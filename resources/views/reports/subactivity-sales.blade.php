@extends('la.layouts.app')
@section('contentheader_title', 'تقرير مبيعات الانشطة')
@section('htmlheader_title')
    تقرير مبيعات الانشطة
@endsection
@section('main-content')
    <div class="">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">تقرير مبيعات الانشطة</div>
                    <div class="panel-body">
                        <form id="report-form">
                            {{ csrf_field() }}
                            <div class="form-group col-md-3">
                                <label for="activity_id">{{ trans('admin.Activity') }}</label>
                                <select name="activity_id" id="activitySelect" class="form-control" rel="select2">
                                    <option value=""></option>
                                    @foreach (App\Models\Activate::all() as $activity)
                                        <option value="{{ $activity->id }}">{{ $activity->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="interest_id">{{ trans('admin.Interest') }}</label>
                                <select name="interest_id" id="interestSelect" class="form-control" rel="select2">
                                    <option value=""></option>
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="">من</label>
                                <input type="date" name="from" id="from"  class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">الي</label>
                                <input type="date" name="to" id="to"  class="form-control">
                            </div>



                            <button type="submit" class="btn btn-primary">ابحث</button>
                        </form>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">نتائج التقرير</div>
                    <div class="panel-body">
                        <table id="report-table" class="table table-bordered">
                            <thead>
                                <tr>

                                    <th>النشاط</th>
                                    <th>النشاط الفرعي</th>
                                    <th>المبيعات المحققه</th>
                                    <th>المدفوع</th>
                                    <th>المتبقي</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- DataTable rows will be populated dynamically using Ajax -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}" />
@endpush

@push('scripts')
    <script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Populate branch options (you can fetch this data from the server)
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
                            dependentSelect.append("<option value='" + item.id + "'>" + item
                                .name +
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





            // Handle form submission and populate the DataTable
            $('#report-form').on('submit', function(event) {
                event.preventDefault();

                var activitySelect = $('#activitySelect').val();
                var from = $('#from').val();
                var to = $('#to').val();
                var interestSelect = $('#interestSelect').val();



                // Perform an Ajax request to fetch report data based on the selected options
                $.ajax({
                    url: '{{ route('admin.generate.sales.activites.report') }}', // Replace with the actual URL
                    data: {
                        activity_id: activitySelect,
                        from: from,
                        to: to,
                        interest_id:interestSelect,
                    },
                    success: function(data) {

                        // Populate the DataTable with the received data
                        var reportTable = $('#report-table').DataTable({
                            destroy: true, // Destroy the previous DataTable instance
                            data: data,
                            columns: [{
                                    data: 'activity'
                                },
                                {
                                    data: 'sub_activity'
                                },
                                {
                                    data: 'total_sales'
                                },
                                {
                                    data: 'paid_amount'
                                },
                                {
                                    data: 'remaining_amounts'
                                }
                            ]
                        });
                    }
                });
            });
        });
    </script>
@endpush
