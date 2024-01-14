@extends('la.layouts.app')

@section('contentheader_title', trans('admin.Employee targets'))
@section('contentheader_description', trans('admin.Employee targets listing'))
@section('section', trans('admin.Employee targets'))
@section('sub_section', trans('admin.Listing'))
@section('htmlheader_title', trans('admin.Employee targets Listing'))

@section('headerElems')
    @can('Employee_targets-create')
        <button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">{{trans('admin.Add Employee target') }}</button>
    @endcan
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
            <table id="example1" class="table table-bordered">
                <thead>
                    <tr class="success">
                        @foreach ($listing_cols as $col)
                            <th>{{ !empty($module->fields[$col]) && !empty($module->fields[$col]['label']) ? trans('admin.'.$module->fields[$col]['label']) : ucfirst($col) }}
                            </th>
                        @endforeach
                        @if ($show_actions)
                            <th>{{ trans('admin.Actions') }}</th>
                        @endif
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

    @can('Employee_targets-create')
        <div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">{{ trans('admin.Add Employee target') }}</h4>
                    </div>
                    {!! Form::open([
                        'route' => config('laraadmin.adminRoute') . '.employee_targets.store',
                        'id' => 'employee_target-add-form',
                        'files' => true,
                    ]) !!}
                    <div class="modal-body">
                        <div class="box-body">
                            @la_input($module, 'employee_id')
                            @la_input($module, 'month')
                           
                            <table id="activity-table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ trans('admin.Activity') }}</th>
                                        <th>{{ trans('admin.Amounts Target') }}</th>
                                        <th>{{ trans('admin.Calls Target') }}</th>
                                        <th>{{ trans('admin.Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td width="30%">
                                            <select class="activity-select form-control" name="activity_id[]" rel="select2">
                                                @foreach ($activities as $activity)
                                                    <option value="{{ $activity->id }}">{{ $activity->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="amount_target[]" class="amount-input form-control"
                                                value="0">
                                        </td>
                                        <td>
                                            <input type="number" name="calls_target[]" class="calls-input form-control"
                                                value="0">
                                        </td>
                                        <td>
                                            <button type="button" class="count-button btn-primary btn">{{ trans('admin.Count') }}</button>
                                            <button type="button" class="delete-button btn-danger btn">{{ trans('admin.Delete') }}</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            
                            <button type="button" id="add-button" class="btn btn-success mt-1"><i class="fa fa-plus"></i> {{ trans('admin.Add Target') }}</button>


                             <div class="form-group mt-2">
                                <label for="target_amount">{{ trans('admin.Total Amount Target') }}* :</label>
                                <input class="form-control" placeholder="Enter Amount Target" readonly
                                    name="target_amount" type="number" value="0">
                            </div>
                            <div class="form-group">
                                <label for="target_meeting">{{ trans('admin.Total Calls / Meetings Target') }}* :</label>
                                <input class="form-control" placeholder="Enter Calls / Meetings Target" readonly
                                    name="target_meeting" type="number" value="0">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('admin.Close') }}</button>
                        {!! Form::submit('تأكيد', ['class' => 'btn btn-success']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    @endcan

@endsection

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}" />
@endpush

@push('scripts')
    <script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
    <script>
        $(function() {
            $("#example1").DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url(config('laraadmin.adminRoute') . '/employee_target_dt_ajax') }}",
                language: {
                    lengthMenu: "_MENU_",
                    search: "_INPUT_",
                    searchPlaceholder: "{{ trans('admin.Search') }}"
                },
                columns: [
                    @foreach ($listing_cols as $col)
                        {
                            data: '{{ $col }}',
                            name: '{{ $col }}'
                        },
                    @endforeach
                    @if ($show_actions)
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    @endif
                ]
            });
            $("#employee_target-add-form").validate({

            });



            // Initialize Select2 for the activity-select elements
            $(".activity-select").select2();
            // Add Row
            $("#add-button").click(function(e) {
                e.preventDefault();
                const newRow = `
                    <tr>
                        <td width="30%">
                            <select class="activity-select form-control" name="activity_id[]" rel="select2">
                                ${getActivityOptions()}
                            </select>
                        </td>
                        <td>
                            <input type="number" name="amount_target[]" class="amount-input form-control" value="0">
                        </td>
                        <td>
                            <input type="number" name="calls_target[]" class="calls-input form-control" value="0">
                        </td>
                        <td>
                            <button class="count-button btn-primary btn">{{ trans('admin.Count') }}</button>
                            <button class="delete-button btn-danger btn">{{ trans('admin.Delete') }}</button>
                        </td>
                    </tr>
                `;
                $("#activity-table tbody").append(newRow);
                  updateSums();

                // Reinitialize Select2 for the newly added select input
                $(".activity-select").select2();
            });

            function getActivityOptions() {
                const activities = {!! json_encode($activities) !!};
                let options = '';
                activities.forEach(function(activity) {
                    options += `<option value="${activity.id}">${activity.name}</option>`;
                });
                return options;
            }

            // Delete Row
            $("#activity-table").on("click", ".delete-button", function() {
                $(this).closest("tr").remove();
                  updateSums();
            });

            updateSums();

            function updateSums() {
                var sumAmount = 0;
                var sumCalls = 0;

                $('#activity-table tbody tr').each(function() {
                    var amount = parseInt($(this).find('input[name="amount_target[]"]').val()) || 0;
                    var calls = parseInt($(this).find('input[name="calls_target[]"]').val()) || 0;

                    sumAmount += amount;
                    sumCalls += calls;
                });

                $('input[name="target_amount"]').val(sumAmount);
                $('input[name="target_meeting"]').val(sumCalls);
            }


            $(document).on('keyup','.amount-input',updateSums); 
            $(document).on('keyup','.calls-input',updateSums);


        });
    </script>
@endpush
