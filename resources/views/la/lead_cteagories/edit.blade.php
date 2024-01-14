@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/lead_cteagories') }}">Lead cteagory</a> :
@endsection
@section("contentheader_description", $lead_cteagory->$view_col)
@section("section", trans("admin.Lead cteagories"))
@section("section_url", url(config('laraadmin.adminRoute') . '/lead_cteagories'))
@section("sub_section", trans("admin.Edit"))

@section("htmlheader_title", "Lead cteagories Edit : ".$lead_cteagory->$view_col)

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
				{!! Form::model($lead_cteagory, ['route' => [config('laraadmin.adminRoute') . '.lead_cteagories.update', $lead_cteagory->id ], 'method'=>'PUT', 'id' => 'lead_cteagory-edit-form', 'files'=>true]) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'contact_category_id')
					@la_input($module, 'contact_id')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( trans("admin.Update"), ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/lead_cteagories') }}">{{ trans('admin.Cancel') }}</a></button>
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
	$("#lead_cteagory-edit-form").validate({
		
	});
});
</script>
@endpush
