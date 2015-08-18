<?php

use Performance\Service\Contract\PerformanceReviewServiceInterface;
use Performance\Service\Mock\PerformanceReviewServiceMock;
use Performance\Service\Request\PerformanceReviewAnswersRequest;

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
		//do form validation, what does that mean?
		try {
			//This line is perhaps the one I'm least confident in.
			//We need this object. I'm not sure exactly the best way to build it, and how
			//much validation happens when you build it. In the end, it just needs to
			//implement the right interface for the operation we're performing later.
			$reviewAnswers = new PerformanceReviewAnswersRequest($this->reviewId, $_POST['questions']);
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

$controller = new ReviewController(new PerformanceReviewServiceMock());
$controller->dispatch();
