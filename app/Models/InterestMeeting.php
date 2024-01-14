<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterestMeeting extends Model
{
	
	protected $table = 'interest_meeting';
	
	protected $hidden = [
        
    ];

	protected $guarded = [];

	protected $dates = ['deleted_at'];
    public function meeting()
    {
        return $this->belongsTo('App\Models\Meeting','meeting_id');
    }
    public function interest()
    {
        return $this->belongsTo('App\Models\Interest','interest_id');
    }
}
