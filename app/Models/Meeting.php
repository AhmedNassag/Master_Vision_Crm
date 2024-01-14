<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meeting extends Model
{
    use SoftDeletes;
	
	protected $table = 'meetings';
	
	protected $hidden = [
        
    ];

	protected $guarded = [];

	protected $dates = ['deleted_at'];
	public function notes()
    {
        return $this->hasMany('App\Models\Meeting_note','meeting_id');
	}
	public function creator()
    {
        return $this->belongsTo('App\Models\Employee','created_by');
    }
    public function contact()
    {
        return $this->belongsTo('App\Models\Contact','contact_id');
    }
    public function interests()
    {
        return $this->belongsToMany('App\Models\Interest','interest_meeting','meeting_id','interest_id');
    }

    
    public function reply()
    {
        return $this->belongsTo(Saved_Reply::class, 'reply_id');
    }

}
