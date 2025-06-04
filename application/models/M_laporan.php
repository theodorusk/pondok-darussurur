<?php
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_laporan extends CI_Model {
    private $table = 'laporan_keuangan';

    public function generate_report($start_date, $end_date, $user_id) {
        $this->db->trans_start();

        // Get totals
        $total_pemasukan = $this->get_total_pemasukan($start_date, $end_date);
        $total_pengeluaran = $this->get_total_pengeluaran($start_date, $end_date);
        
        // Get previous saldo
        $saldo_awal = $this->get_previous_saldo($start_date);
        $saldo_akhir = $saldo_awal + $total_pemasukan - $total_pengeluaran;

        $data = [
            'periode_awal' => $start_date,
            'periode_akhir' => $end_date,
            'total_pemasukan' => $total_pemasukan,
            'total_pengeluaran' => $total_pengeluaran,
            'saldo_awal' => $saldo_awal,
            'saldo_akhir' => $saldo_akhir,
            'created_by' => $user_id,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->db->insert($this->table, $data);
        $id_laporan = $this->db->insert_id();

        $this->db->trans_complete();
        return $id_laporan;
    }

    private function get_total_pemasukan($start_date, $end_date) {
        return $this->db->select_sum('nominal')
            ->where('DATE(tanggal_pemasukan) >=', $start_date)
            ->where('DATE(tanggal_pemasukan) <=', $end_date)
            ->get('pemasukan')
            ->row()
            ->nominal ?? 0;
    }

    private function get_total_pengeluaran($start_date, $end_date) {
        return $this->db->select_sum('nominal')
            ->where('DATE(tanggal_pengeluaran) >=', $start_date)
            ->where('DATE(tanggal_pengeluaran) <=', $end_date)
            ->get('pengeluaran')
            ->row()
            ->nominal ?? 0;
    }

    private function get_previous_saldo($date) {
        $last_report = $this->db->where('periode_akhir <', $date)
            ->order_by('periode_akhir', 'DESC')
            ->limit(1)
            ->get($this->table)
            ->row();

        return $last_report ? $last_report->saldo_akhir : 0;
    }
}