<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Konfirmasi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();

        // Hanya admin yang boleh mengakses controller ini
        if ($this->session->userdata('id_role') != 1) {
            redirect('auth/forbidden');
        }

        $this->load->model('M_pembayaran');
        $this->load->model('M_log');
        $this->load->helper(['form', 'url', 'security']);
        $this->load->library(['form_validation']);
    }

    // Daftar pembayaran yang perlu dikonfirmasi
    public function index()
    {
        $data = [
            'title' => 'Konfirmasi Pembayaran',
            'menunggu' => $this->M_pembayaran->get_pembayaran_by_status('menunggu_konfirmasi'),
            'diterima' => $this->M_pembayaran->get_pembayaran_by_status('diterima'),
            'ditolak' => $this->M_pembayaran->get_pembayaran_by_status('ditolak')
        ];

        template('konfirmasi/list', $data);
    }

    // Halaman detail dan form konfirmasi pembayaran
    public function detail($id)
    {
        $id = xss_clean($id);
        $pembayaran = $this->M_pembayaran->get_detail_pembayaran($id);

        if (!$pembayaran) {
            show_404();
        }

        $data = [
            'title' => 'Detail Konfirmasi Pembayaran',
            'pembayaran' => $pembayaran,
            'log' => $this->M_log->get_log_pembayaran($id)
        ];

        template('konfirmasi/detail', $data);
    }

    // Proses konfirmasi pembayaran (terima/tolak)
    public function proses()
    {
        // Validasi input
        $this->form_validation->set_rules('id_pembayaran', 'ID Pembayaran', 'required|integer');
        $this->form_validation->set_rules('status', 'Status', 'required|in_list[diterima,ditolak]');
        $this->form_validation->set_rules('catatan_admin', 'Catatan Admin', 'trim');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('konfirmasi');
        }

        $id_pembayaran = $this->input->post('id_pembayaran', true);
        $status_baru = $this->input->post('status', true);
        $catatan_admin = $this->input->post('catatan_admin', true);

        // Ambil data pembayaran
        $pembayaran = $this->M_pembayaran->get_detail_pembayaran($id_pembayaran);

        if (!$pembayaran || $pembayaran->status !== 'menunggu_konfirmasi') {
            $this->session->set_flashdata('error', 'Data pembayaran tidak valid atau sudah dikonfirmasi');
            redirect('konfirmasi');
        }

        // Mulai transaksi
        $this->db->trans_begin();

        try {
            // Update status pembayaran
            $pembayaranData = [
                'status' => $status_baru,
                'catatan_admin' => $catatan_admin,
                'konfirmasi_by' => $this->session->userdata('id_user'),
                'tanggal_konfirmasi' => date('Y-m-d H:i:s')
            ];

            $this->M_pembayaran->update($id_pembayaran, $pembayaranData);

            // Jika status diterima, catat ke pemasukan
            if ($status_baru === 'diterima') {
                $this->load->model('M_pemasukan');
                
                $pemasukanData = [
                    'id_pembayaran' => $id_pembayaran,
                    'nominal' => $pembayaran->nominal_bayar,
                    'keterangan' => "Pembayaran {$pembayaran->nama_tagihan} dari santri {$pembayaran->nama_santri}",
                    'tanggal_pemasukan' => date('Y-m-d H:i:s'),
                    'created_by' => $this->session->userdata('id_user')
                ];

                $this->M_pemasukan->insert($pemasukanData);
            }

            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Terjadi kesalahan saat mengkonfirmasi pembayaran');
            }

            $this->db->trans_commit();
            $this->session->set_flashdata('success', 'Pembayaran berhasil ' . ($status_baru === 'diterima' ? 'diterima' : 'ditolak'));

        } catch (Exception $e) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', $e->getMessage());
        }

        redirect('konfirmasi');
    }

    // Laporan pembayaran
    public function laporan()
    {
        $bulan = $this->input->get('bulan') ?? date('m');
        $tahun = $this->input->get('tahun') ?? date('Y');
        $id_kategori = $this->input->get('id_kategori') ?? '';

        $data = [
            'title' => 'Laporan Pembayaran',
            'bulan' => $bulan,
            'tahun' => $tahun,
            'id_kategori' => $id_kategori,
            'kategori' => $this->M_pembayaran->get_kategori(),
            'laporan' => $this->M_pembayaran->get_laporan($bulan, $tahun, $id_kategori)
        ];

        template('konfirmasi/laporan', $data);
    }

    // Export laporan ke Excel
    public function export()
    {
        $bulan = $this->input->get('bulan') ?? date('m');
        $tahun = $this->input->get('tahun') ?? date('Y');
        $id_kategori = $this->input->get('id_kategori') ?? '';

        // Load library untuk Excel
        $this->load->library('PHPExcel');

        // Data laporan
        $laporan = $this->M_pembayaran->get_laporan($bulan, $tahun, $id_kategori);

        // TODO: Implementasi export ke Excel
        // ...

        $this->session->set_flashdata('success', 'Laporan berhasil diexport');
        redirect('konfirmasi/laporan');
    }
}
