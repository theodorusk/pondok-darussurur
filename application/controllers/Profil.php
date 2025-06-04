<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profil extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->load->model(['M_pengguna', 'M_santri']);
        $this->load->helper(['form', 'url', 'security']);
        $this->load->library(['form_validation']);
    }

    // Halaman profil pengguna
    public function index()
    {
        $id_user = $this->session->userdata('id_user');
        $user = $this->M_pengguna->get_by_id($id_user);

        if (!$user) {
            show_404();
        }

        $data = [
            'title' => 'Profil Saya',
            'pengguna' => $user,
            'santri' => ($user->id_role == 2) ? $this->M_santri->get_by_user($id_user) : null
        ];

        template('profil/index', $data);
    }

    // Update profil pengguna
    public function update()
    {
        $id_user = $this->session->userdata('id_user');
        $user = $this->M_pengguna->get_by_id($id_user);

        if (!$user) {
            show_404();
        }

        $this->_validate();

        // Cek apakah email diubah dan sudah ada di database
        if ($this->input->post('email') != $user->email && $this->M_pengguna->email_exists($this->input->post('email'))) {
            $this->session->set_flashdata('error', 'Email sudah digunakan oleh pengguna lain.');
            redirect('profil');
        }

        $userData = $this->_prepare_user_data();
        $this->M_pengguna->update($id_user, $userData);

        // Update session data
        $session_data = [
            'nama_user' => $userData['nama_user'],
            'email' => $userData['email']
        ];

        if (isset($userData['foto_user'])) {
            $session_data['foto'] = $userData['foto_user'];
        }

        $this->session->set_userdata($session_data);

        // Jika santri, update data santri
        if ($user->id_role == 2) {
            $this->_update_santri_data($id_user);
        }

        $this->session->set_flashdata('success', 'Profil berhasil diperbarui.');
        redirect('profil');
    }

    // Halaman ubah password
    public function password()
    {
        $data = [
            'title' => 'Ubah Password'
        ];

        template('profil/password', $data);
    }

    // Proses ubah password
    public function update_password()
    {
        $id_user = $this->session->userdata('id_user');
        $user = $this->M_pengguna->get_detail($id_user); // Get user with password

        if (!$user) {
            show_404();
        }

        $this->form_validation->set_rules('current_password', 'Password Saat Ini', 'required');
        $this->form_validation->set_rules('new_password', 'Password Baru', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required|matches[new_password]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('profil/password');
        }

        // Verifikasi password lama
        $current_password = $this->input->post('current_password');
        if (!password_verify($current_password, $user['password'])) {
            $this->session->set_flashdata('error', 'Password saat ini salah.');
            redirect('profil/password');
        }

        // Update password baru
        $new_password = $this->input->post('new_password');
        $this->M_pengguna->update($id_user, [
            'password' => password_hash($new_password, PASSWORD_DEFAULT)
        ]);

        $this->session->set_flashdata('success', 'Password berhasil diubah.');
        redirect('profil');
    }

    // PRIVATE METHODS
    
    private function _validate()
    {
        $this->form_validation->set_rules('nama_user', 'Nama', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required|trim|in_list[L,P]');
        
        // Validasi khusus santri
        if ($this->session->userdata('id_role') == 2) {
            $this->form_validation->set_rules('no_wa', 'No. WhatsApp', 'required|trim|numeric');
            $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
            $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required|trim');
        }

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('profil');
        }
    }

    private function _prepare_user_data()
    {
        $data = [
            'nama_user' => strip_tags($this->input->post('nama_user', true)),
            'email' => strip_tags($this->input->post('email', true)),
            'jenis_kelamin' => $this->input->post('jenis_kelamin', true)
        ];

        // Handle upload foto profil
        if (!empty($_FILES['foto_user']['name'])) {
            $id_user = $this->session->userdata('id_user');
            $old_photo = $this->M_pengguna->get_foto_by_id($id_user);
            $upload = $this->_upload_file('foto_user', 'uploads/profil', $old_photo);

            if ($upload['status']) {
                $data['foto_user'] = $upload['file'];
            } else {
                $this->session->set_flashdata('error', $upload['error']);
                redirect('profil');
            }
        } elseif ($this->input->post('remove_foto')) {
            // Handle hapus foto
            $id_user = $this->session->userdata('id_user');
            $old_photo = $this->M_pengguna->get_foto_by_id($id_user);
            if ($old_photo && file_exists('./uploads/profil/' . $old_photo)) {
                unlink('./uploads/profil/' . $old_photo);
            }
            $data['foto_user'] = null;
        }

        return $data;
    }

    private function _update_santri_data($userId)
    {
        $santriData = [
            'alamat' => strip_tags($this->input->post('alamat', true)),
            'no_wa' => strip_tags($this->input->post('no_wa', true)),
            'tanggal_lahir' => strip_tags($this->input->post('tanggal_lahir', true))
        ];

        $this->M_santri->update_by_user($userId, $santriData);
    }

    private function _upload_file($fieldName, $path, $oldFile = null)
    {
        $config = [
            'upload_path' => './' . $path,
            'allowed_types' => 'jpg|jpeg|png',
            'max_size' => 2048, // 2MB
            'encrypt_name' => true
        ];

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($fieldName)) {
            return ['status' => false, 'error' => $this->upload->display_errors()];
        }

        // Hapus file lama jika ada
        if ($oldFile && file_exists("./{$path}/{$oldFile}")) {
            unlink("./{$path}/{$oldFile}");
        }

        return ['status' => true, 'file' => $this->upload->data('file_name')];
    }
}