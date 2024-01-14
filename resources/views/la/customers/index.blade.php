@extends("la.layouts.app")

@section("contentheader_title", trans("admin.Customers"))
@section("contentheader_description", trans("admin.Customers listing"))
@section("section", trans("admin.Customers"))
@section("sub_section", trans("admin.Listing"))
@section("htmlheader_title", trans("admin.Customers Listing"))

@section("headerElems")
@can("Customers-create")
	<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">{{trans('admin.Add Customer') }}</button>
	<button type="submit" class="btn btn-success pull-right" style="margin-left:5px" data-toggle="modal"
                            data-target="#ImportModal">{{ trans('admin.Import Excel') }}</button>

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

@can("Customers-create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">{{ trans('admin.Add Customer') }}</h4>
			</div>
			{!! Form::open(['route' => config('laraadmin.adminRoute').'.customers.store', 'id' => 'customer-add-form', 'files'=>true]) !!}
			<div class="modal-body">
				<div class="box-body">

					@la_input($module, 'name')
					@la_input($module, 'mobile')
					@la_input($module, 'contact_source_id')
					@la_input($module, 'activity_id')
					<hr/>
					@la_input($module, 'mobile2')
					@la_input($module, 'gender')
					@la_input($module, 'email')
                    @la_input($module, 'birth_date')
                    @la_input($module, 'national_id')

					@la_input($module, 'contact_category_id')


					<div class="form-group">
						<label for="industry_id">{{ trans('admin.City') }} :</label>
						<select name="city_id" class="form-control" id="citySelect" rel="select2">
							<option value=""></option>
							@foreach ($cities as $city)
								<option value="{{ $city->id }}">{{ $city->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label for="industry_id">{{ trans('admin.Area') }} :</label>
						<select name="area_id" class="form-control" id="areaSelect" rel="select2">

						</select>
					</div>
					<div class="form-group">
						<label for="industry_id">{{ trans('admin.Industry') }} :</label>
						<select name="industry_id" class="form-control" id="industrySelect" rel="select2">
								<option value=""></option>
							@foreach ($industries as $industry)
								<option value="{{ $industry->id }}">{{ $industry->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label for="industry_id">{{ trans('admin.Major') }} :</label>
						<select name="major_id" class="form-control" id="majorSelect" rel="select2">

						</select>
					</div>
					@la_input($module, 'company_name')
					@la_input($module, 'job_title_id')
					@la_input($module, 'notes')

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

@can('Customers-create')
	<div class="modal fade" id="ImportModal" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">{{ trans('admin.Import Excel') }}</h4>
				</div>
				{!! Form::open([
					'route' => config('laraadmin.adminRoute') . '.customers.import',
					'id' => 'contact-add-form',
					'files' => true,
				]) !!}
				<div class="modal-body">
					<div class="box-body">
						<div class="form-group col-md-6">
							<label for="contact_source_id">{{ trans('admin.Contact Source*') }}</label>
							<select class="form-control" required="1" name="contact_source_id">
								<option value="">{{ trans('admin.All') }}</option>
								@foreach ($contactSources as $source)
									<option value="{{ $source->id }}">{{ $source->name }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group col-md-6">
							<label for="activity_id">{{ trans('admin.Activity') }}* :</label>
							<select class="form-control" required="1" name="activity_id">
								<option value="">{{ trans('admin.All') }}</option>
								@foreach ($activities as $activity)
									<option value="{{ $activity->id }}">{{ $activity->name }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group col-md-12">
							<label>{{ trans('admin.1000 records only') }}</label>
							<input name="contacts_file" type="file" id="excel-file"/>
							<button type="button" class="mt-1 btn btn-primary" id="fetch-columns">Fetch Excel Columns</button>

						</div>
						{{-- <div class="form-group">
							<label>{{ trans('admin.Import Source') }}</label>
							<input name="import_source" type="text" class="form-control" />
						</div> --}}
						<div id="excel-columns-container"></div>
					</div>
				</div>



				<!-- Import button -->

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('admin.Close') }}</button>
					{!! Form::submit(trans('admin.Submit'), ['class' => 'btn btn-success']) !!}
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
	$('#fetch-columns').click(function() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var formData = new FormData();
            formData.append('excel_file', $('#excel-file')[0].files[0]);
            formData.append('_token', csrfToken);
            $.ajax({
                url: '{{route("admin.import.fetch.excel.columns")}}?type=customer',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    // Display fetched Excel columns to the user
                    $('#excel-columns-container').html(data);

                    // Add column mapping dropdowns here
                    // (user selects which contact field corresponds to each Excel column)
                },
                error: function(xhr, status, error) {
                    // Handle errors (e.g., display error messages)
                    var errors = JSON.parse(xhr.responseText);
                    console.log(errors);
                }
            });
        });

	$("#example1").DataTable({
		processing: true,
        serverSide: true,
        ajax: "{{ url(config('laraadmin.adminRoute') . '/customer_dt_ajax') }}",
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
        ],
	});
	$("#customer-add-form").validate({

	});
	 function updateMajorSelect() {
            var mainSelectValue = $("#industrySelect").val();
            var dependentSelect = $("#majorSelect");

            // Clear existing options
            dependentSelect.empty();

            // Fetch options via AJAX
            $.ajax({
                url: "{{ route('admin.majors.ajax') }}", // Replace with the actual URL to fetch options
                method: "GET",
                data: {
                    industry_id: mainSelectValue
                },
                dataType: "json",
                success: function(data) {
                    // Populate options based on the AJAX response
                    dependentSelect.append('<option value=""></option>');
                    $.each(data, function(key, item) {
                        dependentSelect.append("<option value='" + item.id + "'>" + item.name +
                            "</option>");
                    });
                    dependentSelect.select2();
                },
                error: function() {
                    alert("Error fetching options.");
                }
            });
        }

        function updateAreaSelect() {
            var mainSelectValue = $("#citySelect").val();
            var dependentSelect = $("#areaSelect");

            // Clear existing options
            dependentSelect.empty();

            // Fetch options via AJAX
            $.ajax({
                url: "{{ route('admin.areas.ajax') }}", // Replace with the actual URL to fetch options
                method: "GET",
                data: {
                    city_id: mainSelectValue
                },
                dataType: "json",
                success: function(data) {
                    dependentSelect.append('<option value=""></option>');
                    // Populate options based on the AJAX response
                    $.each(data, function(key, item) {
                        dependentSelect.append("<option value='" + item.id + "'>" + item.name +
                            "</option>");
                    });
                    dependentSelect.select2();
                },
                error: function() {
                    alert("Error fetching options.");
                }
            });
        }
        updateAreaSelect();


        $("#citySelect").on("change", updateAreaSelect);
        $("#industrySelect").on("change", updateMajorSelect);
});
</script>
@endpush
