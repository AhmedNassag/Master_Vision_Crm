<?php
namespace App\Services;

use App\Models\Point;

class PointAdditionService
{
    public function addPoints($customerId, $activityId, $subActivityId, $amount)
    {

        // Assuming you have a PointsCalculationService to calculate points
        $pointsCalculationService = new PointsCalculationService();
        $pointsSetting = $pointsCalculationService->getPointsSetting($activityId, $subActivityId);

        if (!$pointsSetting) {
            // If not found, try to get general settings
            $pointsSetting = $pointsCalculationService->getGeneralPointsSetting();
        }

        if (!$pointsSetting) {
            return false;
        }
        // Calculate points using the PointsCalculationService
        $calculatedPoints = $pointsCalculationService->calculatePoints($activityId, $subActivityId, $amount);
        // Retrieve PointsSetting based on activity_id and sub_activity_id

        // Assuming you have a logic to determine expiry date (replace with your own logic)
        $expiryDate = now()->addDays($pointsSetting->expiry_days); // Example: points expire in 30 days

        // Create a new Point record
        $point = Point::create([
            'customer_id' => $customerId,
            'activity_id' => $activityId,
            'sub_activity_id' => $subActivityId,
            'points' => $calculatedPoints,
            'expiry_date' => $expiryDate,
        ]);

        return $point;
    }
}
