<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Seeder extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function index()
    {
        // Cek dan insert role admin
        if (!$this->db->get_where('role', ['nama_role' => 'admin'])->row()) {
            $this->db->insert('role', ['nama_role' => 'admin']);
        }

        // Cek dan insert role santri
        if (!$this->db->get_where('role', ['nama_role' => 'santri'])->row()) {
            $this->db->insert('role', ['nama_role' => 'santri']);
        }

        // Ambil id_role admin
        $role_admin = $this->db->get_where('role', ['nama_role' => 'admin'])->row();

        // Cek user admin
        if (!$this->db->get_where('user', ['email' => 'admin@pondok.com'])->row()) {
            $admin_data = [
                'nama_user'     => 'Theo Keraf',
                'email'         => 'theokeraf@gmail.com',
                'password'      => password_hash('123456', PASSWORD_DEFAULT),
                'id_role'       => $role_admin->id_role,
                'nik'           => '1234567890123456',
                'jenis_kelamin' => 'L',
                'foto_user'     => null
            ];
            $this->db->insert('user', $admin_data);
        }

        echo "Seeder selesai dijalankan. <br>Email login: <b>admin@pondok.com</b> | Password: <b>admin123</b>";
    }
}
