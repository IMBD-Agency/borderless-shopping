<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\District;
use App\Models\OrderRequest as ModelsOrderRequest;
use App\Models\OrderRequestProduct;
use App\Models\SubCity;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderReceivedThankyouMail;
use App\Mail\OrderReceivedAdminNotificationMail;
use App\Models\Contact;
use App\Models\Review;
use App\Models\SocialMedia;
use Illuminate\Support\Facades\Log;

class FrontendController extends Controller {

    public function __construct() {
        $this->socialMedia = SocialMedia::all();
    }

    public function index() {
        $this->contact_details = Contact::first();
        $this->districts = District::orderBy('name', 'asc')->get();
        $this->reviews = Review::inRandomOrder()->take(3)->get();
        return view('frontend.index', $this->data);
    }

    public function orderRequest(OrderRequest $request) {
        $user = null;
        if ($request->is_logged_in == 'true') {
            $user = auth()->user();
        } else {
            if ($request->action == 'login') {
                $user = User::where('email', $request->email)->first();
                if (!$user) {
                    return response()->json(['error' => 'Invalid email address'], 401);
                }

                if (!Hash::check($request->password, $user->password)) {
                    return response()->json(['error' => 'Invalid email or password'], 401);
                }
                Auth::login($user);
            } else if ($request->action == 'register') {
                $existingUser = User::where('email', $request->email)->first();
                if ($existingUser) {
                    return response()->json(['error' => 'Email address already exists. Please login to continue.'], 422);
                } else {
                    $user = User::create([
                        'name' => $request->name,
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                    ]);

                    Auth::login($user);
                }
            }
        }

        $orderRequest = DB::transaction(function () use ($request, $user) {

            $tracking_number = generateUnique8DigitId();
            $district = District::find($request->district)->name;
            $area = SubCity::find($request->area)->name;
            if (!$district || !$area) {
                return response()->json(['error' => 'Invalid district or area'], 400);
            }
            $address = $request->recipient_address .  ', ' . $area . ', ' . $district . ', Bangladesh';

            $orderRequest = ModelsOrderRequest::create([
                'user_id' => $user?->id ?? null,
                'recipient_name' => $request->recipient_name,
                'recipient_mobile' => $request->recipient_mobile,
                'recipient_address' => $address,
                'notes' => $request->notes,
                'slug' => md5($tracking_number),
                'tracking_number' => $tracking_number,
            ]);

            // Handle single product fields or arrays
            $productUrls = $request->input('product_urls');
            $productQuantities = $request->input('product_quantities');

            foreach ($productUrls as $index => $url) {
                $quantity = (int)($productQuantities[$index] ?? 1);
                $created = OrderRequestProduct::create([
                    'order_request_id' => $orderRequest->id,
                    'product_url' => $url,
                    'product_quantity' => $quantity,
                ]);

                if ($index === 0) {
                    $orderRequest->setAttribute('product_url', $created->product_url);
                    $orderRequest->setAttribute('product_quantity', $created->product_quantity);
                }
            }

            // Add initial timeline entry
            $orderRequest->addTimelineEntry(
                'order_received',
                'Your order has been received and is being processed.',
                'system',
                $user?->id
            );

            return $orderRequest->load('products');
        });

        // Send emails (user and admin)
        try {
            $recipientEmail = $user?->email ?? null;
            if ($recipientEmail) {
                Mail::to($recipientEmail)->send(new OrderReceivedThankyouMail($orderRequest));
            }
            // Admin notification
            $adminEmail = env('ADMIN_EMAIL');
            if ($adminEmail) {
                Mail::to($adminEmail)->send(new OrderReceivedAdminNotificationMail($orderRequest));
            }
        } catch (\Throwable $e) {
            Log::error($e);
        }

        return response()->json([
            'message' => 'Order request received successfully',
            'order_request' => $orderRequest,
        ]);
    }

    public function getSubCities(Request $request) {
        $subCities = SubCity::where('district_id', $request->district_id)->orderBy('name', 'asc')->get();
        $html = '<option value="">Select Sub City</option>';
        foreach ($subCities as $subCity) {
            $html .= '<option value="' . $subCity->id . '">' . $subCity->name . '</option>';
        }
        return response()->json(['html' => $html]);
    }

    public function orderRequestInvoice($slug) {
        $this->order = ModelsOrderRequest::with(['user', 'products'])->where('slug', $slug)->firstOrFail();
        return view('frontend.order-invoice', $this->data);
    }

    public function orderRequestInvoiceDownload($slug) {
        $order = ModelsOrderRequest::with(['user', 'products'])->where('slug', $slug)->firstOrFail();
        $pdf = Pdf::loadView('frontend.order-invoice-download', compact('order'));
        $pdf->setPaper('A4', 'portrait');
        $pdf_name = 'invoice-' . strtolower($order->tracking_number) . '-' . now()->timestamp . '.pdf';
        return $pdf->stream($pdf_name);
    }

    public function thankYou($tracking_number) {
        $this->order = ModelsOrderRequest::with(['user', 'products'])->where('tracking_number', $tracking_number)->firstOrFail();
        return view('frontend.thank-you', $this->data);
    }

    // User Dashboard Methods
    public function userDashboard() {
        $this->user = auth()->user();
        $this->totalOrders = ModelsOrderRequest::where('user_id', $this->user->id)->count();
        $this->pendingOrders = ModelsOrderRequest::where('user_id', $this->user->id)
            ->whereIn('status', ['order_received', 'order_confirmed', 'order_processed'])
            ->count();
        $this->deliveredOrders = ModelsOrderRequest::where('user_id', $this->user->id)
            ->where('status', 'order_delivered')
            ->count();

        $this->recentOrders = ModelsOrderRequest::where('user_id', $this->user->id)
            ->with('products')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('frontend.user.dashboard', $this->data);
    }

    public function userProfile() {
        $this->user = auth()->user();
        return view('frontend.user.profile', $this->data);
    }

    public function updateUserProfile(Request $request) {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('user.profile')->with('success', 'Profile updated successfully!');
    }

    public function changeUserPassword(Request $request) {
        $user = auth()->user();

        $request->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('user.profile')->with('success', 'Password changed successfully!');
    }

    public function updateUserProfilePicture(Request $request) {
        $user = auth()->user();

        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');

            // Generate unique filename
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // Move file to public directory
            $file->move(public_path('assets/images/users/'), $filename);

            // Delete old image if exists
            if ($user->image && file_exists(public_path('assets/images/users/' . $user->image))) {
                unlink(public_path('assets/images/users/' . $user->image));
            }

            $user->update(['image' => $filename]);
        }

        return redirect()->route('user.profile')->with('success', 'Profile picture updated successfully!');
    }

    public function userOrders() {
        $this->user = auth()->user();
        $this->orders = ModelsOrderRequest::where('user_id', $this->user->id)
            ->with('products')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('frontend.user.orders', $this->data);
    }

    public function userOrderDetails($slug) {
        $this->user = auth()->user();
        $this->order = ModelsOrderRequest::where('user_id', $this->user->id)
            ->where('slug', $slug)
            ->with(['user', 'products', 'timelines.user'])
            ->firstOrFail();

        return view('frontend.user.order-details', $this->data);
    }

    public function trackOrder() {
        return view('frontend.track-order', $this->data);
    }

    public function trackOrderSubmit(Request $request) {
        $request->validate([
            'tracking_number' => 'required|string'
        ]);

        $order = ModelsOrderRequest::where('tracking_number', $request->tracking_number)
            ->with(['user', 'products', 'timelines.user'])
            ->first();

        if (!$order) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No order found with this tracking number. Please check and try again.'
                ], 404);
            }
            return redirect()->route('frontend.track-order')
                ->with('error', 'No order found with this tracking number. Please check and try again.');
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'order' => $order,
                'timeline' => $order->timelines,
                'products' => $order->products
            ]);
        }

        return view('frontend.track-order', compact('order'));
    }

    public function getCsrfToken() {
        return response()->json(['csrf_token' => csrf_token()]);
    }
}
