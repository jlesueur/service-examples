<?php

class ReviewServiceApi {
	public function __construct(PerformanceReviewServiceInterface $service) {
		$this->setPerformanceReviewService($service);
	}
	
	protected function getPerformanceReviewService(DB $db) {
		if (!isset($this->service)) {
			$this->service = new PerformanceReviewService($db);
		}
		return $this->service;
	}
	
	public function setPerformanceReviewService(PerformanceReviewServiceInterface $service) {
		$this->service = $service;
	}
	
	public function getReview(DB $db, APIRequest $request) {
		$this->vars->review = $this->getPerformanceReviewService()->buildPerformanceReview($this->reviewId);
		$this->vars->questions = $this->getPerformanceReviewService()->buildReviewQuestions($this->reviewId);
		$this->vars->answers = $this->getPerformanceReviewService()->buildReviewAnswers($this->reviewId);
		echo json_encode($this->vars);
	}
	
	public function updateReview(DB $db, APIRequest $request, APIResponse $response) {
		$reviewId = $request->get('id');
		try {
			$reviewAnswers = new ReviewAnswersRequest($reviewId, $request->post('questions'));
		} catch (InvalidArgumentException $exception) {
			//invalid data posted.
			Session::message("I'm sorry, you did it wrong.");
			$this->redirect("review.php?id=" . $reviewId);
		}
		$this->getPerformanceReviewService()->answerReviewQuestions($reviewAnswers);
		if ($_POST['action'] == 'submit') {
			$this->getPerformanceReviewService()->submitPerformanceReview($reviewId, new DateTime(null, new DateTimeZone('UTC')));
		}
		$this->redirect("review.php?id=" . $reviewId);
	}
}

IoC::bind('DB', $db);
$api = IoC::make(ReviewServiceApi::class);
$api->getReview($db, $request);