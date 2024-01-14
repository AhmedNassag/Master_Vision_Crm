@extends('la.layouts.app')

@section('contentheader_title', trans('إعدادات النقاط'))
@section('contentheader_description', trans('قائمة إعدادات النقاط'))
@section('section', trans('إعدادات النقاط'))
@section('sub_section', trans('القائمة'))
@section('htmlheader_title', trans('قائمة إعدادات النقاط'))

@section('main-content')
    <div class="box box-success">
        <!--<div class="box-header"></div>-->
        <div class="box-body">
            <form action="{{ route('admin.pointsSettings.update', $pointsSetting->id) }}" method="POST">
                @csrf
                @method('PUT') <!-- Use the PUT method for updates -->

                <!-- Activity Select -->
                <div class="form-group">
                    <label for="activity_id">النشاط</label>
                    <select name="activity_id" id="activity_id" class="form-control" rel="select2">
                        <!-- Populate options based on your activities data -->
                        <option value="">الكل</option>
                        @foreach ($activities as $activity)
                            <option value="{{ $activity->id }}"
                                {{ $pointsSetting->activity_id == $activity->id ? 'selected' : '' }}>
                                {{ $activity->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Sub-Activity Select -->
                <div class="form-group">
                    <label for="sub_activity_id">النشاط الفرعي</label>
                    <select name="sub_activity_id" id="sub_activity_id" class="form-control" rel="select2">
                        <option value="">الكل</option>

                        <!-- Populate options based on your sub-activities data -->
                        @foreach ($subActivities as $subActivity)
                            <option value="{{ $subActivity->id }}"
                                {{ $pointsSetting->sub_activity_id == $subActivity->id ? 'selected' : '' }}>
                                {{ $subActivity->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Points -->
                <div class="form-group">
                    <label for="points">النقاط</label>
                    <input type="number" name="points" id="points" class="form-control"
                        value="{{ $pointsSetting->points }}" required>
                </div>

                <!-- Sales Conversion Rate -->
                <div class="form-group">
                    <label for="sales_conversion_rate">عند تحويل النقاط الى أموال كم يحصل بناء على عدد النقاط أعلاه؟</label>
                    <input type="number" name="sales_conversion_rate" id="sales_conversion_rate" class="form-control"
                        value="{{ $pointsSetting->sales_conversion_rate }}" required>
                </div>

                <!-- Conversion Rate -->
                <div class="form-group">
                    <label for="conversion_rate">عند الشراء كم يحصل على نقاط مقابل كل عملة؟</label>
                    <input type="number" name="conversion_rate" id="conversion_rate" class="form-control"
                        value="{{ $pointsSetting->conversion_rate }}" required>
                </div>

                <!-- Expiry Days -->
                <div class="form-group">
                    <label for="expiry_days">مدة الصلاحية</label>
                    <input type="number" name="expiry_days" id="expiry_days" class="form-control"
                        value="{{ $pointsSetting->expiry_days }}" required>
                </div>

                <button type="submit" class="btn btn-success">{{ trans('Update') }}</button>
            </form>
        </div>
    </div>
@endsection
