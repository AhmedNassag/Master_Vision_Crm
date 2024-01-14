@extends("la.layouts.app")
@section("contentheader_title", "تقرير مبيعات الموظفين")
@section('htmlheader_title')
تقرير مبيعات الموظفين
@endsection
@section("main-content")
<div class="">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">تقرير مبيعات الموظفين</div>
                <div class="panel-body">
                    <form id="report-form">
                        {{ csrf_field() }}
                        <div class="form-group col-md-6">
                            <label for="branch">اختر فرعا:</label>
                            <select id="branch" name="branch" class="form-control" rel='select2'>
                                <option value="">الكل</option>
                                @foreach (\App\Models\Branch::all() as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="month">اختر شهرا</label>
                            <select id="month" name="month" class="form-control" rel='select2'>
                                @foreach($year_month as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
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
                                <th>الموظف</th>
                                <th>الهدف</th>
                                <th>الهدف المحقق</th>
								<th> عدد العملاء </th>
                                <th>نسبة التحقيق</th>
                                <th>الفرع</th>
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
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script>
$(document).ready(function() {
    // Populate branch options (you can fetch this data from the server)






    // Handle form submission and populate the DataTable
    $('#report-form').on('submit', function(event) {
        event.preventDefault();

        var selectedBranch = $('#branch').val();
        var selectedMonth = $('#month').val();

        // Perform an Ajax request to fetch report data based on the selected options
        $.ajax({
            url: '{{ route("admin.generate.sales.employees.report") }}', // Replace with the actual URL
            data: {
                branch: selectedBranch,
                month: selectedMonth
            },
            success: function(data) {
                // Populate the DataTable with the received data
                var reportTable = $('#report-table').DataTable({
                    destroy: true, // Destroy the previous DataTable instance
                    data: data,
                    columns: [
                        { data: 'employee' },
                        { data: 'target' },
                        { data: 'actual' },
						{ data: 'customers_count' },
                        { data: 'margin' },
                        { data: 'branch' }
                    ]
                });
            }
        });
    });
});
</script>
@endpush
