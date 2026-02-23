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

        <div class="col-md-4 mb-3">
            <div class="card shadow h-100">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-journal-check"></i> Total Borrowings</h5>
                    <p class="card-text" style="font-size: 24px;">{{ $borrowings->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2 mb-4">
        <div class="col-lg-8 mb-3">
            <div class="card shadow h-100">
                <div class="card-body">
                    <h5 class="card-title mb-3">Borrowing Trend (Last 6 Months)</h5>
                    <div style="height: 320px;">
                        <canvas id="borrowTrendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-3">
            <div class="card shadow h-100">
                <div class="card-body">
                    <h5 class="card-title mb-3">Borrowing Status</h5>
                    <div style="height: 320px;">
                        <canvas id="borrowingStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow h-100">
                <div class="card-body">
                    <h5 class="card-title mb-3">Products Per Category</h5>
                    <div style="height: 320px;">
                        <canvas id="productsPerCategoryChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    const monthlyBorrowingLabels = @json($monthlyBorrowingLabels);
    const monthlyBorrowingData = @json($monthlyBorrowingData);
    const borrowingStatusLabels = @json($borrowingStatusLabels);
    const borrowingStatusData = @json($borrowingStatusData);
    const productsPerCategoryLabels = @json($productsPerCategoryLabels);
    const productsPerCategoryData = @json($productsPerCategoryData);

    new Chart(document.getElementById('borrowTrendChart'), {
        type: 'line',
        data: {
            labels: monthlyBorrowingLabels,
            datasets: [{
                label: 'Borrowings',
                data: monthlyBorrowingData,
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.2)',
                borderWidth: 2,
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });

    new Chart(document.getElementById('borrowingStatusChart'), {
        type: 'doughnut',
        data: {
            labels: borrowingStatusLabels,
            datasets: [{
                data: borrowingStatusData,
                backgroundColor: ['#0d6efd', '#198754', '#dc3545'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    new Chart(document.getElementById('productsPerCategoryChart'), {
        type: 'bar',
        data: {
            labels: productsPerCategoryLabels,
            datasets: [{
                label: 'Total Products',
                data: productsPerCategoryData,
                backgroundColor: '#0d6efd'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
</script>

@endsection
