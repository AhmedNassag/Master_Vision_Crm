@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/roles') }}">Roles</a> :
@endsection
@section("contentheader_description", $role->$view_col)
@section("section", trans("admin.Roles"))
@section("section_url", url(config('laraadmin.adminRoute') . '/roles'))
@section("sub_section", trans("admin.Edit"))

@section("htmlheader_title", " Edit Role: ".$role->$view_col)

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

<div class="box">
	<div class="box-header">
		
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				{!! Form::model($role, ['route' => [config('laraadmin.adminRoute') . '.roles.update', $role->id ], 'method'=>'PUT', 'id' => 'role-edit-form']) !!}
					@la_input($module, 'name', null, null, "form-control text-uppercase", ["placeholder" => "Role Name in CAPITAL LETTERS with '_' to JOIN e.g. 'SUPER_ADMIN'"])
					{{-- @la_input($module, 'parent') --}}

					<div class="form-group">
						<label for="role">{{trans("admin.Role")}}* :</label>
						<select class="form-control" required="1" data-placeholder="Select Role" rel="select2" name="role">
							
                                                    @php 
                                                        $parent=\Auth::user()->roles[0]->id;
                                                        $roles = \App\Role::find($parent)->getAllChildRoles($parent); 
													@endphp
							@foreach($roles as $role_item)
									<option @if($role->id == $role_item->id)  selected @endif value="{{ $role_item->id }}">{{ $role_item->name }}</option>
							@endforeach
						</select>
					</div>

					<br>
					<div class="form-group">
						{!! Form::submit( trans("admin.Update"), ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/roles') }}">{{ trans('admin.Cancel') }}</a></button>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

@endsection

@push('scripts')
<script>
$(function () {
	$("#role-edit-form").validate({
		
	});
});
</script>
@endpush
