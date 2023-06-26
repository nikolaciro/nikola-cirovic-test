<?php

namespace App\Service;

use App\Models\Franchise;
use DateTime;

class FranchiseService
{
    private const SCORE = 1000;
    private const MAX_REVIEWS_TOTAL = 20;
    private const MAX_REVIEWS_MONTHLY = 5;

    public function calculateScore(Franchise $franchise): int
    {
        $score = self::SCORE;
        $ratingScore = min($score * $franchise->rating / 5, $score);
        $reviewsScore = min($score * $franchise->reviews / self::MAX_REVIEWS_TOTAL, $score);
        $monthlyReviewsScore = min($score * $franchise->getReviewsPerMonthAttribute() / self::MAX_REVIEWS_MONTHLY, $score);

        return ($ratingScore + $reviewsScore + $monthlyReviewsScore) / 3;
    }

    public function calculateLastMonthReviews(array $reviews): int
    {
        $currentDate = new DateTime();

        $previousMonthDate = clone $currentDate;
        $previousMonthDate->modify('-1 month');

        $reviewCountLastMonth = 0;
        foreach ($reviews as $review) {
            $publishedAtDate = new DateTime($review['publishedAtDate']);
            if ($publishedAtDate < $previousMonthDate) {
                break;
            }
            $reviewCountLastMonth++;
        }

        return $reviewCountLastMonth;
    }
}
