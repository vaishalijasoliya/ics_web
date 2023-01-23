<?php
require(APPPATH.'/libraries/REST_Controller.php');
use Restserver\Libraries\REST_Controller;

class Service extends REST_Controller
{
  public function __construct()
  {
    parent::__construct();
  }
  public function index_get()
  {
    $this->response(array('status'=>true,'message'=>'ICS web get services','result'=>'ICS web get services'),200);
  }
  public function index_post()
  {
    $this->response(array('status'=>true,'message'=>'ICS web post services','result'=>'ICS web post services'),200);
  }

  # Register an Operator
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
        $this->response(array('status'=>false,'message'=>'Email already exists','result'=>'Email already exists'),200);
      }
      else {
        $insertdata=array(
          'email'=>$email,
          'username'=>$username,
          'password'=>base64_encode($password),
          'contact'=>$contact,
          'address'=>$address,
          'gender'=>$gender,
          'is_active'=>1
        );
        $insert=$this->user_model->INSERTDATA('tbl_operator',$insertdata);
        if($insert) {
          $this->response(array('status'=>true,'message'=>'User created Successfully','result'=>$insert),200);
        }
        else {
          $this->response(array('status'=>false,'message'=>'Error creating Operator','result'=>'Error creating Operator'),200);
        }
      }
    }
    else {
      $this->response(array('status'=>false,'message'=>'All fields are mandatory','result'=>'All fields are mandatory'),200);
    }
  }

  # Login an Operator
  public function signin_operator_post()
  {
    $username=$this->input->post('username');
    $password=$this->input->post('password');
    if(!empty($username) && !empty($password))
    {
      $wherecol=array(
        'username'=>$username,
        'email'=>$username
      );
      $operatorExists=$this->user_model->get_joins('tbl_operator','','','','','','','','',$wherecol);
      if($operatorExists) {
        $length = sizeof($operatorExists);
        if($length!=1){
          $this->response(array('status'=>false,'message'=>'Operator already exists','result'=>'More users exists with this Username. Please Signin with email', 'size'=> $length),200);
        }
        else {
          $column=array('id','username','email','contact','gender','address','image','channel','is_active');
          $wherePassword=array('email'=>$operatorExists[0]['email'],'password'=>base64_encode($password));
          $passwordExists=$this->user_model->get_joins('tbl_operator',$wherePassword,'',$column);
          if($passwordExists) {
            $passwordExists[0]['role']="operator";
            $this->response(array('status'=>true,'message'=>'User Signin Successfully','result'=>$passwordExists),200);
          }
          else {
            $this->response(array('status'=>false,'message'=>'Password does not match','result'=>'Password does not match'),200);
          }
        }
      }
      else {
        $wherecol=array(
          'username'=>$username,
          'email'=>$username
        );
        $usernameExists=$this->user_model->get_joins('tbl_users','','','','','','','','',$wherecol);
        if($usernameExists) {
          $length = sizeof($usernameExists);
          if($length!=1){
            $this->response(array('status'=>false,'message'=>'Username already exists','result'=>'More users exists with this Username. Please Signin with email', 'size'=> $length),200);
          }
          else {
            $column=array('id','username','email','contact','address','is_active');
            $wherePassword=array('email'=>$usernameExists[0]['email'],'password'=>base64_encode($password));
            $passwordExists=$this->user_model->get_joins('tbl_users',$wherePassword,'',$column);
            if($passwordExists) {
              $passwordExists[0]['role']="user";
              $this->response(array('status'=>true,'message'=>'User Signin Successfully','result'=>$passwordExists),200);
            }
            else {
              $this->response(array('status'=>false,'message'=>'Password does not match','result'=>'Password does not match'),200);
            }
          }
        }
        else {
          $this->response(array('status'=>false,'message'=>'The user details do not exist','result'=>'The user details do not exist'),200);
        }
      }
    }
    else {
      $this->response(array('status'=>false,'message'=>'Username and password are mandatory','result'=>'Username and password are mandatory'),200);
    }
  }
  // public function signin_operator_OLD_post()
  // {
  //   $username=$this->input->post('username');
  //   $password=$this->input->post('password');
  //   if(!empty($username) && !empty($password))
  //   {
  //     $wherecol=array(
  //       'username'=>$username,
  //       'email'=>$username
  //     );
  //     $usernameExists=$this->user_model->get_joins('tbl_operator','','','','','','','','',$wherecol);
  //     if($usernameExists) {
  //       $length = sizeof($usernameExists);
  //       if($length!=1){
  //         $this->response(array('status'=>false,'message'=>'Username already exists','result'=>'More users exists with this Username. Please Signin with email', 'size'=> $length),200);
  //       }
  //       else {
  //         $column=array('id','username','email','contact','gender','address','image','channel','is_active');
  //         $wherePassword=array('email'=>$usernameExists[0]['email'],'password'=>base64_encode($password));
  //         $passwordExists=$this->user_model->get_joins('tbl_operator',$wherePassword,'',$column);
  //         if($passwordExists) {
  //           $this->response(array('status'=>true,'message'=>'User Signin Successfully','result'=>$passwordExists),200);
  //         }
  //         else {
  //           $this->response(array('status'=>false,'message'=>'Password does not match','result'=>'Password does not match'),200);
  //         }
  //       }
  //     }
  //     else {
  //       $this->response(array('status'=>false,'message'=>'Username not exists','result'=>'Username not exists'),200);
  //     }
  //   }
  //   else {
  //     $this->response(array('status'=>false,'message'=>'Username and password are mandatory','result'=>'Username and password are mandatory'),200);
  //   }
  // }

  # GET ALL OPERATORS
  public function get_all_operators_get()
  {
    $column=array('id','username','email','contact','gender','address','image','channel','is_active');
    $operators=$this->user_model->get_joins('tbl_operator','','',$column);
    if($operators) {
      $this->response(array('status'=>true,'message'=>'All operators','result'=>$operators),200);
    }
    else {
      $this->response(array('status'=>false,'message'=>'Operator not found','result'=>'Operator not found'),200);
    }
  }

  # View waterusers by the operator
  public function view_water_users_post()
  {
    $operatorid=$this->input->post('operatorid')?$this->input->post('operatorid'):"";
    $text = $this->input->post('text') ? $this->input->post('text') : '' ;
    // if($operatorid!=""){
      if($text!=''){
        $like = array(
          'tbl_users.username' => $text,
          'tbl_users.contact_name' => $text,
          'tbl_users.email' => $text,
        );
        $userExists = $this->user_model->get_joins('tbl_users','','','',$like,'','tbl_users.id DESC');
        if($userExists){
          $allusers = array();
          foreach($userExists as $exists){
            // if($exists['operatorid']==$operatorid && $exists['is_active']==1){
            if($exists['is_active']==1){
              $collect = array(
                'id'=>$exists['id'],
                'username'=>$exists['username'],
                'contact_name'=>$exists['contact_name'],
                'is_active'=>$exists['is_active'],
                'created_at'=>$exists['created_at']
              );
              array_push($allusers, $collect);
            }
          }
          if(sizeof($allusers) > 0){
            $this->response(array('status'=>true,'message'=>'Users Detail','result'=>$allusers),200);
          }
          else {
            $this->response(array('status'=>true,'message'=>'No Detail found','result'=>[]),200);
          }
        }
        else {
          $this->response(array('status'=>false,'message'=>'No Detail found','result'=>'No Detail found'),200);
        }
      }
      else {
        $column = array('id','username','contact_name','is_active','created_at');
        // $whereOperator = array('operatorid'=>$operatorid);
        // $userExists=$this->user_model->get_joins('tbl_users',$whereOperator,'',$column);
        $userExists=$this->user_model->get_joins('tbl_users','','',$column);
        if($userExists){
          $this->response(array('status'=>true,'message'=>'Users Detail','result'=>$userExists),200);
        }
        else {
          $this->response(array('status'=>false,'message'=>'No Detail found','result'=>'No Detail found'),200);
        }
      }
    // }
    // else {
    //   $this->response(array('status'=>false,'message'=>'Operator id is mandatory','result'=>'Operator id is empty'),200);
    // }
  }

  # SEARCH METER BY CLIENT NAME, SERIAL NUMBER, WATER RIGHT NUMBER OR CHANNEL NAME
  public function search_meter_connections_post()
  {
    $operatorid = $this->input->post('operatorid') ? $this->input->post('operatorid') : '' ;
    $text = $this->input->post('text') ? $this->input->post('text') : '' ;
    // if($operatorid!=''){
      $site_url = base_url().'assets/meterprofiles/';
      $noimage_url = base_url().'assets/meterprofiles/no-logo.jpg';
      if($text!=''){
        $like = array(
          'tbl_meter_connections.meter_name' => $text,
          'tbl_meter_connections.serial_number' => $text,
          'wr_number' => $text,
          'tbl_metertype.type' => $text,
          'tbl_channels.channel_name' => $text,
        );
        $columns = array('tbl_meter_connections.*','tbl_water_rights.wr_number as wr_number','tbl_metertype.type as metertype','tbl_channels.channel_name as channel_name','tbl_users.username as username','tbl_users.contact_name as contact_name', "CONCAT('$site_url', tbl_meter_connections.image) as lastphoto");
        $join=array(
          array( 'table' => 'tbl_water_rights', 'condition' => 'tbl_water_rights.id=tbl_meter_connections.water_right', 'jointype' => 'LEFT' ),
          array( 'table' => 'tbl_metertype', 'condition' => 'tbl_metertype.id=tbl_meter_connections.meter_type', 'jointype' => 'LEFT' ),
          array( 'table' => 'tbl_channels', 'condition' => 'tbl_channels.id=tbl_meter_connections.channel_name', 'jointype' => 'LEFT' ),
          array( 'table' => 'tbl_users', 'condition' => 'tbl_users.id=tbl_meter_connections.userid', 'jointype' => 'LEFT' )
        );
        $meterConnectionsExists = $this->user_model->get_joins('tbl_meter_connections','',$join,$columns,$like,'','tbl_meter_connections.id DESC');
        // print_r($this->db->last_query());
        if($meterConnectionsExists){
          $connections = array();
          foreach($meterConnectionsExists as $meters){
            // if($meters['operatorid']==$operatorid && $meters['isActive']==1){
            if($meters['isActive']==1){
              $collect = array(
                'id'=>$meters['id'],
                'operatorid'=>$meters['operatorid'],
                'userid'=>$meters['userid'],
                'username'=>$meters['username'],
                'contact_name'=>$meters['contact_name'],
                'serial_number'=>$meters['serial_number'],
                'meter_name'=>$meters['meter_name'],
                'channel_name'=>$meters['channel_name'],
                'property'=>$meters['property'],
                'metertype'=>$meters['metertype'],
                'comments'=>$meters['comments'],
                'wr_number'=>$meters['wr_number'],
                'channel_name'=>$meters['channel_name'],
                'isActive'=>$meters['isActive'],
                'createdAt'=>$meters['createdAt'],
                'lastphoto'=>$meters['image']!="" ? $meters['lastphoto'] : $noimage_url
                // 'lastphoto'=>$this->lastReadingPhoto($meters['id'])?  $this->lastReadingPhoto($meters['id']) : ''
              );
              array_push($connections, $collect);
            }
          }
          if(sizeof($connections) > 0){
            $this->response(array('status'=>true,'message'=>'Meter Connections','result'=>$connections),200);
          }
          else {
            $this->response(array('status'=>true,'message'=>'No Meter Connections','result'=>[]),200);
          }
        }
        else {
          $this->response(array('status'=>false,'message'=>'Meter Connections not exists','result'=>'Meter Connections not exists'),200);
        }
      }
      else {
        $columns = array('tbl_meter_connections.*','tbl_water_rights.wr_number as wr_number','tbl_metertype.type as metertype','tbl_channels.channel_name as channel_name','tbl_users.username as username','tbl_users.contact_name as contact_name', "CONCAT('$site_url', tbl_meter_connections.image) as lastphoto");
        $join=array(
          array( 'table' => 'tbl_water_rights', 'condition' => 'tbl_water_rights.id=tbl_meter_connections.water_right', 'jointype' => 'LEFT' ),
          array( 'table' => 'tbl_metertype', 'condition' => 'tbl_metertype.id=tbl_meter_connections.meter_type', 'jointype' => 'LEFT' ),
          array( 'table' => 'tbl_channels', 'condition' => 'tbl_channels.id=tbl_meter_connections.channel_name', 'jointype' => 'LEFT' ),
          array( 'table' => 'tbl_users', 'condition' => 'tbl_users.id=tbl_meter_connections.userid', 'jointype' => 'LEFT' )
        );
        $meterConnectionsExists = $this->user_model->get_joins('tbl_meter_connections','',$join,$columns,'','','tbl_meter_connections.id DESC');
        // print_r($this->db->last_query());
        // exit;
        if($meterConnectionsExists){
          $connections = array();
          foreach($meterConnectionsExists as $meters){
            // if($meters['operatorid']==$operatorid && $meters['isActive']==1){
            if($meters['isActive']==1){
              $collect = array(
                'id'=>$meters['id'],
                'operatorid'=>$meters['operatorid'],
                'userid'=>$meters['userid'],
                'username'=>$meters['username'],
                'contact_name'=>$meters['contact_name'],
                'serial_number'=>$meters['serial_number'],
                'meter_name'=>$meters['meter_name'],
                'channel_name'=>$meters['channel_name'],
                'property'=>$meters['property'],
                'metertype'=>$meters['metertype'],
                'comments'=>$meters['comments'],
                'wr_number'=>$meters['wr_number'],
                'channel_name'=>$meters['channel_name'],
                'isActive'=>$meters['isActive'],
                'createdAt'=>$meters['createdAt'],
                'lastphoto'=>$meters['image']!="" ? $meters['lastphoto'] : $noimage_url
                // 'lastphoto'=>$this->lastReadingPhoto($meters['id'])?  $this->lastReadingPhoto($meters['id']) : ''
              );
              array_push($connections, $collect);
            }
          }
          if(sizeof($connections) > 0){
            $this->response(array('status'=>true,'message'=>'Meter Connections','result'=>$connections),200);
          }
          else {
            $this->response(array('status'=>true,'message'=>'No Meter Connections','result'=>[]),200);
          }
        }
        else {
          $this->response(array('status'=>false,'message'=>'No Connections Available','result'=>'No Connections Available'),200);
        }
      }
    // }
    // else {
    //   $this->response(array('status'=>false,'message'=>'Operator is not valid','result'=>'Operator is not valid'),200);
    // }
  }
  function lastReadingPhoto($meterid)
  {
    $site_url = base_url().'assets/meterimages/';
    $where = array('meter_id' => $meterid );
    $column = array("CONCAT('$site_url', photo) AS photo");
    $meterLastConnectionsExists = $this->user_model->get_joins('tbl_meter_reading',$where,'',$column,'','','tbl_meter_reading.id DESC','1');
    if($meterLastConnectionsExists){
      return $meterLastConnectionsExists[0]['photo'];
    }
    else {
      return false;
    }
  }


  # GET ALL READING OF A METER
  public function view_meter_readings_post()
  {
    $meter_id = $this->input->post('meter_id') ? $this->input->post('meter_id') : '';
    if($meter_id!=''){
      $site_url = base_url().'assets/meterimages/';
      $where = array('tbl_meter_reading.meter_id'=>$meter_id, 'tbl_meter_reading.is_active'=>"1");
      $columns = array('tbl_meter_reading.*', "CONCAT('$site_url', photo) AS photo", 'tbl_water_rights.*', 'tbl_metertype.*', 'tbl_channels.channel_name as channel', 'tbl_meter_connections.serial_number as serial', 'tbl_meter_connections.meter_name as metername', 'tbl_meter_connections.property as meterproperty', 'tbl_meter_connections.isActive as meteractive', 'tbl_meter_connections.comments as metercomment', 'tbl_users.*', 'tbl_charge_codes.charge_code as charge_code');
      $join=array(
        array( 'table' => 'tbl_meter_connections', 'condition' => 'tbl_meter_connections.id='.$meter_id, 'jointype' => 'LEFT' ),
        array( 'table' => 'tbl_water_rights', 'condition' => 'tbl_water_rights.id=tbl_meter_connections.water_right', 'jointype' => 'LEFT' ),
        array( 'table' => 'tbl_metertype', 'condition' => 'tbl_metertype.id=tbl_meter_connections.meter_type', 'jointype' => 'LEFT' ),
        array( 'table' => 'tbl_channels', 'condition' => 'tbl_channels.id=tbl_meter_connections.channel_name', 'jointype' => 'LEFT' ),
        array( 'table' => 'tbl_users', 'condition' => 'tbl_users.id=tbl_meter_connections.userid', 'jointype' => 'LEFT' ),
        array( 'table' => 'tbl_charge_codes', 'condition' => 'tbl_charge_codes.id=tbl_meter_reading.charge_code', 'jointype' => 'LEFT' )
      );
      $meterReadingExists = $this->user_model->get_joins('tbl_meter_reading',$where,$join,$columns,'','','tbl_meter_reading.id DESC');
      if($meterReadingExists){
        $this->response(array('status'=>true,'message'=>'Meter Readings','result'=>$meterReadingExists),200);
      }
      else {
        $this->response(array('status'=>false,'message'=>'Meter Readings not found','result'=>'Meter Readings not found'),200);
      }
    }
    else {
      $this->response(array('status'=>false,'message'=>'Meter Id is not valid','result'=>'Meter Id is not valid'),200);
    }
  }

  # Add water detail of User by the operator
  public function add_water_detail_post()
  {
    $operatorid = $this->input->post('operatorid');
    $username = $this->input->post('username');
    $company_name = $this->input->post('company_name');
    $contact = $this->input->post('contact');
    $address = $this->input->post('address');
    $debator_code = $this->input->post('debator_code');
    $water_right_number = $this->input->post('water_right_number');
    $allocation_volume = $this->input->post('allocation_volume');
    $allocation_transfer_detail = $this->input->post('allocation_transfer_detail');
    $transfer_to = $this->input->post('transfer_to');
    $transfer_from = $this->input->post('transfer_from');
    $water_meter_number = $this->input->post('water_meter_number');
    $serial_number = $this->input->post('serial_number');
    $channel_location = $this->input->post('channel_location');
    $meter_type = $this->input->post('meter_type');
    $stock_supply = $this->input->post('stock_supply');
    $domestic_supply = $this->input->post('domestic_supply');
    $is_active= "1";

    if(!empty($operatorid) && !empty($username)){
      $whereSerial=array('serial_number'=>$serial_number);
      $serialExists=$this->user_model->get_joins('tbl_users',$whereSerial);
      if($serialExists){
        $this->response(array('status'=>false,'message'=>'Serial Number Already Exists','result'=>'Serial Number Already Exists'),200);
      }
      else {
        $insertdata=array(
          'operatorid'=>$operatorid,
          'username'=>$username,
          'company_name'=>$company_name,
          'contact'=>$contact,
          'address'=>$address,
          'debator_code'=>$debator_code,
          'water_right_number'=>$water_right_number,
          'allocation_volume'=>$allocation_volume,
          'allocation_transfer_detail'=>$allocation_transfer_detail,
          'transfer_to'=>$transfer_to,
          'transfer_from'=>$transfer_from,
          'water_meter_number'=>$water_meter_number,
          'serial_number'=>$serial_number,
          'channel_location'=>$channel_location,
          'meter_type'=>$meter_type,
          'stock_supply'=>$stock_supply,
          'domestic_supply'=>$domestic_supply,
          'is_active'=>"1"
        );
        $insert=$this->user_model->INSERTDATA('tbl_users',$insertdata);
        if($insert){
          $this->response(array('status'=>true,'message'=>'Saved Successfully','result'=>$insert),200);
        }
        else {
          $this->response(array('status'=>false,'message'=>'Error creating Operator','result'=>'Error creating Operator'),200);
        }
      }
    }
    else {
      $this->response(array('status'=>false,'message'=>'All feilds are mandatory','result'=>'Some feilds are empty'),200);
    }
  }

  # View waterusers details
  public function view_user_detail_post()
  {
    $userid=$this->input->post('userid')?$this->input->post('userid'):"";
    if($userid!=""){
      $where = array('id'=>$userid);
      $userExists=$this->user_model->get_joins('tbl_users',$where);
      if($userExists){
        $userExists[0]['connections'] = $this->get_user_connections($userid) ? $this->get_user_connections($userid) : [];
        $this->response(array('status'=>true,'message'=>'User Details','result'=>$userExists),200);
      }
      else {
        $this->response(array('status'=>false,'message'=>'No Detail found','result'=>[]),200);
      }
    }
    else {
      $this->response(array('status'=>false,'message'=>'User id is mandatory','result'=>[]),200);
    }
  }
  function get_user_connections($userid)
  {
    $site_url = base_url().'assets/meterprofiles/';
    $noimage_url = base_url().'assets/meterprofiles/no-logo.jpg';
    $where = array('userid'=>$userid);
    $columns = array('tbl_meter_connections.*','tbl_water_rights.wr_number as water_right','tbl_metertype.type as metertype','tbl_channels.channel_name as channel_name','tbl_users.username as username','tbl_users.contact_name as contact_name',"CONCAT('$site_url', tbl_meter_connections.image) as lastphoto");
        $join=array(
          array( 'table' => 'tbl_water_rights', 'condition' => 'tbl_water_rights.id=tbl_meter_connections.water_right', 'jointype' => 'LEFT' ),
          array( 'table' => 'tbl_metertype', 'condition' => 'tbl_metertype.id=tbl_meter_connections.meter_type', 'jointype' => 'LEFT' ),
          array( 'table' => 'tbl_channels', 'condition' => 'tbl_channels.id=tbl_meter_connections.channel_name', 'jointype' => 'LEFT' ),
          array( 'table' => 'tbl_users', 'condition' => 'tbl_users.id=tbl_meter_connections.userid', 'jointype' => 'LEFT' )
        );
    $connectionExists = $this->user_model->get_joins('tbl_meter_connections',$where,$join,$columns,'','','tbl_meter_connections.id DESC');
    if($connectionExists){
      // $connect = array();
      // $i=0;
      // foreach($connectionExists as $exists){
      //   $connectionExists[$i]['lastphoto'] = $this->lastReadingPhoto($exists['id'])?  $this->lastReadingPhoto($exists['id']) : '';
      //   array_push($connect, $connectionExists);
      //   $i++;
      // }
      // return $connect[0];
      return $connectionExists;
    }
    else {
      return false;
    }
  }

  # GET LIST OF CHARGE CODES
  public function get_charge_codes_post()
  {
    $chargeCodesExists=$this->user_model->get_joins('tbl_charge_codes');
    if($chargeCodesExists){
      $this->response(array('status'=>true,'message'=>'Charge Codes','result'=>$chargeCodesExists),200);
    }
    else {
      $this->response(array('status'=>false,'message'=>'No Detail found','result'=>[]),200);
    }
  }


  # Add Meter reading of User by the operator
  public function update_meter_reading_get()
  {
    $join = [
        [
            'table' => 'tbl_meter_connections',
            'condition' =>
                'tbl_meter_readings.meter_id=tbl_meter_connections.id',
            'jointype' => 'LEFT',
        ]
    ];
    $meters = $this
        ->user_model
        ->get_joins('tbl_meter_readings', '',$join);
        // echo "<pre>";
        // print_r($meters);
        // exit;
    foreach ($meters as $key => $meter) {

    $meter_id = $meter['meter_id'];
    $meter_reading = $meter['meter_reading'];
    $date_of_reading = $meter['date_of_reading'];
    $charge_code = $meter['charge_code'];
    $imagename = $meter['photo'];

    if($meter_id!="" && $meter_reading!="" && $charge_code!=""){

                  $where = ['tbl_meter_connections.id' => $meter_id];
                  $join = [
                      [
                          'table' => 'tbl_water_right_alloc',
                          'condition' =>
                              'tbl_water_right_alloc.id=tbl_meter_connections.water_right',
                          'jointype' => 'LEFT',
                      ],
                  ];

                  $meter_exists = $this->user_model->get_joins(
                      'tbl_meter_connections',
                      $where,
                      $join
                  );

                  $where = ['meter_id' => $meter_id];
                  $meters = $this->user_model->get_joins('tbl_meter_reading', $where);



                  if (empty($meters)) {
                      $data = $this->get_reading(
                          $meter_exists[0]['userid'],
                          $meter_exists[0]['water_right'],
                          $meter_reading
                      );

                      if (empty($data)) {
                        if($charge_code==5)
                        {
                          $meter_vol=0;
                          $rmain=$meter_exists[0]['wr_volume'];
                        }else {
                          $meter_vol=$meter_reading;
                          $rmain=$meter_exists[0]['wr_volume'] - $meter_reading;
                        }


                          $insert = [
                              'meter_id' => $meter_id,
                              'meter_reading' => $meter_reading,
                              'meter_vol' => $meter_vol,
                              'remaining' =>$rmain,
                              'date_of_reading' => $date_of_reading,
                              'charge_code' => $charge_code,
                              'prev_remain' =>
                                  $meter_exists[0]['wr_volume'] - $meter_reading,
                              'photo' => $imagename,
                          ];
                          $is_update = $this->user_model->INSERTDATA(
                              'tbl_meter_reading',
                              $insert
                          );
                      } else {

                          foreach ($data as $meter) {
                              $id = $meter['meter_id'];
                              $last_reading = array_reverse(
                                  explode(',', $meter['new_reading'])
                              )[0];
                              $last_remaining = array_reverse(
                                  explode(',', $meter['new_remaining'])
                              )[0];
                              $reading = $meter_reading;
                              if($charge_code==5)
                              {

                                $remain = $last_remaining;
                              }
                              else {

                                $remain = $last_remaining - $meter_reading;
                              }
                              // $remain = $last_remaining - $meter_reading;
                              $where = ['meter_id' => $id];
                              $update = ['remaining' => $remain];
                              $this->user_model->UPDATEDATA(
                                  'tbl_meter_reading',
                                  $where,
                                  $update
                              );
                          }
                          if($charge_code==5)
                          {
                            $meter_vol=0;
                          }
                          else {
                            $meter_vol=$meter_reading;
                          }

                          $insert = [
                              'meter_id' => $meter_id,
                              'meter_reading' => $meter_reading,
                              'meter_vol' => $meter_vol,
                              'remaining' => $update['remaining'],
                              'date_of_reading' => $date_of_reading,
                              'charge_code' => $charge_code,
                              'prev_remain' => $update['remaining'],
                              'photo' => $imagename,
                          ];
                          $is_update = $this->user_model->INSERTDATA(
                              'tbl_meter_reading',
                              $insert
                          );
                      }
                  } else {
                      $data = $this->get_reading(
                          $meter_exists[0]['userid'],
                          $meter_exists[0]['water_right'],
                          $meter_reading
                      );
                      $reading =
                          $meter_reading - array_reverse($meters)[0]['meter_reading'];
                      if (!empty($data)) {
                          foreach ($data as $meter) {
                              $id = $meter['meter_id'];
                              $last_remaining = array_reverse(
                                  explode(',', $meter['new_remaining'])
                              )[0];
                              if($charge_code==5)
                              {
                                $remain = $last_remaining;

                              }else {
                                $remain = $last_remaining - $reading;

                              }
                              $where = ['meter_id' => $id];
                              $update = ['remaining' => $remain];
                              $this->user_model->UPDATEDATA(
                                  'tbl_meter_reading',
                                  $where,
                                  $update
                              );
                          }
                      }

                      if($charge_code==5)
                      {
                        $meter_vol=0;
                      }
                      else {
                        $meter_vol=$reading;
                      }
                      $insert = [
                          'meter_id' => $meter_id,
                          'meter_reading' => $meter_reading,
                          'meter_vol' => $meter_vol,
                          'remaining' => $update['remaining'],
                          'prev_remain' => $update['remaining'],
                          'date_of_reading' => $date_of_reading,
                          'charge_code' => $charge_code,
                          'photo' => $imagename,
                      ];
                      $is_update = $this->user_model->INSERTDATA(
                          'tbl_meter_reading',
                          $insert
                      );
                  }


    }
  }
  exit;
  }

    # Add Meter reading of User by the operator
    public function add_meter_reading_post()
    {
      $meter_id = $this->input->post('meter_id') ? $this->input->post('meter_id') : "";
      $meter_reading = $this->input->post('meter_reading') ? $this->input->post('meter_reading') : "";
      $date_of_reading = $this->input->post('date') ? $this->input->post('date') : date('Y-m-d h:i:s');
      $charge_code = $this->input->post('charge_code') ? $this->input->post('charge_code') : "";

      if($meter_id!="" && $meter_reading!="" && $charge_code!=""){

                    $where = ['tbl_meter_connections.id' => $meter_id];
                    $join = [
                        [
                            'table' => 'tbl_water_right_alloc',
                            'condition' =>
                                'tbl_water_right_alloc.id=tbl_meter_connections.water_right',
                            'jointype' => 'LEFT',
                        ],
                    ];

                    $meter_exists = $this->user_model->get_joins(
                        'tbl_meter_connections',
                        $where,
                        $join
                    );

                    $where = ['meter_id' => $meter_id];
                    $meters = $this->user_model->get_joins('tbl_meter_reading', $where);

                    $dt = new DateTime($date_of_reading);

                    $date = $dt->format('Y-m-d');

                    if (!empty($_FILES['file']['name'])) {
                        $file_name = $_FILES['file']['name'];
                        $tmp = explode('.', $file_name);
                        $file_ext = strtolower(end($tmp));

                        $imagename = 'Meter' . date('Ymdhis') . '.' . $file_ext;
                        $imagedata = $_FILES['file']['tmp_name'];
                        $foldername = "assets/meterimages/";
                        if (!is_dir($foldername)) {
                            mkdir($foldername, 0777, true);
                        }
                        move_uploaded_file($imagedata, $foldername . $imagename);
                    } else {
                        $imagename = 'default-image.png';
                    }

                    if (empty($meters)) {
                        $data = $this->get_reading(
                            $meter_exists[0]['userid'],
                            $meter_exists[0]['water_right'],
                            $meter_reading
                        );

                        if (empty($data)) {
                            $insert = [
                                'meter_id' => $meter_id,
                                'meter_reading' => $meter_reading,
                                'meter_vol' => $meter_reading,
                                'remaining' =>
                                    $meter_exists[0]['wr_volume'] - $meter_reading,
                                'date_of_reading' => $date,
                                'charge_code' => $charge_code,
                                'prev_remain' =>
                                    $meter_exists[0]['wr_volume'] - $meter_reading,
                                'photo' => $imagename,
                            ];
                            $is_update = $this->user_model->INSERTDATA(
                                'tbl_meter_reading',
                                $insert
                            );
                        } else {
                            foreach ($data as $meter) {
                                $id = $meter['meter_id'];
                                $last_reading = array_reverse(
                                    explode(',', $meter['new_reading'])
                                )[0];
                                $last_remaining = array_reverse(
                                    explode(',', $meter['new_remaining'])
                                )[0];
                                $reading = $meter_reading;
                                $remain = $last_remaining - $meter_reading;
                                $where = ['meter_id' => $id];
                                $update = ['remaining' => $remain];
                                $this->user_model->UPDATEDATA(
                                    'tbl_meter_reading',
                                    $where,
                                    $update
                                );
                            }

                            $insert = [
                                'meter_id' => $meter_id,
                                'meter_reading' => $meter_reading,
                                'meter_vol' => $meter_reading,
                                'remaining' => $update['remaining'],
                                'date_of_reading' => $date,
                                'charge_code' => $charge_code,
                                'prev_remain' => $update['remaining'],
                                'photo' => $imagename,
                            ];
                            $is_update = $this->user_model->INSERTDATA(
                                'tbl_meter_reading',
                                $insert
                            );
                        }
                    } else {
                        $data = $this->get_reading(
                            $meter_exists[0]['userid'],
                            $meter_exists[0]['water_right'],
                            $meter_reading
                        );
                        $reading =
                            $meter_reading - array_reverse($meters)[0]['meter_reading'];
                        if (!empty($data)) {
                            foreach ($data as $meter) {
                                $id = $meter['meter_id'];
                                $last_remaining = array_reverse(
                                    explode(',', $meter['new_remaining'])
                                )[0];
                                $remain = $last_remaining - $reading;
                                $where = ['meter_id' => $id];
                                $update = ['remaining' => $remain];
                                $this->user_model->UPDATEDATA(
                                    'tbl_meter_reading',
                                    $where,
                                    $update
                                );
                            }
                        }
                        $insert = [
                            'meter_id' => $meter_id,
                            'meter_reading' => $meter_reading,
                            'meter_vol' => $reading,
                            'remaining' => $update['remaining'],
                            'prev_remain' => $update['remaining'],
                            'date_of_reading' => $date,
                            'charge_code' => $charge_code,
                            'photo' => $imagename,
                        ];
                        $is_update = $this->user_model->INSERTDATA(
                            'tbl_meter_reading',
                            $insert
                        );
                    }

    if($is_update){
      $this->response(array('status'=>true,'message'=>'Reading Saved Successfully','result'=>$is_update),200);
      // compare and insert data in master table
    }
    else {
      $this->response(array('status'=>false,'message'=>'Failed To Save Reading','result'=>'Failed To Save Reading'),200);
    }

      }
      else {
        $this->response(array('status'=>false,'message'=>'All fields are mandatory','result'=>'Some fields are missing'),200);
      }
    }


  # Add Offline Meter reading of User by the operator
  public function add_offline_reading_post()
  {
    $meter_name = $this->input->post('meter_name') ? $this->input->post('meter_name') : "";
    $serial_number = $this->input->post('serial_number') ? $this->input->post('serial_number') : "";
    $meter_reading = $this->input->post('meter_reading') ? $this->input->post('meter_reading') : "";
    $charge_code = $this->input->post('charge_code') ? $this->input->post('charge_code') : "";
    $date_time = $this->input->post('date_time') ? $this->input->post('date_time') : "";

    if($serial_number!="" && $meter_reading!="" && $charge_code!="" && $date_time!=""){
      if(!empty($_FILES['file'])){
        $file_name = $_FILES['file']['name'];
        $tmp = explode('.', $file_name);
        $file_ext = strtolower(end($tmp));

        $imagename = 'Meter'.date('Ymdhis').'.'.$file_ext;
        $imagedata = $_FILES['file']['tmp_name'];
        $foldername="assets/offlinemeterimages/";
        if(!is_dir($foldername)){
          mkdir($foldername, 0777, true);
        }
        move_uploaded_file($imagedata, $foldername . $imagename);
      }
      else {
        $imagename = "";
      }
      $insertdata=array(
        'meter_name'=>$meter_name,
        'serial_number'=>$serial_number,
        'meter_reading'=>$meter_reading,
        'meter_image'=>$imagename,
        'charge_code'=>$charge_code,
        'date_time'=>$date_time
      );
      $insert=$this->user_model->INSERTDATA('tbl_offline_readings',$insertdata);
      if($insert){
        $this->response(array('status'=>true,'message'=>'Reading Saved Successfully','result'=>$insert),200);
        // compare and insert data in master table
      }
      else {
        $this->response(array('status'=>false,'message'=>'Failed To Save Reading','result'=>'Failed To Save Reading'),200);
      }
    }
    else {
      $this->response(array('status'=>false,'message'=>'All fields are mandatory','result'=>'Some fields are missing'),200);
    }
  }

  public function compare_and_save_post()
  {
    $response=array();
    $offlineReadingsExists=$this->user_model->get_joins('tbl_offline_readings');
    $meterExists=$this->user_model->get_joins('tbl_meter_connections');
    if($offlineReadingsExists){
      if($meterExists){
        foreach($offlineReadingsExists as $reading){
          foreach($meterExists as $meter){
            if(strtoupper($reading['serial_number']) == strtoupper($meter['serial_number']) && $this->getIdOfChargeCode($reading['charge_code'])!=null){
              $insertdata = array(
                'meter_id' => $meter['id'],
                'meter_reading' => $reading['meter_reading'],
                'date_of_reading' => $reading['date_time'],
                'charge_code' => $this->getIdOfChargeCode($reading['charge_code']),
                'photo' => $reading['meter_image'],
                'is_active'=>"1"
              );
            }
          }

          if(!empty($insertdata) && isset($insertdata)){
            $insert=$this->user_model->INSERTDATA('tbl_meter_reading',$insertdata);
            if($insert){
              $condition = array('id' => $reading['id']);
              $this->user_model->DELETEDATA('tbl_offline_readings', $condition);
            }
            else {
              array_push($response,$reading['id']);
            }
          }
        }
        // print_r($response);
        if(empty($response)){
          $this->response(array('status'=>true,'message'=>'Readings saved successfully','result'=>[]),200);
        }
        else {
          $this->response(array('status'=>false,'message'=>'Failed to save readings','result'=>$response),200);
        }
      }
      else {
        $this->response(array('status'=>false,'message'=>'No meter connections found','result'=>[]),200);
      }
    }
    else {
      $this->response(array('status'=>false,'message'=>'No offline readings found','result'=>[]),200);
    }
  }
  function getIdOfChargeCode($chargecode){
    $where=array('charge_code'=> $chargecode);
    $chargeCodesExists=$this->user_model->get_joins('tbl_charge_codes', $where);
    return $chargeCodesExists ? $chargeCodesExists[0]['id'] : null;
  }


  # Add water order by User
  public function add_water_order_post() {
    $userid = $this->input->post('userid') ? $this->input->post('userid') : "";
    $meterid = $this->input->post('meter') ? $this->input->post('meter') : "";
    $startTime = $this->input->post('startTime') ? $this->input->post('startTime') : "";
    $flowRate = $this->input->post('flowRate') ? $this->input->post('flowRate') : "";
    $duration = $this->input->post('duration') ? $this->input->post('duration') : "";
    $endTime = $this->input->post('endTime') ? $this->input->post('endTime') : "";
    $totalVolume = $this->input->post('totalVolume') ? $this->input->post('totalVolume') : "";
    $weather = $this->input->post('weather') ? $this->input->post('weather') : "";
    $isActive= "0";

    if(($userid != "") && ($meterid != "") && ($startTime != "") && ($flowRate != "") && ($duration != "") && ($endTime != "") && ($totalVolume != "")){
      $insert=array(
        'userid'=>$userid,
        'meter'=>$meterid,
        'startTime'=> $startTime == "" ? date('Y-m-d H:i:s') : date('Y-m-d H:i:s', strtotime($startTime)),
        'flowRate'=>$flowRate,
        'duration'=>$duration,
        'endTime'=> $endTime == "" ? date('Y-m-d H:i:s') : date('Y-m-d H:i:s', strtotime($endTime)),
        'totalVolume'=>$totalVolume,
        'weather'=>$weather,
        'isActive'=>$isActive
      );
      $where = array('userid'=>$userid,'isActive'=>1);
      $col = array('userid','meter','startTime','flowRate','duration','endTime','totalVolume');
      $users_data = $this->user_model->get_joins('tbl_water_orders',$where,'',$col);
      if(in_array($insert, $users_data)){
        $this->response(array('status'=>false,'message'=>'Order Already Exists','result'=>'Order Already Exists'),200);
      }
      else {
        $insertdata=array(
          'userid'=>$userid,
          'meter'=>$meterid,
          'startTime'=> $startTime == "" ? date('Y-m-d H:i:s') : date('Y-m-d H:i:s', strtotime($startTime)),
          'flowRate'=>$flowRate,
          'duration'=>$duration,
          'endTime'=> $endTime == "" ? date('Y-m-d H:i:s') : date('Y-m-d H:i:s', strtotime($endTime)),
          'totalVolume'=>$totalVolume,
          'weather'=>$weather,
          'isActive'=>$isActive
        );
        $insert=$this->user_model->INSERTDATA('tbl_water_orders',$insertdata);
        if($insert){
          $whereRole=array('role'=>'operator');
          $tokenExists=$this->user_model->get_joins('tbl_tokens',$whereRole);
          if($tokenExists){
            foreach($tokenExists as $tokens){
              $notifiyOperator = array(
                'title' => 'New Water Order Request',
                'message' => 'New Water Order Request',
                'token' => $tokens['devicetoken'],
                'type' => 101
              );
              $this->cronPushNotification($notifiyOperator);
            }
          }

          $whereuser=array('role'=>'user', 'userid'=> $userid);
          $usertokenExists=$this->user_model->get_joins('tbl_tokens',$whereuser);
          if($usertokenExists){
            $notifiyUser = array(
              'title' => 'Order Requested Successfully',
              'message' => 'Order Requested Successfully',
              'token' => $usertokenExists[0]['devicetoken'],
              'type' => 101
            );
            $this->cronPushNotification($notifiyUser);
          }

          // save notification to user
          $this->store_notification('0', $userid, 'Water Order', 'Requested Successfully', 'Pending', 'user');
          $this->response(array('status'=>true,'message'=>'Saved Successfully','result'=>$insert),200);
        }
        else {
          $this->response(array('status'=>false,'message'=>'Error creating Operator','result'=>'Error creating Operator'),200);
        }
      }
    }
    else {
      $this->response(array('status'=>false,'message'=>'All feilds are mandatory','result'=>'Some feilds are empty'),200);
    }
  }

   # Update water order by User
   public function update_water_order_post() {
    $orderid = $this->input->post('orderid') ? $this->input->post('orderid') : "";
    $operatorid = $this->input->post('operatorid') ? $this->input->post('operatorid') : "";
    $userid = $this->input->post('userid') ? $this->input->post('userid') : "";
    $meterid = $this->input->post('meter') ? $this->input->post('meter') : "";
    $startTime = $this->input->post('startTime') ? $this->input->post('startTime') : "";
    $flowRate = $this->input->post('flowRate') ? $this->input->post('flowRate') : "";
    $duration = $this->input->post('duration') ? $this->input->post('duration') : "";
    $endTime = $this->input->post('endTime') ? $this->input->post('endTime') : "";
    $totalVolume = $this->input->post('totalVolume') ? $this->input->post('totalVolume') : "";
    $weather = $this->input->post('weather') ? $this->input->post('weather') : "";

    if(($orderid != "") && ($meterid != "")){
      $where = array('id'=>$orderid,'isActive'=>0  );
      $users_data = $this->user_model->get_joins('tbl_water_orders',$where);
      if(empty($users_data)){
        $this->response(array('status'=>false,'message'=>'Order Not Exists','result'=>'Order Not Exists'),200);
      }
      else {
        $updatedata=array(
          'operatorid'=>$operatorid,
          'meter'=>$meterid,
          'startTime'=> $startTime == "" ? date('Y-m-d H:i:s') : date('Y-m-d H:i:s', strtotime($startTime)),
          'flowRate'=>$flowRate,
          'duration'=>$duration,
          'endTime'=> $endTime == "" ? date('Y-m-d H:i:s') : date('Y-m-d H:i:s', strtotime($endTime)),
          'totalVolume'=>$totalVolume,
          'weather'=>$weather
        );

        $is_update = $this->user_model->UPDATEDATA('tbl_water_orders', $where, $updatedata);
        if($is_update){
          $whereuser=array('role'=>'user', 'userid'=> $userid);
          $tokenExists=$this->user_model->get_joins('tbl_tokens',$whereuser);
          if($tokenExists){
            $notifiyOperator = array(
              'title' => 'Water Order',
              'message' => 'Updated Successfully',
              'token' => $tokenExists[0]['devicetoken'],
              'type' => 101
            );
            $this->cronPushNotification($notifiyOperator);
          }
          // save notification to user
          $this->store_notification($userid, $operatorid, 'Water Order', 'Updated Successfully', 'Pending', 'operator');
          $this->store_notification($operatorid, $userid, 'Water Order', 'Updated Successfully', 'Pending', 'user');
          $this->response(array('status'=>true,'message'=>'Updated Successfully','result'=>$orderid),200);
        }
        else {
          $this->response(array('status'=>false,'message'=>'Error creating Operator','result'=>'Error creating Operator'),200);
        }
      }
    }
    else {
      $this->response(array('status'=>false,'message'=>'All feilds are mandatory','result'=>'Some feilds are empty'),200);
    }
  }




  # View water detail of User by the operator
  public function view_user_orders_post()
  {
    $pending=array();
$approve=array();
$denied=array();

$userid = $this->input->post('userid') ? $this->input->post('userid') : "";
 $meterid = $this->input->post('meterid') ? $this->input->post('meterid') : "";
if($userid != ""){
  if($meterid != ""){
    $whereUser=array(
      'tbl_water_orders.userid'=>$userid,
      'tbl_meter_connections.id'=>$meterid,
      'tbl_meter_connections.userid'=>$userid
    );
  }
  else {
    $whereUser=array(
      'tbl_water_orders.userid'=>$userid,
      'tbl_meter_connections.userid'=>$userid
    );
  }
  $site_url = base_url().'assets/meterprofiles/';
  // $whereUser=array(
  //   'tbl_water_orders.userid'=>$userid,
  //   'tbl_meter_connections.userid'=>$userid
  // );
  $columns = array('tbl_water_orders.*','tbl_meter_connections.id as meterid','tbl_meter_connections.meter_name as meter_name','tbl_meter_connections.serial_number as serial_number','tbl_meter_connections.property as property','tbl_meter_connections.id as meterid','tbl_meter_connections.userid as meteruserid', "CONCAT('$site_url', tbl_meter_connections.image) as meterimage", 'tbl_channels.channel_name as channel_name', 'tbl_metertype.type as type','tbl_water_right_alloc.wr_number as wr_number','tbl_water_right_alloc.wr_volume as wr_volume');
  $join=array(
    array( 'table' => 'tbl_meter_connections', 'condition' => 'tbl_meter_connections.id=tbl_water_orders.meter', 'jointype' => 'LEFT' ),
    array( 'table' => 'tbl_channels', 'condition' => 'tbl_channels.id=tbl_meter_connections.channel_name', 'jointype' => 'LEFT' ),
    array( 'table' => 'tbl_metertype', 'condition' => 'tbl_metertype.id=tbl_meter_connections.meter_type', 'jointype' => 'LEFT' ),
    array( 'table' => 'tbl_water_right_alloc', 'condition' => 'tbl_water_right_alloc.id=tbl_meter_connections.water_right', 'jointype' => 'LEFT' )
  );

  $orderExists=$this->user_model->get_joins('tbl_water_orders', $whereUser, $join, $columns,'','','tbl_water_orders.isActive');


  foreach($orderExists as $value)
  {
     if($value['isActive']==0)
     {
       array_push($pending,$value);
     }

     if($value['isActive']==1)
     {
       array_push($approve,$value);
     }
     if($value['isActive']==2)
     {
       array_push($denied,$value);
     }
  }
  $result=array('pending'=>$pending,'current'=>$approve,'finish'=>$denied);

 if($result){
    $this->response(array('status'=>true,'message'=>'User Orders','result'=>$result),200);
  }
  else {
    $this->response(array('status'=>false,'message'=>'No Order Exists','result'=>[]),200);
  }
}
else {
  $this->response(array('status'=>false,'message'=>'User Id is mandatory','result'=>'Some feilds are empty'),200);
}

  }

  # USAGE INFORMATION BY METER ID OF USER
  public function usage_informationby_meter_post()
  {
    $result=array();
    $userid = $this->input->post('userid') ? $this->input->post('userid') : "";
    $meterid = $this->input->post('meterid') ? $this->input->post('meterid') : "";
    if($userid != ""){
      if($meterid != ""){
        $whereUser=array(
          'tbl_meter_connections.userid'=>$userid,
          'tbl_meter_connections.id'=>$meterid
        );
      }
      else {
        $whereUser=array(
          'tbl_meter_connections.userid'=>$userid
        );
      }
      $site_url = base_url().'assets/meterprofiles/';
      $columns = array('tbl_meter_connections.*', "CONCAT('$site_url', tbl_meter_connections.image) as meterimage", 'tbl_channels.channel_name as channel_name', 'tbl_metertype.type as type','tbl_water_right_alloc.wr_number as wr_number','tbl_water_right_alloc.wr_volume as wr_volume','GROUP_CONCAT(meter_reading) as reading');
      $join=array(
        array( 'table' => 'tbl_meter_reading', 'condition' => 'tbl_meter_reading.meter_id=tbl_meter_connections.id', 'jointype' => 'LEFT' ),
        array( 'table' => 'tbl_channels', 'condition' => 'tbl_channels.id=tbl_meter_connections.channel_name', 'jointype' => 'LEFT' ),
        array( 'table' => 'tbl_metertype', 'condition' => 'tbl_metertype.id=tbl_meter_connections.meter_type', 'jointype' => 'LEFT' ),
        array( 'table' => 'tbl_water_right_alloc', 'condition' => 'tbl_water_right_alloc.id=tbl_meter_connections.water_right', 'jointype' => 'LEFT' )
      );
      $group=array('tbl_meter_connections.id');
      $informationExists=$this->user_model->get_joins('tbl_meter_connections', $whereUser, $join, $columns,'',$group);
      foreach($informationExists as $info)
      {
        $data=array('id'=> $info['id'],
        'operatorid'=> $info['operatorid'],
        'userid'=>$info['userid'],
        'serial_number'=> $info['serial_number'],
        'meter_name'=> $info['meter_name'],
        'channel_name'=>$info['channel_name'],
        'property'=> $info['property'],
        'meter_type'=> $info['meter_type'],
        'water_right'=> $info['water_right'],
        'comments'=> $info['comments'],
        'image'=>$info['image'],
        'isActive'=> $info['isActive'],
        'createdAt'=> $info['createdAt'],
        'meterimage'=> $info['meterimage'],
        'type'=> $info['type'],
        'wr_number'=> $info['wr_number'],
        'wr_volume'=> $info['wr_volume'],
        'total'=>array_reverse(explode(',',$info['reading']))[0],
        'remaining'=>''
      );

      array_push($result,$data);
      }

      if($informationExists){
        $this->response(array('status'=>true,'message'=>'User Usage Information','result'=>$result),200);
      }
      else {
        $this->response(array('status'=>false,'message'=>'Usage Information Not Exists','result'=>[]),200);
      }
    }
    else {
      $this->response(array('status'=>false,'message'=>'User Id is mandatory','result'=>'Some feilds are empty'),200);
    }
  }
  public function user_meter_connection_post()
  {
    $userid = $this->input->post('userid') ? $this->input->post('userid') : "";
    if($userid != ""){
      $site_url = base_url().'assets/meterprofiles/';
      $whereUser=array(
        'tbl_meter_connections.userid'=>$userid
      );
      $columns = array('tbl_meter_connections.*', "CONCAT('$site_url', tbl_meter_connections.image) as meterimage", 'tbl_channels.channel_name as channel_name', 'tbl_metertype.type as type','tbl_water_right_alloc.wr_number as wr_number','tbl_water_right_alloc.wr_volume as wr_volume');
      $join=array(
        array( 'table' => 'tbl_channels', 'condition' => 'tbl_channels.id=tbl_meter_connections.channel_name', 'jointype' => 'LEFT' ),
        array( 'table' => 'tbl_metertype', 'condition' => 'tbl_metertype.id=tbl_meter_connections.meter_type', 'jointype' => 'LEFT' ),
        array( 'table' => 'tbl_water_right_alloc', 'condition' => 'tbl_water_right_alloc.id=tbl_meter_connections.water_right', 'jointype' => 'LEFT' )
      );

      $connectionsExists=$this->user_model->get_joins('tbl_meter_connections', $whereUser, $join, $columns);
      if($connectionsExists){


        $this->response(array('status'=>true,'message'=>'User Connections','result'=>$connectionsExists),200);
      }
      else {
        $this->response(array('status'=>false,'message'=>'No Connections Exists','result'=>[]),200);
      }
    }
    else {
      $this->response(array('status'=>false,'message'=>'User Id is mandatory','result'=>'User Id is empty'),200);
    }

  }

 # METERS BY USER ID
 public function user_meter_connections_post()
 {
   $userid = $this->input->post('userid') ? $this->input->post('userid') : "";
   if($userid != ""){
     $site_url = base_url().'assets/meterprofiles/';
     $whereUser=array(
       'tbl_meter_connections.userid'=>$userid
     );
     $columns = array('tbl_meter_connections.*', "CONCAT('$site_url', tbl_meter_connections.image) as meterimage", 'tbl_channels.channel_name as channel_name', 'tbl_metertype.type as type','tbl_water_right_alloc.wr_number as wr_number','tbl_water_right_alloc.wr_volume as wr_volume');
     $join=array(
       array( 'table' => 'tbl_channels', 'condition' => 'tbl_channels.id=tbl_meter_connections.channel_name', 'jointype' => 'LEFT' ),
       array( 'table' => 'tbl_metertype', 'condition' => 'tbl_metertype.id=tbl_meter_connections.meter_type', 'jointype' => 'LEFT' ),
       array( 'table' => 'tbl_water_right_alloc', 'condition' => 'tbl_water_right_alloc.id=tbl_meter_connections.water_right', 'jointype' => 'LEFT' )
     );

     $connectionsExists=$this->user_model->get_joins('tbl_meter_connections', $whereUser, $join, $columns);
     if($connectionsExists){
       $this->response(array('status'=>true,'message'=>'User Connections','result'=>$connectionsExists),200);
     }
     else {
       $this->response(array('status'=>false,'message'=>'No Connections Exists','result'=>[]),200);
     }
   }
   else {
     $this->response(array('status'=>false,'message'=>'User Id is mandatory','result'=>'User Id is empty'),200);
   }

 }




 # AVAILABLE CHANNELS
 public function available_channels_post()
 {
   $channelsExists=$this->user_model->get_joins('tbl_channels');
   if($channelsExists){
     $inserted=array(array(
           'id' => '',
           'channel_name' => 'Select Channel',
           'channel_location' => 0,
           'channel_active' => '',

       ));

     array_splice( $channelsExists, 0, 0, $inserted );

     $this->response(array('status'=>true,'message'=>'Available Channels','result'=>$channelsExists),200);
   }
   else {
     $this->response(array('status'=>false,'message'=>'Channels Not Exists','result'=>[]),200);
   }
 }

# UNAPPROVED WATER ORDERS
public function unapproved_water_orders_post()
{
  $channelid = $this->input->post('channelid') ? $this->input->post('channelid') : "";
  if($channelid != ""){
    $whereUser=array(
      'tbl_water_orders.isActive'=> 0,
      'tbl_meter_connections.channel_name'=> $channelid
    );
  }
  else {
    $whereUser=array(
      'tbl_water_orders.isActive'=> 0
    );
  }

  $site_url = base_url().'assets/meterprofiles/';
  $columns = array('tbl_water_orders.*','tbl_meter_connections.id as meterid','tbl_meter_connections.meter_name as meter_name','tbl_meter_connections.serial_number as serial_number','tbl_meter_connections.property as property','tbl_meter_connections.id as meterid','tbl_meter_connections.userid as meteruserid', "CONCAT('$site_url', tbl_meter_connections.image) as meterimage", 'tbl_channels.channel_name as channel_name', 'tbl_metertype.type as type','tbl_water_right_alloc.wr_number as wr_number','tbl_water_right_alloc.wr_volume as wr_volume','tbl_users.username as username','tbl_users.contact_name as contact_name','tbl_users.email as email');
  $join=array(
    array( 'table' => 'tbl_meter_connections', 'condition' => 'tbl_meter_connections.id=tbl_water_orders.meter', 'jointype' => 'LEFT' ),
    array( 'table' => 'tbl_channels', 'condition' => 'tbl_channels.id=tbl_meter_connections.channel_name', 'jointype' => 'LEFT' ),
    array( 'table' => 'tbl_metertype', 'condition' => 'tbl_metertype.id=tbl_meter_connections.meter_type', 'jointype' => 'LEFT' ),
    array( 'table' => 'tbl_water_right_alloc', 'condition' => 'tbl_water_right_alloc.id=tbl_meter_connections.water_right', 'jointype' => 'LEFT' ),
    array( 'table' => 'tbl_users', 'condition' => 'tbl_users.id=tbl_water_orders.userid', 'jointype' => 'LEFT' ),
  );
  $orderExists=$this->user_model->get_joins('tbl_water_orders', $whereUser, $join, $columns);
  if($orderExists){
    $this->response(array('status'=>true,'message'=>'Unapproved Orders','result'=>$orderExists),200);
  }
  else {
    $this->response(array('status'=>false,'message'=>'No Order Exists','result'=>[]),200);
  }
}

# ACCEPT WATER ORDER
public function accept_water_order_post()
{
  $orderid = $this->input->post('orderid') ? $this->input->post('orderid') : "";
  $operatorid = $this->input->post('operatorid') ? $this->input->post('operatorid') : "";
  if(($orderid != "") && ($operatorid != "")){
    $condition = array(
      'id' => $orderid,
      'isActive!=' => "2"
    );
    $orderExists=$this->user_model->get_joins('tbl_water_orders', $condition);
    if($orderExists){
      if($orderExists[0]['isActive'] == "0"){
        $receiverid = $orderExists[0]['userid'];
        $updatedata = array(
          'isActive' => '1',
          'operatorid' => $operatorid
        );
        $is_update = $this->user_model->UPDATEDATA('tbl_water_orders', $condition, $updatedata);
        if($is_update){
          //  save notifications : store_notification($senderid,$receiverid,$title,$message,$status,$senderrole)
          $this->store_notification($operatorid, $receiverid, 'Water Order', 'Accepted Successfully', 'Approved', 'operator');
          $this->store_notification($receiverid, $operatorid, 'Water Order', 'Accepted Successfully', 'Approved', 'user');
          //  send notifications
          $notifiyUser = array(
            'title' => 'Water Order Accepted Successfully',
            'message' => 'Water Order Accepted Successfully',
            'token' => $this->getUserDeviceToken($receiverid, 'user'),
            'type' => 101
          );
          $is_updated=$this->user_model->get_joins('tbl_water_orders', $condition);
          $this->response(array('status'=>true,'message'=>'Order Approved Successfully','result'=>$is_updated),200);

        }
        else {
          $this->response(array('status'=>false,'message'=>'No Order Exists','result'=>[]),200);
        }
      }
      else {
        $this->response(array('status'=>false,'message'=>'Order Already Approved','result'=>$orderExists),200);
      }
    }
    else {
      $this->response(array('status'=>false,'message'=>'No Order Exists','result'=>[]),200);
    }
  }
  else {
    $this->response(array('status'=>false,'message'=>'Order And Operator Id is mandatory','result'=>[]),200);
  }
}
function getUserDeviceToken($userid, $role){
  $whereuser=array('role'=> $role, 'userid'=> $userid);
  $usertokenExists=$this->user_model->get_joins('tbl_tokens',$whereuser);
  if($usertokenExists){
    return $usertokenExists[0]['devicetoken'];
  }
  else {
    return false;
  }
}

# DENY WATER ORDER
public function deny_water_order_post()
{
  $orderid = $this->input->post('orderid') ? $this->input->post('orderid') : "";
  $operatorid = $this->input->post('operatorid') ? $this->input->post('operatorid') : "";
  if(($orderid != "") && ($operatorid != "")){
    $condition = array(
      'id' => $orderid
    );
    $orderExists=$this->user_model->get_joins('tbl_water_orders', $condition);
    if($orderExists){
      if($orderExists[0]['isActive'] != "2"){
        $receiverid = $orderExists[0]['userid'];

        if($orderExists[0]['isActive'] == "1"){
          $this->response(array('status'=>false,'message'=>'Order Already Approved','result'=>[]),200);
        } else {
          $updatedata = array(
            'isActive' => '2',
            'operatorid' => $operatorid
          );
          $is_update = $this->user_model->UPDATEDATA('tbl_water_orders', $condition, $updatedata);
          if($is_update){
             //  save notifications : store_notification($senderid,$receiverid,$title,$message,$status,$senderrole)
            $this->store_notification($operatorid, $receiverid, 'Water Order', 'Denied Successfully', 'Denied', 'operator');
            $this->store_notification($operatorid, $receiverid, 'Water Order', 'Denied Successfully', 'Denied', 'user');
            //  send notifications
            $notifiyUser = array(
              'title' => 'Water Order Denied Successfully',
              'message' => 'Water Order Denied Successfully',
              'token' => $this->getUserDeviceToken($receiverid, 'user'),
              'type' => 101
            );
            $is_updated=$this->user_model->get_joins('tbl_water_orders', $condition);
            $this->response(array('status'=>true,'message'=>'Order Denied Successfully','result'=>$is_updated),200);
          }
          else {
            $this->response(array('status'=>false,'message'=>'Order Denied Failed','result'=>[]),200);
          }
        }
      }
      else {
        $this->response(array('status'=>false,'message'=>'Order Already Denied','result'=>$orderExists),200);
      }
    }
    else {
      $this->response(array('status'=>false,'message'=>'No Order Exists','result'=>[]),200);
    }
  }
  else {
    $this->response(array('status'=>false,'message'=>'Order And Operator Id is mandatory','result'=>[]),200);
  }
}

# CURRENT WATER ORDERS - "Display Current Orders", which are orders that are currently being delivered
public function current_water_order_post()
{
  $current_date=date('Y-m-d');
  $current_orders=array();

  $upcoming_orders=array();
  $operatorid = $this->input->post('operatorid') ? $this->input->post('operatorid') : "";
  $channelid = $this->input->post('channelid') ? $this->input->post('channelid') : "";
  if($operatorid != ""){
    $date = date('Y-m-d h:i:s');
    $currentdate = date('Y-m-d', strtotime($date));
    if($channelid != "")
    {

  $whereUser=array(
    'tbl_water_orders.isActive'=> 1,
    'tbl_water_orders.operatorid'=> $operatorid,
    'tbl_channels.id'=>$channelid,

  );

    }
    else{

      $whereUser=array(
        'tbl_water_orders.isActive'=> 1,
        'tbl_water_orders.operatorid'=> $operatorid
      );
    }

    $site_url = base_url().'assets/meterprofiles/';
    $columns = array('tbl_water_orders.*','tbl_meter_connections.id as meterid','tbl_meter_connections.meter_name as meter_name','tbl_meter_connections.serial_number as serial_number','tbl_meter_connections.property as property','tbl_meter_connections.id as meterid','tbl_meter_connections.userid as meteruserid', "CONCAT('$site_url', tbl_meter_connections.image) as meterimage", 'tbl_channels.channel_name as channel_name', 'tbl_metertype.type as type','tbl_water_right_alloc.wr_number as wr_number','tbl_water_right_alloc.wr_volume as wr_volume','tbl_users.username as username','tbl_users.contact_name as contact_name','tbl_users.email as email');
    $join=array(
      array( 'table' => 'tbl_meter_connections', 'condition' => 'tbl_meter_connections.id=tbl_water_orders.meter', 'jointype' => 'LEFT' ),
      array( 'table' => 'tbl_channels', 'condition' => 'tbl_channels.id=tbl_meter_connections.channel_name', 'jointype' => 'LEFT' ),
      array( 'table' => 'tbl_metertype', 'condition' => 'tbl_metertype.id=tbl_meter_connections.meter_type', 'jointype' => 'LEFT' ),
      array( 'table' => 'tbl_water_right_alloc', 'condition' => 'tbl_water_right_alloc.id=tbl_meter_connections.water_right', 'jointype' => 'LEFT' ),
      array( 'table' => 'tbl_users', 'condition' => 'tbl_users.id=tbl_water_orders.userid', 'jointype' => 'LEFT' ),
    );
    $orderExists=$this->user_model->get_joins('tbl_water_orders', $whereUser, $join, $columns,'','','tbl_water_orders.startTime');

    if($orderExists){
      foreach($orderExists as $key=>$orders)
      {
        $s =$orders['startTime'];
        $dt = new DateTime($s);
        $date = $dt->format('Y-m-d');

        if($date==$current_date)
        {
          array_push($current_orders,$orders);
        }
      }

      $current_order=$this->checkTimeSlot($current_orders);

      $result=array('today'=>$current_order,'channel'=>$channelid);

      $this->response(array('status'=>true,'message'=>'Current Orders','result'=>$result),200);


    }
    else {
      $this->response(array('status'=>false,'message'=>'No Order Exists','result'=>[]),200);
    }
  }
  else {
    $this->response(array('status'=>false,'message'=>'Operator Id is mandatory','result'=>[]),200);
  }
}

public function checkTimeSlot($orders)
{


 $data= array(array('start'=>'00:00','end'=>'01:00','flow_rate'=>0,'orders'=>array()),
 array('start'=>'01:00','end'=>'02:00','flow_rate'=>0,'orders'=>array()),array('start'=>'02:00','end'=>'03:00','flow_rate'=>0,'orders'=>array())
,array('start'=>'03:00','end'=>'04:00','flow_rate'=>0,'orders'=>array()),array('start'=>'04:00','end'=>'05:00','flow_rate'=>0,'orders'=>array()),array('start'=>'05:00','end'=>'06:00','flow_rate'=>0,'orders'=>array()),array('start'=>'06:00','end'=>'07:00','flow_rate'=>0,'orders'=>array()),array('start'=>'07:00','end'=>'08:00','flow_rate'=>0,'orders'=>array())
,array('start'=>'08:00','end'=>'09:00','flow_rate'=>0,'orders'=>array()),array('start'=>'09:00','end'=>'10:00','flow_rate'=>0,'orders'=>array()),array('start'=>'10:00','end'=>'11:00','flow_rate'=>0,'orders'=>array()),array('start'=>'11:00','end'=>'12:00','flow_rate'=>0,'orders'=>array()),array('start'=>'12:00','end'=>'13:00','flow_rate'=>0,'orders'=>array()),array('start'=>'13:00','end'=>'14:00','flow_rate'=>0,'orders'=>array())
,array('start'=>'14:00','end'=>'15:00','flow_rate'=>0,'orders'=>array()),array('start'=>'15:00','end'=>'16:00','flow_rate'=>0,'orders'=>array()),array('start'=>'16:00','end'=>'17:00','flow_rate'=>0,'orders'=>array()),array('start'=>'17:00','end'=>'18:00','flow_rate'=>0,'orders'=>array()),array('start'=>'18:00','end'=>'19:00','flow_rate'=>0,'orders'=>array()),array('start'=>'19:00','end'=>'20:00','flow_rate'=>0,'orders'=>array())
,array('start'=>'20:00','end'=>'21:00','flow_rate'=>0,'orders'=>array()),array('start'=>'21:00','end'=>'22:00','flow_rate'=>0,'orders'=>array()),array('start'=>'22:00','end'=>'23:00','flow_rate'=>0,'orders'=>array()),array('start'=>'23:00','end'=>'00:00','flow_rate'=>0,'orders'=>array()));


 foreach($orders as $order)
 {

 $s=$order['startTime'];


 $dt = new DateTime($s);
 $date = $dt->format('H:i');

 $dates=$this->checkTimeInBetween($date);
 $key=$dates['key'];

 if(isset($data[$key]['orders']))
 {
   $current_value=array();

   $data[$key]['flow_rate']=$data[$key]['flow_rate']+$order['flowRate'];
   $data[$key]['orders'][]=array_merge($current_value,$order);

 }
 else
 {

  $data[$key]['flow_rate']=$data[$key]['flow_rate']+$order['flowRate'];

  $data[$key]['orders'][]=$order;

 }

 }
 return $data;


}

public function checkTimeInBetween($date)
{

  $data= array(array('start'=>'00:00','end'=>'01:00'),
  array('start'=>'01:00','end'=>'02:00'),array('start'=>'02:00','end'=>'03:00')
 ,array('start'=>'03:00','end'=>'04:00'),array('start'=>'04:00','end'=>'05:00'),array('start'=>'05:00','end'=>'06:00'),array('start'=>'06:00','end'=>'07:00'),array('start'=>'07:00','end'=>'08:00')
 ,array('start'=>'08:00','end'=>'09:00'),array('start'=>'09:00','end'=>'10:00'),array('start'=>'10:00','end'=>'11:00','flow_rate'=>0,'orders'=>array()),array('start'=>'11:00','end'=>'12:00'),array('start'=>'12:00','end'=>'13:00'),array('start'=>'13:00','end'=>'14:00')
 ,array('start'=>'14:00','end'=>'15:00'),array('start'=>'15:00','end'=>'16:00'),array('start'=>'16:00','end'=>'17:00'),array('start'=>'17:00','end'=>'18:00'),array('start'=>'18:00','end'=>'19:00','flow_rate'=>0,'orders'=>array()),array('start'=>'19:00','end'=>'20:00')
 ,array('start'=>'20:00','end'=>'21:00'),array('start'=>'21:00','end'=>'22:00'),array('start'=>'22:00','end'=>'23:00'),array('start'=>'23:00','end'=>'00:00'));
 foreach($data as $key=>$d)
 {

     if (strtotime($date) >= strtotime($d['start']) && strtotime($date) <= strtotime($d['end'])) {
       $slot =array('key'=>$key,'slot'=>$d);

       return $slot;
   }

 }
}
# UPCOMING WATER ORDERS - "Display Upcoming Orders" which are orders that are approved and scheduled.

public function upcoming_water_order_post()
{
  $current_date=date('Y-m-d');
  $current_orders=array();

  $upcoming_orders=array();
  $operatorid = $this->input->post('operatorid') ? $this->input->post('operatorid') : "";
  $channelid = $this->input->post('channelid') ? $this->input->post('channelid') : "";
  if($operatorid != ""){
    $date = date('Y-m-d h:i:s');
    $currentdate = date('Y-m-d', strtotime($date));
    if($channelid != "")
    {

  $whereUser=array(
    'tbl_water_orders.isActive'=> 1,
    'tbl_water_orders.operatorid'=> $operatorid,
    'tbl_channels.id'=>$channelid,

  );

    }
    else{

      $whereUser=array(
        'tbl_water_orders.isActive'=> 1,
        'tbl_water_orders.operatorid'=> $operatorid
      );
    }
    $site_url = base_url().'assets/meterprofiles/';
    $columns = array('tbl_water_orders.*','tbl_meter_connections.id as meterid','tbl_meter_connections.meter_name as meter_name','tbl_meter_connections.serial_number as serial_number','tbl_meter_connections.property as property','tbl_meter_connections.id as meterid','tbl_meter_connections.userid as meteruserid', "CONCAT('$site_url', tbl_meter_connections.image) as meterimage", 'tbl_channels.channel_name as channel_name', 'tbl_metertype.type as type','tbl_water_right_alloc.wr_number as wr_number','tbl_water_right_alloc.wr_volume as wr_volume','tbl_users.username as username','tbl_users.contact_name as contact_name','tbl_users.email as email');
    $join=array(
      array( 'table' => 'tbl_meter_connections', 'condition' => 'tbl_meter_connections.id=tbl_water_orders.meter', 'jointype' => 'LEFT' ),
      array( 'table' => 'tbl_channels', 'condition' => 'tbl_channels.id=tbl_meter_connections.channel_name', 'jointype' => 'LEFT' ),
      array( 'table' => 'tbl_metertype', 'condition' => 'tbl_metertype.id=tbl_meter_connections.meter_type', 'jointype' => 'LEFT' ),
      array( 'table' => 'tbl_water_right_alloc', 'condition' => 'tbl_water_right_alloc.id=tbl_meter_connections.water_right', 'jointype' => 'LEFT' ),
      array( 'table' => 'tbl_users', 'condition' => 'tbl_users.id=tbl_water_orders.userid', 'jointype' => 'LEFT' ),
    );
    $orderExists=$this->user_model->get_joins('tbl_water_orders', $whereUser, $join, $columns,'','','tbl_water_orders.startTime');
    if($orderExists){
      foreach($orderExists as $key=>$orders)
      {
        $s =$orders['startTime'];
        $dt = new DateTime($s);

        $date = $dt->format('Y-m-d');
        if($date>$current_date)
        {

          array_push($upcoming_orders,$orders);
        }

      }

      $upcoming_orders=$this->checkDateSlot($upcoming_orders);
      $result=array(
      'upcoming'=>$upcoming_orders,'channel'=>$channelid);

      $this->response(array('status'=>true,'message'=>'Upcoming Orders','result'=>$result),200);




    }
    else {
      $result=array('upcoming'=>array(),'channel'=>$channelid);
      $this->response(array('status'=>false,'message'=>'No Order Exists','result'=>$result),200);
    }
  }
  else {
    $this->response(array('status'=>false,'message'=>'Operator Id  is mandatory','result'=>[]),200);
  }

}


public function checkDateSlot($orders)
{
$start=$end=date('Y-m-d');
    $data= array(array('start'=>'00:00','end'=>'01:00','flow_rate'=>0,'orders'=>array()),
    array('start'=>'01:00','end'=>'02:00','flow_rate'=>0,'orders'=>array()),array('start'=>'02:00','end'=>'03:00','flow_rate'=>0,'orders'=>array())
   ,array('start'=>'03:00','end'=>'04:00','flow_rate'=>0,'orders'=>array()),array('start'=>'04:00','end'=>'05:00','flow_rate'=>0,'orders'=>array()),array('start'=>'05:00','end'=>'06:00','flow_rate'=>0,'orders'=>array()),array('start'=>'06:00','end'=>'07:00','flow_rate'=>0,'orders'=>array()),array('start'=>'07:00','end'=>'08:00','flow_rate'=>0,'orders'=>array())
   ,array('start'=>'08:00','end'=>'09:00','flow_rate'=>0,'orders'=>array()),array('start'=>'09:00','end'=>'10:00','flow_rate'=>0,'orders'=>array()),array('start'=>'10:00','end'=>'11:00','flow_rate'=>0,'orders'=>array()),array('start'=>'11:00','end'=>'12:00','flow_rate'=>0,'orders'=>array()),array('start'=>'12:00','end'=>'13:00','flow_rate'=>0,'orders'=>array()),array('start'=>'13:00','end'=>'14:00','flow_rate'=>0,'orders'=>array())
   ,array('start'=>'14:00','end'=>'15:00','flow_rate'=>0,'orders'=>array()),array('start'=>'15:00','end'=>'16:00','flow_rate'=>0,'orders'=>array()),array('start'=>'16:00','end'=>'17:00','flow_rate'=>0,'orders'=>array()),array('start'=>'17:00','end'=>'18:00','flow_rate'=>0,'orders'=>array()),array('start'=>'18:00','end'=>'19:00','flow_rate'=>0,'orders'=>array()),array('start'=>'19:00','end'=>'20:00','flow_rate'=>0,'orders'=>array())
   ,array('start'=>'20:00','end'=>'21:00','flow_rate'=>0,'orders'=>array()),array('start'=>'21:00','end'=>'22:00','flow_rate'=>0,'orders'=>array()),array('start'=>'22:00','end'=>'23:00','flow_rate'=>0,'orders'=>array()),array('start'=>'23:00','end'=>'00:00','flow_rate'=>0,'orders'=>array()));


$test=$data;
$newProduct=array();

  $day=array();
  $count=count($orders)-1;

  if(!empty($orders))
  {

    $start=$orders[0]['startTime'];
    $dummy_date=$orders[$count]['startTime'];
   $end=date('Y-m-d', strtotime("+1 day", strtotime($dummy_date)));
  }

  $this->list_days($start,$end);
  $newOrder=array();
  foreach($orders as $value)
  {

     $s=$value['startTime'];
     $dt = new DateTime($s);
     $value['date'] = $dt->format('Y-m-d');

     array_push($newOrder,$value);
  }
$type = [];
foreach ($newOrder as $item) {
    $type[$item['date']][] = $item;
}


$days=$this->list_days($start,$end);

for($i=0;$i<count($days);$i++)
{
    if (array_key_exists($days[$i],$type))
  {
     foreach($type[$days[$i]] as $key=>$order)
     {

        $s=$order['startTime'];


        $dt = new DateTime($s);

        $date = $dt->format('H:i');
        $time = $dt->format('Y-m-d');

        $dates=$this->checkTimeInBetween($date);
        $key=$dates['key'];

        // if($days[$i]==$order)

            if(isset($data[$key]['orders']))
            {
              $current_value=array();

              $data[$key]['flow_rate']=$data[$key]['flow_rate']+$order['flowRate'];

              $data[$key]['orders'][]=array_merge($current_value,$order);


            }
            else
            {
               $data[$key]['flow_rate']=$data[$key]['flow_rate']+$order['flowRate'];

               $data[$key]['orders'][]=$order;

            }


     }

     $myData=array('day'=>$time,'orders'=>$data);
     array_push($newProduct,$myData);
     $data=$test;

  }
else
  {

    $myData=array('day'=>$days[$i],'orders'=>$data);
    array_push($newProduct,$myData);


  }


}

return $newProduct;


}

public function list_days($st_date,$ed_date)
{

$dateMonthYearArr = array();
$st_dateTS = strtotime($st_date);
$ed_dateTS = strtotime($ed_date);

for ($currentDateTS = $st_dateTS; $currentDateTS <= $ed_dateTS; $currentDateTS += (60 * 60 * 24)) {
// use date() and $currentDateTS to format the dates in between
$currentDateStr = date('Y-m-d',$currentDateTS);
$dateMonthYearArr[] = $currentDateStr;
//print $currentDateStr.”<br />”;
}

return $dateMonthYearArr;

}
# SAVE NOTIFICATIONS
public function save_notifications_post()
{
  $senderid = $this->input->post('senderid') ? $this->input->post('senderid') : "";
  $receiverid = $this->input->post('receiverid') ? $this->input->post('receiverid') : "";
  $title = $this->input->post('title') ? $this->input->post('title') : "";
  $message = $this->input->post('message') ? $this->input->post('message') : "";
  $status = $this->input->post('status') ? $this->input->post('status') : "";
  $senderrole = $this->input->post('senderrole') ? $this->input->post('senderrole') : "";

  if(($senderid != "") && ($receiverid != "") && ($senderrole != "")){
    $insertdata=array(
      'senderid'=>$senderid,
      'senderrole'=>$senderrole,
      'receiverid'=>$receiverid,
      'title'=>$title,
      'message'=>$message,
      'status'=>$status
    );
    $insert=$this->user_model->INSERTDATA('tbl_notifications',$insertdata);
    if($insert) {
      $this->response(array('status'=>true,'message'=>'Notifications saved Successfully','result'=>$insert),200);
    }
    else {
      $this->response(array('status'=>false,'message'=>'Notifications not saved','result'=>'Notifications not saved'),200);
    }
  }
  else {
    $this->response(array('status'=>false,'message'=>'Sender and Receiver Id is mandatory','result'=>[]),200);
  }
}

// Insert notification into DB
function store_notification($senderid,$receiverid,$title,$message,$status,$senderrole){

  if(($senderid != "") && ($receiverid != "") && ($senderrole != "")){
    $insertdata=array(
      'senderid'=>$senderid,
      'senderrole'=>$senderrole,
      'receiverid'=>$receiverid,
      'title'=>$title,
      'message'=>$message,
      'status'=>$status
    );
    $insert=$this->user_model->INSERTDATA('tbl_notifications',$insertdata);
    if($insert) {
      return true;
    }
    else {
      return false;
    }
  }
  else {
    return false;
  }
}




# VIEW NOTIFICATIONS
public function get_notifications_post()
{
  $userid = $this->input->post('userid') ? $this->input->post('userid') : "";
  $senderrole = $this->input->post('senderrole') ? $this->input->post('senderrole') : "";
  if(($userid != "") && ($senderrole != "")){
    $condition = array(
      'receiverid' => $userid,
      'senderid' => $userid,
      'senderrole' => $senderrole
    );
    $notificationExists=$this->user_model->get_joins('tbl_notifications', '','','','','','id DESC','','',$condition);
    if($notificationExists){
      $this->response(array('status'=>true,'message'=>'Notifications','result'=>$notificationExists),200);
    }
    else {
      $this->response(array('status'=>false,'message'=>'Notifications not exists','result'=>[]),200);
    }
  }
  else {
    $this->response(array('status'=>false,'message'=>'User Id and role is mandatory','result'=>[]),200);
  }
}


# SAVE DEVICE TOKEN
public function save_device_token_post()
{
  $userid = $this->input->post('userid') ? $this->input->post('userid') : "";
  $role = $this->input->post('role') ? $this->input->post('role') : "";
  $token = $this->input->post('token') ? $this->input->post('token') : "";
  if(($userid != "") && ($token != "")){
    $condition = array(
      'userid' => $userid,
      'role' => $role
    );
    $tokenExists=$this->user_model->get_joins('tbl_tokens', $condition);
    if($tokenExists){
      $updatedata = array(
        'devicetoken '=>$token
      );
      $is_update = $this->user_model->UPDATEDATA('tbl_tokens', $condition, $updatedata);
      if($is_update){
        $is_updated=$this->user_model->get_joins('tbl_tokens', $condition);
        $this->response(array('status'=>true,'message'=>'Token updated Successfully','result'=>$is_updated),200);
      }
      else {
        $this->response(array('status'=>false,'message'=>'Update Failed','result'=>[]),200);
      }
    }
    else {
      $insertdata=array(
        'userid'=>$userid,
        'role'=>$role,
        'devicetoken '=>$token
      );
      $insert=$this->user_model->INSERTDATA('tbl_tokens',$insertdata);
      if($insert) {
        $this->response(array('status'=>true,'message'=>'Token saved Successfully','result'=>$insert),200);
      }
      else {
        $this->response(array('status'=>false,'message'=>'Token not saved','result'=>'Token not saved'),200);
      }
    }
  }
  else {
    $this->response(array('status'=>false,'message'=>'Operator Id and Token is mandatory','result'=>[]),200);
  }
}


function cronPushNotification($message)
{
  // print_r($message);
  $usertitle = isset($message["title"]) ? $message["title"] : "iCS demo";
  $usermessage = isset($message["message"]) ? $message["message"] : "ics Message";
  $usertoken = isset($message["token"]) ?  $message["token"] : "";
  $firebase_api = "AAAAbfqBdw0:APA91bGgo0RAKWJPDgy2_AS6TyPuDDq9ImriaSYiyEb4d5e-aO2OKxX5UqaOi7UE2snZeK31U_C2OmO2_eWqxYziTOEBJEJwLZA1rSVsqcUcH38MSXBTemOv-Gv3ZKk-Rkdg6YgotIzZ";
  $fields = '{
      "to":"'.$usertoken.'",
      "priority": "high",
      "notification": {
      "title": "'.$usertitle.'",
      "message": "'.$usermessage.'",
      "icon" : "http://server1.dayopeters.com/ICSweb/assets/SampleImages/Logo.png",
      "image" : "http://server1.dayopeters.com/ICSweb/assets/SampleImages/Logo.png",
      "click_action":"FCM_PLUGIN_ACTIVITY",
      "content_available": true
      }
      "data": {
      "badge": 1,
      "sound": "default",
      "alert": "ICS",
      "icon" : "http://server1.dayopeters.com/ICSweb/assets/SampleImages/Logo.png",
      "image" : "http://server1.dayopeters.com/ICSweb/assets/SampleImages/Logo.png"
      }
  }';

  // print_r($fields);
  $url = 'https://fcm.googleapis.com/fcm/send';
  $headers = array( 'Authorization: key=' . $firebase_api, 'Content-Type: application/json' );
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_POSTFIELDS, ($fields));
  $result = curl_exec($ch);
  if($result === FALSE){
      die('Curl failed: ' . curl_error($ch));
  }
  // print_r($result);
  curl_close($ch);
}


# SEND NOTIFICATION
public function sendnotification_get()
{
  $notifiyGuardian = array(
    'title' => 'ICS',
    'message' => 'Hello Testing System',
    'token' => 'dUgHqZ73S4-pdcclwCEDXV:APA91bEUdfTZDnbfUvMRhjJ8AUC9sQ6O-u_sQp7kLqp04Lz6S_ZqUfxq2R3y5hy-eR6jrgaYPA6rXgN-3UI2bjdi35yfl04vb_7_ikGkcEeoky6HLjyF9hw7mbwRJAIf2LscsTeejIWL',
    // 'token' => 'fI1aKgD0S2uqf9CsgYJDh2:APA91bHwpAmUF75L9MBwMpl61IXldeCr4Zyau_FnY3PgRvjVDn36T1DXoIqNxttCQMac8nrpTTbZxeH1BHdtU38vUVRZLsVB6Hut3D4tT16bK3Jv5dbdlfyzRchQzmWQjg4rS69xf-9P',
    'guideid' => 1,
    'angelid' => 1,
    'guardianid' => 1,
    'routeid' => 1,
    'routetype' => 1,
    'type' => 103
  );
  $this->cronPushNotification($notifiyGuardian);
}
public function get_reading($userid, $water_right, $meter_reading)
{
    $column = [
        '*, GROUP_CONCAT(tbl_meter_reading.id) as new_id , GROUP_CONCAT(tbl_meter_reading.meter_reading) as new_reading, GROUP_CONCAT(tbl_meter_reading.remaining) as new_remaining',
    ];
    $group = ['meter_id'];
    $where = ['userid' => $userid, 'water_right' => $water_right];

    $join = [
        [
            'table' => 'tbl_meter_connections',
            'condition' =>
                'tbl_meter_reading.meter_id=tbl_meter_connections.id',
            'jointype' => 'LEFT',
        ],

        [
            'table' => 'tbl_water_right_alloc',
            'condition' =>
                'tbl_water_right_alloc.id=tbl_meter_connections.water_right',
            'jointype' => 'LEFT',
        ],
    ];

    $meters = $this->user_model->get_joins(
        'tbl_meter_reading',
        $where,
        $join,
        $column,
        '',
        $group
    );

    return $meters;
}


public function graph_values_post()
{
  $status = $this->input->get('status') ? $this->input->get('status') : "";
  $channel = $this->input->get('channel') ? $this->input->get('channel') : "";

  $current_date=date('Y-m-d');
  $tommorow=date("Y-m-d", time() + 86400);

  $data= array(array('start'=>'00:00','end'=>'01:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $current_date.' 00:00'),'y'=>0)),
  array('start'=>'01:00','end'=>'02:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $current_date.' 01:00'),'y'=>0)),array('start'=>'02:00','end'=>'03:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $current_date.' 02:00'),'y'=>0))
 ,array('start'=>'03:00','end'=>'04:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $current_date.' 03:00'),'y'=>0)),array('start'=>'04:00','end'=>'05:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $current_date.' 04:00'),'y'=>0)),array('start'=>'05:00','end'=>'06:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $current_date.' 05:00'),'y'=>0)),array('start'=>'06:00','end'=>'07:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $current_date.' 06:00'),'y'=>0)),array('start'=>'07:00','end'=>'08:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $current_date.' 07:00'),'y'=>0))
 ,array('start'=>'08:00','end'=>'09:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $current_date.' 08:00'),'y'=>0)),array('start'=>'09:00','end'=>'10:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $current_date.' 09:00'),'y'=>0)),array('start'=>'10:00','end'=>'11:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $current_date.' 010:00'),'y'=>0)),array('start'=>'11:00','end'=>'12:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $current_date.' 11:00'),'y'=>0)),array('start'=>'12:00','end'=>'13:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $current_date.' 12:00'),'y'=>0)),array('start'=>'13:00','end'=>'14:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $current_date.' 13:00'),'y'=>0))
 ,array('start'=>'14:00','end'=>'15:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $current_date.' 14:00'),'y'=>0)),array('start'=>'15:00','end'=>'16:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $current_date.' 15:00'),'y'=>0)),array('start'=>'16:00','end'=>'17:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $current_date.' 16:00'),'y'=>0)),array('start'=>'17:00','end'=>'18:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $current_date.' 17:00'),'y'=>0)),array('start'=>'18:00','end'=>'19:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $current_date.' 18:00'),'y'=>0)),array('start'=>'19:00','end'=>'20:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $current_date.' 19:00'),'y'=>0))
 ,array('start'=>'20:00','end'=>'21:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $current_date.' 20:00'),'y'=>0)),array('start'=>'21:00','end'=>'22:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $current_date.' 21:00'),'y'=>0)),array('start'=>'22:00','end'=>'23:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $current_date.' 22:00'),'y'=>0)),array('start'=>'23:00','end'=>'00:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $current_date.' 23:00'),'y'=>0)));
 $datas= array(array('start'=>'00:00','end'=>'01:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $tommorow.' 00:00'),'y'=>0)),
 array('start'=>'01:00','end'=>'02:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $tommorow.' 01:00'),'y'=>0)),array('start'=>'02:00','end'=>'03:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $tommorow.' 02:00'),'y'=>0))
,array('start'=>'03:00','end'=>'04:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $tommorow.' 03:00'),'y'=>0)),array('start'=>'04:00','end'=>'05:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $tommorow.' 04:00'),'y'=>0)),array('start'=>'05:00','end'=>'06:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $tommorow.' 05:00'),'y'=>0)),array('start'=>'06:00','end'=>'07:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $tommorow.' 06:00'),'y'=>0)),array('start'=>'07:00','end'=>'08:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $tommorow.' 07:00'),'y'=>0))
,array('start'=>'08:00','end'=>'09:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $tommorow.' 08:00'),'y'=>0)),array('start'=>'09:00','end'=>'10:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $tommorow.' 09:00'),'y'=>0)),array('start'=>'10:00','end'=>'11:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $tommorow.' 10:00'),'y'=>0)),array('start'=>'11:00','end'=>'12:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $tommorow.' 11:00'),'y'=>0)),array('start'=>'12:00','end'=>'13:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $tommorow.' 12:00'),'y'=>0)),array('start'=>'13:00','end'=>'14:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $tommorow.' 13:00'),'y'=>0))
,array('start'=>'14:00','end'=>'15:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $tommorow.' 14:00'),'y'=>0)),array('start'=>'15:00','end'=>'16:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $tommorow.' 15:00'),'y'=>0)),array('start'=>'16:00','end'=>'17:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $tommorow.' 16:00'),'y'=>0)),array('start'=>'17:00','end'=>'18:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $tommorow.' 17:00'),'y'=>0)),array('start'=>'18:00','end'=>'19:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $tommorow.' 18:00'),'y'=>0)),array('start'=>'19:00','end'=>'20:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $tommorow.' 19:00'),'y'=>0))
,array('start'=>'20:00','end'=>'21:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $tommorow.' 20:00'),'y'=>0)),array('start'=>'21:00','end'=>'22:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $tommorow.' 21:00'),'y'=>0)),array('start'=>'22:00','end'=>'23:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $tommorow.' 22:00'),'y'=>0)),array('start'=>'23:00','end'=>'00:00','flowRate'=>0,'orders'=>array(),'graph'=>array('x'=>(  $tommorow.' 23:00'),'y'=>0)));

  $result=array();
  $val1=array();
  $val2=array();

  $upcoming_orders=array();
  $date = date('Y-m-d h:i:s');

    $site_url = base_url().'assets/meterprofiles/';
    $columns = array('tbl_water_orders.*','tbl_meter_connections.id as meterid','tbl_meter_connections.meter_name as meter_name','tbl_meter_connections.serial_number as serial_number','tbl_meter_connections.property as property','tbl_meter_connections.id as meterid','tbl_meter_connections.userid as meteruserid', "CONCAT('$site_url', tbl_meter_connections.image) as meterimage", 'tbl_channels.channel_name as channel_name', 'tbl_metertype.type as type','tbl_water_right_alloc.wr_number as wr_number','tbl_water_right_alloc.wr_volume as wr_volume','tbl_users.username as username','tbl_users.contact_name as contact_name','tbl_users.email as email');
      if(!empty($channel))
      {
        $where=array('tbl_meter_connections.channel_name'=>$channel,'tbl_water_orders.isActive'=>1);


      }else{
        $where=array('tbl_water_orders.isActive'=>1);

        }

    $join=array(
      array( 'table' => 'tbl_meter_connections', 'condition' => 'tbl_meter_connections.id=tbl_water_orders.meter', 'jointype' => 'LEFT' ),
      array( 'table' => 'tbl_channels', 'condition' => 'tbl_channels.id=tbl_meter_connections.channel_name', 'jointype' => 'LEFT' ),
      array( 'table' => 'tbl_metertype', 'condition' => 'tbl_metertype.id=tbl_meter_connections.meter_type', 'jointype' => 'LEFT' ),
      array( 'table' => 'tbl_water_right_alloc', 'condition' => 'tbl_water_right_alloc.id=tbl_meter_connections.water_right', 'jointype' => 'LEFT' ),
      array( 'table' => 'tbl_users', 'condition' => 'tbl_users.id=tbl_water_orders.userid', 'jointype' => 'LEFT' ),
    );
    $orderExists=$this->user_model->get_joins('tbl_water_orders',$where, $join, $columns,'','','tbl_water_orders.startTime');

    if($orderExists){

      foreach($orderExists as $key=>$orders)
      {

        $dt = new DateTime($orders['startTime']);

        $startdate=$dt->format('Y-m-d');

        $dt = new DateTime($orders['endTime']);

        $enddate=$dt->format('Y-m-d');
        $dt = new DateTime($orders['endTime']);

        $endTime = $dt->format('H');
        $dt = new DateTime($orders['startTime']);

        $startTime = $dt->format('H');
        if($startdate<$current_date && $enddate<$current_date){

          }
          else{

        if($startdate<$current_date && $enddate==$current_date)
        {


          $data1=array('start'=>0,'end'=>$endTime+1,'flowRate'=>$orders['flowRate'],'date'=>$enddate,'meter_name'=>$orders['meter_name'],'channel_name'=>$orders['channel_name'],'username'=>$orders['username']);
          array_push($result,$data1);

        }
        else if($startdate<$current_date && $enddate>$current_date)
        {
          $data1=array('start'=>0,'end'=>24,'flowRate'=>$orders['flowRate'],'date'=>$current_date,'meter_name'=>$orders['meter_name'],'channel_name'=>$orders['channel_name'],'username'=>$orders['username']);
          array_push($result,$data1);

          if($enddate==$tommorow)
          {
            $data1=array('start'=>0,'end'=>$endTime,'flowRate'=>$orders['flowRate'],'date'=>$tommorow,'meter_name'=>$orders['meter_name'],'channel_name'=>$orders['channel_name'],'username'=>$orders['username']);
            array_push($result,$data1);
          }else if($enddate>$tommorow)
          {
            $data1=array('start'=>0,'end'=>24,'flowRate'=>$orders['flowRate'],'date'=>$tommorow,'meter_name'=>$orders['meter_name'],'channel_name'=>$orders['channel_name'],'username'=>$orders['username']);
            array_push($result,$data1);
          }


        }else if($startdate==$current_date && $enddate==$current_date){
          $data1=array('start'=>$startTime,'end'=>$endTime,'flowRate'=>$orders['flowRate'],'date'=>$current_date,'meter_name'=>$orders['meter_name'],'channel_name'=>$orders['channel_name'],'username'=>$orders['username']);
          array_push($result,$data1);


          }else if($startdate>$current_date){

            if($startdate==$tommorow && $enddate==$tommorow)
            {
              $data1=array('start'=>$startTime+1,'end'=>$endTime+1,'flowRate'=>$orders['flowRate'],'date'=>$tommorow,'meter_name'=>$orders['meter_name'],'channel_name'=>$orders['channel_name'],'username'=>$orders['username']);
              array_push($result,$data1);
            }else if($startdate==$tommorow && $enddate>$tommorow){
              $data1=array('start'=>$startTime,'end'=>24,'flowRate'=>$orders['flowRate'],'date'=>$tommorow,'meter_name'=>$orders['meter_name'],'channel_name'=>$orders['channel_name'],'username'=>$orders['username']);
              array_push($result,$data1);

            }


            }
            if($startdate==$current_date && $enddate==$tommorow)
            {
              $data1=array('start'=>$startTime,'end'=>24,'flowRate'=>$orders['flowRate'],'date'=>$current_date,'meter_name'=>$orders['meter_name'],'channel_name'=>$orders['channel_name'],'username'=>$orders['username']);
              array_push($result,$data1);

                $data1=array('start'=>0,'end'=>$endTime,'flowRate'=>$orders['flowRate'],'date'=>$tommorow,'meter_name'=>$orders['meter_name'],'channel_name'=>$orders['channel_name'],'username'=>$orders['username']);
              array_push($result,$data1);
            }
}}


      }



foreach ($result as $key => $value) {
// code...
if($value['date']==$current_date)
{
array_push($val1,$value);
}
if($value['date']==$tommorow)
{
array_push($val2,$value);

}
}

$orders1=array();
$orders2=array();

foreach ($val1 as $key => $value) {


for ($i=$value['start']; $i < $value['end']; $i++) {
$data[$i]['flowRate']=$data[$i]['flowRate']+$value['flowRate'];
$data[$i]['date']=$value['date'];
$time=   $value['date'].' '.$data[$i]['start'];
$data[$i]['orders']=$this->check_flowrate($data[$i]['flowRate'],$val1);
$data[$i]['graph']=array('x'=>$time,'y'=>$data[$i]['flowRate']);
}
// code...
}
foreach ($val2 as $key => $value) {
for ($i=$value['start']; $i < $value['end']; $i++) {
$datas[$i]['flowRate']=$datas[$i]['flowRate']+$value['flowRate'];
$datas[$i]['date']=$value['date'];
$time=   $value['date'].' '.$datas[$i]['start'];
$datas[$i]['orders']=$this->check_flowrate($datas[$i]['flowRate'],$val2);


// $time= str_replace( array( '-', ':'), ',', $time);
$datas[$i]['graph']=array('x'=>$time,'y'=>$datas[$i]['flowRate']);
}
// code...
}

if($status==0)
{
  $this->response(array('status'=>true,'message'=>'Token saved Successfully','result'=>$data),200);

  }
  else {
    $this->response(array('status'=>true,'message'=>'Token saved Successfully','result'=>$datas),200);

  }

// exit;
}
function check_flowrate($total_flowrate,$orders)
{

$ord=array();
$sum=0;
for($i=0;$i<count($orders);$i++)
{
  $sum=$sum+$orders[$i]['flowRate'];
  if($sum<=$total_flowrate)
  {
    array_push($ord,$orders[$i]);

  }
  }

  return $ord;
}

}
