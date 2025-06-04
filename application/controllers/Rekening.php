
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rekening extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();

        // Hanya admin yang boleh mengakses controller ini
        if ($this->session->userdata('id_role') != 1) {
            redirect('auth/forbidden');
        }

        $this->load->model('M_rekening');
        $this->load->helper(['form', 'url', 'security']);
        $this->load->library(['form_validation']);
    }

    // Menampilkan daftar rekening
    public function index()
    {
        $data = [
            'title' => 'Manajemen Rekening',
            'rekening' => $this->M_rekening->get_all()
        ];

        template('rekening/read', $data);
    }

    // Form tambah rekening
    public function create()
    {
        $data = [
            'title' => 'Tambah Rekening'
        ];

        template('rekening/create', $data);
    }

    // Proses simpan rekening baru
    public function store()
    {
        // Validasi input
        $this->_validate();

        $rekeningData = [
            'nama_bank' => strip_tags($this->input->post('nama_bank', true)),
            'no_rekening' => strip_tags($this->input->post('no_rekening', true)),
            'atas_nama' => strip_tags($this->input->post('atas_nama', true)),
            'is_active' => $this->input->post('is_active', true) ? 1 : 0
        ];

        $this->M_rekening->insert($rekeningData);
        $this->session->set_flashdata('success', 'Rekening baru berhasil ditambahkan');
        redirect('rekening');
    }

    // Form edit rekening
    public function edit($id)
    {
        $id = xss_clean($id);
        $rekening = $this->M_rekening->get_by_id($id);

        if (!$rekening) {
            show_404();
        }

        $data = [
            'title' => 'Edit Rekening',
            'rekening' => $rekening
        ];

        template('rekening/edit', $data);
    }

    // Proses update rekening
    public function update($id)
    {
        $id = xss_clean($id);
        $rekening = $this->M_rekening->get_by_id($id);

        if (!$rekening) {
            show_404();
        }

        // Validasi input
        $this->_validate();

        $rekeningData = [
            'nama_bank' => strip_tags($this->input->post('nama_bank', true)),
            'no_rekening' => strip_tags($this->input->post('no_rekening', true)),
            'atas_nama' => strip_tags($this->input->post('atas_nama', true)),
            'is_active' => $this->input->post('is_active', true) ? 1 : 0
        ];

        $this->M_rekening->update($id, $rekeningData);
        $this->session->set_flashdata('success', 'Rekening berhasil diperbarui');
        redirect('rekening');
    }

    // Toggle status aktif/nonaktif rekening
    public function toggle($id)
    {
        // Hanya terima request AJAX
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $id = xss_clean($id);
        $rekening = $this->M_rekening->get_by_id($id);

        if (!$rekening) {
            $response = ['status' => false, 'message' => 'Rekening tidak ditemukan'];
        } else {
            $newStatus = $rekening->is_active == 1 ? 0 : 1;
            $this->M_rekening->update($id, ['is_active' => $newStatus]);

            $response = [
                'status' => true,
                'message' => 'Status rekening berhasil diubah',
                'is_active' => $newStatus
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    // Hapus rekening
    public function delete($id)
    {
        // Hanya terima request AJAX
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $id = xss_clean($id);
        $response = ['status' => false, 'message' => ''];

        // Cek apakah rekening digunakan di tagihan
        $used = $this->M_rekening->is_used($id);

        if ($used) {
            $response = [
                'status' => false,
                'message' => 'Rekening tidak dapat dihapus karena sedang digunakan pada tagihan'
            ];
        } else {
            if ($this->M_rekening->delete($id)) {
                $response = [
                    'status' => true,
                    'message' => 'Rekening berhasil dihapus'
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => 'Gagal menghapus rekening'
                ];
            }
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    // PRIVATE METHODS

    // Validasi input rekening
    private function _validate()
    {
        $this->form_validation->set_rules('nama_bank', 'Nama Bank', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('no_rekening', 'Nomor Rekening', 'required|trim|max_length[50]');
        $this->form_validation->set_rules('atas_nama', 'Atas Nama', 'required|trim|max_length[100]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($this->input->post('id_rekening') ? 'rekening/edit/' . $this->input->post('id_rekening') : 'rekening/create');
        }
    }
}
