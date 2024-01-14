@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/attachments') }}">Attachment</a> :
@endsection
@section("contentheader_description", $attachment->$view_col)
@section("section", trans("admin.Attachments"))
@section("section_url", url(config('laraadmin.adminRoute') . '/attachments'))
@section("sub_section", trans("admin.Edit"))

@section("htmlheader_title", "Attachments Edit : ".$attachment->$view_col)

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
				{!! Form::model($attachment, ['route' => [config('laraadmin.adminRoute') . '.attachments.update', $attachment->id ], 'method'=>'PUT', 'id' => 'attachment-edit-form', 'files'=>true]) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'customer_id')
					@la_input($module, 'attachment_name')
					@la_input($module, 'attachment')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( trans("admin.Update"), ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/attachments') }}">{{ trans('admin.Cancel') }}</a></button>
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
	$("#attachment-edit-form").validate({
		
	});
});
</script>
@endpush
