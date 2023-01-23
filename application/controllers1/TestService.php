<?php
require(APPPATH.'/libraries/REST_Controller.php');
use Restserver\Libraries\REST_Controller;

class TestService extends REST_Controller
{
  public function __construct()
  {
    parent::__construct();
        
    //SMTP & mail configuration
    $config = array(
      'protocol'  => 'sendmail',
      'smtp_host' => 'smtp.office365.com',
      'smtp_port' =>  587,
      'smtp_user' => 'info@intelligentcanals.com',
      'smtp_pass' => '1C$1nf0#5',
      'mailtype'  => 'html',
      'charset'   => 'utf-8'
    );
    $this->email->initialize($config);
    $this->email->set_mailtype("html");
    $this->email->set_newline("\r\n");
    $this->email->from('info@intelligentcanals.com', 'ICS App');
  }

  public function sendEmail_get(){   
      $email = 'apurva.dixit@newtechfusion.com';
      $username = 'Apurva';
  
      //Email content
      $htmlContent = '<table>
            <tr>
              <td> <img src="'.base_url('assets/icsImages/norecord.png').'"></td>
            </tr>
            <tr>
            <td><b>Hello '.$username.',</b></td>
            </tr>                       				
            <tr>
            <td><b> Happy Testing. </b></td>
            </tr>                       				
            <tr>
            <td style="height:80px"> </td>
            </tr>					
            <tr>
              <td>Thank You</td>
            </tr>					
          </table>';
      $this->email->to($email,$username);
      $this->email->subject('Email Test');
      $this->email->message($htmlContent);
      if($this->email->send()){
        echo "Mail sent Successfully.";
      }
      else {
        echo "Mail not sent.";
      }
  }







  public function index_get()
  {    
    $data=array('status'=>true,'message'=>'ICS web get services.','result'=>'ICS web get services');
    $this->response($data,200);
  }
  public function index_post()
  {
    $data=array('status'=>true,'message'=>'ICS web post services','result'=>'ICS web post services');
    $this->response($data,200);
  }
	




  public function register_operator_post()
  {
    $username=$this->input->post('username');
    $email=$this->input->post('email');
    $password=$this->input->post('password');
    $contact=$this->input->post('contact');
    $gender=$this->input->post('gender');
    $address=$this->input->post('address');
    if(!empty($username) && !empty($password) && !empty($email)){
      $whereEmail=array('email'=>$email);
      $emailExists=$this->user_model->get_joins('tbl_operator',$whereEmail);
      if($emailExists){          
        $data=array('status'=>false,'message'=>'Email already exists','result'=>'Email already exists');
        $this->response($data,200);
      }
      else {
        // $imagename = 'OPERATOR'.date('Ys_').$_FILES['file']['name'];
        // $imagedata = $_FILES['file']['tmp_name'];
        // $foldername="assets/profileimages/";
        // if(!is_dir($foldername))
        // {
        //     mkdir($foldername, 0777, true);
        // }

        $insertdata=array(
          'email'=>$email,
          'username'=>$username,
          'password'=>base64_encode($password),
          'contact'=>$contact,
          'address'=>$address,
          'gender'=>$gender,
          // 'image'=> base_url('assets/profileimages/'.$imagename),
          'is_active'=>1
        );
        $insert=$this->user_model->INSERTDATA('tbl_operator',$insertdata);
        if($insert) {
          // move_uploaded_file($imagedata, $foldername . $imagename);                  
          $data=array('status'=>true,'message'=>'User created Successfully','result'=>$insert);
          $this->response($data,200);
        }
        else {            
          $data=array('status'=>false,'message'=>'Error creating Operator','result'=>'Error creating Operator');
          $this->response($data,200);
        }
      }
    }
    else {    
      $data=array('status'=>false,'message'=>'All fields are mandatory','result'=>'All fields are mandatory');
      $this->response($data,200);
    }
  }

  public function signin_operator_post()
  {
    $email=$this->input->post('email');
    $password=$this->input->post('password');
    if(!empty($email) && !empty($password))
    {
      $whereEmail=array('email'=>$email);
      $emailExists=$this->user_model->get_joins('tbl_operator',$whereEmail);
      if($emailExists)
      {
        $column=array('id','username','email','contact','gender','address','image','channel','is_active');
        $wherePassword=array('email'=>$email,'password'=>base64_encode($password));
        $passwordExists=$this->user_model->get_joins('tbl_operator',$wherePassword,'',$column);
        if($passwordExists)
        {          
          $data=array('status'=>true,'message'=>'User Signin Successfully','result'=>$passwordExists);
          $this->response($data,200);
        }
        else {          
          $data=array('status'=>false,'message'=>'Password not match please try Again','result'=>'Password not match please try Again');
          $this->response($data,200);
        }
      }
      else {        
        $data=array('status'=>false,'message'=>'Email not exists','result'=>'Email not exists');
        $this->response($data,200);
      }
    }
    else {    
      $data=array('status'=>false,'message'=>'Email and password are mandatory','result'=>'Email and password are mandatory');
      $this->response($data,200);
    }
  }

  public function get_all_operators_get()
  {
    $column=array('id','username','email','contact','gender','address','image','channel','is_active');
    $operators=$this->user_model->get_joins('tbl_operator','','',$column);
    if($operators)
    {      
      $data=array('status'=>true,'message'=>'All operators','result'=>$operators);
      $this->response($data,200);
    }
    else {      
      $data=array('status'=>false,'message'=>'Operator not found','result'=>'Operator not found');
      $this->response($data,200);
    }
  }

  public function delete_operator()
  {
    $id=$this->input->get('id');
    if($id){
      $where=array('id'=>$id);
      $operators=$this->user_model->get_joins('tbl_operator',$where);
      if($operators){
        $delete=$this->user_model->DELETEDATA('tbl_operator',$where);
        if($delete){          
          $data=array('status'=>true,'message'=>'Operator deleted Sucessfully','result'=>'Operator deleted Sucessfully');
          $this->response($data,200);
        }
        else {          
          $data=array('status'=>false,'message'=>'Error deleting operator','result'=>'Error deleting operator');
          $this->response($data,200);
        }
      }
      else {        
        $data=array('status'=>false,'message'=>'User not exists','result'=>'User not exists');
        $this->response($data,200);
      }
    }
    else {    
      $data=array('status'=>false,'message'=>'Id is mandatory','result'=>'Id is mandatory');
      $this->response($data,200);
    }
  }

  public function drupalTest_get()
  {
    $roles = array('0'=>'authenticated', '1'=>'prov_admin');
    // print_r($roles);
    
    $val = implode(',', $roles);
    
    // print_r($val);
    $data = array(
		  'UserName' => '$username',
		  'email' => '$email',
		  'PasswordHash' => '$password',
		  'UId' => '$userid',
		  'DrupalRoleID' => $val
     );
     print_r($data);


  }


  
}
