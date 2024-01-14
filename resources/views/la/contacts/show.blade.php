@extends('la.layouts.app')

@section('htmlheader_title')
    {{ trans('admin.Contact View') }}
@endsection

@push('styles')
    <style>
        .meeting-add-form input {
            width: 49%;
        }

        .progress .progress-bar {
            background-color: red;
            /* Default color */
        }

        .progress .progress-bar.low {
            background-color: red;
            /* 0% - 25% */
        }

        .progress .progress-bar.medium {
            background-color: orange;
            /* 25% - 50% */
        }

        .progress .progress-bar.high {
            background-color: blue;
            /* 50% - 75% */
        }

        .progress .progress-bar.complete {
            background-color: green;
            /* 75% - 100% */
        }
    </style>
@endpush

@section('main-content')

    <div id="page-content" class="profile2">

        <div class="row" style="margin-top:20px">
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

                                <h3 class="profile-username text-center">{{ $contact->name }}</h3>
                                <p class="text-center"><span
                                        class="{{ $contact->status_info['class'] }}">{{ $contact->status_info['status'] }}</span>
                                </p>
                                <p class="text-muted text-center">{{ $contact->mobile }}
                                    {{ $contact->mobile2 ? ', ' . $contact->mobile2 : null }}</p>
                                @php
                                    $completionPercentage = $contact->completion_percentage;
                                @endphp
                                <p class="text-muted "><b>نسبة الاكمال: {{ $completionPercentage }}%</b></p>
                                <div class="progress">
                                    <div class="progress-bar {{ ($completionPercentage >= 90) ? 'complete' : (($completionPercentage >= 50) ? 'high' : (($completionPercentage >= 25) ? 'medium' : 'low')) }}"
                                        role="progressbar"
                                        style="width: {{ $completionPercentage }}%;"
                                        aria-valuenow="{{ $completionPercentage }}" aria-valuemin="0" aria-valuemax="100">

                                        <span class="sr-only">{{ $completionPercentage }}% </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        @can('Contacts-edit')
                                            <a href="{{ url(config('laraadmin.adminRoute') . '/contacts/' . $contact->id . '/edit') }}"
                                                class="btn btn-sm btn-edit bg-olive btn-block"><i class="fa fa-pencil"></i>
                                                {{ trans('admin.Edit') }}</a>
                                        @endcan
                                    </div>
                                    {{-- <div class="col-md-12">
                                        @can('Contacts-delete')
                                            {{ Form::open(['route' => [config('laraadmin.adminRoute') . '.contacts.destroy', $contact->id], 'method' => 'delete', 'style' => 'display:inline']) }}
                                            <button class="btn btn-danger btn-sm btn-block" type="submit"><i
                                                    class="fa fa-times"></i>
                                                Delete</button>
                                            {{ Form::close() }}
                                        @endcan
                                    </div> --}}


                                    <div class="col-md-12 mt-1">
                                        @can('Contacts-edit')
                                            <button type="button" data-toggle="modal" data-target="#createCall"
                                                class="btn btn-sm btn-edit bg-navy btn-block"><i class="fa fa-plus"></i>
                                                {{ trans('admin.Add Call') }}</button>
                                        @endcan
                                    </div>

                                    <div class="col-md-12 mt-1">
                                        @can('Contacts-edit')
                                            <button type="button" data-toggle="modal" data-target="#changeStatus"
                                                class="btn btn-sm btn-edit  bg-maroon btn-block"><i class="fa fa-pencil"></i>
                                                {{ trans('admin.Change Status') }}</button>
                                        @endcan
                                    </div>
                                    @if($contact->customer_id)
                                        <div class="col-md-12 mt-1">
                                            @can('Customers-view')
                                                <a href="{{ url(config('laraadmin.adminRoute') . '/customers/' . $contact->customer_id) }}"
                                                    class="btn btn-sm  bg-olive btn-block"><i class="fa fa-eye"></i>
                                                    {{ trans('admin.Customer Profile') }}</a>
                                            @endcan
                                        </div>
                                    @endif
{{--
                                    <div class="col-md-12 mt-1">
                                        @can('Customers-view')
                                            <button type="button" data-target="#retargetModal" data-toggle="modal" class="btn btn-sm  bg-primary btn-block"><i
                                                    class="fa fa-mouse-pointer"></i>
                                                {{ trans('admin.Re-Target') }}</button>
                                        @endcan
                                    </div> --}}

                                    <div class="col-md-12 mt-1">
                                        @can('Customers-view')
                                            <button type="button" data-target="#assignModal" data-toggle="modal"
                                                class="btn btn-sm  bg-info btn-block"><i class="fa fa-plus"></i>
                                                {{ trans('admin.Assign') }}</button>
                                        @endcan
                                    </div>



                                </div>
                                <br />
                                <ul class="list-group list-group-unbordered">

                                    <li class="list-group-item">
                                        <b>{{ trans('admin.Employee') }}</b> <a
                                            class="pull-right">{{ $contact->employee->name ?? null }}</a>
                                    </li>

                                    <li class="list-group-item">
                                        <b>{{ trans('admin.Gender') }}</b> <a
                                            class="pull-right">{{ $contact->gender }}</a>
                                    </li>

                                    <li class="list-group-item">
                                        <b>{{ trans('admin.Name') }}</b> <a class="pull-right">{{ $contact->name }}</a>
                                    </li>

                                    <li class="list-group-item">
                                        <b>{{ trans('admin.Mobile') }}</b> <a
                                            class="pull-right">{{ $contact->mobile }}</a>
                                    </li>

                                     <li class="list-group-item">
                                        <b>{{ trans('admin.Activity') }}</b> <a
                                            class="pull-right">{{ $contact->activity->name ?? '' }}</a>
                                    </li>

                                    <li class="list-group-item">
                                        <b>{{ trans('admin.Interest') }}</b> <a
                                            class="pull-right">{{ $contact->sub_activity->name ?? '' }}</a>
                                    </li>

                                    <li class="list-group-item">
                                        <b>{{ trans('admin.National ID') }}</b> <a
                                            class="pull-right">{{ $contact->national_id }}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>{{ trans('admin.Birth Date') }}</b> <a
                                            class="pull-right">{{ $contact->birth_date }}</a>
                                    </li>



                                    <li class="list-group-item">
                                        <b>{{ trans('admin.Another mobile') }}</b> <a
                                            class="pull-right">{{ $contact->mobile2 }}</a>
                                    </li>

                                    <li class="list-group-item">
                                        <b>{{ trans('admin.Email') }}</b> <a class="pull-right">{{ $contact->email }}</a>
                                    </li>

                                    <li class="list-group-item">
                                        <b>{{ trans('admin.Company Name') }}</b> <a
                                            class="pull-right">{{ $contact->company_name }}</a>
                                    </li>

                                    <li class="list-group-item">
                                        <b>{{ trans('admin.Job Title') }}</b> <a
                                            class="pull-right">{{ $contact->jobTitle->name ?? '' }}</a>
                                    </li>

                                    <li class="list-group-item">
                                        <b>{{ trans('admin.Contact Category') }}</b> <a
                                            class="pull-right">{{ $contact->contactCategory->name ?? '' }}</a>
                                    </li>

                                    <li class="list-group-item">
                                        <b>{{ trans('admin.Contact Source ID') }}</b> <a
                                            class="pull-right">{{ $contact->contactSource->name }}</a>
                                    </li>

                                    <li class="list-group-item">
                                        <b>{{ trans('admin.City') }}</b> <a
                                            class="pull-right">{{ $contact->city->name ?? '' }}</a>
                                    </li>

                                    <li class="list-group-item">
                                        <b>{{ trans('admin.Area') }}</b> <a
                                            class="pull-right">{{ $contact->area->name ?? '' }}</a>
                                    </li>

                                    <li class="list-group-item">
                                        <b>{{ trans('admin.Industry') }}</b> <a
                                            class="pull-right">{{ $contact->industry->name ?? '' }}</a>
                                    </li>

                                    <li class="list-group-item">
                                        <b>{{ trans('admin.Major') }}</b> <a
                                            class="pull-right">{{ $contact->major->name ?? '' }}</a>
                                    </li>

                                    @php

function isValidURL($url) {
    return filter_var($url, FILTER_VALIDATE_URL) !== false;
}
                                    @endphp
                                    @if($contact->custom_attributes)
                                        @foreach ($contact->custom_attributes as $attribute)
                                            @if(isset($attribute['attribute_label']) && isset($attribute['attribute_value']))
                                            <li class="list-group-item">
                                                <b>{{ $attribute['attribute_label'] ?? null }}</b>
                                                @if(isValidURL($attribute['attribute_value']))
                                                <a href="{{ $attribute['attribute_value'] ?? null}}"
                                                class="pull-right" target="_blank">إضغط لرؤية المرفق</a>
                                                @else
                                                <a
                                                class="pull-right">{{ $attribute['attribute_value'] ?? null}}</a>
                                                @endif
                                            </li>

                                            @endif
                                        @endforeach

                                    @endif






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
                                    {!! $contact->notes!!}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-9" id="taps_section">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#timeline" data-toggle="tab">{{ trans('admin.History') }}</a>
                                </li>
                                <li><a href="#comp_time" data-toggle="tab">تاريخ الاكتمال</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="active tab-pane" id="timeline">
                                    <ul class="timeline timeline-inverse">
                                        @foreach ($histories as $date => $history)
                                            <li class="time-label">
                                                <span class="bg-red"> {{ $date }} </span>
                                            </li>
                                            @foreach ($history as $timelineItem)
                                                @if ($timelineItem->action == App\Constants\LeadHistory\Actions::CALL_CREATED)
                                                    <li>
                                                        <i class="fa fa-phone bg-blue"></i>
                                                        <div class="timeline-item">
                                                            <span class="time"><i class="fa fa-clock-o"></i>
                                                                {{ $timelineItem->created_at->format('H:i') }}</span>
                                                            <h3 class="timeline-header">
                                                                {{ $timelineItem->createdBy->name }}
                                                                {{ trans('admin.Added a new call/meeting') }}
                                                            </h3>
                                                            <div class="timeline-body">
                                                                @php
                                                                    $meeting = \App\Models\Meeting::find($timelineItem->related_model_id);
                                                                @endphp
                                                                <b>{{ trans('admin.Type & Place') }}</b>
                                                                <p>
                                                                    {{ $meeting->type . ' (' . $meeting->meeting_place . ') ' }}
                                                                </p>
                                                                <b>{{ trans('admin.Reply') }}</b>
                                                                <p>{{ $meeting->reply->reply ?? '' }}</p>
                                                                <b>{{ trans('admin.Notes') }}:</b>
                                                                <p>
                                                                    {{strip_tags( $timelineItem->placeholders_array['notes'] )}}
                                                                </p>
                                                                <b>{{ trans('admin.Next Followup date') }}:</b>
                                                                <p>
                                                                    {{ $timelineItem->placeholders_array['follow_date'] }}
                                                                </p>
                                                            </div>

                                                        </div>
                                                    </li>
                                                @elseif($timelineItem->action == App\Constants\LeadHistory\Actions::STATUES_CHANGED)
                                                    <li>
                                                        <i class="fa fa-phone bg-blue"></i>
                                                        <div class="timeline-item">
                                                            <span class="time"><i class="fa fa-clock-o"></i>
                                                                {{ $timelineItem->created_at->format('H:i') }}</span>
                                                            @php
                                                                $logContact = \App\Models\Contact::find($timelineItem->related_model_id);
                                                            @endphp

                                                            <h3 class="timeline-header">
                                                                {{ $timelineItem->createdBy->name }}
                                                                {{ trans('admin.changed status from') }}
                                                                {{ $timelineItem->placeholders_array['from'] }} to <span>
                                                                    {{ $timelineItem->placeholders_array['to'] }}</span>
                                                            </h3>

                                                        </div>
                                                    </li>
                                                @endif
                                            @endforeach
                                        @endforeach

                                        <li>
                                            <i class="fa fa-clock-o bg-gray"></i>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-pane" id="comp_time">
                                    <h3>تقرير الاكمال لكل موظف</h3>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>الموظف</th>
                                                <th>الحقول المكتملة</th>
                                                <th>نسبة الاكمال</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($completedData as $data)
                                                <tr>
                                                    <td>{{ $data->user?$data->user->name:"----" }}</td>
                                                    <td>
                                                        <ul>
                                                            @foreach (explode(',', $data->fields) as $field)
                                                                <li>{{ trans('admin.' . $field) }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                    <td>{{ $data->completion_percentage }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <h3>تقرير اكمال البيانات بتاريخ الاكمال ونسبة الاكمال</h3>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>تاريخ الاكمال</th>
                                                <th>نسبة الاكمال في هذا الوقت</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($completionByDate as $data)
                                                <tr>
                                                    <td>{{ $data->date_creation }}</td>
                                                    <td>{{ $data->completion_percentage }}%</td>
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


    <!-- The modal -->
    <div class="modal fade" id="assignModal" tabindex="-1" role="dialog" aria-labelledby="assignModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="assignModalLabel">{{ trans('admin.Assign Employee') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="branchSelect">{{ trans('admin.Select Branch') }}</label>
                            <select class="form-control" id="branchSelect" rel="select2">
                                <option value=""></option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="employeeSelect">{{ trans('admin.Select Employee') }}</label>
                            <select class="form-control" id="employeeSelect" rel="select2">


                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">{{ trans('admin.Close') }}</button>
                    <button type="button" class="btn btn-primary"
                        id="assignButton">{{ trans('admin.Assign') }}</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="retargetModal" tabindex="-1" role="dialog" aria-labelledby="retargetModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="retargetModalLabel">{{ trans('admin.Re-Target') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        @php
                        $activities = \App\Models\Activate::all();
                        @endphp
                        <div class="form-group col-md-3">
                            <label for="activity_id">{{ trans('admin.Activity') }}* :</label>
                            <select class="form-control" required="1" name="activity_id" id="retargetActivityId">
                                <option value="">{{ trans('admin.All') }}</option>
                                @foreach ($activities as $activity)
                                    <option value="{{ $activity->id }}">{{ $activity->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="employeeSelect">{{ trans('admin.Select Employee') }}</label>
                            <select class="form-control" id="retargetEmployeeSelect" rel="select2">
                                <option value="">اختر موظفا اذا كنت تريد الاستهداف والتعيين</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">{{ trans('admin.Close') }}</button>
                    <button type="button" class="btn btn-primary"
                        id="reTargetButton">{{ trans('admin.Re-Target') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="createCall">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{ trans('admin.Create Call/Meeting') }}</h4>
                </div>
                <div class="modal-body">
                    @include('la.meetings.add-form', [
                        'meetingModule' => $meetingModule,
                        'contact' => $contact,
                        'notes_module' => $notesModule,
                    ])
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" tabindex="-1" role="dialog" id="changeStatus">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{ trans('admin.Change Status from') }} <span
                            class="{{ $contact->status_info['class'] }}">{{ $contact->status_info['status'] }}</span>
                    </h4>
                </div>
                <form method="POST" action="{{ route('admin.lead.status.change') }}">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="contact_id" value="{{ $contact->id }}" />
                        <div class="form-group">
                            <label for="status">{{ trans('admin.Change Status To') }}:</label>
                            <select class="form-control" id="status" name="status">
                                <option value="contacted">{{ trans('admin.Contacted') }}</option>
                                <option value="qualified">{{ trans('admin.Qualified') }}</option>
                                <option value="converted">{{ trans('admin.Converted') }}</option>
                            </select>
                        </div>
                        <div class="form-group" id="invoice-fields" style="display: none;">

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
                                <label for="debt">{{ trans('admin.Debt') }}:</label>
                                <input type="number" step="0.01" class="form-control" id="debt"
                                    name="invoice[debt]" readonly>
                            </div>


                            <!-- Description -->
                            <div class="form-group">
                                <label for="description">{{ trans('admin.Description') }}:</label>
                                <textarea class="form-control" id="description" name="invoice[description]" rows="3"></textarea>
                            </div>


                            <div class="form-group">
                                <label>{{ trans('admin.Activity') }}:</label>
                                <input class="form-control disabled" disabled value="{{ $contact->activity->name ?? '' }}" readonly>
                            </div>

                            <div class="form-group">
                                <label>{{ trans('admin.Interest') }}:</label>
                                <input class="form-control disabled" disabled value="{{ $contact->sub_activity->name ?? '' }}" readonly>
                            </div>


                            <input type="hidden" name="invoice[activity_id]" value="{{ $contact->activity_id }}" />

                            <input type="hidden" name="invoice[interest_id]" value="{{ $contact->interest_id }}" />

                            <!-- Status -->
                            <div class="form-group">
                                <label for="status">{{ trans('admin.Status') }}:</label>
                                <select class="form-control" id="status" name="invoice[status]">
                                    <option value="draft">{{ trans('admin.Draft') }}</option>
                                    <option value="sent">{{ trans('admin.Sent') }}</option>
                                    <option selected value="paid">{{ trans('admin.Paid') }}</option>
                                    <option value="void">{{ trans('admin.Void') }}</option>
                                </select>
                            </div>
                            {{-- <div class="form-group">
                                <label for="">التذكير التالي للمبيعات:</label>
                                <input type="date" class="form-control" id=""
                                    name="next_reorder_reminder">
                            </div> --}}
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default"
                            data-dismiss="modal">{{ trans('admin.Close') }}</button>
                        <button type="submit" class="btn btn-warning">{{ trans('admin.Change Status') }}</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            var totalAmountInput = $('#total_amount');
            var amountPaidInput = $('#amount_paid');
            var debtInput = $('#debt');

            // Attach an input event listener to all relevant fields
            totalAmountInput.add(amountPaidInput).on('input', function() {
                var totalAmount = parseFloat(totalAmountInput.val()) || 0;
                var amountPaid = parseFloat(amountPaidInput.val()) || 0;

                // Calculate the debt
                var debt = totalAmount - amountPaid;

                // Update the debt input field
                debtInput.val(debt.toFixed(2));
            });
            $('#status').change(function() {
                if ($(this).val() === 'converted') {
                    $('#invoice-fields').show();
                } else {
                    $('#invoice-fields').hide();
                }
            });
        });


        const csrfToken = $('meta[name="csrf-token"]').attr('content');


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });

        // $('#reTargetButton').click(function() {
        //     var selectedRows = $('input[name="selectedRows[]"]:checked').map(function() {
        //         return $(this).val();
        //     }).get();
        //     var newActivityId = $('#retargetActivityId').val();
        //     var activity_id = {{ $contact->activity_id }};
        //     var assignedEmployee = $('#retargetEmployeeSelect').val();
        //       $('#reTargetButton').prop('disabled', true).html('Loading...');

        //     // Perform AJAX request to the 'marketing.post.retarget.results' route
        //     $.ajax({
        //         url: "{{ route('admin.marketing.post.retarget.results') }}",
        //         type: 'POST',
        //         data: {
        //             ids: [{[$contact->id]}],
        //             new_activity_id: newActivityId,
        //             activity_id:activity_id,
        //             employee_id:assignedEmployee,
        //             _token: '{{ csrf_token() }}', // Add CSRF token for security
        //         },
        //         success: function(response) {
        //              if (response.success) {
        //                      $('#retargetModal').modal('hide');
        //                     // Show success message using SweetAlert
        //                     var cm_name = 'تم انشاء '+ response.name+ 'بنجاح';
        //                     swal({
        //                         icon: 'success',
        //                         title: 'اعادة استهداف',
        //                         text: cm_name,
        //                     });

        //                 } else {
        //                       swal({
        //                         icon: 'error',
        //                         title: 'تأكد من صحة البيانات',
        //                         type: 'error',
        //                     });

        //                 }
        //         },
        //         error: function(xhr, status, error) {
        //             // Handle AJAX error, if needed
        //             console.error(xhr.responseText);
        //              $('#reTargetButton').prop('disabled', false).html(`{{ trans('admin.Re-Target') }}`);
        //         },
        //         complete: function() {
        //             // Re-enable the "Re-Target" button and reset its text
        //             $('#reTargetButton').prop('disabled', false).html(`{{ trans('admin.Re-Target') }}`);
        //         }
        //     });
        // });

        $('#assignButton').click(function() {
            const selectedEmployeeId = $('#employeeSelect').val();

            if (!selectedEmployeeId) {
                // Handle the case where no employee is selected
                alert('Please select an employee to assign.');
                return;
            }

            const selectedContactIds = [{{ $contact->id }}];

            // Perform an AJAX request to assign the selected records to the selected employee
            $.ajax({
                type: 'POST',
                url: '{{ route('admin.contacts.ajax.assign') }}', // Replace with the actual route
                data: {
                    employee_id: selectedEmployeeId,
                    contact_ids: selectedContactIds
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {

                        $('#assignModal').modal('hide');

                        swal({
                                icon: 'success',
                                title: 'تم التكليف بنجاح',
                                text: "",
                            });


                    } else {
                        // Handle failure, e.g., show an error message
                        alert('Failed to assign selected records. Please try again.');
                    }
                },
                error: function(error) {
                    // Handle AJAX error, e.g., show an error message
                    alert('An error occurred while assigning records. Please try again later.');
                    console.error('Error:', error);
                }
            });
        });

        function updateEmployeeSelect() {
            var mainSelectValue = $("#branchSelect").val();
            var dependentSelect = $("#employeeSelect");

            // Clear existing options
            dependentSelect.empty();

            // Fetch options via AJAX
            $.ajax({
                url: "{{ route('admin.employees.ajax') }}", // Replace with the actual URL to fetch options
                method: "GET",
                data: {
                    branch_id: mainSelectValue
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
        updateEmployeeSelect();
        $("#branchSelect").on("change", updateEmployeeSelect);
    </script>
@endpush
