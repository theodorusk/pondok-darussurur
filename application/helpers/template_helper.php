<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('template')) {
    function template($view, $data = [])
    {
        $CI = &get_instance();

        // Set default title jika belum di-set di controller
        if (!isset($data['title'])) {
            $data['title'] = 'Pencatatan Keuangan Pondok Pesantren  Darussurur';
        }

        // Load urutan layout Kai Admin
        $CI->load->view('template/header', $data);   // Head, CSS, mulai body
        $CI->load->view('template/sidebar', $data);  // Sidebar
        $CI->load->view('template/topbar', $data);   // Navbar atau topbar
        $CI->load->view($view, $data);               // View utama
        $CI->load->view('template/footer', $data);   // Footer, JS
    }
}
