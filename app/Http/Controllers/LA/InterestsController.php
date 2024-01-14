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

use App\Models\Interest;

class InterestsController extends Controller
{
	public $show_action = true;
	public $view_col = 'activity_id';
	public $listing_cols = ['id', 'name', 'activity_id'];

	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() >= 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Interests', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Interests', $this->listing_cols);
		}
		$this->middleware('permission:Interests-view|Interests-create|Interests-edit|Interests-delete', ['only' => ['index','show']]);
		$this->middleware('permission:Interests-create', ['only' => ['create','store']]);
		$this->middleware('permission:Interests-edit', ['only' => ['edit','update']]);
		$this->middleware('permission:Interests-delete', ['only' => ['destroy']]);
	}

	/**
	 * Display a listing of the Interests.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Interests');

		if(Module::hasAccess("Interests", "view")) {
			return View('la.interests.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new interest.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created interest in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("Interests", "create")) {

			$rules = Module::validateRules("Interests", $request);

			$validator = Validator::make($request->all(), $rules);

			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}

			$insert_id = Module::insert("Interests", $request);

			return redirect()->route(config('laraadmin.adminRoute') . '.interests.index');

		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified interest.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Interests", "view")) {

			$interest = Interest::find($id);
			if(isset($interest->id)) {
				$module = Module::get('Interests');
				$module->row = $interest;

				return view('la.interests.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('interest', $interest);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("interest"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified interest.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("Interests", "edit")) {
			$interest = Interest::find($id);
			if(isset($interest->id)) {
				$module = Module::get('Interests');

				$module->row = $interest;

				return view('la.interests.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('interest', $interest);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("interest"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified interest in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("Interests", "edit")) {

			$rules = Module::validateRules("Interests", $request, true);

			$validator = Validator::make($request->all(), $rules);

			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}

			$insert_id = Module::updateRow("Interests", $request, $id);

			return redirect()->route(config('laraadmin.adminRoute') . '.interests.index');

		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}


    public function getAjaxInterests(Request $request)
	{
		return response()->json(Interest::where("activity_id",$request->activity_id)->get()->toArray());
	}

	/**
	 * Remove the specified interest from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Interests", "delete")) {
			Interest::find($id)->delete();

			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.interests.index');
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
		$values = DB::table('interests')->select($this->listing_cols)->whereNull('deleted_at');
		$out = Datatables::of($values->orderBy('id','desc'))->addColumn('action', function ($user) {
			return '';
		})->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Interests');

		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) {
				$col = $this->listing_cols[$j];

				if($fields_popup[$col] != null && Str::startsWith($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i]->$col = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i]->$col);
				}
				if($col == $this->view_col) {
					$data->data[$i]->$col = '<a href="'.url(config('laraadmin.adminRoute') . '/interests/'.$data->data[$i]->id).'">'.$data->data[$i]->$col.'</a>';
				}

				// else if($col == "author") {
				//    $data->data[$i]->$col;
				// }
			}

			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("Interests", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/interests/'.$data->data[$i]->id.'/edit').'" class="btn btn-warning btn-xs" style=""><i class="fa fa-edit"></i></a>';
				}

				if(Module::hasAccess("Interests", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.interests.destroy', $data->data[$i]->id], 'method' => 'delete', 'style'=>'display:inline']);
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
