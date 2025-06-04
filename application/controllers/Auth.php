<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_auth');
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'form']);
    }

    public function index()
    {
        redirect('auth/login');
    }

    public function login()
    {
        // Jika sudah login, redirect ke dashboard
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        // Validasi form
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == TRUE) {
            $email = $this->input->post('email', true);
            $password = $this->input->post('password', true);

            $user = $this->M_auth->get_user_by_email($email);

            if ($user) {
                if (password_verify($password, $user['password'])) {
                    // Simpan ke session
                    $session_data = [
                        'id_user'   => $user['id_user'],
                        'nama_user' => $user['nama_user'],
                        'email'     => $user['email'],
                        'id_role'   => $user['id_role'],
                        'logged_in' => true
                    ];

                    // Tambahkan foto jika ada
                    if (!empty($user['foto_user'])) {
                        $session_data['foto'] = $user['foto_user'];
                    }

                    $this->session->set_userdata($session_data);

                    // Redirect sesuai role
                    switch ($user['id_role']) {
                        case 1: // Admin
                            redirect('dashboard/admin');
                            break;
                        case 2: // Santri
                            redirect('dashboard/santri');
                            break;
                        default:
                            $this->session->set_flashdata('error', 'Role tidak dikenali.');
                            redirect('auth/login');
                    }
                } else {
                    $this->session->set_flashdata('error', 'Password salah.');
                    redirect('auth/login');
                }
            } else {
                $this->session->set_flashdata('error', 'Email tidak terdaftar.');
                redirect('auth/login');
            }
        }

        $this->load->view('auth/login');
    }

    public function logout()
    {
        // Hapus semua data session
        $this->session->unset_userdata([
            'id_user',
            'nama_user',
            'email',
            'id_role',
            'foto',
            'logged_in'
        ]);
        $this->session->sess_destroy();
        redirect('auth/login');
    }

    public function forbidden()
    {
        $this->load->view('auth/forbidden');
    }
}
