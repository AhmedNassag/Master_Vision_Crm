@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/customers') }}">{{ trans('admin.Customer') }}</a> :
@endsection
@section("contentheader_description", $invoice->$view_col)
@section("section", trans("admin.Invoices"))
@section("section_url", url(config('laraadmin.adminRoute') . '/customers'))
@section("sub_section", trans("admin.Edit"))

@section("htmlheader_title", "Invoice Edit : ".$invoice->$view_col)

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
				{!! Form::model($invoice, ['route' => [config('laraadmin.adminRoute') . '.customers.update.invoice', $invoice->id ], 'method'=>'PUT', 'id' => 'invoice-edit-form', 'files'=>true]) !!}
					

				
				<div class="form-group">

                            <!-- Invoice Number -->
                            <div class="form-group">
                                <label for="invoice_number">{{ trans('admin.Invoice Number') }}:</label>
                                <input required type="text" class="form-control" id="invoice_number"
                                    name="invoice_number" value="{{ $invoice->invoice_number }}">
                            </div>

                            <!-- Invoice Date -->
                            <div class="form-group">
                                <label for="invoice_date">{{ trans('admin.Invoice Date') }}:</label>
                                <input type="date" required class="form-control" id="invoice_date"
                                    name="invoice_date" value="{{ $invoice->invoice_date }}">
                            </div>

                            <!-- Total Amount -->
                            <div class="form-group">
                                <label for="total_amount">{{ trans('admin.Total Amount') }}:</label>
                                <input type="number" required step="0.01" class="form-control" id="total_amount"
                                    name="total_amount" value="{{ $invoice->total_amount }}">
                            </div>

                            <!-- Amount Paid -->
                            <div class="form-group">
                                <label for="amount_paid">{{ trans('admin.Amount Paid') }}:</label>
                                <input type="number" required step="0.01" class="form-control" id="amount_paid"
                                    name="amount_paid" value="0"  value="{{ $invoice->amount_paid }}">
                            </div>



                            <!-- Debt (Calculated field) -->
                            <div class="form-group">
                                <label for="debt">Debt:</label>
                                <input type="number" step="0.01" class="form-control" id="debt"
                                    name="debt" readonly>
                            </div>


                            <!-- Description -->
                            <div class="form-group">
                                <label for="description">{{ trans('admin.Description') }}:</label>
                                <textarea class="form-control" id="description" name="description"  value="{{ $invoice->description }}" rows="3"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="status">{{ trans('admin.Activity') }}:</label>
                                <select required class="form-control" id="activity_id" name="activity_id">
                                    @foreach (App\Models\Activate::all() as $activity)
                                        <option @if($invoice->activity_id == $activity->id ) selected  @endif value="{{ $activity->id }}">{{ $activity->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="status">{{ trans('admin.Interest') }}:</label>
                                <select  class="form-control" id="interest_id" name="interest_id" >
                                    <option value="{{ $invoice->interest_id  }}">{{ $invoice->interest ? $invoice->interest->name : " ---- " }} </option>
                                </select>
                            </div>

                            <!-- Status -->
                            <div class="form-group">
                                <label for="status">الحالة:</label>
                                <select required class="form-control" id="status" name="status">
                                    <option @if($invoice->status == 'draft' ) selected  @endif value="draft">{{ trans('admin.Draft') }}</option>
                                    <option @if($invoice->status == 'sent' ) selected  @endif value="sent">{{ trans('admin.Sent') }}</option>
                                    <option @if($invoice->status == 'paid' ) selected  @endif value="paid">مدفوع</option>
                                    <option @if($invoice->status == 'void' ) selected  @endif value="void">{{ trans('admin.Void') }}</option>
                                </select>
                            </div>


                        </div>




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
	
	
	function updateSubActivitiesSelect() {
            var mainSelectValue = $("#activity_id").val();
            var dependentSelect = $("#interest_id");

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
	
	
</script>
@endpush
