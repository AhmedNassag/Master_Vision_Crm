<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meeting_note extends Model
{
    use SoftDeletes;
	
	protected $table = 'meeting_notes';
	
	protected $hidden = [
        
    ];

	protected $guarded = [];

	protected $dates = ['deleted_at'];

	public function meeting()
    {
        return $this->belongsTo('App\Models\Meeting','meeting_id');
	}
	public function creator()
    {
        return $this->belongsTo('App\Models\Employee','created_by');
    }
}
