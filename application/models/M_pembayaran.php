<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_pembayaran extends CI_Model
{
    public function get_tagihan_by_santri($id_santri)
    {
        return $this->db
            ->select('pembayaran_santri.*, tagihan.nama_tagihan, tagihan.nominal, tagihan.tanggal_jatuh_tempo,
                     kategori_pembayaran.nama_kategori, rekening.nama_bank, rekening.no_rekening, rekening.atas_nama,
                     admin.nama_user as nama_admin')  // Tambahkan ini untuk mendapatkan nama admin
            ->from('pembayaran_santri')
            ->join('tagihan', 'tagihan.id_tagihan = pembayaran_santri.id_tagihan')
            ->join('kategori_pembayaran', 'kategori_pembayaran.id_kategori = tagihan.id_kategori')
            ->join('rekening', 'rekening.id_rekening = tagihan.id_rekening')
            ->join('user as admin', 'admin.id_user = pembayaran_santri.konfirmasi_by', 'left')  // Tambahkan join ini
            ->where('pembayaran_santri.id_santri', $id_santri)
            ->order_by('tagihan.tanggal_jatuh_tempo', 'ASC')
            ->order_by('pembayaran_santri.status', 'ASC')
            ->get()
            ->result();
    }

    public function get_pembayaran_by_id($id_pembayaran, $id_santri)
    {
        return $this->db
            ->select('pembayaran_santri.*, tagihan.nama_tagihan, tagihan.nominal, tagihan.tanggal_jatuh_tempo,
                     tagihan.deskripsi as deskripsi_tagihan, kategori_pembayaran.nama_kategori,
                     rekening.nama_bank, rekening.no_rekening, rekening.atas_nama')
            ->from('pembayaran_santri')
            ->join('tagihan', 'tagihan.id_tagihan = pembayaran_santri.id_tagihan')
            ->join('kategori_pembayaran', 'kategori_pembayaran.id_kategori = tagihan.id_kategori')
            ->join('rekening', 'rekening.id_rekening = tagihan.id_rekening')
            ->where('pembayaran_santri.id_pembayaran', $id_pembayaran)
            ->where('pembayaran_santri.id_santri', $id_santri)
            ->get()
            ->row();
    }

    public function update($id_pembayaran, $data)
    {
        $this->db->where('id_pembayaran', $id_pembayaran);
        $this->db->update('pembayaran_santri', $data);
        return $this->db->affected_rows();
    }

    public function get_riwayat_pembayaran($id_santri)
    {
        return $this->db
            ->select('pembayaran_santri.*, tagihan.nama_tagihan, tagihan.nominal, 
                      kategori_pembayaran.nama_kategori, user.nama_user as confirmed_by')
            ->from('pembayaran_santri')
            ->join('tagihan', 'tagihan.id_tagihan = pembayaran_santri.id_tagihan')
            ->join('kategori_pembayaran', 'kategori_pembayaran.id_kategori = tagihan.id_kategori')
            ->join('user', 'user.id_user = pembayaran_santri.konfirmasi_by', 'left') // Perbaikan di sini
            ->where('pembayaran_santri.id_santri', $id_santri)
            ->where('pembayaran_santri.status !=', 'belum_bayar')
            ->order_by('pembayaran_santri.tanggal_bayar', 'DESC')
            ->get()
            ->result();
    }

    public function get_pembayaran_by_status($status)
    {
        return $this->db
            ->select('pembayaran_santri.*, tagihan.nama_tagihan, tagihan.nominal, 
                      kategori_pembayaran.nama_kategori, santri.nis, user.nama_user')
            ->from('pembayaran_santri')
            ->join('tagihan', 'tagihan.id_tagihan = pembayaran_santri.id_tagihan')
            ->join('kategori_pembayaran', 'kategori_pembayaran.id_kategori = tagihan.id_kategori')
            ->join('santri', 'santri.id_santri = pembayaran_santri.id_santri')
            ->join('user', 'user.id_user = santri.id_user')
            ->where('pembayaran_santri.status', $status)
            ->order_by('pembayaran_santri.tanggal_bayar', 'DESC')
            ->get()
            ->result();
    }

    public function get_detail_pembayaran($id_pembayaran)
    {
        return $this->db
            ->select('pembayaran_santri.*, tagihan.nama_tagihan, tagihan.nominal, tagihan.tanggal_jatuh_tempo,
                      kategori_pembayaran.nama_kategori, santri.nis, user.nama_user as nama_santri,
                      rekening.nama_bank, rekening.no_rekening, rekening.atas_nama,
                      admin.nama_user as nama_admin')
            ->from('pembayaran_santri')
            ->join('tagihan', 'tagihan.id_tagihan = pembayaran_santri.id_tagihan')
            ->join('kategori_pembayaran', 'kategori_pembayaran.id_kategori = tagihan.id_kategori')
            ->join('rekening', 'rekening.id_rekening = tagihan.id_rekening')
            ->join('santri', 'santri.id_santri = pembayaran_santri.id_santri')
            ->join('user', 'user.id_user = santri.id_user')
            ->join('user as admin', 'admin.id_user = pembayaran_santri.konfirmasi_by', 'left') // Perbaikan di sini
            ->where('pembayaran_santri.id_pembayaran', $id_pembayaran)
            ->get()
            ->row();
    }

    public function get_kategori()
    {
        return $this->db->get('kategori_pembayaran')->result();
    }

    public function get_laporan($bulan, $tahun, $id_kategori = null)
    {
        $this->db
            ->select('pembayaran_santri.*, tagihan.nama_tagihan, tagihan.nominal, 
                      kategori_pembayaran.nama_kategori, kategori_pembayaran.id_kategori,
                      santri.nis, user.nama_user as nama_santri, admin.nama_user as nama_admin')
            ->from('pembayaran_santri')
            ->join('tagihan', 'tagihan.id_tagihan = pembayaran_santri.id_tagihan')
            ->join('kategori_pembayaran', 'kategori_pembayaran.id_kategori = tagihan.id_kategori')
            ->join('santri', 'santri.id_santri = pembayaran_santri.id_santri')
            ->join('user', 'user.id_user = santri.id_user')
            ->join('user as admin', 'admin.id_user = pembayaran_santri.konfirmasi_by', 'left') // Perbaikan di sini
            ->where('pembayaran_santri.status', 'diterima')
            ->where('MONTH(pembayaran_santri.tanggal_konfirmasi)', $bulan)
            ->where('YEAR(pembayaran_santri.tanggal_konfirmasi)', $tahun);

        if ($id_kategori) {
            $this->db->where('kategori_pembayaran.id_kategori', $id_kategori);
        }

        return $this->db
            ->order_by('pembayaran_santri.tanggal_konfirmasi', 'DESC')
            ->get()
            ->result();
    }

    public function get_statistic_by_category($tahun = null)
    {
        $tahun = $tahun ?? date('Y');

        return $this->db
            ->select('kategori_pembayaran.nama_kategori, MONTH(pembayaran_santri.tanggal_konfirmasi) as bulan,
                     SUM(pembayaran_santri.nominal_bayar) as total')
            ->from('pembayaran_santri')
            ->join('tagihan', 'tagihan.id_tagihan = pembayaran_santri.id_tagihan')
            ->join('kategori_pembayaran', 'kategori_pembayaran.id_kategori = tagihan.id_kategori')
            ->where('pembayaran_santri.status', 'diterima')
            ->where('YEAR(pembayaran_santri.tanggal_konfirmasi)', $tahun)
            ->group_by('kategori_pembayaran.id_kategori, MONTH(pembayaran_santri.tanggal_konfirmasi)')
            ->get()
            ->result();
    }

    // Di model M_pembayaran
    public function get_all_riwayat_by_santri($id_santri)
    {
        // Perbaikan dari tabel 'pembayaran' ke 'pembayaran_santri'
        // dan 'kategori_tagihan' ke 'kategori_pembayaran'
        $this->db->select('ps.*, t.nama_tagihan, k.nama_kategori, u.nama_user as konfirmasi_by_name');
        $this->db->from('pembayaran_santri ps');  // Nama tabel yang benar
        $this->db->join('tagihan t', 'ps.id_tagihan = t.id_tagihan', 'left');
        $this->db->join('kategori_pembayaran k', 't.id_kategori = k.id_kategori', 'left'); // Nama tabel yang benar
        $this->db->join('user u', 'ps.konfirmasi_by = u.id_user', 'left'); // Sesuaikan dengan nama tabel user yang benar
        $this->db->where('ps.id_santri', $id_santri);
        $this->db->order_by('ps.tanggal_bayar', 'desc');
        return $this->db->get()->result();
    }

    public function check_pembayaran_by_santri($id_santri)
    {
        $this->db->where('id_santri', $id_santri);
        $query = $this->db->get('pembayaran_santri');
        return $query->num_rows() > 0;
    }

    public function delete_by_santri($id_santri)
    {
        try {
            // Hapus semua pembayaran yang terkait dengan santri
            $this->db->where('id_santri', $id_santri);
            return $this->db->delete('pembayaran_santri');
        } catch (Exception $e) {
            log_message('error', 'Error in M_pembayaran::delete_by_santri: ' . $e->getMessage());
            return false;
        }
    }
}
