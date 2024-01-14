@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/areas') }}">Area</a> :
@endsection
@section("contentheader_description", $area->$view_col)
@section("section", trans("admin.Areas"))
@section("section_url", url(config('laraadmin.adminRoute') . '/areas'))
@section("sub_section", trans("admin.Edit"))

@section("htmlheader_title", "Areas Edit : ".$area->$view_col)

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
				{!! Form::model($area, ['route' => [config('laraadmin.adminRoute') . '.areas.update', $area->id ], 'method'=>'PUT', 'id' => 'area-edit-form', 'files'=>true]) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'name')
					@la_input($module, 'city_id')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( trans("admin.Update"), ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/areas') }}">{{ trans('admin.Cancel') }}</a></button>
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
	$("#area-edit-form").validate({
		
	});
});
</script>
@endpush
