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
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use App\Models\Notification;
use App\Models\ReorderReminder;
class NotificationsController extends Controller
{
	public $show_action = true;
	public $view_col = 'notification';
	public $listing_cols = ['id', 'dept', 'employee_id', 'notification', 'created_by'];

	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() >= 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Notifications', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Notifications', $this->listing_cols);
		}
		$this->middleware('permission:Notifications-view|Notifications-create|Notifications-edit|Notifications-delete', ['only' => ['index','show']]);
		$this->middleware('permission:Notifications-create', ['only' => ['create','store']]);
		$this->middleware('permission:Notifications-edit', ['only' => ['edit','update']]);
		$this->middleware('permission:Notifications-delete', ['only' => ['destroy']]);
	}

	/**
	 * Display a listing of the Notifications.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Notifications');

		if(Module::hasAccess("Notifications", "view")) {
			return View('la.notifications.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

    public function getTodayReminders()
    {
        $reminders = ReorderReminder::whereDate('reminder_date',Carbon::today())->get();
        $title = 'تذكيرات اليوم';

        return view('la.notifications.reminders',['reminders'=>$reminders,"title"=> $title]);
    }
    public function getMonthReminders()
    {
        $reminders = ReorderReminder::whereYear('reminder_date', Carbon::now()->year)
        ->whereMonth('reminder_date', Carbon::now()->month)->get();
        $title = 'تذكيرات الشهر';
        return view('la.notifications.reminders',['reminders'=>$reminders,"title"=> $title]);
    }

	/**
	 * Show the form for creating a new notification.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created notification in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("Notifications", "create")) {

			$rules = Module::validateRules("Notifications", $request);

			$validator = Validator::make($request->all(), $rules);

			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			$request->created_by=\Auth()->user()->context_id;
			$insert_id = Module::insert("Notifications", $request);

			return redirect()->route(config('laraadmin.adminRoute') . '.notifications.index');

		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified notification.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Notifications", "view")) {

			$notification = Notification::find($id);
			if(isset($notification->id)) {
				$module = Module::get('Notifications');
				$module->row = $notification;

				return view('la.notifications.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('notification', $notification);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("notification"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified notification.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("Notifications", "edit")) {
			$notification = Notification::find($id);
			if(isset($notification->id)) {
				$module = Module::get('Notifications');

				$module->row = $notification;

				return view('la.notifications.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('notification', $notification);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("notification"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified notification in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("Notifications", "edit")) {

			$rules = Module::validateRules("Notifications", $request, true);

			$validator = Validator::make($request->all(), $rules);

			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}

			$insert_id = Module::updateRow("Notifications", $request, $id);

			return redirect()->route(config('laraadmin.adminRoute') . '.notifications.index');

		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified notification from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Notifications", "delete")) {
			Notification::find($id)->delete();

			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.notifications.index');
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
		$values = DB::table('notifications')->select($this->listing_cols)->whereNull('deleted_at');
		$out = Datatables::of($values->orderBy('id','desc'))->addColumn('action', function ($user) {
			return '';
		})->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Notifications');

		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) {
				$col = $this->listing_cols[$j];

				if($fields_popup[$col] != null && Str::startsWith($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i]->$col = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i]->$col);
				}
				if($col == $this->view_col) {
					$data->data[$i]->$col = '<a href="'.url(config('laraadmin.adminRoute') . '/notifications/'.$data->data[$i]->id).'">'.$data->data[$i]->$col.'</a>';
				}

				/*if(($col == "dept" || $col=="employee_id") && $data->data[$i]->$col==0) {
				   $data->data[$i]->$col='';
				}*/
			}

			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("Notifications", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/notifications/'.$data->data[$i]->id.'/edit').'" class="btn btn-warning btn-xs" style=""><i class="fa fa-edit"></i></a>';
				}

				if(Module::hasAccess("Notifications", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.notifications.destroy', $data->data[$i]->id], 'method' => 'delete', 'style'=>'display:inline']);
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
