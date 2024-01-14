@extends('la.layouts.app')

@section('contentheader_title')
    <a href="{{ url(config('laraadmin.adminRoute') . '/employee_targets') }}">{{ trans('admin.Employee target') }}</a> :
@endsection
@section('contentheader_description', $employee_target->$view_col)
@section('section', 'Employee targets')
@section('section_url', url(config('laraadmin.adminRoute') . '/employee_targets'))
@section('sub_section', 'Edit')

@section('htmlheader_title', 'Employee targets Edit : ' . $employee_target->$view_col)

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
                <div class="col-md-10 col-md-offset-1">
                    {!! Form::model($employee_target, [
                        'route' => [config('laraadmin.adminRoute') . '.employee_targets.update', $employee_target->id],
                        'method' => 'PUT',
                        'id' => 'employee_target-edit-form',
                        'files' => true,
                    ]) !!}
                     @la_input($module, 'employee_id')
                    @la_input($module, 'month')
                           
                    <table id="activity-table" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>{{trans('admin.Activity')}}</th>
                                <th>{{trans('admin.Amounts Target')}}</th>
                                <th>{{trans('admin.Calls Target')}}</th>
                                <th>{{trans('admin.Action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employee_target->targets as $target)
                                <tr>
                                    <td width="30%">
                                        <select class="activity-select form-control" name="activity_id[]" rel="select2">
                                            @foreach ($activities as $activity)
                                                <option value="{{ $activity->id }}"
                                                    {{ $activity->id == $target->activity_id ? 'selected' : '' }}>
                                                    {{ $activity->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="amount_target[]" class="amount-input form-control"
                                            value="{{ $target->amount_target }}">
                                    </td>
                                    <td>
                                        <input type="number" name="calls_target[]" class="amount-input form-control"
                                            value="{{ $target->calls_target }}">
                                    </td>
                                    <td>
                                        <button type="button" class="count-button btn-primary btn">{{trans('admin.Count')}}</button>
                                        <button type="button" class="delete-button btn-danger btn">{{trans('admin.Delete')}}</button>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
					<button type="button" id="add-button" class="btn btn-success mt-1"><i class="fa fa-plus"></i> {{trans('admin.Add Target')}}</button>
                    <br>
                    <div class="form-group mt-2">
                        <label for="target_amount">{{trans('admin.Total')}} {{trans('admin.Amount Target')}}* :</label>
                        <input class="form-control" placeholder="Enter Amount Target" readonly
                            name="target_amount" type="number" value="{{$employee_target->target_amount}}">
                    </div>
                    <div class="form-group">
                        <label for="target_meeting">{{trans('admin.Total')}} {{trans('admin.Calls / Meetings Target')}}* :</label>
                        <input class="form-control" placeholder="Enter Calls / Meetings Target" readonly
                            name="target_meeting" type="number" value="{{$employee_target->target_meeting}}">
                    </div>

                  
                    
					<br>
                    <div class="form-group">
                        {!! Form::submit('تعديل', ['class' => 'btn btn-success']) !!} <button class="btn btn-default pull-right"><a
                                href="{{ url(config('laraadmin.adminRoute') . '/employee_targets') }}"> {{trans('admin.Cancel') }}</a></button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    
    <script>
        $(function() {
          
            $("#employee_target-edit-form").validate({

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
                            <input type="number" name="calls_target[]" class="amount-input form-control" value="0">
                        </td>
                        <td>
                            <button class="count-button btn-primary btn">{{trans('admin.Count')}}</button>
                            <button class="delete-button btn-danger btn">{{trans('admin.Delete')}}</button>
                        </td>
                    </tr>
                `;
                $("#activity-table tbody").append(newRow);
			
                // Reinitialize Select2 for the newly added select input
                $(".activity-select").select2();
            });

			function getActivityOptions() {
				const activities = {!!json_encode($activities)!!};
				let options = '';
				activities.forEach(function(activity) {
					options += `<option value="${activity.id}">${activity.name}</option>`;
				});
				return options;
			}

            // Delete Row
            $("#activity-table").on("click", ".delete-button", function() {
                $(this).closest("tr").remove();
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
