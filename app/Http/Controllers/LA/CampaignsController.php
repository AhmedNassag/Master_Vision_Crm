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

use App\Models\Campaign;

class CampaignsController extends Controller
{
	public $show_action = true;
	public $view_col = 'name';
	public $listing_cols = ['id', 'name','url'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() >= 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Campaigns', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Campaigns', $this->listing_cols);
		}
		$this->middleware('permission:Campaigns-view|Campaigns-create|Campaigns-edit|Campaigns-delete', ['only' => ['index','show']]);
		$this->middleware('permission:Campaigns-create', ['only' => ['create','store']]);
		$this->middleware('permission:Campaigns-edit', ['only' => ['edit','update']]);
		$this->middleware('permission:Campaigns-delete', ['only' => ['destroy']]);
	}
	
	/**
	 * Display a listing of the Campaigns.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Campaigns');
		
		if(Module::hasAccess("Campaigns", "view")) {
			return View('la.campaigns.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new campaign.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created campaign in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("Campaigns", "create")) {
		
			$rules = Module::validateRules("Campaigns", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("Campaigns", $request);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.campaigns.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified campaign.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Campaigns", "view")) {
			
			$campaign = Campaign::find($id);
			if(isset($campaign->id)) {
				$module = Module::get('Campaigns');
				$module->row = $campaign;
				
				return view('la.campaigns.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('campaign', $campaign);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("campaign"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified campaign.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("Campaigns", "edit")) {
			$campaign = Campaign::find($id);
			if(isset($campaign->id)) {	
				$module = Module::get('Campaigns');
				
				$module->row = $campaign;
				
				return view('la.campaigns.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('campaign', $campaign);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("campaign"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified campaign in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("Campaigns", "edit")) {
			
			$rules = Module::validateRules("Campaigns", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("Campaigns", $request, $id);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.campaigns.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified campaign from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Campaigns", "delete")) {
			Campaign::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.campaigns.index');
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
		$values = DB::table('campaigns')->select($this->listing_cols)->whereNull('deleted_at');
		$out = Datatables::of($values->orderBy('id','desc'))->addColumn('action', function ($user) {
			return '';
		})->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Campaigns');
		
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
					$data->data[$i]->$col = '<a href="'.url(config('laraadmin.adminRoute') . '/campaigns/'.$data->data[$i]->id).'">'.$data->data[$i]->$col.'</a>';
				}

				else if($col == "url") {
                    if($data->data[$i]->$col)
                    {
                        $data->data[$i]->$col = $data->data[$i]->$col."?campid=".$data->data[$i]->id;
                    }
				}
			}
			
			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("Campaigns", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/campaigns/'.$data->data[$i]->id.'/edit').'" class="btn btn-warning btn-xs" style=""><i class="fa fa-edit"></i></a>';
				}
				
				if(Module::hasAccess("Campaigns", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.campaigns.destroy', $data->data[$i]->id], 'method' => 'delete', 'style'=>'display:inline']);
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
