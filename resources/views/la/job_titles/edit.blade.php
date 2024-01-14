@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/job_titles') }}">Job title</a> :
@endsection
@section("contentheader_description", $job_title->$view_col)
@section("section", trans("admin.Job titles"))
@section("section_url", url(config('laraadmin.adminRoute') . '/job_titles'))
@section("sub_section", trans("admin.Edit"))

@section("htmlheader_title", "Job titles Edit : ".$job_title->$view_col)

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
				{!! Form::model($job_title, ['route' => [config('laraadmin.adminRoute') . '.job_titles.update', $job_title->id ], 'method'=>'PUT', 'id' => 'job_title-edit-form', 'files'=>true]) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'name')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( trans("admin.Update"), ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/job_titles') }}">{{ trans('admin.Cancel') }}</a></button>
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
	$("#job_title-edit-form").validate({
		
	});
});
</script>
@endpush
