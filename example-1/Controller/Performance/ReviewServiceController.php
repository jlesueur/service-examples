<?php

class ReviewServiceController {
	/**
	 *
	 * @var PerformanceReviewServiceInterface
	 */
	private $reviewService;
	
	public function __construct(PerformanceReviewServiceInterface $service) {
		$this->setService($service);
	}
	
	public function setService(PerformanceReviewServiceInterface $service) {
		$this->reviewService = $service;
	}
	
	protected function getPerformanceReviewService() {
		return $this->reviewService;
	}

	public function init() {
		$this->reviewId = (int)$_GET['reviewId'];
		$this->checkPermissions();
	}

	public function get() {
		$this->vars->review = $this->getPerformanceReviewService()->buildPerformanceReview($this->reviewId);
		$this->vars->questions = $this->getPerformanceReviewService()->buildReviewQuestions($this->reviewId);
		$this->vars->answers = $this->getPerformanceReviewService()->buildReviewAnswers($this->reviewId);
		$this->renderTemplate('review.php');
	}

	public function post() {
		try {
			$reviewAnswers = new ReviewAnswersRequest($this->reviewId, $_POST['questions']);
		} catch (InvalidArgumentException $exception) {
			//invalid data posted.
			Session::message("I'm sorry, you did it wrong.");
			$this->redirect("review.php?id=" . $this->reviewId);
		}
		$this->getPerformanceReviewService()->answerReviewQuestions($reviewAnswers);
		if ($_POST['action'] == 'submit') {
			$this->getPerformanceReviewService()->submitPerformanceReview($this->reviewId, new DateTime(null, new DateTimeZone('UTC')));
		}
		$this->redirect("review.php?id=" . $this->reviewId);
	}

}

$controller = new ReviewController(new PerformanceReviewService($db));
$controller->dispatch();
