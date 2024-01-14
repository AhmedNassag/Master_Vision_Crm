<?php
/**
 * Controller genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Http\Controllers\LA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use DB;
use Validator;
use Yajra\DataTables\Datatables;
use Collective\Html\FormFacade as Form;
use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;
use Dwij\Laraadmin\Helpers\LAHelper;
//use Zizaco\Entrust\EntrustFacade as Entrust;
use Illuminate\Support\Str;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsController extends Controller
{
	public $show_action = true;
	public $view_col = 'name';
	public $listing_cols = ['id', 'name'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() >= 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Permissions', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Permissions', $this->listing_cols);
		}
		$this->middleware('permission:Permissions-view|Permissions-create|Permissions-edit|Permissions-delete', ['only' => ['index','show']]);
		$this->middleware('permission:Permissions-create', ['only' => ['create','store']]);
		$this->middleware('permission:Permissions-edit', ['only' => ['edit','update']]);
		$this->middleware('permission:Permissions-delete', ['only' => ['destroy']]);
	}
	
	/**
	 * Display a listing of the Permissions.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Permissions');
		if(auth()->user()->can('Permissions-view')) {
			return View('la.permissions.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
        	return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new permission.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created permission in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(auth()->user()->can('Permissions-create')) {
		
			$rules = Module::validateRules("Permissions", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("Permissions", $request);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.permissions.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified permission.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(auth()->user()->can('Permissions-list')) {
			
			$permission = Permission::find($id);
			if(isset($permission->id)) {
				$module = Module::get('Permissions');
				$module->row = $permission;
				$roles = Role::all();
				
				return view('la.permissions.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding",
					'roles' => $roles,
					'permission_roles'=>$permission->roles->pluck('id')->toArray()
				])->with('permission', $permission);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("permission"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified permission.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(auth()->user()->can('Permissions-edit')) {
			$permission = Permission::find($id);
			if(isset($permission->id)) {
				$module = Module::get('Permissions');				
				$module->row = $permission;
				
				return view('la.permissions.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('permission', $permission);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("permission"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified permission in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(auth()->user()->can('Permissions-edit')) {
			
			$rules = Module::validateRules("Permissions", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("Permissions", $request, $id);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.permissions.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified permission from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(auth()->user()->can('Permissions-delete')) {
			Permission::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.permissions.index');
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	
	/**
	 * Datatable Ajax fetch
	 *
	 * @return
	 */
	public function dtajax()
	{
		$values = DB::table('permissions')->select($this->listing_cols)->whereNull('deleted_at');
		$out = Datatables::of($values->orderBy('id','desc'))->addColumn('action', function ($user) {
			return '';
		})->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Permissions');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && Str::startsWith($fields_popup[$col]->popup_vals, "@")) {
					$data->data->$col = ModuleFields::getFieldValue($fields_popup[$col], $data->data->$col);
				}
				if($col == $this->view_col) {
					$data->data[$i]->$col = '<a href="'.url(config('laraadmin.adminRoute') . '/permissions/'.$data->data[$i]->id).'">'.$data->data[$i]->$col.'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(auth()->user()->can('Permissions-edit')) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/permissions/'.$data->data[$i]->id.'/edit').'" class="btn btn-warning btn-xs" style=""><i class="fa fa-edit"></i></a>';
				}
				
				if(auth()->user()->can('Permissions-delete')) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.permissions.destroy', $data->data[$i]->id], 'method' => 'delete', 'style'=>'display:inline']);
					$output .= ' <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-times"></i></button>';
					$output .= Form::close();
				}
				$data->data[$i]->action = (string)$output;
			}
		$data->data[$i]->id = $i+1;
                }
		$out->setData($data);
		return $out;
	}
	
	/**
	 * Save the  permissions for role in permission view.
	 *
	 * @param  int  $id
	 * @return Redirect to permisssions page
	 */
	public function save_permissions(Request $request, $id)
	{
		if(auth()->user()->hasRole('SUPER_ADMIN')) {
			$permission = Permission::find($id);
			$module = Module::get('Permissions');
			$module->row = $permission;
			$permission_roles=$permission->roles->pluck('id')->toArray();
			$roles = Role::all();
			
			foreach ($roles as $role) {
				$permi_role_id = 'permi_role_'.$role->id;
				$permission_set = $request->$permi_role_id;
				if(isset($permission_set)) {
					if(!in_array($role->id,$permission_roles))
						$role->givePermissionTo($permission->name);
				} else {
					if(in_array($role->id,$permission_roles))
						$role->revokePermissionTo($permission->name);
				}
			}
			return redirect(config('laraadmin.adminRoute') . '/permissions/'.$id."#tab-access");
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
}
