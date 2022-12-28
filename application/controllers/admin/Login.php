<?php

class Login extends CI_Controller{
    function __construct(){
		parent::__construct();		
		$this->load->model('user_model');
 
	}
 
	function index(){
		$this->load->view('admin/login');
	}
 
	function aksi_login(){
        $username = $this->input->post('user');
        $password = $this->input->post('pass');
        $where = array(
            'username' => $username,
            'password' => $password
            );
        $cek = $this->user_model->cek_login("users",$where)->num_rows();
        if($cek > 0){
     
            $data_session = array(
            'username' => $username,
                'status' => "login"
                );
     
            $this->session->set_userdata($data_session);
     
            redirect(base_url("index.php/admin/overview"));
        }else{
            echo "Username dan password salah !";
        }
    }
 
	function logout(){
		$this->session->sess_destroy();
		redirect(base_url('admin/login'));
	}

}