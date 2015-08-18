<?php
namespace Performance\Service\ViewModel;

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

