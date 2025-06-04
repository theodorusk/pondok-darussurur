
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_log extends CI_Model
{
    private $table = 'log_pembayaran';

    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function get_log_pembayaran($id_pembayaran)
    {
        return $this->db
            ->select('log_pembayaran.*, user.nama_user as created_by_name')
            ->from($this->table)
            ->join('user', 'user.id_user = log_pembayaran.created_by')
            ->where('id_pembayaran', $id_pembayaran)
            ->order_by('created_at', 'DESC')
            ->get()
            ->result();
    }

    public function get_recent_logs($limit = 10)
    {
        return $this->db
            ->select('log_pembayaran.*, pembayaran_santri.id_tagihan, tagihan.nama_tagihan,
                     user.nama_user as created_by_name, santri.nis, usr.nama_user as nama_santri')
            ->from($this->table)
            ->join('pembayaran_santri', 'pembayaran_santri.id_pembayaran = log_pembayaran.id_pembayaran')
            ->join('tagihan', 'tagihan.id_tagihan = pembayaran_santri.id_tagihan')
            ->join('santri', 'santri.id_santri = pembayaran_santri.id_santri')
            ->join('user as usr', 'usr.id_user = santri.id_user')
            ->join('user', 'user.id_user = log_pembayaran.created_by')
            ->order_by('log_pembayaran.created_at', 'DESC')
            ->limit($limit)
            ->get()
            ->result();
    }

    public function get_logs_by_date_range($start_date, $end_date)
    {
        return $this->db
            ->select('log_pembayaran.*, pembayaran_santri.id_tagihan, tagihan.nama_tagihan,
                     user.nama_user as created_by_name, santri.nis, usr.nama_user as nama_santri')
            ->from($this->table)
            ->join('pembayaran_santri', 'pembayaran_santri.id_pembayaran = log_pembayaran.id_pembayaran')
            ->join('tagihan', 'tagihan.id_tagihan = pembayaran_santri.id_tagihan')
            ->join('santri', 'santri.id_santri = pembayaran_santri.id_santri')
            ->join('user as usr', 'usr.id_user = santri.id_user')
            ->join('user', 'user.id_user = log_pembayaran.created_by')
            ->where('DATE(log_pembayaran.created_at) >=', $start_date)
            ->where('DATE(log_pembayaran.created_at) <=', $end_date)
            ->order_by('log_pembayaran.created_at', 'DESC')
            ->get()
            ->result();
    }
}
