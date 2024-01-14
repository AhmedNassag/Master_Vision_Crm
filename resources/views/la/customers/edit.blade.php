@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/customers') }}">{{ trans('admin.Customer') }}</a> :
@endsection
@section("contentheader_description", $customer->$view_col)
@section("section", trans("admin.Customers"))
@section("section_url", url(config('laraadmin.adminRoute') . '/customers'))
@section("sub_section", trans("admin.Edit"))

@section("htmlheader_title", "Customers Edit : ".$customer->$view_col)

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
				{!! Form::model($customer, ['route' => [config('laraadmin.adminRoute') . '.customers.update', $customer->id ], 'method'=>'PUT', 'id' => 'customer-edit-form', 'files'=>true]) !!}
					@la_form($module)
                    @php
                        $branches = \App\Models\Branch::all();
                    @endphp
                    <div class="form-group">
						<label for="branch_id">{{ trans('admin.Branch') }} :</label>
						<select name="branch_id" class="form-control" id="branch_id" rel="select2">
							<option value=""></option>
							@foreach ($branches as $branch)
								<option @if($customer->branch_id == $branch->id) selected @endif value="{{ $branch->id }}">{{ $branch->name }}</option>
							@endforeach
						</select>
					</div>



					{{--
					@la_input($module, 'gender')
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
					@la_input($module, 'major_id')
					@la_input($module, 'activity_id')
					@la_input($module, 'created_by')
					@la_input($module, 'notes')
					@la_input($module, 'industry_id')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( trans("admin.Update"), ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/customers') }}"> {{trans('admin.Cancel') }}</a></button>
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
	$("#customer-edit-form").validate({

	});
});
</script>
@endpush
