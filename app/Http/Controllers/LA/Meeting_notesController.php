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

use App\Models\Meeting_note;

class Meeting_notesController extends Controller
{
	public $show_action = true;
	public $view_col = 'follow_date';
	public $listing_cols = ['id', 'meeting_id', 'notes', 'follow_date', 'created_by'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() >= 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Meeting_notes', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Meeting_notes', $this->listing_cols);
		}
		$this->middleware('permission:Meeting_notes-view|Meeting_notes-create|Meeting_notes-edit|Meeting_notes-delete', ['only' => ['index','show']]);
		$this->middleware('permission:Meeting_notes-create', ['only' => ['create','store']]);
		$this->middleware('permission:Meeting_notes-edit', ['only' => ['edit','update']]);
		$this->middleware('permission:Meeting_notes-delete', ['only' => ['destroy']]);
	}
	
	/**
	 * Display a listing of the Meeting_notes.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Meeting_notes');
		
		if(Module::hasAccess("Meeting_notes", "view")) {
			return View('la.meeting_notes.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new meeting_note.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created meeting_note in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("Meeting_notes", "create")) {
		
			$rules = Module::validateRules("Meeting_notes", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("Meeting_notes", $request);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.meeting_notes.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified meeting_note.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Meeting_notes", "view")) {
			
			$meeting_note = Meeting_note::find($id);
			if(isset($meeting_note->id)) {
				$module = Module::get('Meeting_notes');
				$module->row = $meeting_note;
				
				return view('la.meeting_notes.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('meeting_note', $meeting_note);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("meeting_note"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified meeting_note.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("Meeting_notes", "edit")) {
			$meeting_note = Meeting_note::find($id);
			if(isset($meeting_note->id)) {	
				$module = Module::get('Meeting_notes');
				
				$module->row = $meeting_note;
				
				return view('la.meeting_notes.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('meeting_note', $meeting_note);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("meeting_note"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified meeting_note in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("Meeting_notes", "edit")) {
			
			$rules = Module::validateRules("Meeting_notes", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("Meeting_notes", $request, $id);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.meeting_notes.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified meeting_note from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Meeting_notes", "delete")) {
			Meeting_note::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.meeting_notes.index');
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
		$values = DB::table('meeting_notes')->select($this->listing_cols)->whereNull('deleted_at');
		$out = Datatables::of($values->orderBy('id','desc'))->addColumn('action', function ($user) {
			return '';
		})->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Meeting_notes');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				
				if($fields_popup[$col] != null && Str::startsWith($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i]->$col = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i]->$col);
				}
				if($col == $this->view_col) {
					$data->data[$i]->$col = '<a href="'.url(config('laraadmin.adminRoute') . '/meeting_notes/'.$data->data[$i]->id).'">'.$data->data[$i]->$col.'</a>';
				}

				// else if($col == "author") {
				//    $data->data[$i]->$col;
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("Meeting_notes", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/meeting_notes/'.$data->data[$i]->id.'/edit').'" class="btn btn-warning btn-xs" style=""><i class="fa fa-edit"></i></a>';
				}
				
				if(Module::hasAccess("Meeting_notes", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.meeting_notes.destroy', $data->data[$i]->id], 'method' => 'delete', 'style'=>'display:inline']);
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
