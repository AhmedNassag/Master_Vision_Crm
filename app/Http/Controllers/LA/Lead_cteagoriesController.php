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

use App\Models\Lead_cteagory;

class Lead_cteagoriesController extends Controller
{
	public $show_action = true;
	public $view_col = 'contact_category_id';
	public $listing_cols = ['id', 'contact_category_id', 'contact_id'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() >= 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Lead_cteagories', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Lead_cteagories', $this->listing_cols);
		}
		$this->middleware('permission:Lead_cteagories-view|Lead_cteagories-create|Lead_cteagories-edit|Lead_cteagories-delete', ['only' => ['index','show']]);
		$this->middleware('permission:Lead_cteagories-create', ['only' => ['create','store']]);
		$this->middleware('permission:Lead_cteagories-edit', ['only' => ['edit','update']]);
		$this->middleware('permission:Lead_cteagories-delete', ['only' => ['destroy']]);
	}
	
	/**
	 * Display a listing of the Lead_cteagories.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Lead_cteagories');
		
		if(Module::hasAccess("Lead_cteagories", "view")) {
			return View('la.lead_cteagories.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new lead_cteagory.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created lead_cteagory in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("Lead_cteagories", "create")) {
		
			$rules = Module::validateRules("Lead_cteagories", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("Lead_cteagories", $request);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.lead_cteagories.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified lead_cteagory.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Lead_cteagories", "view")) {
			
			$lead_cteagory = Lead_cteagory::find($id);
			if(isset($lead_cteagory->id)) {
				$module = Module::get('Lead_cteagories');
				$module->row = $lead_cteagory;
				
				return view('la.lead_cteagories.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('lead_cteagory', $lead_cteagory);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("lead_cteagory"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified lead_cteagory.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("Lead_cteagories", "edit")) {
			$lead_cteagory = Lead_cteagory::find($id);
			if(isset($lead_cteagory->id)) {	
				$module = Module::get('Lead_cteagories');
				
				$module->row = $lead_cteagory;
				
				return view('la.lead_cteagories.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('lead_cteagory', $lead_cteagory);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("lead_cteagory"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified lead_cteagory in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("Lead_cteagories", "edit")) {
			
			$rules = Module::validateRules("Lead_cteagories", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("Lead_cteagories", $request, $id);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.lead_cteagories.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified lead_cteagory from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Lead_cteagories", "delete")) {
			Lead_cteagory::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.lead_cteagories.index');
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
		$values = DB::table('lead_cteagories')->select($this->listing_cols)->whereNull('deleted_at');
		$out = Datatables::of($values->orderBy('id','desc'))->addColumn('action', function ($user) {
			return '';
		})->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Lead_cteagories');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				
				if($fields_popup[$col] != null && Str::startsWith($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i]->$col = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i]->$col);
				}
				if($col == $this->view_col) {
					$data->data[$i]->$col = '<a href="'.url(config('laraadmin.adminRoute') . '/lead_cteagories/'.$data->data[$i]->id).'">'.$data->data[$i]->$col.'</a>';
				}

				// else if($col == "author") {
				//    $data->data[$i]->$col;
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("Lead_cteagories", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/lead_cteagories/'.$data->data[$i]->id.'/edit').'" class="btn btn-warning btn-xs" style=""><i class="fa fa-edit"></i></a>';
				}
				
				if(Module::hasAccess("Lead_cteagories", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.lead_cteagories.destroy', $data->data[$i]->id], 'method' => 'delete', 'style'=>'display:inline']);
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
