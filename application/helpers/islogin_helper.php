<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Fungsi untuk cek login
function is_logged_in() {
    $CI =& get_instance();
    if (!$CI->session->userdata('logged_in')) {
        redirect('auth/login');
    }
}
