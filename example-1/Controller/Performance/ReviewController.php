<?php

class ReviewController {

	public function __construct() {
		
	}

	public function init() {
		$this->vars->review = new PerformanceReview();
		$this->vars->review->loadById($db, $_GET['reviewId']);
		$this->checkPermissions();
		$this->vars->reviewPeriod = $review->getReviewPeriod($db);
		$this->vars->questions = $reviewPeriod->getQuestions($db);
		foreach ($questions as $question) {
			$this->vars->scales[$question->id] = $question->getScale($db);
		}
		$this->vars->answers = $review->getAnswers($db);
	}

	public function get() {
		$this->renderTemplate('review.php');
	}

	public function post() {
		//validate?
		foreach ($_POST['questions'] as $questionId => $answerPost) {
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
		redirect("review.php");
	}

}

$controller = new ReviewController();
$controller->dispatch();
