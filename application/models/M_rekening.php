
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_rekening extends CI_Model
{
    private $table = 'rekening';

    public function get_all()
    {
        return $this->db
            ->order_by('is_active', 'DESC')
            ->order_by('nama_bank', 'ASC')
            ->get($this->table)
            ->result();
    }

    public function get_active()
    {
        return $this->db
            ->where('is_active', 1)
            ->order_by('nama_bank', 'ASC')
            ->get($this->table)
            ->result();
    }

    public function get_by_id($id_rekening)
    {
        return $this->db
            ->where('id_rekening', $id_rekening)
            ->get($this->table)
            ->row();
    }

    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id_rekening, $data)
    {
        $this->db->where('id_rekening', $id_rekening);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();
    }

    public function delete($id_rekening)
    {
        $this->db->where('id_rekening', $id_rekening);
        $this->db->delete($this->table);
        return $this->db->affected_rows();
    }

    public function is_used($id_rekening)
    {
        // Check if rekening is used in any tagihan
        return $this->db
            ->where('id_rekening', $id_rekening)
            ->get('tagihan')
            ->num_rows() > 0;
    }
}
