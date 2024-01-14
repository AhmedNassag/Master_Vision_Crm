<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_id',
        'action',
        'related_model_id',
        'placeholders',
        'created_by',
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getPlaceholdersArrayAttribute()
    {
        return json_decode($this->placeholders,true);
    }
}
