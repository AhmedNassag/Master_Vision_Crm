@extends("la.layouts.app")

@section("contentheader_title", trans("admin.Roles"))
@section("contentheader_description", trans("admin.Roles Listing"))
@section("section", trans("admin.Roles"))
@section("sub_section", trans("admin.Listing"))
@section("htmlheader_title", trans("admin.Roles Listing"))

@section("headerElems")
@la_access("Roles", "create")
	<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">{{trans("admin.Add Role")}}</button>
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

@la_access("Roles", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">{{trans("admin.Add Role")}}</h4>
			</div>
			{!! Form::open(['route' => 'admin.roles.store', 'id' => 'role-add-form']) !!}
			<div class="modal-body">
				<div class="box-body">
                    {{--@la_input($module, 'name', null, null, "form-control text-uppercase", ["placeholder" => "Role Name in CAPITAL LETTERS with '_' to JOIN e.g. 'SUPER_ADMIN'"])
					@la_input($module, 'display_name')
					@la_input($module, 'description')
					@la_input($module, 'parent')
					@la_input($module, 'view_org')
					@la_input($module, 'view_data')--}}
					@la_input($module , 'name')

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

					@la_input($module , 'view_data')

					@la_input($module , 'view_dept')


					

				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('admin.Close') }}</button>
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
        ajax: "{{ url(config('laraadmin.adminRoute') . '/role_dt_ajax') }}",
		language: {
			lengthMenu: "_MENU_",
			search: "_INPUT_",
			searchPlaceholder: "{{ trans('admin.Search') }}"
		},
		columns: [
			@foreach($listing_cols as $col)
            {data: '{{$col}}' , name: '{{$col}}' },
			@endforeach
            @if($show_actions)
            {data: 'action', name: 'action', orderable: false, searchable: false}
			@endif
        ]
		
	});
	$("#role-add-form").validate({
		
	});
});
</script>
@endpush