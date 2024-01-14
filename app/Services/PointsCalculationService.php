<?php

namespace App\Services;

use App\Models\PointsSetting;
use App\Models\Point;
class PointsCalculationService
{
    public function calculatePoints($activityId, $subActivityId, $amount)
    {
        // Retrieve PointsSetting based on activity_id and sub_activity_id
        $pointsSetting = $this->getPointsSetting($activityId, $subActivityId);

        if (!$pointsSetting) {
            // If not found, try to get general settings
            $pointsSetting = $this->getGeneralPointsSetting();

            if (!$pointsSetting) {
                // Handle the case when PointsSetting is still not found
                return 0;
            }
        }

        // Calculate points based on the conversion_rate and amount
        $points = $amount * $pointsSetting->conversion_rate;

        // Adjust points based on sales_conversion_rate if available
        // if ($pointsSetting->sales_conversion_rate) {
        //     $points *= $pointsSetting->sales_conversion_rate;
        // }

        return $points;
    }

    public function getPointsSetting($activityId, $subActivityId)
    {
        $query = PointsSetting::query();

        // Build the query based on the provided parameters
        if ($activityId !== null) {
            $query->orWhere('activity_id', $activityId);
        }

        if ($subActivityId !== null) {
            $query->orWhere('sub_activity_id', $subActivityId);
        }

        $setting = $query->first();

        if (!$setting && $activityId !== null) {
            $setting = PointsSetting::where('activity_id', $activityId)->first();
        }

        if (!$setting && $subActivityId !== null) {
            $setting = PointsSetting::where('sub_activity_id', $subActivityId)->first();
        }

        return $setting;
    }

    public function getGeneralPointsSetting()
    {
        // Retrieve general settings when both activity_id and sub_activity_id are null
        return PointsSetting::whereNull('activity_id')
            ->whereNull('sub_activity_id')
            ->first();
    }


    public function getPointsValue($customer_id)
    {
        $points = Point::where('customer_id',$customer_id)->get();
        $value = 0;
        foreach($points as $point)
        {
            $pointsSetting = $this->getPointsSetting($point->activity_id, $point->sub_activity_id);

            if (!$pointsSetting) {
                // If not found, try to get general settings
                $pointsSetting = $this->getGeneralPointsSetting();
            }
            if($pointsSetting)
            {
                $pointsCount = $point->points;
                $valuePerOnePoint = $pointsSetting->sales_conversion_rate/$pointsSetting->points;
                $value += $pointsCount*$valuePerOnePoint;
            }
        }
        return $value;
    }
}
