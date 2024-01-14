<?php
/**
 * Controller genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Http\Controllers\LA;

use App\DTOs\LeadHistoryData;
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
use App\Constants\LeadHistory\Actions as ActionConstants;

use App\Models\Meeting;
use App\Models\Meeting_note;
use App\Models\Employee;
use App\Services\LeadHistoryService;

class MeetingsController extends Controller
{
	public $show_action = true;
	public $view_col = 'meeting_date';
	public $listing_cols = ['id', 'contact_id', 'type', 'meeting_place', 'meeting_date', 'revenue', 'created_by'];

	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() >= 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Meetings', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Meetings', $this->listing_cols);
		}
		$this->middleware('permission:Meetings-view|Meetings-create|Meetings-edit|Meetings-delete', ['only' => ['index','show']]);
		$this->middleware('permission:Meetings-create', ['only' => ['create','store']]);
		$this->middleware('permission:Meetings-edit', ['only' => ['edit','update']]);
		$this->middleware('permission:Meetings-delete', ['only' => ['destroy']]);
	}

	/**
	 * Display a listing of the Meetings.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Meetings');

		if(Module::hasAccess("Meetings", "view")) {
			return View('la.meetings.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module,
				'notes_module'=> Module::get('Meeting_notes')
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}
	public function report_index()
	{
		$module = Module::get('Meetings');
		$user=\Auth::user();
		if ($user->roles[0]['view_dept'])
		{
			$emps=\App\Models\Employee::where("dept",$user->employee->dept);
			$contacts=\App\Models\Contact::whereIn("created_by",$emps->pluck('id')->toArray())->get()->pluck("full_name","id")->toArray();
			$emps=$emps->pluck("name","id")->toArray();
		}
		else
		{
			$emps=\App\Models\Employee::pluck("name","id")->toArray();
			$contacts=\App\Models\Contact::all()->pluck("full_name","id")->toArray();
		}
		if(Module::hasAccess("Meetings", "view")) {
			return View('la.meetings.report', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module2' => $module,
				'employees'=>$emps,
				'interests'=>\App\Models\Interest::pluck("name","id")->toArray(),
				'sources'=>\App\Models\Contact_source::pluck("name","id")->toArray(),
				'contacts'=>$contacts,
				'user'=>$user
				]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new meeting.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$module = Module::get('Meetings');

		if(Module::hasAccess("Meetings", "create")) {
			return View('la.meetings.add', [
				'module' => $module,
				'notes_module'=> Module::get('Meeting_notes')
			]);
                    } else {
                return redirect(config('laraadmin.adminRoute')."/");
            }
	}

	/**
	 * Store a newly created meeting in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("Meetings", "create")) {

			$rules = Module::validateRules("Meetings", $request);

			$validator = Validator::make($request->all(), $rules);

			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			$request->created_by=\Auth()->user()->context_id;

			$insert_id = Module::insert("Meetings", $request);
                        $meeting=Meeting::find($insert_id);
                        $meeting->interests()->attach($request->interests_ids);
			if(!empty($request->notes) && !empty($request->follow_date))
			{
				$notes=new Meeting_note;
				$notes->notes=$request->notes;
				$notes->follow_date=$request->follow_date;
				$notes->meeting_id=$insert_id;
				$notes->created_by=\Auth()->user()->context_id;
				Module::insert("Meeting_notes", $notes);
				if(Meeting::where('contact_id',$meeting->contact->id)->count() == 1)
				{
					$meeting->contact->status = 'contacted';
					$meeting->contact->save();
				}
				$data = new LeadHistoryData($meeting->contact->id, ActionConstants::CALL_CREATED, $insert_id, $notes, $request->created_by);
				$leadHistoryService = new LeadHistoryService();
				$leadHistoryService->logAction($data);
			}
			return redirect()->back();

		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified meeting.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Meetings", "view")) {

			$meeting = Meeting::find($id);
			if(isset($meeting->id)) {
				$module = Module::get('Meetings');
				$module->row = $meeting;

				return view('la.meetings.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('meeting', $meeting);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("meeting"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified meeting.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("Meetings", "edit")) {
			$meeting = Meeting::find($id);
			if(isset($meeting->id)) {
				$module = Module::get('Meetings');
				$notes_module = Module::get('Meeting_notes');

				$module->row = $meeting;
				$last_date=$meeting->notes()->orderBy('follow_date','asc')->whereRaw(\DB::raw("follow_date>=CURDATE()"))->first();
				if(!empty($last_date))
				{
					$notes_module->row=$last_date;
					$notes_module->row->notes='';
				}
                                else
                                    $notes_module->row=null;
                                //dd($notes_module->row);
				return view('la.meetings.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
					'notes_module'=>$notes_module
				])->with('meeting', $meeting);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("meeting"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified meeting in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("Meetings", "edit")) {

			$rules = Module::validateRules("Meetings", $request, true);

			$validator = Validator::make($request->all(), $rules);

			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			$meeting=Meeting::find($id);
			$request->created_by=$meeting->created_by;
			$insert_id = Module::updateRow("Meetings", $request, $id);
                        $meeting->interests()->sync($request->interests_ids);
			if(!empty($request->notes) && !empty($request->follow_date))
			{
				$notes=new Meeting_note;
				$notes->notes=$request->notes;
				$notes->follow_date=$request->follow_date;
				$notes->meeting_id=$insert_id;
				$notes->created_by=\Auth()->user()->context_id;
				Module::insert("Meeting_notes", $notes);
			}
			return redirect()->route(config('laraadmin.adminRoute') . '.meetings.index');

		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified meeting from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Meetings", "delete")) {
                    Meeting_note::where("meeting_id",$id)->delete();
			Meeting::find($id)->delete();

			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.meetings.index');
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Datatable Ajax fetch
	 *
	 * @return
	 */
	public function dtajax(Request $request)
	{
		//\DB::enableQueryLog();
		$values = Meeting::select($this->listing_cols)->whereNull('deleted_at');
		if (\Auth()->user()->roles[0]['view_dept']) {
			$emps=Employee::where("dept",\Auth()->user()->employee->dept)->pluck('id')->toArray();
			$values->whereIn("created_by",$emps);
		}
		if (\Auth()->user()->roles[0]['view_data']) {
			$values->where("created_by",\Auth()->user()->context_id);
		}
		if(!empty($request->issearch))
		{
			if(!empty($_GET["created_at_from"]))
			{
				$d2 = date_parse_from_format("d/m/Y",$_GET["created_at_from"]);
				$created_at_from = date("Y-m-d", strtotime($d2['year']."-".$d2['month']."-".$d2['day']));
				$values=$values->where("meeting_date",">=",$created_at_from);
			}
			if(!empty($_GET["created_at_to"]))
			{
				$d2 = date_parse_from_format("d/m/Y",$_GET["created_at_to"]);
				$created_at_to = date("Y-m-d", strtotime($d2['year']."-".$d2['month']."-".$d2['day']));
				$values=$values->where("meeting_date","<=",$created_at_to);
			}
			if(!empty($_GET["follow_date_from"]) && !empty($_GET["follow_date_from"]))
			{
				$d = date_parse_from_format("d/m/Y",$_GET["follow_date_from"]);
				$follow_date_from = date("Y-m-d", strtotime($d['year']."-".$d['month']."-".$d['day']));
				$d2 = date_parse_from_format("d/m/Y",$_GET["follow_date_to"]);
				$follow_date_to = date("Y-m-d", strtotime($d2['year']."-".$d2['month']."-".$d2['day']));
				$values=$values->whereHas("notes",function($q) use ($follow_date_from,$follow_date_to){
					$q->where("follow_date",">=",$follow_date_from)->where("follow_date","<=",$follow_date_to);
				});
			}
			else
			{
				if(!empty($_GET["follow_date_from"]))
				{
					$d2 = date_parse_from_format("d/m/Y",$_GET["follow_date_from"]);
					$follow_date_from = date("Y-m-d", strtotime($d2['year']."-".$d2['month']."-".$d2['day']));
					$values=$values->whereHas("notes",function($q) use ($follow_date_from){
						$q->where("follow_date",">=",$follow_date_from);
					});
				}
				if(!empty($_GET["follow_date_to"]))
				{
					$d2 = date_parse_from_format("d/m/Y",$_GET["follow_date_to"]);
					$follow_date_to = date("Y-m-d", strtotime($d2['year']."-".$d2['month']."-".$d2['day']));
					$values->whereHas("notes",function($q) use ($follow_date_to){
						$q->where("follow_date","<=",$follow_date_to);
					});
				}
			}
			if(!empty($_GET["employee"]))
			{
				$values=$values->where("created_by",$_GET["employee"]);
			}
			if(!empty($_GET["contacts"]))
			{
				$values=$values->where("contact_id",$_GET["contacts"]);
			}
			if(!empty($_GET["interests"]))
			{
				$values=$values->whereRaw('json_contains(interests_ids, \'["' . $_GET['interests'] . '"]\')');
			}
			if(!empty($_GET["sources"]))
			{
				$source=$_GET['sources'];
				$values=$values->whereHas("contact",function($q) use($source) {
					$q->where("contact_source_id",$source);
				});
			}
		}
		$out = Datatables::of($values->orderBy('id','desc'))->addColumn('action', function ($user) {
			return '';
		})->make();
		$data = $out->getData();
//dd(\DB::getQueryLog());
		$fields_popup = ModuleFields::getModuleFields('Meetings');

		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) {
				$col = $this->listing_cols[$j];

				if($fields_popup[$col] != null && Str::startsWith($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i]->$col = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i]->$col);
				}
				if($col == $this->view_col) {
					$data->data[$i]->$col = '<a href="'.url(config('laraadmin.adminRoute') . '/meetings/'.$data->data[$i]->id).'">'.$data->data[$i]->$col.'</a>';
				}

				else if($col == "closed") {
				    $data->data[$i]->$col=!empty($data->data[$i]->$col)? 'yes':'no';
				}
			}

			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("Meetings", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/meetings/'.$data->data[$i]->id.'/edit').'" class="btn btn-warning btn-xs" style=""><i class="fa fa-edit"></i></a>';
				}

				if(Module::hasAccess("Meetings", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.meetings.destroy', $data->data[$i]->id], 'method' => 'delete', 'style'=>'display:inline']);
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
