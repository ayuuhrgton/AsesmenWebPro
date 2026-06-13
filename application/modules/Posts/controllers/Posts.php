<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posts extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Proteksi login
        if(!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
        $this->load->model('Post_model');
    }

    // Tampilan Dashboard Utama
    public function index() {
        $user_id = $this->session->userdata('user_id');
        
        $data['laporan_user'] = $this->Post_model->get_by_user($user_id);
        $data['total_laporan'] = count($data['laporan_user']);
        
        // Memanggil view index bawaan HMVC Posts
        $this->load->view('index', $data);
    }

    // Simpan Laporan Baru
    public function simpan() {
        $jumlah = $this->input->post('jumlah_kendaraan');
        
        // Logika IF/ELSE Status Pelanggaran (Soal No. 5)
        if ($jumlah >= 1 && $jumlah <= 5) {
            $status = "Ringan";
        } elseif ($jumlah >= 6 && $jumlah <= 15) {
            $status = "Sedang";
        } else {
            $status = "Berat";
        }

        // Konfigurasi Upload Gambar (Soal No. 4)
        $config['upload_path']   = './uploads/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['encrypt_name']  = TRUE;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('foto_bukti')) {
            $upload_data = $this->upload->data();
            $nama_file = $upload_data['file_name'];
        } else {
            $nama_file = '';
        }

        $data_simpan = array(
            'user_id'            => $this->session->userdata('user_id'),
            'lokasi'             => $this->input->post('lokasi'),
            'waktu_laporan'      => date('Y-m-d H:i:s'),
            'jumlah_kendaraan'   => $jumlah,
            'status_pelanggaran' => $status,
            'deskripsi'          => $this->input->post('deskripsi'),
            'foto_bukti'         => $nama_file
        );

        $this->Post_model->insert($data_simpan);
        redirect('posts');
    }

    // Hapus Laporan & File Fisik
    public function hapus($id) {
        $laporan = $this->db->get_where('laporan', array('id' => $id))->row_array();
        if ($laporan) {
            if (!empty($laporan['foto_bukti']) && file_exists('./uploads/' . $laporan['foto_bukti'])) {
                unlink('./uploads/' . $laporan['foto_bukti']);
            }
            $this->Post_model->delete($id);
        }
        redirect('posts');
    }

    // RESTful API (Soal Ketentuan Umum No. 6)
    public function api_laporan() {
        $data = $this->Post_model->get_all();
        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode(array(
                 'status' => 200,
                 'message' => 'Success',
                 'data' => $data
             )));
    }


// 1. Menampilkan Form Edit Data
public function edit($id) {
    // Pastikan menggunakan GET untuk mengambil parameter ID sesuai teknis soal
    $data['laporan'] = $this->Post_model->get_by_id($id);
    
    // Proteksi jika data tidak ditemukan
    if (empty($data['laporan'])) {
        redirect('posts');
    }

    $this->load->view('edit', $data);
}

// 2. Memproses Update Data (Gunakan POST sesuai Ketentuan Teknis)
public function proses_update() {
    $id = $this->input->post('id');
    $jumlah = $this->input->post('jumlah_kendaraan');
    
    // Logika IF/ELSE penentuan status tetap wajib dipasang ulang
    if ($jumlah >= 1 && $jumlah <= 5) {
        $status = "Ringan";
    } elseif ($jumlah >= 6 && $jumlah <= 15) {
        $status = "Sedang";
    } else {
        $status = "Berat";
    }

    // Ambil data lama untuk mengecek foto lama
    $laporan_lama = $this->Post_model->get_by_id($id);
    $nama_file = $laporan_lama['foto_bukti']; // Default pakai foto lama

    // Logika Upload File Baru jika user mengganti gambar (Soal No. 4 Poin 5)
    if (!empty($_FILES['foto_bukti']['name'])) {
        $config['upload_path']   = './uploads/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['encrypt_name']  = TRUE;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('foto_bukti')) {
            // Hapus file fisik lama di server agar tidak memicu sampah berkas
            if (!empty($laporan_lama['foto_bukti']) && file_exists('./uploads/' . $laporan_lama['foto_bukti'])) {
                unlink('./uploads/' . $laporan_lama['foto_bukti']);
            }
            
            $upload_data = $this->upload->data();
            $nama_file = $upload_data['file_name']; // Ganti ke nama file baru
        }
    }

    $data_update = array(
        'lokasi'             => $this->input->post('lokasi'),
        'jumlah_kendaraan'   => $jumlah,
        'status_pelanggaran' => $status,
        'deskripsi'          => $this->input->post('deskripsi'),
        'foto_bukti'         => $nama_file
    );

    $this->Post_model->update($id, $data_update);
    redirect('posts');
}}