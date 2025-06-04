
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_kategori extends CI_Model
{
    private $table = 'kategori_pembayaran';

    public function get_all()
    {
        return $this->db
            ->order_by('nama_kategori', 'ASC')
            ->get($this->table)
            ->result();
    }

    public function get_by_id($id_kategori)
    {
        return $this->db
            ->where('id_kategori', $id_kategori)
            ->get($this->table)
            ->row();
    }

    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id_kategori, $data)
    {
        $this->db->where('id_kategori', $id_kategori);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();
    }

    public function delete($id_kategori)
    {
        $this->db->where('id_kategori', $id_kategori);
        $this->db->delete($this->table);
        return $this->db->affected_rows();
    }

    public function is_used($id_kategori)
    {
        // Check if kategori is used in any tagihan
        return $this->db
            ->where('id_kategori', $id_kategori)
            ->get('tagihan')
            ->num_rows() > 0;
    }
}
