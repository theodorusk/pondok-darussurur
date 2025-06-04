<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_santri extends CI_Model
{
    private $table = 'santri';

    public function get_by_user($id_user)
    {
        return $this->db->where('id_user', $id_user)
            ->get($this->table)
            ->row();
    }

    public function get_by_id($id_santri)
    {
        $this->db->select('santri.*, user.nama_user');
        $this->db->from('santri');
        $this->db->join('user', 'user.id_user = santri.id_user');
        $this->db->where('santri.id_santri', $id_santri);
        return $this->db->get()->row();
    }

    public function get_santri_detail($id_santri) {
        return $this->db->select('santri.*, user.nama_user, user.email, user.jenis_kelamin')
            ->from('santri')
            ->join('user', 'user.id_user = santri.id_user')
            ->where('santri.id_santri', $id_santri)
            ->get()
            ->row();
    }

    public function get_all_with_user()
    {
        return $this->db->select('santri.*, user.nama_user, user.foto_user')
            ->from('santri')
            ->join('user', 'user.id_user = santri.id_user')
            ->get()
            ->result();
    }

    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id_santri, $data)
    {
        $this->db->where('id_santri', $id_santri)
            ->update($this->table, $data);
        return $this->db->affected_rows();
    }

    public function update_by_user($id_user, $data)
    {
        $this->db->where('id_user', $id_user)
            ->update($this->table, $data);
        return $this->db->affected_rows();
    }

    public function delete_by_user($id_user)
    {
        $this->db->where('id_user', $id_user);
        return $this->db->delete($this->table);
    }

    public function nis_exists($nis, $except_id = null)
    {
        $this->db->where('nis', $nis);

        if ($except_id) {
            $this->db->where('id_santri !=', $except_id);
        }

        return $this->db->get($this->table)->num_rows() > 0;
    }
}
