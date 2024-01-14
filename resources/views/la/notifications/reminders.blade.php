@extends('la.layouts.app')

@section('contentheader_title', $title )
@section('contentheader_description',  $title )


@section('headerElems')

@endsection

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

    <div class="box box-success">
        <!--<div class="box-header"></div>-->
        <div class="box-body">
            <table id="reorder-reminders-table" class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>العميل</th>
                        <th>الفاتورة</th>
                        <th>تاريخ التذكير</th>
                        <th>حالة التذكير</th>
                        <th>النشاط الفرعي</th>
                        <th>النشاط</th>
                        <th>المبلغ المتوقع</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reminders as $reorderReminder)
                        <tr>
                            <td>{{ $reorderReminder->id }}</td>
                            <td>{{ $reorderReminder->customer->name ?? ""}}</td>
                            <td>#{{ $reorderReminder->invoice->id ?? ""}}</td>
                            <td>{{ $reorderReminder->reminder_date }}</td>
                            <td>{{ $reorderReminder->is_completed ? 'تم التذكير' : 'جديد' }}</td>
                            <td>{{ $reorderReminder->interest->name ?? "" }}</td>
                            <td>{{ $reorderReminder->activity->name ?? ""}}</td>
                            <td>{{ $reorderReminder->expected_amount }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


@endsection

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}" />
@endpush

@push('scripts')
    <script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
    <script>
        $(function() {

            $("#reorder-reminders-table").DataTable();

        });
    </script>
@endpush
