<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function is_logged_in()
{
    $CI = get_instance();
    if (!$CI->session->userdata('logged_in')) {
        redirect('auth/login');
    }
}
