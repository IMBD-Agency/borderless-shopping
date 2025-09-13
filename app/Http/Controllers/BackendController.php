<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        return view('backend.dashboard', compact('breadcrumb'));
    }

    /**
     * Show the settings page.
     *
     * @return \Illuminate\View\View
     */
    public function settings() {
        return view('backend.settings.index');
    }
}
