@extends("la.layouts.app")

@section("contentheader_title", trans("admin.Meetings"))
@section("contentheader_description", trans("admin.Meetings Report"))
@section("section", trans("admin.Meetings"))
@section("sub_section", trans("admin.Report"))
@section("htmlheader_title", trans("admin.Meetings Report"))

@section("headerElems")
@endsection

@section("main-content")

<div class="box box-success">
	<div class="box-header">
    {{ Form::open(array('url' => 'admin/meetings','method'=>'get','id'=>'meeting_search_form')) }}
    <div class="form-group">
        <div class="col-md-12" style="margin-bottom:10px">
			<div class="col-md-3">
                <label for="programs">{{ trans('admin.Meeting date from') }}</label>
                <div class='input-group date'>
					<input class="form-control" placeholder="{{ trans('admin.Meeting date from') }}" name="created_at_from" type="text" @if(!empty($_GET['ctoday'])) value="{{date("d/m/Y")}}" @elseif(!empty($_GET['cmonth'])) value="01/{{date("m/y")}}" @endif>
					<span class='input-group-addon'><span class='fa fa-calendar'></span></span>
				</div>
            </div>
			<div class="col-md-3">
                <label for="programs">{{ trans('admin.Meeting date to') }}</label>
                <div class='input-group date'>
					<input class="form-control" placeholder="{{ trans('admin.Meeting date to') }}" name="created_at_to" type="text" @if(!empty($_GET['ctoday'])) value="{{date("d/m/Y")}}" @endif>
					<span class='input-group-addon'><span class='fa fa-calendar'></span></span>
				</div>
            </div>
			<div class="col-md-3">
                <label for="programs">{{ trans('admin.Follow up date from') }}</label>
                <div class='input-group date'>
					<input class="form-control" placeholder="{{ trans('admin.Follow up date from') }}" name="follow_date_from" type="text" @if(!empty($_GET['ftoday'])) value="{{date("d/m/Y")}}" @endif>
					<span class='input-group-addon'><span class='fa fa-calendar'></span></span>
				</div>
            </div>
			<div class="col-md-3">
                <label for="programs">{{ trans('admin.Follow up date to') }}</label>
                <div class='input-group date'>
					<input class="form-control" placeholder="{{ trans('admin.Follow up date to') }}" name="follow_date_to" type="text" @if(!empty($_GET['ftoday'])) value="{{date("d/m/Y")}}" @endif>
					<span class='input-group-addon'><span class='fa fa-calendar'></span></span>
				</div>
            </div>
            <div class="col-md-3">
                <label for="interests">{{ trans('admin.Interests') }}</label>
                <select name="interests">
                    <option value=""></option>
                    @foreach( $interests as $key=>$val )
                    <option value="{!! $key !!}" >{!!$val!!} </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="sources">{{ trans('admin.Contact Source') }}</label>
                <select name="sources">
                    <option value=""></option>
                    @foreach( $sources as $key=>$val )
                    <option value="{!! $key !!}">{!!$val!!} </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="contacts">{{ trans('admin.Contact') }}</label>
                <select name="contacts">
                    <option value=""></option>
                    @foreach( $contacts as $key=>$emp )
                    <option value="{!! $key !!}" >{!! $emp !!} </option>
                    @endforeach

                </select>
            </div>
            @if (!$user->roles[0]['view_data'])
            <div class="col-md-3">
                <label for="employee">{{ trans('admin.Employee') }} </label>
                <select name="employee">
                    <option value=""></option>
                    @foreach( $employees as $key=>$emp )
                    <option value="{!! $key !!}" >{!! $emp !!} </option>
                    @endforeach

                </select>
            </div>
            @endif
			<div class="col-md-3">
                <input class="btn btn-success" style="margin-top: 25px;" type="submit" value="{{ trans('admin.Search') }}" id="filter" name="filter">
            </div>
            
        </div>
	  
    </div>
    {{ Form::close() }}
    </div>
	<div class="box-body">
		<table id="example1" class="table table-bordered" style="display:none">
		<thead>
		<tr class="success">
			@foreach( $listing_cols as $col )
			<th>{{ !empty($module2->fields[$col]) && !empty($module2->fields[$col]['label'])? trans('admin.'.$module2->fields[$col]['label']) : trans('admin.'.ucfirst($col)) }}</th>
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
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/buttons.dataTables.min.css') }}"/>
@endpush

@push('scripts')
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('la-assets/plugins/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('la-assets/plugins/datatables/jszip.min.js')}}"></script>
<script src="{{ asset('la-assets/plugins/datatables/buttons.html5.min.js')}}"></script>
<script>
$(function () {
    $("select[name=interests]").select2();
    $("select[name=sources]").select2();
    $("select[name=employee]").select2();
    $("select[name=contacts]").select2();
    
    $(document).on('submit','#meeting_search_form', function(e){
        e.preventDefault();
        $("#example1").show();
        var created_at_from = $('input[name=created_at_from]').val();
        var created_at_to = $('input[name=created_at_to]').val();
        var follow_date_from = $('input[name=follow_date_from]').val();
        var follow_date_to = $('input[name=follow_date_to]').val();
        var interests = $('select[name=interests]').val();
        var sources = $('select[name=sources]').val();
        var contacts = $('select[name=contacts]').val();
        var employee ='';
        if($('select[name=employee]').length>0)
            employee=$('select[name=employee]').val();
        
        $("#example1").DataTable({
		processing: true,
        serverSide: true,
        destroy: true,
        ajax: "{{ url(config('laraadmin.adminRoute') . '/meeting_dt_ajax') }}?issearch=1&created_at_from="+created_at_from+"&created_at_to="+created_at_to+
        "&follow_date_from="+follow_date_from+"&follow_date_to="+follow_date_to+"&employee="+employee+"&interests="+interests+"&sources="+sources+"&contacts="+contacts,
		language: {
			lengthMenu: "_MENU_",
			search: "_INPUT_",
			searchPlaceholder: "{{ trans('admin.Search') }}"
		},
        dom: 'Blfrtip',
        buttons: [
            'copy', 'csv', 'excel'
        ],
        lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
		columns: [
			@foreach($listing_cols as $col)
            {data: '{{$col}}' , name: '{{$col}}' },
			@endforeach
            @if($show_actions)
            {data: 'action', name: 'action', orderable: false, searchable: false}
			@endif
        ]
	});
    });
    
    @if(!empty($_GET['ftoday']) || !empty($_GET['ctoday']) || !empty($_GET['cmonth']))
        $("#meeting_search_form").submit();
    @endif
});
</script>
@endpush
