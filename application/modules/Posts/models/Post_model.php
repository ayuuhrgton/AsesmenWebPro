<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post_model extends CI_Model {

    // 1. Mengambil semua data
    public function get_all() {
        return $this->db->get('laporan')->result_array();
    }

    // 2. Mengambil data milik user tertentu
    public function get_by_user($user_id) {
        return $this->db->get_where('laporan', array('user_id' => $user_id))->result_array();
    }

    // 3. Mengambil data spesifik berdasarkan ID
    public function get_by_id($id) {
        return $this->db->get_where('laporan', array('id' => $id))->row_array();
    }

    // 4. Memasukkan data baru
    public function insert($data) {
        return $this->db->insert('laporan', $data);
    }

    // 5. Mengupdate data lama
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('laporan', $data);
    }

    // 6. Menghapus data
    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('laporan');
    }

} // <--- Pastikan ini kurung kurawal terakhir sebagai penutup Class Model!