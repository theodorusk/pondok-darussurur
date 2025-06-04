<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembayaran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();

        // Hanya santri yang boleh mengakses controller ini
        if ($this->session->userdata('id_role') != 2) {
            redirect('auth/forbidden');
        }

        $this->load->model('M_pembayaran');
        $this->load->model('M_santri');
        $this->load->helper(['form', 'url', 'security']);
        $this->load->library(['form_validation']);
    }

    // Halaman utama pembayaran (daftar semua tagihan santri)
    public function index()
    {
        // Ambil ID santri berdasarkan ID user yang login
        $id_user = $this->session->userdata('id_user');
        $santri = $this->M_santri->get_by_user($id_user);

        if (!$santri) {
            $this->session->set_flashdata('error', 'Data santri tidak ditemukan');
            redirect('dashboard/santri');
        }

        $data = [
            'title' => 'Informasi Pembayaran',
            'tagihan' => $this->M_pembayaran->get_tagihan_by_santri($santri->id_santri),
            // Tambahkan data riwayat untuk tab Semua Riwayat
            'riwayat' => $this->M_pembayaran->get_all_riwayat_by_santri($santri->id_santri)
        ];

        template('pembayaran/list', $data);
    }

    // Detail tagihan dan form upload bukti pembayaran
    public function detail($id)
    {
        $id = xss_clean($id);

        // Ambil ID santri berdasarkan ID user yang login
        $id_user = $this->session->userdata('id_user');
        $santri = $this->M_santri->get_by_user($id_user);

        if (!$santri) {
            $this->session->set_flashdata('error', 'Data santri tidak ditemukan');
            redirect('pembayaran');
        }

        // Ambil detail pembayaran
        $pembayaran = $this->M_pembayaran->get_pembayaran_by_id($id, $santri->id_santri);

        if (!$pembayaran) {
            show_404();
        }

        $data = [
            'title' => 'Detail Pembayaran',
            'pembayaran' => $pembayaran
        ];

        template('pembayaran/detail', $data);
    }

    // Proses upload bukti pembayaran
    public function upload($id)
    {
        $id = xss_clean($id);

        // Ambil ID santri berdasarkan ID user yang login
        $id_user = $this->session->userdata('id_user');
        $santri = $this->M_santri->get_by_user($id_user);

        if (!$santri) {
            $this->session->set_flashdata('error', 'Data santri tidak ditemukan');
            redirect('pembayaran');
        }

        // Ambil detail pembayaran
        $pembayaran = $this->M_pembayaran->get_pembayaran_by_id($id, $santri->id_santri);

        if (!$pembayaran) {
            show_404();
        }

        // Pastikan status pembayaran belum dibayar atau ditolak
        if ($pembayaran->status != 'belum_bayar' && $pembayaran->status != 'ditolak') {
            $this->session->set_flashdata('error', 'Pembayaran ini tidak dapat diubah karena statusnya ' . $pembayaran->status);
            redirect('pembayaran/detail/' . $id);
        }

        // Validasi input
        $this->form_validation->set_rules('nominal_bayar', 'Nominal Pembayaran', 'required');
        $this->form_validation->set_rules('catatan_santri', 'Catatan', 'trim');

        if (empty($_FILES['bukti_pembayaran']['name'])) {
            $this->form_validation->set_rules('bukti_pembayaran', 'Bukti Pembayaran', 'required');
        }

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('pembayaran/detail/' . $id);
        }

        // Upload file bukti pembayaran
        $config = [
            'upload_path' => './uploads/bukti_pembayaran/',
            'allowed_types' => 'jpg|jpeg|png|pdf',
            'max_size' => 2048, // 2MB
            'encrypt_name' => true
        ];

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('bukti_pembayaran')) {
            $this->session->set_flashdata('error', $this->upload->display_errors());
            redirect('pembayaran/detail/' . $id);
        }

        // Hapus file lama jika ada
        if ($pembayaran->bukti_pembayaran && file_exists('./uploads/bukti_pembayaran/' . $pembayaran->bukti_pembayaran)) {
            unlink('./uploads/bukti_pembayaran/' . $pembayaran->bukti_pembayaran);
        }

        // Update data pembayaran
        $pembayaranData = [
            'nominal_bayar' => str_replace('.', '', $this->input->post('nominal_bayar', true)),
            'tanggal_bayar' => date('Y-m-d H:i:s'),
            'bukti_pembayaran' => $this->upload->data('file_name'),
            'catatan_santri' => $this->input->post('catatan_santri', true),
            'status' => 'menunggu_konfirmasi',
            'konfirmasi_by' => null,
            'tanggal_konfirmasi' => null,
            'catatan_admin' => null
        ];

        $this->M_pembayaran->update($id, $pembayaranData);

        // Tambahkan log jika sebelumnya ditolak
        if ($pembayaran->status == 'ditolak') {
            $logData = [
                'id_pembayaran' => $id,
                'status_lama' => 'ditolak',
                'status_baru' => 'menunggu_konfirmasi',
                'catatan' => 'Upload ulang bukti pembayaran oleh santri',
                'created_by' => $this->session->userdata('id_user')
            ];

            $this->load->model('M_log');
            $this->M_log->insert($logData);
        }

        $this->session->set_flashdata('success', 'Bukti pembayaran berhasil diunggah. Silahkan tunggu konfirmasi admin.');
        redirect('pembayaran');
    }
}
