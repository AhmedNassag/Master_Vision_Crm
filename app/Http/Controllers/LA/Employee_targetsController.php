<?php
/**
 * Controller genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Http\Controllers\LA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Activate;
use Auth;
use DB;
use Validator;
use Yajra\DataTables\Datatables;
use Collective\Html\FormFacade as Form;
use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use App\Models\Employee_target;
use App\Models\Target;

class Employee_targetsController extends Controller
{
	public $show_action = true;
	public $view_col = 'month';
	public $listing_cols = ['id', 'employee_id', 'month', 'target_amount', 'target_meeting'];
	public $month_format='M-Y';
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() >= 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Employee_targets', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Employee_targets', $this->listing_cols);
		}
		$this->middleware('permission:Employee_targets-view|Employee_targets-create|Employee_targets-edit|Employee_targets-delete', ['only' => ['index','show']]);
		$this->middleware('permission:Employee_targets-create', ['only' => ['create','store']]);
		$this->middleware('permission:Employee_targets-edit', ['only' => ['edit','update']]);
		$this->middleware('permission:Employee_targets-delete', ['only' => ['destroy']]);
	}
	
	/**
	 * Display a listing of the Employee_targets.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		
		$module = Module::get('Employee_targets');
		$year_month=[date('Y-m')=>date($this->month_format)];
                $date = Carbon::now();
                for($i=date('n')+1; $i<24;$i++)
                {
                    $date->addMonth();
                    $year_month[$date->format('Y-m')]=$date->format($this->month_format);
                }
                $module->fields['month']['popup_vals']=$year_month;
		$activities = Activate::query()->get(['id','name']);
		if(Module::hasAccess("Employee_targets", "view")) {
			return View('la.employee_targets.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module,
				'activities'=>$activities,
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new employee_target.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created employee_target in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("Employee_targets", "create")) {
			
			$rules = Module::validateRules("Employee_targets", $request);
			$request->validate([
				
				'activity_id.*' => 'required|exists:activates,id',
				'amount_target.*' => 'integer|min:0',
				'calls_target.*' => 'integer|min:0',
				// Add other validation rules as needed
			]);
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			if(empty($request->target_amount) && empty($request->target_meeting))
                            return redirect()->back()->withErrors(['you should enter amount tareget or meetings target']);
                        if($request->employee_id==\Auth()->user()->context_id)
                            return redirect()->back()->withErrors(['you can`t set target to yourself']);
                        if(Employee_target::where("employee_id",$request->employee_id)->where("month",$request->month)->count()>0)
                            return redirect()->back()->withErrors(['this month target for this employee has been entered before']);
			$insert_id = Module::insert("Employee_targets", $request);
			
			//Insert Activity targets
			$activityIds = $request->activity_id;
			$amountTargets = $request->amount_target;
			$callsTargets = $request->calls_target;
			for ($i = 0; $i < count($activityIds); $i++) {
				$activityId = $activityIds[$i];
				$amountTarget = $amountTargets[$i];
				$callsTarget = $callsTargets[$i];
				Target::create([
					'activity_id' => $activityId,
					'amount_target' => $amountTarget,
					'calls_target' => $callsTarget,
					'employee_target_id'=>$insert_id,
					'employee_id'=>$request->employee_id,
				
				]);
			}
			return redirect()->route(config('laraadmin.adminRoute') . '.employee_targets.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified employee_target.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Employee_targets", "view")) {
			
			$employee_target = Employee_target::find($id);
			if(isset($employee_target->id)) {
				$module = Module::get('Employee_targets');
				$date = new Carbon($employee_target->month);
                                $employee_target->month=$date->format($this->month_format);
				$module->row = $employee_target;
				return view('la.employee_targets.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('employee_target', $employee_target);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("employee_target"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified employee_target.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("Employee_targets", "edit")) {
			$employee_target = Employee_target::find($id);
			
		$activities = Activate::query()->get(['id','name']);
			if(isset($employee_target->id)) {	
				$module = Module::get('Employee_targets');
				
				$module->row = $employee_target;
				$year_month=[date('Y-m')=>date($this->month_format)];
                                $date = Carbon::now();
                                for($i=date('n')+1; $i<24;$i++)
                                {
                                    $date->addMonth();
                                    $year_month[$date->format('Y-m')]=$date->format($this->month_format);
                                }
                                $module->fields['month']['popup_vals']=$year_month;
				return view('la.employee_targets.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
					'activities'=>$activities,
				])->with('employee_target', $employee_target);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("employee_target"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified employee_target in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("Employee_targets", "edit")) {
			
			$rules = Module::validateRules("Employee_targets", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			if(empty($request->target_amount) && empty($request->target_meeting))
                            return redirect()->back()->withErrors(['you should enter amount tareget or meetings target']);
                        if($request->employee_id==\Auth()->user()->context_id)
                            return redirect()->back()->withErrors(['you can`t set target to yourself']);
                        if(Employee_target::where("employee_id",$request->employee_id)->where("month",$request->month)->where("id","!=",$id)->count()>0)
                            return redirect()->back()->withErrors(['this month target for this employee has been entered before']);
			$insert_id = Module::updateRow("Employee_targets", $request, $id);
			$employeeTarget = Employee_target::find($id);
			$employeeTarget->targets()->delete();
			//Insert Activity targets
			$activityIds = $request->activity_id;
			$amountTargets = $request->amount_target;
			$callsTargets = $request->calls_target;
			for ($i = 0; $i < count($activityIds); $i++) {
				$activityId = $activityIds[$i];
				$amountTarget = $amountTargets[$i];
				$callsTarget = $callsTargets[$i];
				Target::create([
					'activity_id' => $activityId,
					'amount_target' => $amountTarget,
					'calls_target' => $callsTarget,
					'employee_target_id'=>$insert_id,
					'employee_id'=>$request->employee_id,
				
				]);
			}
			return redirect()->route(config('laraadmin.adminRoute') . '.employee_targets.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified employee_target from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Employee_targets", "delete")) {
			Employee_target::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.employee_targets.index');
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
		$user=\Auth()->user();
                $values = DB::table('employee_targets')->select($this->listing_cols)->whereNull('deleted_at');
		if ($user->roles[0]['view_dept']) {
                    $emps = \App\Models\Employee::where("dept",$user->employee->dept)->pluck('id')->toArray();
			$values->whereIn("employee_id",$emps);
		}
		if ($user->roles[0]['view_data']) {
			$values->where("employee_id",$user->context_id);
		}
                $out = Datatables::of($values->orderBy('id','desc'))->addColumn('action', function ($user) {
			return '';
		})->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Employee_targets');
		for($i=0; $i < count($data->data); $i++) {
                    $show_action=$this->show_action;
                    if($data->data[$i]->employee_id==\Auth()->user()->context_id)
                        $show_action=false;
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				
				if($fields_popup[$col] != null && Str::startsWith($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i]->$col = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i]->$col);
				}
                                if($col=="month")
                                {
                                    $date = new Carbon($data->data[$i]->$col);
                                    $data->data[$i]->$col=$date->format($this->month_format);
                                }
				if($col == $this->view_col) {
					$data->data[$i]->$col = '<a href="'.url(config('laraadmin.adminRoute') . '/employee_targets/'.$data->data[$i]->id).'">'.$data->data[$i]->$col.'</a>';
				}
                                
				// else if($col == "author") {
				//    $data->data[$i]->$col;
				// }
			}
			
			if($show_action) {
				$output = '';
				if(Module::hasAccess("Employee_targets", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/employee_targets/'.$data->data[$i]->id.'/edit').'" class="btn btn-warning btn-xs" style=""><i class="fa fa-edit"></i></a>';
				}
				
				if(Module::hasAccess("Employee_targets", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.employee_targets.destroy', $data->data[$i]->id], 'method' => 'delete', 'style'=>'display:inline']);
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
}
