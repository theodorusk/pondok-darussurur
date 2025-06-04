<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_pengguna extends CI_Model
{
    private $table = 'user';

    public function get_all_with_role()
    {
        return $this->db->select('user.*, role.nama_role')
            ->from($this->table)
            ->join('role', 'role.id_role = user.id_role')
            ->order_by('user.id_user', 'DESC')
            ->get()
            ->result();
    }

    public function get_by_id($id_user)
    {
        return $this->db->select('user.*, role.nama_role')
            ->from($this->table)
            ->join('role', 'role.id_role = user.id_role')
            ->where('user.id_user', $id_user)
            ->get()
            ->row();
    }

    public function get_all_santri()
    {
        return $this->db->select('user.*, santri.nis')
            ->from('user')
            ->join('santri', 'santri.id_user = user.id_user')
            ->where('user.id_role', 2)
            ->get()
            ->result();
    }

    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id_user, $data)
    {
        return $this->db->where('id_user', $id_user)
            ->update($this->table, $data);
    }

    public function delete($id_user)
    {
        // Hapus validasi dari model karena sudah ditangani di controller
        $this->db->where('id_user', $id_user);
        return $this->db->delete($this->table);
    }

    public function get_foto_by_id($id)
    {
        $this->db->select('foto_user');
        $this->db->where('id_user', $id);
        $query = $this->db->get($this->table);
        $result = $query->row();
        return $result ? $result->foto_user : null;
    }

    public function email_exists($email, $except_id = null)
    {
        $this->db->where('email', $email);

        if ($except_id) {
            $this->db->where('id_user !=', $except_id);
        }

        return $this->db->get($this->table)->num_rows() > 0;
    }

    public function get_roles()
    {
        return $this->db->get('role')->result();
    }

    // Add this method to your existing M_pengguna model:
    public function get_detail($id_user)
    {
        $this->db->select('*');
        $this->db->where('id_user', $id_user);
        $query = $this->db->get($this->table);
        return $query->row_array(); // Return as array to include password field
    }
}
