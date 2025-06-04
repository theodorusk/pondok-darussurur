<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pemasukan extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
        // Check login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
        // Check admin role
        if ($this->session->userdata('id_role') != 1) {
            redirect('auth/blocked');
        }
        
        $this->load->model(['M_pemasukan']);
        $this->load->helper(['form', 'url', 'security']);
    }

    public function index()
    {
        $data = [
            'title' => 'Data Pemasukan',
            'pemasukan' => $this->M_pemasukan->get_all()
        ];

        template('pemasukan/list', $data);
    }

    public function filter()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');

        $pemasukan = $this->M_pemasukan->get_by_period($start_date, $end_date);
        $total = $this->M_pemasukan->get_total_by_period($start_date, $end_date);

        $response = [
            'status' => true,
            'data' => $pemasukan,
            'total' => number_format($total, 0, ',', '.')
        ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function detail($id_pemasukan)
    {
        $id_pemasukan = xss_clean($id_pemasukan);
        $pemasukan = $this->M_pemasukan->get_by_id($id_pemasukan);

        if (!$pemasukan) {
            $this->session->set_flashdata('error', 'Data pemasukan tidak ditemukan');
            redirect('pemasukan');
        }

        $data = [
            'title' => 'Detail Pemasukan',
            'pemasukan' => $pemasukan
        ];

        template('pemasukan/detail', $data);
    }

    public function export($type = 'all')
    {
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');

        // Get data
        $pemasukan = $this->M_pemasukan->get_by_period($start_date, $end_date);
        $total = $this->M_pemasukan->get_total_by_period($start_date, $end_date);

        // Prepare data for view
        $data = [
            'title' => 'Laporan Pemasukan',
            'pemasukan' => $pemasukan,
            'total' => $total,
            'periode' => [
                'awal' => $start_date,
                'akhir' => $end_date
            ],
            'type' => $type
        ];

        // Load the PDF library
        $this->load->library('pdf');

        // Load view
        $html = $this->load->view('pemasukan/export_pdf', $data, true);

        // Create PDF
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->filename = "laporan_pemasukan_{$start_date}_{$end_date}.pdf";
        $this->pdf->load_html($html);
        $this->pdf->render();
        $this->pdf->stream($this->pdf->filename, ['Attachment' => true]);
    }
}