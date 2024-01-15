@extends("la.layouts.app")
@section("contentheader_title", "تقرير مبيعات الفروع")
@section('htmlheader_title')
تقرير مبيعات الفروع
@endsection
@section("main-content")
<div class="">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">تقرير مبيعات الفروع</div>
                <div class="panel-body">
                    <form id="report-form">
                        {{ csrf_field() }}
                        <div class="form-group col-md-12">
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
                                <th>الفرع</th>
                                <th>الهدف</th>
                                <th>الهدف المحقق</th>
                                <th>نسبة التحقيق</th>
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
            url: '{{ route("admin.generate.sales.branches.report") }}', // Replace with the actual URL
            data: {
                month: selectedMonth
            },
            success: function(data) {
                // Populate the DataTable with the received data
                var reportTable = $('#report-table').DataTable({
                    destroy: true, // Destroy the previous DataTable instance
                    data: data,
                    columns: [
                        { data: 'branch' },
                        { data: 'target' },
                        { data: 'actual' },
                        { data: 'margin' },
                    ]
                });
            }
        });
    });
});
</script>
@endpush
