<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointsSetting extends Model
{
    protected $fillable = [
        'activity_id',
        'sub_activity_id',
        'conversion_rate',
        'sales_conversion_rate',
        'points',
        'expiry_days',
    ];

    public function activity()
    {
        return $this->belongsTo(Activate::class);
    }

    public function subActivity()
    {
        return $this->belongsTo(Interest::class,'sub_activity_id');
    }
}
