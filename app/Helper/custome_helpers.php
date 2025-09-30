<?php

use App\Models\OrderRequest;
use App\Models\OrderRequestProduct;
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

//isStudent
function isStudent() {
    return isRole('student');
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
function convertAudToBdt($amount) {
    $req_url = "https://v6.exchangerate-api.com/v6/" . env('EXCHANGERATE_API') . "/latest/AUD";
    $response_json = file_get_contents($req_url);

    if (false !== $response_json) {
        try {
            $response = json_decode($response_json);

            if ('success' === $response->result) {
                $base_price = $amount;
                $bdt_price = round(($base_price * $response->conversion_rates->BDT), 2);
                return $bdt_price;
            }
        } catch (Exception $e) {
            Log::error($e);
        }
    }
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
