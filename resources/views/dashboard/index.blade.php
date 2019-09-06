@extends('dashboard.layouts.app')
@section('title', 'Admin Dashboard')
@section('content')
<!-- Page Header -->
@php
$resources = $likes = $users = $reviews = $views = $downloads = $admins =  null;
if(Auth::user()->hasRole('admin') OR Auth::user()->hasRole('moderator'))
{
$resources = \App\Resource::count();
$users     = \App\User::count();
$downloads   = \App\Resource::sum('downloads');
$views     = \App\Resource::sum('views');
$admins = \App\User::role('admin')->get();
}
if(Auth::user()->hasRole('user'))
{
$resources  = Auth::user()->resources->count();
$likes      = Auth::user()->likes->count();;
$reviews    = Auth::user()->reviews->count();
$views      = Auth::user()->resources->sum('views');
}
@endphp
<div class="page-header row no-gutters py-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <span class="text-uppercase page-subtitle">Dashboard</span>
        <h3 class="page-title">Islamic Resource Hub - Overview</h3>
    </div>
</div>
@if(Auth::user()->hasRole('admin') OR Auth::user()->hasRole('moderator'))
<div class="row">
    <div class="col-lg col-md-6 col-sm-6 mb-4">
        <div class="stats-small stats-small--1 card card-small">
            <div class="card-body p-0 d-flex">
                <div class="d-flex flex-column m-auto">
                    <div class="stats-small__data text-center">
                        <span class="stats-small__label text-uppercase">Total Resources</span>
                        <h6 class="stats-small__value count my-3">{{ $resources }}</h6>
                    </div>
                </div>
                <canvas height="120" class="blog-overview-stats-small-1"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg col-md-6 col-sm-6 mb-4">
        <div class="stats-small stats-small--1 card card-small">
            <div class="card-body p-0 d-flex">
                <div class="d-flex flex-column m-auto">
                    <div class="stats-small__data text-center">
                        <span class="stats-small__label text-uppercase">Total Users</span>
                        <h6 class="stats-small__value count my-3">{{ $users }}</h6>
                    </div>
                </div>
                <canvas height="120" class="blog-overview-stats-small-2"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg col-md-4 col-sm-6 mb-4">
        <div class="stats-small stats-small--1 card card-small">
            <div class="card-body p-0 d-flex">
                <div class="d-flex flex-column m-auto">
                    <div class="stats-small__data text-center">
                        <span class="stats-small__label text-uppercase">Total Downloads</span>
                        <h6 class="stats-small__value count my-3">{{ $downloads }}</h6>
                    </div>
                </div>
                <canvas height="120" class="blog-overview-stats-small-3"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg col-md-4 col-sm-6 mb-4">
        <div class="stats-small stats-small--1 card card-small">
            <div class="card-body p-0 d-flex">
                <div class="d-flex flex-column m-auto">
                    <div class="stats-small__data text-center">
                        <span class="stats-small__label text-uppercase">Views</span>
                        <h6 class="stats-small__value count my-3">{{ $views }}</h6>
                    </div>
                </div>
                <canvas height="120" class="blog-overview-stats-small-4"></canvas>
            </div>
        </div>
    </div>
</div>
@elseif(Auth::user()->hasRole('user'))
<div class="row">
    <div class="col-lg col-md-6 col-sm-6 mb-4">
        <div class="stats-small stats-small--1 card card-small">
            <div class="card-body p-0 d-flex">
                <div class="d-flex flex-column m-auto">
                    <div class="stats-small__data text-center">
                        <span class="stats-small__label text-uppercase">Total Resources</span>
                        <h6 class="stats-small__value count my-3">{{ $resources }}</h6>
                    </div>
                </div>
                <canvas height="120" class="blog-overview-stats-small-1"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg col-md-6 col-sm-6 mb-4">
        <div class="stats-small stats-small--1 card card-small">
            <div class="card-body p-0 d-flex">
                <div class="d-flex flex-column m-auto">
                    <div class="stats-small__data text-center">
                        <span class="stats-small__label text-uppercase">Total Likes</span>
                        <h6 class="stats-small__value count my-3">{{ $likes }}</h6>
                    </div>
                </div>
                <canvas height="120" class="blog-overview-stats-small-2"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg col-md-4 col-sm-6 mb-4">
        <div class="stats-small stats-small--1 card card-small">
            <div class="card-body p-0 d-flex">
                <div class="d-flex flex-column m-auto">
                    <div class="stats-small__data text-center">
                        <span class="stats-small__label text-uppercase">Total Reviews</span>
                        <h6 class="stats-small__value count my-3">{{ $reviews }}</h6>
                    </div>
                </div>
                <canvas height="120" class="blog-overview-stats-small-3"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg col-md-4 col-sm-6 mb-4">
        <div class="stats-small stats-small--1 card card-small">
            <div class="card-body p-0 d-flex">
                <div class="d-flex flex-column m-auto">
                    <div class="stats-small__data text-center">
                        <span class="stats-small__label text-uppercase">Views</span>
                        <h6 class="stats-small__value count my-3">{{ $views }}</h6>
                    </div>
                </div>
                <canvas height="120" class="blog-overview-stats-small-4"></canvas>
            </div>
        </div>
    </div>
</div>
@endif
@if(Auth::user()->hasRole('admin') OR Auth::user()->hasRole('moderator'))
<div class="row">
    <!-- Users Stats -->
    <div class="col-lg-8 col-md-8 col-sm-12 mb-4">
        <div class="card card-small">
            <div class="card-header border-bottom">
                <h6 class="m-0">Monthly Statistics</h6>
            </div>
            <div class="card-body pt-0">
                <canvas height="130" style="max-width: 100% !important;" class="blog-overview-users"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4">
      <div class="card card-small">
            <div class="card-header border-bottom">
                <h6 class="m-0">Admins</h6>
            </div>
            <div class="card-body pt-0">
               <ul class="list-group">
                 @forelse($admins as $admin)
                 <li class="list-group-item"><i class="fa fa-user"></i> {{ $admin->full_name }}</li>
                 @empty
                 <li class="list-group-item">No Admin Found</li>
                 @endforelse
               </ul>
            </div>
        </div>
    </div>
    <!-- End Users Stats -->
  </div>
  @endif

<!-- End Top Referrals Component -->
@endsection
@section('page_scripts')

<script>
    var visitorsOfMonth = [];
    var viewsOfMonth = [];
    $.ajax({
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          type: 'POST',
          url: "{{ route('dashboard.statistics.ajax') }}",
          data: {type:'monthly'},
          success: function (data){
            data.stats.forEach(function(stat){
                visitorsOfMonth.push(stat.visitors);
                viewsOfMonth.push(stat.pageViews);
            });
             //
            // Blog Overview Users
            //

            var bouCtx = document.getElementsByClassName('blog-overview-users')[0];

            // Data
            var bouData = {
              // Generate the days labels on the X axis.
              labels: Array.from(new Array(30), function (_, i) {
                return i === 0 ? 1 : i;
              }),
              datasets: [{
                label: 'Visitors',
                fill: 'start',
                data: visitorsOfMonth,
                backgroundColor: 'rgba(0,123,255,0.1)',
                borderColor: 'rgba(0,123,255,1)',
                pointBackgroundColor: '#ffffff',
                pointHoverBackgroundColor: 'rgb(0,123,255)',
                borderWidth: 1.5,
                pointRadius: 0,
                pointHoverRadius: 3
              }, {
                label: 'Page Views',
                fill: 'start',
                data: viewsOfMonth,
                backgroundColor: 'rgba(255,65,105,0.1)',
                borderColor: 'rgba(255,65,105,1)',
                pointBackgroundColor: '#ffffff',
                pointHoverBackgroundColor: 'rgba(255,65,105,1)',
                borderDash: [3, 3],
                borderWidth: 1,
                pointRadius: 0,
                pointHoverRadius: 2,
                pointBorderColor: 'rgba(255,65,105,1)'
              }]
            };

            // Options
            var bouOptions = {
              responsive: true,
              legend: {
                position: 'top'
              },
              elements: {
                line: {
                  // A higher value makes the line look skewed at this ratio.
                  tension: 0.3
                },
                point: {
                  radius: 0
                }
              },
              scales: {
                xAxes: [{
                  gridLines: false,
                  ticks: {
                    callback: function (tick, index) {
                      // Jump every 7 values on the X axis labels to avoid clutter.
                      return index % 7 !== 0 ? '' : tick;
                    }
                  }
                }],
                yAxes: [{
                  ticks: {
                    suggestedMax: 45,
                    callback: function (tick, index, ticks) {
                      if (tick === 0) {
                        return tick;
                      }
                      // Format the amounts using Ks for thousands.
                      return tick > 999 ? (tick/ 1000).toFixed(1) + 'K' : tick;
                    }
                  }
                }]
              },
              // Uncomment the next lines in order to disable the animations.
              // animation: {
              //   duration: 0
              // },
              hover: {
                mode: 'nearest',
                intersect: false
              },
              tooltips: {
                custom: false,
                mode: 'nearest',
                intersect: false
              }
            };

            // Generate the Analytics Overview chart.
            window.BlogOverviewUsers = new Chart(bouCtx, {
              type: 'LineWithLine',
              data: bouData,
              options: bouOptions
            });



            // Render the chart.
            window.BlogOverviewUsers.render();
          },
          error: function(e) {
              console.log(e);
          }
        });
   
</script>
<script>
    var browsersArr = [];
    var sessionsArr = [];
    $.ajax({
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          type: 'POST',
          url: "{{ route('dashboard.statistics.ajax') }}",
          data: {type:'browser'},
          success: function (data){
           data.browsers.forEach(function(browser){
            browsersArr.push(browser.browser);
            sessionsArr.push(browser.sessions);
           });
           // Users by device pie chart
            //
            // Data
            var ubdData = {
              datasets: [{
                hoverBorderColor: '#ffffff',
                data:  null,
                backgroundColor: [
                  'rgba(0,123,255,0.9)',
                  'rgba(0,123,255,0.5)',
                  'rgba(0,123,255,0.3)'
                ]
              }],
              labels: null
            };
            ubdData.datasets[0].data = sessionsArr;
            ubdData.labels = browsersArr;
            // Options
            var ubdOptions = {
              legend: {
                position: 'bottom',
                labels: {
                  padding: 25,
                  boxWidth: 20
                }
              },
              cutoutPercentage: 0,
              // Uncomment the following line in order to disable the animations.
              // animation: false,
              tooltips: {
                custom: false,
                mode: 'index',
                position: 'nearest'
              }
            };

            var ubdCtx = document.getElementsByClassName('blog-users-by-device')[0];
            window.ubdChart = new Chart(ubdCtx, {
                  type: 'pie',
                  data: ubdData,
                  options: ubdOptions
                });
          },
          error: function(e) {
              console.log(e);
          }
        }); 
    
</script>

@endsection