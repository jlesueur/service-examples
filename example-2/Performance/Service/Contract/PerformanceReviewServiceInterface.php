<?php
namespace Performance\Service\Contract;

use DateTime;
use Performance\Service\ViewModel\PerformanceReviewAnswersInterface;
use Performance\Service\ViewModel\PerformanceReviewInterface;
use Performance\Service\ViewModel\PerformanceReviewQuestionsInterface;

Interface PerformanceReviewServiceInterface {

	/**
	 *
	 * @param int $id
	 * @return PerformanceReviewInterface
	 */
	public function buildPerformanceReview($id);

	/**
	 *
	 * @param int $id
	 * @return PerformanceReviewQuestionsInterface
	 */
	public function buildReviewQuestions($id);

	/**
	 *
	 * @param int $id
	 * @return PerformanceReviewAnswersInterface
	 */
	public function buildReviewAnswers($id);

	/**
	 *
	 * @param PerformanceReviewAnswersInterface $answers
	 */
	public function answerReviewQuestions(PerformanceReviewAnswersInterface $answers);

	/**
	 *
	 * @param int $reviewId
	 * @param DateTime $now
	 */
	public function submitPerformanceReview($reviewId, DateTime $now);
}