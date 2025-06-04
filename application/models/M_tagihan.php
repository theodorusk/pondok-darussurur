
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_tagihan extends CI_Model
{
    private $table = 'tagihan';

    public function get_all_tagihan()
    {
        return $this->db
            ->select('tagihan.*, kategori_pembayaran.nama_kategori, rekening.nama_bank, rekening.no_rekening, 
                      rekening.atas_nama, user.nama_user as created_by_name')
            ->from($this->table)
            ->join('kategori_pembayaran', 'kategori_pembayaran.id_kategori = tagihan.id_kategori')
            ->join('rekening', 'rekening.id_rekening = tagihan.id_rekening')
            ->join('user', 'user.id_user = tagihan.created_by')
            ->order_by('tagihan.created_at', 'DESC')
            ->get()
            ->result();
    }

    public function get_by_id($id_tagihan)
    {
        return $this->db
            ->select('tagihan.*, kategori_pembayaran.nama_kategori, rekening.nama_bank, rekening.no_rekening, 
                      rekening.atas_nama, user.nama_user as created_by_name')
            ->from($this->table)
            ->join('kategori_pembayaran', 'kategori_pembayaran.id_kategori = tagihan.id_kategori')
            ->join('rekening', 'rekening.id_rekening = tagihan.id_rekening')
            ->join('user', 'user.id_user = tagihan.created_by')
            ->where('tagihan.id_tagihan', $id_tagihan)
            ->get()
            ->row();
    }

    public function get_active_tagihan()
    {
        $today = date('Y-m-d');
        return $this->db
            ->select('tagihan.*, kategori_pembayaran.nama_kategori')
            ->from($this->table)
            ->join('kategori_pembayaran', 'kategori_pembayaran.id_kategori = tagihan.id_kategori')
            ->where('tagihan.tanggal_jatuh_tempo >=', $today)
            ->get()
            ->result();
    }

    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id_tagihan, $data)
    {
        $this->db->where('id_tagihan', $id_tagihan);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();
    }

    public function delete($id_tagihan)
    {
        $this->db->where('id_tagihan', $id_tagihan);
        $this->db->delete($this->table);
        return $this->db->affected_rows();
    }

    public function batch_insert_tagihan_santri($batch_data)
    {
        return $this->db->insert_batch('pembayaran_santri', $batch_data);
    }

    public function get_pembayaran_by_tagihan($id_tagihan)
    {
        return $this->db
            ->select('pembayaran_santri.*, santri.nis, user.nama_user, user.foto_user')
            ->from('pembayaran_santri')
            ->join('santri', 'santri.id_santri = pembayaran_santri.id_santri')
            ->join('user', 'user.id_user = santri.id_user')
            ->where('pembayaran_santri.id_tagihan', $id_tagihan)
            ->order_by('pembayaran_santri.status', 'ASC')
            ->order_by('user.nama_user', 'ASC')
            ->get()
            ->result();
    }

    public function cek_sudah_dibayar($id_tagihan)
    {
        // Check if any payment has been made for this tagihan
        return $this->db
            ->where('id_tagihan', $id_tagihan)
            ->where_in('status', ['diterima', 'menunggu_konfirmasi'])
            ->get('pembayaran_santri')
            ->num_rows() > 0;
    }

    public function hapus_tagihan_santri($id_tagihan)
    {
        $this->db->where('id_tagihan', $id_tagihan);
        $this->db->delete('pembayaran_santri');
        return $this->db->affected_rows();
    }
}
