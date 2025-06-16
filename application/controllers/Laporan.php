<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Cek login
        if (!$this->session->userdata('id_user')) {
            redirect('auth');
        }
        // Load model
        $this->load->model('M_laporan');
        // Load helper fungsi
        $this->load->helper('fungsi');
    }

    public function index()
    {
        $data = [
            'title' => 'Laporan Keuangan',
            'laporan' => $this->M_laporan->get_all()
        ];

        template('laporan/list', $data);
    }

    public function generate()
    {
        // Validasi input
        $this->form_validation->set_rules('periode_awal', 'Periode Awal', 'required');
        $this->form_validation->set_rules('periode_akhir', 'Periode Akhir', 'required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('laporan');
        }

        try {
            $periode_awal = $this->input->post('periode_awal');
            $periode_akhir = $this->input->post('periode_akhir');
            $keterangan = $this->input->post('keterangan');
            
            // Generate laporan
            $id_laporan = $this->M_laporan->generate_report(
                $periode_awal,
                $periode_akhir,
                $keterangan,
                $this->session->userdata('id_user')
            );

            if ($id_laporan) {
                $this->session->set_flashdata('success', 'Laporan berhasil dibuat');
            } else {
                $this->session->set_flashdata('error', 'Gagal membuat laporan');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('error', $e->getMessage());
        }

        redirect('laporan');
    }

    public function detail($id_laporan)
    {
        $data = [
            'title' => 'Detail Laporan Keuangan',
            'laporan' => $this->M_laporan->get_by_id($id_laporan),
            'pemasukan' => $this->M_laporan->get_pemasukan_detail($id_laporan),
            'pengeluaran' => $this->M_laporan->get_pengeluaran_detail($id_laporan)
        ];

        template('laporan/detail', $data);
    }

    public function delete($id)
    {
        // Hanya terima request AJAX
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $id = xss_clean($id);
        $response = ['status' => false, 'message' => ''];

        try {
            // Cek apakah laporan ada
            $laporan = $this->M_laporan->get_by_id($id);
            if (!$laporan) {
                throw new Exception('Data laporan tidak ditemukan');
            }

            // Proses hapus
            if ($this->M_laporan->delete($id)) {
                $response = [
                    'status' => true,
                    'message' => 'Laporan berhasil dihapus'
                ];
            } else {
                throw new Exception('Gagal menghapus laporan');
            }

        } catch (Exception $e) {
            $response = [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function print($id_laporan)
    {
        // Ambil data
        $laporan = $this->M_laporan->get_by_id($id_laporan);
        $pemasukan = $this->M_laporan->get_pemasukan_detail($id_laporan);
        $pengeluaran = $this->M_laporan->get_pengeluaran_detail($id_laporan);
        
        if (!$laporan) {
            show_404();
        }
        
        // Load view untuk konten PDF
        $html = $this->load->view('laporan/print_pdf', [
            'laporan' => $laporan,
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran
        ], true);
        
        // Generate nama file PDF
        $filename = 'Laporan_Keuangan_' . sprintf('%03d', $laporan->id_laporan);
        
        // Load library PDF (jika tidak di-autoload)
        $this->load->library('pdf');
        
        // Generate PDF menggunakan library
        $this->pdf->generate($html, $filename, 'A4', 'portrait');
    }
}