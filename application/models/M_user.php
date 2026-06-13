<?php
class M_user extends CI_Model {
    public function insert_user($data) {
        return $this->db->insert('users', $data);
    }
    public function get_user_by_email($email) {
        return $this->db->get_where('users', array('email' => $email))->row_array();
    }
}