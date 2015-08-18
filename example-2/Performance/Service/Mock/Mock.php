<?php
namespace Performance\Service\Mock;

use DateTime;
use Performance\Service\Contract\PerformanceReviewServiceInterface;
use Performance\Service\ViewModel\PerformanceReviewAnswersInterface;
use Performance\Service\ViewModel\PerformanceReviewInterface;
use Performance\Service\ViewModel\PerformanceReviewQuestionsInterface;

class PerformanceReviewServiceMock implements PerformanceReviewServiceInterface {
	public function __construct() {

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

class PerformanceReviewMock implements PerformanceReviewInterface {
	public function getId() {
		return 9;
	}

}

class PerformanceReviewAnswersMock implements PerformanceReviewAnswersInterface {
	public function getReviewId() {
		return 9;
	}

	public function getScale($questionId) {
		return 1;
	}

	public function getText($questionId) {
		return 'I can do that.';
	}

}

class PerformanceReviewQuestionsMock implements PerformanceReviewQuestionsInterface {
	public function getQuestions() {
		return [
			0 => 'Are you a code monkey?',
			1 => 'Are you a code warrior?'
		];
	}

	public function getScale($questionId) {
		return [
			0 => 'yes',
			1 => 'no'
		];
	}

}