@extends('la.layouts.app')

@section('contentheader_title', trans('admin.Contacts'))
@section('contentheader_description', trans('admin.Contacts listing'))
@section('section', trans('admin.Contacts'))
@section('sub_section', trans('admin.Listing'))
@section('htmlheader_title', trans('admin.Contacts Listing'))



@section('main-content')

    <style>
        .selected-row {
            background: #daf6e2 !important;
        }

        .selected-row.selected-danger {
            background: #f6dada !important;
        }
    </style>

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


	@if (session('success'))
		<div class="alert alert-success">
			{{ session('success') }}
		</div>
	@endif

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-solid  collapsed-box">
                    <div class="box-header with-border">
                        <h3 class="box-title"> <i class="fa fa-filter"></i> {{ trans('admin.Filters') }}</h3>
                        <div class="box-tools">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body no-padding" style="display:none">
                        <form method="POST" accept-charset="UTF-8" id="filterContactForm" enctype="multipart/form-data"
                            novalidate="novalidate">

                            <div class="modal-body">
                                <div class="box-body" style="direction:rtl;">
                                    <!-- Personal Information -->
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label for="gender">{{ trans('admin.Gender') }}* :</label>
                                            <select class="form-control" required="1" name="gender">
                                                <option value="">{{ trans('admin.All') }}</option>
                                                <option value="Male">{{ trans('admin.Male') }}</option>
                                                <option value="Female">{{ trans('admin.Female') }}</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="name">{{ trans('admin.Name') }}* :</label>
                                            <input class="form-control" data-rule-maxlength="256" required="1"
                                                name="name" type="text">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="mobile">{{ trans('admin.Mobile') }}* :</label>
                                            <input class="form-control" data-rule-maxlength="20" data-rule-unique="true"
                                                field_id="56" adminroute="admin" row_id="0" required="1"
                                                name="mobile" type="text" value="">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="mobile2">{{ trans('admin.Another mobile') }} :</label>
                                            <input class="form-control" data-rule-maxlength="20" name="mobile2"
                                                type="text">
                                        </div>
                                    </div>
                                    <hr style="margin-top:10px;margin-bottom:10px" />

                                    <!-- Identification -->
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label for="national_id">{{ trans('admin.National ID') }}* :</label>
                                            <input class="form-control" data-rule-maxlength="20" data-rule-unique="true"
                                                field_id="56" adminroute="admin" row_id="0" required="1"
                                                name="national_id" type="text" value="">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="email">{{ trans('admin.Email') }} :</label>
                                            <input class="form-control" data-rule-maxlength="256" data-rule-email="true"
                                                name="email" type="email">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="company_name">{{ trans('admin.Company name') }}</label>
                                            <input class="form-control" data-rule-maxlength="256" name="company_name"
                                                type="text">
                                        </div>
                                    </div>
                                    <hr style="margin-top:10px;margin-bottom:10px" />

                                    <!-- Job and Categories -->
                                    <div class="row">

                                        <div class="form-group col-md-3">
                                            <label for="contact_category_id">{{ trans('admin.Category') }}* :</label>
                                            <select class="form-control" required="1" multiple
                                                name="contact_category_id[]" rel="select2">
                                                <option value="">{{ trans('admin.All') }}</option>
                                                @foreach ($contactCategories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="contact_source_id">{{ trans('admin.Contact Source*') }}</label>
                                            <select class="form-control" required="1" name="contact_source_id">
                                                <option value="">{{ trans('admin.All') }}</option>
                                                @foreach ($contactSources as $source)
                                                    <option value="{{ $source->id }}">{{ $source->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="campaign_id">{{ trans('admin.Campaign') }}*</label>
                                            <select class="form-control" required="1" name="campaign_id"
                                                rel="select2">
                                                <option value="">{{ trans('admin.All') }}</option>
                                                @foreach (App\Models\Campaign::all() as $campaign)
                                                    <option value="{{ $campaign->id }}">CP-{{ $campaign->id }} -
                                                        {{ $campaign->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="search_branch_id">الفرع*</label>
                                            <select class="form-control" required="1" id="searchBranchSelect" name="search_branch_id"
                                                rel="select2">
                                                <option value="">{{ trans('admin.All') }}</option>
                                                @foreach (App\Models\Branch::all() as $branch)
                                                    <option value="{{ $branch->id }}">CP-{{ $branch->id }} -
                                                        {{ $branch->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="search_employee_id">الموظف*</label>
                                            <select class="form-control" required="1" id="searchEmployeeSelect" name="search_employee_id"
                                                rel="select2">
                                                <option value="">{{ trans('admin.All') }}</option>

                                            </select>
                                        </div>


                                    </div>

                                    <hr style="margin-top:10px;margin-bottom:10px" />

                                    <!-- Contact Source and Location -->
                                    <div class="row">

                                        <div class="form-group col-md-3">
                                            <label for="city_id">{{ trans('admin.City') }}* :</label>
                                            <select class="form-control" required="1" name="city_id">
                                                <option value="">{{ trans('admin.All') }}</option>
                                                @foreach ($cities as $city)
                                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="area_id">{{ trans('admin.Area') }}* :</label>
                                            <select class="form-control" required="1" name="area_id">
                                                <option value="">{{ trans('admin.All') }}</option>
                                                @foreach ($areas as $area)
                                                    <option value="{{ $area->id }}">{{ $area->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <hr style="margin-top:10px;margin-bottom:10px" />

                                    <!-- Industry and Major -->
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label for="industry_id">{{ trans('admin.Industry') }}* :</label>
                                            <select class="form-control" required="1" name="industry_id">
                                                <option value="">{{ trans('admin.All') }}</option>
                                                @foreach ($industries as $industry)
                                                    <option value="{{ $industry->id }}">{{ $industry->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="major_id">{{ trans('admin.Major') }}* :</label>
                                            <select class="form-control" required="1" name="major_id">
                                                <option value="">{{ trans('admin.All') }}</option>
                                                @foreach ($majors as $major)
                                                    <option value="{{ $major->id }}">{{ $major->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="job_title_id">{{ trans('admin.Job title') }} :</label>
                                            <select class="form-control" required="1" name="job_title_id">
                                                <option value="">{{ trans('admin.All') }}</option>
                                                @foreach ($jobTitles as $jobTitle)
                                                    <option value="{{ $jobTitle->id }}">{{ $jobTitle->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>


                                    </div>
                                    <hr style="margin-top:10px;margin-bottom:10px" />
                                    <hr style="margin-top:10px;margin-bottom:10px" />
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label id="fromDate">تاريخ من</label>
                                            <input type="date" name="from_date" id="fromDate" class="form-control">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label id="fromDate">تاريخ الي</label>
                                            <input type="date" name="to_date" id="toDate" class="form-control">
                                        </div>
                                    </div>

                                    <!-- Activity -->
                                    <div class="row">
                                        @if (auth()->user()->type != 'Employee')
                                            <div class="form-group col-md-3">
                                                <label
                                                    for="assignment_type">{{ trans('admin.Assignment Status') }}*</label>
                                                <select class="form-control" required="1" name="assignment_type">
                                                    <option value="">{{ trans('admin.All') }}</option>
                                                    <option value="assigned">{{ trans('admin.Assigned') }}</option>
                                                    <option value="un-assigned">{{ trans('admin.Not Assigned') }}</option>
                                                </select>
                                            </div>
                                        @endif
                                        <div class="form-group col-md-3">
                                            <label for="activity_id">{{ trans('admin.Activity') }}* :</label>
                                            <select class="form-control" id="searchActivityId" required="1"
                                                name="activity_id">
                                                <option value="">{{ trans('admin.All') }}</option>
                                                @foreach ($activities as $activity)
                                                    <option value="{{ $activity->id }}">{{ $activity->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="activity_id">{{ trans('admin.Interest') }} :</label>
                                            <select class="form-control" id="searchInterestId" required="1"
                                                name="interest_id">
                                                <option value="">{{ trans('admin.All') }}</option>
                                            </select>
                                        </div>
                                        <input type="hidden" value="" id="statusFilter" name="status" />
                                    </div>
                                    <hr style="margin-top:10px;margin-bottom:10px" />

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default"
                                    data-dismiss="modal">{{ trans('admin.Close') }}</button>
                                <input class="btn btn-success" type="submit" value="Apply Filters">
                            </div>
                        </form>
                    </div>

                </div>
            </div>
            <div class="col-md-3">
                @can('Contacts-create')
                    <button type="submit" class="btn bg-olive btn-block margin-bottom " data-toggle="modal"
                        data-target="#AddModal">{{ trans('admin.Add Contact') }}</button>
                    <button type="submit" class="btn bg-purple btn-block margin-bottom " data-toggle="modal"
                        data-target="#ImportModal">{{ trans('admin.Import Excel') }}</button>
                @endcan
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ trans('admin.Folders') }}</h3>
                        <div class="box-tools">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <ul class="nav nav-pills nav-stacked">
                            <li class="status-tap active"><a href="#" onclick="filterByStatus(event,'')"><i
                                        class="fa fa-inbox"></i> {{ trans('admin.All') }}</a></li>
                            <li class="status-tap"><a href="#" onclick="filterByStatus(event,'new')"><i
                                        class="fa fa-inbox"></i> {{ trans('admin.New') }}
                                    <span
                                        class="label label-primary pull-right">{{ $statusCounts['new'] ?? null }}</span></a>
                            </li>
                            <li class="status-tap"><a href="#" onclick="filterByStatus(event,'contacted')"><i
                                        class="fa fa-phone"></i>
                                    {{ trans('admin.Contacted') }} <span
                                        class="label bg-navy pull-right">{{ $statusCounts['contacted'] ?? null }}</span></a>
                            </li>
                            <li class="status-tap"><a href="#" onclick="filterByStatus(event,'qualified')"><i
                                        class="fa fa-filter"></i> {{ trans('admin.Qualified') }} <span
                                        class="label bg-olive pull-right">{{ $statusCounts['qualified'] ?? null }}</span></a>
                            </li>
                            <li class="status-tap"><a href="#" onclick="filterByStatus(event,'converted')"><i
                                        class="fa fa-star"></i>
                                    {{ trans('admin.Converted') }} <span
                                        class="label label-success pull-right">{{ $statusCounts['converted'] ?? null }}</span></a>
                            </li>
                            <li class="status-tap"><a href="#" onclick="filterByStatus(event,'trashed')"><i
                                        class="fa fa-trash-o"></i>
                                    {{ trans('admin.Trash') }} <span
                                        class="label label-danger pull-right">{{ $statusCounts['trashed'] ?? null }}</span></a>
                            </li>
                            <li class="status-tap"><a href="#" onclick="filterByStatus(event,'inactive')"><i
                                        class="fa fa-users"></i>
                                    {{ trans('admin.inactive') }}<span
                                        class="label label-danger pull-right">{{ $statusCounts['inactive'] ?? null }}</span></a>
                            </li>
                        </ul>
                    </div>

                </div>



            </div>

            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ trans('admin.Inbox') }}</h3>
                        <div class="box-tools pull-right">
                            <div class="has-feedback">
                                <input type="text" id="nameFilter" class="form-control input-sm" name="name"
                                    placeholder="{{ trans('admin.Search with Name') }}">
                                <span class="glyphicon glyphicon-search form-control-feedback"></span>

                            </div>
						</div>
						<div class="box-tools pull-right" style="margin-right:30%">
							<div class="has-feedback">
                                <input type="text" id="mobileFilter" class="form-control input-sm" name="mobile"
                                    placeholder="{{ trans('admin.Search with Phone') }}">
                                <span class="glyphicon glyphicon-search form-control-feedback"></span>

                            </div>


                        </div>
                        <div class="box-tools"
                            style="left: 10px;    right: auto;
                        width: 20%;
                        float: left;">
                            <!-- Add the select dropdown for static page limits -->
                            <div class="form-group" style="display: flex;
                            ">
                                <label>عدد النتائج: </label>
                                <select id="staticPageLimit" class="form-control input-sm"
                                    style="    width: 40%;margin-right: 3%;">
                                    <option selected value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                    <option value="200">200</option>

                                </select>
                            </div>


                        </div>

                    </div>

                    <div class="box-body no-padding">
                       <div class="mailbox-controls">
							{!! Form::model(null, ['route' => [config('laraadmin.adminRoute') . '.messages.store' ], 'method'=>'POST', 'id' => 'message-edit-form', 'files'=>true]) !!}
								<select multiple required id="selected-records" name="reciever_id[]" class="form-control" rel="select2">

								</select>


									<label for="notes" class="messagelabel">{{ trans('admin.Message') }} :</label>
									<textarea required class="messagetextarea form-control" placeholder="Enter Messages" cols="30" rows="3" name="message">
									</textarea>
							    <div id="validation-errors" class="alert alert-danger" style="display: none;"></div>
								<input type="hidden" name="reciever_data_type" value="id" >
							
							<button type="button" onclick="validateForm()" class="messagebtn btn btn-success btn-sm ">إرسال 
                            </button>
							{!! Form::close() !!}
							
                        </div>
                        <div class="mailbox-controls">

                            <button type="button" id="selectAll" class="btn btn-default btn-sm checkbox-toggle"><i
                                    class="fa fa-square-o"></i>
                            </button>
                            <div class="btn-group ">
                                <button type="button" class="btn bg-danger btn-sm" data-toggle="modal"
                                    data-target="#trashModal">
                                    <i class="fa fa-trash-o"></i> إزاله للمهملات
                                </button>


                                <button type="button" class="btn bg-olive btn-sm" data-toggle="modal"
                                    data-target="#removeFromTrashModal"><i class="fa fa-recycle"></i> إستعادة من المهملات</button>
                            </div>

                            <div class="btn-group bg-danger">
                                <button type="button" class="btn bg-maroon btn-sm" data-toggle="modal"
                                data-target="#removeModal"><i class="fa fa-remove"></i> إزاله نهائيه</button>
                            </div>

                            <div class="btn-group ">
                                <button type="button" class="btn bg-navy btn-sm" data-toggle="modal"
                                    data-target="#deactivateUsersModel"><i class="fa fa-close"></i> الغاء النشاط </button>
                                <button type="button" class="btn bg-olive btn-sm" data-toggle="modal"
                                    data-target="#activateUsersModel"><i class="fa fa-wrench"></i> اعادة النشاط </button>
                                @if(auth()->user()->type == 'Admin' || auth()->user()->employee->has_branch_access ==1)
								
									<button type="button" class="btn bg-info btn-sm" data-toggle="modal"
										data-target="#assignModal"><i class="fa fa-plus"></i> {{ trans('admin.Assign') }}
									</button>
								
								@endif
                            </div>

                            <button type="button" class="btn bg-orange btn-sm" onclick="refreshResults()"><i
                                    class="fa fa-refresh"></i> إعادة تحميل النتائج </button>
                            <div class="pull-right">
                                <span id="pagination-info" data-current-page="1" data-total-pages="1">0-0/0</span>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm" onclick="loadPreviousPage()"><i
                                            class="fa fa-chevron-left"></i></button>
                                    <button type="button" class="btn btn-default btn-sm" onclick="loadNextPage()"><i
                                            class="fa fa-chevron-right"></i></button>
                                </div>
                            </div>

                        </div>
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-hover table-striped " id="contactTable">
                                <thead>
                                    <th></th>
                                    <th>{{ trans('admin.Status') }}</th>
                                    <th>{{ trans('admin.Name') }}</th>
                                    <th>{{ trans('admin.Phone') }}</th>
                                    <th>{{ trans('admin.Contact source') }}</th>
                                    <th>{{ trans('admin.City') }}</th>
                                    <th>{{ trans('admin.Area') }}</th>
                                    <th>{{ trans('admin.Category') }}</th>
                                    <th>{{ trans('admin.Activity') }}</th>
                                    <th></th>
                                    <th>{{ trans('admin.Employee Name') }}</th>
                                    <th>{{ trans('admin.Date') }}</th>
                                </thead>
                                <tbody>
                                    <tr id="loader" style="display: none;">
                                        <td colspan="5">{{ trans('admin.Loading...') }}</td>
                                    </tr>

                                </tbody>
                            </table>

                        </div>

                    </div>

                    <div class="box-footer no-padding">

                    </div>
                </div>

            </div>

        </div>

    </section>

    @can('Contacts-create')
        <div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">{{ trans('admin.Add Contact') }}</h4>
                    </div>
                    {!! Form::open([
                        'route' => config('laraadmin.adminRoute') . '.contacts.store',
                        'id' => 'contact-add-form',
                        'files' => true,
                    ]) !!}
                    <div class="modal-body">
                        <div class="box-body">


                            @la_input($module, 'customer_id')
                            @la_input($module, 'name')
                            @la_input($module, 'mobile')
                            @la_input($module, 'contact_source_id')
                            <div class="form-group">
                                <label for="activity_id">{{ trans('admin.Activity') }} :</label>
                                <select name="activity_id" class="form-control" id="activitySelect" rel="select2" required>
                                    <option value=""></option>
                                    @foreach ($activities as $activity)
                                        <option value="{{ $activity->id }}">{{ $activity->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" required>
                                <label for="interest_id">{{ trans('admin.Interest') }} :</label>
                                <select name="interest_id" class="form-control" id="interestSelect" rel="select2">

                                </select>
                            </div>
                            <hr />
                            @la_input($module, 'mobile2')
                            @la_input($module, 'national_id')

                            <div class="form-group">
                                <label for="industry_id">{{ trans('admin.Birth Date') }} :</label>
                                <input type="date" name="birth_date" class="form-control" />
                            </div>
                            @la_input($module, 'gender')
                            @la_input($module, 'email')

                            @la_input($module, 'contact_category_id')

                            <div class="form-group">
                                <label for="industry_id">{{ trans('admin.City') }} :</label>
                                <select name="city_id" class="form-control" id="citySelect" rel="select2">
                                    <option value=""></option>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="industry_id">{{ trans('admin.Area') }} :</label>
                                <select name="area_id" class="form-control" id="areaSelect" rel="select2">

                                </select>
                            </div>
                            <div class="form-group">
                                <label for="industry_id">{{ trans('admin.Industry') }} :</label>
                                <select name="industry_id" class="form-control" id="industrySelect" rel="select2">
                                    <option value=""></option>
                                    @foreach ($industries as $industry)
                                        <option value="{{ $industry->id }}">{{ $industry->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="industry_id">{{ trans('admin.Major') }} :</label>
                                <select name="major_id" class="form-control" id="majorSelect" rel="select2">

                                </select>
                            </div>
                            @la_input($module, 'company_name')
                            @la_input($module, 'job_title_id')

                            @la_input($module, 'created_by')
                            @la_input($module, 'notes')

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default"
                            data-dismiss="modal">{{ trans('admin.Close') }}</button>
                        {!! Form::submit(trans('admin.Submit'), ['class' => 'btn btn-success']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        <!-- The modal -->
        <div class="modal fade" id="assignModal" tabindex="-1" role="dialog" aria-labelledby="assignModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="assignModalLabel">{{ trans('admin.Assign Employee') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="branchSelect">{{ trans('admin.Select Branch') }}</label>
                                <select class="form-control" id="branchSelect" rel="select2">
                                    <option value=""></option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="employeeSelect">{{ trans('admin.Select Employee') }}</label>
                                <select class="form-control" id="employeeSelect" rel="select2">


                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ trans('admin.Close') }}</button>
                        <button type="button" class="btn btn-primary"
                            id="assignButton">{{ trans('admin.Assign') }}</button>
                    </div>
                </div>
            </div>
        </div>



        <div class="modal fade" id="removeFromTrashModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-body">
                        <h4 class="text-success text-center">هل أنت متأكد من استعادة جهات الاتصال هذه من المهملات؟
                        </h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ trans('admin.Close') }}</button>
                        <button type="button" class="btn btn-success" id="removeFromTrashButton">إستعادة</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- The modal -->
        <div class="modal fade" id="trashModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-body">
                        <h4 class="text-danger text-center">{{ trans('admin.Are you sure moving these contacts to trash?') }}
                        </h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ trans('admin.Close') }}</button>
                        <button type="button" class="btn btn-danger"
                            id="trashButton">{{ trans('admin.To Trash') }}</button>
                    </div>
                </div>
            </div>
        </div>



		<div class="modal fade" id="removeModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-body">
                        <h4 class="text-danger text-center"> هل انت متأكد من أزالة جهات الأتصال هذه بشكل نهائى ؟
                        </h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ trans('admin.Close') }}</button>
                        <button type="button" class="btn btn-danger"
                            id="removeButton">{{ trans('admin.Remove') }}</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="activateUsersModel" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-body">
                        <h4 class="text-success text-center">هل انت متأكد من اعادة نشاط جهات الاتصال هذه؟
                        </h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ trans('admin.Close') }}</button>
                        <button type="button" class="btn btn-danger" id="activateButton">نعم متأكد</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="deactivateUsersModel" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-body">
                        <h4 class="text-danger text-center">هل انت متأكد من الغاء نشاط جهات الاتصال هذه؟
                        </h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ trans('admin.Close') }}</button>
                        <button type="button" class="btn btn-success" id="deactivateButton">نعم متأكد</button>
                    </div>
                </div>
            </div>
        </div>

    @endcan

    @can('Contacts-create')
        @can('Contact_sources-create')
            @can('Contact_categories-create')
                @can('Cities-create')
                    @can('Areas-create')
                        @can('Job_titles-create')
                            @can('Industries-create')
                                @can('Majors-create')
                                    <div class="modal fade" id="ImportModal" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                            aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">{{ trans('admin.Import Excel') }}</h4>
                                                </div>
                                                {!! Form::open([
                                                    'route' => config('laraadmin.adminRoute') . '.contacts.import',
                                                    'id' => 'contact-add-form',
                                                    'files' => true,
                                                ]) !!}
                                                <div class="modal-body">
                                                    <div class="box-body">
                                                        <div class="form-group col-md-6">
                                                            <label for="contact_source_id">{{ trans('admin.Contact Source*') }}</label>
                                                            <select class="form-control" required="1" name="contact_source_id" rel="select2">
                                                                <option value="">{{ trans('admin.All') }}</option>
                                                                @foreach ($contactSources as $source)
                                                                    <option value="{{ $source->id }}">{{ $source->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="activity_id">{{ trans('admin.Activity') }}* :</label>
                                                            <select class="form-control" required="1" id="importActivity" name="activity_id" rel="select2">
                                                                <option value="">{{ trans('admin.All') }}</option>
                                                                @foreach ($activities as $activity)
                                                                    <option value="{{ $activity->id }}">{{ $activity->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <label for="interest_id">{{ trans('admin.Interest') }}* :</label>
                                                            <select class="form-control" required="1" id="importInterest" name="interest_id"  rel="select2">
                                                                <option value="">{{ trans('admin.All') }}</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group col-md-12">
                                                            <label>{{ trans('admin.1000 records only') }}</label>
                                                            <input name="contacts_file" type="file" id="excel-file" />
                                                            <button type="button" class="mt-1 btn btn-primary" id="fetch-columns">معالجة الملف</button>

                                                        </div>
                                                        {{-- <div class="form-group">
                                                            <label>{{ trans('admin.Import Source') }}</label>
                                                            <input name="import_source" type="text" class="form-control" />
                                                        </div> --}}
                                                        <div id="excel-columns-container"></div>
                                                    </div>
                                                </div>



                                                <!-- Import button -->

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">{{ trans('admin.Close') }}</button>
                                                    {!! Form::submit(trans('admin.Submit'), ['class' => 'btn btn-success']) !!}
                                                </div>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                @endcan
                            @endcan
                        @endcan
                    @endcan
                @endcan
            @endcan
        @endcan
    @endcan

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>




    	<script>
            function validateForm() {
                //e.preventDefault();
                //document.getElementById('message-edit-form').preventDefault();
                
                var selectedRecords = document.getElementById('selected-records');
                var messageTextarea = document.querySelector('.messagetextarea');
                var validationErrors = document.getElementById('validation-errors');

                // Reset previous validation errors
                validationErrors.style.display = 'none';
                validationErrors.innerHTML = '';

                // Validate the selected records
                if (selectedRecords.value.length === 0) {
                    appendError('Please select at least one receiver.');
                }

                // Validate the message textarea
                if (messageTextarea.value.trim() === '') {
                    appendError('Please enter a message.');
                }

                // If there are validation errors, display them
                if (validationErrors.innerHTML !== '') {
                    validationErrors.style.display = 'block';
                    return;
                }

                // If validation passes, submit the form
                document.getElementById('message-edit-form').submit();
            }

            function appendError(message) {
                var validationErrors = document.getElementById('validation-errors');
                var errorMessage = document.createElement('p');
                errorMessage.innerHTML = message;
                validationErrors.appendChild(errorMessage);
            }
        </script>



	<script>
		document.addEventListener("DOMContentLoaded", function() {
		  // Get the mailbox-controls div
		  var mailboxControls = document.querySelector('.mailbox-controls');

		  // Get the select2 span element within mailbox-controls
		  var select2Span = mailboxControls.querySelector('.select2.select2-container');

          var formTextarea = mailboxControls.querySelector('.messagetextarea');
	      var formLable = mailboxControls.querySelector('.messagelabel');
		  var formBtn = mailboxControls.querySelector('.messagebtn');

		  // Check if the element exists before trying to hide it
		  if (select2Span) {
			// Hide the select2 span element
			select2Span.style.display = 'none';

            formTextarea.style.display = 'none';
			formLable.style.display = 'none';
			formBtn.style.display = 'none';

		  }
		});
	 </script>

    <script>
		
		
		
        const filterForm = $('#filterContactForm');
        const contactTable = $('#contactTable tbody');
        const pagination = $('#pagination');
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        const loader = $('#loader');
        const loaderClone = loader.clone();
        const pageInfo = $('#pagination-info');
        const selectElement = $('#selected-records');

        let selectedRecords = [];

        $('#selectAll').click(function() {
            // Toggle the "checked" state of the checkboxes
            $('.record-checkbox').each(function() {
                $(this).prop('checked', !$(this).prop('checked'));
            });

            // Trigger the 'change' event on the checkboxes
            $('.record-checkbox').trigger('change');


            var mailboxControls = document.querySelector('.mailbox-controls');

			// Get the select2 span element within mailbox-controls
			var formTextarea = mailboxControls.querySelector('.messagetextarea');
			var formLable = mailboxControls.querySelector('.messagelabel');
			var formBtn = mailboxControls.querySelector('.messagebtn');
			formTextarea.style.display = 'block';
			formLable.style.display = 'block';
			formBtn.style.display = 'block';

        });

        $('#fetch-columns').click(function() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var formData = new FormData();
            formData.append('excel_file', $('#excel-file')[0].files[0]);
            formData.append('_token', csrfToken);
            $.ajax({
                url: '{{ route('admin.import.fetch.excel.columns') }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    // Display fetched Excel columns to the user
                    $('#excel-columns-container').html(data);

                    // Add column mapping dropdowns here
                    // (user selects which contact field corresponds to each Excel column)
                },
                error: function(xhr, status, error) {
                    // Handle errors (e.g., display error messages)
                    var errors = JSON.parse(xhr.responseText);
                    console.log(errors);
                }
            });
        });


        updateMajorSelect();

        function toggleSelect2Visibility() {

            if (selectedRecords.length > 0) {

                selectElement.next(".select2-container").show();
            } else {
                selectElement.val(null).trigger('change');
                console.log(selectElement.next(".select2-container"));
                selectElement.next(".select2-container").hide();
            }
        }
        toggleSelect2Visibility();

        $('table').on('change', '.record-checkbox', function() {
            const $this = $(this);
            const id = $this.data('id');
            const name = $this.data('name');
            const isChecked = $this.is(':checked');


            var mailboxControls = document.querySelector('.mailbox-controls');

			// Get the select2 span element within mailbox-controls
			var formTextarea = mailboxControls.querySelector('.messagetextarea');
			var formLable = mailboxControls.querySelector('.messagelabel');
			var formBtn = mailboxControls.querySelector('.messagebtn');
			formTextarea.style.display = 'block';
			formLable.style.display = 'block';
			formBtn.style.display = 'block';

            

            if (isChecked) {
                // Add the selected record to the array
                selectedRecords.push({
                    id,
                    name
                });
            } else {
                // Remove the unselected record from the array
                selectedRecords = selectedRecords.filter(record => record.id !== id);
            }

            const options = selectedRecords.map(record => {
                return $('<option>', {
                    selected: true,
                    value: record.id,
                    text: record.name
                })[0]; // [0] is used to get the DOM element from the jQuery object
            });

            selectElement.empty().append(options);
            toggleSelect2Visibility();
        });

        function filterByStatus(e, status) {
            e.preventDefault();
            $('#statusFilter').val(status);

            filterForm.trigger('submit');
        }


        function displayContacts(page, status = '') {
            // Serialize the form data
            const originalFormData = filterForm.serializeArray();
            originalFormData.push({
                name: 'status',
                value: status
            });
            originalFormData.push({
                name: 'limit',
                value: $('#staticPageLimit').val(),
            });

            const formData = originalFormData.filter(field => field.value.trim() !== '');
            console.log(formData);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            loader.show();
            $.ajax({
                type: 'POST',
                url: `{{ route('admin.contacts.ajax.filter') }}?page=${page}`,
                data: formData,
                dataType: 'json',
                success: function(data) {
                    loader.hide();
                    contactTable.empty();
                    const contacts = data.data;
                    contacts.forEach(function(contact) {

                        selectedClass = contact.is_assigned ? 'selected-row' : '';
                        selectedClass += contact.is_trashed ? ' selected-danger' : '';
                        employeeName = contact.is_assigned ?
                            ` ${contact.employee_name}` : '';
                        const newRow = $('<tr class="' + selectedClass + '">');
                        newRow.append(
                            `<td><input type="checkbox" class="record-checkbox" data-id="${contact.id}" data-name="${contact.name}"></td>`
                        );
                        newRow.append(
                            `<td class="mailbox-star"><span class="${contact.status_info.class}">${contact.status_info.status}</span></td>`
                        );
                        newRow.append(
                            `<td class="mailbox-name"><a href="${contact.url}">${contact.name}</a></td>`
                        );
                        newRow.append(
                            `<td class="mailbox-subject"> ${contact.phone}</td>`
                        );
                        newRow.append(
                            `<td class="mailbox-subject"> ${contact.contact_source}</td>`
                        );
                        newRow.append(
                            `<td class="mailbox-subject"> ${contact.city}</td>`
                        );
                        newRow.append(
                            `<td class="mailbox-subject"> ${contact.area}</td>`
                        );
                        newRow.append(
                            `<td class="mailbox-subject"> ${contact.category}</td>`
                        );
                        newRow.append(
                            `<td class="mailbox-subject"> ${contact.activity} <br /> <b>${contact.sub_activity}</b> </td>`
                        );
                        newRow.append(
                            `<td class="mailbox-subject"></td>`
                        );
                        newRow.append(`<td class="mailbox-attachment">${employeeName}</td>`);

                        newRow.append(
                            `<td class="mailbox-date">${contact.human_time}</td>`);


                        contactTable.append(newRow);
                        $('.record-checkbox').each(function() {
                            const id = $(this).data('id');
                            if (selectedRecords.some(record => record.id === id)) {
                                $(this).prop('checked', true);
                            }
                        });
                    });

                    const totalPages = data.paginationInfo.last_page;
                    const currentPage = data.paginationInfo.current_page;
                    const totalRecords = data.paginationInfo.total;
                    const startRecord = (currentPage - 1) * data.paginationInfo.per_page + 1;
                    const endRecord = Math.min(currentPage * data.paginationInfo.per_page, totalRecords);
                    const paginationInfo = `${startRecord}-${endRecord}/${totalRecords}`;


                    pageInfo.attr('data-current-page', currentPage);
                    pageInfo.attr('data-total-pages', totalPages);
                    pageInfo.text(paginationInfo);


                },
                error: function(error) {
                    loader.hide();
                    console.error('Error:', error);
                }
            });
        }

        function refreshResults() {
            filterForm.trigger('submit');
        }

        $('#staticPageLimit').change(function() {
            filterForm.trigger('submit');
        });
		
		
		$('#nameFilter').on('input', function() {
			// Additional logic, if needed
			var inputValue = $(this).val();
			console.log('Input value changed to: ' + inputValue);
			//$('#contactTable').DataTable().search(inputValue).draw();
			// Submit the form
			
			
			// Remove any previous input with the same name
			filterForm.find('input[name="name"]').remove();
			// Append a new hidden input with the name and value
			filterForm.append('<input type="hidden" name="name" value="' + inputValue + '">');
			// Submit the form
			filterForm.trigger('submit');
			
		});
		
		
		$('#mobileFilter').on('input', function() {
			// Additional logic, if needed
			var inputValue = $(this).val();
			console.log('Input value changed to: ' + inputValue);
			//$('#contactTable').DataTable().search(inputValue).draw();
			// Submit the form
			
			
			// Remove any previous input with the same name
			filterForm.find('input[name="mobile"]').remove();
			// Append a new hidden input with the name and value
			filterForm.append('<input type="hidden" name="mobile" value="' + inputValue + '">');
			// Submit the form
			filterForm.trigger('submit');
			
		});




        toggleSelect2Visibility();

        displayContacts(1);

        filterForm.on('submit', function(e) {
            e.preventDefault();
            contactTable.empty();
            contactTable.append(loaderClone);
            loaderClone.show();
            displayContacts(1);
        });

        $('.status-tap').click(function() {
            $(this).addClass('active').siblings().removeClass('active');
        });

        //Pagination

        function getCurrentPage() {

            return parseInt(pageInfo.attr('data-current-page'));
        }

        function getTotalPages() {
            return parseInt(pageInfo.attr('data-total-pages'));
        }

        function navigateToPage(page) {
            const currentPageAttr = getCurrentPage();
            const totalPagesAttr = getTotalPages();


            if (page >= 1 && page <= totalPagesAttr && page !== currentPageAttr) {
                displayContacts(page);
            }
        }

        function loadPreviousPage() {
            const prevToCurrentPage = getCurrentPage() - 1;
            navigateToPage(prevToCurrentPage);
        }

        function loadNextPage() {

            const nextToCurrentPage = getCurrentPage() + 1;
            console.log(nextToCurrentPage);
            navigateToPage(nextToCurrentPage);
        }

        //Assign Action

        $('#assignButton').click(function() {
            const selectedEmployeeId = $('#employeeSelect').val();

            if (!selectedEmployeeId) {
                // Handle the case where no employee is selected
                alert('Please select an employee to assign.');
                return;
            }

            const selectedContactIds = selectedRecords.map(record => record.id);

            // Perform an AJAX request to assign the selected records to the selected employee
            $.ajax({
                type: 'POST',
                url: '{{ route('admin.contacts.ajax.assign') }}', // Replace with the actual route
                data: {
                    employee_id: selectedEmployeeId,
                    contact_ids: selectedContactIds
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        console.log(response.data);
                        // Handle success, e.g., show a success message
                        // Reset the select element and hide the modal
                        selectElement.val(null).trigger('change');
                        selectedRecords.length = 0;
                        $('#assignModal').modal('hide');

                        // Refresh the contact list by triggering the form submission
                        filterForm.trigger('submit');
                    } else {
                        // Handle failure, e.g., show an error message
                        alert('Failed to assign selected records. Please try again.');
                    }
                },
                error: function(error) {
                    // Handle AJAX error, e.g., show an error message
                    alert('An error occurred while assigning records. Please try again later.');
                    console.error('Error:', error);
                }
            });
        });

        $('#trashButton,#removeFromTrashButton').click(function() {


            const selectedContactIds = selectedRecords.map(record => record.id);

            // Perform an AJAX request to assign the selected records to the selected employee
            $.ajax({
                type: 'POST',
                url: '{{ route('admin.contacts.ajax.to.trash') }}', // Replace with the actual route
                data: {
                    contact_ids: selectedContactIds
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        console.log(response.data);

                        selectElement.val(null).trigger('change');
                        selectedRecords.length = 0;
                        $('#trashModal').modal('hide');
                        $('#removeFromTrashModal').modal('hide');

                        filterForm.trigger('submit');
                    } else {
                        // Handle failure, e.g., show an error message
                        alert('Failed to trash selected records. Please try again.');
                    }
                },
                error: function(error) {
                    // Handle AJAX error, e.g., show an error message
                    alert('An error occurred while trashing records. Please try again later.');
                    console.error('Error:', error);
                }
            });
        });
		
		
		$('#removeButton').click(function() {


            const selectedContactIds = selectedRecords.map(record => record.id);

            // Perform an AJAX request to assign the selected records to the selected employee
            $.ajax({
                type: 'POST',
                url: '{{ route('admin.contacts.ajax.to.delete') }}', // Replace with the actual route
                data: {
                    contact_ids: selectedContactIds
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        console.log(response.data);

                        selectElement.val(null).trigger('change');
                        selectedRecords.length = 0;
                        $('#removeModal').modal('hide');

                        filterForm.trigger('submit');
                    } else {
                        // Handle failure, e.g., show an error message
                        alert('Failed to remove selected records. Please try again.');
                    }
                },
                error: function(error) {
                    // Handle AJAX error, e.g., show an error message
                    alert('An error occurred while removing records. Please try again later.');
                    console.error('Error:', error);
                }
            });
        });
		

        $('#deactivateButton,#activateButton').click(function() {


            const selectedContactIds = selectedRecords.map(record => record.id);

            // Perform an AJAX request to assign the selected records to the selected employee
            $.ajax({
                type: 'POST',
                url: '{{ route('admin.contacts.ajax.to.deactivateUsers') }}', // Replace with the actual route
                data: {
                    contact_ids: selectedContactIds
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        console.log(response.data);

                        selectElement.val(null).trigger('change');
                        selectedRecords.length = 0;
                        $('#deactivateUsersModel').modal('hide');
                        $('#activateUsersModel').modal('hide');

                        filterForm.trigger('submit');
                    } else {
                        // Handle failure, e.g., show an error message
                        alert('Failed to deactivateUsers selected records. Please try again.');
                    }
                },
                error: function(error) {
                    // Handle AJAX error, e.g., show an error message
                    alert('An error occurred while trashing records. Please try again later.');
                    console.error('Error:', error);
                }
            });
        });





        function updateMajorSelect() {
            var mainSelectValue = $("#industrySelect").val();
            var dependentSelect = $("#majorSelect");

            // Clear existing options
            dependentSelect.empty();

            // Fetch options via AJAX
            $.ajax({
                url: "{{ route('admin.majors.ajax') }}", // Replace with the actual URL to fetch options
                method: "GET",
                data: {
                    industry_id: mainSelectValue
                },
                dataType: "json",
                success: function(data) {
                    // Populate options based on the AJAX response
                    dependentSelect.append('<option value=""></option>');
                    $.each(data, function(key, item) {
                        dependentSelect.append("<option value='" + item.id + "'>" + item.name +
                            "</option>");
                    });
                    dependentSelect.select2();
                },
                error: function() {
                    alert("Error fetching options.");
                }
            });
        }


        function updateEmployeeSelect() {
            var mainSelectValue = $("#branchSelect").val();
            var dependentSelect = $("#employeeSelect");

            // Clear existing options
            dependentSelect.empty();

            // Fetch options via AJAX
            $.ajax({
                url: "{{ route('admin.employees.ajax') }}", // Replace with the actual URL to fetch options
                method: "GET",
                data: {
                    branch_id: mainSelectValue
                },
                dataType: "json",
                success: function(data) {
                    dependentSelect.append('<option value=""></option>');
                    // Populate options based on the AJAX response
                    $.each(data, function(key, item) {
                        dependentSelect.append("<option value='" + item.id + "'>" + item.name +
                            "</option>");
                    });
                    dependentSelect.select2();
                },
                error: function() {
                    alert("Error fetching options.");
                }
            });
        }
        updateEmployeeSelect();
        function updateAreaSelect() {
            var mainSelectValue = $("#citySelect").val();
            var dependentSelect = $("#areaSelect");

            // Clear existing options
            dependentSelect.empty();

            // Fetch options via AJAX
            $.ajax({
                url: "{{ route('admin.areas.ajax') }}", // Replace with the actual URL to fetch options
                method: "GET",
                data: {
                    city_id: mainSelectValue
                },
                dataType: "json",
                success: function(data) {
                    dependentSelect.append('<option value=""></option>');
                    // Populate options based on the AJAX response
                    $.each(data, function(key, item) {
                        dependentSelect.append("<option value='" + item.id + "'>" + item.name +
                            "</option>");
                    });
                    dependentSelect.select2();
                },
                error: function() {
                    alert("Error fetching options.");
                }
            });
        }
        updateAreaSelect();

        function updateSubActivitiesSelect() {
            var mainSelectValue = $("#activitySelect").val();
            var dependentSelect = $("#interestSelect");

            // Clear existing options
            dependentSelect.empty();

            // Fetch options via AJAX
            $.ajax({
                url: "{{ route('admin.interests.ajax') }}", // Replace with the actual URL to fetch options
                method: "GET",
                data: {
                    activity_id: mainSelectValue
                },
                dataType: "json",
                success: function(data) {
                    dependentSelect.append('<option value=""></option>');
                    // Populate options based on the AJAX response
                    $.each(data, function(key, item) {
                        dependentSelect.append("<option value='" + item.id + "'>" + item.name +
                            "</option>");
                    });
                    dependentSelect.select2();
                },
                error: function() {
                    alert("Error fetching options.");
                }
            });
        }

        function updateSearchSubActivitiesSelect() {
            var mainSelectValue = $("#searchActivityId").val();
            var dependentSelect = $("#searchInterestId");

            // Clear existing options
            dependentSelect.empty();

            // Fetch options via AJAX
            $.ajax({
                url: "{{ route('admin.interests.ajax') }}", // Replace with the actual URL to fetch options
                method: "GET",
                data: {
                    activity_id: mainSelectValue
                },
                dataType: "json",
                success: function(data) {
                    dependentSelect.append('<option value=""></option>');
                    // Populate options based on the AJAX response
                    $.each(data, function(key, item) {
                        dependentSelect.append("<option value='" + item.id + "'>" + item.name +
                            "</option>");
                    });
                    dependentSelect.select2();
                },
                error: function() {
                    alert("Error fetching options.");
                }
            });
        }

        function updateImportInterestSelect()
        {
            var mainSelectValue = $("#importActivity").val();
            var dependentSelect = $("#importInterest");

            // Clear existing options
            dependentSelect.empty();

            // Fetch options via AJAX
            $.ajax({
                url: "{{ route('admin.interests.ajax') }}", // Replace with the actual URL to fetch options
                method: "GET",
                data: {
                    activity_id: mainSelectValue
                },
                dataType: "json",
                success: function(data) {
                    dependentSelect.append('<option value=""></option>');
                    // Populate options based on the AJAX response
                    $.each(data, function(key, item) {
                        dependentSelect.append("<option value='" + item.id + "'>" + item.name +
                            "</option>");
                    });
                    dependentSelect.select2();
                },
                error: function() {
                    alert("Error fetching options.");
                }
            });
        }



        function updateSearchEmployeeSelect() {
            var mainSelectValue = $("#searchBranchSelect").val();
            var dependentSelect = $("#searchEmployeeSelect");

            // Clear existing options
            dependentSelect.empty();

            // Fetch options via AJAX
            $.ajax({
                url: "{{ route('admin.employees.ajax') }}", // Replace with the actual URL to fetch options
                method: "GET",
                data: {
                    branch_id: mainSelectValue
                },
                dataType: "json",
                success: function(data) {
                    dependentSelect.append('<option value=""></option>');
                    // Populate options based on the AJAX response
                    $.each(data, function(key, item) {
                        dependentSelect.append("<option value='" + item.id + "'>" + item.name +
                            "</option>");
                    });
                    dependentSelect.select2();
                },
                error: function() {
                    alert("Error fetching options.");
                }
            });
        }


        $("#branchSelect").on("change", updateEmployeeSelect);
        $("#searchBranchSelect").on("change", updateSearchEmployeeSelect);


        $("#citySelect").on("change", updateAreaSelect);
        $("#industrySelect").on("change", updateMajorSelect);
        $("#activitySelect").on("change", updateSubActivitiesSelect);
        $("#importActivity").on("change", updateImportInterestSelect);

        $("#searchActivityId").on("change", updateSearchSubActivitiesSelect);
    </script>
@endpush
