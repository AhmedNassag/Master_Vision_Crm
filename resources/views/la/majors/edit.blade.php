@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/majors') }}">Major</a> :
@endsection
@section("contentheader_description", $major->$view_col)
@section("section", trans("admin.Majors"))
@section("section_url", url(config('laraadmin.adminRoute') . '/majors'))
@section("sub_section", trans("admin.Edit"))

@section("htmlheader_title", "Majors Edit : ".$major->$view_col)

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
				{!! Form::model($major, ['route' => [config('laraadmin.adminRoute') . '.majors.update', $major->id ], 'method'=>'PUT', 'id' => 'major-edit-form', 'files'=>true]) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'industry_id')
					@la_input($module, 'name')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( trans("admin.Update"), ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/majors') }}">{{ trans('admin.Cancel') }}</a></button>
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
	$("#major-edit-form").validate({
		
	});
});
</script>
@endpush
