<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_laporan extends CI_Model 
{
    private $table = 'laporan_keuangan';

    public function get_all() 
    {
        // Tambahkan join dengan tabel user untuk mengambil nama pembuat laporan
        return $this->db->select('l.*, u.nama_user as created_by_name')
                       ->from($this->table.' l')
                       ->join('user u', 'u.id_user = l.created_by', 'left')
                       ->order_by('l.periode_akhir', 'DESC')
                       ->get()
                       ->result();
    }

    public function generate_report($start_date, $end_date, $keterangan, $user_id) 
    {
        $this->db->trans_start();

        try {
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
                'keterangan' => $keterangan,
                'created_by' => $user_id,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->db->insert($this->table, $data);
            $id_laporan = $this->db->insert_id();

            $this->db->trans_complete();
            return $id_laporan;

        } catch (Exception $e) {
            $this->db->trans_rollback();
            throw $e;
        }
    }

    public function get_total_pemasukan($start_date, $end_date)
    {
        $result = $this->db->select_sum('nominal')
                          ->where('DATE(tanggal_pemasukan) >=', $start_date)
                          ->where('DATE(tanggal_pemasukan) <=', $end_date)
                          ->get('pemasukan')
                          ->row();
        return $result->nominal ?? 0;
    }
    
    public function get_total_pengeluaran($start_date, $end_date)
    {
        $result = $this->db->select_sum('nominal')
                          ->where('DATE(tanggal_pengeluaran) >=', $start_date)
                          ->where('DATE(tanggal_pengeluaran) <=', $end_date)
                          ->get('pengeluaran')
                          ->row();
        return $result->nominal ?? 0;
    }
    
    public function get_total_pemasukan_all()
    {
        $result = $this->db->select_sum('nominal')
                          ->get('pemasukan')
                          ->row();
        return $result->nominal ?? 0;
    }

    public function get_total_pengeluaran_all()
    {
        $result = $this->db->select_sum('nominal')
                          ->get('pengeluaran')
                          ->row();
        return $result->nominal ?? 0;
    }
    
    public function get_total_by_category($id_kategori)
    {
        $result = $this->db->select_sum('p.nominal')
                          ->from('pemasukan p')
                          ->join('pembayaran_santri ps', 'p.id_pembayaran = ps.id_pembayaran', 'left')
                          ->join('tagihan t', 'ps.id_tagihan = t.id_tagihan', 'left')
                          ->where('t.id_kategori', $id_kategori)
                          ->where('ps.status', 'diterima')
                          ->get()
                          ->row();
        return $result->nominal ?? 0;
    }

    private function get_previous_saldo($date) 
    {
        $last_report = $this->db->where('periode_akhir <', $date)
            ->order_by('periode_akhir', 'DESC')
            ->limit(1)
            ->get($this->table)
            ->row();

        return $last_report ? $last_report->saldo_akhir : 0;
    }

    public function get_by_id($id_laporan)
    {
        return $this->db->get_where($this->table, ['id_laporan' => $id_laporan])->row();
    }

    public function get_pemasukan_detail($id_laporan)
    {
        $laporan = $this->get_by_id($id_laporan);
        
        return $this->db->select('p.*, ps.id_tagihan, t.nama_tagihan, s.nis, u.nama_user as nama_santri')
                        ->from('pemasukan p')
                        ->join('pembayaran_santri ps', 'ps.id_pembayaran = p.id_pembayaran')
                        ->join('tagihan t', 't.id_tagihan = ps.id_tagihan')
                        ->join('santri s', 's.id_santri = ps.id_santri')
                        ->join('user u', 'u.id_user = s.id_user')
                        ->where('DATE(p.tanggal_pemasukan) >=', $laporan->periode_awal)
                        ->where('DATE(p.tanggal_pemasukan) <=', $laporan->periode_akhir)
                        ->get()
                        ->result();
    }

    public function get_pengeluaran_detail($id_laporan) 
    {
        $laporan = $this->get_by_id($id_laporan);
        
        return $this->db->select('p.*, u.nama_user as created_by_name')
                        ->from('pengeluaran p')
                        ->join('user u', 'u.id_user = p.created_by')
                        ->where('DATE(p.tanggal_pengeluaran) >=', $laporan->periode_awal)
                        ->where('DATE(p.tanggal_pengeluaran) <=', $laporan->periode_akhir)
                        ->get()
                        ->result();
    }

    public function delete($id_laporan) 
    {
        // Mulai transaksi
        $this->db->trans_start();
        
        try {
            // Hapus laporan
            $this->db->where('id_laporan', $id_laporan);
            $this->db->delete($this->table);
            
            $this->db->trans_complete();
            return ($this->db->trans_status() === TRUE);
            
        } catch (Exception $e) {
            $this->db->trans_rollback();
            return false;
        }
    }
}