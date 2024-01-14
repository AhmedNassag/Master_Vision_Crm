@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/meetings') }}">{{ trans('admin.Meeting') }}</a> :
@endsection
@section("contentheader_description", trans("admin.Add Meeting"))
@section("section", trans("admin.Meetings"))
@section("section_url", url(config('laraadmin.adminRoute') . '/meetings'))
@section("sub_section", trans("admin.Add"))

@section("htmlheader_title", trans("admin.Add Meeting"))

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
                    @include('la.meetings.add-form',['meetingModule'=>$module])
			</div>
		</div>
	</div>
</div>

@endsection

@push('scripts')
<script>
$(function () {
	$("#meeting-add-form").validate({
		
	});
	$("#meeting-add-form .form-group").not(":last").addClass("col-md-6");
        @if(!empty($_GET['contact_id']))
            $("select[name=contact_id]").val("{{$_GET['contact_id']}}").trigger("change");
        @endif
});
</script>
@endpush
