@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/countries') }}">{{trans("admin.Country")}}</a> :
@endsection
@section("contentheader_description", $country->$view_col)
@section("section", trans("admin.Countries"))
@section("section_url", url(config('laraadmin.adminRoute') . '/countries'))
@section("sub_section", trans("admin.Edit"))

@section("htmlheader_title", trans("admin.Countries")." ".trans("admin.Edit")." : ".$country->$view_col)

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
				{!! Form::model($country, ['route' => [config('laraadmin.adminRoute') . '.countries.update', $country->id ], 'method'=>'PUT', 'id' => 'country-edit-form', 'files'=>true]) !!}
					@la_form($module , ['name','phonecode'])
					
					{{--
					@la_input($module, 'iso')
					@la_input($module, 'name')
					@la_input($module, 'nicename')
					@la_input($module, 'iso3')
					@la_input($module, 'numcode')
					@la_input($module, 'phonecode')
					--}}
                    <br>
					<div class="form-group col-md-12">
						{!! Form::submit( trans("admin.Update"), ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/countries') }}">{{trans("admin.Cancel")}}</a></button>
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
	$("#country-edit-form").validate({
		
	});
	$("#country-edit-form .form-group").not(":last").addClass("col-md-6");
});
</script>
@endpush
