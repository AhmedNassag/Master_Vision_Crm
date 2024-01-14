@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/meetings') }}">{{ trans('admin.Meeting') }}</a> :
@endsection
@section("contentheader_description", $meeting->$view_col)
@section("section", trans("admin.Meetings"))
@section("section_url", url(config('laraadmin.adminRoute') . '/meetings'))
@section("sub_section", trans("admin.Edit"))

@section("htmlheader_title", "Meetings Edit : ".$meeting->$view_col)

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
				{!! Form::model($meeting, ['route' => [config('laraadmin.adminRoute') . '.meetings.update', $meeting->id ], 'method'=>'PUT', 'id' => 'meeting-edit-form', 'files'=>true]) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'contact_id')
					@la_input($module, 'interests_ids')
					@la_input($module, 'type')
					@la_input($module, 'meeting_place')
					@la_input($module, 'meeting_date')
					@la_input($module, 'revenue')
					@la_input($module, 'created_by')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( trans("admin.Update"), ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/meetings') }}"> {{trans('admin.Cancel') }}</a></button>
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
	$("#meeting-edit-form").validate({
		
	});
});
</script>
@endpush
