<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReorderReminder extends Model
{
    use HasFactory;
    protected $table = 'reorder_reminders';

    protected $fillable = [
        'customer_id',
        'invoice_id',
        'reminder_date',
        'is_completed',
        "interest_id",
        "activity_id",
        "expected_amount",
    ];

    protected $dates = ['reminder_date'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

     public function activity()
    {
        return $this->belongsTo(Activate::class, 'activity_id');
    }

     public function interest()
    {
        return $this->belongsTo(Activate::class, 'interest_id');
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
}
