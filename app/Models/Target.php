<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_id',
        'amount_target',
        'calls_target',
        'employee_target_id',
        'employee_id',
        'interest_id'
    ];

    // Define the relationship between Target and Activity
    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }
    public function sub_activity()
    {
        return $this->belongsTo(Interest::class, 'interest_id');
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function employeeTarget()
    {
        return $this->belongsTo(Employee_target::class, 'employee_target_id');
    }
}
