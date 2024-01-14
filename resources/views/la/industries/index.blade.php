@extends("la.layouts.app")

@section("contentheader_title", trans("admin.Industries"))
@section("contentheader_description", trans("admin.Industries listing"))
@section("section", trans("admin.Industries"))
@section("sub_section", trans("admin.Listing"))
@section("htmlheader_title", trans("admin.Industries Listing"))

@section("headerElems")
@can("Industries-create")
	<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">{{trans("admin.Add Industry")}}</button>
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

@can("Industries-create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">{{trans("admin.Add Industry")}}</h4>
			</div>
			{!! Form::open(['route' => config('laraadmin.adminRoute').'.industries.store', 'id' => 'industry-add-form', 'files'=>true]) !!}
			<div class="modal-body">
				<div class="box-body">
                    @la_form($module)
					
					{{--
					@la_input($module, 'name')
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
        ajax: "{{ url(config('laraadmin.adminRoute') . '/industry_dt_ajax') }}",
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
	$("#industry-add-form").validate({
		
	});
});
</script>
@endpush
