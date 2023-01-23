<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authentication extends CI_Controller {

	/**
	 * This is default constructor of the class
	 */
	public function __construct()
	{
			parent::__construct();
	}


  /**
	 * This function used to check the user is logged in or not
	 */
	function isLoggedIn()
	{
			$isLoggedIn = $this->session->userdata('isLoggedIn');

			if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
			{
					$this->load->view('login');
			}
			else {
				$role = $this->session->userdata('role');
         if($role=='operator')
				 {
              redirect('/operator');
				 }
				 if($role=='user')
				{
							redirect('/user');
				}

				// print_r($role);

			}

		 // exit;
	}
	public function register()
	{
		$this->load->view('register');
	}
	public function login()
	{
		$this->isLoggedIn();

		// $this->load->view('login');
	}
	public function registerMe()
	{
		$email=$this->input->post('email');
		$password=$this->input->post('password');
		$username=$this->input->post('username');
		$contact=$this->input->post('contact');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[tbl_operator.email]');
		$this->form_validation->set_rules('password','Password','required');
		$this->form_validation->set_rules('username', 'Username', 'required|is_unique[tbl_operator.username]');
		$this->form_validation->set_rules('contact','Contact','required|min_length[5]|is_unique[tbl_operator.contact]');
		if ($this->form_validation->run())
		{
   			$where=array('email'=>$email,'password'=>base64_encode($password),
						'username'=>$username,'contact'=>$contact,'is_active'=>1);
			$users=$this->user_model->insertdata('tbl_operator',$where);
			if($users)
			{
				$where=array('id'=>$users);
				$exist=$this->user_model->get_joins('tbl_operator',$where);
				$this->session->set_userdata('user_id',$exist[0]['id']);
				$this->session->set_userdata('isLoggedIn', TRUE);
				$this->session->set_userdata('role','operator');
				$data=array('data'=>$exist);
				$this->load->view('Operator/profile',$data);
			} else {
				$this->session->set_flashdata('error','User not register');
				redirect('Authentication/register');
			}
		}
		else
		 {
			$this->session->set_flashdata('error',validation_errors('<p class="error">', '</p>'));
			redirect('Authentication/register');
		}
	}
	public function loginMe()
	{
		$username=$this->input->post('username');
		$password=base64_encode($this->input->post('password'));

		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password','Password','required');


					 $needle   = "@";

					 if( strpos( $username, $needle ) !== false) {
						 $wherecol=array(
							 'email'=>$username,
							 );

					 }else{
						 $wherecol=array(
							 'username'=>$username,
							 );

					 }

			$operator=$this->user_model->get_joins('tbl_operator',$wherecol);
			$users=$this->user_model->get_joins('tbl_users',$wherecol);

		if(!empty($operator))
		{
			$wherecol=array(
				'username'=>$username,
				'password'=>$password,
				);
			$passwordExists=$this->user_model->get_joins('tbl_operator',$wherecol);

			if($passwordExists) {

				$this->session->set_userdata('user_id',$passwordExists[0]['id']);
				$this->session->set_userdata('isLoggedIn', TRUE);
				$this->session->set_userdata('role','operator');
				$this->session->set_flashdata('success', 'Signin Successfully');
				redirect('Operator');
			}
			else {
				$this->session->set_flashdata('error','Password does not match');
				redirect('Authentication/login');
			}

		}
	   if(!empty($users)){


			 $needle   = "@";

			 if( strpos( $username, $needle ) !== false) {
				 $wherecol=array(
					 'email'=>$username,
					 'password'=>$password,

					 );
			 }else{
				 $wherecol=array(
					'username'=>$username,
					'password'=>$password,

					);
			 }


			 $passwordExists=$this->user_model->get_joins('tbl_users',$wherecol);

			 if($passwordExists) {
				 $this->session->set_userdata('user_id',$passwordExists[0]['id']);
				 $this->session->set_userdata('isLoggedIn', TRUE);
				 $this->session->set_userdata('role','user');
				 $this->session->set_flashdata('success', 'Signin Successfully');
				 redirect('User');
			 }
			 else {
				 $this->session->set_flashdata('error','Password does not match');
				 redirect('Authentication/login');
			 }

			}

		if(empty($operator) && empty($users)) {
			$this->session->set_flashdata('error','Username not exists');
			redirect('Authentication/login');
		}

	}

	public function test()
	{
		$this->load->view('Operator/profile');
	}
}
