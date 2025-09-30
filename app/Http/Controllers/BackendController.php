<?php

namespace App\Http\Controllers;

use App\Mail\OrderReceivedAdminNotificationMail;
use App\Mail\OrderReceivedThankyouMail;
use App\Models\OrderRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class BackendController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard() {
        $breadcrumb = [
            ['title' => 'Dashboard', 'url' => route('backend.dashboard')]
        ];

        // Get dashboard statistics
        $stats = $this->getDashboardStats();

        // Get recent orders
        $recentOrders = OrderRequest::with(['user', 'products'])
            ->latest()
            ->limit(5)
            ->get();

        // Get order status distribution
        $orderStatusData = $this->getOrderStatusData();

        // Get monthly order trends (last 6 months)
        $monthlyTrends = $this->getMonthlyTrends();

        // Get payment statistics
        $paymentStats = $this->getPaymentStats();

        return view('backend.dashboard', compact(
            'breadcrumb',
            'stats',
            'recentOrders',
            'orderStatusData',
            'monthlyTrends',
            'paymentStats'
        ));
    }

    /**
     * Get dashboard statistics
     */
    private function getDashboardStats() {
        $totalOrders = OrderRequest::count();
        $totalUsers = User::count();
        $totalRevenue = OrderRequest::where('payment_status', 'paid')->sum('total_amount') ?? 0;
        $pendingOrders = OrderRequest::whereIn('status', ['order_received', 'order_confirmed', 'order_processed'])->count();

        // Calculate growth percentages (comparing with previous month)
        $currentMonth = now()->startOfMonth();
        $lastMonth = now()->subMonth()->startOfMonth();
        $currentMonthEnd = now()->endOfMonth();
        $lastMonthEnd = now()->subMonth()->endOfMonth();

        $currentMonthOrders = OrderRequest::whereBetween('created_at', [$currentMonth, $currentMonthEnd])->count();
        $lastMonthOrders = OrderRequest::whereBetween('created_at', [$lastMonth, $lastMonthEnd])->count();
        $orderGrowth = $lastMonthOrders > 0 ? (($currentMonthOrders - $lastMonthOrders) / $lastMonthOrders) * 100 : 0;

        $currentMonthRevenue = OrderRequest::where('payment_status', 'paid')
            ->whereBetween('created_at', [$currentMonth, $currentMonthEnd])
            ->sum('total_amount') ?? 0;
        $lastMonthRevenue = OrderRequest::where('payment_status', 'paid')
            ->whereBetween('created_at', [$lastMonth, $lastMonthEnd])
            ->sum('total_amount') ?? 0;
        $revenueGrowth = $lastMonthRevenue > 0 ? (($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100 : 0;

        return [
            'total_orders' => $totalOrders,
            'total_users' => $totalUsers,
            'total_revenue' => $totalRevenue,
            'pending_orders' => $pendingOrders,
            'order_growth' => round($orderGrowth, 1),
            'revenue_growth' => round($revenueGrowth, 1),
            'current_month_orders' => $currentMonthOrders,
            'current_month_revenue' => $currentMonthRevenue,
        ];
    }

    /**
     * Get order status distribution
     */
    private function getOrderStatusData() {
        $statuses = [
            'order_received' => 'Received',
            'order_confirmed' => 'Confirmed',
            'order_processed' => 'Processed',
            'order_shipped' => 'Shipped',
            'order_delivered' => 'Delivered',
            'order_returned' => 'Returned',
            'order_cancelled' => 'Cancelled'
        ];

        $data = [];
        foreach ($statuses as $status => $label) {
            $count = OrderRequest::where('status', $status)->count();
            $data[] = [
                'label' => $label,
                'value' => $count,
                'status' => $status
            ];
        }

        return $data;
    }

    /**
     * Get monthly trends for the last 6 months
     */
    private function getMonthlyTrends() {
        $months = [];
        $orderCounts = [];
        $revenueData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $startOfMonth = $date->copy()->startOfMonth();
            $endOfMonth = $date->copy()->endOfMonth();

            $months[] = $date->format('M Y');

            $orderCount = OrderRequest::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
            $orderCounts[] = $orderCount;

            $revenue = OrderRequest::where('payment_status', 'paid')
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->sum('total_amount') ?? 0;
            $revenueData[] = $revenue;
        }

        return [
            'months' => $months,
            'orders' => $orderCounts,
            'revenue' => $revenueData
        ];
    }

    /**
     * Get payment statistics
     */
    private function getPaymentStats() {
        $totalOrders = OrderRequest::count();
        $paidOrders = OrderRequest::where('payment_status', 'paid')->count();
        $pendingOrders = OrderRequest::where('payment_status', 'pending')->count();
        $partialOrders = OrderRequest::where('payment_status', 'partially')->count();

        return [
            'total_orders' => $totalOrders,
            'paid_orders' => $paidOrders,
            'pending_orders' => $pendingOrders,
            'partial_orders' => $partialOrders,
            'paid_percentage' => $totalOrders > 0 ? round(($paidOrders / $totalOrders) * 100, 1) : 0,
            'pending_percentage' => $totalOrders > 0 ? round(($pendingOrders / $totalOrders) * 100, 1) : 0,
            'partial_percentage' => $totalOrders > 0 ? round(($partialOrders / $totalOrders) * 100, 1) : 0,
        ];
    }

    /**
     * Show the settings page.
     *
     * @return \Illuminate\View\View
     */
    public function settings() {
        return view('backend.settings.index');
    }

    public function debug() {
    }
}
