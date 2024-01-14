@extends('la.layouts.app')

@section('htmlheader_title')
    {{ trans('admin.Customer view') }}
@endsection

@push('styles')
    <style>
        .meeting-add-form input {
            width: 49%;
        }
    </style>
@endpush

@section('main-content')
    <style>
        /* Styles for the loader */
        .loader {
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            position: absolute;
            top: 50%;
            left: 50%;
            margin-left: -20px;
            margin-top: -20px;
            display: none;
            /* Initially hidden */
        }

        /* Keyframes for loader animation */
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
    <div class="loader" id="loader"></div>

    <div id="page-content" class="profile2">
        <div class="row" style="margin-top: 20px">
            <div class="container">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-3">
                        <div class="box box-primary">
                            <div class="box-body box-profile">

                                <h3 class="profile-username text-center">{{ $customer->name }}</h3>

                                <p class="text-muted text-center">{{ $customer->mobile }}
                                    {{ $customer->mobile2 ? ', ' . $customer->mobile2 : null }}</p>
                                <div class="row">
                                    <div class="col-md-12">

                                        <a href="{{ url(config('laraadmin.adminRoute') . '/customers/' . $customer->id . '/edit') }}"
                                            class="btn btn-sm btn-edit bg-olive btn-block"><i class="fa fa-pencil"></i>
                                            {{ trans('admin.Edit') }}</a>

                                        <button type="button" data-toggle="modal" data-target="#createReminder"
                                            class="btn btn-sm btn-edit bg-maroon btn-block"><i class="fa fa-plus"></i>
                                            تذكير باعادة المتابعة</button>
                                        <button type="button" data-toggle="modal" data-target="#AddParentModal"
                                            class="btn btn-sm  bg-navy btn-block"><i class="fa fa-plus"></i>
                                            إضافة عميل مرتبط</button>

                                        <button type="button" data-toggle="modal" data-target="#retargetModel"
                                            class="btn btn-sm  bg-orange btn-block"><i class="fa fa-plus"></i>
                                            إعادة استهداف</button>
                                        

                                    </div>
                                    {{-- <div class="col-md-12 mt-1">
                                        @can('Contacts-edit')
                                            <button type="button" data-toggle="modal" data-target="#addAttachment"
                                                class="btn btn-sm btn-edit btn-primary btn-block"><i class="fa fa-plus"></i>
                                                Add Attachment</button>
                                        @endcan
                                    </div> --}}





                                </div>
                                <br />
                                <ul class="list-group list-group-unbordered">
                                    @if ($customer->parent)
                                        <li class="list-group-item">
                                            <b>العميل الاساسي</b> <a class="pull-right"> <a
                                                    href='{{ url(config('laraadmin.adminRoute') . '/customers/' . $customer->parent->id) }}'>{{ $customer->parent->name ?? null }}</a></a>
                                        </li>
                                    @endif

                                    <li class="list-group-item">
                                        <b>{{ trans('admin.Gender') }}</b> <a
                                            class="pull-right">{{ $customer->gender }}</a>
                                    </li>

                                    <li class="list-group-item">
                                        <b>{{ trans('admin.Name') }}</b> <a class="pull-right">{{ $customer->name }}</a>
                                    </li>

                                    <li class="list-group-item">
                                        <b>{{ trans('admin.Mobile') }}</b> <a
                                            class="pull-right">{{ $customer->mobile }}</a>
                                    </li>

                                    <li class="list-group-item">
                                        <b>{{ trans('admin.Another mobile') }}</b> <a
                                            class="pull-right">{{ $customer->mobile2 }}</a>
                                    </li>

                                    <li class="list-group-item">
                                        <b>{{ trans('admin.Email') }}</b> <a class="pull-right">{{ $customer->email }}</a>
                                    </li>

                                    <li class="list-group-item">
                                        <b>{{ trans('admin.Company Name') }}</b> <a
                                            class="pull-right">{{ $customer->company_name }}</a>
                                    </li>

                                    <li class="list-group-item">
                                        <b>{{ trans('admin.Job Title') }}</b> <a
                                            class="pull-right">{{ $customer->jobTitle->name ?? '' }}</a>
                                    </li>



                                    <li class="list-group-item">
                                        <b>{{ trans('admin.Customer Source ID') }}</b> <a
                                            class="pull-right">{{ $customer->customerSource->name ?? '' }}</a>
                                    </li>

                                    <li class="list-group-item">
                                        <b>{{ trans('admin.Branch') }}</b> <a
                                            class="pull-right">{{ $customer->branch->name ?? '' }}</a>
                                    </li>

                                    <li class="list-group-item">
                                        <b>{{ trans('admin.City') }}</b> <a
                                            class="pull-right">{{ $customer->city->name ?? '' }}</a>
                                    </li>

                                    <li class="list-group-item">
                                        <b>{{ trans('admin.Area') }}</b> <a
                                            class="pull-right">{{ $customer->area->name ?? '' }}</a>
                                    </li>

                                    <li class="list-group-item">
                                        <b>{{ trans('admin.Industry') }}</b> <a
                                            class="pull-right">{{ $customer->industry->name ?? '' }}</a>
                                    </li>

                                    <li class="list-group-item">
                                        <b>{{ trans('admin.Major') }}</b> <a
                                            class="pull-right">{{ $customer->major->name ?? '' }}</a>
                                    </li>





                                </ul>

                                <br />

                            </div>
                        </div>

                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">{{ trans('admin.About') }}</h3>
                            </div>

                            <div class="box-body">

                                <hr />
                                <strong><i class="fa fa-file-text-o margin-r-5"></i> {{ trans('admin.Notes') }}</strong>
                                <p>
                                    {!! $customer->notes !!}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-9">

                        <!-- Invoices Tab -->
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#invoices" data-toggle="tab">{{ trans('admin.Invoices') }}</a>
                                </li>
                                <li><a href="#attachments" data-toggle="tab">{{ trans('admin.Attachments') }}</a></li>
                                <li><a href="#contacts" data-toggle="tab">إعادة الإستهداف</a></li>
                                <li><a href="#reminders" data-toggle="tab">التذكيرات</a></li>

                                <li><a href="#relatedCustomers" data-toggle="tab">عملاء مرتبطين</a></li>
                                <li><a href="#points" data-toggle="tab"> نظام النقاط</a></li>



                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane" id="attachments">
                                    <div class="row">

                                        <div class="modal-body">
                                            <div class="box-body">

                                                <input type="hidden" value="{{ $customer->id }}" name="customer_id" />

                                                <table class="table table-bordered" id="attachmentTable">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ trans('admin.Attachment Name') }}</th>
                                                            <th>{{ trans('admin.Thumbnail') }}</th>
                                                            <th>{{ trans('admin.File') }}</th>
                                                            <th>{{ trans('admin.Progress') }}</th>
                                                            <th>{{ trans('admin.Action') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($customer->attachments as $attachment)
                                                            <tr>
                                                                <td>{{ $attachment->attachment_name }}
                                                                </td>
                                                                <td><img src="{{ asset('uploads/thumbnails/' . basename($attachment->attachment)) }}"
                                                                        alt="Thumbnail" id="thumbnail"
                                                                        style="max-width: 100px; max-height: 100px;">
                                                                </td>
                                                                <td>
                                                                    <a href="{{ asset('uploads/' . basename($attachment->attachment)) }}"
                                                                        download="{{ $customer->name }} - {{ $attachment->attachment_name }}"
                                                                        class="btn btn-primary">{{ trans('admin.Download') }}</a>
                                                                </td>
                                                                <td>

                                                                </td>
                                                                <td> <button type="button" class="btn btn-danger"
                                                                        onclick="removeAttachment(this, {{ $attachment->id }})">{{ trans('admin.Remove') }}</button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        <tr>
                                                            <td><input type="text" name="attachment_name[]"
                                                                    class="form-control"
                                                                    placeholder="Enter attachment name">
                                                            </td>
                                                            <td><img src="#" alt="Thumbnail" id="thumbnail"
                                                                    style="max-width: 100px; max-height: 100px; display: none;">
                                                            </td>
                                                            <td><input type="file" name="attachments[]"
                                                                    class="form-control-file"
                                                                    onchange="previewImage(this)">
                                                            </td>
                                                            <td>
                                                                <div class="progress">
                                                                    <div class="progress-bar" role="progressbar"
                                                                        style="width: 0%;" id="progressBar"></div>
                                                                </div>
                                                            </td>
                                                            <td><button type="button" class="btn btn-primary"
                                                                    onclick="uploadFile(this)">{{ trans('admin.Upload') }}</button>
                                                                <button type="button" class="btn btn-danger"
                                                                    onclick="removeAttachment(this)">{{ trans('admin.Remove') }}</button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <button type="button" class="btn btn-success"
                                                    onclick="addRow()">{{ trans('admin.Add Attachment') }}</button>



                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="tab-pane active" id="invoices">
                                    <div class="row">
                                        <div class="col-xs-6">

                                            <div class="small-box bg-green">
                                                <div class="inner">
                                                    <h3>{{ number_format($customer->invoices->sum('amount_paid'), 0) }}<sup
                                                            style="font-size: 20px"> {{ trans('admin.EGP') }}</sup></h3>
                                                    <p>{{ trans('admin.Paid Amounts') }}</p>
                                                </div>
                                                <div class="icon">
                                                    <i class="ion ion-stats-bars"></i>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="col-xs-6">
                                            <div class="small-box bg-danger">
                                                <div class="inner">
                                                    <h3>{{ number_format($customer->invoices->sum('total_amount') - $customer->invoices->sum('amount_paid'), 0) }}<sup
                                                            style="font-size: 20px"> {{ trans('admin.EGP') }}</sup></h3>
                                                    <p> {{ trans('admin.Remaining Amounts') }}</p>
                                                </div>
                                                <div class="icon">
                                                    <i class="ion ion-stats-bars"></i>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">

                                            <button type="button" data-toggle="modal" data-target="#AddInvoice"
                                                class="btn btn-primary"> <i class="fa fa-plus"></i>
                                                {{ trans('admin.Add Invoice') }}</button>
                                        </div>
                                    </div>
                                    <table class="table table-bordered mt-2">
                                        <thead>
                                            <tr>
                                                <th> {{ trans('admin.Invoice Number') }}</th>
                                                <th> {{ trans('admin.Invoice Date') }}</th>
                                                <th> {{ trans('admin.Total Amount') }}</th>
                                                <th> {{ trans('admin.Amount Paid') }}</th>
                                                <th> {{ trans('admin.Debt') }}</th>
                                                <th> النشاط</th>
                                                <th> النشاط الفرعي</th>

                                                <th> {{ trans('admin.Status') }}</th>
												<th> Action </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($customer->invoices as $invoice)
                                                <tr>
                                                    <td>{{ $invoice->invoice_number }}</td>
                                                    <td>{{ $invoice->invoice_date }}</td>
                                                    <td>{{ number_format($invoice->total_amount, 0) }}</td>
                                                    <td>{{ number_format($invoice->amount_paid, 0) }}</td>
                                                    <td>{{ number_format($invoice->debt, 0) }}</td>
                                                    <td>{{ $invoice->activity->name }}</td>
                                                    <td>{{ $invoice->sub_activity->name ?? '' }}</td>


                                                    <td>{{ ucfirst($invoice->status) }}</td>
                                                    <td>
														<a class="btn-sm btn-edit bg-olive btn-block"  href="{{ route('admin.customers.edit.invoice',$invoice->id) }}" > <i class="fa fa-pencil">  </i>  </a>
													</td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane" id="contacts">

                                    <table class="table table-bordered">
                                        <thead>
                                            <th>{{ trans('admin.Status') }}</th>
                                            <th>{{ trans('admin.Name') }}</th>
                                            <th>{{ trans('admin.Phone') }}</th>
                                            <th>{{ trans('admin.Contact source') }}</th>
                                            <th>{{ trans('admin.City') }}</th>
                                            <th>{{ trans('admin.Area') }}</th>
                                            <th>{{ trans('admin.Category') }}</th>
                                            <th>{{ trans('admin.Activity') }}</th>
                                            <th>{{ trans('admin.Interest') }}</th>

                                            <th>{{ trans('admin.Employee Name') }}</th>
                                            <th>{{ trans('admin.Date') }}</th>
                                        </thead>
                                        <tbody>
                                            @foreach (App\Models\Contact::where('customer_id', $customer->id)->get() as $contact)
                                                <tr>
                                                    <td><span
                                                            class="{{ $contact->status_info['class'] }}">{{ $contact->status_info['status'] }}
                                                    </td>
                                                    <td><a href="#" class="load-content"
                                                            data-url="{{ route('admin.contacts.show', ['contact' => $contact->id]) }}">{{ $contact->name }}</a>
                                                    </td>
                                                    <td>{{ $contact->mobile }}</td>
                                                    <td>{{ $contact->contactSource->name ?? '' }}</td>
                                                    <td>{{ $contact->city->name ?? '' }}</td>
                                                    <td>{{ $contact->area->name ?? '' }}</td>
                                                    <td>{{ $contact->contactCategory->name ?? '' }}</td>
                                                    <td>{{ $contact->activity->name ?? '' }}</td>
                                                    <td>{{ $contact->sub_activity->name ?? '' }}</td>

                                                    <td>{{ $contact->employee->name ?? '' }}</td>

                                                    <td>{{ $contact->created_at->format('Y-m-d') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane" id="reminders">
                                    <table id="reorder-reminders-table" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>العميل</th>
                                                <th>الفاتورة</th>
                                                <th>تاريخ التذكير</th>
                                                <th>حالة التذكير</th>
                                                <th>النشاط الفرعي</th>
                                                <th>النشاط</th>
                                                <th>المبلغ المتوقع</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($customer->reminders as $reorderReminder)
                                                <tr>
                                                    <td>{{ $reorderReminder->id }}</td>
                                                    <td>{{ $reorderReminder->customer->name ?? '' }}</td>
                                                    <td>#{{ $reorderReminder->invoice->id ?? '' }}</td>
                                                    <td>{{ $reorderReminder->reminder_date->format('Y-m-d') }}</td>
                                                    <td>{{ $reorderReminder->is_completed ? 'تم التذكير' : 'جديد' }}</td>
                                                    <td>{{ $reorderReminder->interest->name ?? '' }}</td>
                                                    <td>{{ $reorderReminder->activity->name ?? '' }}</td>
                                                    <td>{{ $reorderReminder->expected_amount }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>
                                <div class="tab-pane" id="relatedCustomers">
                                    <table id="related_customers" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>العميل</th>
                                                <th>تاريخ الادخال</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($customer->related_customers as $r_customer)
                                                <tr>
                                                    <td>{{ $r_customer->id }}</td>
                                                    <td><a
                                                            href='{{ url(config('laraadmin.adminRoute') . '/customers/' . $r_customer->id) }}'>{{ $r_customer->name }}</a>
                                                    </td>
                                                    <td>{{ $r_customer->created_at->format('Y-m-d') }}</td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane" id="points">
                                    <div class="row">
                                        <div class="col-xs-6">

                                            <div class="small-box bg-green">
                                                <div class="inner">
                                                    <h3>{{ number_format($customer->calculateSumOfPoints(), 0) }}<sup
                                                            style="font-size: 20px"> نقطة</sup></h3>
                                                    <p>عدد النقاط الصالحة</p>
                                                </div>
                                                <div class="icon">
                                                    <i class="ion ion-stats-bars"></i>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="col-xs-6">

                                            <div class="small-box bg-green">
                                                <div class="inner">
                                                    <h3>{{ number_format($customer->calculatePointsValue(), 0) }}<sup
                                                            style="font-size: 20px"> {{ trans('admin.EGP') }}</sup></h3>
                                                    <p>القيمة المالية للنقاط</p>
                                                </div>
                                                <div class="icon">
                                                    <i class="ion ion-stats-bars"></i>
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered text-center" id="pointsTable">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th scope="col">العميل</th>
                                                            <th scope="col">النشاط</th>
                                                            <th scope="col">النشاط الفرعي</th>
                                                            <th scope="col">النقاط</th>
                                                            <th scope="col">تاريخ انتهاء الصلاحية</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($customer->points as $point)
                                                            <tr>
                                                                <td>{{ $point->customer->name }}</td>
                                                                <td>{{ $point->activity->name }}</td>
                                                                <td>{{ $point->subActivity->name }}</td>
                                                                <td>{{ $point->points }}</td>
                                                                <td>{{ $point->expiry_date }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    @can('Attachments-create')
        <div class="modal fade" id="addAttachment" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"> {{ trans('admin.Add Attachment') }}</h4>
                    </div>

                </div>
            </div>
        </div>
    @endcan

    <div class="modal fade" id="contactModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ trans('admin.Contact Details') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="AddInvoice">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{ trans('admin.Add Invoice') }}
                    </h4>
                </div>
                <form method="POST" action="{{ route('admin.customers.add.invoice') }}">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="invoice[customer_id]" value="{{ $customer->id }}" />

                        <div class="form-group">

                            <!-- Invoice Number -->
                            <div class="form-group">
                                <label for="invoice_number">{{ trans('admin.Invoice Number') }}:</label>
                                <input type="text" class="form-control" id="invoice_number"
                                    name="invoice[invoice_number]">
                            </div>

                            <!-- Invoice Date -->
                            <div class="form-group">
                                <label for="invoice_date">{{ trans('admin.Invoice Date') }}:</label>
                                <input type="date" class="form-control" id="invoice_date"
                                    name="invoice[invoice_date]">
                            </div>

                            <!-- Total Amount -->
                            <div class="form-group">
                                <label for="total_amount">{{ trans('admin.Total Amount') }}:</label>
                                <input type="number" step="0.01" class="form-control" id="total_amount"
                                    name="invoice[total_amount]">
                            </div>

                            <!-- Amount Paid -->
                            <div class="form-group">
                                <label for="amount_paid">{{ trans('admin.Amount Paid') }}:</label>
                                <input type="number" step="0.01" class="form-control" id="amount_paid"
                                    name="invoice[amount_paid]" value="0">
                            </div>



                            <!-- Debt (Calculated field) -->
                            <div class="form-group">
                                <label for="debt">Debt:</label>
                                <input type="number" step="0.01" class="form-control" id="debt"
                                    name="invoice[debt]" readonly>
                            </div>


                            <!-- Description -->
                            <div class="form-group">
                                <label for="description">{{ trans('admin.Description') }}:</label>
                                <textarea class="form-control" id="description" name="invoice[description]" rows="3"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="status">{{ trans('admin.Activity') }}:</label>
                                <select class="form-control" id="activity_id" name="invoice[activity_id]">
                                    @foreach (App\Models\Activate::all() as $activity)
                                        <option value="{{ $activity->id }}">{{ $activity->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="status">{{ trans('admin.Interest') }}:</label>
                                <select class="form-control" id="interest_id" name="invoice[interest_id]" required>
                                    <option value=""></option>
                                </select>
                            </div>

                            <!-- Status -->
                            <div class="form-group">
                                <label for="status">الحالة:</label>
                                <select class="form-control" id="status" name="invoice[status]">
                                    <option value="draft">{{ trans('admin.Draft') }}</option>
                                    <option value="sent">{{ trans('admin.Sent') }}</option>
                                    <option selected value="paid">مدفوع</option>
                                    <option value="void">{{ trans('admin.Void') }}</option>
                                </select>
                            </div>


                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default"
                            data-dismiss="modal">{{ trans('admin.Close') }}</button>
                        <button type="submit" class="btn btn-warning">{{ trans('admin.Add Invoice') }}</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" tabindex="-1" role="dialog" id="createReminder">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">تذكير بموعد متابعة
                    </h4>
                </div>
                <form method="POST" action="{{ route('admin.customers.add.reminder') }}">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="reminder[customer_id]" value="{{ $customer->id }}" />

                        <div class="form-group">



                            <!-- Total Amount -->
                            <div class="form-group">
                                <label for="expected_amount">المبلغ المتوقع:</label>
                                <input type="number" step="0.01" class="form-control" id="expected_amount"
                                    name="reminder[expected_amount]">
                            </div>

                            <div class="form-group">
                                <label for="status">{{ trans('admin.Activity') }}:</label>
                                <select class="form-control" id="activity_id2" name="reminder[activity_id]">
                                    @foreach (App\Models\Activate::all() as $activity)
                                        <option value="{{ $activity->id }}">{{ $activity->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="">{{ trans('admin.Interest') }}:</label>
                                <select class="form-control" id="interest_id2" name="reminder[interest_id]" required>
                                    <option value=""></option>
                                </select>
                            </div>



                            <div class="form-group">
                                <label for=""> تاريخ التذكير:</label>
                                <input type="date" class="form-control" id=""
                                    name="reminder[reminder_date]">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default"
                            data-dismiss="modal">{{ trans('admin.Close') }}</button>
                        <button type="submit" class="btn btn-warning">اضافة التذكير</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" tabindex="-1" role="dialog" id="retargetModel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"> اعادة استهداف العميل
                    </h4>
                </div>

                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12">
                            <!-- Available actions section -->
                            <div class="box" id="actions-box ">
                                <div class="box-header">
                                    <h3 class="box-title">{{ trans('admin.Actions') }}</h3>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="campaign_id"> الحملة</label>
                                            <select name="campaign_id" id="campaign_id" class="form-control"
                                                rel="select2">
                                                <option value=""></option>
                                                @foreach (App\Models\Campaign::all() as $campaign)
                                                    <option value="{{ $campaign->id }}">{{ $campaign->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="new_activity_id">النشاط المستهدف</label>
                                            <select name="new_activity_id" id="new_activity_id" class="form-control"
                                                rel="select2">
                                                <option value=""></option>
                                                @foreach (App\Models\Activate::all() as $activity)
                                                    <option value="{{ $activity->id }}">{{ $activity->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="new_interest_id">النشاط الفرعي المستهدف</label>
                                            <select name="new_interest_id" id="new_interest_id" class="form-control"
                                                rel="select2">
                                                <option value=""></option>

                                            </select>
                                        </div>
                                        <div class="form-group col-md-12">

                                            <button class="btn btn-success"
                                                id="reTargetButton">{{ trans('admin.Re-Target') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    @can('Customers-create')
        <div class="modal fade" id="AddParentModal" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">إضافة عميل مرتبط</h4>
                    </div>
                    {!! Form::open([
                        'route' => config('laraadmin.adminRoute') . '.customers.store',
                        'id' => 'customer-add-form',
                        'files' => true,
                    ]) !!}
                    <div class="modal-body">
                        <div class="box-body">
                            <input type="hidden" name="parent_id" value="{{ $customer->id }}">

                            @la_input($addModule, 'name')
                            @la_input($addModule, 'mobile')
                            @la_input($addModule, 'contact_source_id')
                            @la_input($addModule, 'activity_id')
                            <hr />
                            @la_input($addModule, 'mobile2')
                            @la_input($addModule, 'gender')
                            @la_input($addModule, 'email')
                            @la_input($addModule, 'birth_date')
                            @la_input($addModule, 'national_id')

                            @la_input($addModule, 'contact_category_id')

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
                            @la_input($addModule, 'company_name')
                            @la_input($addModule, 'job_title_id')
                            @la_input($addModule, 'notes')

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default"
                            data-dismiss="modal">{{ trans('admin.Close') }}</button>
                        {!! Form::submit(trans('admin.Submit'), ['class' => 'btn btn-success']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    @endcan





@endsection
@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}" />
@endpush

@push('scripts')
    <script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
    <script>
        var totalAmountInput = $('#total_amount');
        var amountPaidInput = $('#amount_paid');
        var debtInput = $('#debt');



        $('#reorder-reminders-table').DataTable();
        $('#related_customers').DataTable();
        $('#pointsTable').DataTable();





        $('#reTargetButton').click(function() {

            var newActivityId = $('select[name="new_activity_id"]').val();
            var campaign_id = $('select[name="campaign_id"]').val();
            @if(isset($customer->invoices->first()->activity->id))
            var activity_id = {{ $customer->invoices->first()->activity->id }};
            @else
            var activity_id = newActivityId;
            @endif
            var new_interest_id = $('select[name="new_interest_id"]').val();

            // Add your data validation logic here
            if (!newActivityId || !activity_id || !new_interest_id || !campaign_id) {
                // Show an error message or perform appropriate actions for validation failure
                swal({
                    icon: 'error',
                    title: 'تأكد من صحة البيانات',
                    type: 'error',
                });
            } else {
                // Disable the button and show "Loading..." while making the AJAX request
                $('#reTargetButton').prop('disabled', true).html('Loading...');

                // Perform AJAX request to the 'marketing.post.retarget.results' route
                $.ajax({
                    url: "{{ route('admin.marketing.post.retarget.results') }}",
                    type: 'POST',
                    data: {
                        ids: [{{ $customer->id }}],
                        new_activity_id: newActivityId,
                        activity_id: activity_id,
                        campaign_id: campaign_id,
                        new_interest_id: new_interest_id,
                        _token: '{{ csrf_token() }}', // Add CSRF token for security
                    },
                    success: function(response) {
                        if (response.success) {
                            // Show success message using SweetAlert
                            var cm_name = 'تم بنجاح';
                            swal({
                                icon: 'success',
                                title: 'اعادة استهداف',
                                text: cm_name,
                            });

                            // Clear and reset the form elements
                            $('select[name="new_activity_id"]').val('');
                            $('select[name="new_activity_id"]').trigger('change');
                            $('select[name="new_interest_id"]').val('');
                            $('select[name="new_interest_id"]').trigger('change');

                        } else {
                            swal({
                                icon: 'error',
                                title: 'تأكد من صحة البيانات',
                                type: 'error',
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle AJAX error, if needed
                        console.error(xhr.responseText);
                        $('#reTargetButton').prop('disabled', false).html(
                            '{{ trans('admin.Re-Target') }}');
                    },
                    complete: function() {
                        // Re-enable the "Re-Target" button and reset its text
                        $('#reTargetButton').prop('disabled', false).html(
                            '{{ trans('admin.Re-Target') }}');
                    }
                });
            }
        });

        // Attach an input event listener to all relevant fields
        totalAmountInput.add(amountPaidInput).on('input', function() {
            var totalAmount = parseFloat(totalAmountInput.val()) || 0;
            var amountPaid = parseFloat(amountPaidInput.val()) || 0;

            // Calculate the debt
            var debt = totalAmount - amountPaid;

            // Update the debt input field
            debtInput.val(debt.toFixed(2));
        });
        // Function to add a new row to the table
        function addRow() {
            var newRow = `
                <tr>
                    <td><input type="text" name="attachment_name[]" class="form-control" placeholder="Enter attachment name"></td>
                    <td><img src="#" alt="Thumbnail" id="thumbnail" style="max-width: 100px; max-height: 100px; display: none;"></td>
                    <td><input type="file" name="attachments[]" class="form-control-file" onchange="previewImage(this)"></td>
                    <td>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 0%;" id="progressBar"></div>
                        </div>
                    </td>
                    <td class="buttons-container"><button type="button" class="btn btn-primary" onclick="uploadFile(this)">{{ trans('admin.Upload') }}</button><button type="button" class="btn btn-danger" onclick="removeAttachment(this)">{{ trans('admin.Remove') }}</button></td>
                </tr>
            `;
            $('#attachmentTable tbody').append(newRow);
        }

        // Function to remove a row from the table
        function removeAttachment(button, attachmentId = '') {
            // Check if the attachment is existing (data-existing="true")
            var isExisting = (attachmentId == '') ? false : true;

            if (isExisting) {
                // Use AJAX to delete the existing attachment
                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.attachments.delete.ajax') }}', // Replace with your delete route
                    data: {
                        attachmentId: attachmentId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {

                        $(button).closest('tr').remove();
                    },
                    error: function(xhr, textStatus, errorThrown) {

                        console.error(errorThrown);
                    }
                });
            } else {

                $(button).closest('tr').remove();
            }
        }


        function previewImage(input) {
            var thumbnail = $(input).closest('tr').find('img#thumbnail');
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    thumbnail.attr('src', e.target.result);
                    thumbnail.css('display', 'block');
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                thumbnail.css('display', 'none');
            }
        }

        function uploadFile(button) {
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            var fileInput = $(button).closest('tr').find('input[type="file"]');
            var formData = new FormData();
            formData.append('attachment_name', $(button).closest('tr').find('input[name="attachment_name[]"]').val());
            formData.append('attachment_file', fileInput[0].files[0]);
            formData.append('customer_id', {{ $customer->id }})
            // Create a new XMLHttpRequest
            var xhr = new XMLHttpRequest();

            // Configure the request
            xhr.open('POST', '{{ route('admin.attachments.store.ajax') }}', true);
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);

            // Define a progress event handler
            xhr.upload.addEventListener('progress', function(e) {
                if (e.lengthComputable) {
                    var percentComplete = (e.loaded / e.total) * 100;
                    $('#progressBar').css('width', percentComplete.toFixed(2) + '%');
                }
            });

            // Define a load event handler
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    swal({
                        icon: 'success',
                        title: 'Successfully Uploaded',
                        type: 'success',
                    });
                    var buttonContainer = $(button).parent('td');
                    buttonContainer.empty();
                    buttonContainer.append(
                        `<button type="button" class="btn btn-danger" onclick="removeAttachment(this,${response.attachment_id})">Remove</button>`
                    );
                } else if (xhr.status === 422) {

                    var response = JSON.parse(xhr.responseText);
                    var errors = response.errors;
                    swal({
                        icon: 'error',
                        title: 'خطأ في الادخال',
                        type: 'error',
                        text: 'Please correct the following errors:',
                        html: formatErrors(errors),
                    });

                } else {

                    swal({
                        icon: 'error',
                        type: 'error',
                        title: 'Validation Error',
                        text: 'Upload failed with status: ' + xhr.status,
                    });
                }
            };

            xhr.onerror = function() {


                swal({
                    icon: 'error',
                    type: 'error',
                    title: 'Validation Error',
                    text: 'Upload failed with an error',
                });
            };

            xhr.send(formData);
        }

        function formatErrors(errors) {
            let html = '<ul>';
            for (const error in errors) {
                if (errors.hasOwnProperty(error)) {
                    html += `<li>${errors[error]}</li>`;
                }
            }
            html += '</ul>';
            return html;
        }

        $(document).ready(function() {
            $('.load-content').on('click', function(e) {
                e.preventDefault();

                var link = $(this);
                var url = link.data('url');
                var modal = $('#contactModel');
                var loader = $('#loader');
                loader.show();
                // Use AJAX to fetch content from the URL
                $.get(url, function(data) {
                    // Create a temporary element to hold the content
                    var tempElement = $('<div>').html(data);

                    // Extract the specific element you want to display in the modal
                    var contentToDisplay = tempElement.find('#taps_section');

                    // Update the modal content with the extracted element
                    modal.find('.modal-body').html(contentToDisplay.attr('class', ''));

                    // Show the modal
                    loader.hide();
                    modal.modal('show');
                });
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
        updateSubActivitiesSelect();
        $("#activity_id").on("change", updateSubActivitiesSelect);


        function updateSubActivitiesSelect2() {
            var mainSelectValue = $("#activity_id2").val();
            var dependentSelect = $("#interest_id2");

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

        function updateSearchSubActivitiesSelect() {
            var mainSelectValue = $("#new_activity_id").val();
            var dependentSelect = $("#new_interest_id");

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
        $("#new_activity_id").on("change", updateSearchSubActivitiesSelect);

        updateSubActivitiesSelect2();
        $("#activity_id2").on("change", updateSubActivitiesSelect2);
    </script>
@endpush
