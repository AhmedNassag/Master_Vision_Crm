<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Interest extends Model
{
    use SoftDeletes;
	
	protected $table = 'interests';
	
	protected $hidden = [
        
    ];

	protected $guarded = [];

	protected $dates = ['deleted_at'];
	public function meetings()
    {
        return $this->belongsToMany('App\Models\Meeting','interest_meeting','interest_id','meeting_id');
    }
}
