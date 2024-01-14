<?php
/**
 * Controller genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Http\Controllers\LA;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Customer;
use App\Models\Meeting;
use App\Models\Employee;
use App\Models\Employee_target;
use App\Models\ReorderReminder;
use Carbon\Carbon;
use Dwij\Laraadmin\Models\LAConfigs;

/**
 * Class DashboardController
 * @package App\Http\Controllers
 */
class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public $images=[];
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        $user=\Auth()->user();
        $target= Employee_target::where("employee_id",$user->context_id)->where("month",date("Y-m"))->first();
        $did_amount=Meeting::where("created_by",$user->context_id)->sum("revenue");
        $did_meetings=Meeting::where("created_by",$user->context_id)->count();
        $emps=[];
        if ($user->roles[0]['view_dept']) {
            $emps=Employee::where("dept",\Auth()->user()->employee->dept)->pluck('id')->toArray();
        }
        if ($user->roles[0]['view_data']) {
            $emps=[$user->context_id];
        }
        //contacts
        $contacts=Contact::get();
        //follow today
        $follow_today=Meeting::whereHas("notes",function($q){
                $q->whereRaw(\DB::raw("follow_date=CURDATE()"));
        });
        $first_day=date("Y-m-")."01";
        //in and out calls today
        $calls_in_today=Meeting::where("type","call")
                ->where("meeting_place","in")->whereRaw(\DB::raw("meeting_date=CURDATE()"));
        $calls_out_today=Meeting::where("type","call")
                ->where("meeting_place","out")->whereRaw(\DB::raw("meeting_date=CURDATE()"));
        //in and out call this month
        $calls_in_month=Meeting::where("type","call")
                ->where("meeting_place","in")->whereRaw(\DB::raw("meeting_date>='$first_day'"));
        $calls_out_month=Meeting::where("type","call")
                ->where("meeting_place","out")->whereRaw(\DB::raw("meeting_date>='$first_day'"));
        //in and out meetings today
        $meetings_in_today=Meeting::where("type","meeting")
                ->where("meeting_place","in")->whereRaw(\DB::raw("meeting_date=CURDATE()"));
        $meetings_out_today=Meeting::where("type","meeting")
                ->where("meeting_place","out")->whereRaw(\DB::raw("meeting_date=CURDATE()"));
        //in and out meetings this month
        $meetings_in_month=Meeting::where("type","meeting")
                ->where("meeting_place","in")->whereRaw(\DB::raw("meeting_date>='$first_day'"));
        $meetings_out_month=Meeting::where("type","meeting")
                ->where("meeting_place","out")->whereRaw(\DB::raw("meeting_date>='$first_day'"));
        //top client sources
        $sources = \App\Models\Contact_source::withCount(['contacts'=>function($q) use ($emps){
            $q->whereNull("deleted_at");
            if(count($emps)>0)
                $q->whereIn("created_by",$emps);
        }])->having("contacts_count",">",0)->orderBy("contacts_count","desc")->take(5)->get();
        //top cities
        $cities = \App\Models\City::withCount(['contacts'=>function($q) use ($emps){
            $q->whereNull("deleted_at");
            if(count($emps)>0)
                $q->whereIn("created_by",$emps);
        }])->having("contacts_count",">",0)->orderBy("contacts_count","desc")->take(5)->get();
        //top areas
        $areas = \App\Models\Area::withCount(['contacts'=>function($q) use ($emps){
            $q->whereNull("deleted_at");
            if(count($emps)>0)
                $q->whereIn("created_by",$emps);
        }])->having("contacts_count",">",0)->orderBy("contacts_count","desc")->take(5)->get();
        //top 5 intersets
        $interests = \App\Models\Interest::withCount(['meetings'=>function($q) use ($emps){
            $q->whereNull("deleted_at");
            if(count($emps)>0)
                $q->whereIn("created_by",$emps);
        }])->having("meetings_count",">",0)->orderBy("meetings_count","desc")->take(5)->get();
        //top 5 employees
        $employees = \App\Models\Employee::withCount(['meetings'=>function($q) use ($emps){
            $q->whereNull("deleted_at");
            if(count($emps)>0)
                $q->whereIn("created_by",$emps);
        }])->having("meetings_count",">",0)->orderBy("meetings_count","desc")->take(5)->get();
        if (count($emps)>0) {
            $contacts->whereIn("created_by",$emps);
            $follow_today->whereIn("created_by",$emps);
            $calls_in_today->whereIn("created_by",$emps);
            $calls_out_today->whereIn("created_by",$emps);
            $calls_in_month->whereIn("created_by",$emps);
            $calls_out_month->whereIn("created_by",$emps);
            $meetings_in_today->whereIn("created_by",$emps);
            $meetings_out_today->whereIn("created_by",$emps);
            $meetings_in_month->whereIn("created_by",$emps);
            $meetings_out_month->whereIn("created_by",$emps);
        }

        $todayReminders = ReorderReminder::whereDate('reminder_date',Carbon::today())->count();
        $monthReminders = ReorderReminder::whereYear('reminder_date', Carbon::now()->year)
        ->whereMonth('reminder_date', Carbon::now()->month)
        ->count();
        $mostSalesEmployees = Employee::whereHas('invoices')
                    ->withSum('invoices', 'total_amount')
                    ->orderBy('invoices_sum_total_amount', 'desc')
                    ->limit(10)
                    ->get();

        $mostSalesBranches = Branch::join('employees', 'branches.id', '=', 'employees.branch_id')
                    ->join('invoices', 'employees.id', '=', 'invoices.created_by')
                    ->select('branches.*')
                    ->selectRaw('SUM(invoices.total_amount) as total_sales')
                    ->groupBy('branches.id','branches.deleted_at','branches.name')
                    ->orderByDesc('total_sales')
                    ->get();


        $customers = Customer::count();
        $contacts_count=$contacts->count();
        $follow_today_count=$follow_today->count();
        $calls_in_today=$calls_in_today->count();
        $calls_out_today=$calls_out_today->count();
        $calls_in_month=$calls_in_month->count();
        $calls_out_month=$calls_out_month->count();
        $meetings_in_today=$meetings_in_today->count();
        $meetings_out_today=$meetings_out_today->count();
        $meetings_in_month=$meetings_in_month->count();
        $meetings_out_month=$meetings_out_month->count();
        return view('la.dashboard',  compact('contacts_count','follow_today_count',
                'calls_in_today','calls_out_today', 'calls_in_month','calls_out_month',
                'meetings_in_today','meetings_out_today', 'meetings_in_month','meetings_out_month',
                'sources','interests','cities','areas','employees', 'target', 'did_amount','did_meetings','todayReminders',
                'monthReminders','customers','mostSalesEmployees','mostSalesBranches'));
    }



    public function general_settings(){

        $configs = LAConfigs::getAll();
        return View('la.la_configs.general_settings', [
                'configs' => $configs,
        ]);
    }


    public function store_general_settings(Request $request){
         $all = $request->except('_token');
        foreach(['end_date', 'max_users', 'whatsapp_instance', 'whatsapp_token'] as $key) {
                if(!isset($all[$key])) {
                        $all[$key] = 0;
                } else {
                        $all[$key] = $all[$key];
                }
        }


        //return $all;
        foreach($all as $key => $value) {
                if(in_array($key,$this->images))
                {
                        if (!empty($request->$key))
                                $value = $this->uploadFile($request->$key);
                }
                LAConfigs::where('key', $key)->updateOrInsert(['key' => $key],['value' => $value]);
                
        }


        return redirect()->back();
    }


}
