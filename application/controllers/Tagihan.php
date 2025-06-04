<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tagihan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();

        // Hanya admin yang boleh mengakses controller ini
        if ($this->session->userdata('id_role') != 1) {
            redirect('auth/forbidden');
        }

        $this->load->model('M_tagihan');
        $this->load->model('M_kategori');
        $this->load->model('M_rekening');
        $this->load->model('M_santri');
        $this->load->helper(['form', 'url', 'security']);
        $this->load->library(['form_validation']);
    }

    // Menampilkan semua tagihan
    public function index()
    {
        $data = [
            'title' => 'Manajemen Tagihan',
            'tagihan' => $this->M_tagihan->get_all_tagihan()
        ];
        template('tagihan/read', $data);
    }

    // Form tambah tagihan
    public function create()
    {
        $data = [
            'title' => 'Buat Tagihan Baru',
            'kategori' => $this->M_kategori->get_all(),
            'rekening' => $this->M_rekening->get_active()
        ];
        template('tagihan/create', $data);
    }

    // Proses simpan tagihan baru
    public function store()
    {
        // Validasi input
        $this->_validate();

        // Siapkan data tagihan
        $tagihanData = [
            'id_kategori' => $this->input->post('id_kategori', true),
            'nama_tagihan' => strip_tags($this->input->post('nama_tagihan', true)),
            'deskripsi' => strip_tags($this->input->post('deskripsi', true)),
            'nominal' => str_replace('.', '', $this->input->post('nominal', true)),
            'tanggal_mulai' => $this->input->post('tanggal_mulai', true),
            'tanggal_jatuh_tempo' => $this->input->post('tanggal_jatuh_tempo', true),
            'id_rekening' => $this->input->post('id_rekening', true),
            'created_by' => $this->session->userdata('id_user')
        ];

        // Simpan tagihan
        $this->db->trans_begin();

        try {
            // Insert tagihan dan dapatkan id_tagihan
            $id_tagihan = $this->M_tagihan->insert($tagihanData);

            // Generate tagihan untuk setiap santri
            $this->_generate_tagihan_santri($id_tagihan);

            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Terjadi kesalahan saat membuat tagihan');
            }

            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Tagihan berhasil dibuat dan dikirim ke santri');
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', $e->getMessage());
        }

        redirect('tagihan');
    }

    // Detail tagihan (termasuk daftar pembayaran santri)
    public function detail($id)
    {
        $id = xss_clean($id);
        $tagihan = $this->M_tagihan->get_by_id($id);

        if (!$tagihan) {
            show_404();
        }

        $data = [
            'title' => 'Detail Tagihan',
            'tagihan' => $tagihan,
            'pembayaran' => $this->M_tagihan->get_pembayaran_by_tagihan($id)
        ];

        template('tagihan/detail', $data);
    }

    // Form edit tagihan
    public function edit($id)
    {
        $id = xss_clean($id);
        $tagihan = $this->M_tagihan->get_by_id($id);

        if (!$tagihan) {
            show_404();
        }

        $data = [
            'title' => 'Edit Tagihan',
            'tagihan' => $tagihan,
            'kategori' => $this->M_kategori->get_all(),
            'rekening' => $this->M_rekening->get_active()
        ];

        template('tagihan/edit', $data);
    }

    // Proses update tagihan
    public function update($id)
    {
        $id = xss_clean($id);
        $tagihan = $this->M_tagihan->get_by_id($id);

        if (!$tagihan) {
            show_404();
        }

        $this->_validate();

        $tagihanData = [
            'id_kategori' => $this->input->post('id_kategori', true),
            'nama_tagihan' => strip_tags($this->input->post('nama_tagihan', true)),
            'deskripsi' => strip_tags($this->input->post('deskripsi', true)),
            'nominal' => str_replace('.', '', $this->input->post('nominal', true)),
            'tanggal_mulai' => $this->input->post('tanggal_mulai', true),
            'tanggal_jatuh_tempo' => $this->input->post('tanggal_jatuh_tempo', true),
            'id_rekening' => $this->input->post('id_rekening', true)
        ];

        $this->M_tagihan->update($id, $tagihanData);
        $this->session->set_flashdata('success', 'Tagihan berhasil diperbarui');
        redirect('tagihan');
    }

    // Hapus tagihan
    public function delete($id)
    {
        // Hanya terima request AJAX
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $id = xss_clean($id);
        $response = ['status' => false, 'message' => ''];

        try {
            $this->db->trans_begin();

            // Cek apakah tagihan sudah dibayar
            $sudah_dibayar = $this->M_tagihan->cek_sudah_dibayar($id);
            if ($sudah_dibayar) {
                throw new Exception('Tidak dapat menghapus tagihan yang sudah dibayar oleh santri');
            }

            // Hapus tagihan santri terlebih dahulu (foreign key constraint akan menghapus pembayaran)
            $this->M_tagihan->hapus_tagihan_santri($id);

            // Hapus tagihan utama
            $this->M_tagihan->delete($id);

            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Gagal menghapus tagihan');
            }

            $this->db->trans_commit();
            $response = [
                'status' => true,
                'message' => 'Tagihan berhasil dihapus'
            ];
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $response = [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    // PRIVATE METHODS

    // Validasi input tagihan
    private function _validate()
    {
        $this->form_validation->set_rules('nama_tagihan', 'Nama Tagihan', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('id_kategori', 'Kategori', 'required|integer');
        $this->form_validation->set_rules('nominal', 'Nominal', 'required');
        $this->form_validation->set_rules('tanggal_mulai', 'Tanggal Mulai', 'required');
        $this->form_validation->set_rules('tanggal_jatuh_tempo', 'Tanggal Jatuh Tempo', 'required');
        $this->form_validation->set_rules('id_rekening', 'Rekening Pembayaran', 'required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($this->input->post('id_tagihan') ? 'tagihan/edit/' . $this->input->post('id_tagihan') : 'tagihan/create');
        }
    }

    // Generate tagihan untuk setiap santri
    private function _generate_tagihan_santri($id_tagihan)
    {
        // Ambil semua santri
        $santri = $this->M_santri->get_all_with_user();

        if (empty($santri)) {
            throw new Exception('Tidak ada santri yang aktif');
        }

        // Buat tagihan untuk setiap santri
        $batch_data = [];
        foreach ($santri as $s) {
            $batch_data[] = [
                'id_tagihan' => $id_tagihan,
                'id_santri' => $s->id_santri,
                'status' => 'belum_bayar',
                'created_at' => date('Y-m-d H:i:s')
            ];
        }

        $this->M_tagihan->batch_insert_tagihan_santri($batch_data);
    }
}
