<?php
class Auth extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('M_user');
    }

    public function index() {
        $this->load->view('v_login');
    }

    public function register() {
        $this->load->view('v_register');
    }

    public function proses_register() {
        // Validasi input sesuai spesifikasi soal
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

        if ($this->form_validation->run() == FALSE) {
            // Kalau gagal, balikin ke register dengan pesan eror
            $this->load->view('v_register');
        } else {
            $data = array(
                'nama' => $this->input->post('nama'),
                'email' => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT)
            );
            $this->M_user->insert_user($data);
            redirect('auth');
        }
    }

    public function proses_login() {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        
        $user = $this->M_user->get_user_by_email($email);

        if ($user && password_verify($password, $user['password'])) {
            // Set session jika password cocok
            $session_data = array(
                'user_id' => $user['id'],
                'nama' => $user['nama'],
                'logged_in' => TRUE
            );
            $this->session->set_userdata($session_data);
            redirect('dashboard');
        } else {
            // Gagal login
            $this->session->set_flashdata('error', 'Email atau Password salah!');
            redirect('auth');
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth');
    }
}