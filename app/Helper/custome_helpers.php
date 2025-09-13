<?php

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

//isClient
function isClient() {
    return isRole('client');
}
