@extends("la.layouts.app")

@section("contentheader_title", trans("admin.Attachments"))
@section("contentheader_description", trans("admin.Attachments listing"))
@section("section", trans("admin.Attachments"))
@section("sub_section", trans("admin.Listing"))
@section("htmlheader_title", trans("admin.Attachments Listing"))

@section("headerElems")
@can("Attachments-create")
	<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">{{trans("admin.Add Attachment")}}</button>
@endcan
@endsection

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

<div class="box box-success">
	<!--<div class="box-header"></div>-->
	<div class="box-body">
		<table id="example1" class="table table-bordered">
		<thead>
		<tr class="success">
			@foreach( $listing_cols as $col )
			<th>{{ !empty($module->fields[$col]) && !empty($module->fields[$col]['label'])? trans('admin.'.$module->fields[$col]['label']) : ucfirst($col) }}</th>
			@endforeach
			@if($show_actions)
			<th>{{ trans('admin.Actions') }}</th>
			@endif
		</tr>
		</thead>
		<tbody>
			
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
        serverSide: true,
        ajax: "{{ url(config('laraadmin.adminRoute') . '/attachment_dt_ajax') }}",
		language: {
			lengthMenu: "_MENU_",
			search: "_INPUT_",
			searchPlaceholder: "{{ trans('admin.Search') }}"
		},
		columns: [
			@foreach($listing_cols as $col)
            {data: '{{$col}}' , name: '{{$col}}' },
			@endforeach
            @if($show_actions)
            {data: 'action', name: 'action', orderable: false, searchable: false}
			@endif
        ]
	});
	$("#attachment-add-form").validate({
		
	});
});
</script>
@endpush
