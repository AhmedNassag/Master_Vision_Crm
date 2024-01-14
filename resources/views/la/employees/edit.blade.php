@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/employees') }}">Employees</a> :
@endsection
@section("contentheader_description", $employee->$view_col)
@section("section", trans("admin.Employees"))
@section("section_url", url(config('laraadmin.adminRoute') . '/employees'))
@section("sub_section", trans("admin.Edit"))

@section("htmlheader_title", "Employee Edit : ".$employee->$view_col)


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
				{!! Form::model($employee, ['route' => [config('laraadmin.adminRoute') . '.employees.update', $employee->id ], 'method'=>'PUT', 'id' => 'employee-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'name')
					@la_input($module, 'mobile')
					@la_input($module, 'email')
					@la_input($module, 'dept')
					@la_input($module, 'active')
					--}}
                    <div class="form-group">
						<label for="role">Role* :</label>
						<select class="form-control" required="1" data-placeholder="Select Role" rel="select2" name="role">
							<?php if(\Auth::user()->hasRole("SUPER_ADMIN"))
                                                            $roles = \App\Role::all();
                                                        else
                                                        {
                                                        $parents=\Auth::user()->roles->pluck('id')->toArray();
                                                        $roles = \App\Role::whereIn("id",$parents)->orWhereIn("parent",$parents)->get(); } ?>
							@foreach($roles as $role)
								@if($role->name != 'SUPER_ADMIN' || \Auth::user()->hasRole("SUPER_ADMIN"))
									@if($user->hasRole($role->name))
										<option value="{{ $role->id }}" selected>{{ $role->name }}</option>
									@else
										<option value="{{ $role->id }}">{{ $role->name }}</option>
									@endif
								@endif
							@endforeach
						</select>
					</div>
					<br>
					<div class="form-group">
						{!! Form::submit( "Update", ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/employees') }}">{{ trans('admin.Cancel') }}</a></button>
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
	$("#employee-edit-form").validate({
		
	});
        $("input[name=password]").closest('.form-group').remove();
        //$("input[name=password]").removeAttr("required");
        //$("input[name=password]").attr("aria-required",false);
        $(document).on("change","select[name=organization_id]",function(){
             $.ajax({
                    type: "GET",
                    url:"{{url('/admin/getDeptForOrg')}}/"+$("select[name=organization_id]").val() ,
                    success: function(response)
                    {
                            if(response){
                                    var options = [];
                                    $.each(response, function (key, value) {
                                            options.push({
                                                    text: value,
                                                    id: key
                                            });
                                    });
                                    $('select[name="dept"]').empty().select2({
                                            data: options
                                    });
                            }

                    }
            });
        });
        $("select[name=organization_id]").trigger("change");
        $('select[name="dept"]').val("{{$module->row->dept}}");
});
</script>
@endpush
