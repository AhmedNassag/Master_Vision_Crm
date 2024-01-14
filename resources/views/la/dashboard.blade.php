@extends('la.layouts.app')

@section('htmlheader_title')
    {{ trans('admin.Dashboard') }}
@endsection
@section('contentheader_title')
    {{ trans('admin.Dashboard') }}
@endsection
@section('contentheader_description')
    {{ trans('admin.Organisation Overview') }}
@endsection

@section('main-content')
    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">


            <!-- /.col -->
            <div class="col-lg-12 col-md-6">
                <!-- Application buttons -->
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"> الاحصائيات العامه </h3>
                    </div>
                    
                    <div class="box-body">

                        <div class="col-lg-12 col-md-6">
                            <a class="btn btn-app" style="height: auto;">
                                <span class="badge bg-yellow"> 
                                    {{ $contacts_count }} 
                                </span>
                                <i class="fa ion-person-add">
                                    <span style="display:block;">
                                        {{ trans('admin.Contacts') }}
                                    </span>
                                </i> 
                            </a>
                            

                            <a class="btn btn-app" style="height: auto;">
                                <span class="badge bg-navy">  {{ $customers }}  </span>
                                <i class="fa ion-ios-people">
                                    <span style="display:block;">
                                    العملاء الحاليين
                                    </span>
                                </i> 
                            </a>

                            <a class="btn btn-app" style="height: auto;">
                                <span class="badge bg-olive">  {{ $calls_in_today }}  </span>
                                <i class="fa fa-phone">
                                    <span style="display:block;">
                                           {{ trans('admin.Calls Today') }} {{ trans('admin.in') }} 
                                    </span>
                                </i> 
                            </a>


                            <a class="btn btn-app" style="height: auto;">
                                <span class="badge bg-info">  {{ $calls_out_today }}  </span>
                                <i class="fa fa-phone">
                                    <span style="display:block;">
                                           {{ trans('admin.Calls Today') }} {{ trans('admin.out') }} 
                                    </span>
                                </i> 
                            </a>


                            <a class="btn btn-app" style="height: auto;">
                                <span class="badge bg-purple">  {{ $calls_in_month }}  </span>
                                <i class="fa fa-phone">
                                    <span style="display:block;">
                                           {{ trans('admin.Calls Monthly') }} {{ trans('admin.in') }} 
                                    </span>
                                </i> 
                            </a>


                            <a class="btn btn-app" style="height: auto;">
                                <span class="badge bg-red">  {{ $calls_out_month }}  </span>
                                <i class="fa fa-phone">
                                    <span style="display:block;">
                                           {{ trans('admin.Calls Monthly') }} {{ trans('admin.out') }} 
                                    </span>
                                </i> 
                            </a>


                        </div>

                    </div>
                <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
          <!-- /.col -->


            <div class="col-lg-12 col-md-9">
                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-purple">
                        <div class="inner">
                            <h3>{{ $contacts_count }}</h3>
                            <p>{{ trans('admin.Contacts') }}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{ url(config('laraadmin.adminRoute') . '/contacts') }}"
                            class="small-box-footer">{{ trans('admin.More info') }} <i
                                class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->
                <div class="col-md-4 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-orange">
                        <div class="inner">
                            <h3>{{ $customers }}</h3>
                            <p> العملاء</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-ios-people"></i>
                        </div>
                        <a href="{{ url(config('laraadmin.adminRoute') . '/customers') }}"
                            class="small-box-footer">{{ trans('admin.More info') }} <i
                                class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->
                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $calls_in_today }}<sup style="font-size: 20px">{{ trans('admin.in') }}</sup> /
                                {{ $calls_out_today }}<sup style="font-size: 20px">{{ trans('admin.out') }}</sup></h3>
                            <p>{{ $calls_in_today + $calls_out_today }} {{ trans('admin.Calls Today') }}</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <a href="{{ url(config('laraadmin.adminRoute') . '/meetings_report?ctoday=1') }}"
                            class="small-box-footer">{{ trans('admin.More info') }} <i
                                class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->

                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-olive">
                        <div class="inner">
                            <h3>{{ $calls_in_month }}<sup style="font-size: 20px">{{ trans('admin.in') }}</sup> /
                                {{ $calls_out_month }}<sup style="font-size: 20px">{{ trans('admin.out') }}</sup></h3>
                            <p>{{ $calls_in_month + $calls_out_month }} {{ trans('admin.Calls monthly') }}</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <a href="{{ url(config('laraadmin.adminRoute') . '/meetings_report?cmonth=1') }}"
                            class="small-box-footer">{{ trans('admin.More info') }} <i
                                class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->
                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-navy">
                        <div class="inner">
                            <h3>{{ $follow_today_count }}</h3>
                            <p>{{ trans('admin.To follow today') }}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-calendar"></i>
                        </div>
                        <a href="{{ url(config('laraadmin.adminRoute') . '/meetings_report?ftoday=1') }}"
                            class="small-box-footer">{{ trans('admin.More info') }} <i
                                class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->
                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-maroon">
                        <div class="inner">
                            <h3>{{ $meetings_in_today }}<sup style="font-size: 20px">{{ trans('admin.in') }}</sup> /
                                {{ $meetings_out_today }}<sup style="font-size: 20px">{{ trans('admin.out') }}</sup></h3>
                            <p>{{ $meetings_in_today + $meetings_out_today }} {{ trans('admin.Meetings Today') }}</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-handshake-o"></i>
                        </div>
                        <a href="{{ url(config('laraadmin.adminRoute') . '/meetings_report?ctoday=1') }}"
                            class="small-box-footer">{{ trans('admin.More info') }} <i
                                class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->

                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-navy">
                        <div class="inner">
                            <h3>{{ $meetings_in_month }}<sup style="font-size: 20px">{{ trans('admin.in') }}</sup> /
                                {{ $meetings_out_month }}<sup style="font-size: 20px">{{ trans('admin.out') }}</sup></h3>
                            <p>{{ $meetings_in_month + $meetings_out_month }} {{ trans('admin.Meetings monthly') }}</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-handshake-o"></i>
                        </div>
                        <a href="{{ url(config('laraadmin.adminRoute') . '/meetings_report?cmonth=1') }}"
                            class="small-box-footer"> {{ trans('admin.More info') }}<i
                                class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->


                <div class="col-md-4 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $todayReminders }}</h3>
                            <p>تذكيرات اليوم</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-android-notifications"></i>
                        </div>
                        <a href="{{ url(config('laraadmin.adminRoute') . '/today-reminders') }}"
                            class="small-box-footer">{{ trans('admin.More info') }} <i
                                class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->
                <div class="col-md-4 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>{{ $monthReminders }}</h3>
                            <p>تذكيرات الشهر</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-android-notifications"></i>
                        </div>
                        <a href="{{ url(config('laraadmin.adminRoute') . '/month-reminders') }}"
                            class="small-box-footer">{{ trans('admin.More info') }} <i
                                class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->




            </div>
            <div class="col-md-3 col-lg-3">
                @if (!empty($target))
                    <!-- Calendar -->
                    <div class="box box-solid bg-green-gradient">
                        <div class="box-header">
                            <i class="fa fa-long-arrow-up"></i>
                            <h3 class="box-title">{{ trans('admin.Target') }}</h3>
                            <!-- tools box -->
                            <div class="pull-right box-tools">
                                <!-- button with a dropdown -->
                                <button class="btn btn-success btn-sm" data-widget="collapse"><i
                                        class="fa fa-minus"></i></button>
                            </div><!-- /. tools -->
                        </div><!-- /.box-header -->
                        <div class="box-footer text-black">
                            <div class="row">
                                @if (!empty($target->target_amount))
                                    <div class="col-sm-12">
                                        <!-- Progress bars -->
                                        <div class="clearfix">
                                            <span class="pull-left">{{ $did_amount }} / {{ $target->target_amount }}
                                                {{ LAConfigs::getByKey('currency_symbol') }}</span>
                                            <small
                                                class="pull-right">{{ floor(($did_amount / $target->target_amount) * 100) }}%</small>
                                        </div>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-green"
                                                style="width: {{ floor(($did_amount / $target->target_amount) * 100) }}%;">
                                            </div>
                                        </div>
                                    </div><!-- /.col -->
                                @endif
                                @if (!empty($target->target_meeting))
                                    <div class="col-sm-12">
                                        <!-- Progress bars -->
                                        <div class="clearfix">z
                                            <span class="pull-left">{{ $did_meetings }} / {{ $target->target_meeting }}
                                                {{ trans('admin.Calls / Meetings') }}</span>
                                            <small
                                                class="pull-right">{{ floor(($did_meetings / $target->target_meeting) * 100) }}%</small>
                                        </div>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-green"
                                                style="width: {{ floor(($did_meetings / $target->target_meeting) * 100) }}%;">
                                            </div>
                                        </div>
                                    </div><!-- /.col -->
                                @endif

                            </div><!-- /.row -->
                        </div><!-- /.box-body -->

                    </div><!-- /.box -->
                @endif
            </div>
        </div><!-- /.row -->
        <!-- Main row -->
        <div class="row">


            <div class="col-lg-8 col-xs-6">
                <!-- TABLE: LATEST ORDERS -->
                <div class="box box-info ">
                    <div class="box-header with-border">
                    <h3 class="box-title" style="margin-right: 7%;"> اعلى 10 موظفين - مبييعات </h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                    <div class="table-responsive">
                        <table class="table no-margin">
                        <thead>
                        <tr>
                            <th>الأسم</th>
                            <th>عدد العملاء</th>
                            <th>المبلغ</th>
                            <th>الفرع</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($mostSalesEmployees as $employee)

                                @php
                                $uniqueCustomerCount = \App\Models\Invoice::where('created_by', $employee->id)
                                ->distinct('customer_id')
                                ->count();
                                @endphp
                            <tr>
                                <td><a href="#">{{ $employee->name }}</a></td>
                                <td>{{ $uniqueCustomerCount }}</td>
                                <td><span >{{ number_format($employee->invoices_sum_total_amount,0) }} --  ج.م</span></td>
                                <td>
                                <div class="sparkbar" data-color="#00a65a" data-height="20">{{ $employee->branch->name ?? 'لا يوجد' }}</div>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                    </div>
                    <!-- /.box-body -->
                    <!-- /.box-footer -->
                </div>

            </div>

            <div class="col-lg-4 col-xs-6">

                <!-- PRODUCT LIST -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                    <h3 class="box-title" style="margin-right: 12%">أعلى 10 فروع -- مبيعات</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                    <ul class="products-list product-list-in-box">
                        @foreach ($mostSalesBranches as $branch)
                        <li class="item">
                        <div class="product-info">
                            <a href="#" class="product-title">
                                {{ $branch->name }}
                            </a>
                            <span class="pull-right">{{ number_format($branch->total_sales,0) }} --  ج.م</span>
                            <span class="product-description">

                                </span>
                        </div>
                        </li>
                        @endforeach
                    </ul>
                    </div>

                    <!-- /.box-footer -->
                </div>

            </div>

        </div>
        <div class="row">

            <div class="col-lg-3 col-xs-6">
                <!-- PRODUCT LIST -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                    <h3 class="box-title" style="margin-right: 15%"> {{ trans('admin.Top 5') }} {{ trans('admin.Contact sources') }} </h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                    <ul class="products-list product-list-in-box">
                        @foreach ($sources as $one)
                        <li class="item">
                        <div class="product-info">
                            <a href="#" class="product-title">
                                {{ $one->name }}
                            </a>
                            <span class="pull-right">{{ $one->contacts_count }} </span>
                            <span class="product-description">

                                </span>
                        </div>
                        </li>
                        @endforeach
                    </ul>
                    </div>

                    <!-- /.box-footer -->
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <!-- PRODUCT LIST -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                    <h3 class="box-title" style="margin-right: 15%"> {{ trans('admin.Top 5') }} {{ trans('admin.Contact Cities') }} </h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                    <ul class="products-list product-list-in-box">
                        @foreach ($cities as $one)
                        <li class="item">
                        <div class="product-info">
                            <a href="#" class="product-title">
                                {{ $one->name }}
                            </a>
                            <span class="pull-right">{{ $one->contacts_count }} </span>
                            <span class="product-description">

                                </span>
                        </div>
                        </li>
                        @endforeach
                    </ul>
                    </div>

                    <!-- /.box-footer -->
                </div>
            </div>




            <div class="col-lg-3 col-xs-6">
                <!-- PRODUCT LIST -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                    <h3 class="box-title" style="margin-right: 15%"> {{ trans('admin.Top 5') }} {{ trans('admin.Contact Areas') }} </h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                    <ul class="products-list product-list-in-box">
                        @foreach ($areas as $one)
                        <li class="item">
                        <div class="product-info">
                            <a href="#" class="product-title">
                                {{ $one->name }}
                            </a>
                            <span class="pull-right">{{ $one->contacts_count }} </span>
                            <span class="product-description">

                                </span>
                        </div>
                        </li>
                        @endforeach
                    </ul>
                    </div>

                    <!-- /.box-footer -->
                </div>
            </div>




            <div class="col-lg-3 col-xs-6">
                <!-- PRODUCT LIST -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                    <h3 class="box-title" style="margin-right: 15%"> {{ trans('admin.Top 5') }} {{ trans('admin.Meeting Interests') }} </h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                    <ul class="products-list product-list-in-box">
                        @foreach ($interests as $one)
                        <li class="item">
                        <div class="product-info">
                            <a href="#" class="product-title">
                                {{ $one->name }}
                            </a>
                            <span class="pull-right">{{ $one->meetings_count }} </span>
                            <span class="product-description">

                                </span>
                        </div>
                        </li>
                        @endforeach
                    </ul>
                    </div>

                    <!-- /.box-footer -->
                </div>
            </div>




        </div><!-- /.row (main row) -->

    </section><!-- /.content -->
@endsection

@push('styles')
    <!-- Morris chart -->
    <link rel="stylesheet" href="{{ asset('la-assets/plugins/morris/morris.css') }}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ asset('la-assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css') }}">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{ asset('la-assets/plugins/datepicker/datepicker3.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('la-assets/plugins/daterangepicker/daterangepicker-bs3.css') }}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ asset('la-assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
@endpush


@push('scripts')
    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="{{ asset('la-assets/plugins/morris/morris.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('la-assets/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
    <!-- jvectormap -->
    <script src="{{ asset('la-assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('la-assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('la-assets/plugins/knob/jquery.knob.js') }}"></script>
    <!-- daterangepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
    <script src="{{ asset('la-assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- datepicker -->
    <script src="{{ asset('la-assets/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{ asset('la-assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('la-assets/plugins/fastclick/fastclick.js') }}"></script>
    <!-- dashboard
        <script src="{{ asset('la-assets/js/pages/dashboard.js') }}"></script>-->
@endpush

@push('scripts')
    <script>
        (function($) {
            $('body').pgNotification({
                style: 'circle',
                title: '{{ LAConfigs::getByKey('sitename') }}',
                message: "Welcome to {{ LAConfigs::getByKey('sitename') }}...",
                position: "top-right",
                timeout: 0,
                type: "success",
                thumbnail: '<img width="40" height="40" style="display: inline-block;" src="{{ asset('la-assets/img/user2-160x160.jpg') }}" data-src="{{ asset('la-assets/img/user2-160x160.jpg') }}" data-src-retina="{{ asset('la-assets/img/user2-160x160.jpg') }}" alt="">'
            }).show();
        })(window.jQuery);
    </script>
@endpush
