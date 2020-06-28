<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		//load library form validasi
		$this->load->library('form_validation');
		//load model admin
		$this->load->model('Admin_model');
	}

	public function index()
	{

		if ($this->Admin_model->logged_id()) {
			//jika memang session sudah terdaftar, maka redirect ke halaman dahsboard
			redirect("home");
		} else {

			//jika session belum terdaftar

			//set form validation
			$this->form_validation->set_rules('user_name', 'Username', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');

			//set message form validation
			$this->form_validation->set_message('required', '<div class="alert alert-danger" style="margin-top: 3px">
	                <div class="header"><b><i class="fa fa-exclamation-circle"></i> {field}</b> harus diisi</div></div>');

			//cek validasi
			if ($this->form_validation->run() == TRUE) {

				//get data dari FORM
				$username = $this->input->post("user_name", TRUE);
				$password = MD5($this->input->post('password', TRUE));

				//checking data via model
				$checking = $this->Admin_model->check_login(array('user_name' => $username), array('password' => $password));

				//jika ditemukan, maka create session
				if ($checking != FALSE) {
					foreach ($checking as $apps) {

						$session_data = array(
							'user_id'   => $apps->id,
							'user_name' => $apps->user_name,
							'name' => $apps->nama,
							'user_pass' => $apps->password

						);
						//set session userdata
						$this->session->set_userdata($session_data);

						redirect('home');
					}
				} else {

					$data['error'] = '<div class="alert alert-danger" style="margin-top: 3px">
	                	<div class="header"><b><i class="fa fa-exclamation-circle"></i> ERROR</b> username atau password salah!</div></div>';
					$this->load->view('login', $data);
				}
			} else {

				$this->load->view('login');
			}
		}
	}
}
