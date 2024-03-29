<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use SoftDeletes;

	protected $table = 'branches';

	protected $hidden = [

    ];

	protected $guarded = [];

	protected $dates = ['deleted_at'];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
