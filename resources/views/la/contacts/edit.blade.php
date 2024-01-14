@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/contacts') }}">{{ trans('admin.Contact') }}</a> :
@endsection
@section("contentheader_description", $contact->$view_col)
@section("section", trans("admin.Contacts"))
@section("section_url", url(config('laraadmin.adminRoute') . '/contacts'))
@section("sub_section", trans("admin.Edit"))

@section("htmlheader_title", "Contacts Edit : ".$contact->$view_col)

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
				{!! Form::model($contact, ['route' => [config('laraadmin.adminRoute') . '.contacts.update', $contact->id ], 'method'=>'PUT', 'id' => 'contact-edit-form', 'files'=>true]) !!}

					@la_input($module, 'customer_id')
					@la_input($module, 'name')
					@la_input($module, 'mobile')
					@la_input($module, 'contact_source_id')
                    @php
                    $activities = App\Models\Activate::all();
                    @endphp

					<div class="form-group">
                        <label for="activity_id">{{ trans('admin.Activity') }} :</label>
                        <select name="activity_id" class="form-control" id="activitySelect" rel="select2" required>
                            <option value=""></option>
                            @foreach ($activities as $activity)
                                <option @if($activity->id == $contact->activity_id) selected @endif value="{{ $activity->id }}">{{ $activity->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" required>
                        <label for="interest_id">{{ trans('admin.Interest') }} :</label>
                        <select name="interest_id" class="form-control" id="interestSelect" rel="select2">

                        </select>
                    </div>
					<hr/>
					@la_input($module, 'mobile2')
					@la_input($module, 'national_id')
                    <div class="form-group">
                        <label for="birth_date">{{ trans('admin.Birth Date') }} :</label>
                        <input type="date" name="birth_date" value="{{ $contact->birth_date }}" class="form-control">
                    </div>
					@la_input($module, 'gender')
					@la_input($module, 'email')

					@la_input($module, 'contact_category_id')

                            <div class="form-group">
                                <label for="industry_id">{{ trans('admin.City') }} :</label>
                                <select name="city_id" class="form-control" id="citySelect" rel="select2">
                                    <option value=""></option>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city->id }}" @if($contact->city_id == $city->id) selected @endif>{{ $city->name }}</option>
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
                                        <option value="{{ $industry->id }}" @if($contact->industry_id == $industry->id) selected @endif>{{ $industry->name }}</option>
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

                            @la_input($module, 'created_by')
                            <textarea name="notes" class="summernote form-control" >{{ $contact->notes }}</textarea>
                    <br>
					<div class="form-group">
						{!! Form::submit( trans("admin.Update"), ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/contacts') }}">{{ trans('admin.Cancel') }}</a></button>
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
	$("#contact-edit-form").validate({

	});
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
						var selected = (item.id == "{{$contact->major_id}}")?"selected":"";
                        dependentSelect.append("<option "+selected+" value='" + item.id + "'>" + item.name +
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
						var selected = (item.id == "{{$contact->area_id}}")?"selected":"";
                        dependentSelect.append("<option "+selected+" value='" + item.id + "'>" + item.name +
                            "</option>");
                    });
                    dependentSelect.select2();
                },
                error: function() {
                    alert("Error fetching options.");
                }
            });
        }

        function updateSubActivitiesSelect() {
            var mainSelectValue = $("#activitySelect").val();
            var dependentSelect = $("#interestSelect");

            // Clear existing options
            dependentSelect.empty();

            // Fetch options via AJAX
            $.ajax({
                url: "{{ route('admin.interests.ajax') }}", // Replace with the actual URL to fetch options
                method: "GET",
                data: {
                    activity_id: mainSelectValue
                },
                dataType: "json",
                success: function(data) {
                    dependentSelect.append('<option value=""></option>');
                    // Populate options based on the AJAX response
                    $.each(data, function(key, item) {
						var selected = (item.id == "{{$contact->interest_id}}")?"selected":"";
                        dependentSelect.append("<option "+selected+" value='" + item.id + "'>" + item.name +
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
		updateMajorSelect();
        updateSubActivitiesSelect();
        $("#citySelect").on("change", updateAreaSelect);
        $("#industrySelect").on("change", updateMajorSelect);
        $("#activitySelect").on("change", updateSubActivitiesSelect);

</script>
@endpush
