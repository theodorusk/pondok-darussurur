<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengeluaran extends CI_Controller {
    public function __construct() {
        parent::__construct();
        is_logged_in();
        
        if ($this->session->userdata('id_role') != 1) {
            redirect('auth/forbidden');
        }

        $this->load->model('M_pengeluaran');
        $this->load->library(['form_validation', 'upload']);
    }

    public function index() {
        $data = [
            'title' => 'Data Pengeluaran',
            'pengeluaran' => $this->M_pengeluaran->get_all()
        ];
        template('pengeluaran/list', $data);
    }

    public function create() {
        $data = [
            'title' => 'Tambah Pengeluaran'
        ];
        template('pengeluaran/create', $data);
    }

    public function store() {
        $this->form_validation->set_rules('nama_pengeluaran', 'Nama Pengeluaran', 'required|trim');
        $this->form_validation->set_rules('nominal', 'Nominal', 'required|trim');
        $this->form_validation->set_rules('tanggal_pengeluaran', 'Tanggal Pengeluaran', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('pengeluaran/create');
            return;
        }

        $data = [
            'nama_pengeluaran' => $this->input->post('nama_pengeluaran', true),
            'nominal' => str_replace('.', '', $this->input->post('nominal')),
            'keterangan' => $this->input->post('keterangan', true),
            'tanggal_pengeluaran' => $this->input->post('tanggal_pengeluaran') . ' ' . date('H:i:s'),
            'created_by' => $this->session->userdata('id_user')
        ];

        // Handle file upload if exists
        if (!empty($_FILES['bukti_pengeluaran']['name'])) {
            $config['upload_path'] = './uploads/bukti_pengeluaran/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
            $config['max_size'] = 2048;
            $config['encrypt_name'] = true;

            // Create directory if not exists
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
            }

            $this->upload->initialize($config);

            if (!$this->upload->do_upload('bukti_pengeluaran')) {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('pengeluaran/create');
                return;
            }

            $data['bukti_pengeluaran'] = $this->upload->data('file_name');
        }

        if ($this->M_pengeluaran->insert($data)) {
            $this->session->set_flashdata('success', 'Data pengeluaran berhasil ditambahkan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menambahkan data pengeluaran');
        }
        
        redirect('pengeluaran');
    }

    public function edit($id) {
        $pengeluaran = $this->M_pengeluaran->get_by_id($id);
        
        if (!$pengeluaran) {
            show_404();
        }

        $data = [
            'title' => 'Edit Pengeluaran',
            'pengeluaran' => $pengeluaran
        ];
        
        template('pengeluaran/update', $data);
    }

    public function update($id) {
        $pengeluaran = $this->M_pengeluaran->get_by_id($id);
        
        if (!$pengeluaran) {
            show_404();
        }

        $this->form_validation->set_rules('nama_pengeluaran', 'Nama Pengeluaran', 'required|trim');
        $this->form_validation->set_rules('nominal', 'Nominal', 'required|trim');
        $this->form_validation->set_rules('tanggal_pengeluaran', 'Tanggal Pengeluaran', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('pengeluaran/edit/' . $id);
            return;
        }

        $data = [
            'nama_pengeluaran' => $this->input->post('nama_pengeluaran', true),
            'nominal' => str_replace('.', '', $this->input->post('nominal')),
            'keterangan' => $this->input->post('keterangan', true),
            'tanggal_pengeluaran' => $this->input->post('tanggal_pengeluaran') . ' ' . date('H:i:s')
        ];

        // Handle file upload if exists
        if (!empty($_FILES['bukti_pengeluaran']['name'])) {
            $config['upload_path'] = './uploads/bukti_pengeluaran/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
            $config['max_size'] = 2048;
            $config['encrypt_name'] = true;

            $this->upload->initialize($config);

            if (!$this->upload->do_upload('bukti_pengeluaran')) {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('pengeluaran/edit/' . $id);
                return;
            }

            // Delete old file if exists
            if ($pengeluaran->bukti_pengeluaran && 
                file_exists('./uploads/bukti_pengeluaran/' . $pengeluaran->bukti_pengeluaran)) {
                unlink('./uploads/bukti_pengeluaran/' . $pengeluaran->bukti_pengeluaran);
            }

            $data['bukti_pengeluaran'] = $this->upload->data('file_name');
        }

        if ($this->M_pengeluaran->update($id, $data)) {
            $this->session->set_flashdata('success', 'Data pengeluaran berhasil diperbarui');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui data pengeluaran');
        }
        
        redirect('pengeluaran');
    }

    public function delete($id) {
        // Hanya terima request AJAX
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $id = xss_clean($id);
        $pengeluaran = $this->M_pengeluaran->get_by_id($id);

        if (!$pengeluaran) {
            $response = [
                'status' => false,
                'message' => 'Data pengeluaran tidak ditemukan'
            ];
        } else {
            // Hapus file bukti jika ada
            if ($pengeluaran->bukti_pengeluaran && 
                file_exists('./uploads/bukti_pengeluaran/' . $pengeluaran->bukti_pengeluaran)) {
                unlink('./uploads/bukti_pengeluaran/' . $pengeluaran->bukti_pengeluaran);
            }

            if ($this->M_pengeluaran->delete($id)) {
                $response = [
                    'status' => true,
                    'message' => 'Data pengeluaran berhasil dihapus'
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => 'Gagal menghapus data pengeluaran'
                ];
            }
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function detail($id) {
        $pengeluaran = $this->M_pengeluaran->get_by_id($id);
        
        if (!$pengeluaran) {
            show_404();
        }

        $data = [
            'title' => 'Detail Pengeluaran',
            'pengeluaran' => $pengeluaran
        ];

        template('pengeluaran/detail', $data);
    }
}