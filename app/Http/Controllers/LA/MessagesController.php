<?php

/**
 * Controller genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Http\Controllers\LA;

use App\Exports\ContactExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Resources\ContactsResource;
use App\Imports\ContactsImport;
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

use App\Models\Contact;
use App\Models\Customer;
use App\Services\ContactFilterService;
use App\Services\LeadConversionService;
use App\Services\LeadHistoryService;

use App\Models\Job_title;
use App\Models\Contact_category;
use App\Models\Contact_source;
use App\Models\City;
use App\Models\Area;
use App\Models\Industry;
use App\Models\Major;
use App\Models\Activate;
use App\Models\Branch;
use App\Models\ContactCompletion;
use App\Models\Employee;
use App\Observers\ContactDataObserver;
use Maatwebsite\Excel\Facades\Excel;
use Dwij\Laraadmin\Models\LAConfigs;

class MessagesController extends Controller
{
	public $show_action = true;
	public $view_col = 'name';
	public $listing_cols = ['id', 'gender', 'customer_id', 'name', 'mobile', 'mobile2', 'email', 'company_name', 'job_title_id', 'contact_category_id', 'contact_source_id', 'city_id', 'area_id', 'industry_id', 'major_id', 'activity_id', 'created_by', 'notes'];
	protected $contactFilterService;




    

	/**
	 * Display a listing of the Contacts.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		if (Module::hasAccess("Contacts", "view")) {
			$module = Module::get('Contacts');
			$jobTitles = Job_title::all();
			$contactCategories = Contact_category::all();
			$contactSources = Contact_source::all();
			$cities = City::all();
			$areas = Area::all();
			$industries = Industry::all();
			$majors = Major::all();
			$activities = Activate::all();
			$statusCounts = Contact::whereIn('status', ['new', 'converted','contacted'])
				->where('is_trashed', 0)
				->where('is_active', 1)
				->select('status', DB::raw('COUNT(*) as count'))
				->groupBy('status')
				->pluck('count', 'status')
				->toArray();
			$statusCounts['trashed'] = Contact::where('is_trashed', 1)->count();
			$statusCounts['inactive'] = Contact::where('is_active', 0)->count();

			$employees = Employee::all();
            $branches = Branch::all();

			return View('la.contacts.managment', compact(
				'jobTitles',
                'branches',
				'module',
				'contactCategories',
				'contactSources',
				'cities',
				'areas',
				'industries',
				'majors',
				'activities',
				'statusCounts',
				'employees'
			));
		} else {
			return redirect(config('laraadmin.adminRoute') . "/");
		}
		$module = Module::get('Contacts');
		if (Module::hasAccess("Contacts", "view")) {
			return View('la.contacts.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
			return redirect(config('laraadmin.adminRoute') . "/");
		}
	}
	
	
	
	public function getRecieverTypeData(Request $request)
    {
		switch ($request->id) {
			case 1:
				$data = Contact::all();
			  break;
			case 2:
				$data = Customer::all();
			  break;
			case 3:
				$data = [];
			  break;
			default:
			$data = [];
		  }
        
        $newData = '"<option value="">'.trans("admin.Select Item").'</option>';

        foreach ($data as $on) {
			$newData .= "<option value='+" . $on->mobile . "'>" . $on->name . "</option>";
        }

        return response()->json([
            "status"    => '1',
            "msg"       => [$newData]
        ]);
    }



	public function deactivateUsers(Request $request)
	{

		if (is_array($request->contact_ids) && count($request->contact_ids) > 0) {

			$contacts = Contact::whereIn('id', $request->contact_ids)->get();
			foreach($contacts as $contact)
			{
				if($contact->is_active == 1)
				{
					$contact->update(['is_active' => 0]);
				}else{
					$contact->update(['is_active' => 1]);
				}
			}

			return response()->json(['success' => true]);
		} else {
			return response()->json(['success' => false]);
		}
	}

	


	/**
	 * Show the form for creating a new contact.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		if (Module::hasAccess("Contacts", "view")) {

				$types = array(['id'=>1,'name'=>trans('admin.Contacts')]
				,['id'=>2,'name'=>trans('admin.Customers')]);
                
				return view('la.messages.create', [
                    "types"=>$types,
				]);

		} else {
			return redirect(config('laraadmin.adminRoute') . "/");
		}
	}



	

	

	/**
	 * Store a newly created contact in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		//return $request->reciever_data_type;
		//return ($request->reciever_id);
		if($request->has('reciever_data_type') && $request->reciever_data_type = 'id'){
			$mobile_recievers = Contact::WhereIn('id',$request->reciever_id)->pluck('mobile');
			$all_mobiles = '';
			foreach($mobile_recievers as $index=>$mobile ){
				if($index==0){
					$all_mobiles = '+'.$mobile;
				}else{
					$all_mobiles = $all_mobiles.','.'+'.$mobile;
				}
				
			}
			
			//dd($recievers);
		}else{
			$all_mobiles = $request->reciever_id;
			$all_mobiles = implode("," ,$all_mobiles);
		}
		 
		$token = LAConfigs::getByKey('whatsapp_token')?? null;
		$instance = LAConfigs::getByKey('whatsapp_instance')?? null;
		if($token == null || $instance == null){
			$errorMessage = 'من فضلك تأكد من أشتراكك فى خدمة الرسائل عن طريق الواتساب';
			return redirect()->back()->withErrors([$errorMessage]);
		}
		//$all_mobiles = implode(",",$all_mobiles);

		$url = "https://api.ultramsg.com/instance".$instance."/messages/chat";
		$params=array(
			'token' => $token,
			'to' => $all_mobiles,
			'body' => $request->message
			);
			$curl = curl_init();
			curl_setopt_array($curl, array(
			  CURLOPT_URL => $url,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_SSL_VERIFYHOST => 0,
			  CURLOPT_SSL_VERIFYPEER => 0,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => http_build_query($params),
			  CURLOPT_HTTPHEADER => array(
				"content-type: application/x-www-form-urlencoded"
			  ),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			if ($err) {
			  echo "cURL Error #:" . $err;
			  $errorMessage = 'من فضلك تأكد من بيانات الاشتراك';
			return redirect()->back()->withErrors([$err]);
			} else {
			  echo $response;
			  return redirect()->back();
			}
		
		
		
	}

    public function exportContactsView()
    {
        $jobTitles = Job_title::all();
			$contactCategories = Contact_category::all();
			$contactSources = Contact_source::all();
			$cities = City::all();
			$areas = Area::all();
			$industries = Industry::all();
			$majors = Major::all();
			$activities = Activate::all();
			$employees = Employee::all();


        return view('reports.export-contact',compact(
            'jobTitles',
            'contactCategories',
            'contactSources',
            'cities',
            'areas',
            'industries',
            'majors',
            'activities',
            'employees'
        ));
    }

    public function exportContacts(Request $request)
    {
        $filters = [
			'gender' => $request->input('gender'),
			'status' => $request->input('status'),
			'name' => $request->input('name'),
			'mobile' => $request->input('mobile'),
			'mobile2' => $request->input('mobile2'),
			'email' => $request->input('email'),
			'company_name' => $request->input('company_name'),
			'job_title_id' => $request->input('job_title_id'),
			'contact_category_id' => $request->input('contact_category_id'),
			'contact_source_id' => $request->input('contact_source_id'),
			'city_id' => $request->input('city_id'),
			'area_id' => $request->input('area_id'),
			'industry_id' => $request->input('industry_id'),
			'major_id' => $request->input('major_id'),
			'activity_id' => $request->input('activity_id'),
			'notes' => $request->input('notes'),
			'assignment_type' => $request->input('assignment_type'),
			'national_id' => $request->input('national_id'),
			'campaign_id' => $request->input('campaign_id'),
            'interest_id'=> $request->input('interest_id'),
            'from_date'=> $request->input('from_date'),
            'to_date'=> $request->input('to_date'),
            'search_branch_id'=>$request->input('search_branch_id'),
            'search_employee_id'=>$request->input('search_employee_id'),
		];

		// Use the ContactFilterService to filter contacts
		$filteredContacts = $this->contactFilterService->filter($filters)->get();
        return Excel::download(new ContactExport($filteredContacts), 'contacts.xlsx');
    }

	/**
	 * Display the specified contact.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{

		if (Module::hasAccess("Contacts", "view")) {

			$contact = Contact::find($id);



			if (isset($contact->id)) {
				$module = Module::get('Contacts');

				$meetingModule = Module::get('Meetings');
				$notesModule = Module::get('Meeting_notes');
				$module->row = $contact;
				$leadHistoryService = new LeadHistoryService();
				$contactHistories = $leadHistoryService->organizeLeadHistoryForTimeline($contact);
                $employees = Employee::all();
                $completionByDate = ContactCompletion::where('contact_id',$contact->id)->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d %H:%i') as date_creation"), DB::raw('count(*) as completion_percentage'))
                ->groupBy('date_creation')
                ->get();
                 $completedData = ContactCompletion::where('contact_id',$contact->id)->select('completed_by',DB::raw('count(*) as completion_percentage'),DB::raw('GROUP_CONCAT(property_name) as fields'))
                ->groupBy('completed_by')
                ->get();

                $contactObserver = new ContactDataObserver();
                $totalFields = count($contactObserver->trackedFields);
                foreach($completionByDate as $date)
                {
                    $date->completion_percentage =  round(($date->completion_percentage / $totalFields) * 100);
                }
                $branches = Branch::all();
				return view('la.contacts.show', [
					'module' => $module,
					'view_col' => $this->view_col,
                    'completionByDate'=> $completionByDate,
                    'completedData'=> $completedData,
                    'employees'=>$employees,
					'no_header' => true,
					'meetingModule' => $meetingModule,
					'notesModule' => $notesModule,
					'histories' => $contactHistories,
					'no_padding' => "no-padding",
                    "branches"=>$branches,
				])->with('contact', $contact);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("contact"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute') . "/");
		}
	}

	/**
	 * Show the form for editing the specified contact.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if (Module::hasAccess("Contacts", "edit")) {
			$contact = Contact::find($id);
			if (isset($contact->id)) {
				$module = Module::get('Contacts');

				$module->row = $contact;
				$cities = City::all();
				$areas = Area::all();
				$industries = Industry::all();
				$majors = Major::all();
				return view('la.contacts.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
					'cities' => $cities,
					'areas' => $areas,
					'industries' => $industries,
					'majors' => $majors,
				])->with('contact', $contact);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("contact"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute') . "/");
		}
	}

	/**
	 * Update the specified contact in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if (Module::hasAccess("Contacts", "edit")) {

			$rules = Module::validateRules("Contacts", $request, true);

			$validator = Validator::make($request->all(), $rules);

			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}


			$contact = Contact::find($id);

			$data = $request->all();
			$data['created_by'] = auth()->user()->context_id;
			$contact->update(array_filter($data, function ($value) {
				if(!is_array($value))
				{
					return $value !== '' && $value !== null;
				}
			}));
			$contact->categories()->sync($request->contact_category_id);

			return redirect()->route(config('laraadmin.adminRoute') . '.contacts.index');
		} else {
			return redirect(config('laraadmin.adminRoute') . "/");
		}
	}

	/**
	 * Remove the specified contact from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if (Module::hasAccess("Contacts", "delete")) {
			Contact::find($id)->delete();

			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.contacts.index');
		} else {
			return redirect(config('laraadmin.adminRoute') . "/");
		}
	}

	/**
	 * Datatable Ajax fetch
	 *
	 * @return
	 */
	public function dtajax(Request $request)
	{
		$values = DB::table('contacts')->select($this->listing_cols)->whereNull('deleted_at');
		if (!empty($request->issearch)) {
			if (!empty($_GET["created_at_from"])) {
				$d2 = date_parse_from_format("d/m/Y", $_GET["created_at_from"]);
				$created_at_from = date("Y-m-d", strtotime($d2['year'] . "-" . $d2['month'] . "-" . $d2['day']));
				$values = $values->where("created_at", ">=", $created_at_from);
			}
			if (!empty($_GET["created_at_to"])) {
				$d2 = date_parse_from_format("d/m/Y", $_GET["created_at_to"]);
				$created_at_to = date("Y-m-d", strtotime($d2['year'] . "-" . $d2['month'] . "-" . $d2['day']));
				$values = $values->where("created_at", "<=", $created_at_to);
			}

			if (!empty($_GET["employee"])) {
				$values = $values->where("created_by", $_GET["employee"]);
			}
			if (!empty($_GET["category"])) {
				$values = $values->where("contact_category_id", $_GET["category"]);
			}
			if (!empty($_GET["sources"])) {
				$values = $values->where("contact_source_id", $_GET['sources']);
			}
			if (!empty($_GET["area"])) {
				$values = $values->where("area_id", $_GET["area"]);
			}
			if (!empty($_GET["city"])) {
				$values = $values->where("city_id", $_GET["city"]);
			}
			if (!empty($_GET["job_title_id"])) {
				$values = $values->where("job_title_id", $_GET["job_title_id"]);
			}
			if (!empty($_GET["industry_id"])) {
				$values = $values->where("industry_id", $_GET["industry_id"]);
			}
			if (!empty($_GET["major_id"])) {
				$values = $values->where("major_id", $_GET["major_id"]);
			}
		}
		$out = Datatables::of($values->orderBy('id', 'desc'))->addColumn('action', function ($user) {
			return '';
		})->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Contacts');

		for ($i = 0; $i < count($data->data); $i++) {
			for ($j = 0; $j < count($this->listing_cols); $j++) {
				$col = $this->listing_cols[$j];

				if ($fields_popup[$col] != null && Str::startsWith($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i]->$col = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i]->$col);
				}
				if ($col == $this->view_col) {
					$data->data[$i]->$col = '<a href="' . url(config('laraadmin.adminRoute') . '/contacts/' . $data->data[$i]->id) . '">' . $data->data[$i]->$col . '</a>';
				}

				// else if($col == "author") {
				//    $data->data[$i]->$col;
				// }
			}

			if ($this->show_action) {
				$output = '';
				if (Module::hasAccess("Contacts", "edit")) {
					$output .= '<a href="' . url(config('laraadmin.adminRoute') . '/contacts/' . $data->data[$i]->id . '/edit') . '" class="btn btn-warning btn-xs" style=""><i class="fa fa-edit"></i></a>';
				}

				if (Module::hasAccess("Contacts", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.contacts.destroy', $data->data[$i]->id], 'method' => 'delete', 'style' => 'display:inline']);
					$output .= ' <button class="btn btn-danger deleteFormBtn btn-xs" type="submit"><i class="fa fa-times"></i></button>';
					$output .= Form::close();
				}
				$data->data[$i]->action = (string)$output;
			}
			$data->data[$i]->id = $i + 1;
		}
		$out->setData($data);
		return $out;
	}

	public function import(Request $request)
	{
		// Validate the form submission
		$request->validate([
			'contacts_file' => 'required|mimes:xlsx,xls',
			'column_mappings' => 'required|array',
		]);

		// Retrieve column mappings from the request
		$columnMappings = $request->input('column_mappings');

        foreach ($columnMappings as $key => $value) {
            // Check if "contact_field" is null or empty
            if (isset($value['contact_field']) && ($value['contact_field'] === null || $value['contact_field'] === "")) {
                // Update "contact_field" to "notes"
                $columnMappings[$key]['contact_field'] = "notes";
            }
        }

		// Get the uploaded Excel file
		$uploadedFile = $request->file('contacts_file');

		// Create a unique filename for the uploaded file
		$filename = time() . '_' . $uploadedFile->getClientOriginalName();

		// Store the uploaded file in a temporary location
		$uploadedFile->storeAs('temp', $filename);

		// Define the path to the stored temporary file
		$filePath = storage_path('app/temp/' . $filename);

		// try {

		//Excel::import(new ContactsImport($columnMappings,$request->contact_source_id,$request->activity_id,$request->interest_id), $filePath);

		
		$importInstance = new ContactsImport($columnMappings, $request->contact_source_id, $request->activity_id, $request->interest_id);
		Excel::import($importInstance, $filePath);

		$rowsSavedCount = $importInstance->getRowsSavedCount();
		$rowsSkippedCount = $importInstance->getRowsSkippedCount();
		
		return redirect()->back()->with('success', "Contacts imported successfully. Rows saved: $rowsSavedCount, Rows skipped: $rowsSkippedCount.");
		//return redirect()->back()->with('success', 'Contacts imported successfully.');
		// } catch (\Exception $e) {
		// 	// Handle any import errors
		// 	return redirect()->back()->with('error', 'An error occurred during import. Please check your file and try again.');
		// } finally {
		// 	// Remove the temporary file
		// 	unlink($filePath);
		// }
	}

	public function report_index()
	{
		$module = Module::get('Contacts');
		$user = \Auth::user();
		if ($user->roles[0]['view_data']) {
			$emps = \App\Models\Employee::where("dept", $user->employee->dept)->pluck("name", "id")->toArray();
		} else {
			$emps = \App\Models\Employee::pluck("name", "id")->toArray();
		}
		if (Module::hasAccess("Contacts", "view")) {
			return View('la.contacts.report', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module2' => $module,
				'employees' => $emps,
				'sources' => \App\Models\Contact_source::pluck("name", "id")->toArray(),
				'categories' => \App\Models\Contact_category::pluck("name", "id")->toArray(),
				'cities' => \App\Models\City::pluck("name", "id")->toArray(),
				'industries' => \App\Models\Industry::pluck("name", "id")->toArray(),
				'jobs' => \App\Models\Job_title::pluck("name", "id")->toArray(),
				'user' => $user
			]);
		} else {
			return redirect(config('laraadmin.adminRoute') . "/");
		}
	}
}
