@extends("la.layouts.app")
@section("contentheader_title", trans("admin.Employees"))
@section("contentheader_description", trans("admin.employees listing"))
@section("section", trans("admin.Employees"))
@section("sub_section", trans("admin.Listing"))
@section("htmlheader_title", trans("admin.Employees Listing"))

@section("headerElems")
@la_access("Employees", "create")
	<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">{{trans("admin.Add Employee")}}</button>
@endla_access
@endsection

@section("main-content")

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
					@foreach( $listing_cols as $col )
					<th>{{ !empty($module->fields[$col]) && !empty($module->fields[$col]['label'])? trans('admin.'.$module->fields[$col]['label']) : ucfirst($col) }}</th>
					@endforeach
						@la_access("Employee_targets", "view")
							<th>{{trans("admin.Target")}}</th>
						@endla_access
						@if($show_actions)
					        <th>{{trans("admin.Actions")}}</th>
					@endif
				</tr>
			</thead>
			<tbody>

			</tbody>
		</table>
	</div>
</div>

@la_access("Employees", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">{{trans("admin.Add Employee")}} </h4>
			</div>
			{!! Form::open(['route' => 'admin.employees.store', 'id' => 'employee-add-form']) !!}
			<div class="modal-body">
				<div class="box-body">
                    @la_form($module)

					{{--
					@la_input($module, 'name')
					@la_input($module, 'mobile')
					@la_input($module, 'email')
					@la_input($module, 'dept')
					@la_input($module, 'active')
					--}}

					<div class="form-group">
						<label for="password">{{trans("admin.password")}}* :</label>
						<input class="form-control valid" placeholder="{{trans("admin.Enter Password")}}" data-rule-maxlength="256" required="1" name="password" type="password" value="" aria-required="true" aria-invalid="false">
					</div>
					<div class="form-group">
						<label for="role">{{trans("admin.Role")}}* :</label>
						<select class="form-control" required="1" data-placeholder="Select Role" rel="select2" name="role">
                            @php
                                $parent=\Auth::user()->roles[0]->id;
                                $roles = \App\Role::find($parent)->getAllChildRoles($parent);
                            @endphp
							@foreach($roles as $role)
								<option value="{{ $role->id }}">{{ $role->name }}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">{{trans("admin.Close")}}</button>
				{!! Form::submit( trans("admin.Add"), ['class'=>'btn btn-success']) !!}
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endla_access

@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script>
$(function () {
	$("#example1").DataTable({
		processing: true,
        serverSide: true,
        ajax: "{{ url(config('laraadmin.adminRoute') . '/employee_dt_ajax') }}",
		language: {
			lengthMenu: "_MENU_",
			search: "_INPUT_",
			searchPlaceholder: "{{ trans('admin.Search') }}"
		},
		columns: [
			@foreach($listing_cols as $col)
            {data: '{{$col}}' , name: '{{$col}}' },
			@endforeach
                @la_access("Employee_targets", "view")
                {data: 'target' , name: 'target' },
                @endla_access
            @if($show_actions)
            {data: 'action', name: 'action', orderable: false, searchable: false}
			@endif
        ]
	});

	$("#employee-add-form").validate({

	});
});
</script>
@endpush
