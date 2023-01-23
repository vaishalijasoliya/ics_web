<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
	default page of the website
*/



class Welcome extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library("pagination");
		if($this->session->userdata('user_id')==""  || $this->session->userdata('role')!=="operator"){
			redirect('Authentication/login');
		}
		if($this->session->userdata('user_id')!=""  || $this->session->userdata('role')=="operator"){
			redirect('Operator');
		}
	}

	public function index()
	{
		$this->load->view('welcome_message');
	}
}
