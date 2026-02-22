@extends('layouts.main')

@section('container')
<div class="mx-3 container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mt-2 pb-2 mb-3">
        <h3>Welcome, {{ auth()->user()->name }}!</h3>
    </div>

  <div class="row">
    <div class="col-md-4 mb-3">
        <div class="card shadow h-100">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-people-fill"></i> Total Users</h5>
                <p class="card-text" style="font-size: 24px;">{{ $users->count() }}</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card shadow h-100">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-box-fill"></i> Total Products</h5>
                <p class="card-text" style="font-size: 24px;">{{ $products->count() }}</p>
            </div>
        </div>
    </div>

  </div>
</div>

@endsection
