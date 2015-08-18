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
	
	public function getReview(APIRequest $request, APIResponse $response) {
		$vars->review = $this->getPerformanceReviewService()->buildPerformanceReview($this->reviewId);
		$vars->questions = $this->getPerformanceReviewService()->buildReviewQuestions($this->reviewId);
		$vars->answers = $this->getPerformanceReviewService()->buildReviewAnswers($this->reviewId);
		echo json_encode($this->vars);
	}
	
	public function updateReview(APIRequest $request, APIResponse $response) {
		$reviewId = $request->get('id');
		try {
			//The API could use a different Request object, as long as it implements the right
			//interface.
			$reviewAnswers = new ReviewAnswersRequest($reviewId, $request->post('questions'));
		} catch (InvalidArgumentException $exception) {
			//invalid data posted.
			$response->errorCode(400);
			$response->errorMessage('You did it wrong!');
			return true;
		}
		$this->getPerformanceReviewService()->answerReviewQuestions($reviewAnswers);
		$response->successCode(200);
		return true;
	}
}

IoC::bind('DB', $db);
$api = IoC::make(ReviewServiceApi::class);
$api->getReview($request, $response);