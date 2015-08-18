<?php

namespace Performance\Service;

use DB;
use DateTime;
use Performance\Service\Contract\PerformanceReviewServiceInterface;
use Performance\Service\Mock\PerformanceReviewAnswersMock;
use Performance\Service\Mock\PerformanceReviewMock;
use Performance\Service\Mock\PerformanceReviewQuestionsMock;
use Performance\Service\ViewModel\PerformanceReviewAnswersInterface;
use Performance\Service\ViewModel\PerformanceReviewInterface;
use Performance\Service\ViewModel\PerformanceReviewQuestionsInterface;

class PerformanceReviewService implements PerformanceReviewServiceInterface {
	public function __construct(DB $db) {

	}

	public function answerReviewQuestions(PerformanceReviewAnswersInterface $answers) {
		return true;
	}

	public function buildPerformanceReview($id) {
		return new PerformanceReviewMock();
	}

	public function buildReviewAnswers($id) {
		return new PerformanceReviewAnswersMock();
	}

	public function buildReviewQuestions($id) {
		return new PerformanceReviewQuestionsMock();
	}

	public function submitPerformanceReview($reviewId, DateTime $now) {
		return true;
	}

}

class PerformanceReview implements PerformanceReviewInterface {
	public function __construct($id) {
		$this->id = $id;
	}
	public function getId() {
		return $this->id;
	}

}

class PerformanceReviewAnswers implements PerformanceReviewAnswersInterface {
	public function __construct($reviewId, $answers) {
		$this->reviewId = $reviewId;
		//validate answers, scale should be int, text should be less than 8192 chars, etc.
		//This is BL validation, not form validation. It looks for required fields,
		$this->answers = $answers;
	}

	public function getReviewId() {
		return $this->reviewId;
	}

	public function getScale($questionId) {
		return $this->answers[$questionId]['scale'];
	}

	public function getText($questionId) {
		return $this->answers[$questionId]['text'];
	}

}

class PerformanceReviewQuestions implements PerformanceReviewQuestionsInterface {
	public function __construct($questions, $scales) {
		$this->questions = $questions;
		$this->scales = $scales;
	}

	/**
	 *
	 * @return string[]
	 */
	public function getQuestions() {
		return $this->questions;
	}

	public function getScale($questionId) {
		return $this->questions[$questionId];
	}
}