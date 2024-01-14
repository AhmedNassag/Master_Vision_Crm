@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/notifications') }}">Notification</a> :
@endsection
@section("contentheader_description", $notification->$view_col)
@section("section", trans("admin.Notifications"))
@section("section_url", url(config('laraadmin.adminRoute') . '/notifications'))
@section("sub_section", trans("admin.Edit"))

@section("htmlheader_title", "Notifications Edit : ".$notification->$view_col)

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
				{!! Form::model($notification, ['route' => [config('laraadmin.adminRoute') . '.notifications.update', $notification->id ], 'method'=>'PUT', 'id' => 'notification-edit-form', 'files'=>true]) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'dept')
					@la_input($module, 'employee_id')
					@la_input($module, 'notification')
					@la_input($module, 'created_by')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( trans("admin.Update"), ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/notifications') }}">{{ trans('admin.Cancel') }}</a></button>
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
	$("#notification-edit-form").validate({
		
	});
        $("select[name=dept]").prepend(new Option("Select department", "0"));
        $("select[name=employee_id]").prepend(new Option("Select employee", "0"));
        
        $(document).on("change","select[name^=dept]",function(){
            var dept=0;
            if($(this).val().length)
                dept=$(this).val();
			$.ajax({
				type: "GET",
				url:"{{url(config('laraadmin.adminRoute') . '/get_employees_by_dept')}}/"+dept,
				processData: false,
				contentType: false,
				success: function(response) {
					if(response)
					{
						var options = [];
                                                options.push({
                                                        text: "Select employee",
                                                        id: 0
                                                });
						$.each(response, function (key, value) {
							options.push({
								text: value,
								id: key
							});
						});
                                                var employee=$("select[name=employee_id]").val();
						$("select[name^=employee_id]").empty().select2({
									data: options
							});
                                                $("select[name^=employee_id]").val(employee).change();
					}
					else
					{
						$("select[name^=employee_id]").empty();
					}
				}
			});
	});
	$("select[name=dept]").trigger("change");
});
</script>
@endpush
