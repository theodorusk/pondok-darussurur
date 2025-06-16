<?php
// filepath: c:\laragon\www\pondokdarussurur\application\libraries\Pdf.php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '../vendor/autoload.php';

class Pdf {
    public function __construct() {
        // Constructor
    }
    
    public function generate($html, $filename = 'laporan', $paper = 'A4', $orientation = 'portrait', $stream = TRUE)
    {
        $config = array(
            'mode' => 'utf-8',
            'format' => $paper,
            'orientation' => $orientation,
            'margin_left' => 25,
            'margin_right' => 25,
            'margin_top' => 25,
            'margin_bottom' => 25
        );
        
        $mpdf = new \Mpdf\Mpdf($config);
        $mpdf->SetTitle($filename);
        $mpdf->SetAuthor('Pondok Darussurur');
        $mpdf->SetCreator('Sistem Keuangan Pondok Darussurur');
        
        $mpdf->WriteHTML($html);
        
        if ($stream) {
            // I: inline, menampilkan di browser
            // D: download, force download
            $mpdf->Output($filename . ".pdf", "I");
        } else {
            return $mpdf->Output('', 'S');
        }
    }
}