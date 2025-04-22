<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;

if (!function_exists('is_active_route')) {
    function is_active_route($routeName, $output = 'active')
    {
        if (is_array($routeName)) {
            foreach ($routeName as $name) {
                if (Route::currentRouteName() == $name) {
                    return $output;
                }
            }
        } else {
            if (Route::currentRouteName() == $routeName) {
                return $output;
            }
        }

        return '';
    }
}

if (!function_exists('is_active_url')) {
    function is_active_url($url, $output = 'active')
    {
        if (is_array($url)) {
            foreach ($url as $u) {
                if (Request::is($u)) {
                    return $output;
                }
            }
        } else {
            if (Request::is($url)) {
                return $output;
            }
        }

        return '';
    }
}

if (!function_exists('get_route_title')) {
    function get_route_title($routeName = null)
    {
        // Jika tidak ada parameter, ambil current route
        $routeName = $routeName ?? Route::currentRouteName();

        // Pastikan $routeName tidak null
        if (empty($routeName)) {
            return 'Default Title';
        }

        // Custom mapping untuk nama route yang lebih user-friendly
        $titles = [
            'dashboard' => 'Beranda',
            'surat-masuk.index' => 'Daftar Surat Masuk',
            'surat-masuk.create' => 'Buat Surat Masuk Baru',
            'surat-masuk.edit' => 'Edit Surat Masuk',
            'surat-masuk.show' => 'Detail Surat Masuk',
            // Tambahkan mapping lainnya sesuai kebutuhan
        ];

        return $titles[$routeName] ?? ucwords(str_replace(['-', '.'], ' ', $routeName));
    }
}
