<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_pengeluaran extends CI_Model {
    private $table = 'pengeluaran';

    public function get_all() {
        try {
            return $this->db->select('pengeluaran.*, user.nama_user as nama_admin')
                ->from($this->table)
                ->join('user', 'user.id_user = pengeluaran.created_by')
                ->order_by('pengeluaran.tanggal_pengeluaran', 'DESC')
                ->get()
                ->result();
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            return [];
        }
    }

    public function get_by_id($id) {
        return $this->db->select('pengeluaran.*, user.nama_user as nama_admin')
            ->from($this->table)
            ->join('user', 'user.id_user = pengeluaran.created_by')
            ->where('id_pengeluaran', $id)
            ->get()
            ->row();
    }

    public function get_by_period($start_date, $end_date) {
        return $this->db->select('pengeluaran.*, user.nama_user as nama_admin')
            ->from($this->table)
            ->join('user', 'user.id_user = pengeluaran.created_by')
            ->where('DATE(tanggal_pengeluaran) >=', $start_date)
            ->where('DATE(tanggal_pengeluaran) <=', $end_date)
            ->order_by('tanggal_pengeluaran', 'DESC')
            ->get()
            ->result();
    }

    public function get_total() 
    {
        try {
            $result = $this->db->select_sum('nominal')
                              ->get($this->table)
                              ->row();
            return $result->nominal ?? 0;
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            return 0;
        }
    }

    public function get_total_by_period($start_date = null, $end_date = null) {
        $this->db->select_sum('nominal');
        if ($start_date && $end_date) {
            $this->db->where('DATE(tanggal_pengeluaran) >=', $start_date)
                    ->where('DATE(tanggal_pengeluaran) <=', $end_date);
        }
        $result = $this->db->get($this->table)->row();
        return $result->nominal ?? 0;
    }

    public function insert($data) {
        try {
            $this->db->insert($this->table, $data);
            return $this->db->insert_id();
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            return false;
        }
    }

    public function update($id, $data) {
        return $this->db->where('id_pengeluaran', $id)
            ->update($this->table, $data);
    }

    public function delete($id) {
        try {
            return $this->db->where('id_pengeluaran', $id)
                ->delete($this->table);
        } catch (Exception $e) {
            log_message('error', 'Error in M_pengeluaran::delete: ' . $e->getMessage());
            return false;
        }
    }
}