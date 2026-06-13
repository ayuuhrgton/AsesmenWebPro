<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_laporan extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // 1. Mengambil seluruh data laporan (Untuk RESTful API)
    public function get_semua() {
        return $this->db->get('laporan')->result_array();
    }
    
    // 2. Mengambil data laporan khusus milik user yang sedang login (Ketentuan Soal No 3 Poin 6)
    public function get_by_user($user_id) {
        $this->db->where('user_id', $user_id);
        return $this->db->get('laporan')->result_array();
    }

    // 3. Menyimpan data laporan baru ke database (INSERT)
    public function simpan($data) {
        return $this->db->insert('laporan', $data);
    }

    // 4. Menghapus data laporan berdasarkan ID (DELETE)
    public function hapus($id) {
        $this->db->where('id', $id);
        return $this->db->delete('laporan');
    }
}