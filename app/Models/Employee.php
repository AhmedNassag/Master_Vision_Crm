<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

	protected $table = 'employees';

	protected $hidden = [

    ];

	protected $guarded = [];

	protected $dates = ['deleted_at'];
    public function contacts()
    {
        return $this->hasMany('App\Models\Contact','created_by');
    }
    public function meetings()
    {
        return $this->hasMany('App\Models\Meeting','created_by');
    }

    public function invoices()
    {
        return $this->hasMany('App\Models\Invoice','created_by');
    }

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');

    }

     public static function all($not_current=0) {
		if (debug_backtrace()[1]['function'] === 'getDDArray')
		{
                    $user=\Auth()->user();
                    $emps=[];
                    if($user->roles[0]->view_dept)
                        $emps = \App\Models\Employee::where("dept",$user->employee->dept)->pluck('id')->toArray();
                    if($user->roles[0]->view_data)
                        $emps = [$user->context_id];
                    if(count($emps)>0 && $not_current)
                        unset($emps[$user->context_id]);
                    if(count($emps)>0)
			return parent::whereIn("id",$emps)->where("id","!=",1)->get();
                    return parent::where("id","!=",1)->get();
		}
		else
			return parent::where("id","!=",1)->get();
	}
}
