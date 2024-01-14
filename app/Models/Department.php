<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;
	
	protected $table = 'departments';
	
	protected $hidden = [
        
    ];

	protected $guarded = [];

	protected $dates = ['deleted_at'];
        
        public static function all($columns=[]) {
		if (debug_backtrace()[1]['function'] === 'getDDArray')
		{
			$return =parent::get();
			if (\Auth()->user()->roles[0]['view_dept']) {
                            $return = parent::where("id",\Auth()->user()->employee->dept)->get();
                        }
                    return $return;
		}
		else
			return parent::all();
	}
}
