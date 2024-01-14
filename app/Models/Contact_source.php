<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact_source extends Model
{
    use SoftDeletes;
	
	protected $table = 'contact_sources';
	
	protected $hidden = [
        
    ];

	protected $guarded = [];

	protected $dates = ['deleted_at'];
    public function contacts()
    {
        return $this->hasMany('App\Models\Contact','contact_source_id');
    }
}
