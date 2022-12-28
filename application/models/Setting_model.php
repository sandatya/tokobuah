<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('auth_model');
		if (!$this->auth_model->current_user()) {
			redirect('auth/login');
		}
	}

	public function index()
	{
		$data['current_user'] = $this->auth_model->current_user();
		$this->load->view('admin/setting', $data);
	}

	public function upload_avatar()
	{
		echo "comming soon!";
	}

	public function remove_avatar()
	{
		echo "comming soon!";
	}

	public function edit_profile()
	{
		// load edit profile form
	}

	public function edit_password()
	{
		// load edit password form
	}
}