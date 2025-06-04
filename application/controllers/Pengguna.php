<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengguna extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('M_pengguna');
        $this->load->model('M_santri');
        $this->load->helper(['form', 'url', 'security']);
        $this->load->library(['form_validation']);
    }

    public function index()
    {
        $data = [
            'title' => 'Manajemen Pengguna',
            'pengguna' => $this->M_pengguna->get_all_with_role()
        ];
        template('pengguna/read', $data);
    }

    public function detail($id)
    {
        $id = xss_clean($id);
        $pengguna = $this->M_pengguna->get_by_id($id);

        if (!$pengguna) {
            show_404();
        }

        $data = [
            'title' => 'Detail Pengguna',
            'pengguna' => $pengguna,
            'santri' => ($pengguna->id_role == 2) ? $this->M_santri->get_by_user($id) : null
        ];

        template('pengguna/detail', $data);
    }
    public function create()
    {
        $data = [
            'title' => 'Tambah Pengguna',
            'roles' => $this->M_pengguna->get_roles()
        ];
        template('pengguna/create', $data);
    }

    public function store()
    {
        $this->_validate();

        if ($this->M_pengguna->email_exists($this->input->post('email'))) {
            $this->session->set_flashdata('error', 'Email sudah digunakan oleh pengguna lain.');
            redirect('Pengguna/create');
        }

        $userData = $this->_prepare_user_data();
        $userId = $this->M_pengguna->insert($userData);

        if ($userData['id_role'] == 2) { // Jika role adalah santri
            if ($this->M_santri->nis_exists($this->input->post('nis'))) {
                $this->M_pengguna->delete($userId);
                $this->session->set_flashdata('error', 'NIS sudah digunakan oleh santri lain.');
                redirect('Pengguna/create');
            }
            $this->_handle_santri_data($userId, $userData);
        }

        $this->session->set_flashdata('success', 'Berhasil menambahkan pengguna.');
        redirect('Pengguna');
    }

    public function edit($id)
    {
        $id = xss_clean($id);
        $pengguna = $this->M_pengguna->get_by_id($id);

        if (!$pengguna) {
            show_404();
        }

        $data = [
            'title' => 'Edit Pengguna',
            'roles' => $this->M_pengguna->get_roles(),
            'pengguna' => $pengguna,
            'santri' => ($pengguna->id_role == 2) ? $this->M_santri->get_by_user($id) : null
        ];

        template('pengguna/update', $data);
    }

    public function update($id)
    {
        $id = xss_clean($id);
        $this->_validate($id);

        $userData = $this->_prepare_user_data($id);
        $this->M_pengguna->update($id, $userData);

        // Jika mengedit profil sendiri, update session
        if ($id == $this->session->userdata('id_user')) {
            $session_data = [
                'nama_user' => $userData['nama_user'],
                'email' => $userData['email']
            ];

            if (isset($userData['foto_user'])) {
                $session_data['foto'] = $userData['foto_user'];
            }

            $this->session->set_userdata($session_data);
        }

        if ($userData['id_role'] == 2) { // Jika role adalah santri
            $santri = $this->M_santri->get_by_user($id);
            if ($this->input->post('nis') != $santri->nis && $this->M_santri->nis_exists($this->input->post('nis'))) {
                $this->session->set_flashdata('error', 'NIS sudah digunakan oleh santri lain.');
                redirect("Pengguna/edit/{$id}");
            }
            $this->_handle_santri_data($id, $userData, true);
        }

        $this->session->set_flashdata('success', 'Data pengguna berhasil diperbarui.');
        redirect('Pengguna');
    }

    public function delete($id)
    {
        // Hanya terima request AJAX
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
    
        $id = xss_clean($id);
        $response = ['success' => false, 'message' => ''];
    
        try {
            // Mulai transaksi
            $this->db->trans_begin();
    
            // Dapatkan data pengguna
            $user = $this->M_pengguna->get_by_id($id);
            if (!$user) {
                throw new Exception('Data pengguna tidak ditemukan');
            }
    
            // Cegah penghapusan diri sendiri
            if ($id == $this->session->userdata('id_user')) {
                throw new Exception('Anda tidak dapat menghapus akun sendiri');
            }
    
            // Hapus data santri terkait jika role santri
            if ($user->id_role == 2) {
                $santri = $this->M_santri->get_by_user($id);
                if ($santri) {
                    // Hapus foto KTP jika ada
                    if (!empty($santri->foto_ktp)) {
                        $ktp_path = './uploads/ktp/' . $santri->foto_ktp;
                        if (file_exists($ktp_path)) {
                            if (!unlink($ktp_path)) {
                                throw new Exception('Gagal menghapus foto KTP');
                            }
                        }
                    }
                    
                    // Hapus data santri dari database
                    if (!$this->M_santri->delete_by_user($id)) {
                        throw new Exception('Gagal menghapus data santri terkait');
                    }
                }
            }
    
            // Hapus foto profil jika ada
            if (!empty($user->foto_user)) {
                $foto_path = './uploads/profil/' . $user->foto_user;
                if (file_exists($foto_path)) {
                    if (!unlink($foto_path)) {
                        throw new Exception('Gagal menghapus foto profil');
                    }
                }
            }
    
            // Hapus pengguna dari database
            if (!$this->M_pengguna->delete($id)) {
                throw new Exception('Gagal menghapus data pengguna');
            }
    
            // Verifikasi semua operasi berhasil sebelum commit
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Gagal dalam proses transaksi');
            }
    
            // Commit transaksi
            $this->db->trans_commit();
    
            $response = [
                'status' => true,  // Ubah dari 'success' ke 'status' untuk konsistensi
                'message' => 'Data pengguna berhasil dihapus'
            ];
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $response['message'] = $e->getMessage();
            
            // Log error untuk debugging
            log_message('error', 'Gagal menghapus pengguna: ' . $e->getMessage());
        }
    
        // Kirim response JSON
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    // PRIVATE METHODS

    private function _validate($except_id = null)
    {
        $this->form_validation->set_rules('nama_user', 'Nama', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('id_role', 'Role', 'required|integer');

        if (is_null($except_id)) {
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        } else {
            $this->form_validation->set_rules('password', 'Password', 'min_length[6]');
        }

        if ($this->input->post('id_role') == 2) { // Validasi khusus santri
            $this->form_validation->set_rules('nis', 'NIS', 'required|trim|max_length[20]');
            $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
            $this->form_validation->set_rules('no_wa', 'No. WhatsApp', 'required|trim|numeric');
            $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required|trim');
            $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required|trim|in_list[L,P]');
        }

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect(empty($except_id) ? 'Pengguna/create' : "Pengguna/edit/{$except_id}");
        }
    }

    private function _prepare_user_data($id = null)
    {
        $data = [
            'nama_user' => strip_tags($this->input->post('nama_user', true)),
            'email' => strip_tags($this->input->post('email', true)),
            'id_role' => (int)$this->input->post('id_role'),
            'jenis_kelamin' => $this->input->post('jenis_kelamin', true)
        ];

        if (!empty($this->input->post('password'))) {
            $data['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
        }

        // Handle upload foto profil
        if (!empty($_FILES['foto_user']['name'])) {
            $old_photo = $id ? $this->M_pengguna->get_foto_by_id($id) : null;
            $upload = $this->_upload_file('foto_user', 'uploads/profil', $old_photo);

            if ($upload['status']) {
                $data['foto_user'] = $upload['file'];
            } else {
                $this->session->set_flashdata('error', $upload['error']);
                redirect(empty($id) ? 'Pengguna/create' : "Pengguna/edit/{$id}");
            }
        } elseif ($this->input->post('remove_foto')) {
            // Handle hapus foto
            $old_photo = $this->M_pengguna->get_foto_by_id($id);
            if ($old_photo && file_exists('./uploads/profil/' . $old_photo)) {
                unlink('./uploads/profil/' . $old_photo);
            }
            $data['foto_user'] = null;
        }

        return $data;
    }

    private function _handle_santri_data($userId, $userData, $isUpdate = false)
    {
        $santriData = [
            'id_user' => $userId,
            'nis' => strip_tags($this->input->post('nis', true)),
            'alamat' => strip_tags($this->input->post('alamat', true)),
            'no_wa' => strip_tags($this->input->post('no_wa', true)),
            'tanggal_lahir' => strip_tags($this->input->post('tanggal_lahir', true))
        ];

        if ($isUpdate) {
            $this->M_santri->update_by_user($userId, $santriData);
        } else {
            $this->M_santri->insert($santriData);
        }
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
