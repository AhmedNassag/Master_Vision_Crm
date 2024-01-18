<?php
/**
 * Controller genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Http\Controllers\LA;
use Illuminate\Support\Str;

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

use App\Models\User;
use App\Models\Employee;
use App\Models\Meeting;
use App\Models\Employee_target;
use App\Models\Invoice;
use Mail;
use Log;
use Spatie\Permission\Models\Role;
use Hash;
use Illuminate\Support\Arr;
use Dwij\Laraadmin\Models\LAConfigs;

class EmployeesController extends Controller
{
	public $show_action = true;
	public $view_col = 'name';
	public $listing_cols = ['id', 'name', 'mobile', 'email', 'dept', 'active','has_branch_access'];

	public function __construct() {

		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() >= 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Employees', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Employees', $this->listing_cols);
		}
		$this->middleware('permission:Employees-view|Employees-create|Employees-edit|Employees-delete', ['only' => ['index','show']]);
		$this->middleware('permission:Employees-create', ['only' => ['create','store']]);
		$this->middleware('permission:Employees-edit', ['only' => ['edit','update']]);
		$this->middleware('permission:Employees-delete', ['only' => ['destroy']]);
	}

	/**
	 * Display a listing of the Employees.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Employees');
		if(Module::hasAccess($module->id)) {
			return View('la.employees.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module,
				'roles' => Role::pluck('name','name')->all(),
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new employee.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

    public function ajaxEmployeesSelect(Request $request)
    {
        $employees = Employee::where("branch_id",$request->branch_id)->get();
        $employees->each(function ($employee) {
           $employee->name = $employee->name." <b>( ".(($employee->has_branch_access)?"مدير فرع":"موظف")." )</b>";
        });
        return response()->json($employees);
    }

	/**
	 * Store a newly created employee in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("Employees", "create")) {

			$rules = Module::validateRules("Employees", $request);

			$validator = Validator::make($request->all(), $rules);

			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			$max_users=LAConfigs::getByKey("max_users");
                        if(Employee::where("active",1)->where("id","!=",1)->count()>=$max_users)
                            return redirect()->back()->withErrors(["you have reached your maximum number of users ($max_users)"]);
			// generate password
			$password=$request->password;

			// Create Employee
			$employee_id = Module::insert("Employees", $request);
			$emp=Employee::find($employee_id);
			// Create User
			$user = User::create([
				'name' => $request->name,
				'email' => $request->email,
				'password' => bcrypt($password),
				'context_id' => $employee_id,
				'type' => "Employee",
				'active'=>$emp->active
			]);

			// update user role
                        $role = Role::find($request->role);
			$user->assignRole([$role->name]);
			//$user->assignRole($request->input('roles'));
			/*$user->detachRoles();
			$role = Role::find($request->role);
			$user->attachRole($role);
			*/
			if(env('MAIL_USERNAME') != null && env('MAIL_USERNAME') != "null" && env('MAIL_USERNAME') != "") {
				// Send mail to User his Password
				/*Mail::send('emails.send_login_cred', ['user' => $user, 'password' => $password], function ($m) use ($user) {
					$m->from('hello@laraadmin.com', 'LaraAdmin');
					$m->to($user->email, $user->name)->subject('LaraAdmin - Your Login Credentials');
				});*/
			} else {
				Log::info("User created: username: ".$user->email." Password: ".$password);
			}

			return redirect()->route(config('laraadmin.adminRoute') . '.employees.index');

		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified employee.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Employees", "view")) {

			$employee = Employee::find($id);
                        $user=\Auth()->user();
                        if($user->roles[0]['view_data'] && $employee->id !=$user->context_id)
                        {
                            return view('errors.404', [
                                    'record_id' => $id,
                                    'record_name' => ucfirst("employee"),
                            ]);
                        }
			if(isset($employee->id)) {
				$module = Module::get('Employees');
				$module->row = $employee;

				// Get User Table Information
				$user = User::where('context_id', '=', $id)->firstOrFail();

				return view('la.employees.show', [
					'user' => $user,
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('employee', $employee);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("employee"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified employee.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("Employees", "edit")) {

			$employee = Employee::find($id);
                        $user=\Auth()->user();
                        if($user->roles[0]['view_data'] && $employee->id !=$user->context_id)
                        {
                            return view('errors.404', [
                                    'record_id' => $id,
                                    'record_name' => ucfirst("employee"),
                            ]);
                        }
			if(isset($employee->id)) {
				$module = Module::get('Employees');

				$module->row = $employee;

				// Get User Table Information
				$user = User::where('context_id', '=', $id)->firstOrFail();

				return view('la.employees.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
					'user' => $user,
				])->with('employee', $employee);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("employee"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified employee in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("Employees", "edit")) {

			$rules = Module::validateRules("Employees", $request, true);

			$validator = Validator::make($request->all(), $rules);
			$emp=Employee::find($id);
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
                        if($emp->active==0 && !empty($request->active))
                        {
                            $max_users=LAConfigs::getByKey("max_users");
                            if(Employee::where("active",1)->where("id","!=",1)->count()>=$max_users)
                                return redirect()->back()->withErrors(["you have reached your maximum number of users ($max_users)"]);
                        }
			//$password=$request->password;
            //if(!empty($password))
		//		$request->password=bcrypt($password);

			$employee_id = Module::updateRow("Employees", $request, $id);
                        $emp=Employee::find($id);

			// Update User
			$user = User::where("type","Employee")->where('context_id', $employee_id)->first();
			$user->name = $emp->name;
			$user->email = $emp->email;
			$user->active = $emp->active;
			//if(!empty($password))
			//	$user->password=bcrypt($password);
			$user->save();

			// update user role
			//$user->detachRoles();
			$role = Role::find($request->role);
			$user->syncRoles([$role->name]);

			return redirect()->route(config('laraadmin.adminRoute') . '.employees.index');

		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified employee from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Employees", "delete")) {
                    if($message=$this->checkAvailabilityToDelete($id,array("Contact"=>array("contacts","created_by"),"Meeting"=>array("meetings","created_by"),"Employee_target"=>array("targets","employee_id"),"Notification"=>array("notifications assigned","employee_id","notifications created by him","created_by"))))
                    {

                            return  redirect()->back()->withErrors(['msg'=>[$message]]);
                    }
                        Employee::find($id)->delete();
			User::where("context_id",$id)->delete();
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.employees.index');
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
		$values = DB::table('employees')->select($this->listing_cols)->whereNull('deleted_at')->where("id","!=",1);
		
		if (\Auth()->user()->roles[0]['view_dept']) {
			$values->where("dept",\Auth()->user()->employee->dept);
		}
		if (\Auth()->user()->roles[0]['view_data']) {
			$values->where("id",\Auth()->user()->context_id);
		}
		$out = Datatables::of($values->orderBy('id','desc'))->addColumn('action', function ($user) {
			return '';
		})->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Employees');
		$currency = LAConfigs::getByKey('currency_symbol');
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) {
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && Str::startsWith($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i]->$col = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i]->$col);
				}
				if($col == $this->view_col) {
					$data->data[$i]->$col = '<a href="'.url(config('laraadmin.adminRoute') . '/employees/'.$data->data[$i]->id).'">'.$data->data[$i]->$col.'</a>';
				}
				else if($col == "active") {
				    $data->data[$i]->$col=!empty($data->data[$i]->$col)?trans('admin.Yes'):trans('admin.No');
				}else if($col == "has_branch_access")
                {
                    $data->data[$i]->$col=!empty($data->data[$i]->$col)?trans('admin.Yes'):trans('admin.No');
                }
			}

			$target_output='';
			if(Module::hasAccess("Employee_targets", "view"))
			{
				$target= Employee_target::where("employee_id",$data->data[$i]->id)->where("month",date("M-Y"))->first();
				
				if(!empty($target->target_amount))
				{
					$did_amount=Invoice::where('created_by',$data->data[$i]->id)->sum("total_amount");
					$target_output .=$did_amount. " / ".$target->target_amount." ".$currency ." (".floor($did_amount/$target->target_amount*100)."%)<br>";
				}
				if(!empty($target->target_amount))
				{
					$did_meetings=Meeting::where("created_by",$data->data[$i]->id)->count();
					$target_output .=$did_meetings. " / ".$target->target_meeting." Calls / Meetings (".floor($did_meetings/$target->target_meeting*100)."%)";
				}
			}
			$data->data[$i]->target=$target_output;
			
			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("Employees", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/employees/'.$data->data[$i]->id.'/edit').'" class="btn btn-warning btn-xs" style=""><i class="fa fa-edit"></i></a>';
				}
				
				if(Module::hasAccess("Employees", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.employees.destroy', $data->data[$i]->id], 'method' => 'delete', 'style'=>'display:inline']);
					$output .= ' <button class="btn btn-danger deleteFormBtn btn-xs" type="submit"><i class="fa fa-times"></i></button>';
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
     * Change Employee Password
     *
     * @return
     */
	public function change_password($id, Request $request) {

		$validator = Validator::make($request->all(), [
            'password' => 'required|min:6',
			'password_confirmation' => 'required|min:6|same:password'
        ]);

		if ($validator->fails()) {
			return \Redirect::to(config('laraadmin.adminRoute') . '/employees/'.$id)->withErrors($validator);
		}

		$employee = Employee::find($id);
		$user = User::where("context_id", $employee->id)->where('type', 'Employee')->first();
		$user->password = bcrypt($request->password);
		$user->save();

		\Session::flash('success_message', 'Password is successfully changed');

		// Send mail to User his new Password
		if(env('MAIL_USERNAME') != null && env('MAIL_USERNAME') != "null" && env('MAIL_USERNAME') != "") {
			// Send mail to User his new Password
			/*Mail::send('emails.send_login_cred_change', ['user' => $user, 'password' => $request->password], function ($m) use ($user) {
				$m->from(LAConfigs::getByKey('default_email'), LAConfigs::getByKey('sitename_en'));
				$m->to($user->email, $user->name)->subject('LaraAdmin - Login Credentials chnaged');
			});*/
		} else {
			Log::info("User change_password: username: ".$user->email." Password: ".$request->password);
		}

		return redirect(config('laraadmin.adminRoute') . '/employees/'.$id.'#tab-account-settings');
	}
        public function get_employees_by_dept($dept)
        {
            if(!empty($dept))
                return Employee::where("dept",$dept)->pluck('name','id')->toArray();
            return Employee::pluck('name','id')->toArray();
        }
}
