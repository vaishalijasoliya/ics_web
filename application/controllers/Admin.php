<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct() {
		parent::__construct();
		
		$this->load->library("pagination");
		if($this->session->userdata('admin_user_id')=="" || $this->session->userdata('role')!=="admin"){
			redirect('Login');
		}
	}
	public function index()
	{
		$id=$this->session->userdata('admin_user_id');
		$where=array('id'=>$id);
		$admin=$this->user_model->get_joins('tbl_admin',$where);
		$this->session->set_userdata('name',$admin[0]['name']);
		$cuser=array('count(id) as count');
		$data['user_data']=$this->user_model->get_joins('tbl_users','','',$cuser);
		$data['operator_data']=$this->user_model->get_joins('tbl_operator','','',$cuser);
		$data['page_title']='Dashboard';
		$data['page_name']='Admin/dashboard';
		$this->load->view('Admin/index',$data);
	}
  	public function viewoperators()
	{
		if(($this->input->post('addnewoperator')) == "save"){
			$username=$this->input->post('username');
			$email=$this->input->post('email');
			$password=$this->input->post('password');
			if(!empty($username) && !empty($password) && !empty($email)){
			  $whereEmail=array('email'=>$email);
			  $emailExists=$this->user_model->get_joins('tbl_operator',$whereEmail);
			  if($emailExists){
				 $this->session->set_flashdata('error','Operator Already Exists');
				 redirect('Admin/viewoperators');
			  }
			  else {

				$insertdata=array(
				  'email'=>$email,
				  'username'=>$username,
				  'password'=>base64_encode($password),
				  'is_active'=>1
				);
				$insert=$this->user_model->INSERTDATA('tbl_operator',$insertdata);
				if($insert) {
					$this->session->set_flashdata('success','Operator Created Successfully');

				}
				else {
					$this->session->set_flashdata('error','Error creating Operator');
				}
			  }
			}
			else {
				$data=array('status'=>false,'message'=>'All fields are mandatory','result'=>'All fields are mandatory');
				$this->response($data,200);
			}
		}
		if(($this->input->post('updateoperator')) == "save"){

			$id = $this->input->post('id');
			$username = $this->input->post('username');
			$email = $this->input->post('email');
      $exists=array('id !='=>$id,
		             'email'=>$email);

      $email_exists=$this->user_model->get_joins('tbl_operator',$exists);

	    if(!empty($email_exists))
			{
				$this->session->set_flashdata('error','Email already exists for Another Operator');
        redirect('Admin/viewoperators');
			}
			else {
				// $contact = $this->input->post('contact');
				// $gender = $this->input->post('gender');
				// $address = $this->input->post('address');
				$condition = array(
					'id' => $id
				);
				$updatedata = array(
					'username' => $username,
					'email' => $email,
					// 'contact' => $contact,
					// 'gender' => $gender,
					// 'address' => $address
				);
				$is_update = $this->user_model->UPDATEDATA('tbl_operator', $condition, $updatedata);
				if($is_update){
					$this->session->set_flashdata('success','Operator updated Sucessfully');

				}
				else {
					$this->session->set_flashdata('error','Error in updating Operator');
				}
			}


		}
		if(($this->input->post('deleteoperator')) == "save"){

			$id = $this->input->post('id');
			$condition = array(
				'id' => $id
			);
			$is_delete = $this->user_model->DELETEDATA('tbl_operator', $condition);
			if($is_delete){
				$this->session->set_flashdata('success','Operator Deleted Sucessfully');
			}
			else {
				$this->session->set_flashdata('error','Error in deleting Operator');
			}
		}
		$data['data']=$this->user_model->get_joins('tbl_operator');
		$data['page_title']='Operators';
		$data['page_name']='Admin/operators';
		$this->load->view('Admin/index',$data);

	}
	public function viewusers()
	{

			if(($this->input->post('addnewuser')) == "save"){

				$username=$this->input->post('username');
				$surname=$this->input->post('surname');
				$operatorid=$this->input->post('opertor_id');

				if(!empty($username) && !empty($surname) && !empty($operatorid)){
				  $whereEmail=array('username'=>$username);
				  $emailExists=$this->user_model->get_joins('tbl_users',$whereEmail);
				  if($emailExists){
					 $this->session->set_flashdata('error','User Already Exists');
					 redirect('Admin/viewusers');
				  }
				  else {

					$insertdata=array(
					  'operatorid'=>$operatorid,
					  'username'=>$username,
					  'surname'=>$surname,
					  'is_active'=>1
					);
					$insert=$this->user_model->INSERTDATA('tbl_users',$insertdata);
					if($insert) {
						$this->session->set_flashdata('success','User Created Successfully');

					}
					else {
						$this->session->set_flashdata('error','Error creating Operator');
					}
				  }
				}
				else {
					$data=array('status'=>false,'message'=>'All fields are mandatory','result'=>'All fields are mandatory');
					$this->response($data,200);
				}
			}
		if(($this->input->post('updateuser')) == "save"){

			$id = $this->input->post('id');
			$operatorid = $this->input->post('opertor_id');
			$username = $this->input->post('username');
			$surname = $this->input->post('surname');
			$condition = array(
				'id' => $id
			);
			$updatedata = array(
				'operatorid' => $operatorid,
				'username'=>$username,
				'surname'=>$surname
			);
			$is_update = $this->user_model->UPDATEDATA('tbl_users', $condition, $updatedata);
			if($is_update){
				$this->session->set_flashdata('success','Users updated Sucessfully');
			}
			else {
				$this->session->set_flashdata('error','Error in updating Water right');
			}
		}
		if(($this->input->post('deleteuser')) == "save"){

			$id = $this->input->post('id');
			$condition = array(
				'id' => $id
			);
			$is_delete = $this->user_model->DELETEDATA('tbl_users', $condition);
			if($is_delete){
				$this->session->set_flashdata('success','User Deleted Sucessfully');
			}
			else {
				$this->session->set_flashdata('error','Error in deleting User');
			}
		}

		$join= array(array('table'=>'tbl_operator','condition'=>'tbl_users.operatorid=tbl_operator.id','jointype'=>'left'));
    $columns=array('tbl_users.*','tbl_operator.username as operatorName');
		$data['operators']=$this->user_model->get_joins('tbl_operator');
		$data['data']=$this->user_model->get_joins('tbl_users','',$join,$columns);
		$data['page_title']='Users';
		$data['page_name']='Admin/users';
		$this->load->view('Admin/index',$data);
	}

	public function viewuser($id)
	{
		$where=array('tbl_users.id'=>$id);
		$join= array(array('table'=>'tbl_operator','condition'=>'tbl_users.operatorid=tbl_operator.id','jointype'=>'left'));
		$columns=array('tbl_users.*','tbl_operator.username as operatorName');
		$data['data']=$this->user_model->get_joins('tbl_users',$where,$join,$columns);
		$whereuser=array('user_id'=>$id);
		$data['water_right']=$this->user_model->get_joins('tbl_water_right_alloc',$whereuser);
		$data['page_title']='View Info';
		$data['page_name']='Admin/userinfo';
		$this->load->view('Admin/index',$data);
	}

	public function viewoperator($id)
	{
		$where=array('id'=>$id);
		$data['data']=$this->user_model->get_joins('tbl_operator',$where);
		$data['page_title']='View Info';
		$data['page_name']='Admin/operatorinfo';
		$this->load->view('Admin/index',$data);
	}

	public function delete_operator($id)
	{
		$where=array('id'=>$id);
		$delete=$this->user_model->DELETEDATA('tbl_operator',$where);
		if($delete)
		{
			$this->session->set_flashdata('success','User deleted Sucessfully');
			redirect('Admin/operators');
		}
		else {
			$this->session->set_flashdata('error','Error deleting user');
			redirect('Admin/operators');
		}
	}

	public function canal_info()
	{
		if(($this->input->post('addnewright')) == "save"){
			$wr_number = $this->input->post('wr_number');
			$field=array(
				'wr_number'=>$wr_number
			);
			$wr_info= $this->user_model->INSERTDATA('tbl_water_rights', $field);
			if($wr_info>0) {
				$this->session->set_flashdata('success','Water right added Sucessfully');
			}
			else {
				$this->session->set_flashdata('error','Error in adding Water right');
			}
		}
		if(($this->input->post('updatenewright')) == "save"){
			$id = $this->input->post('id');
			$wr_number = $this->input->post('wr_number');
			$condition = array(
				'id' => $id
			);
			$updatedata = array(
				'wr_number' => $wr_number
			);
			$is_update = $this->user_model->UPDATEDATA('tbl_water_rights', $condition, $updatedata);
			if($is_update){
				$this->session->set_flashdata('success','Water right updated Sucessfully');
			}
			else {
				$this->session->set_flashdata('error','Error in updating Water right');
			}
		}
		if(($this->input->post('deletenewright')) == "save"){
			$id = $this->input->post('id');
			$condition = array(
				'id' => $id
			);
			$is_delete = $this->user_model->DELETEDATA('tbl_water_rights', $condition);
			if($is_delete){
				$this->session->set_flashdata('success','Water right Deleted Sucessfully');
			}
			else {
				$this->session->set_flashdata('error','Error in deleting Water right');
			}
		}
		if(($this->input->post('addnewchannel')) == "save"){
			$channel_name = $this->input->post('channel');
			$field=array(
				'channel_name'=>$channel_name
			);
			$channel_info= $this->user_model->INSERTDATA('tbl_channels', $field);
			if($channel_info>0) {
				$this->session->set_flashdata('success','Channel added Sucessfully');
			}
			else {
				$this->session->set_flashdata('error','Error in adding channel');
			}
		}
		if(($this->input->post('updatechannel')) == "save"){
			$id = $this->input->post('id');
			$channel_name = $this->input->post('channel');
			$condition = array(
				'id' => $id
			);
			$updatedata = array(
				'channel_name' => $channel_name
			);
			$is_update = $this->user_model->UPDATEDATA('tbl_channels', $condition, $updatedata);
			if($is_update){
				$this->session->set_flashdata('success','Channel updated Sucessfully');
			}
			else {
				$this->session->set_flashdata('error','Error in updating channel');
			}
		}
		if(($this->input->post('deletechannel')) == "save"){
			$id = $this->input->post('id');
			$condition = array(
				'id' => $id
			);
			$is_delete = $this->user_model->DELETEDATA('tbl_channels', $condition);
			if($is_delete){
				$this->session->set_flashdata('success','Channel Deleted Sucessfully');
			}
			else {
				$this->session->set_flashdata('error','Error in deleting channel');
			}
		}

		if(($this->input->post('addnewmetertype')) == "save"){
			$meter_type = $this->input->post('meter_type');
			$field=array(
				'type'=>$meter_type
			);
			$channel_info= $this->user_model->INSERTDATA('tbl_metertype', $field);
			if($channel_info>0) {
				$this->session->set_flashdata('success','Meter Type added Sucessfully');
			}
			else {
				$this->session->set_flashdata('error','Error in adding channel');
			}
		}

		if(($this->input->post('updatemetertype')) == "save"){
			$id = $this->input->post('id');
			$type = $this->input->post('type');
			$condition = array(
				'id' => $id
			);
			$updatedata = array(
				'type' => $type
			);
			$is_update = $this->user_model->UPDATEDATA('tbl_metertype', $condition, $updatedata);
			if($is_update){
				$this->session->set_flashdata('success','Meter Type updated Sucessfully');
			}
			else {
				$this->session->set_flashdata('error','Error in updating channel');
			}
		}
		if(($this->input->post('deletemetertype')) == "save"){
			$id = $this->input->post('id');
			$condition = array(
				'id' => $id
			);
			$is_delete = $this->user_model->DELETEDATA('tbl_metertype', $condition);
			if($is_delete){
				$this->session->set_flashdata('success','Meter Type Deleted Sucessfully');
			}
			else {
				$this->session->set_flashdata('error','Error in deleting Meter Type');
			}
		}


				if(($this->input->post('addnewchargecode')) == "save"){
					$charge_code = $this->input->post('charge_code');
					$field=array(
						'charge_code'=>$charge_code
					);
					$channel_info= $this->user_model->INSERTDATA('tbl_charge_codes', $field);
					if($channel_info>0) {
						$this->session->set_flashdata('success','Charge Code added Sucessfully');
					}
					else {
						$this->session->set_flashdata('error','Error in adding Charge Code');
					}
				}
			if(($this->input->post('updatenewchargecode')) == "save"){
							$id = $this->input->post('id');
							$charge_code = $this->input->post('charge_code');
							$condition = array(
								'id' => $id
							);
							$updatedata = array(
								'charge_code' => $charge_code
							);
							$is_update = $this->user_model->UPDATEDATA('tbl_charge_codes', $condition, $updatedata);
							if($is_update){
								$this->session->set_flashdata('success','Charge Code updated Sucessfully');
							}
							else {
								$this->session->set_flashdata('error','Error in updating Charge Code');
							}
						}
		if(($this->input->post('deletenewchargecode')) == "save"){
							$id = $this->input->post('id');
							$condition = array(
								'id' => $id
							);
							$is_delete = $this->user_model->DELETEDATA('tbl_charge_codes', $condition);
							if($is_delete){
								$this->session->set_flashdata('success','Charge Code Deleted Sucessfully');
							}
							else {
								$this->session->set_flashdata('error','Error in deleting Meter Type');
							}
						}

			if(($this->input->post('addnewallocationtype')) == "save"){
											$allocation_type = $this->input->post('allocation_type');
											$field=array(
												'type'=>$allocation_type
											);
											$channel_info= $this->user_model->INSERTDATA('tbl_allocation_type', $field);
											if($channel_info>0) {
												$this->session->set_flashdata('success','Allocation Type added Sucessfully');
											}
											else {
												$this->session->set_flashdata('error','Error in adding Charge Code');
											}
										}
										if(($this->input->post('updateallowcationtype')) == "save"){
														$id = $this->input->post('id');
														$type = $this->input->post('type');
														$condition = array(
															'id' => $id
														);
														$updatedata = array(
															'type' => $type
														);
														$is_update = $this->user_model->UPDATEDATA('tbl_allocation_type', $condition, $updatedata);
														if($is_update){
															$this->session->set_flashdata('success','Allocation Type updated Sucessfully');
														}
														else {
															$this->session->set_flashdata('error','Error in updating Charge Code');
														}
													}
			if(($this->input->post('deleteallowcationtype')) == "save"){
																		$id = $this->input->post('id');
																		$condition = array(
																			'id' => $id
																		);
																		$is_delete = $this->user_model->DELETEDATA('tbl_allocation_type', $condition);
																		if($is_delete){
																			$this->session->set_flashdata('success','AllocationType Deleted Sucessfully');
																		}
																		else {
																			$this->session->set_flashdata('error','Error in deleting Meter Type');
																		}
																	}

		$data['rights']=$this->user_model->get_joins('tbl_water_rights');
		$data['channels']=$this->user_model->get_joins('tbl_channels');
		$data['metertype']=$this->user_model->get_joins('tbl_metertype');
		$data['charge_codes']=$this->user_model->get_joins('tbl_charge_codes');
		$data['allocation_type']=$this->user_model->get_joins('tbl_allocation_type');
		$data['debators']=$this->user_model->get_joins('tbl_debators');
		$data['page_title']='Canal Info';
		$data['page_name']='Admin/canalinfo';
		$this->load->view('Admin/index',$data);
	}

public function seasons()
{
	if(($this->input->post('season_data')) == "save")
	{
		$summer=$this->input->post('summer');
		$winter1=$this->input->post('winter1');
		$winter2=$this->input->post('winter2');
		$summer_condition=array('season_name'=>'Summer');
		$winter1_condition=array('season_name'=>'Winter 1');
    $winter2_condition=array('season_name'=>'Winter 2');
      $from= explode("-",$summer);
			$summer_from=date("Y-m-d H:i:s", strtotime($from[0]));
			$summer_to=date("Y-m-d H:i:s", strtotime($from[1]));
			$from= explode("-",$winter1);
			$winter1_from=date("Y-m-d H:i:s", strtotime($from[0]));
			$winter1_to=date("Y-m-d H:i:s", strtotime($from[1]));
			$from= explode("-",$winter2);
			$winter2_from=date("Y-m-d H:i:s", strtotime($from[0]));
			$winter2_to=date("Y-m-d H:i:s", strtotime($from[1]));

		$summer_update=array('date_range'=>$summer,'start_date'=>$summer_from,'end_date'=>$summer_to);
		$winter1_update=array('date_range'=>$winter1,'start_date'=>$winter1_from,'end_date'=>$winter1_to);
    $winter2_update=array('date_range'=>$winter2,'start_date'=>$winter2_from,'end_date'=>$winter2_to);

		$is_update = $this->user_model->UPDATEDATA('tbl_seasons',$summer_condition, $summer_update);
		$is_update = $this->user_model->UPDATEDATA('tbl_seasons',$winter1_condition, $winter1_update);
		$is_update = $this->user_model->UPDATEDATA('tbl_seasons',$winter2_condition, $winter2_update);

		$this->session->set_flashdata('success','Seasons Schedules Updated Sucessfully');

	}

	$data['seasons']=$this->user_model->get_joins('tbl_seasons');
	$data['page_title']='Seasons Schedules';
	$data['page_name']='Admin/seasons';
	$this->load->view('Admin/index',$data);
}

public function water_right()
{
	if(($this->input->post('updatewaterright')) == "save")
	{

  $id=  $this->input->post('id');
	$wr_number=	$this->input->post('wr_number');
  $wr_volume=	$this->input->post('wr_volume');
  $right_condition=array('id'=>$id);
	$right_update=array('wr_number'=>$wr_number,
                    'wr_volume'=>$wr_volume);
	$is_update = $this->user_model->UPDATEDATA('tbl_water_right_alloc',$right_condition, $right_update);

	$this->session->set_flashdata('success','Water right Updated Sucessfully');



	}
	  $columns=array('tbl_water_right_alloc.*','tbl_users.username');
    $join=array(
			array( 'table' => 'tbl_users', 'condition' => 'tbl_water_right_alloc.user_id= tbl_users.id', 'jointype' => 'LEFT' ),
		);
	  $data['data']=$this->user_model->get_joins('tbl_water_right_alloc','',$join,$columns);
		// $data['data']=$this->user_model->get_joins('tbl_operator');
		$data['page_title']='Water Right';
		$data['page_name']='Admin/water_right';
		$this->load->view('Admin/index',$data);

}

public function edit_profile()
{
	$data['data']=$this->user_model->get_joins('tbl_admin');
	$data['page_title']='Edit Profile';
	$data['page_name']='Admin/edit_profile';
	$this->load->view('Admin/index',$data);

}

public function edit_email()
{
	$email=$this->input->post('email');
  $condition=array('id'=>1);
	$update=array('email'=>$email);

	$this->user_model->UPDATEDATA('tbl_admin',$condition, $update);

}
public function edit_name()
{

		$email=$this->input->post('email');
	  $condition=array('id'=>1);
		$update=array('name'=>$email,'username'=>$email);

		$this->user_model->UPDATEDATA('tbl_admin',$condition, $update);
}

public function edit_password()
{

		$pass=$this->input->post('password');
	  $condition=array('id'=>1);
		$update=array('password'=>base64_encode($pass));

		$this->user_model->UPDATEDATA('tbl_admin',$condition, $update);
}

public function alert_season_date()
{
	$a=array();
	$data=$this->user_model->get_joins('tbl_seasons','','',array('end_date'));
	foreach ($data as $value) {

		$dts = new DateTime($value['end_date']);

		$todate = $dts->format('Y-m-d');

		array_push($a,$todate);
	}

     $res = 0;

     foreach($a as $v) {
         if($res < $v)
             $res = $v;
     }

		 $date = date('Y-m-d');
		 if($date>$res)
		 {
			 echo "date is greater";

		 }
		 else {
		 	echo "date is less";
		 }
}

	public function signout()
	{
		$this->session->unset_userdata('user_id');
		$this->session->sess_destroy();
		redirect('Login');
	}
}
