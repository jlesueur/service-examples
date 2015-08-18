<?php

Interface PerformanceReviewServiceInterface {

	/**
	 * 
	 * @param type $id
	 * @return PerformanceReviewInterface
	 */
	public function buildPerformanceReview($id);
	
	/**
	 * 
	 * @param type $id
	 * @return PerformanceReviewQuestionsInterface
	 */
	public function buildReviewQuestions($id);
	
	/**
	 * 
	 * @param type $id
	 * @return PerformanceReviewAnswersInterface
	 */
	public function buildReviewAnswers($id);

	/**
	 * could the first item be just an id? maybe. But if we send the whole 
	 * 
	 * @param int $reviewId
	 * @param PerformanceReviewAnswersInterface $answers
	 */
	public function answerReviewQuestions(PerformanceReviewAnswersInterface $answers);

	public function submitPerformanceReview($reviewId, DateTime $now);
}

Interface PerformanceReviewInterface {

	/**
	 * @return int
	 */
	public function getId();
}

Interface PerformanceReviewQuestionsInterface {
	/**
	 * @return string[]
	 */
	public function getQuestions();
	
	/**
	 * @return array
	 */
	public function getScale($questionId);
}

Interface PerformanceReviewAnswersInterface {
	public function getReviewId();
	
	/**
	 * @param int $questionId
	 * @return string
	 */
	public function getText($questionId);
	
	/**
	 * @param int $questionId
	 * @return int
	 */
	public function getScale($questionId);
}

class PerformanceReviewService implements PerformanceReviewServiceInterface {
	public function __construct(DB $db) {
		
	}

	public function answerReviewQuestions(\PerformanceReviewAnswersInterface $answers) {
		return true;
	}

	public function buildPerformanceReview($id) {
		
	}

	public function buildReviewAnswers($id) {
		
	}

	public function buildReviewQuestions($id) {
		
	}

	public function submitPerformanceReview($reviewId, \DateTime $now) {
		
	}

}

class PerformanceReviewAnswers implements PerformanceReviewAnswersInterface {
	public function __construct($reviewId, $questions) {
		
	}

	public function getReviewId() {
		
	}

	public function getScale($questionId) {
		
	}

	public function getText($questionId) {
		
	}

}