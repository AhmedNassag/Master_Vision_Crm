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

use App\Models\Organization;

class OrganizationsController extends Controller
{
	public $show_action = true;
	public $view_col = 'name';
	public $listing_cols = ['id', 'profile_image', 'name', 'email', 'phone', 'website', 'assigned_to', 'city'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() >= 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Organizations', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Organizations', $this->listing_cols);
		}
		$this->middleware('permission:Organizations-view|Organizations-create|Organizations-edit|Organizations-delete', ['only' => ['index','show']]);
		$this->middleware('permission:Organizations-create', ['only' => ['create','store']]);
		$this->middleware('permission:Organizations-edit', ['only' => ['edit','update']]);
		$this->middleware('permission:Organizations-delete', ['only' => ['destroy']]);

	}
	
	/**
	 * Display a listing of the Organizations.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Organizations');
		
		if(Module::hasAccess($module->id)) {
			return View('la.organizations.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new organization.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created organization in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("Organizations", "create")) {
		
			$rules = Module::validateRules("Organizations", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("Organizations", $request);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.organizations.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified organization.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Organizations", "view")) {
			
			$organization = Organization::find($id);
			if(isset($organization->id)) {
				$module = Module::get('Organizations');
				$module->row = $organization;
				
				return view('la.organizations.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('organization', $organization);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("organization"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified organization.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("Organizations", "edit")) {
			$organization = Organization::find($id);
			if(isset($organization->id)) {
				$organization = Organization::find($id);
				
				$module = Module::get('Organizations');
				
				$module->row = $organization;
				
				return view('la.organizations.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('organization', $organization);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("organization"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified organization in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("Organizations", "edit")) {
			
			$rules = Module::validateRules("Organizations", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("Organizations", $request, $id);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.organizations.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified organization from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Organizations", "delete")) {
			Organization::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.organizations.index');
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
		$values = DB::table('organizations')->select($this->listing_cols)->whereNull('deleted_at');
		$out = Datatables::of($values->orderBy('id','desc'))->addColumn('action', function ($user) {
			return '';
		})->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Organizations');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) {
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && $fields_popup[$col]->field_type_str == "Image") {
					if($data->data[$i]->$col != 0) {
						$img = \App\Models\Upload::find($data->data[$i]->$col);
						if(isset($img->name)) {
							$data->data[$i]->$col = '<img src="'.$img->path().'?s=50">';
						} else {
							$data->data[$i]->$col = "";
						}
					} else {
						$data->data[$i]->$col = "";
					}
				}
				if($fields_popup[$col] != null && Str::startsWith($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i]->$col = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i]->$col);
				}
				if($col == $this->view_col) {
					$data->data[$i]->$col = '<a href="'.url(config('laraadmin.adminRoute') . '/organizations/'.$data->data[$i]->id).'">'.$data->data[$i]->$col.'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i]->$col;
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("Organizations", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/organizations/'.$data->data[$i]->id.'/edit').'" class="btn btn-warning btn-xs" style=""><i class="fa fa-edit"></i></a>';
				}
				
				if(Module::hasAccess("Organizations", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.organizations.destroy', $data->data[$i]->id], 'method' => 'delete', 'style'=>'display:inline']);
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
}
