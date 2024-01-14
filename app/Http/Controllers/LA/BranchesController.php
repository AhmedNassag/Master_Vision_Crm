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

use App\Models\Branch;

class BranchesController extends Controller
{
	public $show_action = true;
	public $view_col = 'name';
	public $listing_cols = ['id', 'name'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() >= 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Branches', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Branches', $this->listing_cols);
		}
		$this->middleware('permission:Branches-view|Branches-create|Branches-edit|Branches-delete', ['only' => ['index','show']]);
		$this->middleware('permission:Branches-create', ['only' => ['create','store']]);
		$this->middleware('permission:Branches-edit', ['only' => ['edit','update']]);
		$this->middleware('permission:Branches-delete', ['only' => ['destroy']]);
	}
	
	/**
	 * Display a listing of the Branches.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Branches');
		
		if(Module::hasAccess("Branches", "view")) {
			return View('la.branches.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new branch.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created branch in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("Branches", "create")) {
		
			$rules = Module::validateRules("Branches", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("Branches", $request);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.branches.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified branch.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Branches", "view")) {
			
			$branch = Branch::find($id);
			if(isset($branch->id)) {
				$module = Module::get('Branches');
				$module->row = $branch;
				
				return view('la.branches.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('branch', $branch);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("branch"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified branch.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("Branches", "edit")) {
			$branch = Branch::find($id);
			if(isset($branch->id)) {	
				$module = Module::get('Branches');
				
				$module->row = $branch;
				
				return view('la.branches.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('branch', $branch);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("branch"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified branch in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("Branches", "edit")) {
			
			$rules = Module::validateRules("Branches", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("Branches", $request, $id);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.branches.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified branch from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Branches", "delete")) {
			Branch::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.branches.index');
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
		$values = DB::table('branches')->select($this->listing_cols)->whereNull('deleted_at');
		$out = Datatables::of($values->orderBy('id','desc'))->addColumn('action', function ($user) {
			return '';
		})->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Branches');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && $fields_popup[$col]->field_type_str == "Image") {
					if($data->data[$i]->$col != 0) {
						$img = \App\Models\Upload::find($data->data[$i]->$col);
						if(isset($img->name)) {
							$data->data[$i]->$col = '<img width="100px" src="'.$img->path().'?s=100">';
						} else {
							$data->data[$i]->$col = "";
						}
					} else {
						$data->data[$i]->$col = "";
					}
				}
				if($fields_popup[$col] != null && $fields_popup[$col]->field_type_str == "Checkbox") {
					if(empty($data->data[$i]->$col))
						$data->data[$i]->$col="<span style='color:red'>No</span>";
					else
						$data->data[$i]->$col="<span style='color:green'>Yes</span>";
				}
				if($fields_popup[$col] != null && Str::startsWith($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i]->$col = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i]->$col);
				}
				if($col == $this->view_col) {
					$data->data[$i]->$col = '<a href="'.url(config('laraadmin.adminRoute') . '/branches/'.$data->data[$i]->id).'">'.$data->data[$i]->$col.'</a>';
				}

				// else if($col == "author") {
				//    $data->data[$i]->$col;
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("Branches", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/branches/'.$data->data[$i]->id.'/edit').'" class="btn btn-warning btn-xs" style=""><i class="fa fa-edit"></i></a>';
				}
				
				if(Module::hasAccess("Branches", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.branches.destroy', $data->data[$i]->id], 'method' => 'delete', 'style'=>'display:inline']);
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
