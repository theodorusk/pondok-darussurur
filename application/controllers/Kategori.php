<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategori extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Cek apakah user sudah login
        $this->load->helper('islogin_helper');
        is_logged_in();

        // Hanya admin yang boleh mengakses controller ini
        if ($this->session->userdata('id_role') != 1) {
            redirect('auth/forbidden');
        }

        $this->load->model('M_kategori');
        $this->load->helper(['form', 'url', 'security']);
        $this->load->library(['form_validation']);
    }

    // Menampilkan daftar kategori pembayaran
    public function index()
    {
        $data = [
            'title' => 'Kategori Pembayaran',
            'kategori' => $this->M_kategori->get_all()
        ];

        template('kategori/read', $data);
    }

    // Form tambah kategori
    public function create()
    {
        $data = [
            'title' => 'Tambah Kategori Pembayaran'
        ];

        template('kategori/create', $data);
    }

    // Proses simpan kategori baru
    public function store()
    {
        // Validasi input
        $this->_validate();

        $kategoriData = [
            'nama_kategori' => strip_tags($this->input->post('nama_kategori', true)),
            'deskripsi' => strip_tags($this->input->post('deskripsi', true))
        ];

        $this->M_kategori->insert($kategoriData);
        $this->session->set_flashdata('success', 'Kategori pembayaran berhasil ditambahkan');
        redirect('kategori');
    }

    // Form edit kategori
    public function edit($id)
    {
        $id = xss_clean($id);
        $kategori = $this->M_kategori->get_by_id($id);

        if (!$kategori) {
            show_404();
        }

        $data = [
            'title' => 'Edit Kategori Pembayaran',
            'kategori' => $kategori
        ];

        template('kategori/edit', $data);
    }

    // Proses update kategori
    public function update($id)
    {
        $id = xss_clean($id);
        $kategori = $this->M_kategori->get_by_id($id);

        if (!$kategori) {
            show_404();
        }

        // Validasi input
        $this->_validate();

        $kategoriData = [
            'nama_kategori' => strip_tags($this->input->post('nama_kategori', true)),
            'deskripsi' => strip_tags($this->input->post('deskripsi', true))
        ];

        $this->M_kategori->update($id, $kategoriData);
        $this->session->set_flashdata('success', 'Kategori pembayaran berhasil diperbarui');
        redirect('kategori');
    }

    // Hapus kategori
    public function delete($id)
    {
        // Hanya terima request AJAX
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $id = xss_clean($id);
        $response = ['status' => false, 'message' => ''];

        // Cek apakah kategori digunakan di tagihan
        $used = $this->M_kategori->is_used($id);

        if ($used) {
            $response = [
                'status' => false,
                'message' => 'Kategori tidak dapat dihapus karena sedang digunakan pada tagihan'
            ];
        } else {
            if ($this->M_kategori->delete($id)) {
                $response = [
                    'status' => true,
                    'message' => 'Kategori berhasil dihapus'
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => 'Gagal menghapus kategori'
                ];
            }
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    // PRIVATE METHODS

    // Validasi input kategori
    private function _validate()
    {
        $this->form_validation->set_rules('nama_kategori', 'Nama Kategori', 'required|trim|max_length[100]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($this->input->post('id_kategori') ? 'kategori/edit/' . $this->input->post('id_kategori') : 'kategori/create');
        }
    }
}
