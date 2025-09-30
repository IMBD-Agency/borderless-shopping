@extends('layouts.backend')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Dashboard</h1>
        <p class="page-description">Welcome to your admin dashboard - Overview of your business performance</p>
    </div>

    <!-- Key Metrics Cards -->
    <div class="dashboard-grid mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title">Total Orders</h5>
                <div class="card-icon primary">
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>
            <div class="card-value">{{ number_format($stats['total_orders']) }}</div>
            <div class="card-change {{ $stats['order_growth'] >= 0 ? 'positive' : 'negative' }}">
                <i class="fas fa-arrow-{{ $stats['order_growth'] >= 0 ? 'up' : 'down' }}"></i>
                <span>{{ abs($stats['order_growth']) }}% from last month</span>
            </div>
            <div class="card-subtitle">This month: {{ $stats['current_month_orders'] }}</div>
        </div>

        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title">Total Revenue</h5>
                <div class="card-icon success">
                    <i class="fas fa-dollar-sign"></i>
                </div>
            </div>
            <div class="card-value">৳{{ number_format($stats['total_revenue'], 2) }}</div>
            <div class="card-change {{ $stats['revenue_growth'] >= 0 ? 'positive' : 'negative' }}">
                <i class="fas fa-arrow-{{ $stats['revenue_growth'] >= 0 ? 'up' : 'down' }}"></i>
                <span>{{ abs($stats['revenue_growth']) }}% from last month</span>
            </div>
            <div class="card-subtitle">This month: ৳{{ number_format($stats['current_month_revenue'], 2) }}</div>
        </div>

        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title">Total Users</h5>
                <div class="card-icon warning">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="card-value">{{ number_format($stats['total_users']) }}</div>
            <div class="card-change positive">
                <i class="fas fa-user-plus"></i>
                <span>Registered customers</span>
            </div>
            <div class="card-subtitle">Active users</div>
        </div>

        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title">Pending Orders</h5>
                <div class="card-icon error">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
            <div class="card-value">{{ number_format($stats['pending_orders']) }}</div>
            <div class="card-change {{ $stats['pending_orders'] > 0 ? 'negative' : 'positive' }}">
                <i class="fas fa-{{ $stats['pending_orders'] > 0 ? 'exclamation-triangle' : 'check-circle' }}"></i>
                <span>{{ $stats['pending_orders'] > 0 ? 'Needs attention' : 'All processed' }}</span>
            </div>
            <div class="card-subtitle">Awaiting processing</div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <!-- Monthly Trends Chart -->
        <div class="col-lg-8 mb-4">
            <div class="dashboard-card chart-card">
                <div class="card-header">
                    <h5 class="card-title">Order Trends</h5>
                    <div class="card-actions">
                        <button class="btn btn-sm btn-primary" onclick="toggleChartType()">
                            <i class="fas fa-chart-line"></i> Toggle View
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="trendsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Order Status Distribution -->
        <div class="col-lg-4 mb-4">
            <div class="dashboard-card chart-card">
                <div class="card-header">
                    <h5 class="card-title">Order Status</h5>
                </div>
                <div class="card-body">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Status & Recent Orders Row -->
    <div class="row ">
        <!-- Payment Status -->
        <div class="col-lg-4 mb-4">
            <div class="dashboard-card">
                <div class="card-header">
                    <h5 class="card-title">Payment Status</h5>
                </div>
                <div class="card-body">
                    <div class="payment-stats">
                        <div class="payment-stat-item">
                            <div class="payment-stat-label">
                                <span class="payment-stat-color paid"></span>
                                <span>Paid</span>
                            </div>
                            <div class="payment-stat-value">
                                <strong>{{ $paymentStats['paid_orders'] }}</strong>
                                <small>({{ $paymentStats['paid_percentage'] }}%)</small>
                            </div>
                        </div>
                        <div class="payment-stat-item">
                            <div class="payment-stat-label">
                                <span class="payment-stat-color pending"></span>
                                <span>Pending</span>
                            </div>
                            <div class="payment-stat-value">
                                <strong>{{ $paymentStats['pending_orders'] }}</strong>
                                <small>({{ $paymentStats['pending_percentage'] }}%)</small>
                            </div>
                        </div>
                        <div class="payment-stat-item">
                            <div class="payment-stat-label">
                                <span class="payment-stat-color partial"></span>
                                <span>Partial</span>
                            </div>
                            <div class="payment-stat-value">
                                <strong>{{ $paymentStats['partial_orders'] }}</strong>
                                <small>({{ $paymentStats['partial_percentage'] }}%)</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="col-lg-8 mb-4">
            <div class="dashboard-card">
                <div class="card-header">
                    <h5 class="card-title">Recent Orders</h5>
                    <a href="{{ route('backend.orders.index') }}" class="btn btn-sm btn-primary">
                        View All <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="card-body">
                    @if ($recentOrders->count() > 0)
                        <div class="recent-orders">
                            @foreach ($recentOrders as $order)
                                <div class="recent-order-item">
                                    <div class="order-info">
                                        <div class="order-tracking">{{ $order->tracking_number }}</div>
                                        <div class="order-customer">{{ $order->user->name ?? 'Guest' }}</div>
                                        <div class="order-date">{{ $order->created_at->format('M d, Y') }}</div>
                                    </div>
                                    <div class="order-status">
                                        <span class="status-badge status-{{ $order->status }}">
                                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                        </span>
                                    </div>
                                    <div class="order-amount">
                                        @if ($order->total_amount)
                                            ৳{{ number_format($order->total_amount, 2) }}
                                        @else
                                            <span class="text-muted">TBD</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                            <p>No orders found</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
    <script>
        let trendsChart;
        let statusChart;
        let chartType = 'line'; // 'line' or 'bar'

        // Chart data from Laravel
        const trendsData = @json($monthlyTrends);
        const statusData = @json($orderStatusData);

        $(document).ready(function() {
            initializeCharts();
        });

        function initializeCharts() {
            // Trends Chart
            const trendsCtx = document.getElementById('trendsChart').getContext('2d');
            trendsChart = new Chart(trendsCtx, {
                type: chartType,
                data: {
                    labels: trendsData.months,
                    datasets: [{
                        label: 'Orders',
                        data: trendsData.orders,
                        borderColor: '#ec1d25',
                        backgroundColor: 'rgba(236, 29, 37, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#ec1d25',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8
                    }, {
                        label: 'Revenue (৳)',
                        data: trendsData.revenue,
                        borderColor: '#088134',
                        backgroundColor: 'rgba(8, 129, 52, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#088134',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        yAxisID: 'y1'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    scales: {
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            },
                            ticks: {
                                color: '#666666'
                            }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            beginAtZero: true,
                            grid: {
                                drawOnChartArea: false,
                            },
                            ticks: {
                                color: '#666666',
                                callback: function(value) {
                                    return '৳' + value.toLocaleString();
                                }
                            }
                        },
                        x: {
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            },
                            ticks: {
                                color: '#666666'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                padding: 20,
                                color: '#1A1A1A'
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(255, 255, 255, 0.95)',
                            titleColor: '#1A1A1A',
                            bodyColor: '#666666',
                            borderColor: '#ec1d25',
                            borderWidth: 1,
                            cornerRadius: 12,
                            displayColors: true,
                            callbacks: {
                                label: function(context) {
                                    if (context.datasetIndex === 1) {
                                        return 'Revenue: ৳' + context.parsed.y.toLocaleString();
                                    }
                                    return 'Orders: ' + context.parsed.y;
                                }
                            }
                        }
                    }
                }
            });

            // Status Chart (Doughnut)
            const statusCtx = document.getElementById('statusChart').getContext('2d');
            const statusColors = [
                '#ec1d25', '#f0bb1b', '#088134', '#EF4444',
                '#8b5cf6', '#06b6d4', '#f97316'
            ];

            statusChart = new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: statusData.map(item => item.label),
                    datasets: [{
                        data: statusData.map(item => item.value),
                        backgroundColor: statusColors,
                        borderColor: '#ffffff',
                        borderWidth: 3,
                        hoverBorderWidth: 4,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '60%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 15,
                                color: '#1A1A1A',
                                font: {
                                    size: 12
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(255, 255, 255, 0.95)',
                            titleColor: '#1A1A1A',
                            bodyColor: '#666666',
                            borderColor: '#ec1d25',
                            borderWidth: 1,
                            cornerRadius: 12,
                            callbacks: {
                                label: function(context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = ((context.parsed / total) * 100).toFixed(1);
                                    return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                                }
                            }
                        }
                    }
                }
            });
        }

        function toggleChartType() {
            chartType = chartType === 'line' ? 'bar' : 'line';
            trendsChart.destroy();
            initializeCharts();
        }
    </script>
@endpush
