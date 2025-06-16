@extends('layouts.main')

@section('content')
    <div class="container my-4">
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card text-white bg-primary shadow h-100 py-2">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-project-diagram fa-2x"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">Program</h5>
                            <div class="h3 mb-0">{{ $total_program }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card text-white bg-warning shadow h-100 py-2">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-handshake fa-2x"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">Partnership</h5>
                            <div class="h3 mb-0">{{ $total_partnership }}</div>
                        </div>
                    </div>
                </div>
            </div>

             <div class="col-xl-3 col-md-6 mb-4">
                <div class="card text-white bg-info shadow h-100 py-2">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">Testimoni</h5>
                            <div class="h3 mb-0">{{ $total_testimoni }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card text-white bg-secondary shadow h-100 py-2">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">Admin</h5>
                            <div class="h3 mb-0">{{ $total_admin }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    Chart Pengunjung Website
                </div>
                <div class="card-body">
                    <canvas id="myBarChart" width="100%" height="40"></canvas>
                </div>
            </div>
        </div> --}}
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{-- <script>
        const pages = @json($pages);
        const labels = Object.keys(pages);
        const data = Object.values(pages);
        const ctx = document.getElementById('myBarChart').getContext('2d');
        const myBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Page Views',
                    data: data,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                    },
                },
            }
        });
    </script> --}}
@endsection
