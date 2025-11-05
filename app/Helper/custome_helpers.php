<?php

use App\Models\OrderRequest;
use App\Models\OrderRequestProduct;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

function get_user_image($image) {
    return asset('assets/images/users/' . $image);
}

function get_user_role($role) {
    return ucwords(str_replace('_', ' ', $role));
}

//user role check
function isRole($role) {
    $userRole = auth()->user()->role ?? null;
    if (is_array($role)) {
        return in_array($userRole, $role);
    } else {
        return $userRole == $role;
    }
}

//isSuperAdmin
function isSuperAdmin() {
    return isRole('super_admin');
}

//isAdmin
function isAdmin() {
    return isRole('admin');
}

//isCustomer
function isCustomer() {
    return isRole('customer');
}

//generate unique 8 digit id
function generateUnique8DigitId($prefix = 'AU-', $suffix = '', int $maxAttempts = 10): string {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $length = 8;
    $tries = 0;

    do {
        $id = '';
        for ($i = 0; $i < $length; $i++) {
            $id .= $characters[random_int(0, strlen($characters) - 1)];
        }

        $exists = DB::table('order_requests')
            ->where('tracking_number', $prefix . $id . $suffix)
            ->exists();

        $tries++;

        if ($tries >= $maxAttempts) {
            throw new RuntimeException("Could not generate a unique alphanumeric ID after {$maxAttempts} attempts.");
        }
    } while ($exists);

    return $prefix . $id . $suffix;
}

//convert aud to bdt
function convertAudToBdt($amount = 1) {
    $req_url = "https://v6.exchangerate-api.com/v6/" . env('EXCHANGERATE_API') . "/pair/AUD/BDT";
    $response_json = file_get_contents($req_url);

    if (false !== $response_json) {
        try {
            $response = json_decode($response_json);
            if ('success' === $response->result) {
                $base_price = $amount;
                $bdt_price = round(($base_price * $response->conversion_rate), 2);
                return $bdt_price;
            }
        } catch (Exception $e) {
            Log::error($e);
        }
    }
}

//extract youtube id from url
function extractYouTubeId(string $input) {
    // Trim whitespace
    $input = trim($input);

    // If input already looks like a plain 11-character ID, return it
    if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $input)) {
        return $input;
    }

    // Try parsing as a URL first
    if (filter_var($input, FILTER_VALIDATE_URL)) {
        $parts = parse_url($input);

        // 1) Query param v= (standard watch URL)
        if (!empty($parts['query'])) {
            parse_str($parts['query'], $query);
            if (!empty($query['v']) && preg_match('/^[a-zA-Z0-9_-]{11}$/', $query['v'])) {
                return $query['v'];
            }
        }

        // 2) Path-based formats: /embed/ID, /v/ID, /shorts/ID, or youtu.be/ID
        if (!empty($parts['path'])) {
            // Remove leading/trailing slashes
            $path = trim($parts['path'], '/');
            $segments = explode('/', $path);

            // Common patterns: embed/ID, v/ID, shorts/ID, or just ID for youtu.be
            $possible = end($segments);
            if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $possible)) {
                return $possible;
            }

            // For youtu.be the ID may be the first segment
            $host = $parts['host'] ?? '';
            if (strpos($host, 'youtu.be') !== false) {
                $first = $segments[0] ?? '';
                if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $first)) {
                    return $first;
                }
            }
        }
    }

    // 3) As a last resort, try a wide regex that looks for the 11-char ID in common URL patterns or plain text
    if (preg_match('/(?:youtube(?:-nocookie)?\.com\/(?:watch\?.*v=|embed\/|v\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/i', $input, $m)) {
        return $m[1];
    }

    // 4) Final fallback: any standalone 11-char token found in the string
    if (preg_match('/\b([a-zA-Z0-9_-]{11})\b/', $input, $m)) {
        return $m[1];
    }

    return false;
}

//scrapingbee api
function scrapingbeeApi($order) {
    $api_key = env('SCRAPINGBEE_API');
    $products = $order->products;

    foreach ($products as $product) {
        $url = urlencode($product->product_url);
        // get cURL resource
        $ch = curl_init();

        // set url
        // curl_setopt($ch, CURLOPT_URL, 'https://app.scrapingbee.com/api/v1?api_key=9G5KMPZPGEC9OHA0K7EOPWTKY2O3M106KEHNDJ3YDDG6Q5N8P732C7OM7RUENWP9HIB2EFI8IZAOWM7Z&url=https%3A%2F%2Fwww.amazon.com.au%2FLEGO-Creator-Swing-Promo-6373620%2Fdp%2FB0982DWRSS%3Fpd_rd_w%3DGmLWZ%26content-id%3Damzn1.sym.36bbdb86-b7cf-4ece-b220-7744a3b6a603%26pf_rd_p%3D36bbdb86-b7cf-4ece-b220-7744a3b6a603%26pf_rd_r%3DXW809R4THVZN7SMGBP7K%26pd_rd_wg%3DYDidc%26pd_rd_r%3D42ca1c15-4df8-48bd-9517-a7663764cae4%26pd_rd_i%3DB0982DWRSS&ai_extract_rules=%7B%0A++++%22product_name%22+%3A+%22name+of+the+product%22%2C%0A++++%22product_price%22+%3A+%22price+of+the+product%22%0A%7D');
        curl_setopt($ch, CURLOPT_URL, 'https://app.scrapingbee.com/api/v1?api_key=' . $api_key . '&url=' . $url . '&ai_extract_rules=%7B%0A++++%22product_name%22+%3A+%22name+of+the+product%22%2C%0A++++%22product_price%22+%3A+%22price+of+the+product%22%0A%7D');

        // set method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        // return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // send the request and save response to $response
        $response = curl_exec($ch);

        // stop if fails
        if (!$response) {
            die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
        }

        // $response = json_decode($response, true);

        // echo 'HTTP Status Code: ' . curl_getinfo($ch, CURLINFO_HTTP_CODE) . PHP_EOL;
        // echo 'Response Body: ' . $response . PHP_EOL;
        dd($response);
        // close curl resource to free up system resources
        curl_close($ch);
    }
}

//total customers count
function totalCustomersCount() {
    return User::where('role', 'customer')->count() + 500;
}

//total orders count
function totalOrdersCount() {
    return OrderRequest::count() + 500;
}
