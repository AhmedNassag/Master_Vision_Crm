<!DOCTYPE html>
<html lang="en">

@section('htmlheader')
    @include('la.layouts.partials.htmlheader')
    <meta name="csrf-token" content="{{ csrf_token() }}">



@show

<body
    class="{{ LAConfigs::getByKey('skin') }} {{ LAConfigs::getByKey('layout') }}
    @if (LAConfigs::getByKey('layout') == 'sidebar-mini') sidebar-collapse @endif"
    bsurl="{{ url('') }}" adminRoute="{{ config('laraadmin.adminRoute') }}"
    style='font-family: DejaVu Sans;font-size: inherit;'
>

    <style>
        .loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f7f9fb;
            transition: opacity 0.75s, visibility 0.75s;
        }

        .loader-hidden {
            opacity: 0;
            visibility: hidden;

        }

        .loader::after {
            content: "";
            width: 75px;
            height: 75px;
            border: 15px solid #dddddd;
            border-top-color: #7449f5;
            border-radius: 50%;
            animation: loading 0.75s ease infinite;
        }

        @keyframes loading {
            from {
                transform: rotate(0turn);
            }

            to {
                transform: rotate(1turn);
            }
        }
    </style>



    <div class="wrapper">

        @include('la.layouts.partials.mainheader')

        @if (LAConfigs::getByKey('layout') != 'layout-top-nav')
            @include('la.layouts.partials.sidebar')
        @endif

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @if (LAConfigs::getByKey('layout') == 'layout-top-nav')
                <div class="container">
            @endif
            @if (!isset($no_header))
                @include('la.layouts.partials.contentheader')
            @endif

            <!-- Main content -->
            <section class="content {{ !empty($no_padding) ? $no_padding : '' }}">
                <!-- Your Page Content Here -->

                @php
                    use Carbon\Carbon;
                    $expirationDate = Carbon::parse(LAConfigs::getByKey('end_date')); // Replace this with your actual expiration date

                    // Get the current date and time
                    $now = Carbon::now();

                    // Calculate the difference
                    $diff = $now->diff($expirationDate);

                    // Access the difference in various units
                    $daysDifference = $diff->days;
                @endphp
                @if ($daysDifference && $daysDifference <= 5)
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="fa fa-fw fa-clock-o"></i> {{ trans('admin.Notes') }}!</h4>
                        سيتم انتهاء الاشتراك خلال {{ $daysDifference }} يوم
                        ---- تاريخ الانتهاء يوم : {{ LAConfigs::getByKey('end_date') }}

                    </div>
                @endif

                @yield('main-content')

                <div class="loader"> </div>
            </section><!-- /.content -->

            @if (LAConfigs::getByKey('layout') == 'layout-top-nav')
        </div>
        @endif
    </div><!-- /.content-wrapper -->

    @include('la.layouts.partials.controlsidebar')

    @include('la.layouts.partials.footer')

    </div><!-- ./wrapper -->

    @include('la.layouts.partials.file_manager')

    @section('scripts')

        <script>
            window.addEventListener("load", () => {
                const loader = document.querySelector(".loader");

                loader.classList.add("loader-hidden");

                loader.addEventListener("load", () => {
                    document.body.removeChild("loader");
                })
            })
        </script>

        @include('la.layouts.partials.scripts')

    @show

</body>

</html>
