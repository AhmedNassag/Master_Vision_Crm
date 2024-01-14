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

use App\Models\Industry;

class IndustriesController extends Controller
{
	public $show_action = true;
	public $view_col = 'name';
	public $listing_cols = ['id', 'name'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() >= 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Industries', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Industries', $this->listing_cols);
		}
		$this->middleware('permission:Industries-view|Industries-create|Industries-edit|Industries-delete', ['only' => ['index','show']]);
		$this->middleware('permission:Industries-create', ['only' => ['create','store']]);
		$this->middleware('permission:Industries-edit', ['only' => ['edit','update']]);
		$this->middleware('permission:Industries-delete', ['only' => ['destroy']]);
	}
	
	/**
	 * Display a listing of the Industries.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Industries');
		
		if(Module::hasAccess("Industries", "view")) {
			return View('la.industries.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new industry.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created industry in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("Industries", "create")) {
		
			$rules = Module::validateRules("Industries", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("Industries", $request);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.industries.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified industry.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Industries", "view")) {
			
			$industry = Industry::find($id);
			if(isset($industry->id)) {
				$module = Module::get('Industries');
				$module->row = $industry;
				
				return view('la.industries.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('industry', $industry);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("industry"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified industry.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("Industries", "edit")) {
			$industry = Industry::find($id);
			if(isset($industry->id)) {	
				$module = Module::get('Industries');
				
				$module->row = $industry;
				
				return view('la.industries.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('industry', $industry);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("industry"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified industry in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("Industries", "edit")) {
			
			$rules = Module::validateRules("Industries", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("Industries", $request, $id);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.industries.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified industry from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Industries", "delete")) {
                    if($message=$this->checkAvailabilityToDelete($id,array("Contact"=>array("contacts","industry_id"),"Major"=>array("majors","industry_id"))))
                    {
                            return  redirect()->back()->withErrors(['msg'=>[$message]]);
                    }
			Industry::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.industries.index');
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
		$values = DB::table('industries')->select($this->listing_cols)->whereNull('deleted_at');
		$out = Datatables::of($values->orderBy('id','desc'))->addColumn('action', function ($user) {
			return '';
		})->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Industries');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				
				if($fields_popup[$col] != null && Str::startsWith($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i]->$col = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i]->$col);
				}
				if($col == $this->view_col) {
					$data->data[$i]->$col = '<a href="'.url(config('laraadmin.adminRoute') . '/industries/'.$data->data[$i]->id).'">'.$data->data[$i]->$col.'</a>';
				}

				// else if($col == "author") {
				//    $data->data[$i]->$col;
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("Industries", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/industries/'.$data->data[$i]->id.'/edit').'" class="btn btn-warning btn-xs" style=""><i class="fa fa-edit"></i></a>';
				}
				
				if(Module::hasAccess("Industries", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.industries.destroy', $data->data[$i]->id], 'method' => 'delete', 'style'=>'display:inline']);
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
