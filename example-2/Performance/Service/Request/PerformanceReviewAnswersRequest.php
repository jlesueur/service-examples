<?php

namespace Performance\Service\Request;

use Performance\Service\ViewModel\PerformanceReviewAnswersInterface;

/**
 * I think I'm least sure about what this one looks like. These are constructed
 * in the consumer from user data. Since user data is different for every consumer,
 * maybe it is the consumers job to provide implementations. 
 */
class PerformanceReviewAnswersRequest implements PerformanceReviewAnswersInterface {
	public function __construct($reviewId, $answers) {
		//validate that you have the right data to build this request, since
		//$answers is just an array, you probably need to check the contents.
		$this->reviewId = $reviewId;
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