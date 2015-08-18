<?php
namespace Performance\Service\ViewModel;

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