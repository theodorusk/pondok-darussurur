<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_dashboard extends CI_Model
{
    public function count_santri()
    {
        return $this->db->where('id_role', 2)->count_all_results('user');
    }

    public function count_tagihan_aktif()
    {
        $today = date('Y-m-d');
        return $this->db->where('tanggal_jatuh_tempo >=', $today)
                ->count_all_results('tagihan');
    }

    public function count_pembayaran_by_status($status)
    {
        return $this->db->where('status', $status)
                ->count_all_results('pembayaran_santri');
    }

    public function get_recent_payments($limit = 5)
    {
        return $this->db->select('ps.*, t.nama_tagihan, u.nama_user')
                ->from('pembayaran_santri ps')
                ->join('tagihan t', 't.id_tagihan = ps.id_tagihan', 'left')
                ->join('santri s', 's.id_santri = ps.id_santri', 'left')
                ->join('user u', 'u.id_user = s.id_user', 'left')
                ->where('ps.status !=', 'belum_bayar')
                ->order_by('ps.created_at', 'DESC')
                ->limit($limit)
                ->get()
                ->result();
    }

    public function get_monthly_payments($year = null)
    {
        if (!$year) {
            $year = date('Y');
        }
        
        $this->db->select("MONTH(tanggal_bayar) as bulan, SUM(nominal_bayar) as total")
                ->from('pembayaran_santri')
                ->where('status', 'diterima')
                ->where("YEAR(tanggal_bayar)", $year)
                ->group_by('bulan')
                ->order_by('bulan', 'ASC');
                
        $query = $this->db->get();
        
        // Initialize array with all months
        $monthly_data = array_fill(1, 12, 0);
        
        // Fill data from query results
        foreach ($query->result() as $row) {
            $monthly_data[(int)$row->bulan] = (float)$row->total;
        }
        
        return $monthly_data;
    }

    public function get_santri_payment_summary($id_santri)
    {
        // Get all payment data for this santri
        $this->db->select('ps.*, t.nama_tagihan, t.nominal, t.tanggal_jatuh_tempo');
        $this->db->from('pembayaran_santri ps');
        $this->db->join('tagihan t', 't.id_tagihan = ps.id_tagihan', 'left');
        $this->db->where('ps.id_santri', $id_santri);
        $payments = $this->db->get()->result();
        
        // Count by status
        $diterima = 0;
        $menunggu_konfirmasi = 0;
        $belum_bayar = 0;
        $ditolak = 0;
        
        $tagihan_akan_datang = [];
        
        foreach ($payments as $payment) {
            switch ($payment->status) {
                case 'diterima':
                    $diterima++;
                    break;
                case 'menunggu_konfirmasi':
                    $menunggu_konfirmasi++;
                    break;
                case 'ditolak':
                    $ditolak++;
                    break;
                case 'belum_bayar':
                    $belum_bayar++;
                    // Add to upcoming bills if not yet paid
                    if (!empty($payment->tanggal_jatuh_tempo)) {
                        $payment->tanggal_jatuh_tempo = date('Y-m-d', strtotime($payment->tanggal_jatuh_tempo));
                        $tagihan_akan_datang[] = $payment;
                    }
                    break;
            }
        }
        
        // Sort upcoming bills by due date
        usort($tagihan_akan_datang, function($a, $b) {
            return strtotime($a->tanggal_jatuh_tempo) - strtotime($b->tanggal_jatuh_tempo);
        });
        
        // Limit to 5 items
        $tagihan_akan_datang = array_slice($tagihan_akan_datang, 0, 5);
        
        // Create object with counts
        $result = new stdClass();
        $result->total_tagihan = count($payments);
        $result->diterima = $diterima;
        $result->menunggu_konfirmasi = $menunggu_konfirmasi;
        $result->belum_bayar = $belum_bayar;
        $result->ditolak = $ditolak;
        $result->tagihan_akan_datang = $tagihan_akan_datang;
        
        return $result;
    }
}
