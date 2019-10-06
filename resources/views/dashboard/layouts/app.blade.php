<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>{{ config('app.name', 'Islamic Resource Hub') }} - @yield('title')</title>
        <meta name="description" content="Islamic Resource Hub">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{ asset('irh_assets/vendor/fontawesome/all.min.css') }}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('irh_assets/vendor/bootstrap/bootstrap.min.css') }}" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="{{ asset('irh_assets/vendor/toastr/toastr.min.css') }}">
        <link href="{{ asset('irh_assets/vendor/select2/select2.min.css') }}" rel="stylesheet" />
        <link rel="stylesheet" id="main-stylesheet" data-version="1.1.0" href="{{ asset('irh_assets/vendor/shards_dashboard/styles/shards-dashboards.1.1.0.min.css') }}">
        <link rel="stylesheet" href="{{ asset('irh_assets/vendor/shards_dashboard/styles/extras.1.1.0.min.css') }}">
        <link rel="stylesheet" href="{{ asset('irh_assets/vendor/dropzone/dropzone.css') }}">
        <link rel="stylesheet" href="{{ asset('irh_assets/vendor/DataTables/datatables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('irh_assets/vendor/jquery-ui/jquery-ui.min.css') }}">
        <link rel="stylesheet" href="{{ asset('irh_assets/vendor/summernote/summernote-lite.css') }}">
        <link rel="stylesheet" href="{{ asset('irh_assets/css/custom.css?v=1.0') }}">
        <link rel="icon" href="{{ asset('irh_assets/images/favicon.png') }}" type="png" sizes="32x32">
        @yield('page_styles')
        <style>
            .modal-backdrop
            {
              background: rgb(0,0,0,0.5);
            }
        </style>
        <script async defer src="https://buttons.github.io/buttons.js"></script>
    </head>
    <body class="h-100 pr-0">
        <div class="container-fluid">
            <div class="row">
                @include('dashboard.layouts.sidebar')
                <main class="main-content col-lg-10 col-md-9 col-sm-12 p-0 offset-lg-2 offset-md-3">
                    <div class="main-navbar sticky-top bg-white">
                        @include('dashboard.layouts.nav')
                    </div>
                    <div class="main-content-container container-fluid px-4">
                        @yield('content')
                    </div>
                    @include('dashboard.layouts.footer')
                </main>
            </div>
        </div>
        <!-- JS Files -->
        <script src="{{ asset('irh_assets/vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('irh_assets/vendor/popper/popper.min.js') }}" ></script>
        <script src="{{ asset('irh_assets/vendor/bootstrap/bootstrap.min.js') }}"></script>
        <script src="{{ asset('irh_assets/vendor/toastr/toastr.min.js') }}"></script>
        <script src="{{ asset('irh_assets/vendor/select2/select2.min.js') }}"></script>
        <script src="{{ asset('irh_assets/vendor/dropzone/dropzone.js') }}"></script>
        <script src="{{ asset('irh_assets/vendor/DataTables/datatables.min.js') }}"></script>
        <script src="{{ asset('irh_assets/vendor/jquery-ui/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('irh_assets/vendor/summernote/summernote-lite.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
        <script src="https://unpkg.com/shards-ui@latest/dist/js/shards.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Sharrre/2.0.1/jquery.sharrre.min.js"></script>
        <script src="{{ asset('irh_assets/vendor/shards_dashboard/scripts/extras.1.1.0.min.js') }}"></script>
        <script src="{{ asset('irh_assets/vendor/shards_dashboard/scripts/shards-dashboards.1.1.0.min.js') }}"></script>
        <script src="{{ asset('irh_assets/js/custom.js?v=1') }}"></script>
        <script>
        $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
        $(".selectbox").select2({
        placeholder:"--Choose--"
        });
        $('.summernote').summernote();
        });
        </script>
        @yield('page_scripts')
        @if (Session::has('error'))
        <script type="text/javascript">
        toastr.error("{{ Session::get('error') }}");
        </script>
        @endif
        @if (Session::has('success'))
        <script type="text/javascript">
        toastr.success("{{ Session::get('success') }}");
        </script>
        @endif
        @if (Session::has('info'))
        <script type="text/javascript">
        toastr.info("{{ Session::get('info') }}");
        </script>
        @endif
    </body>
</html>