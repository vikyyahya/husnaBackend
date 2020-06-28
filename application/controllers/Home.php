<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    public function __construct()
    {
		parent::__construct();
		 $this->load->model('Admin_model');
	}

	public function index()
	{
		if($this->Admin_model->logged_id())
		{
        // load view admin/overview.php
        $this->load->view("admin/home");
    	}else{

			redirect("login");
        

    	}
	}
public function logout()
	{
		$this->session->sess_destroy();

        $this->load->view("login");
		
	}
	
}
