@extends("la.layouts.app")

@section("contentheader_title", trans("إعدادات النقاط"))
@section("contentheader_description", trans("قائمة إعدادات النقاط"))
@section("section", trans("إعدادات النقاط"))
@section("sub_section", trans("القائمة"))
@section("htmlheader_title", trans("قائمة إعدادات النقاط"))

@section("headerElems")
	<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">{{trans("إضافة إعداد النقاط")}}</button>
@endsection

@section("main-content")
<div class="box box-success">
	<!--<div class="box-header"></div>-->
	<div class="box-body">

        <table class="table">
            <thead>
                <tr>
                    <th> النشاط</th>
                    <th> النشاط الفرعي</th>
                    <th>معدل التحويل</th>
                    <th>معدل تحويل المبيعات</th>
                    <th>النقاط</th>
                    <th>أيام الانتهاء</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pointsSettings as $pointsSetting)
                    <tr>
                        <td>{{ $pointsSetting->activity->name ?? null}}</td>
                        <td>{{ $pointsSetting->sub_activity->name ?? null }}</td>
                        <td>{{ $pointsSetting->conversion_rate }}  نقاط/ جنيه</td>
                        <td>{{ $pointsSetting->sales_conversion_rate }} جنيه/{{ $pointsSetting->points }} نقطة</td>
                        <td>{{ $pointsSetting->points }}</td>
                        <td>{{ $pointsSetting->expiry_days }}</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                    الإجراءات <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">

                                    <li><a href="{{ route('admin.pointsSettings.edit', $pointsSetting) }}">تعديل</a></li>
                                    <li>
                                        <form action="{{ route('admin.pointsSettings.destroy', $pointsSetting) }}" method="POST" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete" style="display: block;
                                            padding: 3px 20px;
                                            clear: both;
                                            font-weight: normal;
                                            line-height: 1.42857143;
                                            color: #777;
                                            white-space: nowrap;
                                            background: none;
                                            border: none;">حذف</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $pointsSettings->links() }}
    </div>
</div>

<!-- AddModal -->
<div class="modal fade" id="AddModal" tabindex="-1" role="dialog" aria-labelledby="AddModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="AddModalLabel">{{ trans("إضافة إعداد النقاط") }}</h4>
            </div>
            <div class="modal-body">
                <!-- Include your create form here -->
                <form action="{{ route('admin.pointsSettings.store') }}" method="POST">
                    @csrf

                    <!-- Activity Select -->
                    <div class="form-group">
                        <label for="activity_id">النشاط</label>
                        <select name="activity_id" id="activity_id" class="form-control"  rel="select2">
                            <!-- Populate options based on your activities data -->
                            <option value="">الكل</option>
                            @foreach($activities as $activity)
                                <option value="{{ $activity->id }}">{{ $activity->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sub-Activity Select -->
                    <div class="form-group">
                        <label for="sub_activity_id">النشاط الفرعي</label>
                        <select name="sub_activity_id" id="sub_activity_id" class="form-control"  rel="select2">
                            <option value="">الكل</option>

                            <!-- Populate options based on your sub-activities data -->
                            @foreach($subActivities as $subActivity)
                                <option value="{{ $subActivity->id }}">{{ $subActivity->name }}</option>
                            @endforeach
                        </select>
                    </div>

                     <!-- Points -->
                     <div class="form-group">
                        <label for="points">النقاط</label>
                        <input type="number" name="points" id="points" class="form-control" required>
                    </div>



                    <!-- Sales Conversion Rate -->
                    <div class="form-group">
                        <label for="sales_conversion_rate">عند تحويل النقاط الي اموال كم يحصل بناء علي عدد النقاط اعلاه؟</label>
                        <input type="number" name="sales_conversion_rate" id="sales_conversion_rate" class="form-control" required>
                    </div>


                    <!-- Conversion Rate -->
                    <div class="form-group">
                        <label for="conversion_rate">عند الشراء كم يحصل علي نقاط مقابل كل عملة؟</label>
                        <input type="number" name="conversion_rate" id="conversion_rate" class="form-control" required>
                    </div>

                    <!-- Expiry Days -->
                    <div class="form-group">
                        <label for="expiry_days">مدة الصلاحية</label>
                        <input type="number" name="expiry_days" id="expiry_days" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-success">{{ trans('Submit') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Use SweetAlert for delete confirmation
    $('.delete-form').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        swal({
            title: 'هل أنت متأكد؟',
            text: 'لن يمكنك التراجع عن هذا الإجراء!',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'نعم، قم بالحذف!',
            cancelButtonText: 'إلغاء'
        }).then(function(isConfirm) {
            if (isConfirm) {
                form.submit();
            }
        });
    });
});

</script>
@endpush
