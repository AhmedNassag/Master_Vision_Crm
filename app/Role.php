<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App;

//use Zizaco\Entrust\EntrustRole;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Role extends Model //EntrustRole
{
    use SoftDeletes;
	
	protected $table = 'roles';
	
	protected $hidden = [
        
    ];



	public function children (){
		return $this->hasMany(Role::class,'parent');
	}




	public function getAllChildRoles($parentRoleId)
    {
        // Retrieve the parent role and its descendants recursively
        $parentRole = Role::find($parentRoleId);

        if ($parentRole) {
            // Use a recursive function to get all descendants
            $roles = $this->getAllDescendants($parentRole);

            // Flatten the array to get a one-level array of all child roles
            $flattenedRoles = collect($roles)->flatten();

            return $flattenedRoles->unique()->all();
        }

        return null;
    }

    protected function getAllDescendants($role)
    {
        $descendants = [];

        // Get direct children of the current role
        $children = $role->children;

        // Recursively get descendants for each child
        foreach ($children as $child) {
            $descendants[] = $child;
            $descendants = array_merge($descendants, $this->getAllDescendants($child));
        }

        return $descendants;
    }


	// protected static function boot()
    // {
    //     parent::boot();


    //     static::booted(function () {
    //         // Check if the authenticated user has a role with parent equal to 0
    //         $user = auth()->user();

    //         if ($user && $user->roles[0]->parent == 0) {
    //             // Return all roles
    //             static::addGlobalScope('parentEqualsZero', function ($builder) {
    //                 $builder->where('parent', 0);
    //             });
    //         } else {
    //             // Return roles where parent is not equal to 0
    //             static::addGlobalScope('parentNotEqualsZero', function ($builder) {
    //                 $builder->where('parent', '<>', 0);
    //             });
    //         }
    //     });
    // }



	

	protected $guarded = [];

	protected $dates = ['deleted_at'];
}
