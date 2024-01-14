@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/messages') }}">{{trans("admin.Message")}}</a> :
@endsection
@section("section", trans("admin.Messages"))
@section("section_url", url(config('laraadmin.adminRoute') . '/messages'))
@section("sub_section", trans("admin.Add"))

@section("htmlheader_title", trans("admin.Messages")." ".trans("admin.Add")." : ")

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
			<div class="col-md-12">
				{!! Form::model(null, ['route' => [config('laraadmin.adminRoute') . '.messages.store' ], 'method'=>'POST', 'id' => 'message-edit-form', 'files'=>true]) !!}
				
					<div class="form-group col-md-6" >
						<label>{{ trans('admin.Reciever Type') }}:</label>
						<select required name="branchable_type" id="reciever_type_select" required data-token="{{csrf_token()}}" class="form-control">
								<option value="">{{ trans('admin.Select Reciever Type') }}</option>
							@foreach ($types as $type)

								<option value="{{ $type['id'] }}">{{ $type['name'] }}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group col-md-6" id="reciever_type_dev">
						<label>{{ trans('admin.Item') }}:</label>
						<select required name="reciever_id[]" id="item_select" multiple required select2 rel="select2" class="form-control select2">
							<option value="">{{ trans('admin.Select Item') }}</option>
						</select>
					</div>
				
				
				
					<div class="form-group col-md-6">
						<label for="notes">{{ trans('admin.Message') }} :</label>
						<textarea required class="form-control" placeholder="Enter Messages" cols="30" rows="3" name="message">
						</textarea>
					</div>


                    <br>
					<div class="form-group col-md-12">
						{!! Form::submit( trans("admin.Send"), ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/messages') }}">{{trans("admin.Cancel")}}</a></button>
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
	$("#message-edit-form").validate({
		
	});
	$("#message-edit-form .form-group").not(":last").addClass("col-md-6");
});
</script>

<script>
	$('#reciever_type_select').on('change',function (e) {
		e.preventDefault();
		var reciever_type_id = $(this).val();
		console.log('her is reciever_type_id');
		console.log(reciever_type_id);
		if(reciever_type_id!=3){
			// reciever_type_dev
			$('#reciever_type_dev').show();
			var token = $(this).data('token');

			var url = "/get-data-by-reciever-type";
			$.ajax({
				url: url ,
				method: 'get',
				data: {
					"_token": token,
					"id": reciever_type_id,
				},

				beforeSend: function () {
					// $('#backData').html('<div class="loader"></div>');
				},
				success: function (data) {
					if (data.status == '1'){
						$('#item_select').html('').append(data.msg);
					}
				},

			})
		}else{
			$('#reciever_type_dev').hide();
		}
		
	})
    </script>

@endpush
