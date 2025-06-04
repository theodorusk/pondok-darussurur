
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_dashboard extends CI_Model
{
    public function count_santri()
    {
        return $this->db
            ->from('santri')
            ->count_all_results();
    }

    public function count_tagihan_aktif()
    {
        $today = date('Y-m-d');
        return $this->db
            ->where('tanggal_jatuh_tempo >=', $today)
            ->from('tagihan')
            ->count_all_results();
    }

    public function count_pembayaran_by_status($status)
    {
        return $this->db
            ->where('status', $status)
            ->from('pembayaran_santri')
            ->count_all_results();
    }

    public function get_recent_payments($limit = 5)
    {
        return $this->db
            ->select('pembayaran_santri.*, tagihan.nama_tagihan, santri.nis, user.nama_user')
            ->from('pembayaran_santri')
            ->join('tagihan', 'tagihan.id_tagihan = pembayaran_santri.id_tagihan')
            ->join('santri', 'santri.id_santri = pembayaran_santri.id_santri')
            ->join('user', 'user.id_user = santri.id_user')
            ->where('pembayaran_santri.status', 'menunggu_konfirmasi')
            ->order_by('pembayaran_santri.tanggal_bayar', 'DESC')
            ->limit($limit)
            ->get()
            ->result();
    }

    public function get_monthly_payments($year = null)
    {
        $year = $year ?? date('Y');

        return $this->db
            ->select('MONTH(tanggal_konfirmasi) as bulan, SUM(nominal_bayar) as total')
            ->from('pembayaran_santri')
            ->where('status', 'diterima')
            ->where('YEAR(tanggal_konfirmasi)', $year)
            ->group_by('MONTH(tanggal_konfirmasi)')
            ->get()
            ->result();
    }

    public function get_santri_payment_summary($id_santri)
    {
        // Get summary of payments for a particular santri
        $today = date('Y-m-d');

        $summary = new stdClass();

        // Count total tagihan
        $summary->total_tagihan = $this->db
            ->where('id_santri', $id_santri)
            ->from('pembayaran_santri')
            ->count_all_results();

        // Count belum bayar
        $summary->belum_bayar = $this->db
            ->where('id_santri', $id_santri)
            ->where('status', 'belum_bayar')
            ->from('pembayaran_santri')
            ->count_all_results();

        // Count menunggu konfirmasi
        $summary->menunggu_konfirmasi = $this->db
            ->where('id_santri', $id_santri)
            ->where('status', 'menunggu_konfirmasi')
            ->from('pembayaran_santri')
            ->count_all_results();

        // Count diterima
        $summary->diterima = $this->db
            ->where('id_santri', $id_santri)
            ->where('status', 'diterima')
            ->from('pembayaran_santri')
            ->count_all_results();

        // Count ditolak
        $summary->ditolak = $this->db
            ->where('id_santri', $id_santri)
            ->where('status', 'ditolak')
            ->from('pembayaran_santri')
            ->count_all_results();

        // Get upcoming tagihan/bills
        $summary->tagihan_akan_datang = $this->db
            ->select('pembayaran_santri.*, tagihan.nama_tagihan, tagihan.nominal, tagihan.tanggal_jatuh_tempo')
            ->from('pembayaran_santri')
            ->join('tagihan', 'tagihan.id_tagihan = pembayaran_santri.id_tagihan')
            ->where('pembayaran_santri.id_santri', $id_santri)
            ->where('pembayaran_santri.status', 'belum_bayar')
            ->where('tagihan.tanggal_jatuh_tempo >=', $today)
            ->order_by('tagihan.tanggal_jatuh_tempo', 'ASC')
            ->limit(3)
            ->get()
            ->result();

        return $summary;
    }
}
