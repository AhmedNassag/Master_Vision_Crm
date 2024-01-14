@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/meeting_notes') }}">Meeting note</a> :
@endsection
@section("contentheader_description", $meeting_note->$view_col)
@section("section", trans("admin.Meeting notes"))
@section("section_url", url(config('laraadmin.adminRoute') . '/meeting_notes'))
@section("sub_section", trans("admin.Edit"))

@section("htmlheader_title", "Meeting notes Edit : ".$meeting_note->$view_col)

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
			<div class="col-md-8 col-md-offset-2">
				{!! Form::model($meeting_note, ['route' => [config('laraadmin.adminRoute') . '.meeting_notes.update', $meeting_note->id ], 'method'=>'PUT', 'id' => 'meeting_note-edit-form', 'files'=>true]) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'meeting_id')
					@la_input($module, 'notes')
					@la_input($module, 'follow_date')
					@la_input($module, 'created_by')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( trans("admin.Update"), ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/meeting_notes') }}">{{ trans('admin.Cancel') }}</a></button>
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
	$("#meeting_note-edit-form").validate({
		
	});
});
</script>
@endpush
