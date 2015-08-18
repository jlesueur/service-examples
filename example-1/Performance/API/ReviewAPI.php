<?php

class ReviewApi {
	public function __construct() {
		
	}
	
	public function getReview(DB $db, APIRequest $request) {
		$this->vars->review = new PerformanceReview();
		$this->vars->review->loadById($db, $request->get('reviewId'));
		$this->checkPermissions();
		$this->vars->reviewPeriod = $this->vars->review->getReviewPeriod($db);
		$this->vars->questions = $this->vars->reviewPeriod->getQuestions($db);
		foreach ($this->vars->questions as $question) {
			$this->vars->scales[$question->id] = $question->getScale($db);
		}
		$this->vars->answers = $this->vars->review->getAnswers($db);
		echo json_encode($this->vars);
	}
	
	public function updateReview(DB $db, APIRequest $request, APIResponse $response) {
		$this->vars->review = new PerformanceReview();
		$this->vars->review->loadById($db, $request->get('reviewId'));
		//validate?
		foreach ($request->post('questions') as $questionId => $answerPost) {
			$answer = new ReviewAnswer();
			if (!$answer->loadOneWhere($db, 'question_id = ? and review_id = ?', [$questionId, $this->vars->review->id])) {
				$answer->questionId = $questionId;
				$answer->reviewId = $this->vars->review->id;
			}
			$answer->text = $answerPost['text'];
			$answer->scale = $answerPost['scale'];
			$answer->store($db);
		}
		if ($_POST['action'] == 'submit') {
			$this->vars->review->submitted = 'yes';
			$this->vars->review->submittedYmdt = gmdate('Y-m-d H:i:s');
			$this->vars->review->submit($db);
			$updater = new WorkflowUpdater();
			$workflow = new Workflow();
			$workflow->loadOneWhere($db, 'table_row_id = ? and type = ?', [$this->vars->review->id, 'review']);
			$updater->complete($db, $workflow);
		}
		$response->success();
	}
}
