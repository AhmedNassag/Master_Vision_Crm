@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/saved_replies') }}">{{trans("admin.Saved Reply")}}</a> :
@endsection
@section("contentheader_description", $saved_reply->$view_col)
@section("section", trans("admin.Saved Replies"))
@section("section_url", url(config('laraadmin.adminRoute') . '/saved_replies'))
@section("sub_section", trans("admin.Edit"))

@section("htmlheader_title", trans("admin.Saved Replies")." ".trans("admin.Edit")." : ".$saved_reply->$view_col)

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
			<div class="col-md-12">
				{!! Form::model($saved_reply, ['route' => [config('laraadmin.adminRoute') . '.saved_replies.update', $saved_reply->id ], 'method'=>'PUT', 'id' => 'saved_reply-edit-form', 'files'=>true]) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'reply')
					--}}
                    <br>
					<div class="form-group col-md-12">
						{!! Form::submit( trans("admin.Update"), ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/saved_replies') }}">{{ trans('admin.Cancel') }}</a></button>
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
	$("#saved_reply-edit-form").validate({
		
	});
	$("#saved_reply-edit-form .form-group").not(":last").addClass("col-md-6");
});
</script>
@endpush
