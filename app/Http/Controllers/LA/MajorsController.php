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

use App\Models\Major;

class MajorsController extends Controller
{
	public $show_action = true;
	public $view_col = 'name';
	public $listing_cols = ['id', 'industry_id', 'name'];

	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() >= 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Majors', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Majors', $this->listing_cols);
		}
		$this->middleware('permission:Majors-view|Majors-create|Majors-edit|Majors-delete', ['only' => ['index','show']]);
		$this->middleware('permission:Majors-create', ['only' => ['create','store']]);
		$this->middleware('permission:Majors-edit', ['only' => ['edit','update']]);
		$this->middleware('permission:Majors-delete', ['only' => ['destroy']]);
	}

	/**
	 * Display a listing of the Majors.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Majors');

		if(Module::hasAccess("Majors", "view")) {
			return View('la.majors.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new major.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created major in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("Majors", "create")) {

			$rules = Module::validateRules("Majors", $request);

			$validator = Validator::make($request->all(), $rules);

			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}

			$insert_id = Module::insert("Majors", $request);

			return redirect()->route(config('laraadmin.adminRoute') . '.majors.index');

		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified major.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Majors", "view")) {

			$major = Major::find($id);
			if(isset($major->id)) {
				$module = Module::get('Majors');
				$module->row = $major;

				return view('la.majors.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('major', $major);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("major"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified major.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("Majors", "edit")) {
			$major = Major::find($id);
			if(isset($major->id)) {
				$module = Module::get('Majors');

				$module->row = $major;

				return view('la.majors.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('major', $major);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("major"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified major in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("Majors", "edit")) {

			$rules = Module::validateRules("Majors", $request, true);

			$validator = Validator::make($request->all(), $rules);

			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}

			$insert_id = Module::updateRow("Majors", $request, $id);

			return redirect()->route(config('laraadmin.adminRoute') . '.majors.index');

		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified major from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Majors", "delete")) {
                    if($message=$this->checkAvailabilityToDelete($id,array("Contact"=>array("contacts","major_id"))))
                    {
                            return  redirect()->back()->withErrors(['msg'=>[$message]]);
                    }
			Major::find($id)->delete();

			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.majors.index');
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
		$values = DB::table('majors')->select($this->listing_cols)->whereNull('deleted_at');
		$out = Datatables::of($values->orderBy('id','desc'))->addColumn('action', function ($user) {
			return '';
		})->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Majors');

		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) {
				$col = $this->listing_cols[$j];

				if($fields_popup[$col] != null && Str::startsWith($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i]->$col = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i]->$col);
				}
				if($col == $this->view_col) {
					$data->data[$i]->$col = '<a href="'.url(config('laraadmin.adminRoute') . '/majors/'.$data->data[$i]->id).'">'.$data->data[$i]->$col.'</a>';
				}

				// else if($col == "author") {
				//    $data->data[$i]->$col;
				// }
			}

			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("Majors", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/majors/'.$data->data[$i]->id.'/edit').'" class="btn btn-warning btn-xs" style=""><i class="fa fa-edit"></i></a>';
				}

				if(Module::hasAccess("Majors", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.majors.destroy', $data->data[$i]->id], 'method' => 'delete', 'style'=>'display:inline']);
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

    public function get_majors_by_industry($industry_id)
	{
		return response()->json(Major::where("industry_id",$industry_id)->pluck('name','id')->toArray());
	}

	public function ajax_get_majors_by_industry(Request $request)
	{
		return response()->json(Major::where("industry_id",$request->industry_id)->get()->toArray());
	}
}
