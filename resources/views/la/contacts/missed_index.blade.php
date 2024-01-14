@extends("la.layouts.app")

@section("contentheader_title", trans("admin.Contacts"))
@section("contentheader_description", trans("admin.Contacts Missed Import"))
@section("section", trans("admin.Contacts"))
@section("sub_section", trans("admin.Missed Import"))
@section("htmlheader_title", trans("admin.Contacts Missed Import"))

@section("main-content")

<div class="box box-success">
	<!--<div class="box-header"></div>-->
	<div class="box-body">
		<table id="example1" class="table table-bordered">
		<thead>
                    <tr class="success">
			<th>{{ trans('admin.Name') }}</th>
			<th>{{ trans('admin.Mobile') }}</th>
			<th>{{ trans('admin.Email') }}</th>
			<th>{{ trans('admin.Category') }}</th>
			<th>{{ trans('admin.Source') }}</th>
			<th>{{ trans('admin.City') }}</th>
			<th>{{ trans('admin.Area') }}</th>
			<th>{{ trans('admin.Job Title') }}</th>
			<th>{{ trans('admin.Industry') }}</th>
			<th>{{ trans('admin.Major') }}</th>
			<th>{{ trans('admin.Reason') }}</th>
                    </tr>
		</thead>
		<tbody>
                    @foreach($missed_contacts as $one)
                    <tr>
                        <td>{{$one['row'][0]}}</td>
                        <td>{{$one['row'][1]}}</td>
                        <td>{{$one['row'][2]}}</td>
                        <td>{{$one['row'][3]}}</td>
                        <td>{{$one['row'][4]}}</td>
                        <td>{{$one['row'][5]}}</td>
                        <td>{{$one['row'][6]}}</td>
                        <td>{{$one['row'][7]}}</td>
                        <td>{{$one['row'][8]}}</td>
                        <td>{{$one['row'][9]}}</td>
                        <td>{{$one['type']}}</td>
                    </tr>
                    @endforeach
		</tbody>
		</table>
	</div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script>
$(function () {
	$("#example1").DataTable({
		processing: true,
	});
});
</script>
@endpush
