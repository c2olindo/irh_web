@extends('dashboard.layouts.app')
@section('title', 'Donations')
@section('content')
<!-- Page Header -->
<div class="page-header row no-gutters py-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <span class="text-uppercase page-subtitle">Islamic Resource Hub</span>
        <h3 class="page-title">Donations</h3>
    </div>
</div>
<!-- End Page Header -->
<!-- Small Stats Blocks -->
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
        <div class="card">
            <div class="card-header border-bottom">
                    <h6 class="m-0">All Donations</a></h6>
            </div>
            <div class="card-body p-0 d-flex">
                <table class="table mb-0">
                      <thead class="bg-light">
                        <tr>
                          <th scope="col" class="border-0">Transaction #</th>
                          <th scope="col" class="border-0">Email</th>
                          <th scope="col" class="border-0">Amount</th>
                          <th scope="col" class="border-0">Type</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse($donations as $donation)
                        <tr>
                          <td>{{ $donation->transaction_id }}</td>
                          <td>{{ $donation->email }}</td>
                          <td>{{ $donation->amount }} USD</td>
                          <td>{{ $donation->type }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No Donations Found</td>
                        </tr>
                        @endforelse
                      </tbody>
                    </table>
            </div>
        </div>
    </div>
</div>
@endsection