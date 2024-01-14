@extends("la.layouts.app")

@section("contentheader_title", trans("admin.Configuration"))
@section("contentheader_description", "")
@section("section", trans("admin.Configuration"))
@section("sub_section", "")
@section("htmlheader_title", trans("admin.Configuration"))

@section("headerElems")
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
<form action="{{route(config('laraadmin.adminRoute').'.general_settings.store')}}" method="POST" enctype="multipart/form-data">
	<!-- general form elements disabled -->
	<div class="box box-warning">
		<div class="box-header with-border">
			<h3 class="box-title">General Settings</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
			{{ csrf_field() }}
			<!-- text input -->

        <div class="col-lg-6">
            <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Expiration Date:</h3>
                </div>
                <div class="box-body">
                  <div class="row">
                    <div class="col-xs-3">
                        {{-- <label>Expiration Date:</label> --}}

                        <div class="input-group">
                          <input type="date" class="form-control" name="end_date" data-inputmask="'alias': 'dd/mm/yyyy'" value="{{$configs->end_date}}" data-mask>
                        </div>
                    </div>
                  </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>


        <div class="col-lg-6">
            <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Max Users Numbers :</h3>
                </div>
                <div class="box-body">
                  <div class="row">
                    <div class="col-xs-3">
                        {{-- <label>Expiration Date:</label> --}}

                        <div class="input-group">
                          <input type="number" class="form-control" name="max_users" value="{{$configs->max_users}}" >
                        </div>
                    </div>
                  </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>



        <div class="col-lg-6">
            <div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title">Whats App Messgaes Config :</h3>
                </div>
                <div class="box-body">
                  <div class="row">
                    <div class="col-lg-8 col-xs-3">
                        <label>Instance:</label>

                        <div class="input-group">
                          <input type="number" class="form-control" name="whatsapp_instance" value="{{$configs->whatsapp_instance ?? null}}" >
                        </div>
                    </div>

                    <div class="col-lg-8 col-xs-3">
                        <label>Token:</label>

                        <div class="input-group">
                          <input type="text" class="form-control" name="whatsapp_token" value="{{$configs->whatsapp_token ?? null}}" >
                        </div>
                    </div>

                  </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
			
		</div><!-- /.box-body -->
		<div class="box-footer">
			<button type="submit" class="btn btn-primary">Save</button>
		</div><!-- /.box-footer -->
	</div><!-- /.box -->
</form>

@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>

@endpush
