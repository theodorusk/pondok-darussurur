<?php
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_pengeluaran extends CI_Model {
    private $table = 'pengeluaran';

    public function get_all() {
        return $this->db->select('pengeluaran.*, user.nama_user as nama_admin')
            ->from($this->table)
            ->join('user', 'user.id_user = pengeluaran.created_by')
            ->order_by('pengeluaran.tanggal_pengeluaran', 'DESC')
            ->get()
            ->result();
    }

    public function get_by_period($start_date, $end_date) {
        return $this->db->where('DATE(tanggal_pengeluaran) >=', $start_date)
            ->where('DATE(tanggal_pengeluaran) <=', $end_date)
            ->order_by('tanggal_pengeluaran', 'DESC')
            ->get($this->table)
            ->result();
    }

    public function get_total_by_period($start_date, $end_date) {
        return $this->db->select_sum('nominal')
            ->where('DATE(tanggal_pengeluaran) >=', $start_date)
            ->where('DATE(tanggal_pengeluaran) <=', $end_date)
            ->get($this->table)
            ->row()
            ->nominal ?? 0;
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data) {
        return $this->db->where('id_pengeluaran', $id)->update($this->table, $data);
    }

    public function delete($id) {
        return $this->db->where('id_pengeluaran', $id)->delete($this->table);
    }
}