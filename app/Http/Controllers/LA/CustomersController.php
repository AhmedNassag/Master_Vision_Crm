<?php
/**
 * Controller genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Http\Controllers\LA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Imports\CustomersImport;
use App\Models\Activate;
use App\Models\Area;
use App\Models\Campaign;
use App\Models\City;
use App\Models\Contact;
use App\Models\Contact_source;
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

use App\Models\Customer;
use App\Models\Industry;
use App\Models\Interest;
use App\Models\ReorderReminder;
use App\Models\Invoice;
use App\Models\Major;
use App\Services\PointAdditionService;
use Maatwebsite\Excel\Facades\Excel;

class CustomersController extends Controller
{
	public $show_action = true;
	public $view_col = 'name';
	public $listing_cols = ['id', 'name','mobile', 'mobile2', 'email', 'job_title_id', 'contact_source_id', 'city_id', 'area_id', 'activity_id', 'created_by'];

	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() >= 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Customers', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Customers', $this->listing_cols);
		}
		$this->middleware('permission:Customers-view|Customers-create|Customers-edit|Customers-delete', ['only' => ['index','show']]);
		$this->middleware('permission:Customers-create', ['only' => ['create','store']]);
		$this->middleware('permission:Customers-edit', ['only' => ['edit','update']]);
		$this->middleware('permission:Customers-delete', ['only' => ['destroy']]);
	}

	/**
	 * Display a listing of the Customers.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Customers');
		$cities = City::all();
		$areas = Area::all();
		$industries = Industry::all();
		$majors = Major::all();
		$activities = Activate::all();
		$contactSources = Contact_source::all();
		if(Module::hasAccess("Customers", "view")) {
			return View('la.customers.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module,
				'contactSources'=>$contactSources,
				"cities"=> $cities,
				"areas"=> $areas,
				"industries"=> $industries,
				"majors"=> $majors,
				"activities"=> $activities,
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new customer.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created customer in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("Customers", "create")) {

			$rules = Module::validateRules("Customers", $request);

			$validator = Validator::make($request->all(), $rules);

			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}

			$data = $request->all();
			$data['created_by'] = auth()->user()->context_id;
            $employee = auth()->user()->employee;
            if($employee)
            {
                $data['branch_id'] = $employee->branch_id;
            }
			$insert = Customer::create(array_filter($data, function ($value) {
				return $value !== '' && $value !== null;
			}));

			return redirect()->route(config('laraadmin.adminRoute') . '.customers.index');

		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified customer.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Customers", "view")) {

			$customer = Customer::find($id);
			if(isset($customer->id)) {
				$module = Module::get('Customers');
                $addModule = Module::get('Customers');
				$module->row = $customer;
				$attachmentsModule = Module::get('Attachments');
                $cities = City::all();
                $areas = Area::all();
                $industries = Industry::all();
                $majors = Major::all();
                $activities = Activate::all();
                $contactSources = Contact_source::all();

				return view('la.customers.show', [
					'module' => $module,
                    'addModule'=>$addModule,
					'view_col' => $this->view_col,
					'attachmentsModule'=>$attachmentsModule,
					'no_header' => true,
					'no_padding' => "no-padding",
                    'contactSources'=>$contactSources,
                    "cities"=> $cities,
                    "areas"=> $areas,
                    "industries"=> $industries,
                    "majors"=> $majors,
                    "activities"=> $activities,
				])->with('customer', $customer);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("customer"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified customer.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	 public function edit($id)
	{
		if(Module::hasAccess("Customers", "edit")) {
			$customer = Customer::find($id);
			if(isset($customer->id)) {
				$module = Module::get('Customers');

				$module->row = $customer;

				return view('la.customers.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('customer', $customer);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("customer"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}




	public function editInvoice($id)
	{
		if(Module::hasAccess("Customers", "edit")) {
			 $invoice = Invoice::find($id);
			if(isset($invoice->id)) {


				return view('la.customers.edit-invoice', [

					'view_col' => $this->view_col,
				])->with('invoice', $invoice);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("invoice"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified customer in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("Customers", "edit")) {

			$rules = Module::validateRules("Customers", $request, true);

			$validator = Validator::make($request->all(), $rules);

			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
            $data = array_map(function($value) {
                return $value === "" ? null : $value;
            }, $request->all());


            $customer = Customer::find($id);
            $customer->update($data);

			return redirect()->route(config('laraadmin.adminRoute') . '.customers.index');

		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	
	
	
	public function updateInvoice(Request $request, $id)
	{
		if(Module::hasAccess("Customers", "edit")) {



            $data = array_map(function($value) {
                return $value === "" ? null : $value;
            }, $request->all());


            $invoice = Invoice::find($id);
            $invoice->update($data);

			return redirect()->route(config('laraadmin.adminRoute') . '.customers.index');

		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified customer from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Customers", "delete")) {
			Customer::find($id)->delete();

			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.customers.index');
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
		$values = Customer::query()->select($this->listing_cols)->whereNull('deleted_at');

		$out = Datatables::of($values->orderBy('id','desc'))->addColumn('action', function ($user) {
			return '';
		})->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Customers');

		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) {
				$col = $this->listing_cols[$j];

				if($fields_popup[$col] != null && Str::startsWith($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i]->$col = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i]->$col);
				}
				if($col == $this->view_col) {
					$data->data[$i]->$col = '<a href="'.url(config('laraadmin.adminRoute') . '/customers/'.$data->data[$i]->id).'">'.$data->data[$i]->$col.'</a>';
				}

				// else if($col == "author") {
				//    $data->data[$i]->$col;
				// }
			}

			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("Customers", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/customers/'.$data->data[$i]->id.'/edit').'" class="btn btn-warning btn-xs" style=""><i class="fa fa-edit"></i></a>';
				}

				if(Module::hasAccess("Customers", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.customers.destroy', $data->data[$i]->id], 'method' => 'delete', 'style'=>'display:inline']);
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

		Excel::import(new CustomersImport($columnMappings,$request->contact_source_id,$request->activity_id), $filePath);


		return redirect()->back()->with('success', 'Contacts imported successfully.');
		// } catch (\Exception $e) {
		// 	// Handle any import errors
		// 	return redirect()->back()->with('error', 'An error occurred during import. Please check your file and try again.');
		// } finally {
		// 	// Remove the temporary file
		// 	unlink($filePath);
		// }
	}

	public function retarget()
	{
		return view('la.marketing.retarget');
	}

	public function retargetResults()
	{
		$values = Customer::query()->select($this->listing_cols)->whereNull('deleted_at');

		$from =request()->from;
		$to =request()->to;
		$activity_id = request()->activity_id;
        $interest_id = request()->interest_id;


		$values = $values->whereHas('invoices', function ($query) use ($from, $to, $activity_id,$interest_id) {
			return $query->where('activity_id', $activity_id)
                        ->when(($from && $to),function($query) use($from, $to){
                            $query->whereBetween('invoice_date', [$from, $to]);
                        });
                        // ->when($interest_id,function($query) use($interest_id){
                        //     $query->where('interest_id', $interest_id);
                        // });


		})->get();
		return response()->json($values);

	}

	public function addInvoice(Request $request)
	{
		$validator = Validator::make($request->all(), [

			'invoice' => [
				'required',
				'array',
				'min:1',
			],
			'invoice.invoice_number' => 'required|string',
			'invoice.invoice_date' => 'required|date',
			'invoice.total_amount' => 'required|numeric',
			'invoice.amount_paid' => 'required|numeric',
			'invoice.debt' => 'required|numeric',
			'invoice.description' => 'required|string',
			'invoice.status' => 'required|string',
			'invoice.customer_id'=>'required',
		]);

		if ($validator->fails()) {
			return redirect()
				->back()
				->withErrors($validator)
				->withInput();
		}


        $dataInvoice = $request->invoice;
        $dataInvoice['created_by'] = auth()->user()->context_id;

        $invoice = Invoice::create($dataInvoice);

        //points
        $addPointsService = new PointAdditionService();
        $addPointsService->addPoints($invoice->customer_id,$invoice->activity_id,$invoice->interest_id,$invoice->amount_paid);

        if($request->next_reorder_reminder)
        {
            ReorderReminder::create([
                "customer_id" => $invoice->customer_id,
                "invoice_id"  => $invoice->id,
                "reminder_date" => $request->next_reorder_reminder,
            ]);
        }

		return redirect()->back();

	}

    public function addReminder(Request $request)
    {
        $validator = Validator::make($request->all(), [

			'reminder' => [
				'required',
				'array',
				'min:1',
			],
			'reminder.activity_id' => 'required',
			'reminder.reminder_date' => 'required|date',
            'reminder.expected_amount'=>'required',
			'reminder.customer_id'=>'required',
		]);

		if ($validator->fails()) {
			return redirect()
				->back()
				->withErrors($validator)
				->withInput();
		}


        $data = $request->reminder;

        $invoice = ReorderReminder::create($data);



		return redirect()->back();
    }

	public function postRetargetResults(Request $request)
	{
		$old_activity = Activate::find($request->activity_id);
		$new_activity = Activate::find($request->new_activity_id);
        $new_sub_activity = Interest::find($request->new_interest_id);
		$name = "إعادة استهداف ({$old_activity->name} إلي {$new_activity->name}) (فرعي: {$new_sub_activity->name}) ";
		//Create Compaign
        $campaign_id = request()->campaign_id;
        if($campaign_id)
        {
            $campaign = Campaign::find($campaign_id);
            $name = "تم اضافته الي حملة الاستهداف ". "( $campaign )". "بنجاح";
        }else
        {
            $campaign = Campaign::create([
                'name'=>$name
            ]);
        }


		//Create lead accounts

		foreach ($request->ids as $id) {
			$customer = Customer::find($id);
			$contact =  Contact::create([
                'name' => $customer->name,
                'mobile' => $customer->mobile,
                'gender' => $customer->gender,
                'email' => $customer->email,
                'contact_source_id' => $customer->contact_source_id,
                'city_id' => $customer->city_id,
                'area_id' => $customer->area_id,
                'job_title_id' => $customer->job_title_id,
                'industry_id' => $customer->industry_id,
                'major_id' => $customer->major_id,
                'created_by' => $customer->created_by,
                'mobile2' => $customer->mobile2,
                'company_name' => $customer->company_name,
                'notes' => $customer->notes,
				'activity_id'=>$request->new_activity_id,
                'interest_id'=>$request->new_interest_id,
				'campaign_id'=>$campaign->id,
				'customer_id'=>$customer->id,
            ]);
		}

		return response()->json(['success'=>true,'name'=>$name]);
	}

}
