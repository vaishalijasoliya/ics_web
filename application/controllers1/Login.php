<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    if($this->session->userdata('user_id')!=="" && $this->session->userdata('role')=="admin")
    {
      redirect('Admin');
    }
   }
	public function index()
	{
		$this->load->view('Admin/login');
	}
  public function loginMe()
  {
    $email=$this->input->post('email');
    $password=$this->input->post('password');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
    $this->form_validation->set_rules('password','Password','required');
    if($this->form_validation->run()){
      $whereEmail=array('email'=>$email);
      $emailExists= $this->user_model->get_joins('tbl_admin',$whereEmail);
      if($emailExists)
      {
        $where=array('email'=>$email,'password'=>base64_encode($password));
        $users= $this->user_model->get_joins('tbl_admin',$where);
        if(!empty($users))
        {
          if($users[0]['role']==='admin')
          {
            $this->session->set_userdata('admin_user_id',$users[0]['id']);
            $this->session->set_userdata('isLoggedIn', TRUE);
            $this->session->set_userdata('role','admin');
            $this->session->set_flashdata('success', 'Sucessfully Log In.');
            redirect('Admin');
          }
        }
        else {
          $this->session->set_flashdata('error', '<b>Password not match!!!</b> please enter correct password');
          redirect('Login');
        }
      }
      else
      {
        $this->session->set_flashdata('error', 'Email not Exists,Please Register to Login');
        redirect('Login');
      }
    }
    else {
      $this->session->set_flashdata('error',validation_errors('<p class="error">', '</p>'));
      redirect('Login');
      return false;
    }
  }



}
