<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_auth extends CI_Model
{

    public function get_user_by_email($email)
    {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('email', $email);
        $query = $this->db->get();
        return $query->row_array(); // Pastikan row_array() mengembalikan array dengan field foto
    }
}
