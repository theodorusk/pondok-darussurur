<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        // Cek apakah sudah login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function index()
    {
        // Redirect sesuai role
        $role = $this->session->userdata('id_role');

        if ($role == 1) {
            redirect('dashboard/admin');
        } elseif ($role == 2) {
            redirect('dashboard/santri');
        } else {
            redirect('auth/forbidden');
        }
    }

    public function admin()
    {
        if ($this->session->userdata('id_role') != 1) {
            redirect('auth/forbidden');
        }

        $data['title'] = 'Dashboard Admin';
        $data['nama_user'] = $this->session->userdata('nama_user');

        template('dashboard/admin', $data);
    }

    public function santri()
    {
        if ($this->session->userdata('id_role') != 2) {
            redirect('auth/forbidden');
        }

        $data['title'] = 'Dashboard Santri';
        $data['nama_user'] = $this->session->userdata('nama_user');

        template('dashboard/santri', $data);
    }
}
