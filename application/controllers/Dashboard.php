<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        // Cek apakah sudah login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
        
        // Load model yang dibutuhkan untuk dashboard
        $this->load->model(['M_dashboard', 'M_laporan', 'M_kategori', 'M_pembayaran', 'M_pengeluaran']);
    }

    public function index()
    {
        // Redirect sesuai role
        $role = $this->session->userdata('id_role');

        if ($role == 1) {
            redirect('dashboard/admin');
        } elseif ($role == 2) {
            redirect('dashboard/santri');
        } else {
            redirect('auth/forbidden');
        }
    }

    public function admin()
    {
        if ($this->session->userdata('id_role') != 1) {
            redirect('auth/forbidden');
        }

        // Data untuk summary cards
        $data['title'] = 'Dashboard Admin';
        $data['nama_user'] = $this->session->userdata('nama_user');
        $data['santri_count'] = $this->M_dashboard->count_santri();
        $data['menunggu_konfirmasi'] = $this->M_dashboard->count_pembayaran_by_status('menunggu_konfirmasi');
        $data['belum_bayar'] = $this->M_dashboard->count_pembayaran_by_status('belum_bayar');
        
        // Data keuangan
        $data['total_pemasukan'] = $this->M_laporan->get_total_pemasukan_all();
        $data['total_pengeluaran'] = $this->M_laporan->get_total_pengeluaran_all();
        $data['saldo'] = $data['total_pemasukan'] - $data['total_pengeluaran'];
        
        // Data bulan ini
        $start_date = date('Y-m-01'); // awal bulan ini
        $end_date = date('Y-m-t'); // akhir bulan ini
        $data['pemasukan_bulan_ini'] = $this->M_laporan->get_total_pemasukan($start_date, $end_date);
        $data['pengeluaran_bulan_ini'] = $this->M_laporan->get_total_pengeluaran($start_date, $end_date);
        
        // Data untuk tabel pembayaran terbaru
        $data['pembayaran_terbaru'] = $this->M_dashboard->get_recent_payments(10);
        
        // Data untuk chart kategori pembayaran
        $categories = $this->M_kategori->get_all();
        $category_data = [
            'labels' => [],
            'values' => [],
            'colors' => ['#3498db', '#2ecc71', '#f1c40f', '#e74c3c', '#9b59b6', '#1abc9c', '#34495e', '#f39c12']
        ];
        
        foreach ($categories as $i => $cat) {
            $category_data['labels'][] = $cat->nama_kategori;
            $category_data['values'][] = $this->M_laporan->get_total_by_category($cat->id_kategori);
            // Cycling through colors if there are more categories than colors
            $category_data['colors'][] = $category_data['colors'][$i % count($category_data['colors'])];
        }
        $data['category_data'] = json_encode($category_data);
        
        // Data untuk chart bulanan tahun ini
        $year = date('Y');
        $monthly_data = [
            'months' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            'income' => [],
            'expense' => []
        ];
        
        for ($i = 1; $i <= 12; $i++) {
            $month_start = sprintf('%s-%02d-01', $year, $i);
            $month_end = date('Y-m-t', strtotime($month_start));
            
            $monthly_data['income'][] = $this->M_laporan->get_total_pemasukan($month_start, $month_end);
            $monthly_data['expense'][] = $this->M_laporan->get_total_pengeluaran($month_start, $month_end);
        }
        $data['monthly_data'] = json_encode($monthly_data);

        template('dashboard/admin', $data);
    }

    public function santri()
    {
        if ($this->session->userdata('id_role') != 2) {
            redirect('auth/forbidden');
        }
        
        // Get santri ID based on logged in user
        $id_user = $this->session->userdata('id_user');
        $this->load->model('M_santri');
        $santri = $this->M_santri->get_by_user($id_user);
        
        if (!$santri) {
            $this->session->set_flashdata('error', 'Data santri tidak ditemukan.');
            redirect('auth/logout');
        }
        
        $id_santri = $santri->id_santri;
        
        // Load required models
        $this->load->model(['M_dashboard', 'M_pembayaran']);
        
        // Get payment summary from dashboard model
        $summary = $this->M_dashboard->get_santri_payment_summary($id_santri);
        
        // Prepare data for view
        $data = [
            'title' => 'Dashboard Santri',
            'nama_user' => $this->session->userdata('nama_user'),
            'total_tagihan' => $summary->total_tagihan,
            'diterima' => $summary->diterima,
            'menunggu_konfirmasi' => $summary->menunggu_konfirmasi,
            'belum_bayar' => $summary->belum_bayar,
            'ditolak' => $summary->ditolak,
            'tagihan_akan_datang' => $summary->tagihan_akan_datang,
            'riwayat_pembayaran' => []
        ];
        
        // Get payment history
        $riwayat = $this->M_pembayaran->get_all_riwayat_by_santri($id_santri);
        
        // Filter out unpaid payments from history
        $filtered_riwayat = array_filter($riwayat, function($item) {
            return $item->status != 'belum_bayar';
        });
        
        // Sort by payment date (newest first)
        usort($filtered_riwayat, function($a, $b) {
            $date_a = strtotime($a->tanggal_bayar ?? $a->created_at);
            $date_b = strtotime($b->tanggal_bayar ?? $b->created_at);
            return $date_b - $date_a;
        });
        
        // Limit to 5 items
        $data['riwayat_pembayaran'] = array_slice($filtered_riwayat, 0, 5);
        
        template('dashboard/santri', $data);
    }
    
    public function get_santri_data()
    {
        // Pastikan request AJAX dan pengguna adalah santri
        if (!$this->input->is_ajax_request() || $this->session->userdata('id_role') != 2) {
            show_404();
        }
        
        $this->load->model(['M_dashboard', 'M_santri', 'M_pembayaran']);
        
        // Get ID santri berdasarkan user yang login
        $id_user = $this->session->userdata('id_user');
        $santri = $this->M_santri->get_by_user($id_user);
        
        if (!$santri) {
            $response = [
                'status' => false,
                'message' => 'Data santri tidak ditemukan'
            ];
            
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
            return;
        }
        
        // Get payment summary
        $summary = $this->M_dashboard->get_santri_payment_summary($santri->id_santri);
        
        // Get recent payment history
        $riwayat = $this->M_pembayaran->get_recent_riwayat_by_santri($santri->id_santri, 5);
        
        $response = [
            'status' => true,
            'data' => [
                'total_tagihan' => $summary->total_tagihan,
                'belum_bayar' => $summary->belum_bayar,
                'menunggu_konfirmasi' => $summary->menunggu_konfirmasi,
                'diterima' => $summary->diterima,
                'ditolak' => $summary->ditolak,
                'tagihan_akan_datang' => $summary->tagihan_akan_datang,
                'riwayat_pembayaran' => $riwayat
            ]
        ];
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
}
