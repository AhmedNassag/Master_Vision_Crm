@extends('la.layouts.app')

@section('contentheader_title')
    {{ trans('admin.Re-Target') }}
@endsection
@section('contentheader_description', trans('admin.Re-Target'))
@section('section', trans('admin.Re-Target'))

@section('htmlheader_title', trans('admin.Re-Target'))

@section('main-content')

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="box">
        <div class="box-header">
        </div>
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="activity_id">{{ trans('admin.Activity') }}</label>
                    <select name="activity_id" id="activitySelect" class="form-control" rel="select2">
                        <option value=""></option>
                        @foreach (App\Models\Activate::all() as $activity)
                            <option value="{{ $activity->id }}">{{ $activity->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="interest_id">{{ trans('admin.Interest') }}</label>
                    <select name="interest_id" id="interestSelect" class="form-control" rel="select2">
                        <option value=""></option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="from">{{ trans('admin.From') }}</label>
                    <input type="date" name="from" id="from" class="form-control">
                </div>
                <div class="form-group col-md-4">
                    <label for="to">{{ trans('admin.To') }}:</label>
                    <input type="date" name="to" id="to" class="form-control">
                </div>
                <div class="form-group col-md-4">
                    <button type="submit" class="btn btn-primary" id="filterButton">{{ trans('admin.Filter') }}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-9">
            <!-- Display table for response data -->
            <div class="box" id="data-table-box">
                <div class="box-header">
                    <h3 class="box-title">النتائج</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>{{ trans('admin.id') }}</th>
                                    <th>{{ trans('admin.Gender') }}</th>
                                    <th>{{ trans('admin.Name') }}</th>
                                    <th>{{ trans('admin.Mobile') }}</th>
                                    <th>{{ trans('admin.Email') }}</th>
                                    <th>{{ trans('admin.Company Name') }}</th>


                                </tr>
                            </thead>
                            <tbody id="data-table-body">
                                <!-- Data rows will be added here dynamically -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <!-- Available actions section -->
            <div class="box" id="actions-box ">
                <div class="box-header">
                    <h3 class="box-title">{{ trans('admin.Actions') }}</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="new_activity_id">النشاط المستهدف</label>
                            <select name="new_activity_id" id="new_activity_id" class="form-control" rel="select2">
                                <option value=""></option>
                                @foreach (App\Models\Activate::all() as $activity)
                                    <option value="{{ $activity->id }}">{{ $activity->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="new_interest_id">النشاط الفرعي المستهدف</label>
                            <select name="new_interest_id" id="new_interest_id" class="form-control" rel="select2">
                                <option value=""></option>

                            </select>
                        </div>
                        <div class="form-group col-md-12">

                            <button class="btn btn-success" id="reTargetButton">{{ trans('admin.Re-Target') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // AJAX request to retrieve data on filter button click
        $('#filterButton').click(function() {

            var activityId = $('select[name="activity_id"]').val();
            var interestId = $('select[name="interest_id"]').val();
            var fromDate = $('#from').val();
            var toDate = $('#to').val();

            $('#reTargetButton').prop('disabled', true).html('Loading...');

            // Perform AJAX request and update the data table
            $.ajax({
                url: "{{ route('admin.marketing.retarget.results') }}",
                type: 'GET',
                data: {
                    activity_id: activityId,
                    interest_id: interestId,
                    from: fromDate,
                    to: toDate
                },
                success: function(response) {
                    // Update the data table with response data
                    var dataTableBody = $('#data-table-body');
                    dataTableBody.empty();

                    $.each(response, function(index, row) {
                        var newRow = '<tr>' +
                            '<td><input type="checkbox" checked name="selectedRows[]" value="' +
                            row
                            .id + '"></td>' +
                            '<td>' + row.id + '</td>' +
                            '<td>' + row.gender + '</td>' +
                            '<td><a href="#">' +
                            row.name + '</a></td>' +
                            '<td>' + row.mobile + '</td>' +
                            '<td>' + row.email + '</td>' +
                            '<td>' + row.company_name + '</td>'

                        '</tr>';
                        dataTableBody.append(newRow);
                    });

                    // Show the data table and actions box
                    $('#data-table-box').show();
                    $('#actions-box').show();
                    $('#reTargetButton').prop('disabled', false).html(
                    `{{ trans('admin.Re-Target') }}`);
                }
            });
        });

        $('#reTargetButton').click(function() {
            var selectedRows = $('input[name="selectedRows[]"]:checked').map(function() {
                return $(this).val();
            }).get();
            var newActivityId = $('select[name="new_activity_id"]').val();
            var activity_id = $('select[name="activity_id"]').val();
            var new_interest_id = $('select[name="new_interest_id"]').val();

            // Add your data validation logic here
            if (selectedRows.length === 0 || !newActivityId || !activity_id || !new_interest_id) {
                // Show an error message or perform appropriate actions for validation failure
                swal({
                    icon: 'error',
                    title: 'تأكد من صحة البيانات',
                    type: 'error',
                });
            } else {
                // Disable the button and show "Loading..." while making the AJAX request
                $('#reTargetButton').prop('disabled', true).html('Loading...');

                // Perform AJAX request to the 'marketing.post.retarget.results' route
                $.ajax({
                    url: "{{ route('admin.marketing.post.retarget.results') }}",
                    type: 'POST',
                    data: {
                        ids: selectedRows,
                        new_activity_id: newActivityId,
                        activity_id: activity_id,
                        new_interest_id:new_interest_id,
                        _token: '{{ csrf_token() }}', // Add CSRF token for security
                    },
                    success: function(response) {
                        if (response.success) {
                            // Show success message using SweetAlert
                            var cm_name = 'تم انشاء ' + response.name + ' بنجاح';
                            swal({
                                icon: 'success',
                                title: 'اعادة استهداف',
                                text: cm_name,
                            });

                            // Clear and reset the form elements
                            $('select[name="new_activity_id"]').val('');
                            $('select[name="new_activity_id"]').trigger('change');
                            $('select[name="new_interest_id"]').val('');
                            $('select[name="new_interest_id"]').trigger('change');
                            $('select[name="activity_id"]').val('');
                            $('select[name="activity_id"]').trigger('change');
                            $('#from').val('');
                            $('#to').val();
                            var dataTableBody = $('#data-table-body');
                            dataTableBody.empty();
                        } else {
                            swal({
                                icon: 'error',
                                title: 'تأكد من صحة البيانات',
                                type: 'error',
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle AJAX error, if needed
                        console.error(xhr.responseText);
                        $('#reTargetButton').prop('disabled', false).html(
                            '{{ trans('admin.Re-Target') }}');
                    },
                    complete: function() {
                        // Re-enable the "Re-Target" button and reset its text
                        $('#reTargetButton').prop('disabled', false).html(
                            '{{ trans('admin.Re-Target') }}');
                    }
                });
            }
        });

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
            var mainSelectValue = $("#new_activity_id").val();
            var dependentSelect = $("#new_interest_id");

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






        $("#activitySelect").on("change", updateSubActivitiesSelect);
        $("#new_activity_id").on("change", updateSearchSubActivitiesSelect);
    </script>
@endpush
