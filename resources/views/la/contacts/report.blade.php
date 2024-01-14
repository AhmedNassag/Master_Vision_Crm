@extends('la.layouts.app')

@section('contentheader_title', trans('admin.Contacts'))
@section('contentheader_description', trans('admin.Contacts Report'))
@section('section', trans('admin.Contacts'))
@section('sub_section', trans('admin.Report'))
@section('htmlheader_title', trans('admin.Contacts Report'))

@section('main-content')

    <div class="box box-success">
        <div class="box-header">
            {{ Form::open(['url' => 'admin/contacts', 'method' => 'get', 'id' => 'contact_search_form']) }}
            <div class="form-group">
                <div class="col-md-12" style="margin-bottom:10px">
                    <div class="col-md-3">
                        <label for="programs">{{ trans('admin.Creation date from') }}</label>
                        <div class='input-group date'>
                            <input class="form-control" placeholder="{{ trans('admin.Creation date from') }}" name="created_at_from"
                                type="text">
                            <span class='input-group-addon'><span class='fa fa-calendar'></span></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="programs">{{ trans('admin.Creation date to') }}</label>
                        <div class='input-group date'>
                            <input class="form-control" placeholder="{{ trans('admin.Creation date to') }}" name="created_at_to" type="text">
                            <span class='input-group-addon'><span class='fa fa-calendar'></span></span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="city_id">{{ trans('admin.City') }}</label>
                        <select name="city_id">
                            <option value=""></option>
                            @foreach ($cities as $key => $val)
                                <option value="{!! $key !!}">{!! $val !!} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="area_id">{{ trans('admin.Area') }}</label>
                        <select name="area_id">
                            <option value="">{{ trans('admin.Select City first') }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-3">
                        <label for="sources">{{ trans('admin.Contact Source') }}</label>
                        <select name="sources">
                            <option value=""></option>
                            @foreach ($sources as $key => $val)
                                <option value="{!! $key !!}">{!! $val !!} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="categories">{{ trans('admin.Contact Category') }}</label>
                        <select name="categories">
                            <option value=""></option>
                            @foreach ($categories as $key => $val)
                                <option value="{!! $key !!}">{!! $val !!} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="industry_id">{{ trans('admin.Industry') }}</label>
                        <select name="industry_id">
                            <option value=""></option>
                            @foreach ($industries as $key => $val)
                                <option value="{!! $key !!}">{!! $val !!} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="major_id">{{ trans('admin.Major') }}</label>
                        <select name="major_id">
                            <option value="">{{ trans('admin.Select Industry first') }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-3">
                        <label for="job">{{ trans('admin.Job Title') }} </label>
                        <select name="job">
                            <option value=""></option>
                            @foreach ($jobs as $key => $emp)
                                <option value="{!! $key !!}">{!! $emp !!} </option>
                            @endforeach

                        </select>
                    </div>
                    @if (!$user->roles[0]['view_data'])
                        <div class="col-md-3">
                            <label for="employee">{{ trans('admin.Employee') }} </label>
                            <select name="employee">
                                <option value=""></option>
                                @foreach ($employees as $key => $emp)
                                    <option value="{!! $key !!}">{!! $emp !!} </option>
                                @endforeach

                            </select>
                        </div>
                    @endif
                    <div class="col-md-3">
                        <input class="btn btn-success" style="margin-top: 25px;" type="submit"
                            value="{{ trans('admin.Search') }}" id="filter" name="filter">
                    </div>

                </div>

            </div>
            {{ Form::close() }}
        </div>
        <div class="box-body">
            <div class="table-responsive">
            <table id="example1" class="table table-bordered" style="display:none">
                <thead>
                    <tr class="success">
                        @foreach ($listing_cols as $col)
                            <th>{{ !empty($module2->fields[$col]) && !empty($module2->fields[$col]['label']) ? trans('admin.'.$module2->fields[$col]['label']) : trans('admin.'.ucfirst($col)) }}
                            </th>
                        @endforeach
                        @if ($show_actions)
                            <th>{{ trans('admin.Actions') }}</th>
                        @endif
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/buttons.dataTables.min.css') }}" />
@endpush

@push('scripts')
    <script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('la-assets/plugins/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('la-assets/plugins/datatables/jszip.min.js') }}"></script>
    <script src="{{ asset('la-assets/plugins/datatables/buttons.html5.min.js') }}"></script>
    <script>
        $(function() {
            $("select[name=sources]").select2();
            $("select[name=employee]").select2();
            $("select[name=categories]").select2();
            $("select[name=city_id]").select2();
            $("select[name=area_id]").select2();
            $("select[name=industry_id]").select2();
            $("select[name=major_id]").select2();
            $("select[name=job]").select2();

            $(document).on('submit', '#contact_search_form', function(e) {
                e.preventDefault();
                $("#example1").show();
                var created_at_from = $('input[name=created_at_from]').val();
                var created_at_to = $('input[name=created_at_to]').val();
                var category = $('select[name=categories]').val();
                var sources = $('select[name=sources]').val();
                var city = $('select[name=city_id]').val();
                var area = $('select[name=area_id]').val();
                var industry = $('select[name=industry_id]').val();
                var major = $('select[name=major_id]').val();
                var job = $('select[name=job]').val();
                var employee = '';
                if ($('select[name=employee]').length > 0)
                    employee = $('select[name=employee]').val();

                $("#example1").DataTable({
                    processing: true,
                    serverSide: true,
                    destroy: true,
                    ajax: "{{ url(config('laraadmin.adminRoute') . '/contact_dt_ajax') }}?issearch=1&created_at_from=" +
                        created_at_from + "&created_at_to=" + created_at_to +
                        "&employee=" + employee + "&sources=" + sources + "&city=" + city +
                        "&area=" + area + "&category=" + category + "&job_title_id=" + job +
                        "&industry_id=" + industry + "&major_id=" + major,
                    language: {
                        lengthMenu: "_MENU_",
                        search: "_INPUT_",
                        searchPlaceholder: "{{ trans('admin.Search') }}"
                    },
                    dom: 'Blfrtip',
                    buttons: [
                        'copy', 'csv', 'excel'
                    ],
                    lengthMenu: [
                        [10, 25, 50, -1],
                        [10, 25, 50, "All"]
                    ],
                    columns: [
                        @foreach ($listing_cols as $col)
                            {
                                data: '{{ $col }}',
                                name: '{{ $col }}'
                            },
                        @endforeach
                        @if ($show_actions)
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false
                            }
                        @endif
                    ]
                });
            });

            $("#contact-add-form").validate({

            });
            $("#contact-add-form .form-group").addClass("col-md-6");
            $(document).on("change", "select[name^=city_id]", function() {
                var city = 0;
                if ($(this).val().length > 0)
                    city = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "{{ url(config('laraadmin.adminRoute') . '/get_areas_by_city') }}/" +
                        city,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response) {
                            var options = [];
                            options.push({
                                text: "Select an area",
                                id: 0
                            });
                            $.each(response, function(key, value) {
                                options.push({
                                    text: value,
                                    id: key
                                });
                            });
                            $("select[name^=area_id]").empty().select2({
                                data: options

                            });
                        } else {
                            $("select[name^=area_id]").empty();
                            var newOption = new Option("Select City first", "", false, false);
                            $("select[name^=area_id]").empty().append(newOption).trigger(
                                "change");
                        }
                    }
                });
            });
            $(document).on("change", "select[name^=industry_id]", function() {
                var industry = 0;
                if ($(this).val().length > 0)
                    industry = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "{{ url(config('laraadmin.adminRoute') . '/get_majors_by_industry') }}/" +
                        industry,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response) {
                            var options = [];
                            options.push({
                                text: "Select a major",
                                id: 0
                            });
                            $.each(response, function(key, value) {
                                options.push({
                                    text: value,
                                    id: key
                                });
                            });
                            $("select[name^=major_id]").empty().select2({
                                data: options

                            });
                        } else {
                            var newOption = new Option("Select Insutry first", "", false,
                            false);
                            $("select[name^=major_id]").empty().append(newOption).trigger(
                                "change");
                        }
                    }
                });
            });
        });
    </script>
@endpush
