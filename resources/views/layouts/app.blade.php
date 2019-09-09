<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Signika" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" type="text/css">

     <link href="{{ asset('irh_assets/vendor/fontawesome/all.min.css') }}" rel="stylesheet">
     <link rel="stylesheet" href="{{ asset('irh_assets/vendor/bootstrap/bootstrap.min.css') }}" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- Styles -->
    <link href="{{ asset('irh_assets/css/custom.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('irh_assets/images/favicon.png') }}" type="png" sizes="32x32">
    @yield('page_styles')
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-136687170-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-136687170-1');
    </script>

</head>
<body class="pr-0">
    <div id="app">
        <nav class="navbar navbar-expand-md bg-dark navbar-dark sticky-top">
          <a class="navbar-brand pl-5" href="{{ url('/') }}">
              <img src="{{ asset('irh_assets/images/irhsignika.png') }}" alt="" width="auto" height="35">
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item px-3">
                <a class="nav-link" href="{{ route('theme.resources') }}">Resources</a>
              </li>
              <!-- @auth
              <li class="nav-item px-3">
                <a href="{{ route('theme.savedresources') }}" class="nav-link">Saved Resources</a>
              </li>
              @endauth -->
              <li class="nav-item px-2">
                <a class="nav-link" href="{{ route('theme.supportus') }}">Support Us</a>
              </li>
              <li class="nav-item px-2">
                <a class="nav-link" href="{{ route('theme.contactus') }}">Contact Us</a>
              </li>
              <li class="nav-item px-2 navBtn">
                @auth
                <a class="btn bg-yellow btn-block navButton" href="{{ route('dashboard.index') }}">Dashboard</a>
                @else
                <a class="btn bg-yellow btn-block navButton" href="{{ route('login') }}">Sign in</a>
                @endauth
              </li>
            </ul>
          </div>
        </nav>
        <main class="">
            @yield('content')
        </main>
        <footer class="bg-dark py-3 text-center">
        <div class="container">
          <div class="social-icons">
            <span class="px-3"><a href="https://www.facebook.com/islamicresourcehub"><img src="{{ asset('irh_assets/images/facebook.png') }}" alt="" width="30px"></a></span>
            <span class="px-3"><a href="https://www.instagram.com/islamicresourcehub/"><img src="{{ asset('irh_assets/images/instagram.png') }}" alt="" width="30px"></a></span>
            <span class="px-3"><a href="https://twitter.com/IslamicRH"><img src="{{ asset('irh_assets/images/twitter.png') }}" alt="" width="30px"></a></span>
          </div>
          <div class="pt-4  pb-2">
            <p class="text-white">&copy; Copyright {{ date('Y') }} All Rights Reserved | Islamic Resource Hub.</p>
          </div>
          <div class="">
            <small class="text-white"><a href="{{ url('/terms-and-conditions') }}" target="_blank" class="text-white">Terms &amp; Conditions</a> | <a href="{{ url('/privacy-policy') }}" target="_blank" class="text-white">Privacy Policy</a></small>
          </div>
        </div>
      </footer>
      <a href="{{ route('theme.supportus') }}" id="supportUsBtn" style="display: none;">
      <div class="alert bg-blue alert-dismissible fade show" role="alert">
        Help us bring you more free bespoke learning resources by donating to our project
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      </a>
    </div>

    <!-- JS Files -->
    <script src="{{ asset('irh_assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('irh_assets/vendor/popper/popper.min.js') }}" ></script>
    <script src="{{ asset('irh_assets/vendor/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('irh_assets/js/custom.js') }}"></script>
    <script>
      $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
      });
       function saveResource(res,single)
     {
      var html ='';
        $.ajax({
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
              type: 'POST',
              url: "{{ route('theme.saveresource.ajax') }}",
              data: {resource:res},
              success: function (data){
                if(data.success)
                {
                  var path = "{{ asset('irh_assets/images/savedlogo.png') }}";
                  html += `<img src="${path}" alt="" width="30px">`;
                  if(single)
                  {
                    $('#saveResourceContainer').html(html);
                  }
                  else
                  {
                    $('#saveResourceContainer_'+res).html(html);
                  }
                }
              }
       });


     }
    </script>
     @yield('page_scripts')
</body>
</html>
