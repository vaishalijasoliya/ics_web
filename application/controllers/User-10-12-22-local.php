<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->library("pagination");
    if ($this->session->userdata('user_id') == ""  || $this->session->userdata('role') !== "user") {
      redirect('Authentication/login');
    }


    //SMTP & mail configuration
    $config = array(
      'protocol' => 'sendmail',
      'smtp_host' => 'smtp.office365.com',
      'smtp_port' => 587,
      'smtp_user' => 'info@intelligentcanals.com',
      'smtp_pass' => '1C$1nf0#5',
      'mailtype' => 'html',
      'charset' => 'utf-8'
    );
    $this
      ->email
      ->initialize($config);
    $this
      ->email
      ->set_mailtype("html");
    $this
      ->email
      ->set_newline("\r\n");
    $this
      ->email
      ->from('info@intelligentcanals.com', 'ICS App');
  }
  public function index()
  {
    $id = $this->session->userdata('user_id');
    $where = array('id' => $id);
    $data['data'] = $this->user_model->get_joins('tbl_users', $where);
    $data['page_title'] = 'Dashboard';
    $this->load->view('User/dashboard', $data);
  }

  public function add_water_right()
  {
    if ($this->input->post('save_order') == 'save') {
      $id = $this->session->userdata('user_id');
      $meter_name = $this->input->post('meter_name');
      $start_date = $this->input->post('start_date');
      $flow_rate = $this->input->post('flow_rate');
      $end_date = $this->input->post('end_date');
      $duration = $this->input->post('duration');
      $volume = $this->input->post('volume');

      $needle   = "NaN";

      if (strpos($duration, $needle) !== false  || strpos($volume, $needle) !== false) {

        $this->session->set_flashdata('error', 'Please enter valid Values');
        redirect($_SERVER['HTTP_REFERER']);
      } else {
        $insert = array(
          'userid' => $id,
          'meter' => $meter_name,
          'startTime' => date('Y-m-d H:i', strtotime($start_date)),
          'flowRate' => $flow_rate,
          'duration' => $duration,
          'endTime' => date('Y-m-d H:i', strtotime($end_date)),
          'totalVolume' => $volume,
        );
        $where = array('userid' => $id, 'isActive' => 1);
        $col = array(
          'userid',
          'meter',
          'startTime',
          'flowRate',
          'duration',
          'endTime',
          'totalVolume'
        );
        $users_data = $this->user_model->get_joins('tbl_water_orders', $where, '', $col);

        if (in_array($insert, $users_data)) {
          $this->session->set_flashdata('error', 'Order already exists for this time');
          redirect($_SERVER['HTTP_REFERER']);
        } else {
          $insert_data = $this->user_model->INSERTDATA('tbl_water_orders', $insert);
          if ($insert_data) {
            /* send notifications to operator*/

            $whereRole=array('role'=>'operator');
                  $tokenExists=$this->user_model->get_joins('tbl_tokens',$whereRole);

                  if($tokenExists){
                    foreach($tokenExists as $tokens){
                      // get nnotification only once while app is not running 
                      if($tokens['push_status'] == 'active' && $tokens['app_status'] == 'inactive'){
                          $notifiyOperator = array(
                            'title' => 'New Water Order Request',
                            'message' => 'New Water Order Request',
                            'token' => $tokens['devicetoken'],
                            'type' => 101
                          );
                          $this->cronPushNotification($notifiyOperator);
                          $condition = array(
                            'userid' => $tokens['userid'],
                            'role' => $tokens['role']
                          );
                          $updatedata = array(
                            'push_status' => 'inactive'
                          );
                          $is_update = $this->user_model->UPDATEDATA('tbl_tokens', $condition, $updatedata);
                          if($is_update){
                              $ispushstatus = true;
                          }
                              
                          
                      }
                      
                    }
                  }

                  $whereuser=array('role'=>'user', 'userid'=> $id);
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


            $insert = array(
              'senderid' => $id,
              'senderrole' => 'user',
              'receiverid' => '',
              'title' => 'Water Order',
              'message' => 'New Water Order Requested',
              'status' => 'Pending'
            );
            $this->user_model->INSERTDATA('tbl_notifications', $insert);
          }
          $this->session->set_flashdata('success', 'Order placed successfully please check again for status');
          redirect('user/history_orders');
        }
      }
    }
    $id = $this->session->userdata('user_id');
    $where = array('userid' => $id);
    $data['meter_names'] = $this->user_model->get_joins('tbl_meter_connections', $where);
    $data['page_title'] = 'Add Water Order';
    $data['page_name'] = 'User/add_water_order';

    $this->load->view('User/index', $data);
  }

  function cronPushNotification($message)
  {
    // print_r($message);
    $usertitle = isset($message["title"]) ? $message["title"] : "iCS demo";
    $usermessage = isset($message["message"]) ? $message["message"] : "ics Message";
    $usertoken = isset($message["token"]) ?  $message["token"] : "";
    $firebase_api = "AAAABEOAJ3E:APA91bGHYp7fQWcssaV5krcfSHyy-2ML3k4_mjMaTBQIeDVJFj-JyzwVLfO6fjRkRusmwbd-zj2njjT7aOjAMLI6W2GfKlYhwkUvsIjvFu5l1azRsLKzZm5q13ciFbdNBA6ssqNIWLId";
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
  

  public function history_orders()
  {
    $id = $this->session->userdata('user_id');

    $where = array('tbl_water_orders.userid' => $id, 'tbl_water_orders.isActive =' => 0);

    $join = array(
      array(
        'table' => 'tbl_meter_connections',
        'condition' => 'tbl_meter_connections.id=tbl_water_orders.meter',
        'jointype' => 'LEFT'
      )

    );
    $col = array('meter_name', 'startTime', 'flowRate', 'duration', 'endTime', 'totalVolume', 'tbl_water_orders.isActive');

    $data['water_orders'] = $this->user_model->get_joins('tbl_water_orders', $where, $join, $col, '', '', 'tbl_water_orders.id DESC');

    $data['page_title'] = 'Orders';
    $data['page_name'] = 'User/orders_history';

    $this->load->view('User/index', $data);
  }

  public function archive_history_orders()
  {
    $id = $this->session->userdata('user_id');

    $date = date('Y-m-d');
    $archivedate = date('Y-m-d', (strtotime('-2 day', strtotime($date))));

    $where = array(
      'tbl_water_orders.userid' => $id,
      'tbl_water_orders.isActive !=' => 0,
      'tbl_water_orders.orderedDate <=' => $archivedate,
    );

    $join = array(
      array(
        'table' => 'tbl_meter_connections',
        'condition' => 'tbl_meter_connections.id=tbl_water_orders.meter',
        'jointype' => 'LEFT'
      )

    );
    $col = array('meter_name', 'startTime', 'flowRate', 'duration', 'endTime', 'totalVolume', 'tbl_water_orders.isActive');

    $data['water_orders'] = $this->user_model->get_joins('tbl_water_orders', $where, $join, $col, '', '', 'tbl_water_orders.id DESC');

    $data['page_title'] = 'Orders';
    $data['page_name'] = 'User/orders_history';

    $this->load->view('User/index', $data);
  }

  public function upcoming_orders()
  {
    $data['page_title'] = 'Upcoming/Current Orders';
    $data['page_name'] = 'User/upcoming_orders';

    $this->load->view('User/index', $data);
  }
  public function client_details()
  {
    $ud_detail_onesubmit = $this->input->post('ud_detail_onesubmit');
    if ($ud_detail_onesubmit == 'Save changes') {
      $userid = $this->input->post('userid');
      $username = $this->input->post('username');
      $contact_name = $this->input->post('contact_name');
      $address = $this->input->post('address');
      $password = base64_encode($this->input->post('password'));
      $phone = $this->input->post('phone');
      $mobile = $this->input->post('mobile');
      $stockdomestic = $this->input->post('stockdomestic') != "" ? $this
        ->input
        ->post('stockdomestic') : 0;
      $where = array('id' => $_SESSION['user_id']);
      $updatedata = array(
        'username' => $username, 'contact_name' => $contact_name,
        'address' => $address, 'password' => $password, 'phone' => $phone, 'contact' => $mobile, 'stock_supply' => $stockdomestic
      );

      $is_update = $this
        ->user_model
        ->UPDATEDATA('tbl_users', $where, $updatedata);
      if ($is_update) {
        $this
          ->session
          ->set_flashdata('success', 'User Details updated sucessfully');
      } else {
        $this
          ->session
          ->set_flashdata('error', 'Error in updating User');
      }
    }
    $data['page_title'] = 'Client Details';
    $data['page_name'] = 'User/client_details';
    $where = array('id' => $_SESSION['user_id']);
    $data['user_details'] = $this->user_model->get_joins('tbl_users', $where);

    $join = array(
      array(
        'table' => 'tbl_channels',
        'condition' => 'tbl_channels.id=tbl_meter_connections.channel_name',
        'jointype' => 'LEFT'
      ),
      array(
        'table' => 'tbl_water_right_alloc',
        'condition' => 'tbl_water_right_alloc.id=tbl_meter_connections.water_right',
        'jointype' => 'LEFT'
      )
    );
    $whereID = array('userid' => $_SESSION['user_id']);
    $data['meter_details'] = $this->user_model->get_joins('tbl_meter_connections', $whereID, $join);
    $whereID = array('user_id' => $_SESSION['user_id']);
    $data['water_rights'] = $this->user_model->get_joins('tbl_water_right_alloc', $whereID);

    $this->load->view('User/index', $data);
  }
  public function usage()
  {
    $userid = $this->session->userdata('user_id');
    $meter_name = $this->input->post('meter_name');
    if ($meter_name != "") {
      $whereUser = array(
        'tbl_meter_connections.userid' => $userid,
        'tbl_meter_connections.id' => $meter_name
      );
    } else {
      $whereUser = array(
        'tbl_meter_connections.userid' => $userid
      );
    }
    $where = array('userid' => $userid);
    $group = array('tbl_meter_connections.id');
    $join = array(
      array('table' => 'tbl_meter_reading', 'condition' => 'tbl_meter_reading.meter_id=tbl_meter_connections.id', 'jointype' => 'LEFT'),
      array('table' => 'tbl_channels', 'condition' => 'tbl_channels.id=tbl_meter_connections.channel_name', 'jointype' => 'LEFT'),
      array('table' => 'tbl_metertype', 'condition' => 'tbl_metertype.id=tbl_meter_connections.meter_type', 'jointype' => 'LEFT'),
      array('table' => 'tbl_water_right_alloc', 'condition' => 'tbl_water_right_alloc.id=tbl_meter_connections.water_right', 'jointype' => 'LEFT')
    );
    $data['usage'] = $this->user_model->get_joins('tbl_meter_connections', $whereUser, $join, '', '', $group);
    $data['meter_name'] = $this->user_model->get_joins('tbl_meter_connections', $where);

    $data['page_title'] = 'Usage Information';
    $data['page_name'] = 'User/usage_user';

    $this->load->view('User/index', $data);
  }

  public function notification()
  {
    $id = $this->session->userdata('user_id');

    $date = date('Y-m-d');
    $archivedate = date('Y-m-d', (strtotime('-1 day', strtotime($date))));

    $where = array(
      'senderid' => $id,
      'status =' => 'Pending',
      'tbl_notifications.date >=' => $archivedate,
    );

    $column = array('tbl_notifications.*', 'tbl_users.username as sendername', 'tbl_operator.username as username');
    $join = array(
      array(
        'table' => 'tbl_users',
        'condition' => 'tbl_notifications.senderid=tbl_users.id',
        'jointype' => 'LEFT'
      ),
      array(
        'table' => 'tbl_operator',
        'condition' => 'tbl_notifications.receiverid=tbl_operator.id',
        'jointype' => 'LEFT'
      ),
    );

    $data['notifications'] = $this->user_model->get_joins('tbl_notifications', $where, $join, $column, '', '', 'tbl_notifications.id DESC');

    $data['page_title'] = 'Notification';
    $data['page_name'] = 'User/notification';


    $this->load->view('User/index', $data);
  }

  public function notification_archive()
  {
    $id = $this->session->userdata('user_id');
    $where = array('senderid' => $id, 'status !=' => 'Pending');

    $column = array('tbl_notifications.*', 'tbl_users.username as sendername', 'tbl_operator.username as username');
    $join = array(
      array(
        'table' => 'tbl_users',
        'condition' => 'tbl_notifications.senderid=tbl_users.id',
        'jointype' => 'LEFT'
      ),
      array(
        'table' => 'tbl_operator',
        'condition' => 'tbl_notifications.receiverid=tbl_operator.id',
        'jointype' => 'LEFT'
      ),
    );

    $data['notifications'] = $this->user_model->get_joins('tbl_notifications', $where, $join, $column, '', '', 'tbl_notifications.id DESC');

    $data['page_title'] = 'Notification';
    $data['page_name'] = 'User/notification';


    $this->load->view('User/index', $data);
  }
  public function contact()
  {
    $data['page_title'] = 'Contact';
    $data['page_name'] = 'User/contact';

    $this->load->view('User/index', $data);
  }

  public function contact_mail()
  {
    $name = $this
      ->input
      ->post('name');
    $email = $this
      ->input
      ->post('email');
    $subject = $this
      ->input
      ->post('subject');
    $message = $this
      ->input
      ->post('message');

    $data = array(
      'name' => $name,
      'email' => $email,
      'subject' => $subject,
      'message' => $message
    );
    $mesg = $this
      ->load
      ->view('mail', $data, true);

    $this
      ->email
      ->to('info@intelligentcanals.com', $name);
    $this
      ->email
      ->subject($subject);
    $this
      ->email
      ->message($mesg);
    if ($this
      ->email
      ->send()
    ) {
      $this
        ->session
        ->set_flashdata('success', 'Mail Send Sucessfully');
    }

    redirect($_SERVER['HTTP_REFERER']);
  }

  public function message_count()
  {
    $id = $this->session->userdata('user_id');
    $where = array('senderid' => $id, 'status !=' => 'Pending', 'is_read' => 0);

    $column = array('tbl_notifications.*', 'tbl_users.username as sendername', 'tbl_operator.username as username');
    $join = array(
      array(
        'table' => 'tbl_users',
        'condition' => 'tbl_notifications.senderid=tbl_users.id',
        'jointype' => 'LEFT'
      ),
      array(
        'table' => 'tbl_operator',
        'condition' => 'tbl_notifications.receiverid=tbl_operator.id',
        'jointype' => 'LEFT'
      ),
    );


    $data = $this->user_model->get_joins('tbl_notifications', $where, $join, $column, '', '', 'tbl_notifications.id DESC');
    print_r(json_encode(count($data)));
  }

  public function update_message_count()
  {

    $id = $this->session->userdata('user_id');
    $where = array('senderid' => $id, 'status !=' => 'Pending', 'is_read' => 0);
    $update = array('is_read' => 1);
    $data = $this->user_model->UPDATEDATA('tbl_notifications', $where, $update);
    print_r(json_encode($data));
  }

  public function sendNotification()
  {


    $value = array('title' => 'Test Title', 'message' => 'This is my test message', 'token' => 'fHEid1gAAx7C9TVB7AMk-D:APA91bE_96VbUu1yig1UQr1cc3f2yVQVQWTiaMe80opRTvB0q1kN_7ih76LzTztfg_50Z-eUkp6Ftf2UEewO87H4cgEWutMU6JVuZG7_Srwq-aAzbh_89izV4vLQBQk53oE2QT1LTHak');

    $title = $value['title'];
    $message = $value['message'];
    $fbasetoken = $value['token'];

    // echo  $fbasetoken;
    // exit;
    // $title = $_GET['title'];
    // $message = isset($_GET['message'])?$_GET['message']:'';


    $firebase_api = 'AAAAB3h3etU:APA91bF4T2VMFwVLiPpJA1_h5TJTJ62kwBOe7HrUwGey4qS9-2KdNz0H2pUyTFbLeI6VEr6jB-yhyFu9l-gkVyftfTjuVhlAkAelh3yDZ9nn7ArqtfJ9OjsdkVYVFtYQt3JFSIpCW-NZ';

    //$firebase_token = $_GET['firebase_token'];
    // $firebase_token = explode(',',$_GET['firebase_token']);
    $firebase_token = explode(',', $fbasetoken);

    foreach ($firebase_token as $firebase_token) {

      $fields = '{
    "to" : "' . $firebase_token . '",
    "notification" : {
        "title" :"test from server",
        "body" :"test lorem ipsum"
    }
}';


      // Set POST variables
      $url = 'https://fcm.googleapis.com/fcm/send';
      $headers = array(
        'Authorization: key=' . $firebase_api,
        'Content-Type: application/json'
      );

      // Open connection
      $ch = curl_init();

      // Set the url, number of POST vars, POST data
      curl_setopt($ch, CURLOPT_URL, $url);

      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      // Disabling SSL Certificate support temporarily
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

      curl_setopt($ch, CURLOPT_POSTFIELDS, ($fields));

      // Execute post
      $result = curl_exec($ch);
      if ($result === FALSE) {
        die('Curl failed: ' . curl_error($ch));
      }

      // Close connection
      curl_close($ch);
      print_r($result);
    }
  }

  public function logout()
  {
    $this->session->unset_userdata('user_id');
    $this->session->sess_destroy();
    redirect('welcome');
  }
}
