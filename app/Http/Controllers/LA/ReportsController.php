<?php

/**
 * Controller genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Http\Controllers\LA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Activate;
use App\Models\Branch;
use App\Models\Employee;
use App\Models\Employee_target;
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
use App\Models\Invoice;
use Carbon\Carbon;

class ReportsController extends Controller
{

    public $month_format = 'M-Y';
    public function salesReport(Request $request)
    {
        $year_month = [];
        
        $currentYear = date('Y'); // Get the current year
        
        // Start from January of the current year
        $date = Carbon::create($currentYear, 1, 1);
        
        for ($i = 1; $i <= date('n'); $i++) {
            $year_month[$date->format('Y-m')] = $date->format($this->month_format);
            $date->addMonth();
        }
        return view('reports.employee-sales', ['year_month' => $year_month]);
    }



    public function ajaxEmployeesByBranch(Request $request)
    {
        return response()->json(Employee::where("branch_id", $request->branch_id)->get()->toArray());
    }

    public function getEmployeeSalesReport(Request $request)
    {
        $employees = Employee::when($request->branch, function ($query) use ($request) {
            return $query->where('branch_id', $request->branch);
        })->get();
        // dd($employees);
        $reportData = [];

        foreach ($employees as $index=>$employee) {
            // Get the target for the current employee and year
            $target = Employee_target::where('employee_id', $employee->id)
                ->where('month', Carbon::create($request->month)->format('M-Y'))
                ->sum('target_amount');
                
            // $targetCalls = Employee_target::where('employee_id', $employee->id)
            //     ->where('month', $request->month)
            //     ->sum('target_calls');
            // $actualCalls = Meeting::where('employee_id', $employee->id)
            //     ->where('month', $request->month)
            //     ->sum('target_calls');

            // Get the actual total amount for invoices created by the current employee and year
            $actual = Invoice::where('created_by', $employee->id)
                ->where(DB::raw('DATE_FORMAT(invoice_date, "%Y-%m")'), $request->month)
                ->sum('total_amount');

            $uniqueCustomerCount = Invoice::where('created_by', $employee->id)
				->where(DB::raw('DATE_FORMAT(invoice_date, "%Y-%m")'), $request->month)
				->distinct('customer_id')
				->count();

            // Calculate the margin percentage
            $margin = ($actual > 0 && $target > 0) ? ($actual / $target) * 100 : 0;

            // Create a data entry for the report
            $reportData[] = [
                'employee' => $employee->name, // Replace 'name' with the actual column name in your Employee model
                'target' => $target,
                'actual' => $actual,
				'customers_count' => $uniqueCustomerCount,
                'margin' =>  number_format($margin, 2) . "%",
                'branch' => Branch::find($employee->branch_id)->name ?? "", // You can add the year if needed
            ];
        }

        return response()->json($reportData);
    }

    public function branchSalesReport(Request $request)
    {



        $year_month = [];

        $currentYear = date('Y'); // Get the current year

        // Start from January of the current year
        $date = Carbon::create($currentYear, 1, 1);

        for ($i = 1; $i <= date('n'); $i++) {
            $year_month[$date->format('Y-m')] = $date->format($this->month_format);
            $date->addMonth();
        }
        return view('reports.branch-sales', ['year_month' => $year_month]);
    }

    public function getBranchSalesReport(Request $request)
    {
        $branches = Branch::all();
        $reportData = [];
        foreach ($branches as $branch) {
            $employees = Employee::where('branch_id', $branch->id)->get();

            $data = [
                'branch' => $branch->name, // Replace 'name' with the actual column name in your Employee model
                'target' => 0,
                'actual' => 0,
            ];

            foreach ($employees as $employee) {
                // Get the target for the current employee and year
                $target = Employee_target::where('employee_id', $employee->id)
                    ->where('month', $request->month)
                    ->sum('target_amount');

                // Get the actual total amount for invoices created by the current employee and year
                $actual = Invoice::where('created_by', $employee->id)
                    ->where(DB::raw('DATE_FORMAT(invoice_date, "%Y-%m")'), $request->month)
                    ->sum('total_amount');

                // Calculate the margin percentage
                $margin = ($actual > 0) ? ($actual / $target) * 100 : 0;
                $data['target'] += $target;
                $data['actual'] += $actual;
                // Create a data entry for the report

            }
            $margin = ($data['actual'] > 0 && $data['target'] > 0) ? ($data['actual'] / $data['target']) * 100 : 0;
            $data['margin'] = number_format($margin, 0) . "%";
            $data['target'] = number_format($data['target'],0);
            $data['actual'] = number_format($data['actual'],0);
            $reportData[] = $data;
        }


        return response()->json($reportData);
    }

    public function activitySalesReport()
    {
        return view('reports.subactivity-sales');
    }

    public function getActivitySalesReport()
    {
        $from = request()->from;
        $to = request()->to;
        $activity_id = request()->activity_id;
        $interest_id = request()->interest_id;
        $reportData = [];
        if ($interest_id) {
            $invoices = Invoice::where('activity_id', $activity_id)
                ->where('interest_id', $interest_id)
                ->when(($from != "" && $to != ""), function ($query) use ($from, $to) {
                    return $query->whereBetween('invoice_date', [$from, $to]);
                })->get();
            $reportData[] = [
                'activity' => Activate::find($activity_id)->name ?? "",
                'sub_activity' => Interest::find($interest_id)->name ?? "",
                'total_sales' => number_format($invoices->sum('total_amount'),0),
                'paid_amount' => number_format($invoices->sum('amount_paid'),0),
                'remaining_amounts' => number_format($invoices->sum('total_amount') - $invoices->sum('amount_paid'),0),
            ];
        } elseif ($activity_id && !$interest_id) {
            $invoices = Invoice::where('activity_id', $activity_id)
                ->when(($from != "" && $to != ""), function ($query) use ($from, $to) {
                    return $query->whereBetween('invoice_date', [$from, $to]);
                })->get();
            $reportData[] = [
                'activity' => Activate::find($activity_id)->name ?? "",
                'sub_activity' => "",
                'total_sales' => number_format($invoices->sum('total_amount'),0),
                'paid_amount' => number_format($invoices->sum('amount_paid'),0),
                'remaining_amounts' => number_format($invoices->sum('total_amount') - $invoices->sum('amount_paid'),0),
            ];
        } else {
            $activites = Activate::all();
            foreach ($activites as $activity) {
                $invoices = Invoice::where('activity_id', $activity->id)
                    ->when(($from != "" && $to != ""), function ($query) use ($from, $to) {
                        return $query->whereBetween('invoice_date', [$from, $to]);
                    })->get();

                $reportData[] = [
                    'activity' => $activity->name ?? "",
                    'sub_activity' => "",
                    'total_sales' => number_format($invoices->sum('total_amount'),0),
                    'paid_amount' => number_format($invoices->sum('amount_paid'),0),
                    'remaining_amounts' => number_format($invoices->sum('total_amount') - $invoices->sum('amount_paid'),0),
                ];
            }
        }
        return response()->json($reportData);
    }



    public function subActivitySalesReport()
    {
    }
}
