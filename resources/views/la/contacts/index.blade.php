@extends("la.layouts.app")

@section("contentheader_title", trans("admin.Contacts"))
@section("contentheader_description", trans("admin.Contacts listing"))
@section("section", trans("admin.Contacts"))
@section("sub_section", trans("admin.Listing"))
@section("htmlheader_title", trans("admin.Contacts Listing"))

@section("headerElems")
@can("Contacts-create")
	<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">{{trans('admin.Add Contact') }}</button>
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

@can("Contacts-create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">{{ trans('admin.Add Contact') }}</h4>
			</div>
			{!! Form::open(['route' => config('laraadmin.adminRoute').'.contacts.store', 'id' => 'contact-add-form', 'files'=>true]) !!}
			<div class="modal-body">
				<div class="box-body">
                    @la_form($module)
					
					{{--
					@la_input($module, 'gender')
					@la_input($module, 'customer_id')
					@la_input($module, 'name')
					@la_input($module, 'mobile')
					@la_input($module, 'mobile2')
					@la_input($module, 'email')
					@la_input($module, 'company_name')
					@la_input($module, 'job_title_id')
					@la_input($module, 'contact_category_id')
					@la_input($module, 'contact_source_id')
					@la_input($module, 'city_id')
					@la_input($module, 'area_id')
					@la_input($module, 'industry_id')
					@la_input($module, 'major_id')
					@la_input($module, 'activity_id')
					@la_input($module, 'created_by')
					@la_input($module, 'notes')
					--}}
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('admin.Close') }}</button>
				{!! Form::submit( trans('admin.Submit'), ['class'=>'btn btn-success']) !!}
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endcan

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
        ajax: "{{ url(config('laraadmin.adminRoute') . '/contact_dt_ajax') }}",
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
	$("#contact-add-form").validate({
		
	});
});
</script>
@endpush
