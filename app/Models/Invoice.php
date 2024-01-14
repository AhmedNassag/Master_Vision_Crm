<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice_number',
        'invoice_date',
        'total_amount',
        'amount_paid',
        'activity_id',
        'debt',
        'customer_id',
        'description',
        'status',
        'interest_id',
        'created_by',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function activity()
    {
        return $this->belongsTo(Activate::class, 'activity_id');
    }
	
	public function interest()
    {
        return $this->belongsTo(Interest::class, 'interest_id');
    }

    public function sub_activity()
    {
        return $this->belongsTo(Interest::class, 'interest_id');

    }
}
