<?php 

 use App\Http\Controllers\LA\BranchesController;

 use App\Http\Controllers\LA\Saved_RepliesController;

 use App\Http\Controllers\LA\Lead_cteagoriesController;

 use App\Http\Controllers\LA\AttachmentsController;

 use App\Http\Controllers\LA\CustomersController;


 use App\Http\Controllers\LA\ActivatesController;

 use App\Http\Controllers\LA\NotificationsController;

 use App\Http\Controllers\LA\Employee_targetsController;

 use App\Http\Controllers\LA\MajorsController;

 use App\Http\Controllers\LA\IndustriesController;

 use App\Http\Controllers\LA\Job_titlesController;

 use App\Http\Controllers\LA\Meeting_notesController;

 use App\Http\Controllers\LA\MeetingsController;

 use App\Http\Controllers\LA\ContactsController;

 use App\Http\Controllers\LA\Contact_categoriesController;

 use App\Http\Controllers\LA\AreasController;

 use App\Http\Controllers\LA\CitiesController;
 use App\Http\Controllers\LA\CountriesController;

 use App\Http\Controllers\LA\Contact_sourcesController;

 use App\Http\Controllers\LA\InterestsController;


use App\Http\Controllers\HomeController;
use App\Http\Controllers\LA\CampaignsController;
use App\Http\Controllers\LA\UploadsController;
use App\Http\Controllers\LA\DashboardController;
use App\Http\Controllers\LA\UserController;
use App\Http\Controllers\LA\RolesController;
use App\Http\Controllers\LA\PermissionsController;
use App\Http\Controllers\LA\DepartmentsController;
use App\Http\Controllers\LA\EmployeesController;
use App\Http\Controllers\LA\ImportController;
use App\Http\Controllers\LA\OrganizationsController;
use App\Http\Controllers\LA\PointsSettingController;
use App\Http\Controllers\LA\ReportsController;
use App\Http\Controllers\LA\UsersController;
use App\Http\Controllers\LA\MessagesController;

/* ================== Homepage ================== */
//Route::get('/', [HomeController::class, 'index']);
//Route::get('/home', [HomeController::class, 'index']);
Auth::routes();

/* ================== Access Uploaded Files ================== */
Route::get('files/{hash}/{name}', [UploadsController::class, 'get_file']);

/*
|--------------------------------------------------------------------------
| Admin Application Routes
|--------------------------------------------------------------------------
*/

$as = "";
if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() >= 5.3) {
	$as = config('laraadmin.adminRoute').'.';

	// Routes for Laravel 5.3
	Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class,'logout']);
}

Route::middleware(['auth','ActivePackage'])->name($as)->group(function () {



	Route::resource(config('laraadmin.adminRoute') . '/la_configs', App\Http\Controllers\LA\LAConfigController::class)->middleware('permission:ADMIN_PANEL');

    Route::get(config('laraadmin.adminRoute') . '/general_settings', [DashboardController::class, 'general_settings'])->middleware('permission:ADMIN_PANEL');
    Route::post(config('laraadmin.adminRoute') . '/general_settings', [DashboardController::class, 'store_general_settings'])->name('general_settings.store')->middleware('permission:ADMIN_PANEL');


	/* ================== Dashboard ================== */

	Route::get(config('laraadmin.adminRoute'),  [DashboardController::class, 'index']);
	Route::get(config('laraadmin.adminRoute'). '/dashboard', [DashboardController::class, 'index']);

	/* ================== Users ================== */
	Route::resource(config('laraadmin.adminRoute') . '/users', UsersController::class);
	Route::get(config('laraadmin.adminRoute') . '/user_dt_ajax', [UsersController::class,'dtajax']);

	/* ================== Uploads ================== */
	Route::resource(config('laraadmin.adminRoute') . '/uploads', UploadsController::class);
	Route::post(config('laraadmin.adminRoute') . '/upload_files', [UploadsController::class,'upload_files']);
	Route::get(config('laraadmin.adminRoute') . '/uploaded_files', [UploadsController::class,'uploaded_files']);
	Route::post(config('laraadmin.adminRoute') . '/uploads_update_caption', [UploadsController::class,'update_caption']);
	Route::post(config('laraadmin.adminRoute') . '/uploads_update_filename', [UploadsController::class,'update_filename']);
	Route::post(config('laraadmin.adminRoute') . '/uploads_update_public', [UploadsController::class,'update_public']);
	Route::post(config('laraadmin.adminRoute') . '/uploads_delete_file', [UploadsController::class,'delete_file']);

	/* ================== Roles ================== */
	Route::resource(config('laraadmin.adminRoute') . '/roles', RolesController::class);
	Route::get(config('laraadmin.adminRoute') . '/role_dt_ajax', [RolesController::class,'dtajax']);
	Route::post(config('laraadmin.adminRoute') . '/save_module_role_permissions/{id}', [RolesController::class,'save_module_role_permissions']);

	/* ================== Permissions ================== */
	Route::resource(config('laraadmin.adminRoute') . '/permissions', PermissionsController::class);
	Route::get(config('laraadmin.adminRoute') . '/permission_dt_ajax', [PermissionsController::class,'dtajax']);
	Route::post(config('laraadmin.adminRoute') . '/save_permissions/{id}', [PermissionsController::class,'save_permissions']);

	/* ================== Departments ================== */
	Route::resource(config('laraadmin.adminRoute') . '/departments', DepartmentsController::class);
	Route::get(config('laraadmin.adminRoute') . '/department_dt_ajax', [DepartmentsController::class,'dtajax']);

	/* ================== Employees ================== */
	Route::resource(config('laraadmin.adminRoute') . '/employees', EmployeesController::class);
	Route::get(config('laraadmin.adminRoute') . '/employee_dt_ajax', [EmployeesController::class,'dtajax']);
    Route::get(config('laraadmin.adminRoute') . '/ajax/employees-select', [EmployeesController::class,'ajaxEmployeesSelect'])->name('employees.ajax');
	Route::post(config('laraadmin.adminRoute') . '/change_password/{id}', [EmployeesController::class,'change_password']);
	Route::get(config('laraadmin.adminRoute') . '/get_employees_by_dept/{dept}', [EmployeesController::class,'get_employees_by_dept']);

	Route::post(config('laraadmin.adminRoute') . 'import/fetch-excel-columns', [ImportController::class,'fetchExcelColumns'])->name('import.fetch.excel.columns');


	/* ================== Organizations ================== */
	Route::resource(config('laraadmin.adminRoute') . '/organizations', OrganizationsController::class);
	Route::get(config('laraadmin.adminRoute') . '/organization_dt_ajax', [OrganizationsController::class,'dtajax']);

	Route::resource(config('laraadmin.adminRoute') . '/backups', BackupsController::class);
	Route::get(config('laraadmin.adminRoute') . '/backup_dt_ajax', [BackupsController::class,'dtajax']);
	Route::post(config('laraadmin.adminRoute') . '/create_backup_ajax', [BackupsController::class,'create_backup_ajax']);
	Route::get(config('laraadmin.adminRoute') . '/downloadBackup/{id}', [BackupsController::class,'downloadBackup']);




	/* ================== Interests ================== */
	Route::resource(config('laraadmin.adminRoute') . '/interests', InterestsController::class);
	Route::get(config('laraadmin.adminRoute') . '/interest_dt_ajax', [InterestsController::class,'dtajax']);

    Route::get(config('laraadmin.adminRoute') . '/getAjaxInterests', [InterestsController::class,'getAjaxInterests'])->name("interests.ajax");


	/* ================== Contact_sources ================== */
	Route::resource(config('laraadmin.adminRoute') . '/contact_sources', Contact_sourcesController::class);
	Route::get(config('laraadmin.adminRoute') . '/contact_source_dt_ajax', [Contact_sourcesController::class,'dtajax']);

	/* ================== Cities ================== */
	Route::resource(config('laraadmin.adminRoute') . '/cities', CitiesController::class);
	Route::get(config('laraadmin.adminRoute') . '/city_dt_ajax', [CitiesController::class,'dtajax']);


	/* ================== Countries ================== */
	Route::resource(config('laraadmin.adminRoute') . '/countries', CountriesController::class);
	Route::get(config('laraadmin.adminRoute') . '/country_dt_ajax', [CountriesController::class,'dtajax']);


	/* ================== Areas ================== */
	Route::resource(config('laraadmin.adminRoute') . '/areas', AreasController::class);
	Route::get(config('laraadmin.adminRoute') . '/area_dt_ajax', [AreasController::class,'dtajax']);
	Route::get(config('laraadmin.adminRoute') . '/get_areas_by_city/{city_id}', [AreasController::class,'get_areas_by_city']);
	Route::get(config('laraadmin.adminRoute') . '/ajax_get_areas_by_city', [AreasController::class,'ajax_get_areas_by_city'])->name('areas.ajax');


	/* ================== Contact_categories ================== */
	Route::resource(config('laraadmin.adminRoute') . '/contact_categories', Contact_categoriesController::class);
	Route::get(config('laraadmin.adminRoute') . '/contact_category_dt_ajax', [Contact_categoriesController::class,'dtajax']);

	/* ================== Contacts ================== */
    Route::get(config('laraadmin.adminRoute') . '/contacts/export',[ContactsController::class,'exportContactsView']);

    Route::get(config('laraadmin.adminRoute') . '/contacts/go',[ContactsController::class,'goToContact'])->name('contacts.go');
    Route::post(config('laraadmin.adminRoute') . '/export-contacts',[ContactsController::class,'exportContacts'])->name('reports.export.contacts');
	Route::resource(config('laraadmin.adminRoute') . '/contacts', ContactsController::class);
	Route::post(config('laraadmin.adminRoute') . '/change_status', [ContactsController::class,'changeStatus'])->name('lead.status.change');
	Route::post(config('laraadmin.adminRoute') . '/filter-data', [ContactsController::class,'getfilteredData'])->name('contacts.ajax.filter');
	Route::post(config('laraadmin.adminRoute') . '/assign', [ContactsController::class,'assignToEmployee'])->name('contacts.ajax.assign');
	Route::post(config('laraadmin.adminRoute') . '/to-trash', [ContactsController::class,'toTrash'])->name('contacts.ajax.to.trash');
	Route::post(config('laraadmin.adminRoute') . '/contacts'. '/delete', [ContactsController::class,'ajaxDelete'])->name('contacts.ajax.to.delete');
	
	Route::post(config('laraadmin.adminRoute') . '/deactivateUsers', [ContactsController::class,'deactivateUsers'])->name('contacts.ajax.to.deactivateUsers');


	Route::resource(config('laraadmin.adminRoute') . '/messages', MessagesController::class);
	Route::get('/get-data-by-reciever-type',[MessagesController::class, 'getRecieverTypeData'])->name('getRecieverTypeData');


    Route::resource(config('laraadmin.adminRoute') .'/pointsSettings', PointsSettingController::class);


	Route::get(config('laraadmin.adminRoute') . '/contact_dt_ajax', [ContactsController::class,'dtajax']);
	Route::get(config('laraadmin.adminRoute') . '/contacts_report', [ContactsController::class,'report_index']);
	Route::post(config('laraadmin.adminRoute') . '/contacts_import', [ContactsController::class,'import'])->name('contacts.import');


	/* ================== Meetings ================== */
	Route::resource(config('laraadmin.adminRoute') . '/meetings', MeetingsController::class);
	Route::get(config('laraadmin.adminRoute') . '/meeting_dt_ajax', [MeetingsController::class,'dtajax']);
	Route::get(config('laraadmin.adminRoute') . '/meetings_report', [MeetingsController::class,'report_index']);

	/* ================== Meeting_notes ================== */
	Route::resource(config('laraadmin.adminRoute') . '/meeting_notes', Meeting_notesController::class);
	Route::get(config('laraadmin.adminRoute') . '/meeting_note_dt_ajax', [Meeting_notesController::class,'dtajax']);

	/* ================== Job_titles ================== */
	Route::resource(config('laraadmin.adminRoute') . '/job_titles', Job_titlesController::class);
	Route::get(config('laraadmin.adminRoute') . '/job_title_dt_ajax', [Job_titlesController::class,'dtajax']);

	/* ================== Industries ================== */
	Route::resource(config('laraadmin.adminRoute') . '/industries', IndustriesController::class);
	Route::get(config('laraadmin.adminRoute') . '/industry_dt_ajax', [IndustriesController::class,'dtajax']);

	/* ================== Majors ================== */
	Route::resource(config('laraadmin.adminRoute') . '/majors', MajorsController::class);
	Route::get(config('laraadmin.adminRoute') . '/major_dt_ajax', [MajorsController::class,'dtajax']);
	Route::get(config('laraadmin.adminRoute') . '/get_majors_by_industry/{industry_id}', [MajorsController::class,'get_majors_by_industry']);
	Route::get(config('laraadmin.adminRoute') . '/ajax_get_majors_by_industry', [MajorsController::class,'ajax_get_majors_by_industry'])->name('majors.ajax');



	/* ================== Employee_targets ================== */
	Route::resource(config('laraadmin.adminRoute') . '/employee_targets', Employee_targetsController::class);
	Route::get(config('laraadmin.adminRoute') . '/employee_target_dt_ajax', [Employee_targetsController::class,'dtajax']);

	/* ================== Notifications ================== */
	Route::resource(config('laraadmin.adminRoute') . '/notifications', NotificationsController::class);
	Route::get(config('laraadmin.adminRoute') . '/notification_dt_ajax', [NotificationsController::class,'dtajax']);

    Route::get(config('laraadmin.adminRoute') . '/today-reminders', [NotificationsController::class,'getTodayReminders']);
    Route::get(config('laraadmin.adminRoute') . '/month-reminders', [NotificationsController::class,'getMonthReminders']);

	/* ================== Activates ================== */
	Route::resource(config('laraadmin.adminRoute') . '/activates', ActivatesController::class);
	Route::get(config('laraadmin.adminRoute') . '/activate_dt_ajax', [ActivatesController::class,'dtajax']);


	/* ================== Customers ================== */
	Route::resource(config('laraadmin.adminRoute') . '/customers', CustomersController::class);
	Route::post(config('laraadmin.adminRoute') . '/customers/invoice/add', [CustomersController::class,'addInvoice'])->name('customers.add.invoice');
	Route::get(config('laraadmin.adminRoute') . '/customers/invoice/{invoice_id}/edit', [CustomersController::class,'editInvoice'])->name('customers.edit.invoice');
	Route::put(config('laraadmin.adminRoute') . '/customers/invoice/{invoice_id}/update', [CustomersController::class,'updateInvoice'])->name('customers.update.invoice');
	Route::post(config('laraadmin.adminRoute') . '/customers/reminder/add', [CustomersController::class,'addReminder'])->name('customers.add.reminder');

	Route::post(config('laraadmin.adminRoute') . '/customers_import', [CustomersController::class,'import'])->name('customers.import');

	Route::get(config('laraadmin.adminRoute') . '/customer_dt_ajax', [CustomersController::class,'dtajax']);


	/*Marketing*/
	Route::get(config('laraadmin.adminRoute') . '/marketing/re-target', [CustomersController::class,'retarget'])->name('marketing.retarget');
	Route::get(config('laraadmin.adminRoute') . '/marketing/re-target-results', [CustomersController::class,'retargetResults'])->name('marketing.retarget.results');
	Route::post(config('laraadmin.adminRoute') . '/marketing/re-target-results', [CustomersController::class,'postRetargetResults'])->name('marketing.post.retarget.results');

    Route::get(config('laraadmin.adminRoute') . '/reports/employee-sales-report',[ReportsController::class,'salesReport']);
    Route::get(config('laraadmin.adminRoute') . '/reports/branch-sales-report',[ReportsController::class,'branchSalesReport']);
    Route::get(config('laraadmin.adminRoute') . '/reports/activitySalesReport',[ReportsController::class,'activitySalesReport']);


    Route::get(config('laraadmin.adminRoute') . '/reports/getActivitySalesReport',[ReportsController::class,'getActivitySalesReport'])->name('generate.sales.activites.report');

    Route::get(config('laraadmin.adminRoute') . '/reports/getBranchSalesReport',[ReportsController::class,'getBranchSalesReport'])->name('generate.sales.branches.report');




    Route::get(config('laraadmin.adminRoute') . '/reports/getEmployeeSalesReport',[ReportsController::class,'getEmployeeSalesReport'])->name('generate.sales.employees.report');

    Route::get(config('laraadmin.adminRoute') . '/reports/get-employees-by-branch',[ReportsController::class,'ajaxEmployeesByBranch'])->name('reports.employees.by.branch');

	// <form method="POST" action="{{ route('filter-customers') }}">
    //         @csrf
    //         <div class="form-group">
    //             <label for="activity_id">Activity ID:</label>
    //             <input type="text" name="activity_id" id="activity_id" class="form-control">
    //         </div>
    //         <div class="form-group">
    //             <label for="from">From Date:</label>
    //             <input type="date" name="from" id="from" class="form-control">
    //         </div>
    //         <div class="form-group">
    //             <label for="to">To Date:</label>
    //             <input type="date" name="to" id="to" class="form-control">
    //         </div>
    //         <div class="form-group">
    //             <button type="submit" class="btn btn-primary">Filter</button>
    //         </div>
    //     </form>



	/* ================== Attachments ================== */
	Route::resource(config('laraadmin.adminRoute') . '/attachments', AttachmentsController::class);
	Route::get(config('laraadmin.adminRoute') . '/attachment_dt_ajax', [AttachmentsController::class,'dtajax']);
	Route::post(config('laraadmin.adminRoute') . '/store-ajax', [AttachmentsController::class,'storeAjax'])->name('attachments.store.ajax');
	Route::post(config('laraadmin.adminRoute') . '/delete-ajax', [AttachmentsController::class,'deleteAjax'])->name('attachments.delete.ajax');

	/* ================== Lead_cteagories ================== */
	Route::resource(config('laraadmin.adminRoute') . '/lead_cteagories', Lead_cteagoriesController::class);
	Route::get(config('laraadmin.adminRoute') . '/lead_cteagory_dt_ajax', [Lead_cteagoriesController::class,'dtajax']);

	/* ================== Saved_Replies ================== */
	Route::resource(config('laraadmin.adminRoute') . '/saved_replies', Saved_RepliesController::class);
	Route::get(config('laraadmin.adminRoute') . '/saved_reply_dt_ajax', [Saved_RepliesController::class,'dtajax']);

	/* ==================  ================== */
	Route::resource(config('laraadmin.adminRoute') . '/campaigns', CampaignsController::class);
	Route::get(config('laraadmin.adminRoute') . '/campaign_dt_ajax', [CampaignsController::class,'dtajax']);

	/* ================== Branches ================== */
	Route::resource(config('laraadmin.adminRoute') . '/branches', BranchesController::class);
	Route::get(config('laraadmin.adminRoute') . '/branch_dt_ajax', [BranchesController::class,'dtajax']);

});
