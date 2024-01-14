@extends('la.layouts.app')
@section('contentheader_title', ' تصدير جهات الاتصال')
@section('htmlheader_title')
    تصدير جهات الاتصال
@endsection
@section('main-content')
    <div class="">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">تصدير جهات الاتصال</div>
                    <div class="panel-body">
                        <form method="POST" action="{{ route('admin.reports.export.contacts') }}" accept-charset="UTF-8" id="filterContactForm" enctype="multipart/form-data"
                            novalidate="novalidate">
                            @csrf
                            <div class="modal-body">
                                <div class="box-body" style="direction:rtl;">
                                    <!-- Personal Information -->
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label for="gender">{{ trans('admin.Gender') }}* :</label>
                                            <select rel="select2"  class="form-control" required="1" name="gender">
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
                                            <select rel="select2"  class="form-control" required="1" multiple
                                                name="contact_category_id[]" rel="select2">
                                                <option value="">{{ trans('admin.All') }}</option>
                                                @foreach ($contactCategories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="contact_source_id">{{ trans('admin.Contact Source*') }}</label>
                                            <select rel="select2"  class="form-control" required="1" name="contact_source_id">
                                                <option value="">{{ trans('admin.All') }}</option>
                                                @foreach ($contactSources as $source)
                                                    <option value="{{ $source->id }}">{{ $source->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="campaign_id">{{ trans('admin.Campaign') }}*</label>
                                            <select rel="select2"  class="form-control" required="1" name="campaign_id" rel="select2">
                                                <option value="">{{ trans('admin.All') }}</option>
                                                @foreach (App\Models\Campaign::all() as $campaign)
                                                    <option value="{{ $campaign->id }}">CP-{{ $campaign->id }} -
                                                        {{ $campaign->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <hr style="margin-top:10px;margin-bottom:10px" />

                                    <!-- Contact Source and Location -->
                                    <div class="row">

                                        <div class="form-group col-md-3">
                                            <label for="city_id">{{ trans('admin.City') }}* :</label>
                                            <select rel="select2"  class="form-control" required="1" name="city_id">
                                                <option value="">{{ trans('admin.All') }}</option>
                                                @foreach ($cities as $city)
                                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="area_id">{{ trans('admin.Area') }}* :</label>
                                            <select rel="select2"  class="form-control" required="1" name="area_id">
                                                <option value="">{{ trans('admin.All') }}</option>
                                                @foreach ($areas as $area)
                                                    <option value="{{ $area->id }}">{{ $area->name }}</option>
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

                                    <!-- Industry and Major -->
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label for="industry_id">{{ trans('admin.Industry') }}* :</label>
                                            <select rel="select2"  class="form-control" required="1" name="industry_id">
                                                <option value="">{{ trans('admin.All') }}</option>
                                                @foreach ($industries as $industry)
                                                    <option value="{{ $industry->id }}">{{ $industry->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="major_id">{{ trans('admin.Major') }}* :</label>
                                            <select rel="select2"  class="form-control" required="1" name="major_id">
                                                <option value="">{{ trans('admin.All') }}</option>
                                                @foreach ($majors as $major)
                                                    <option value="{{ $major->id }}">{{ $major->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="job_title_id">{{ trans('admin.Job title') }} :</label>
                                            <select rel="select2"  class="form-control" required="1" name="job_title_id">
                                                <option value="">{{ trans('admin.All') }}</option>
                                                @foreach ($jobTitles as $jobTitle)
                                                    <option value="{{ $jobTitle->id }}">{{ $jobTitle->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>


                                    </div>
                                    <hr style="margin-top:10px;margin-bottom:10px" />

                                    <!-- Activity -->
                                    <div class="row">
                                        @if (auth()->user()->type != 'Employee')
                                            <div class="form-group col-md-3">
                                                <label
                                                    for="assignment_type">{{ trans('admin.Assignment Status') }}*</label>
                                                <select rel="select2"  class="form-control" required="1" name="assignment_type">
                                                    <option value="">{{ trans('admin.All') }}</option>
                                                    <option value="assigned">{{ trans('admin.Assigned') }}</option>
                                                    <option value="un-assigned">{{ trans('admin.Not Assigned') }}</option>
                                                </select>
                                            </div>
                                        @endif
                                        <div class="form-group col-md-3">
                                            <label for="activity_id">{{ trans('admin.Activity') }}* :</label>
                                            <select rel="select2"  class="form-control" id="searchActivityId" required="1"
                                                name="activity_id">
                                                <option value="">{{ trans('admin.All') }}</option>
                                                @foreach ($activities as $activity)
                                                    <option value="{{ $activity->id }}">{{ $activity->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="activity_id">{{ trans('admin.Interest') }} :</label>
                                            <select rel="select2"  class="form-control" id="searchInterestId" required="1"
                                                name="interest_id">
                                                <option value="">{{ trans('admin.All') }}</option>
                                            </select>
                                        </div>

                                        <div class="row col-md-12">
                                            <div class="form-group col-md-3">
                                                <label id="fromDate">تاريخ من</label>
                                                <input type="date" name="from_date" id="fromDate" class="form-control">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label id="fromDate">تاريخ الي</label>
                                                <input type="date" name="to_date" id="toDate" class="form-control">
                                            </div>
                                        </div>
                                        <input type="hidden" value="" id="statusFilter" name="status" />
                                    </div>
                                    <hr style="margin-top:10px;margin-bottom:10px" />

                                </div>
                            </div>
                            <div class="modal-footer">

                                <input class="btn btn-success" type="submit" value="تصدير">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
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
        updateSearchEmployeeSelect();
        $("#searchBranchSelect").on("change", updateSearchEmployeeSelect);
    </script>
@endpush
