<?php

/**
 * Controller genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Http\Controllers\LA;

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
use App\Models\Employee;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportController extends Controller
{

    public function fetchExcelColumns(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls',
        ]);

        // Read the Excel file to fetch column names
        $excelColumns = [];

        $filePath = $request->file('excel_file')->getRealPath();
        $spreadsheet = IOFactory::load($filePath);
        $worksheet = $spreadsheet->getActiveSheet();
        $highestColumn = $worksheet->getHighestColumn();

        $highestColumnNumber = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

		for ($colNumber = 1; $colNumber <= $highestColumnNumber; $colNumber++) {
			$col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colNumber);
			$excelColumns[] = $worksheet->getCell($col . '1')->getValue();
		}

        // You will need to provide data for $contactFields and $lookupTables
        if($request->type == 'customer')
        {
            $contactFields = [
                'name' => 'Name',
                'mobile' => 'Mobile',
                'mobile2' => 'Mobile 2',
                'email' => 'Email',
                'company_name' => 'Company Name',
                'city_id' => 'City',
                'area_id' => 'Area',
                'contact_source_id' => 'Contact Source',
                'job_title_id' => 'Job Title ID',
                'industry_id' => 'Industry ID',
                'major_id' => 'Major ID',
                'notes' => 'Notes',
                'gender' => 'Gender',
            ];
        }else{
            $contactFields = [
                'name' => trans('admin.Name'),
                'mobile' => trans('admin.Mobile'),
                'mobile2' => trans('admin.Mobile 2'),
                'email' => trans('admin.Email'),
                'company_name' => trans('admin.Company Name'),
                'city_id' => trans('admin.City'),
                'area_id' => trans('admin.Area'),
                'contact_source_id' => trans('admin.Contact Source'),
                'job_title_id' => trans('admin.Job Title ID'),
                'industry_id' => trans('admin.Industry ID'),
                'major_id' => trans('admin.Major ID'),
                'notes' => trans('admin.Notes'),
                'gender' => trans('admin.Gender'),
                'is_trashed' => 'Is Trashed',
                'birth_date' => trans('admin.Birth Date'),
                'national_id' => trans('admin.National ID'),
                'code' => trans('admin.Code'),
                'is_active' => 'Is Active',
            ];

        }




        $view = View::make('partials.excel_columns', compact('excelColumns', 'contactFields'));

        return $view;
    }

}
