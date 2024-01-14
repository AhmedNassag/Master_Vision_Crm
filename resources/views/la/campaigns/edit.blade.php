@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/campaigns') }}">{{trans("admin.Campaign")}}</a> :
@endsection
@section("contentheader_description", $campaign->$view_col)
@section("section", trans("admin.Campaigns"))
@section("section_url", url(config('laraadmin.adminRoute') . '/campaigns'))
@section("sub_section", trans("admin.Edit"))

@section("htmlheader_title", trans("admin.Campaigns")." ".trans("admin.Edit")." : ".$campaign->$view_col)

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
				{!! Form::model($campaign, ['route' => [config('laraadmin.adminRoute') . '.campaigns.update', $campaign->id ], 'method'=>'PUT', 'id' => 'campaign-edit-form', 'files'=>true]) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'name')
					--}}
                    <br>
					<div class="form-group col-md-12">
						{!! Form::submit( trans("admin.Update"), ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/campaigns') }}">{{ trans('admin.Cancel') }}</a></button>
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
	$("#campaign-edit-form").validate({
		
	});
	$("#campaign-edit-form .form-group").not(":last").addClass("col-md-6");
});
</script>
@endpush
