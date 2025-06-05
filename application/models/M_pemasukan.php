<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_pemasukan extends CI_Model 
{
    private $table = 'pemasukan';

    public function get_all() {
        return $this->db->select('pemasukan.*, pembayaran_santri.id_tagihan, tagihan.nama_tagihan, 
                                santri.nis, user.nama_user as nama_santri, admin.nama_user as nama_admin')
            ->from($this->table)
            ->join('pembayaran_santri', 'pembayaran_santri.id_pembayaran = pemasukan.id_pembayaran')
            ->join('tagihan', 'tagihan.id_tagihan = pembayaran_santri.id_tagihan')
            ->join('santri', 'santri.id_santri = pembayaran_santri.id_santri')
            ->join('user', 'user.id_user = santri.id_user')
            ->join('user as admin', 'admin.id_user = pemasukan.created_by')
            ->order_by('pemasukan.tanggal_pemasukan', 'DESC')
            ->get()
            ->result();
    }

    public function get_by_period($start_date, $end_date) {
        return $this->db->select('pemasukan.*, pembayaran_santri.id_tagihan, tagihan.nama_tagihan')
            ->from($this->table)
            ->join('pembayaran_santri', 'pembayaran_santri.id_pembayaran = pemasukan.id_pembayaran')
            ->join('tagihan', 'tagihan.id_tagihan = pembayaran_santri.id_tagihan')
            ->where('DATE(tanggal_pemasukan) >=', $start_date)
            ->where('DATE(tanggal_pemasukan) <=', $end_date)
            ->order_by('tanggal_pemasukan', 'DESC')
            ->get()
            ->result();
    }

    public function get_total() {
        $this->db->select_sum('nominal');
        $query = $this->db->get('pemasukan');
        $result = $query->row();
        return $result ? $result->nominal : 0;
    }

    public function get_total_by_period($start_date = null, $end_date = null) {
        $this->db->select_sum('nominal');
        
        if ($start_date && $end_date) {
            $this->db->where('DATE(tanggal_pemasukan) >=', $start_date);
            $this->db->where('DATE(tanggal_pemasukan) <=', $end_date);
        }
        
        $query = $this->db->get('pemasukan');
        $result = $query->row();
        return $result ? $result->nominal : 0;
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }
}