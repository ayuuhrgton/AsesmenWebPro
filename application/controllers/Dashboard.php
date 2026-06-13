<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Proteksi halaman: wajib login sesuai ketentuan soal No. 2 Poin 3
        if(!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
        // Panggil model M_laporan yang baru dibuat
        $this->load->model('M_laporan');
    }

    // TAMPILKAN HALAMAN UTAMA DASHBOARD (Poin 3 & Poin 6)
    public function index() {
        $user_id = $this->session->userdata('user_id');
        
        // Menampilkan data laporan BERDASARKAN user yang sedang login (Ketentuan Soal No. 3 Poin 6)
        $data['laporan_user'] = $this->M_laporan->get_by_user($user_id);
        
        // Menghitung jumlah total laporan milik user (Ketentuan Soal No. 6 Poin 1)
        $data['total_laporan'] = count($data['laporan_user']);
        
        // Lempar data ke view dashboard Bootstrap
        $this->load->view('v_dashboard', $data);
    }

    // PROSES SIMPAN DATA + UPLOAD FILE + LOGIKA IF/ELSE STATUS (Poin 4 & Poin 5)
    public function simpan() {
        $jumlah = $this->input->post('jumlah_kendaraan');
        
        // LOGIKA PHP PENENTUAN STATUS PELANGGARAN (Ketentuan Soal No. 5)
        if ($jumlah >= 1 && $jumlah <= 5) {
            $status = "Ringan";
        } elseif ($jumlah >= 6 && $jumlah <= 15) {
            $status = "Sedang";
        } else {
            $status = "Berat";
        }

        // KONFIGURASI UPLOAD FILE (Ketentuan Soal No. 4)
        $config['upload_path']          = './uploads/';
        $config['allowed_types']        = 'jpg|jpeg|png'; // File yang diizinkan (Poin 2)
        $config['encrypt_name']         = TRUE;           // Enkripsi nama file biar aman

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('foto_bukti')) {
            $upload_data = $this->upload->data();
            $nama_file = $upload_data['file_name']; // Nama file didapat
        } else {
            $nama_file = ''; // Kosong jika gagal upload
        }

        // Siapkan array data untuk disimpan ke MySQL
        $data_simpan = array(
            'user_id'            => $this->session->userdata('user_id'),
            'lokasi'             => $this->input->post('lokasi'),
            'waktu_laporan'      => date('Y-m-d H:i:s'),
            'jumlah_kendaraan'   => $jumlah,
            'status_pelanggaran' => $status, // Hasil logika IF/ELSE
            'deskripsi'          => $this->input->post('deskripsi'),
            'foto_bukti'         => $nama_file  // Disimpan ke database (Poin 3)
        );

        $this->M_laporan->simpan($data_simpan);
        redirect('dashboard');
    }

    // PROSES HAPUS DATA + BERKAS FISIK DI SERVER (Ketentuan Soal No. 4 Poin 6)
    public function hapus($id) {
        // Ambil data laporan sebelum dihapus untuk tahu nama file fotonya
        $laporan = $this->db->get_where('laporan', array('id' => $id))->row_array();
        
        if ($laporan) {
            $nama_file = $laporan['foto_bukti'];
            
            // Hapus file fisik dari folder uploads jika ada
            if (!empty($nama_file) && file_exists('./uploads/' . $nama_file)) {
                unlink('./uploads/' . $nama_file);
            }
            
            // Hapus data dari database
            $this->M_laporan->hapus($id);
        }
        
        redirect('dashboard');
    }

    // ====== RESTful API MINIMAL (Ketentuan Umum No. 6) ======
    // Mengembalikan data JSON jika diakses ke url: localhost/smartparking_report/dashboard/api_laporan
    public function api_laporan() {
        $data = $this->M_laporan->get_semua();
        
        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode(array(
                 'status' => 200,
                 'message' => 'Data aduan berhasil ditarik secara RESTful',
                 'data' => $data
             )));
    }
}