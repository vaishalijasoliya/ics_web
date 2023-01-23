<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Operator extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this
            ->load
            ->library("pagination");
        if (
            $this
            ->session
            ->userdata('user_id') == "" || $this
            ->session
            ->userdata('role') !== "operator"
        ) {
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
        $id = $this
            ->session
            ->userdata('user_id');
        $where = array(
            'id' => $id
        );
        $data['data'] = $this
            ->user_model
            ->get_joins('tbl_operator', $where);
        $data['page_title'] = 'Dashboard';
        // $data['page_name']='Operator/dashboard';
        // $this->load->view('Operator/index',$data);
        $this
            ->load
            ->view('Operator/dashboard', $data);
    }

    public function isEmailExists()
    {
        $email = $this
            ->input
            ->post('email');
        $whereEmail = array(
            'email' => $email
        );
        $emailExists = $this
            ->user_model
            ->get_joins('tbl_operator', $whereEmail);
        if ($emailExists) {
            echo "* Email already exists";
        } else {
            return false;
        }
    }
    /* SYSTEM INFORMATIONS */
    public function admin_user_config()
    {
        if (($this
            ->input
            ->post('createoperator')) == "save") {
            $username = $this
                ->input
                ->post('username');
            $email = $this
                ->input
                ->post('email');
            $password = $this
                ->input
                ->post('password');
            $whereEmail = array(
                'email' => $email
            );
            $emailExists = $this
                ->user_model
                ->get_joins('tbl_operator', $whereEmail);
            if ($emailExists) {
                $this
                    ->session
                    ->set_flashdata('error', 'Email already exists');
            } else {
                $field = array(
                    'username' => $username,
                    'email' => $email,
                    'password' => base64_encode($password)
                );
                $insert = $this
                    ->user_model
                    ->INSERTDATA('tbl_operator', $field);
                if ($insert) {
                    $this
                        ->session
                        ->set_flashdata('success', 'Operator added Sucessfully');
                } else {
                    $this
                        ->session
                        ->set_flashdata('error', 'Error in adding Operator');
                }
            }
        }
        if (($this
            ->input
            ->post('updateoperator')) == "save") {

            $id = $this
                ->input
                ->post('id');
            $username = $this
                ->input
                ->post('username');
            $email = $this
                ->input
                ->post('email');
            $password = $this
                ->input
                ->post('password');
            $whereEmail = array(
                'email' => $email
            );
            $emailExists = $this
                ->user_model
                ->get_joins('tbl_operator', $whereEmail);
            if ($emailExists) {
                $condition = array(
                    'id' => $id
                );
                $updatedata = array(
                    'username' => $username,
                    'password' => base64_encode($password),
                    'email' => $email
                );
                $is_update = $this
                    ->user_model
                    ->UPDATEDATA('tbl_operator', $condition, $updatedata);
                if ($is_update) {
                    $this
                        ->session
                        ->set_flashdata('success', 'Operator updated sucessfully on existing email');
                } else {
                    $this
                        ->session
                        ->set_flashdata('error', 'Error in updating Operator');
                }
            } else {
                $condition = array(
                    'id' => $id
                );
                $updatedata = array(
                    'username' => $username,
                    'email' => $email,
                    'password' => base64_encode($password)
                );
                $is_update = $this
                    ->user_model
                    ->UPDATEDATA('tbl_operator', $condition, $updatedata);
                if ($is_update) {
                    $this
                        ->session
                        ->set_flashdata('success', 'Operator updated Sucessfully');
                } else {
                    $this
                        ->session
                        ->set_flashdata('error', 'Error in updating Operator');
                }
            }
        }
        if (($this
            ->input
            ->post('deleteoperator')) == "save") {
            $id = $this
                ->input
                ->post('id');
            $condition = array(
                'id' => $id
            );
            $is_delete = $this
                ->user_model
                ->DELETEDATA('tbl_operator', $condition);
            if ($is_delete) {
                $this
                    ->session
                    ->set_flashdata('success', 'Operator Deleted Sucessfully');
            } else {
                $this
                    ->session
                    ->set_flashdata('error', 'Error in deleting Operator');
            }
        }
        $data['data'] = $this
            ->user_model
            ->get_joins('tbl_operator');
        $data['page_title'] = 'Admin User Config';
        $data['page_name'] = 'Operator/admin_user_config';
        $this
            ->load
            ->view('Operator/index', $data);
    }

    public function water_usage_report()
    {
        $data['page_title'] = 'Water Usage Report';
        $data['page_name'] = 'Operator/water_usage_report';
        $this
            ->load
            ->view('Operator/index', $data);
    }
    public function system_total_report()
    {
        $data['page_title'] = 'System Total Reports';
        $data['page_name'] = 'Operator/system_total_report';
        $this
            ->load
            ->view('Operator/index', $data);
    }
    public function transfers()
    {
        if ($this->input->post('add_transfer') == 'transfer') {

            $tr_username_1 =  $this->input->post('tr_username_1');
            $tr_username_2 =  $this->input->post('tr_username_2');
            $tr_water_right_1 =  $this->input->post('tr_water_right_1');
            $tr_water_right_2 =  $this->input->post('tr_water_right_2');
            $tr_duration =  $this->input->post('tr_duration');
            $tr_volume =  $this->input->post('tr_volume');
            $tr_season =  $this->input->post('tr_season');
            $tr_permanent_check =  $this->input->post('tr_permanent_check');
            $tr_wr1_vol = -$tr_volume;
            $tr_wr2_vol = $tr_volume;
            $this->user_model->update_water_right($tr_water_right_1, $tr_wr1_vol);
            $this->user_model->update_water_right($tr_water_right_2, $tr_wr2_vol);

            $this->user_model->update_model($tr_water_right_1, $tr_volume);
            $this->user_model->update_model($tr_water_right_2, $tr_wr2_vol);

            $insertdata = array(
                'userid_1' => $tr_username_1, 'tbl_waterright_1' => $tr_water_right_1, 'duration' => $tr_duration,
                'season' => $tr_season, 'volume' => $tr_volume, 'userid_2' => $tr_username_2, 'tbl_waterright_2' => $tr_water_right_2
            );
            $this->user_model->INSERTDATA('tbl_transfer_details', $insertdata);
        }
        $data['page_title'] = 'Transfers';
        $data['page_name'] = 'Operator/transfers';
        $this
            ->load
            ->view('Operator/index', $data);
    }

    public function get_volumeallocation()
    {

        $waterid = $this->input->get('waterid');
        $where = array('id' => $waterid);
        $meters = $this->user_model->get_joins('tbl_water_right_alloc', $where);
        print_r(json_encode($meters));
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


    /* WATER USERS */
    public function usage()
    {

        if (($this
            ->input
            ->post('add_meter_readings')) == "save") {


            $meter_id = $this->input->post('meter_id');
            $meter_reading = $this->input->post('meter_reading');
            $date_of_reading = $this->input->post('date_of_reading');
            $channel = $this->input->post('channel');
            $charge_code = $this->input->post('charge_code');

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
                    if ($charge_code == 5) {
                        $meter_vol = 0;
                        $rmain = $meter_exists[0]['wr_volume'];
                    } else {
                        $meter_vol = $meter_reading;
                        $rmain = $meter_exists[0]['wr_volume'] - $meter_reading;
                    }

                    $insert = [
                        'meter_id' => $meter_id,
                        'meter_reading' => $meter_reading,
                        'meter_vol' => $meter_vol,
                        'remaining' =>
                        $rmain,
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
                        if ($charge_code == 5) {

                            $remain = $last_remaining;
                        } else {

                            $remain = $last_remaining - $meter_reading;
                        }
                        $where = ['meter_id' => $id];
                        $update = ['remaining' => $remain];
                        $this->user_model->UPDATEDATA(
                            'tbl_meter_reading',
                            $where,
                            $update
                        );
                    }
                    if ($charge_code == 5) {
                        $meter_vol = 0;
                    } else {
                        $meter_vol = $meter_reading;
                    }
                    $insert = [
                        'meter_id' => $meter_id,
                        'meter_reading' => $meter_reading,
                        'meter_vol' => $meter_vol,
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
                        if ($charge_code == 5) {
                            $remain = $last_remaining;
                        } else {
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
                if ($charge_code == 5) {
                    $meter_vol = 0;
                } else {
                    $meter_vol = $reading;
                }
                $insert = [
                    'meter_id' => $meter_id,
                    'meter_reading' => $meter_reading,
                    'meter_vol' => $meter_vol,
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

            if ($is_update) {
                $this->session->set_flashdata(
                    'success',
                    'Meter Added sucessfully'
                );
            } else {
                $this->session->set_flashdata('error', 'Error in adding Meter');
            }
        }
        if (($this
            ->input
            ->post('edit_meter_readings')) == "save") {

            $meter_id = $this
                ->input
                ->post('meter_id');
            $meter_reading = $this
                ->input
                ->post('meter_reading');
            $date_of_reading = $this
                ->input
                ->post('date_of_reading');
            $charge_code = $this
                ->input
                ->post('charge_code');
            $photo = $this
                ->input
                ->post('imagename');

            $dt = new DateTime($date_of_reading);

            $date = $dt->format('Y-m-d');
            $column = array('*', 'tbl_meter_reading.id as new_id');

            $condition = array(
                'tbl_meter_reading.id' => $meter_id
            );
            $join = array(
                array(
                    'table' => 'tbl_meter_connections',
                    'condition' => 'tbl_meter_connections.id=tbl_meter_reading.meter_id',
                    'jointype' => 'LEFT'
                ),
                array(
                    'table' => 'tbl_water_right_alloc',
                    'condition' => 'tbl_water_right_alloc.id=tbl_meter_connections.water_right',
                    'jointype' => 'LEFT'
                ),

            );
            $editdata = $this
                ->user_model
                ->get_joins('tbl_meter_reading', $condition, $join, $column);

            if ($editdata[0]['meter_reading'] != $meter_reading) {

                $remain = $meter_reading - $editdata[0]['meter_reading'];

                $update = array(
                    'meter_reading' => $editdata[0]['meter_reading'] + $remain,
                    'meter_vol' => $editdata[0]['meter_vol'] + $remain,
                    'prev_remain' => $editdata[0]['prev_remain'] - $remain
                );
                $whereUpdate = array('id' => $meter_id);
                $this->user_model->UPDATEDATA('tbl_meter_reading', $whereUpdate, $update);

                $where = array('meter_id' => $editdata[0]['meter_id'], 'userid' => $editdata[0]['userid'], 'tbl_meter_reading.id>=' => $meter_id);
                $all_readings = $this
                    ->user_model
                    ->get_joins('tbl_meter_reading', $where, $join, $column);

                foreach ($all_readings as $key => $value) {
                    if ($key > 0) {

                        $meter_vol = $value['meter_reading'] - $all_readings[$key - 1]['meter_reading'];
                        $ud = array('meter_vol' => $meter_vol);
                        $wd = array('id' => $value['new_id']);
                        $this->user_model->UPDATEDATA('tbl_meter_reading', $wd, $ud);
                    }
                }
                $group = array('water_right');
                $get_col = array('*', 'sum(meter_vol) as meter_total', 'GROUP_CONCAT(tbl_meter_reading.id) as new_id');
                $where_col = array('water_right' => $editdata[0]['water_right'], 'userid' => $editdata[0]['userid']);
                $meters = $this->user_model->get_joins('tbl_meter_reading', $where_col, $join, $get_col, '', $group);

                $meter_ids = explode(',', $meters[0]['new_id']);
                foreach ($meter_ids as $key => $value) {
                    $where_id = array('id' => $value);
                    $update_remain = array('remaining' => $editdata[0]['wr_volume'] - $meters[0]['meter_total']);
                    $this->user_model->UPDATEDATA('tbl_meter_reading', $where_id, $update_remain);
                    // echo $this->db->last_query();
                }
            }


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
                if ($editdata[0]['photo'] != 'default-image.png') {
                    unlink('/var/www/clients/client4/web4/web/ICSweb/assets/meterimages/' . $photo);
                }
            } else {
                $imagename = $photo;
            }


            $updatedata = array(
                'date_of_reading' => $date,
                'photo' => $imagename,
                'charge_code' => $charge_code
            );
            $is_update = $this
                ->user_model
                ->UPDATEDATA('tbl_meter_reading', $condition, $updatedata);
            if ($is_update) {

                $this
                    ->session
                    ->set_flashdata('success', 'Meter updated sucessfully');
            } else {
                $this
                    ->session
                    ->set_flashdata('error', 'Error in updating Operator');
            }
        }
        $columns = array(
            'tbl_meter_reading.*',
            'tbl_meter_connections.meter_name as meter_name',
            'tbl_meter_connections.serial_number as serial_number',
            'tbl_channels.channel_name as channel_name',
            'tbl_metertype.type as type',
            'tbl_charge_codes.charge_code as charge_code_value'
        );
        $join = array(
            array(
                'table' => 'tbl_meter_connections',
                'condition' => 'tbl_meter_connections.id=tbl_meter_reading.meter_id',
                'jointype' => 'LEFT'
            ),
            array(
                'table' => 'tbl_water_rights',
                'condition' => 'tbl_meter_connections.water_right=tbl_water_rights.id',
                'jointype' => 'LEFT'
            ),
            array(
                'table' => 'tbl_metertype',
                'condition' => 'tbl_meter_connections.meter_type=tbl_metertype.id',
                'jointype' => 'LEFT'
            ),
            array(
                'table' => 'tbl_channels',
                'condition' => 'tbl_meter_connections.channel_name=tbl_channels.id',
                'jointype' => 'LEFT'
            ),
            array(
                'table' => 'tbl_charge_codes',
                'condition' => 'tbl_meter_reading.charge_code=tbl_charge_codes.id',
                'jointype' => 'LEFT'
            ),
        );
        $details = $this
            ->user_model
            ->get_joins('tbl_meter_reading', '', $join, $columns, '', '', 'Year(date_of_reading),month(date_of_reading)');

        $channels = $this
            ->user_model
            ->get_joins('tbl_channels');
        $metertype = $this
            ->user_model
            ->get_joins('tbl_metertype');
        $charge_codes = $this
            ->user_model
            ->get_joins('tbl_charge_codes');
        $connections = $this
            ->user_model
            ->get_joins('tbl_meter_connections');

        //     echo  $this->db->last_query();
        // exit;
        $data['channels'] = $channels;
        $data['metertype'] = $metertype;
        $data['charge_codes'] = $charge_codes;
        $data['connections'] = $connections;
        $data['data'] = $details;
        $data['page_title'] = 'Usage';
        $data['page_name'] = 'Operator/usage';
        $this
            ->load
            ->view('Operator/index', $data);
    }
    public function user_details()
    {
        $wherename = array(
            'operatorid' => $this
                ->session
                ->userdata('user_id')
        );
        $data['water_rights'] = $this
            ->user_model
            ->get_joins('tbl_water_rights');
        $data['water_users'] = $this
            ->user_model
            ->get_joins('tbl_users', $wherename);
        $data['page_title'] = 'User Details';
        $data['page_name'] = 'Operator/user_details';
        $this
            ->load
            ->view('Operator/index', $data);
    }

    public function add_new_client()
    {
        if (
            $this
            ->input
            ->post('username') != ""
        ) {
            $username = $this
                ->input
                ->post('username');
            $contactname = $this
                ->input
                ->post('contactname') != "" ? $this
                ->input
                ->post('contactname') : "";
            $wherename = array(
                'username' => $username,
                'contact_name' => $contactname
            );
            $userExists = $this
                ->user_model
                ->get_joins('tbl_users', $wherename);
            if ($userExists) {
                $response = array(
                    'status' => false,
                    'message' => 'User with same details is already exists'
                );
                print_r(json_encode($response));
            } else {
                $field = array(
                    'operatorid' => $this
                        ->session
                        ->userdata('user_id'),
                    'username' => $username,
                    'contact_name' => $contactname,
                );
                $insert = $this
                    ->user_model
                    ->INSERTDATA('tbl_users', $field);
                if ($insert) {
                    $response = array(
                        'status' => true,
                        'message' => 'Water User added Sucessfully'
                    );
                    print_r(json_encode($response));
                } else {
                    $response = array(
                        'status' => false,
                        'message' => 'Error in adding Water User'
                    );
                    print_r(json_encode($response));
                }
            }
        } else {
            $response = array(
                'status' => false,
                'message' => 'Username is mandatory'
            );
            print_r(json_encode($response));
        }
    }
    /* FETCH ALL WATER USERS OF AN OPERATOR */
    public function load_water_users()
    {
        // $wherename=array('operatorid'=>$this->session->userdata('user_id'));
        // $userExists=$this->user_model->get_joins('tbl_users',$wherename);
        $userExists = $this
            ->user_model
            ->get_joins('tbl_users');
        if ($userExists) {
            print_r(json_encode($userExists));
        } else {
            $response = array(
                'status' => false,
                'message' => 'Error in fetching Water User'
            );
            print_r(json_encode($response));
        }
    }
    /* FETCH ALL DETAILS OF A WATER USER */
    public function ud_clientdetail_onchange()
    {
        if (
            $this
            ->input
            ->post('username') != ""
        ) {
            $username = $this
                ->input
                ->post('username');
            $contact_name = $this
                ->input
                ->post('contact_name') != "" ? $this
                ->input
                ->post('contact_name') : "";
            $wherename = array(
                // 'operatorid'=>$this->session->userdata('user_id'),
                'tbl_users.id' => $username,
                // 'contact_name'=>$contact_name,
                'is_active' => 1
            );
            $columns = array(
                'tbl_users.*',
                'tbl_water_rights.id as wr_id',
                'tbl_water_rights.wr_number as wr_number',
                'tbl_water_rights.wr_volume as wr_volume'
            );
            $join = array(
                array(
                    'table' => 'tbl_water_rights',
                    'condition' => 'tbl_water_rights.id=tbl_users.water_right_number',
                    'jointype' => 'LEFT'
                )
            );
            $userExists = $this
                ->user_model
                ->get_joins('tbl_users', $wherename, $join, $columns);
            // print_r($this->db->last_query());
            if ($userExists) {
                print_r(json_encode($userExists));
            } else {
                $response = array(
                    'status' => false,
                    'message' => 'User not exists'
                );
                print_r(json_encode($response));
            }
        } else {
            $response = array(
                'status' => false,
                'message' => 'Username is mandatory'
            );
            print_r(json_encode($response));
        }
    }
    /* FETCH ALL DETAILS OF A WATER USER BY USERID */
    public function contactnames_by_username()
    {
        if (
            $this
            ->input
            ->post('username') != ""
        ) {
            $username = $this
                ->input
                ->post('username');
            $wherename = array(
                // 'operatorid'=>$this->session->userdata('user_id'),
                'id' => $username,
                'is_active' => 1
            );
            $userExists = $this
                ->user_model
                ->get_joins('tbl_users', $wherename);
            if ($userExists) {
                print_r(json_encode($userExists));
            } else {
                $response = array(
                    'status' => false,
                    'message' => 'User not exists'
                );
                print_r(json_encode($response));
            }
        } else {
            $response = array(
                'status' => false,
                'message' => 'Username is mandatory'
            );
            print_r(json_encode($response));
        }
    }

    public function assign_water_right()
    {
        $userid = $this
            ->input
            ->post('userid') ? $this
            ->input
            ->post('userid') : "";
        $water_right_number = $this
            ->input
            ->post('water_right_number') ? $this
            ->input
            ->post('water_right_number') : "";
        if (
            $this
            ->input
            ->post('userid') != "" && $this
            ->input
            ->post('water_right_number') != ""
        ) {
            $whereuser = array(
                'id' => $userid
            );
            $isexists = $this
                ->user_model
                ->get_joins('tbl_users', $whereuser);
            if ($isexists) {
                $presavedright = $isexists[0]['water_right_number'];
                if ($presavedright != "") {

                    if (preg_match('/\b' . $water_right_number . '\b/', $presavedright)) {
                        $response = array(
                            'status' => false,
                            'message' => 'Water Right is already saved for this client'
                        );
                        print_r(json_encode($response));
                    } else {
                        $condition = array(
                            'id' => $userid
                        );
                        $updatedata = array(
                            'water_right_number' => $presavedright . $water_right_number . ',',
                        );
                        $is_update = $this
                            ->user_model
                            ->UPDATEDATA('tbl_users', $condition, $updatedata);
                        if ($is_update) {
                            $response = array(
                                'status' => true,
                                'message' => 'Water Right added Sucessfully'
                            );
                            print_r(json_encode($response));
                        } else {
                            $response = array(
                                'status' => false,
                                'message' => 'Error in adding Water Right'
                            );
                            print_r(json_encode($response));
                        }
                    }
                } else {
                    $condition = array(
                        'id' => $userid
                    );
                    $updatedata = array(
                        'water_right_number' => $water_right_number . ',',
                    );
                    $is_update = $this
                        ->user_model
                        ->UPDATEDATA('tbl_users', $condition, $updatedata);
                    if ($is_update) {
                        $response = array(
                            'status' => true,
                            'message' => 'New Water Right added Sucessfully'
                        );
                        print_r(json_encode($response));
                    } else {
                        $response = array(
                            'status' => false,
                            'message' => 'Error in adding Water Right'
                        );
                        print_r(json_encode($response));
                    }
                }
            } else {
                $response = array(
                    'status' => false,
                    'message' => 'Water user does not exists'
                );
                print_r(json_encode($response));
            }
        } else {
            $response = array(
                'status' => false,
                'message' => '* Water user & Water right number is mandatory'
            );
            print_r(json_encode($response));
        }
    }
    /* FETCH ALL CHANNELS */
    public function load_channels()
    {
        $channelExists = $this
            ->user_model
            ->get_joins('tbl_channels');
        if ($channelExists) {
            print_r(json_encode($channelExists));
        } else {
            $response = array(
                'status' => false,
                'message' => 'Error in fetching Water User'
            );
            print_r(json_encode($response));
        }
    }
    /* FETCH ALL METER TYPE */
    public function load_metertypes()
    {
        $meterTypeExists = $this
            ->user_model
            ->get_joins('tbl_metertype');
        if ($meterTypeExists) {
            print_r(json_encode($meterTypeExists));
        } else {
            $response = array(
                'status' => false,
                'message' => 'Error in fetching Water User'
            );
            print_r(json_encode($response));
        }
    }
    /* FETCH WATER RIGHT */
    public function load_water_rights()
    {
        $waterRightExists = $this
            ->user_model
            ->get_joins('tbl_water_rights');

        if ($waterRightExists) {
            print_r(json_encode($waterRightExists));
        } else {
            $response = array(
                'status' => false,
                'message' => 'Error in fetching Water Rights'
            );
            print_r(json_encode($response));
        }
    }
    /* FETCH DETAILS OF WATER RIGHT */
    public function load_water_right_detail()
    {
        $userid = $this
            ->input
            ->post('userid') ? $this
            ->input
            ->post('userid') : "";
        if ($userid != "") {
            $where = array(
                'id' => $userid,
                'is_active' => 1
            );
            $waterUserExists = $this
                ->user_model
                ->get_joins('tbl_users', $where);
            if ($waterUserExists) {
                $waterRight = $waterUserExists[0]['water_right_number'] ? $waterUserExists[0]['water_right_number'] : "";
                if ($waterRight != "") {
                    $rightId = explode(',', $waterRight);
                    $collect = array();
                    foreach ($rightId as $Id) {
                        if ($Id != null) {
                            $rightData = $this->getWaterRightInfo($Id);
                            $data = array(
                                'id' => $rightData[0]['id'],
                                'wr_number' => $rightData[0]['wr_number'],
                                'wr_surname' => $rightData[0]['wr_surname'],
                                'wr_firstname' => $rightData[0]['wr_firstname'],
                                'wr_volume' => $rightData[0]['wr_volume'],
                                'isActive' => $rightData[0]['isActive'],
                                'createdAt' => $rightData[0]['createdAt']
                            );
                            array_push($collect, $data);
                        }
                    }
                    if (sizeof($collect) > 0) {
                        print_r(json_encode($collect));
                    }
                } else {
                    $response = array(
                        'status' => false,
                        'message' => 'Water Right is empty'
                    );
                    print_r(json_encode($response));
                }
            } else {
                $response = array(
                    'status' => false,
                    'message' => 'Error in fetching Water Right'
                );
                print_r(json_encode($response));
            }
        } else {
            $response = array(
                'status' => false,
                'message' => 'User id is mandatory'
            );
            print_r(json_encode($response));
        }
    }
    /* FETCH METER CONNECTIONS */
    public function load_meter_connections()
    {
        if (
            $this
            ->input
            ->post('userid') != ""
        ) {

            $water_right = $this
                ->input
                ->post('water_right');
            $userid = $this
                ->input
                ->post('userid');

            if (empty($water_right)) {
                $where = array(
                    // 'operatorid'=>$this->session->userdata('user_id'),
                    'userid' => $userid,
                    'tbl_meter_connections.isActive' => 1
                );
            } else {

                $where = array(
                    // 'operatorid'=>$this->session->userdata('user_id'),
                    'userid' => $userid,
                    'tbl_meter_connections.water_right' => $water_right,
                    'tbl_meter_connections.isActive' => 1
                );
            }

            $columns = array(
                'tbl_meter_connections.*',
                'tbl_water_right_alloc.wr_number as wr_number',
                'tbl_metertype.type as meter_type',
                'tbl_channels.channel_name as channel_name',
                'tbl_meter_connections.channel_name as channel_id',
                'tbl_meter_connections.meter_type as type_id',
                'tbl_meter_connections.flow_rate_topic as f_rate_name',
                'tbl_meter_connections.telementry as telementry',
                'tbl_meter_connections.flow_rate_scaling as f_rate_scal',
                'tbl_meter_connections.flow_total_reading_topic as f_total_name',
                'tbl_meter_connections.flow_total_reading_scaling as f_total_scal',
            );
            $join = array(
                // array( 'table' => 'tbl_water_rights', 'condition' => 'tbl_water_rights.id=tbl_meter_connections.water_right', 'jointype' => 'LEFT' ),
                array(
                    'table' => 'tbl_water_right_alloc',
                    'condition' => 'tbl_water_right_alloc.id=tbl_meter_connections.water_right',
                    'jointype' => 'LEFT'
                ),
                array(
                    'table' => 'tbl_metertype',
                    'condition' => 'tbl_metertype.id=tbl_meter_connections.meter_type',
                    'jointype' => 'LEFT'
                ),
                array(
                    'table' => 'tbl_channels',
                    'condition' => 'tbl_channels.id=tbl_meter_connections.channel_name',
                    'jointype' => 'LEFT'
                )
            );
            $meterConnectionsExists = $this
                ->user_model
                ->get_joins('tbl_meter_connections', $where, $join, $columns, '', '', 'tbl_meter_connections.id DESC');
            if ($meterConnectionsExists) {
                print_r(json_encode($meterConnectionsExists));
            } else {
                $response = array(
                    'status' => false,
                    'message' => 'Meter Connections not exists'
                );
                print_r(json_encode($response));
            }
        } else {
            $response = array(
                'status' => false,
                'message' => 'Select Client for the Connections'
            );
            print_r(json_encode($response));
        }
    }

    /* ADD NEW METER CONNECTION */
    public function add_meter_connection()
    {
        if (
            $this->input->post('userid') != "" && $this->input->post('meter_name') != "" && $this->input->post('channel_name') != "" && $this->input->post('water_right_number') != "" && $this->input->post('property') != "" && $this->input->post('meter_type') != ""  && $this->input->post('serial_number') != ""
        ) {

            $operatorid = $this->session->userdata('user_id');
            $userid = $this->input->post('userid');
            $meter_name = $this->input->post('meter_name');
            $channel_name = $this->input->post('channel_name');
            $water_right_number = $this->input->post('water_right_number');
            $property = $this->input->post('property');
            $meter_type = $this->input->post('meter_type');

            $field = array(
                'operatorid' => $operatorid,
                'userid' => $userid,
                'meter_name' => $meter_name,
                'channel_name' => $channel_name,
                'property' => $property,
                'meter_type' => $meter_type,
                'water_right' => $water_right_number,
            );


            $insert = $this
                ->user_model
                ->INSERTDATA('tbl_meter_connections', $field);


            if ($insert) {
                $response = array(
                    'status' => true,
                    'message' => 'Meter connection added Sucessfully'
                );
                print_r(json_encode($response));
            } else {
                $response = array(
                    'status' => false,
                    'message' => 'Error in adding Meter Connection'
                );
                print_r(json_encode($response));
            }
        } else {
            $response = array(
                'status' => false,
                'message' => 'Userid and Meter details are mandatory'
            );
            print_r(json_encode($response));
        }
    }

    public function edit_permanent_allocation()
    {
        $userid = $this
            ->input
            ->post('userid');
        $permanent_alloc = $this
            ->input
            ->post('permanent_alloc');
        $condition = array(
            'id' => $userid
        );
        $updatedata = array(
            'allocation_volume' => $permanent_alloc
        );
        $is_update = $this
            ->user_model
            ->UPDATEDATA('tbl_users', $condition, $updatedata);
        if ($is_update) {
            $response = array(
                'status' => true,
                'message' => 'Permanent Allocation Updated Sucessfully'
            );
            print_r(json_encode($response));
        } else {
            $response = array(
                'status' => false,
                'message' => 'Permanent Allocation Update Failed'
            );
            print_r(json_encode($response));
        }
    }

    public function edit_userdetail()
    {
        if (
            $this
            ->session
            ->userdata('user_id') != "" && $this
            ->input
            ->post('userid') != "" && $this
            ->input
            ->post('username') != ""
        ) {
            $operatorid = $this
                ->session
                ->userdata('user_id');
            $userid = $this
                ->input
                ->post('userid');
            $username = $this
                ->input
                ->post('username');
            $contact_name = $this
                ->input
                ->post('contact_name');
            $address = $this
                ->input
                ->post('address');
            $email = $this
                ->input
                ->post('email');
            $password = $this
                ->input
                ->post('password');


            $property = $this
                ->input
                ->post('property');
            $phone = $this
                ->input
                ->post('phone');
            $mobile = $this
                ->input
                ->post('mobile');
            $stockdomestic = $this
                ->input
                ->post('stockdomestic');
            $condition = array(
                'id' => $userid
            );
            $updatedata = array(
                'operatorid' => $operatorid,
                'id' => $userid,
                'username' => $username,
                'contact_name' => $contact_name,
                'address' => $address,
                'email' => $email,
                'password' => base64_encode($password),
                'property' => $property,
                'phone' => $phone,
                'contact' => $mobile,
                'stock_supply' => $stockdomestic
            );
            $is_update = $this
                ->user_model
                ->UPDATEDATA('tbl_users', $condition, $updatedata);
            if ($is_update) {
                $response = array(
                    'status' => true,
                    'message' => 'Water User Detail Updated Sucessfully'
                );
                print_r(json_encode($response));
            } else {
                $response = array(
                    'status' => false,
                    'message' => 'Water User Detail Update Failed'
                );
                print_r(json_encode($response));
            }
        } else {
            $response = array(
                'status' => false,
                'message' => 'Username and Id is mandatory'
            );
            print_r(json_encode($response));
        }
    }

    public function client_usage_report()
    {
        $data['page_title'] = 'Client Usage Report';
        $data['page_name'] = 'Operator/client_usage_report';
        $this
            ->load
            ->view('Operator/index', $data);
    }

    public function live_flow()
    {
        $data['page_title'] = 'Client Live Flow';
        $data['page_name'] = 'Operator/live_flow';

        $channels = $this
            ->user_model
            ->get_joins('tbl_channels');
        

        //     echo  $this->db->last_query();
        // exit;
        $data['channels'] = $channels;

        $this
            ->load
            ->view('Operator/index', $data);
    }

    /* CONTACT */
    public function contact()
    {
        $data['page_title'] = 'Contact';
        $data['page_name'] = 'Operator/contact';
        $this
            ->load
            ->view('Operator/index', $data);
    }

    public function profile_data()
    {
        $imagename = 'OPERATOR' . date('Ys_') . $_FILES['file']['name'];
        $imagedata = $_FILES['file']['tmp_name'];
        $foldername = "assets/profileimages/";
        if (!is_dir($foldername)) {
            mkdir($foldername, 0777, true);
        }
        $gender = $this
            ->input
            ->post('gender');
        $address = $this
            ->input
            ->post('address');
        $id = $this
            ->input
            ->post('id');
        $condition = array(
            'id' => $id
        );
        $updatedata = array(
            'gender' => $gender,
            'address' => $address,
            'image' => base_url('assets/profileimages/') . $imagename
        );
        $update = $this
            ->user_model
            ->UPDATEDATA('tbl_operator', $condition, $updatedata);
        if ($update && move_uploaded_file($imagedata, $foldername . $imagename)) {
            $this
                ->session
                ->set_flashdata('success', '<b>Hello</b>');
            redirect('Operator');
        } else {
            $this
                ->session
                ->set_flashdata('error', 'Error Updating Profile');
            redirect('Operator');
        }
    }
    /* LOGOUT */
    public function logout()
    {
        $this
            ->session
            ->unset_userdata('user_id');
        $this
            ->session
            ->sess_destroy();
        redirect('welcome');
    }
    public function testpage()
    {
        $this
            ->load
            ->view('welcome_message');
    }

    /* THIS METHODS */
    function getWaterRightInfo($Id)
    {
        $where = array(
            'id' => $Id
        );
        $waterRightExists = $this
            ->user_model
            ->get_joins('tbl_water_rights', $where);
        if ($waterRightExists) {
            return $waterRightExists;
        }
    }

    public function get_contactname()
    {
        $userid = $this
            ->input
            ->get('userid');
        $columns = array(
            'contact_name'
        );
        $column = array(
            'tbl_meter_connections.id as meter_id',
            'meter_name'
        );
        $where = array(
            'id' => $userid
        );
        $wheremeter = array(
            'userid' => $userid
        );
        $get_contactname = $this
            ->user_model
            ->get_joins('tbl_users', $where, '', $columns);

        $get_metername = $this
            ->user_model
            ->get_joins('tbl_meter_connections', $wheremeter, '', $column);
        $get_metername = array(
            'meter_name' => $get_metername
        );
        array_push($get_contactname, $get_metername);

        print_r(json_encode($get_contactname));
    }

    public function get_seasondata()
    {
        $get_seasondata = $this
            ->user_model
            ->get_joins('tbl_seasons');
        print_r(json_encode($get_seasondata));
    }

    public function check_numb($num)
    {
        if ($num > 0) {
            return 'positive';
        } else {
            return 'negative';
        }
    }

    public function get_seasondate()
    {
        $seasonid = $this
            ->input
            ->get('seasonid');
        $columns = array(
            'start_date',
            'end_date'
        );
        $where = array(
            'id' => $seasonid
        );
        $get_seasondate = $this
            ->user_model
            ->get_joins('tbl_seasons', $where, '', $columns);
        print_r(json_encode($get_seasondate));
    }

    public function maxDate($dates)
    {
        $dates = explode(',', $dates);
        return max($dates);
    }
    public function load_client_usage_report()
    {

        $result = [];
        $userid = $this->input->post('userid');
        $fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $meterid = $this->input->post('meterid');
        $individual_user = $this->input->post('individual_meter');
        $allmeter = $this->input->post('allmeter');

        if ($allmeter == 1 && !empty($userid)) {
            if (!empty($meterid)) {
                if (!empty($fromdate)) {
                    $dt = new DateTime($fromdate);

                    $fromdate = $dt->format('Y-m-d');

                    $dts = new DateTime($todate);

                    $todate = $dts->format('Y-m-d');

                    $where = [
                        'tbl_users.id' => $userid,
                        'date_of_reading >=' => $fromdate,
                        'date_of_reading <=' => $todate,
                        'water_right' => $meterid,
                    ];
                } else {
                    $where = [
                        'tbl_users.id' => $userid,
                        'water_right' => $meterid,
                    ];
                }
            } else {
                if (!empty($fromdate)) {
                    $dt = new DateTime($fromdate);

                    $fromdate = $dt->format('Y-m-d');

                    $dts = new DateTime($todate);

                    $todate = $dts->format('Y-m-d');

                    $where = [
                        'tbl_users.id' => $userid,
                        'date_of_reading >=' => $fromdate,
                        'date_of_reading <=' => $todate,
                    ];
                } else {
                    $where = [
                        'tbl_users.id' => $userid,
                    ];
                }
            }
            $join = [
                [
                    'table' => 'tbl_meter_connections',
                    'condition' =>
                    'tbl_meter_reading.meter_id=tbl_meter_connections.id',
                    'jointype' => 'LEFT',
                ],
                [
                    'table' => 'tbl_users',
                    'condition' => 'tbl_users.id=tbl_meter_connections.userid',
                    'jointype' => 'LEFT',
                ],
                [
                    'table' => 'tbl_channels',
                    'condition' =>
                    'tbl_channels.id=tbl_meter_connections.channel_name',
                    'jointype' => 'LEFT',
                ],
                [
                    'table' => 'tbl_metertype',
                    'condition' =>
                    'tbl_metertype.id=tbl_meter_connections.meter_type',
                    'jointype' => 'LEFT',
                ],
                [
                    'table' => 'tbl_water_right_alloc',
                    'condition' =>
                    'tbl_water_right_alloc.id=tbl_meter_connections.water_right',
                    'jointype' => 'LEFT',
                ],
                // array( 'table' => 'tbl_water_rights', 'condition' => 'tbl_water_rights.id=tbl_meter_connections.water_right', 'jointype' => 'LEFT' ),
                [
                    'table' => 'tbl_charge_codes',
                    'condition' =>
                    'tbl_charge_codes.id=tbl_meter_reading.charge_code',
                    'jointype' => 'LEFT',
                ],
            ];

            $column = [
                'tbl_meter_reading.*',
                'tbl_metertype.*',
                'tbl_channels.channel_name as channel_name',
                'tbl_meter_connections.*',
                'tbl_water_right_alloc.*',
                'tbl_users.*',
                'tbl_charge_codes.*',
                'tbl_meter_reading.meter_reading as usage',
            ];

            $result = $this->user_model->get_joins(
                'tbl_meter_reading',
                $where,
                $join,
                $column,
                '',
                '',
                'tbl_meter_reading.id DESC'
            );
        } else {
            if (empty($meterid)) {
                if (!empty($fromdate)) {
                    $dt = new DateTime($fromdate);

                    $fromdate = $dt->format('Y-m-d');

                    $dts = new DateTime($todate);

                    $todate = $dts->format('Y-m-d');

                    $where = [
                        'tbl_users.id' => $userid,
                        'date_of_reading >=' => $fromdate,
                        'date_of_reading <=' => $todate,
                    ];
                } else {
                    $where = [
                        'tbl_users.id' => $userid,
                    ];
                }
            } else {
                if (!empty($fromdate)) {
                    $dt = new DateTime($fromdate);

                    $fromdate = $dt->format('Y-m-d');

                    $dts = new DateTime($todate);

                    $todate = $dts->format('Y-m-d');

                    $where = [
                        'tbl_users.id' => $userid,
                        'tbl_meter_connections.water_right' => $meterid,
                        'date_of_reading >' => $fromdate,
                        'date_of_reading <' => $todate,
                    ];
                } else {
                    $where = [
                        'tbl_users.id' => $userid,
                        'tbl_meter_connections.water_right' => $meterid,
                    ];
                }
            }

            $join = [
                [
                    'table' => 'tbl_meter_connections',
                    'condition' =>
                    'tbl_meter_reading.meter_id=tbl_meter_connections.id',
                    'jointype' => 'LEFT',
                ],
                [
                    'table' => 'tbl_users',
                    'condition' => 'tbl_users.id=tbl_meter_connections.userid',
                    'jointype' => 'LEFT',
                ],
                [
                    'table' => 'tbl_channels',
                    'condition' =>
                    'tbl_channels.id=tbl_meter_connections.channel_name',
                    'jointype' => 'LEFT',
                ],
                [
                    'table' => 'tbl_metertype',
                    'condition' =>
                    'tbl_metertype.id=tbl_meter_connections.meter_type',
                    'jointype' => 'LEFT',
                ],
                [
                    'table' => 'tbl_water_right_alloc',
                    'condition' =>
                    'tbl_water_right_alloc.id=tbl_meter_connections.water_right',
                    'jointype' => 'LEFT',
                ],
                // array( 'table' => 'tbl_water_rights', 'condition' => 'tbl_water_rights.id=tbl_meter_connections.water_right', 'jointype' => 'LEFT' ),
                [
                    'table' => 'tbl_charge_codes',
                    'condition' =>
                    'tbl_charge_codes.id=tbl_meter_reading.charge_code',
                    'jointype' => 'LEFT',
                ],
            ];

            if ($individual_user == 1) {
                $result_data = array();
                $columns = [
                    '*',
                    'sum(meter_vol) as meter_vol',
                    'GROUP_CONCAT(date_of_reading) as date_of_reading',
                    'GROUP_CONCAT(meter_reading) as meter_readings',
                ];
                $group = ['meter_id'];
                $details = $this->user_model->get_joins(
                    'tbl_meter_reading',
                    $where,
                    $join,
                    $columns,
                    '',
                    $group,
                    'tbl_meter_reading.id DESC'
                );

                // echo "<pre>";
                // echo $this->db->last_query();
                // print_r($details);
                // exit;
                $remain = 0;
                foreach ($details as $value) {
                    $sign = $this->check_numb(
                        $value['wr_volume'] - $value['meter_vol']
                    );

                    $date = $this->maxDate($value['date_of_reading']);
                    $meter_reading = $this->maxDate($value['meter_readings']);


                    $data = [
                        'id' => $value['id'],
                        'meter_id' => $value['meter_id'],
                        'meter_reading' => $meter_reading,
                        'date_of_reading' => $date,
                        'charge_code' => $value['charge_code'],
                        'photo' => $value['photo'],
                        'is_active' => $value['is_active'],
                        'created_at' => $value['created_at'],
                        'operatorid' => $value['operatorid'],
                        'userid' => $value['userid'],
                        'serial_number' => $value['serial_number'],
                        'meter_name' => $value['meter_name'],
                        'channel_name' => $value['channel_name'],
                        'property' => $value['property'],
                        'meter_type' => $value['meter_type'],
                        'water_right' => $value['water_right'],
                        'comments' => $value['comments'],
                        'image' => $value['image'],
                        'surname' => $value['surname'],
                        'username' => $value['username'],
                        'contact_name' => $value['contact_name'],
                        'company_name' => $value['company_name'],
                        'type' => $value['type'],
                        'wr_number' => $value['wr_number'],
                        'wr_volume' => $value['wr_volume'],
                        'remaining' => $value['remaining'],
                        'sign' => $sign,
                        'meter_vol' => $value['meter_vol'],
                        'usage' => $meter_reading,
                    ];

                    array_push($result, $data);
                }

                // foreach ($result_data as $key => $value) {
                //
                //                         $data = [
                //                             'id' => $value['id'],
                //                             'meter_id' => $value['meter_id'],
                //                             'meter_reading' => $meter_reading,
                //                             'date_of_reading' => $date,
                //                             'charge_code' => $value['charge_code'],
                //                             'photo' => $value['photo'],
                //                             'is_active' => $value['is_active'],
                //                             'created_at' => $value['created_at'],
                //                             'operatorid' => $value['operatorid'],
                //                             'userid' => $value['userid'],
                //                             'serial_number' => $value['serial_number'],
                //                             'meter_name' => $value['meter_name'],
                //                             'channel_name' => $value['channel_name'],
                //                             'property' => $value['property'],
                //                             'meter_type' => $value['meter_type'],
                //                             'water_right' => $value['water_right'],
                //                             'comments' => $value['comments'],
                //                             'image' => $value['image'],
                //                             'surname' => $value['surname'],
                //                             'username' => $value['username'],
                //                             'contact_name' => $value['contact_name'],
                //                             'company_name' => $value['company_name'],
                //                             'type' => $value['type'],
                //                             'wr_number' => $value['wr_number'],
                //                             'wr_volume' => $value['wr_volume'],
                //                             'remaining' => $value['wr_volume']-$remain,
                //                             'sign' => $sign,
                //                             'meter_vol' => round($value['meter_vol'], 4),
                //                             'usage' => $meter_reading,
                //                         ];
                //
                //                         array_push($result, $data);
                // }



            } else {
                $columns = [
                    '*,SUM(meter_vol) as meter_vol, GROUP_CONCAT(DISTINCT tbl_meter_connections.meter_name) as meter_name',
                    'GROUP_CONCAT(date_of_reading) as date_of_reading',
                ];

                $details = $this->user_model->get_joins(
                    'tbl_meter_reading',
                    $where,
                    $join,
                    $columns,
                    '',
                    'tbl_meter_connections.water_right',
                    'tbl_meter_reading.id DESC'
                );

                foreach ($details as $value) {
                    $count = $this->count_meter($value['meter_name']);

                    $volume = $value['wr_volume'];

                    $remaining = $volume - $value['meter_vol'];

                    $sign = $this->check_numb($remaining);
                    $date = $this->maxDate($value['date_of_reading']);

                    $data = [
                        'id' => $value['id'],
                        'meter_id' => $value['meter_id'],
                        'meter_reading' =>
                        $value['wr_volume'] - $value['remaining'],
                        'date_of_reading' => $date,
                        'charge_code' => $value['charge_code'],
                        'photo' => $value['photo'],
                        'is_active' => $value['is_active'],
                        'created_at' => $value['created_at'],
                        'operatorid' => $value['operatorid'],
                        'userid' => $value['userid'],
                        'serial_number' => '-',
                        'meter_name' => '-',
                        'channel_name' => $value['channel_name'],
                        'property' => $value['property'],
                        'meter_type' => $value['meter_type'],
                        'water_right' => $value['water_right'],
                        'comments' => $value['comments'],
                        'image' => $value['image'],
                        'surname' => $value['surname'],
                        'username' => $value['username'],
                        'contact_name' => $value['contact_name'],
                        'company_name' => $value['company_name'],
                        'type' => $value['type'],
                        'wr_number' => $value['wr_number'],
                        'wr_volume' => $volume,
                        'remaining' => round($remaining, 4),
                        'sign' => $sign,
                        'meter_vol' => round($value['meter_vol'], 4),
                        'usage' => '-',
                    ];

                    array_push($result, $data);
                }
            }
        }

        print_r(json_encode($result));
    }

    public function count_meter($meter_name)
    {

        $count = count(explode(",", $meter_name));
        return $count;
    }

    public function upload_meter_image()
    {

        if (
            $this->input->post('userid') != "" && $this->input->post('meter_name') != "" && $this->input->post('channel_name') != "" && $this->input->post('water_right_number') != "" && $this->input->post('property') != "" && $this->input->post('meter_type') != "" && $this->input->post('serial_number') != ""
            // && $this->input->post('flow_rate_topic_name') != "" && $this->input->post('flow_rate_scaling') != "" &&  $this->input->post('flow_total_reading') != "" && $this->input->post('flow_total_reading_scaling') != ""
        ) {

            $operatorid = $this->session->userdata('user_id');
            $userid = $this->input->post('userid');
            $meter_name = $this->input->post('meter_name');
            $channel_name = $this->input->post('channel_name');
            $water_right_number = $this->input->post('water_right_number');
            $property = $this->input->post('property');
            $meter_type = $this->input->post('meter_type');
            $serial_number = $this->input->post('serial_number');

            $flow_rate_topic_name  = $this->input->post('flow_rate_topic_name');
            $flow_rate_scaling = $this->input->post('flow_rate_scaling');

            $flow_total_reading = $this->input->post('flow_total_reading');
            $flow_total_reading_scaling = $this->input->post('flow_total_reading_scaling');

            $telementry = $this->input->post('Telemetry');

            // if ($flow_rate_topic_name != '' && $flow_rate_scaling != '' && $flow_total_reading != '' && $flow_total_reading_scaling != '') {
            //     $flow_rate_topic_name  = $this->input->post('flow_rate_topic_name');
            //     $flow_rate_scaling = $this->input->post('flow_rate_scaling');
            //     $flow_total_reading = $this->input->post('flow_total_reading');
            //     $flow_total_reading_scaling = $this->input->post('flow_total_reading_scaling');
            // } else if ($flow_rate_topic_name != '' && $flow_rate_scaling != '') {
            //     $flow_total_reading = '';
            //     $flow_total_reading_scaling = '';
            // } else if ($flow_total_reading != '' && $flow_rate_scaling != '') {
            //     $flow_rate_topic_name = '';
            //     $flow_total_reading_scaling = '';
            // }


            if (!empty($_FILES['file'])) {
                $file_name = $_FILES['file']['name'];
                $tmp = explode('.', $file_name);
                $file_ext = strtolower(end($tmp));

                $imagename = 'Meter' . date('Ymdhis') . '.' . $file_ext;
                $imagedata = $_FILES['file']['tmp_name'];
                $foldername = "assets/meterprofiles/";

                if (!is_dir($foldername)) {
                    mkdir($foldername, 0777, true);
                }
                move_uploaded_file($imagedata, $foldername . $imagename);
            } else {
                $imagename = "";
            }

            $field = array(
                'operatorid' => $operatorid,
                'userid' => $userid,
                'meter_name' => $meter_name,
                'channel_name' => $channel_name,
                'property' => $property,
                'meter_type' => $meter_type,
                'serial_number' => $serial_number,
                'water_right' => $water_right_number,
                'image' => $imagename,
                'telementry' => $telementry,
                'flow_rate_topic' =>  $flow_rate_topic_name,
                'flow_rate_scaling' =>  $flow_rate_scaling,
                'flow_total_reading_topic' =>   $flow_total_reading,
                'flow_total_reading_scaling' => $flow_total_reading_scaling
            );

            $insert = $this
                ->user_model
                ->INSERTDATA('tbl_meter_connections', $field);

            if ($insert) {
                $response = array(
                    'status' => true,
                    'message' => 'Meter connection added Sucessfully'
                );
                print_r(json_encode($response));
            } else {
                $response = array(
                    'status' => false,
                    'message' => 'Error in adding Meter Connection'
                );
                print_r(json_encode($response));
            }
        } else {
            $response = array(
                'status' => false,
                'message' => 'Userid and Meter details are mandatory'
            );
            print_r(json_encode($response));
        }
    }

    public function load_water_usage_report()
    {

        $result = [];
        $channels = $this->input->post('channels');
        $fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $all_meter = $this->input->post('all_meter');

        if (empty($all_meter)) {
            if (!empty($fromdate)) {
                $dt = new DateTime($fromdate);

                $fromdate = $dt->format('Y-m-d');

                $dts = new DateTime($todate);

                $todate = $dts->format('Y-m-d');
                $where = [
                    'tbl_meter_connections.channel_name' => $channels,
                    'date_of_reading >' => $fromdate,
                    'date_of_reading <' => $todate,
                ];
            } else {
                $where = [
                    'tbl_meter_connections.channel_name' => $channels,
                ];
            }
        } else {
            if (!empty($fromdate)) {
                $dt = new DateTime($fromdate);

                $fromdate = $dt->format('Y-m-d');

                $dts = new DateTime($todate);

                $todate = $dts->format('Y-m-d');
                $where = [
                    'date_of_reading >' => $fromdate,
                    'date_of_reading <' => $todate,
                ];
            } else {
                $where = [];
            }
        }

        $columns = [
            'username',
            'contact_name',
            'meter_name',
            'wr_number',
            'sum(meter_vol) as meter_reading',
            '(wr_volume- sum(meter_vol) ) as remaining',
            'wr_volume',
            'tbl_channels.channel_name',
        ];
        $join = [
            [
                'table' => 'tbl_meter_connections',
                'condition' =>
                'tbl_meter_connections.id=tbl_meter_reading.meter_id',
                'jointype' => 'LEFT',
            ],
            [
                'table' => 'tbl_water_right_alloc',
                'condition' =>
                'tbl_water_right_alloc.id=tbl_meter_connections.water_right',
                'jointype' => 'LEFT',
            ],
            // array( 'table' => 'tbl_water_rights', 'condition' => 'tbl_water_rights.id=tbl_meter_connections.water_right', 'jointype' => 'LEFT' ),
            [
                'table' => 'tbl_users',
                'condition' => 'tbl_users.id=tbl_meter_connections.userid',
                'jointype' => 'LEFT',
            ],
            [
                'table' => 'tbl_charge_codes',
                'condition' =>
                'tbl_charge_codes.id=tbl_meter_reading.charge_code',
                'jointype' => 'LEFT',
            ],
            [
                'table' => 'tbl_channels',
                'condition' =>
                'tbl_channels.id=tbl_meter_connections.channel_name',
                'jointype' => 'LEFT',
            ],
        ];

        $channels = $this->user_model->get_joins(
            'tbl_meter_reading',
            $where,
            $join,
            $columns,
            '',
            'tbl_meter_connections.water_right'
        );

        foreach ($channels as $value) {
            $sign = $this->check_numb($value['remaining']);

            $channel = [
                'username' => $value['username'],
                'contact_name' => $value['contact_name'],
                'wr_number' => $value['wr_number'],
                'meter_name' => $value['meter_name'],
                'meter_reading' => round($value['meter_reading'], 2),
                'remaining' => round($value['remaining'], 2),
                'wr_volume' => $value['wr_volume'],
                'channel_name' => $value['channel_name'],
                'sign' => $sign,
            ];
            array_push($result, $channel);
        }
        // echo  $this->db->last_query();
        print_r(json_encode($result));
    }

    public function delete_meter_connection()
    {
        $id = $this
            ->input
            ->post('id');
        $where = array(
            'id' => $id
        );
        $updatedata = array(
            'isActive' => 0
        );
        $update = $this
            ->user_model
            ->UPDATEDATA('tbl_meter_connections', $where, $updatedata);

        if ($update) {
            $response = array(
                'status' => true,
                'message' => 'Meter Connection delete Sucessfully'
            );
            print_r(json_encode($response));
        } else {
            $response = array(
                'status' => false,
                'message' => 'Error in deleting Meter Connection'
            );
            print_r(json_encode($response));
        }
        // print_r(json_encode($_POST));

    }
    public function load_usage_history()
    {
        $result = array();
        $id = $this
            ->input
            ->post('userid');
        $show_all = $this
            ->input
            ->post('show_all');
        $water_right = $this
            ->input
            ->post('water_right');
        if ($show_all == 0) {
            $where = array(
                'tbl_meter_connections.isActive' => 1
            );
            if (!empty($id)) {
                $where = array(
                    'tbl_meter_connections.userid' => $id,
                    'tbl_meter_connections.isActive' => 1
                );
            }
            if (!empty($id) && !empty($water_right)) {
                $where = array(
                    'tbl_meter_connections.userid' => $id,
                    'tbl_meter_connections.water_right' => $water_right,
                    'tbl_meter_connections.isActive' => 1
                );
            }
        } else {
            $where = array();

            if (!empty($id)) {
                $where = array(
                    'tbl_meter_connections.userid' => $id
                );
            }
            if (!empty($id) && !empty($water_right)) {
                $where = array(
                    'tbl_meter_connections.userid' => $id,
                    'tbl_meter_connections.water_right' => $water_right,

                );
            }
        }

        $columns = array(
            'tbl_meter_reading.*',
            'tbl_meter_connections.userid as userid',
            'tbl_meter_connections.meter_name as meter_name',
            'tbl_meter_connections.serial_number as serial_number',
            'tbl_channels.id as channel_id',
            'tbl_channels.channel_name as channel_name',
            'tbl_metertype.type as type',
            'tbl_charge_codes.charge_code as charge_code_value',
            'tbl_metertype.id as type_id',
            'tbl_meter_connections.isActive as active'
        );

        $join = array(
            array(
                'table' => 'tbl_meter_connections',
                'condition' => 'tbl_meter_connections.id=tbl_meter_reading.meter_id',
                'jointype' => 'LEFT'
            ),
            array(
                'table' => 'tbl_water_right_alloc',
                'condition' => 'tbl_meter_connections.water_right=tbl_water_right_alloc.id',
                'jointype' => 'LEFT'
            ),
            // array( 'table' => 'tbl_water_rights', 'condition' => 'tbl_meter_connections.water_right=tbl_water_rights.id', 'jointype' => 'LEFT' ),
            array(
                'table' => 'tbl_metertype',
                'condition' => 'tbl_meter_connections.meter_type=tbl_metertype.id',
                'jointype' => 'LEFT'
            ),
            array(
                'table' => 'tbl_channels',
                'condition' => 'tbl_meter_connections.channel_name=tbl_channels.id',
                'jointype' => 'LEFT'
            ),
            array(
                'table' => 'tbl_charge_codes',
                'condition' => 'tbl_meter_reading.charge_code=tbl_charge_codes.id',
                'jointype' => 'LEFT'
            ),
        );
        $details = $this->user_model->get_joins('tbl_meter_reading', $where, $join, $columns, '', '', 'tbl_meter_reading.id DESC');

        foreach ($details as $value) {
            $data = array(
                'id' => $value['id'],
                'userid' => $value['userid'],
                'meter_id' => $value['meter_id'],
                'meter_reading' => $value['meter_reading'],
                'date_of_reading' => date("d-m-Y", strtotime($value['date_of_reading'])),
                'meter_vol' => $value['meter_vol'],
                'charge_code' => $value['charge_code'],
                'photo' => $value['photo'],
                'is_active' => $value['is_active'],
                'meter_name' => $value['meter_name'],
                'serial_number' => $value['serial_number'],
                'channel_id' => $value['channel_id'],
                'channel_name' => $value['channel_name'],
                'type' => $value['type'],
                'charge_code_value' => $value['charge_code_value'],
                'type_id' => $value['type_id'],
                'active' => $value['active'],
                'remaining' => $value['remaining']
            );
            array_push($result, $data);
        }
        print_r(json_encode($result));
    }

    public function check_meter_reading()
    {

        $meter_id = $this->input->post('meter_id');
        $meter_reading = $this->input->post('meter_reading');
        $where = array('meter_id' => $meter_id);
        $meter_exists = $this->user_model->get_joins(
            'tbl_meter_reading',
            $where
        );
        if (empty($meter_exists)) {
            echo json_decode(1);
        } else {
            $prev_reading = array_reverse($meter_exists)[0]['meter_reading'];
            if ($meter_reading >= $prev_reading) {
                echo json_decode(1);
            } else {

                echo json_decode($prev_reading);
            }
        }
    }

    public function edit_meter_connection()
    {
        $id = $this->input->post('id');
        $meter_name = $this->input->post('meter_name');
        $channel_name = $this->input->post('channel_name');
        $water_right_number = $this->input->post('water_right_number');
        $property = $this->input->post('property');
        $meter_type = $this->input->post('meter_type');
        $serial_number = $this->input->post('serial_number');
        $photo = $this->input->post('imagename');

        $flow_rate_topic_name  = $this->input->post('flow_rate_topic_name');
        $flow_rate_scaling = $this->input->post('flow_rate_scaling');
        $flow_total_reading = $this->input->post('flow_total_reading');
        $flow_total_reading_scaling = $this->input->post('flow_total_reading_scaling');

        $telementry = $this->input->post('telemetry');

        if (!empty($_FILES['file']['name'])) {
            $file_name = $_FILES['file']['name'];
            $tmp = explode('.', $file_name);
            $file_ext = strtolower(end($tmp));

            $imagename = 'Meter' . date('Ymdhis') . '.' . $file_ext;
            $imagedata = $_FILES['file']['tmp_name'];
            $foldername = "assets/meterprofiles/";
            if (!is_dir($foldername)) {
                mkdir($foldername, 0777, true);
            }
            move_uploaded_file($imagedata, $foldername . $imagename);
            unlink('/var/www/clients/client4/web4/web/ICSweb/assets/meterprofiles/' . $photo);
        } else {
            $imagename = $photo;
        }

        $condition = array(
            'id' => $id
        );
        $updatedata = array(
            'serial_number' => $serial_number,
            'meter_name' => $meter_name,
            'image' => $imagename,
            // 'water_right'=>$water_right_number,
            'channel_name' => $channel_name,
            'property' => $property,
            'meter_type' => $meter_type,
            'telementry' => $telementry,
            'flow_rate_topic' =>  $flow_rate_topic_name,
            'flow_rate_scaling' =>  $flow_rate_scaling,
            'flow_total_reading_topic' =>   $flow_total_reading,
            'flow_total_reading_scaling' => $flow_total_reading_scaling
        );
        $is_update = $this
            ->user_model
            ->UPDATEDATA('tbl_meter_connections', $condition, $updatedata);
        if ($is_update) {
            $response = array(
                'status' => true,
                'message' => 'Meter Connection updated Sucessfully'
            );
            print_r(json_encode($response));
        } else {
            $response = array(
                'status' => false,
                'message' => 'Error in updating Meter Connection'
            );
            print_r(json_encode($response));
        }
    }

    public function get_propertname()
    {
        $id = $this
            ->input
            ->post('userid');
        $where = array(
            'id' => $id
        );
        $data = $this
            ->user_model
            ->get_joins('tbl_users', $where);

        print_r(json_encode($data));
    }

    public function add_water_right()
    {
        $userid = $this
            ->input
            ->post('userid');
        $water_right_number = $this
            ->input
            ->post('water_right_number');
        $volume_alloc = $this
            ->input
            ->post('volume_alloc');
        $whereExists = array(
            'wr_number' => $water_right_number
        );
        $exists = $this
            ->user_model
            ->get_joins('tbl_water_right_alloc', $whereExists);
        if (empty($exists)) {
            $field = array(
                'user_id' => $userid,
                'wr_number' => $water_right_number,
                'wr_volume' => $volume_alloc,
                'isActive' => 1
            );

            $insert = $this
                ->user_model
                ->INSERTDATA('tbl_water_right_alloc', $field);
            if ($insert) {
                $response = array(
                    'status' => true,
                    'message' => 'Water right number Added successfully'
                );
                print_r(json_encode($response));
            } else {
                $response = array(
                    'status' => false,
                    'message' => 'Error Addiing water right'
                );
                print_r(json_encode($response));
            }
        } else {
            $response = array(
                'status' => false,
                'message' => 'Water right number already exists'
            );
            print_r(json_encode($response));
        }
    }
    public function load_water_right_data()
    {
        $id = $this
            ->input
            ->post('id');
        $where = array(
            'user_id' => $id
        );
        $data = $this
            ->user_model
            ->get_joins('tbl_water_right_alloc', $where);
        print_r(json_encode($data));
    }
    public function load_details()
    {
        $id = $this
            ->input
            ->post('id');
        $where = array(
            'id' => $id
        );
        $data = $this
            ->user_model
            ->get_joins('tbl_users', $where);
        print_r(json_encode($data));
    }
    public function get_channel_by_id()
    {

        $id = $this
            ->input
            ->post('id');
        if ($id == 'All Channels') {
            $data = array(
                array(
                    'channel_name' => 'All Channels'
                )
            );
            print_r(json_encode($data));
        } else {

            $where = array(
                'id' => $id
            );
            $data = $this
                ->user_model
                ->get_joins('tbl_channels', $where);
            print_r(json_encode($data));
        }
    }

    public function load_usage_summary()
    {

        $user_id = $this
            ->input
            ->post('user_id');
        $wr_number = $this
            ->input
            ->post('wr_number');

        if (!empty($user_id)) {

            $property = '';
            $allocation = 0;
            $permanent = 0;
            $usage = 0;
            $remaining = 0;
            $temporary = 0;
            $remain = 0;

            $join = array(
                array(
                    'table' => 'tbl_users',
                    'condition' => 'tbl_users.id=tbl_meter_connections.userid',
                    'jointype' => 'LEFT'
                ),
                array(
                    'table' => 'tbl_meter_reading',
                    'condition' => 'tbl_meter_reading.meter_id=tbl_meter_connections.id',
                    'jointype' => 'LEFT'
                ),
                array(
                    'table' => 'tbl_water_right_alloc',
                    'condition' => 'tbl_water_right_alloc.id=tbl_meter_connections.water_right',
                    'jointype' => 'LEFT'
                ),
            );
            if (empty($wr_number)) {
                $where = array(
                    'userid' => $user_id
                );
            } else {
                $where = array(
                    'userid' => $user_id,
                    'water_right' => $wr_number
                );
            }



            $group = array('water_right');
            $data = $this
                ->user_model
                ->get_joins('tbl_meter_connections', $where, $join, '', '', $group);

            foreach ($data as $value) {
                if ($value['remaining'] == NULL) {
                    $value['remaining'] = 0;
                    $remain = $value['wr_volume'];
                } else {
                    $remain = $value['remaining'];
                }
                $usage = $usage + ($value['wr_volume'] - $remain);

                $property = $value['username'];
                $allocation = $allocation + $value['wr_volume'];
                $permanent = $permanent + $value['wr_volume'];
                $remaining = $remaining + $value['remaining'];
            }
            $where = array(
                'userid' => $user_id,
                'isActive' => 1
            );

            $data_temporary = $this
                ->user_model
                ->get_joins('tbl_water_orders', $where);


            foreach ($data_temporary as $value) {
                $temporary = $temporary + $value['totalVolume'];
            }


            $result = array(
                'property' => $property,
                'allocation' => $allocation,
                'permanent' => $permanent,
                'usage' => $usage,
                'remaining' => $remaining,
                'temporary' => 0
            );
            print_r(json_encode($result));
        }
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

    public function notification()
    {

        $date = date('Y-m-d');
        $archivedate = date('Y-m-d', (strtotime('-1 day', strtotime($date))));

        $column = array('tbl_notifications.*', "(CASE
        WHEN senderrole = 'user' THEN  tbl_users.username  WHEN senderrole = 'operator' THEN  tbl_operator.username END) as username");

        $where = array(
            'tbl_notifications.date >=' => $archivedate,
        );

        $join = array(
            array(
                'table' => 'tbl_users',
                'condition' => 'tbl_notifications.senderid=tbl_users.id',
                'jointype' => 'LEFT'
            ),
            array(
                'table' => 'tbl_operator',
                'condition' => 'tbl_notifications.senderid=tbl_operator.id',
                'jointype' => 'LEFT'
            ),
        );


        $data['notifications'] = $this->user_model->get_joins('tbl_notifications', $where, $join, $column, '', '', 'tbl_notifications.id DESC');
        $data['page_title'] = 'Notification';
        $data['page_name'] = 'Operator/mail_box';
        $this->load->view('Operator/index', $data);
    }
    public function notification_archive()
    {

        $date = date('Y-m-d');
        $archivedate = date('Y-m-d', (strtotime('-1 day', strtotime($date))));

        $column = array('tbl_notifications.*', "(CASE
        WHEN senderrole = 'user' THEN  tbl_users.username  WHEN senderrole = 'operator' THEN  tbl_operator.username END) as username");

        $where = array(
            'tbl_notifications.date <=' => $archivedate,
        );

        $join = array(
            array(
                'table' => 'tbl_users',
                'condition' => 'tbl_notifications.senderid=tbl_users.id',
                'jointype' => 'LEFT'
            ),
            array(
                'table' => 'tbl_operator',
                'condition' => 'tbl_notifications.senderid=tbl_operator.id',
                'jointype' => 'LEFT'
            ),
        );

        $data['notifications'] = $this->user_model->get_joins('tbl_notifications', $where, $join, $column, '', '', 'tbl_notifications.id DESC');
        $data['page_title'] = 'Notification';
        $data['page_name'] = 'Operator/mail_box_archive';
        $this->load->view('Operator/index', $data);
    }

    public function load_system_total_report()
    {
        $result = array();
        $columns = array(
            'username',
            'contact_name',
            'meter_name',
            'wr_number',
            'sum(meter_reading) as meter_reading',
            '(wr_volume- sum(meter_reading) ) as remaining',
            'wr_volume',
            'tbl_channels.channel_name',
            'serial_number',
            'tbl_metertype.type',
            'tbl_charge_codes.charge_code'
        );
        $join = array(
            array(
                'table' => 'tbl_meter_connections',
                'condition' => 'tbl_meter_connections.id=tbl_meter_reading.meter_id',
                'jointype' => 'LEFT'
            ),
            array(
                'table' => 'tbl_water_right_alloc',
                'condition' => 'tbl_water_right_alloc.id=tbl_meter_connections.water_right',
                'jointype' => 'LEFT'
            ),
            // array( 'table' => 'tbl_water_rights', 'condition' => 'tbl_water_rights.id=tbl_meter_connections.water_right', 'jointype' => 'LEFT' ),
            array(
                'table' => 'tbl_metertype',
                'condition' => 'tbl_meter_connections.meter_type=tbl_metertype.id',
                'jointype' => 'LEFT'
            ),

            array(
                'table' => 'tbl_users',
                'condition' => 'tbl_users.id=tbl_meter_connections.userid',
                'jointype' => 'LEFT'
            ),
            array(
                'table' => 'tbl_charge_codes',
                'condition' => 'tbl_charge_codes.id=tbl_meter_reading.charge_code',
                'jointype' => 'LEFT'
            ),
            array(
                'table' => 'tbl_channels',
                'condition' => 'tbl_channels.id=tbl_meter_connections.channel_name',
                'jointype' => 'LEFT'
            ),
        );

        $channels = $this
            ->user_model
            ->get_joins('tbl_meter_reading', '', $join, $columns, '', 'tbl_meter_reading.meter_id');

        foreach ($channels as $value) {

            $sign = $this->check_numb($value['remaining']);

            $channel = array(
                'username' => $value['username'],
                'contact_name' => $value['contact_name'],
                'wr_number' => $value['wr_number'],
                'serial_number' => $value['serial_number'],
                'meter_name' => $value['meter_name'],
                'type' => $value['type'],
                'charge_code' => $value['charge_code'],
                'meter_reading' => $value['meter_reading'],
                'remaining' => $value['remaining'],
                'wr_volume' => $value['wr_volume'],
                'channel_name' => $value['channel_name'],
                'sign' => $sign,
                'total' => $value['meter_reading'],
            );

            // echo '<pre>';
            // print_r($channel).die;

            array_push($result, $channel);
        }
        // echo  $this->db->last_query();
        print_r(json_encode($result));
    }

    public function orders()
    {
        // if ($this->input->post('approved')) {
        //     $operatorid = $this
        //         ->session
        //         ->userdata('user_id');
        //     $update_data = array(
        //         'operatorid' => $operatorid,
        //         'isActive' => 1
        //     );
        //     $id = $this->input->post('order_id');
        //     $userid = $this->input->post('userid');

        //     $where = array('id' => $id);
        //     $update = $this->user_model->UPDATEDATA('tbl_water_orders', $where, $update_data);

        //     if ($update) {
        //         $this
        //             ->session
        //             ->set_flashdata('success', 'Order Approved Successfully');

        //         $update_data = array(
        //             'senderid' => $userid,
        //             'receiverid' => $operatorid,
        //             'senderrole' => 'operator',
        //             'title' => 'Water Order',
        //             'message' => 'Approved Order',
        //             'status' => 'Approved'
        //         );

        //         $whereuser = array('role' => 'user', 'userid' => $userid);
        //         $usertokenExists = $this->user_model->get_joins('tbl_tokens', $whereuser);
        //         if ($usertokenExists) {
        //             $notifiyUser = array(
        //             'title' => 'Approved Water Order',
        //             'message' => 'Approved Water Order',
        //             'token' => $usertokenExists[0]['devicetoken'],
        //             'type' => 101
        //             );
        //             $pushStatis = $this->cronPushNotification($notifiyUser);
        //         }

        //         $update = $this->user_model->INSERTDATA('tbl_notifications', $update_data);
                    
        //     } else {
        //         $this
        //             ->session
        //             ->set_flashdata('error', 'Error approving order');
        //     }
            
        //     redirect($_SERVER['HTTP_REFERER']);
        //     exit;
        // }

        if ($this->input->post('denied')) {
            $operatorid = $this
                ->session
                ->userdata('user_id');
            $update_data = array(
                'operatorid' => $operatorid,
                'isActive' => 3
            );
            $id = $this->input->post('order_id');
            $userid = $this->input->post('userid');

            $where = array('id' => $id);
            $update = $this->user_model->UPDATEDATA('tbl_water_orders', $where, $update_data);

            if ($update) {
                $this
                    ->session
                    ->set_flashdata('success', 'Order Denied Successfully');

                $update_data = array(
                    'senderid' => $userid,
                    'receiverid' => $operatorid,
                    'senderrole' => 'operator',
                    'title' => 'Water Order',
                    'message' => 'Denied Order',
                    'status' => 'Denied'
                );

                $where = array('id' => $id);


                $update = $this->user_model->UPDATEDATA('tbl_notifications', $where, $update_data);

                $whereuser = array('role' => 'user', 'userid' => $userid);
                $usertokenExists = $this->user_model->get_joins('tbl_tokens', $whereuser);
                if ($usertokenExists) {
                    $notifiyUser = array(
                    'title' => 'Denied Water Order',
                    'message' => 'Denied Water Order',
                    'token' => $usertokenExists[0]['devicetoken'],
                    'type' => 101
                    );
                    $this->cronPushNotification($notifiyUser);
                }

            } else {
                $this
                    ->session
                    ->set_flashdata('error', 'Error dening order');
            }

            redirect($_SERVER['HTTP_REFERER']);
            exit;
        }

        $data['p_graph_value'] = $this->graph_values(0);
        $data['a_graph_value'] = $this->graph_values(1);
        $data['c_graph_value'] = $this->graph_orders(0);

        $data['page_title'] = 'Water Order System';
        $data['page_name'] = 'Operator/orders';

        $this->load->view('Operator/index', $data);
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


    public function get_waterright()
    {
        $userid = $this
            ->input
            ->get('userid');
        $columns = array(
            'contact_name'
        );
        $column = array(
            'tbl_meter_connections.id as meter_id',
            'meter_name'
        );
        $where = array(
            'id' => $userid
        );
        $wheremeter = array(
            'user_id' => $userid
        );
        $get_contactname = $this
            ->user_model
            ->get_joins('tbl_users', $where, '', $columns);

        $get_metername = $this
            ->user_model
            ->get_joins('tbl_water_right_alloc', $wheremeter);
        $get_metername = array(
            'meter_name' => $get_metername
        );
        array_push($get_contactname, $get_metername);

        print_r(json_encode($get_contactname));
    }

    public function get_meterconnection()
    {
        $userid = $this
            ->input
            ->post('user_id');
        $columns = array(
            'id',
            'meter_name'
        );
        if (!empty($userid)) {
            $where = array(
                'userid' => $userid
            );
            $get_meterconnection = $this
                ->user_model
                ->get_joins('tbl_meter_connections', $where, '', $columns);
        } else {
            $get_meterconnection = $this
                ->user_model
                ->get_joins('tbl_meter_connections', '', '', $columns);
        }
        print_r(json_encode($get_meterconnection));
    }

    public function get_serialnumber()
    {
        $userid = $this
            ->input
            ->post('user_id');

        $columns = array(
            'id',
            'serial_number'
        );
        if (!empty($userid)) {
            $where = array(
                'userid' => $userid
            );
            $get_meterconnection = $this
                ->user_model
                ->get_joins('tbl_meter_connections', $where, '', $columns);
        } else {
            $get_meterconnection = $this
                ->user_model
                ->get_joins('tbl_meter_connections', '', '', $columns);
        }
        print_r(json_encode($get_meterconnection));
    }

    public function load_upcoming_water_order()
    {
        $current_orders = array();

        $channel_id = $this->input->post('channel_id');
        $order_usernames = $this->input->post('userid');
        if ($order_usernames == 0) {
            if ($channel_id == 0) {
                $where = array();
            } else {
                $where = [
                    'tbl_channels.id' => $channel_id,
                ];
            }
        } else {
            if ($channel_id == 0) {
                $where = array('tbl_meter_connections.userid' => $order_usernames,);
            } else {
                $where = [
                    'tbl_channels.id' => $channel_id,
                    'tbl_meter_connections.userid' => $order_usernames,
                ];
            }
        }


        $site_url = base_url() . 'assets/meterprofiles/';
        $columns = array('tbl_water_orders.*', 'tbl_meter_connections.id as meterid', 'tbl_meter_connections.meter_name as meter_name', 'tbl_meter_connections.serial_number as serial_number', 'tbl_meter_connections.property as property', 'tbl_meter_connections.id as meterid', 'tbl_meter_connections.userid as meteruserid', "CONCAT('$site_url', tbl_meter_connections.image) as meterimage", 'tbl_channels.channel_name as channel_name', 'tbl_metertype.type as type', 'tbl_water_right_alloc.wr_number as wr_number', 'tbl_water_right_alloc.wr_volume as wr_volume', 'tbl_users.username as username', 'tbl_users.contact_name as contact_name', 'tbl_users.email as email');

        $join = array(
            array('table' => 'tbl_meter_connections', 'condition' => 'tbl_meter_connections.id=tbl_water_orders.meter', 'jointype' => 'LEFT'),
            array('table' => 'tbl_channels', 'condition' => 'tbl_channels.id=tbl_meter_connections.channel_name', 'jointype' => 'LEFT'),
            array('table' => 'tbl_metertype', 'condition' => 'tbl_metertype.id=tbl_meter_connections.meter_type', 'jointype' => 'LEFT'),
            array('table' => 'tbl_water_right_alloc', 'condition' => 'tbl_water_right_alloc.id=tbl_meter_connections.water_right', 'jointype' => 'LEFT'),
            array('table' => 'tbl_users', 'condition' => 'tbl_users.id=tbl_water_orders.userid', 'jointype' => 'LEFT'),
        );

        $current_date = date('Y-m-d');

        $orderExists = $this->user_model->get_joins('tbl_water_orders', $where, $join, $columns);
        // echo $this->db->last_query();

        foreach ($orderExists as $orders) {
            $s = $orders['startTime'];
            $dt = new DateTime($s);

            $date = $dt->format('Y-m-d');
            if ($date > $current_date) {
                if ($orders['isActive'] == 1) {
                    $action = '<a href="#" data-toggle="modal" data-target="#deny_order"><i class="fa fa-times fa-2x" aria-hidden="true" style="color:red"></i></a> <a href="#" data-toggle="modal" data-target="#edit_order" style="margin-left:5%;"><i class="fa fa-pencil fa-2x" aria-hidden="true" style="color:black"></i></a>';
                } else {

                    $action = '<a href="#" data-toggle="modal" data-target="#approve_order_' . $orders['id'] . '"><i class="fa fa-check fa-2x" aria-hidden="true" style="color:green"></i></a> <a href="#" data-toggle="modal" data-target="#deny_order"><i class="fa fa-times fa-2x" aria-hidden="true" style="color:red"></i></a> <a href="#" data-toggle="modal" data-target="#edit_order"><i class="fa fa-pencil fa-2x" aria-hidden="true" style="color:black"></i></a>';
                }

                $orders = array(
                    "id" => $orders['id'],
                    "operatorid" => $orders['operatorid'],
                    "userid" => $orders['userid'],
                    "meter" => $orders['meter'],
                    "startTime" => $orders['startTime'],
                    "flowRate" => $orders['flowRate'],
                    "duration" => $orders['duration'],
                    "endTime" => $orders['endTime'],
                    "totalVolume" => $orders['totalVolume'],
                    "weather" => $orders['username'],
                    "orderedDate" => $orders['orderedDate'],
                    "isActive" => $orders['isActive'],
                    "meterid" => $orders['meterid'],
                    "meter_name" => $orders['meter_name'],
                    "serial_number" => $orders['serial_number'],
                    "meteruserid" => $orders['meteruserid'],
                    "channel_name" => $orders['channel_name'],
                    "type" => $orders['type'],
                    "wr_number" => $orders['wr_number'],
                    "wr_volume" => $orders['wr_volume'],
                    "username" => $orders['username'],
                    "action" => $action,
                    "modal" => ''
                );

                array_push($current_orders, $orders);
            }
        }

        print_r(json_encode($current_orders));
    }

    public function graph_orders($status)
    {
        $current_date = date('Y-m-d');
        $tommorow = date("Y-m-d", time() + 86400);

        $data = array(
            array('start' => '00:00', 'end' => '01:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-00:00' . '-00:00'), 'y' => 0)),
            array('start' => '01:00', 'end' => '02:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-01:00'), 'y' => 0)), array('start' => '02:00', 'end' => '03:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-02:00'), 'y' => 0)), array('start' => '03:00', 'end' => '04:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-03:00'), 'y' => 0)), array('start' => '04:00', 'end' => '05:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-04:00'), 'y' => 0)), array('start' => '05:00', 'end' => '06:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-05:00'), 'y' => 0)), array('start' => '06:00', 'end' => '07:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-06:00'), 'y' => 0)), array('start' => '07:00', 'end' => '08:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-07:00'), 'y' => 0)), array('start' => '08:00', 'end' => '09:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-08:00'), 'y' => 0)), array('start' => '09:00', 'end' => '10:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-09:00'), 'y' => 0)), array('start' => '10:00', 'end' => '11:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-010:00'), 'y' => 0)), array('start' => '11:00', 'end' => '12:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-11:00'), 'y' => 0)), array('start' => '12:00', 'end' => '13:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-12:00'), 'y' => 0)), array('start' => '13:00', 'end' => '14:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-13:00'), 'y' => 0)), array('start' => '14:00', 'end' => '15:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-14:00'), 'y' => 0)), array('start' => '15:00', 'end' => '16:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-15:00'), 'y' => 0)), array('start' => '16:00', 'end' => '17:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-16:00'), 'y' => 0)), array('start' => '17:00', 'end' => '18:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-17:00'), 'y' => 0)), array('start' => '18:00', 'end' => '19:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-18:00'), 'y' => 0)), array('start' => '19:00', 'end' => '20:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-19:00'), 'y' => 0)), array('start' => '20:00', 'end' => '21:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-20:00'), 'y' => 0)), array('start' => '21:00', 'end' => '22:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-21:00'), 'y' => 0)), array('start' => '22:00', 'end' => '23:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-22:00'), 'y' => 0)), array('start' => '23:00', 'end' => '00:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-23:00'), 'y' => 0))
        );
        $datas = array(
            array('start' => '00:00', 'end' => '01:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-00:00'), 'y' => 0)),
            array('start' => '01:00', 'end' => '02:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-01:00'), 'y' => 0)), array('start' => '02:00', 'end' => '03:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-02:00'), 'y' => 0)), array('start' => '03:00', 'end' => '04:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-03:00'), 'y' => 0)), array('start' => '04:00', 'end' => '05:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-04:00'), 'y' => 0)), array('start' => '05:00', 'end' => '06:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-05:00'), 'y' => 0)), array('start' => '06:00', 'end' => '07:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-06:00'), 'y' => 0)), array('start' => '07:00', 'end' => '08:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-07:00'), 'y' => 0)), array('start' => '08:00', 'end' => '09:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-08:00'), 'y' => 0)), array('start' => '09:00', 'end' => '10:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-09:00'), 'y' => 0)), array('start' => '10:00', 'end' => '11:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-10:00'), 'y' => 0)), array('start' => '11:00', 'end' => '12:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-11:00'), 'y' => 0)), array('start' => '12:00', 'end' => '13:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-12:00'), 'y' => 0)), array('start' => '13:00', 'end' => '14:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-13:00'), 'y' => 0)), array('start' => '14:00', 'end' => '15:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-14:00'), 'y' => 0)), array('start' => '15:00', 'end' => '16:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-15:00'), 'y' => 0)), array('start' => '16:00', 'end' => '17:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-16:00'), 'y' => 0)), array('start' => '17:00', 'end' => '18:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-17:00'), 'y' => 0)), array('start' => '18:00', 'end' => '19:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-18:00'), 'y' => 0)), array('start' => '19:00', 'end' => '20:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-19:00'), 'y' => 0)), array('start' => '20:00', 'end' => '21:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-20:00'), 'y' => 0)), array('start' => '21:00', 'end' => '22:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-21:00'), 'y' => 0)), array('start' => '22:00', 'end' => '23:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-22:00'), 'y' => 0)), array('start' => '23:00', 'end' => '00:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-23:00'), 'y' => 0))
        );

        $result = array();
        $val1 = array();
        $val2 = array();

        $upcoming_orders = array();
        $date = date('Y-m-d h:i:s');

        $site_url = base_url() . 'assets/meterprofiles/';
        $columns = array('tbl_water_orders.*', 'tbl_meter_connections.id as meterid', 'tbl_meter_connections.meter_name as meter_name', 'tbl_meter_connections.serial_number as serial_number', 'tbl_meter_connections.property as property', 'tbl_meter_connections.id as meterid', 'tbl_meter_connections.userid as meteruserid', "CONCAT('$site_url', tbl_meter_connections.image) as meterimage", 'tbl_channels.channel_name as channel_name', 'tbl_metertype.type as type', 'tbl_water_right_alloc.wr_number as wr_number', 'tbl_water_right_alloc.wr_volume as wr_volume', 'tbl_users.username as username', 'tbl_users.contact_name as contact_name', 'tbl_users.email as email');
        $where = array('tbl_water_orders.isActive' => $status);
        $join = array(
            array('table' => 'tbl_meter_connections', 'condition' => 'tbl_meter_connections.id=tbl_water_orders.meter', 'jointype' => 'LEFT'),
            array('table' => 'tbl_channels', 'condition' => 'tbl_channels.id=tbl_meter_connections.channel_name', 'jointype' => 'LEFT'),
            array('table' => 'tbl_metertype', 'condition' => 'tbl_metertype.id=tbl_meter_connections.meter_type', 'jointype' => 'LEFT'),
            array('table' => 'tbl_water_right_alloc', 'condition' => 'tbl_water_right_alloc.id=tbl_meter_connections.water_right', 'jointype' => 'LEFT'),
            array('table' => 'tbl_users', 'condition' => 'tbl_users.id=tbl_water_orders.userid', 'jointype' => 'LEFT'),
        );
        $orderExists = $this->user_model->get_joins('tbl_water_orders', $where, $join, $columns, '', '', 'tbl_water_orders.startTime');

        if ($orderExists) {
            foreach ($orderExists as $key => $orders) {
                $dt = new DateTime($orders['startTime']);

                $startdate = $dt->format('Y-m-d');

                $dt = new DateTime($orders['endTime']);

                $enddate = $dt->format('Y-m-d');
                $dt = new DateTime($orders['endTime']);

                $endTime = $dt->format('H');
                $dt = new DateTime($orders['startTime']);

                $startTime = $dt->format('H');
                if ($startdate < $current_date && $enddate < $current_date) {
                } else {

                    // if($startdate<$current_date && $enddate==$current_date)
                    // {
                    //
                    //
                    //   $data1=array('start'=>0,'end'=>$endTime+1,'flowRate'=>$orders['flowRate'],'date'=>$enddate);
                    //   array_push($result,$data1);
                    //
                    // }
                    // else if($startdate<$current_date && $enddate>$current_date)
                    // {
                    //   $data1=array('start'=>0,'end'=>24,'flowRate'=>$orders['flowRate'],'date'=>$current_date);
                    //   array_push($result,$data1);
                    //
                    //   if($enddate==$tommorow)
                    //   {
                    //     $data1=array('start'=>0,'end'=>$endTime,'flowRate'=>$orders['flowRate'],'date'=>$tommorow);
                    //     array_push($result,$data1);
                    //   }else if($enddate>$tommorow)
                    //   {
                    //     $data1=array('start'=>0,'end'=>24,'flowRate'=>$orders['flowRate'],'date'=>$tommorow);
                    //     array_push($result,$data1);
                    //   }
                    //
                    //
                    // }
                    // else if($startdate==$current_date && $enddate==$current_date){
                    //   $data1=array('start'=>$startTime,'end'=>$endTime,'flowRate'=>$orders['flowRate'],'date'=>$current_date);
                    //   array_push($result,$data1);
                    //
                    //
                    //   }
                    // else
                    if ($startdate > $current_date) {

                        if ($startdate == $tommorow && $enddate == $tommorow) {
                            $data1 = array('start' => $startTime + 1, 'end' => $endTime + 1, 'flowRate' => $orders['flowRate'], 'date' => $tommorow);
                            array_push($result, $data1);
                        } else if ($startdate == $tommorow && $enddate > $tommorow) {
                            $data1 = array('start' => $startTime, 'end' => 24, 'flowRate' => $orders['flowRate'], 'date' => $tommorow);
                            array_push($result, $data1);
                        }
                    }
                    // if($startdate==$current_date && $enddate==$tommorow)
                    // {
                    //   $data1=array('start'=>$startTime,'end'=>24,'flowRate'=>$orders['flowRate'],'date'=>$current_date);
                    //   array_push($result,$data1);
                    //
                    //     $data1=array('start'=>0,'end'=>$endTime,'flowRate'=>$orders['flowRate'],'date'=>$tommorow);
                    //   array_push($result,$data1);
                    // }
                }
            }
        }

        foreach ($result as $key => $value) {
            // code...
            if ($value['date'] == $current_date) {
                array_push($val1, $value);
            }
            if ($value['date'] == $tommorow) {
                array_push($val2, $value);
            }
        }

        foreach ($val1 as $key => $value) {
            for ($i = $value['start']; $i < $value['end']; $i++) {
                $data[$i]['flowRate'] = $data[$i]['flowRate'] + $value['flowRate'];
                $data[$i]['date'] = $value['date'];
                $time =   $value['date'] . '-' . $data[$i]['start'];
                $time = str_replace(array('-', ':'), ',', $time);

                $data[$i]['graph'] = array('x' => $time, 'y' => $data[$i]['flowRate']);
            }
            // code...
        }
        foreach ($val2 as $key => $value) {
            for ($i = $value['start']; $i < $value['end']; $i++) {
                $datas[$i]['flowRate'] = $datas[$i]['flowRate'] + $value['flowRate'];
                $datas[$i]['date'] = $value['date'];
                $time =   $value['date'] . '-' . $datas[$i]['start'];
                $time = str_replace(array('-', ':'), ',', $time);
                $datas[$i]['graph'] = array('x' => $time, 'y' => $datas[$i]['flowRate']);
            }
            // code...
        }
        return (array_merge($data, $datas));
        // echo "<pre>";
        // print_r(array_merge($data,$datas));
        // exit;
    }

    public function load_current_water_order()
    {
        $current_orders = array();

        $channel_id = $this->input->post('channel_id');

        $site_url = base_url() . 'assets/meterprofiles/';
        $columns = array('tbl_water_orders.*', 'tbl_meter_connections.id as meterid', 'tbl_meter_connections.meter_name as meter_name', 'tbl_meter_connections.serial_number as serial_number', 'tbl_meter_connections.property as property', 'tbl_meter_connections.id as meterid', 'tbl_meter_connections.userid as meteruserid', "CONCAT('$site_url', tbl_meter_connections.image) as meterimage", 'tbl_channels.channel_name as channel_name', 'tbl_metertype.type as type', 'tbl_water_right_alloc.wr_number as wr_number', 'tbl_water_right_alloc.wr_volume as wr_volume', 'tbl_users.username as username', 'tbl_users.contact_name as contact_name', 'tbl_users.email as email');

        $join = array(
            array('table' => 'tbl_meter_connections', 'condition' => 'tbl_meter_connections.id=tbl_water_orders.meter', 'jointype' => 'LEFT'),
            array('table' => 'tbl_channels', 'condition' => 'tbl_channels.id=tbl_meter_connections.channel_name', 'jointype' => 'LEFT'),
            array('table' => 'tbl_metertype', 'condition' => 'tbl_metertype.id=tbl_meter_connections.meter_type', 'jointype' => 'LEFT'),
            array('table' => 'tbl_water_right_alloc', 'condition' => 'tbl_water_right_alloc.id=tbl_meter_connections.water_right', 'jointype' => 'LEFT'),
            array('table' => 'tbl_users', 'condition' => 'tbl_users.id=tbl_water_orders.userid', 'jointype' => 'LEFT'),
        );

        $current_date = date('Y-m-d');

        if ($channel_id == 0) {
            $where = array('tbl_water_orders.isActive' => 1);
        } else {
            $where = array('tbl_water_orders.isActive' => 1, 'tbl_channels.id' => $channel_id);
        }


        $orderExists = $this->user_model->get_joins('tbl_water_orders', $where, $join, $columns);

        foreach ($orderExists as $orders) {
            $s = $orders['endTime'];
            $dt = new DateTime($s);

            $date = $dt->format('Y-m-d');
            if ($date > $current_date) {
                $orders = array(
                    "id" => $orders['id'],
                    "operatorid" => $orders['operatorid'],
                    "userid" => $orders['userid'],
                    "meter" => $orders['meter'],
                    "startTime" => $orders['startTime'],                          "flowRate" => $orders['flowRate'],
                    "duration" => $orders['duration'],                            "endTime" => $orders['endTime'],                         "totalVolume" => $orders['totalVolume'],               "weather" => $orders['username'],                            "orderedDate" => $orders['orderedDate'],                   "isActive" => $orders['isActive'],
                    "meterid" => $orders['meterid'],
                    "meter_name" => $orders['meter_name'],
                    "serial_number" => $orders['serial_number'],
                    "meteruserid" => $orders['meteruserid'],
                    "channel_name" => $orders['channel_name'],
                    "type" => $orders['type'],
                    "wr_number" => $orders['wr_number'],
                    "wr_volume" => $orders['wr_volume'],
                    "username" => $orders['username'],
                    "action" => '-',
                    "modal" => ''
                );


                array_push($current_orders, $orders);
            }
        }

        print_r(json_encode($current_orders));
    }

    public function load_allwater_orders()
    {
        $current_orders = [];

        $channel_id = $this->input->post('channel_id');
        $order_usernames = $this->input->post('userid');

        if ($order_usernames == 0) {
            if ($channel_id == 0) {
                $where = [
                    'tbl_water_orders.isActive =' => 0,
                ];
            } else {
                $where = [
                    'tbl_channels.id' => $channel_id,
                    'tbl_water_orders.isActive =' => 0,
                ];
            }
        } else {
            if ($channel_id == 0) {
                $where = [
                    'tbl_water_orders.isActive =' => 0,
                    'tbl_meter_connections.userid' => $order_usernames,
                ];
            } else {
                $where = [
                    'tbl_channels.id' => $channel_id,
                    'tbl_water_orders.isActive =' => 0,
                    'tbl_meter_connections.userid' => $order_usernames,
                ];
            }
        }

        $site_url = base_url() . 'assets/meterprofiles/';

        $columns = [
            'tbl_water_orders.*',
            'tbl_meter_connections.id as meterid',
            'tbl_meter_connections.meter_name as meter_name',
            'tbl_meter_connections.serial_number as serial_number',
            'tbl_meter_connections.property as property',
            'tbl_meter_connections.userid as meteruserid',
            "CONCAT('$site_url', tbl_meter_connections.image) as meterimage",
            'tbl_channels.channel_name as channel_name',
            'tbl_metertype.type as type',
            'tbl_water_right_alloc.wr_number as wr_number',
            'tbl_water_right_alloc.wr_volume as wr_volume',
            'tbl_users.username as username',
            'tbl_users.contact_name as contact_name',
            'tbl_users.email as email',
        ];

        $join = [
            [
                'table' => 'tbl_meter_connections',
                'condition' =>
                'tbl_meter_connections.id=tbl_water_orders.meter',
                'jointype' => 'LEFT',
            ],
            [
                'table' => 'tbl_channels',
                'condition' =>
                'tbl_channels.id=tbl_meter_connections.channel_name',
                'jointype' => 'LEFT',
            ],
            [
                'table' => 'tbl_metertype',
                'condition' =>
                'tbl_metertype.id=tbl_meter_connections.meter_type',
                'jointype' => 'LEFT',
            ],
            [
                'table' => 'tbl_water_right_alloc',
                'condition' =>
                'tbl_water_right_alloc.id=tbl_meter_connections.water_right',
                'jointype' => 'LEFT',
            ],
            [
                'table' => 'tbl_users',
                'condition' => 'tbl_users.id=tbl_water_orders.userid',
                'jointype' => 'LEFT',
            ],
        ];

        $orderExists = $this->user_model->get_joins(
            'tbl_water_orders',
            $where,
            $join,
            $columns,
            '',
            '',
            'tbl_water_orders.id DESC'
        );

        // echo '<pre>';
        // print_r($orderExists);
        // die;

        $current_date = date('Y-m-d');

        foreach ($orderExists as $orders) {

            $s = $orders['startTime'];
            $dt = new DateTime($s);
            $date = $dt->format('Y-m-d');
            $s = $orders['endTime'];
            $dt = new DateTime($s);
            $end_date = $dt->format('Y-m-d');

            if ($date >= $current_date) {

                if ($orders['isActive'] == 1) {
                    $action =
                        '<a href="#" data-toggle="modal" data-target="#deny_order_' .
                        $orders['id'] .
                        '"><i class="fa fa-times fa-2x" aria-hidden="true" style="color:red"></i></a> <a href="#" class="openEditModal" data-toggle="modal" data-target="#edit_order"  data-id="' . $orders['id'] . '" data-user_name="' . $orders['username'] . '" data-start="' . $orders['startTime'] . '" data-end="' . $orders['endTime'] . '" data-duration="' . $orders['duration'] . '" data-flow_rate="' . $orders['flowRate'] . '" data-volume="' . $orders['totalVolume'] . '" data-userid="' . $orders['userid'] . '" style="margin-left:5%;"><i class="fa fa-pencil fa-2x" aria-hidden="true" style="color:black"></i></a>';
                } else {
                    $action =
                        '<a href="#" data-toggle="modal" data-target="#approve_order_' .
                        $orders['id'] .
                        '"><i class="fa fa-check fa-2x" aria-hidden="true" style="color:green"></i></a> <a href="#" data-toggle="modal" data-target="#deny_order_' .
                        $orders['id'] .
                        '"><i class="fa fa-times fa-2x" aria-hidden="true" style="color:red"></i></a> <a href="#" data-toggle="modal" data-target="#edit_order"  data-id="' . $orders['id'] . '" data-user_name="' . $orders['username'] . '" data-start="' . $orders['startTime'] . '" data-end="' . $orders['endTime'] . '" data-duration="' . $orders['duration'] . '" data-flow_rate="' . $orders['flowRate'] . '" data-volume="' . $orders['totalVolume'] . '" data-userid="' . $orders['userid'] . '"><i class="fa fa-pencil fa-2x" aria-hidden="true" style="color:black"></i></a>';
                }

                $modal =
                    '<div class="modal fade" id="approve_order_' .
                    $orders['id'] .
                    '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog" role="document"><form action="" method="POST"> <div class="modal-content"> <div class="modal-header"><h3 class="modal-title" id="exampleModalLabel">Approve Order</h3><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><p style="font-size:15px;">Are you sure you want to approve this order<input type="hidden" name="order_id" value="' .
                    $orders['id'] .
                    '"><input type="hidden" name="userid" value="' .
                    $orders['userid'] .
                    '"></p></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>  <button type="submit" class="btn btn-success" name="approved" value="approved">Approve Order</button></div></div></form></div></div>

                    <div class="modal fade" id="deny_order_' .
                    $orders['id'] .
                    '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog" role="document"><form action="" method="POST"> <div class="modal-content"> <div class="modal-header"><h3 class="modal-title" id="exampleModalLabel">Deny Order</h3><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><p style="font-size:15px;">Are you sure you want to deny this order<input type="hidden" name="order_id" value="' .
                    $orders['id'] .
                    '"><input type="hidden" name="userid" value="' .
                    $orders['userid'] .
                    '"></p></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>  <button type="submit" class="btn btn-danger" name="denied" value="denied">Deny Order</button></div></div></form></div></div>
                    ';
            } else if ($date < $current_date && $end_date >= $current_date) {
                $action = '<a href="#" data-toggle="modal" data-target="#deny_order_' .
                    $orders['id'] .
                    '"><i class="fa fa-times fa-2x" aria-hidden="true" style="color:red"></i></a> <a href="#" class="openEditModal" data-toggle="modal" data-target="#edit_order"  data-id="' . $orders['id'] . '" data-user_name="' . $orders['username'] . '" data-start="' . $orders['startTime'] . '" data-end="' . $orders['endTime'] . '" data-duration="' . $orders['duration'] . '" data-flow_rate="' . $orders['flowRate'] . '" data-volume="' . $orders['totalVolume'] . '" data-userid="' . $orders['userid'] . '" style="margin-left:5%;"><i class="fa fa-pencil fa-2x" aria-hidden="true" style="color:black"></i></a>';
                $modal = '';
            } else {
                $action = '-';
                $modal = '';
            }


            $orders = [
                "id" => $orders['id'],
                "operatorid" => $orders['operatorid'],
                "userid" => $orders['userid'],
                "meter" => $orders['meter'],
                "startTime" => $orders['startTime'],
                "flowRate" => $orders['flowRate'],
                "duration" => $orders['duration'],
                "endTime" => $orders['endTime'],
                "totalVolume" => $orders['totalVolume'],
                "weather" => $orders['username'],
                "orderedDate" => $orders['orderedDate'],
                "isActive" => $orders['isActive'],
                "meterid" => $orders['meterid'],
                "meter_name" => $orders['meter_name'],
                "serial_number" => $orders['serial_number'],
                "meteruserid" => $orders['meteruserid'],
                "channel_name" => $orders['channel_name'],
                "type" => $orders['type'],
                "wr_number" => $orders['wr_number'],
                "wr_volume" => $orders['wr_volume'],
                "username" => $orders['username'],
                "modal" => $modal ? $modal : '',
                "action" => $action ? $action : '-',
            ];
            array_push($current_orders, $orders);
        }

        //echo "<pre>";
        //print_r($current_orders) . die;

        print_r(json_encode($current_orders));
    }

    public function load_allwater_orders_archive()
    {
        $current_orders = [];

        $channel_id = $this->input->post('channel_id');
        $order_usernames = $this->input->post('userid');

        $date = date('Y-m-d');
        $archivedate = date('Y-m-d', (strtotime('-2 day', strtotime($date))));

        if ($order_usernames == 0) {
            if ($channel_id == 0) {
                $where = [
                    'tbl_water_orders.isActive !=' => 0,
                ];
            } else {
                //echo "if else";
                $where = [
                    'tbl_channels.id' => $channel_id,
                    'tbl_water_orders.isActive !=' => 0,
                    'tbl_water_orders.orderedDate <=' => $archivedate,
                ];
            }
        } else {
            if ($channel_id == 0) {
                //echo "else if";
                $where = [
                    'tbl_water_orders.isActive !=' => 0,
                    'tbl_meter_connections.userid' => $order_usernames,
                    'tbl_water_orders.orderedDate <=' => $archivedate,
                ];
            } else {
                //echo "else else";
                $where = [
                    'tbl_channels.id' => $channel_id,
                    'tbl_water_orders.isActive !=' => 3,
                    'tbl_meter_connections.userid' => $order_usernames,
                ];
            }
        }

        $site_url = base_url() . 'assets/meterprofiles/';
        $columns = [
            'tbl_water_orders.*',
            'tbl_meter_connections.id as meterid',
            'tbl_meter_connections.meter_name as meter_name',
            'tbl_meter_connections.serial_number as serial_number',
            'tbl_meter_connections.property as property',
            'tbl_meter_connections.userid as meteruserid',
            "CONCAT('$site_url', tbl_meter_connections.image) as meterimage",
            'tbl_channels.channel_name as channel_name',
            'tbl_metertype.type as type',
            'tbl_water_right_alloc.wr_number as wr_number',
            'tbl_water_right_alloc.wr_volume as wr_volume',
            'tbl_users.username as username',
            'tbl_users.contact_name as contact_name',
            'tbl_users.email as email',
        ];

        $join = [
            [
                'table' => 'tbl_meter_connections',
                'condition' =>
                'tbl_meter_connections.id=tbl_water_orders.meter',
                'jointype' => 'LEFT',
            ],
            [
                'table' => 'tbl_channels',
                'condition' =>
                'tbl_channels.id=tbl_meter_connections.channel_name',
                'jointype' => 'LEFT',
            ],
            [
                'table' => 'tbl_metertype',
                'condition' =>
                'tbl_metertype.id=tbl_meter_connections.meter_type',
                'jointype' => 'LEFT',
            ],
            [
                'table' => 'tbl_water_right_alloc',
                'condition' =>
                'tbl_water_right_alloc.id=tbl_meter_connections.water_right',
                'jointype' => 'LEFT',
            ],
            [
                'table' => 'tbl_users',
                'condition' => 'tbl_users.id=tbl_water_orders.userid',
                'jointype' => 'LEFT',
            ],
        ];


        $orderExists = $this->user_model->get_joins(
            'tbl_water_orders',
            $where,
            $join,
            $columns,
            '',
            '',
            'tbl_water_orders.id DESC'
        );

        // echo '<pre>';
        // print_r($orderExists);
        // die;


        $current_date = date('Y-m-d');
        foreach ($orderExists as $orders) {
            $s = $orders['startTime'];
            $dt = new DateTime($s);

            $date = $dt->format('Y-m-d');
            $s = $orders['endTime'];
            $dt = new DateTime($s);
            $end_date = $dt->format('Y-m-d');

            if ($date >= $current_date) {

                if ($orders['isActive'] == 1) {
                    $action =
                        '<a href="#" data-toggle="modal" data-target="#deny_order_' .
                        $orders['id'] .
                        '"><i class="fa fa-times fa-2x" aria-hidden="true" style="color:red"></i></a> <a href="#" class="openEditModal" data-toggle="modal" data-target="#edit_order"  data-id="' . $orders['id'] . '" data-user_name="' . $orders['username'] . '" data-start="' . $orders['startTime'] . '" data-end="' . $orders['endTime'] . '" data-duration="' . $orders['duration'] . '" data-flow_rate="' . $orders['flowRate'] . '" data-volume="' . $orders['totalVolume'] . '" data-userid="' . $orders['userid'] . '" style="margin-left:5%;"><i class="fa fa-pencil fa-2x" aria-hidden="true" style="color:black"></i></a>';
                } else {
                    $action =
                        '<a href="#" data-toggle="modal" data-target="#approve_order_' .
                        $orders['id'] .
                        '"><i class="fa fa-check fa-2x" aria-hidden="true" style="color:green"></i></a> <a href="#" data-toggle="modal" data-target="#deny_order_' .
                        $orders['id'] .
                        '"><i class="fa fa-times fa-2x" aria-hidden="true" style="color:red"></i></a> <a href="#" data-toggle="modal" data-target="#edit_order"  data-id="' . $orders['id'] . '" data-user_name="' . $orders['username'] . '" data-start="' . $orders['startTime'] . '" data-end="' . $orders['endTime'] . '" data-duration="' . $orders['duration'] . '" data-flow_rate="' . $orders['flowRate'] . '" data-volume="' . $orders['totalVolume'] . '" data-userid="' . $orders['userid'] . '"><i class="fa fa-pencil fa-2x" aria-hidden="true" style="color:black"></i></a>';
                }

                $modal =
                    '<div class="modal fade" id="approve_order_' .
                    $orders['id'] .
                    '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog" role="document"><form action="" method="POST"> <div class="modal-content"> <div class="modal-header"><h3 class="modal-title" id="exampleModalLabel">Approve Order</h3><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><p style="font-size:15px;">Are you sure you want to approve this order<input type="hidden" name="order_id" value="' .
                    $orders['id'] .
                    '"><input type="hidden" name="userid" value="' .
                    $orders['userid'] .
                    '"></p></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>  <button type="submit" class="btn btn-success" name="approved" value="approved">Approve Order</button></div></div></form></div></div>

                    <div class="modal fade" id="deny_order_' .
                    $orders['id'] .
                    '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog" role="document"><form action="" method="POST"> <div class="modal-content"> <div class="modal-header"><h3 class="modal-title" id="exampleModalLabel">Deny Order</h3><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><p style="font-size:15px;">Are you sure you want to deny this order<input type="hidden" name="order_id" value="' .
                    $orders['id'] .
                    '"><input type="hidden" name="userid" value="' .
                    $orders['userid'] .
                    '"></p></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>  <button type="submit" class="btn btn-danger" name="denied" value="denied">Deny Order</button></div></div></form></div></div>
                    ';
            } else if ($date < $current_date && $end_date >= $current_date) {
                $action = '<a href="#" data-toggle="modal" data-target="#deny_order_' .
                    $orders['id'] .
                    '"><i class="fa fa-times fa-2x" aria-hidden="true" style="color:red"></i></a> <a href="#" class="openEditModal" data-toggle="modal" data-target="#edit_order"  data-id="' . $orders['id'] . '" data-user_name="' . $orders['username'] . '" data-start="' . $orders['startTime'] . '" data-end="' . $orders['endTime'] . '" data-duration="' . $orders['duration'] . '" data-flow_rate="' . $orders['flowRate'] . '" data-volume="' . $orders['totalVolume'] . '" data-userid="' . $orders['userid'] . '" style="margin-left:5%;"><i class="fa fa-pencil fa-2x" aria-hidden="true" style="color:black"></i></a>';
                $modal = '';
            } else {
                $action = '-';
                $modal = '';
            }

            $orders = [
                "id" => $orders['id'],
                "operatorid" => $orders['operatorid'],
                "userid" => $orders['userid'],
                "meter" => $orders['meter'],
                "startTime" => $orders['startTime'],
                "flowRate" => $orders['flowRate'],
                "duration" => $orders['duration'],
                "endTime" => $orders['endTime'],
                "totalVolume" => $orders['totalVolume'],
                "weather" => $orders['username'],
                "orderedDate" => $orders['orderedDate'],
                "isActive" => $orders['isActive'],
                "meterid" => $orders['meterid'],
                "meter_name" => $orders['meter_name'],
                "serial_number" => $orders['serial_number'],
                "meteruserid" => $orders['meteruserid'],
                "channel_name" => $orders['channel_name'],
                "type" => $orders['type'],
                "wr_number" => $orders['wr_number'],
                "wr_volume" => $orders['wr_volume'],
                "username" => $orders['username'],
                "modal" => $modal ? $modal : '',
                "action" => $action ? $action : '-',
            ];
            array_push($current_orders, $orders);
        }
        // echo "<pre>";
        // print_r($current_orders);

        print_r(json_encode($current_orders));
    }

    public function load_new_water_orders()
    {
        $current_orders = [];
        $channel_id = $this->input->post('channel_id');
        $order_usernames = $this->input->post('userid');
        if ($order_usernames == 0) {
            if ($channel_id == 0) {
                $where = ['tbl_water_orders.isActive =' => 0];
            } else {
                $where = [
                    'tbl_channels.id' => $channel_id,
                    'tbl_water_orders.isActive =' => 0,
                ];
            }
        } else {
            if ($channel_id == 0) {
                $where = [
                    'tbl_water_orders.isActive =' => 0,
                    'tbl_meter_connections.userid' => $order_usernames,
                ];
            } else {
                $where = [
                    'tbl_channels.id' => $channel_id,
                    'tbl_water_orders.isActive =' => 0,
                    'tbl_meter_connections.userid' => $order_usernames,
                ];
            }
        }

        $site_url = base_url() . 'assets/meterprofiles/';
        $columns = [
            'tbl_water_orders.*',
            'tbl_meter_connections.id as meterid',
            'tbl_meter_connections.meter_name as meter_name',
            'tbl_meter_connections.serial_number as serial_number',
            'tbl_meter_connections.property as property',
            'tbl_meter_connections.id as meterid',
            'tbl_meter_connections.userid as meteruserid',
            "CONCAT('$site_url', tbl_meter_connections.image) as meterimage",
            'tbl_channels.channel_name as channel_name',
            'tbl_metertype.type as type',
            'tbl_water_right_alloc.wr_number as wr_number',
            'tbl_water_right_alloc.wr_volume as wr_volume',
            'tbl_users.username as username',
            'tbl_users.contact_name as contact_name',
            'tbl_users.email as email',
        ];

        $join = [
            [
                'table' => 'tbl_meter_connections',
                'condition' =>
                'tbl_meter_connections.id=tbl_water_orders.meter',
                'jointype' => 'LEFT',
            ],
            [
                'table' => 'tbl_channels',
                'condition' =>
                'tbl_channels.id=tbl_meter_connections.channel_name',
                'jointype' => 'LEFT',
            ],
            [
                'table' => 'tbl_metertype',
                'condition' =>
                'tbl_metertype.id=tbl_meter_connections.meter_type',
                'jointype' => 'LEFT',
            ],
            [
                'table' => 'tbl_water_right_alloc',
                'condition' =>
                'tbl_water_right_alloc.id=tbl_meter_connections.water_right',
                'jointype' => 'LEFT',
            ],
            [
                'table' => 'tbl_users',
                'condition' => 'tbl_users.id=tbl_water_orders.userid',
                'jointype' => 'LEFT',
            ],
        ];

        $orderExists = $this->user_model->get_joins(
            'tbl_water_orders',
            $where,
            $join,
            $columns,
            '',
            '',
            'tbl_water_orders.orderedDate DESC'
        );
        $current_date = date('Y-m-d');
        foreach ($orderExists as $orders) {
            $s = $orders['startTime'];
            $dt = new DateTime($s);

            $date = $dt->format('Y-m-d');
            if ($date >= $current_date) {
                if ($orders['isActive'] == 1) {
                    $action =
                        '<a href="#" data-toggle="modal" data-target="#deny_order_' .
                        $orders['id'] .
                        '"><i class="fa fa-times fa-2x" aria-hidden="true" style="color:red"></i></a> <a href="#" class="openEditModal" data-toggle="modal" data-target="#edit_order"  data-id="' . $orders['id'] . '" data-user_name="' . $orders['username'] . '" data-start="' . $orders['startTime'] . '" data-end="' . $orders['endTime'] . '" data-duration="' . $orders['duration'] . '" data-flow_rate="' . $orders['flowRate'] . '" data-volume="' . $orders['totalVolume'] . '" data-userid="' . $orders['userid'] . '" style="margin-left:5%;"><i class="fa fa-pencil fa-2x" aria-hidden="true" style="color:black"></i></a>';
                } else {
                    $action =
                        '<a href="#" data-toggle="modal" data-target="#approve_order_' .
                        $orders['id'] .
                        '"><i class="fa fa-check fa-2x" aria-hidden="true" style="color:green"></i></a> <a href="#" data-toggle="modal" data-target="#deny_order_' .
                        $orders['id'] .
                        '"><i class="fa fa-times fa-2x" aria-hidden="true" style="color:red"></i></a> <a href="#" data-toggle="modal" data-target="#edit_order"><i class="fa fa-pencil fa-2x" aria-hidden="true" style="color:black"></i></a>';
                }



                $modal =
                    '<div class="modal fade" id="approve_order_' .
                    $orders['id'] .
                    '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog" role="document"><form action="" method="POST"> <div class="modal-content"> <div class="modal-header"><h3 class="modal-title" id="exampleModalLabel">Approve Order</h3><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><p style="font-size:15px;">Are you sure you want to approve this order<input type="hidden" name="order_id" value="' .
                    $orders['id'] .
                    '"><input type="hidden" name="userid" value="' .
                    $orders['userid'] .
                    '"></p></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>  <button type="submit" class="btn btn-success" name="approved" value="approved">Approve Order</button></div></div></form></div></div>

            <div class="modal fade" id="deny_order_' .
                    $orders['id'] .
                    '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog" role="document"><form action="" method="POST"> <div class="modal-content"> <div class="modal-header"><h3 class="modal-title" id="exampleModalLabel">Deny Order</h3><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><p style="font-size:15px;">Are you sure you want to deny this order<input type="hidden" name="order_id" value="' .
                    $orders['id'] .
                    '"><input type="hidden" name="userid" value="' .
                    $orders['userid'] .
                    '"></p></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>  <button type="submit" class="btn btn-danger" name="denied" value="denied">Deny Order</button></div></div></form></div></div>
                    ';
            } else {
                $action = '-';
                $modal = '';
            }

            $orders = [
                "id" => $orders['id'],
                "operatorid" => $orders['operatorid'],
                "userid" => $orders['userid'],
                "meter" => $orders['meter'],
                "startTime" => $orders['startTime'],
                "flowRate" => $orders['flowRate'],
                "duration" => $orders['duration'],
                "endTime" => $orders['endTime'],
                "totalVolume" => $orders['totalVolume'],
                "weather" => $orders['username'],
                "orderedDate" => $orders['orderedDate'],
                "isActive" => $orders['isActive'],
                "meterid" => $orders['meterid'],
                "meter_name" => $orders['meter_name'],
                "serial_number" => $orders['serial_number'],
                "meteruserid" => $orders['meteruserid'],
                "channel_name" => $orders['channel_name'],
                "type" => $orders['type'],
                "wr_number" => $orders['wr_number'],
                "wr_volume" => $orders['wr_volume'],
                "username" => $orders['username'],
                "modal" => $modal ? $modal : '',
                "action" => $action ? $action : '-',
            ];
            array_push($current_orders, $orders);
        }

        print_r(json_encode($current_orders));
    }

    public function message_count()
    {
        $where = ['is_read' => 0, 'senderrole' => 'user'];
        $message = $this->user_model->get_joins('tbl_notifications', $where);

        $count = count($message);
        print_r($count);
    }

    public function update_message_count()
    {
        $update = ['is_read' => 1];
        $where = ['senderrole' => 'user'];
        $this->user_model->UPDATEDATA('tbl_notifications', $where, $update);
        print_r(json_encode(1));
    }

    public function edit_water_orders()
    {

        $id = $this->input->post('id');
        $userid = $this->input->post('userid');
        $flow_rate = $this->input->post('flow_rate');
        $start_time = $this->input->post('start_time');
        $end_time = $this->input->post('end_time');
        $duration = $this->input->post('duration');
        $volume = $this->input->post('volume');

        $where = array('id' => $id);
        $update = array(
            'startTime' => $start_time,
            'flowRate' => $flow_rate,
            'duration' => $duration,
            'endTime' => $end_time,
            'totalVolume' => $volume
        );
        $is_update = $this->user_model->UPDATEDATA('tbl_water_orders', $where, $update);
        if ($is_update) {
            $senderid = $this->session->userdata('user_id');

            $whereuser = array('role' => 'user', 'userid' => $userid);
            $usertokenExists = $this->user_model->get_joins('tbl_tokens', $whereuser);
            if ($usertokenExists) {
                $notifiyUser = array(
                'title' => 'Water Order Edited',
                'message' => 'Edited By Operator',
                'token' => $usertokenExists[0]['devicetoken'],
                'type' => 101
                );
                $this->cronPushNotification($notifiyUser);
            }


            $insert = array(
                'senderid' => $senderid,
                'senderrole' => 'operator',
                'receiverid' => $userid,
                'title' => 'Water Order Edited',
                'Message' => 'Edited By Operator',
                'Status' => '<a class="btn btn-sm btn-primary" href="user/accept_order">View</a>',
                'is_read' => 0
            );
            $this->user_model->INSERTDATA('tbl_notifications', $insert);
            $this->session->set_flashdata(
                'success',
                'Water Edited Sucessfully'
            );
        }
        redirect('Operator/orders');
    }

    function formatSecondsToClock($seconds)
    {
        $t = round($seconds);
        return sprintf('%02d:%02d:%02d', ($t / 3600), ($t / 60 % 60), $t % 60);
    }

    function split_times($interval)
    {
        $result = array();
        if ($interval > 86400) {
            return $result;
        } else {
            $timeSlice = 86400 / $interval;
            $timeStamp = 0;
            for ($i = 0; $i < $interval; $i++) {
                array_push($result, $this->formatSecondsToClock($timeStamp));
                $timeStamp += $timeSlice;
            }
        }
        return $result;
    }

    # UPCOMING WATER ORDERS - "Display Upcoming Orders" which are orders that are approved and scheduled.

    public function pending_water_order()
    {
        $current_date = date('Y-m-d');
        $result = array();

        $upcoming_orders = array();
        $date = date('Y-m-d h:i:s');

        $site_url = base_url() . 'assets/meterprofiles/';
        $columns = array('tbl_water_orders.*', 'tbl_meter_connections.id as meterid', 'tbl_meter_connections.meter_name as meter_name', 'tbl_meter_connections.serial_number as serial_number', 'tbl_meter_connections.property as property', 'tbl_meter_connections.id as meterid', 'tbl_meter_connections.userid as meteruserid', "CONCAT('$site_url', tbl_meter_connections.image) as meterimage", 'tbl_channels.channel_name as channel_name', 'tbl_metertype.type as type', 'tbl_water_right_alloc.wr_number as wr_number', 'tbl_water_right_alloc.wr_volume as wr_volume', 'tbl_users.username as username', 'tbl_users.contact_name as contact_name', 'tbl_users.email as email');
        $join = array(
            array('table' => 'tbl_meter_connections', 'condition' => 'tbl_meter_connections.id=tbl_water_orders.meter', 'jointype' => 'LEFT'),
            array('table' => 'tbl_channels', 'condition' => 'tbl_channels.id=tbl_meter_connections.channel_name', 'jointype' => 'LEFT'),
            array('table' => 'tbl_metertype', 'condition' => 'tbl_metertype.id=tbl_meter_connections.meter_type', 'jointype' => 'LEFT'),
            array('table' => 'tbl_water_right_alloc', 'condition' => 'tbl_water_right_alloc.id=tbl_meter_connections.water_right', 'jointype' => 'LEFT'),
            array('table' => 'tbl_users', 'condition' => 'tbl_users.id=tbl_water_orders.userid', 'jointype' => 'LEFT'),
        );
        $where = array('tbl_water_orders.isActive' => 0);
        $orderExists = $this->user_model->get_joins('tbl_water_orders', $where, $join, $columns, '', '', 'tbl_water_orders.startTime');
        if ($orderExists) {
            foreach ($orderExists as $key => $orders) {
                $s = $orders['startTime'];
                $dt = new DateTime($s);

                $date = $dt->format('Y-m-d');
                if ($date >= $current_date) {

                    array_push($upcoming_orders, $orders);
                }
            }

            $upcoming_orders = $this->checkDateSlot($upcoming_orders);
            if (!empty($upcoming_orders)) {
                foreach ($upcoming_orders as $key => $value) {
                    // code...
                    foreach ($value['orders'] as $key => $order) {
                        $time =   $value['day'] . '-' . $order['start'];
                        $time = str_replace(array('-', ':'), ',', $time);
                        $graph = array('x' => $time, 'y' => $order['flowRate']);
                        array_push($result, $graph);
                    }
                }
                return $result;
            }
        }
    }

    public function approve_water_order()
    {
        $current_date = date('Y-m-d');
        $result = array();

        $upcoming_orders = array();
        $date = date('Y-m-d h:i:s');

        $site_url = base_url() . 'assets/meterprofiles/';
        $columns = array('tbl_water_orders.*', 'tbl_meter_connections.id as meterid', 'tbl_meter_connections.meter_name as meter_name', 'tbl_meter_connections.serial_number as serial_number', 'tbl_meter_connections.property as property', 'tbl_meter_connections.id as meterid', 'tbl_meter_connections.userid as meteruserid', "CONCAT('$site_url', tbl_meter_connections.image) as meterimage", 'tbl_channels.channel_name as channel_name', 'tbl_metertype.type as type', 'tbl_water_right_alloc.wr_number as wr_number', 'tbl_water_right_alloc.wr_volume as wr_volume', 'tbl_users.username as username', 'tbl_users.contact_name as contact_name', 'tbl_users.email as email');
        $join = array(
            array('table' => 'tbl_meter_connections', 'condition' => 'tbl_meter_connections.id=tbl_water_orders.meter', 'jointype' => 'LEFT'),
            array('table' => 'tbl_channels', 'condition' => 'tbl_channels.id=tbl_meter_connections.channel_name', 'jointype' => 'LEFT'),
            array('table' => 'tbl_metertype', 'condition' => 'tbl_metertype.id=tbl_meter_connections.meter_type', 'jointype' => 'LEFT'),
            array('table' => 'tbl_water_right_alloc', 'condition' => 'tbl_water_right_alloc.id=tbl_meter_connections.water_right', 'jointype' => 'LEFT'),
            array('table' => 'tbl_users', 'condition' => 'tbl_users.id=tbl_water_orders.userid', 'jointype' => 'LEFT'),
        );
        $where = array('tbl_water_orders.isActive' => 1);
        $orderExists = $this->user_model->get_joins('tbl_water_orders', $where, $join, $columns, '', '', 'tbl_water_orders.startTime');
        if ($orderExists) {
            foreach ($orderExists as $key => $orders) {
                $s = $orders['startTime'];
                $dt = new DateTime($s);

                $date = $dt->format('Y-m-d');
                if ($date >= $current_date) {
                    array_push($upcoming_orders, $orders);
                }
            }

            $upcoming_orders = $this->checkDateSlot($upcoming_orders);

            foreach ($upcoming_orders as $key => $value) {
                // code...
                foreach ($value['orders'] as $key => $order) {
                    $time =   $value['day'] . '-' . $order['start'];
                    $time = str_replace(array('-', ':'), ',', $time);
                    $graph = array('x' => $time, 'y' => $order['flowRate']);
                    array_push($result, $graph);
                }
            }
            return $result;
        }
    }
    public function checkTimeInBetween($date)

    {

        $data = array(
            array('start' => '00:00', 'end' => '01:00'),
            array('start' => '01:00', 'end' => '02:00'), array('start' => '02:00', 'end' => '03:00'), array('start' => '03:00', 'end' => '04:00'), array('start' => '04:00', 'end' => '05:00'), array('start' => '05:00', 'end' => '06:00'), array('start' => '06:00', 'end' => '07:00'), array('start' => '07:00', 'end' => '08:00'), array('start' => '08:00', 'end' => '09:00'), array('start' => '09:00', 'end' => '10:00'), array('start' => '10:00', 'end' => '11:00', 'flow_rate' => 0, 'orders' => array()), array('start' => '11:00', 'end' => '12:00'), array('start' => '12:00', 'end' => '13:00'), array('start' => '13:00', 'end' => '14:00'), array('start' => '14:00', 'end' => '15:00'), array('start' => '15:00', 'end' => '16:00'), array('start' => '16:00', 'end' => '17:00'), array('start' => '17:00', 'end' => '18:00'), array('start' => '18:00', 'end' => '19:00', 'flow_rate' => 0, 'orders' => array()), array('start' => '19:00', 'end' => '20:00'), array('start' => '20:00', 'end' => '21:00'), array('start' => '21:00', 'end' => '22:00'), array('start' => '22:00', 'end' => '23:00'), array('start' => '23:00', 'end' => '00:00')
        );
        foreach ($data as $key => $d) {

            if (strtotime($date) >= strtotime($d['start']) && strtotime($date) <= strtotime($d['end'])) {
                $slot = array('key' => $key, 'slot' => $d);

                return $slot;
            }
        }
    }
    public function checkDateSlot($orders)
    {
        $start = date('Y-m-d');
        $end = date('Y-m-d', strtotime("+1 day", strtotime($start)));
        $data = array(
            array('start' => '00:00', 'end' => '01:00', 'flowRate' => 0, 'orders' => array()),
            array('start' => '01:00', 'end' => '02:00', 'flowRate' => 0, 'orders' => array()), array('start' => '02:00', 'end' => '03:00', 'flowRate' => 0, 'orders' => array()), array('start' => '03:00', 'end' => '04:00', 'flowRate' => 0, 'orders' => array()), array('start' => '04:00', 'end' => '05:00', 'flowRate' => 0, 'orders' => array()), array('start' => '05:00', 'end' => '06:00', 'flowRate' => 0, 'orders' => array()), array('start' => '06:00', 'end' => '07:00', 'flowRate' => 0, 'orders' => array()), array('start' => '07:00', 'end' => '08:00', 'flowRate' => 0, 'orders' => array()), array('start' => '08:00', 'end' => '09:00', 'flowRate' => 0, 'orders' => array()), array('start' => '09:00', 'end' => '10:00', 'flowRate' => 0, 'orders' => array()), array('start' => '10:00', 'end' => '11:00', 'flowRate' => 0, 'orders' => array()), array('start' => '11:00', 'end' => '12:00', 'flowRate' => 0, 'orders' => array()), array('start' => '12:00', 'end' => '13:00', 'flowRate' => 0, 'orders' => array()), array('start' => '13:00', 'end' => '14:00', 'flowRate' => 0, 'orders' => array()), array('start' => '14:00', 'end' => '15:00', 'flowRate' => 0, 'orders' => array()), array('start' => '15:00', 'end' => '16:00', 'flowRate' => 0, 'orders' => array()), array('start' => '16:00', 'end' => '17:00', 'flowRate' => 0, 'orders' => array()), array('start' => '17:00', 'end' => '18:00', 'flowRate' => 0, 'orders' => array()), array('start' => '18:00', 'end' => '19:00', 'flowRate' => 0, 'orders' => array()), array('start' => '19:00', 'end' => '20:00', 'flowRate' => 0, 'orders' => array()), array('start' => '20:00', 'end' => '21:00', 'flowRate' => 0, 'orders' => array()), array('start' => '21:00', 'end' => '22:00', 'flowRate' => 0, 'orders' => array()), array('start' => '22:00', 'end' => '23:00', 'flowRate' => 0, 'orders' => array()), array('start' => '23:00', 'end' => '00:00', 'flowRate' => 0, 'orders' => array())
        );


        $test = $data;
        $newProduct = array();

        $day = array();
        $count = count($orders) - 1;

        $newOrder = array();
        foreach ($orders as $value) {

            $s = $value['startTime'];
            $dt = new DateTime($s);
            $value['date'] = $dt->format('Y-m-d');

            array_push($newOrder, $value);
        }
        $type = [];
        foreach ($newOrder as $item) {
            $type[$item['date']][] = $item;
        }


        $days = $this->list_days($start, $end);

        for ($i = 0; $i < count($days); $i++) {
            if (array_key_exists($days[$i], $type)) {
                foreach ($type[$days[$i]] as $key => $order) {

                    $s = $order['startTime'];


                    $dt = new DateTime($s);

                    $date = $dt->format('H:i');
                    $time = $dt->format('Y-m-d');

                    $dates = $this->checkTimeInBetween($date);

                    $key = $dates['key'];

                    // if($days[$i]==$order)

                    if (isset($data[$key]['orders'])) {
                        $current_value = array();

                        $data[$key]['flowRate'] = $data[$key]['flowRate'] + $order['flowRate'];

                        $data[$key]['orders'][] = array_merge($current_value, $order);
                    } else {
                        $data[$key]['flowRate'] = $data[$key]['flowRate'] + $order['flowRate'];

                        $data[$key]['orders'][] = $order;
                    }
                }

                $myData = array('day' => $time, 'orders' => $data);
                array_push($newProduct, $myData);
                $data = $test;
            } else {

                $myData = array('day' => $days[$i], 'orders' => $data);
                array_push($newProduct, $myData);
            }
        }

        return $newProduct;
    }

    public function list_days($st_date, $ed_date)
    {

        $dateMonthYearArr = array();
        $st_dateTS = strtotime($st_date);
        $ed_dateTS = strtotime($ed_date);

        for ($currentDateTS = $st_dateTS; $currentDateTS <= $ed_dateTS; $currentDateTS += (60 * 60 * 24)) {
            // use date() and $currentDateTS to format the dates in between
            $currentDateStr = date('Y-m-d', $currentDateTS);
            $dateMonthYearArr[] = $currentDateStr;
            //print $currentDateStr.”<br />”;
        }

        return $dateMonthYearArr;
    }


    public function graph_values($status)
    {
        $current_date = date('Y-m-d');
        $tommorow = date("Y-m-d", time() + 86400);

        $data = array(
            array('start' => '00:00', 'end' => '01:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-00:00' . '-00:00'), 'y' => 0)),
            array('start' => '01:00', 'end' => '02:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-01:00'), 'y' => 0)), array('start' => '02:00', 'end' => '03:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-02:00'), 'y' => 0)), array('start' => '03:00', 'end' => '04:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-03:00'), 'y' => 0)), array('start' => '04:00', 'end' => '05:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-04:00'), 'y' => 0)), array('start' => '05:00', 'end' => '06:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-05:00'), 'y' => 0)), array('start' => '06:00', 'end' => '07:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-06:00'), 'y' => 0)), array('start' => '07:00', 'end' => '08:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-07:00'), 'y' => 0)), array('start' => '08:00', 'end' => '09:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-08:00'), 'y' => 0)), array('start' => '09:00', 'end' => '10:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-09:00'), 'y' => 0)), array('start' => '10:00', 'end' => '11:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-010:00'), 'y' => 0)), array('start' => '11:00', 'end' => '12:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-11:00'), 'y' => 0)), array('start' => '12:00', 'end' => '13:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-12:00'), 'y' => 0)), array('start' => '13:00', 'end' => '14:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-13:00'), 'y' => 0)), array('start' => '14:00', 'end' => '15:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-14:00'), 'y' => 0)), array('start' => '15:00', 'end' => '16:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-15:00'), 'y' => 0)), array('start' => '16:00', 'end' => '17:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-16:00'), 'y' => 0)), array('start' => '17:00', 'end' => '18:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-17:00'), 'y' => 0)), array('start' => '18:00', 'end' => '19:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-18:00'), 'y' => 0)), array('start' => '19:00', 'end' => '20:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-19:00'), 'y' => 0)), array('start' => '20:00', 'end' => '21:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-20:00'), 'y' => 0)), array('start' => '21:00', 'end' => '22:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-21:00'), 'y' => 0)), array('start' => '22:00', 'end' => '23:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-22:00'), 'y' => 0)), array('start' => '23:00', 'end' => '00:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $current_date . '-23:00'), 'y' => 0))
        );
        $datas = array(
            array('start' => '00:00', 'end' => '01:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-00:00'), 'y' => 0)),
            array('start' => '01:00', 'end' => '02:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-01:00'), 'y' => 0)), array('start' => '02:00', 'end' => '03:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-02:00'), 'y' => 0)), array('start' => '03:00', 'end' => '04:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-03:00'), 'y' => 0)), array('start' => '04:00', 'end' => '05:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-04:00'), 'y' => 0)), array('start' => '05:00', 'end' => '06:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-05:00'), 'y' => 0)), array('start' => '06:00', 'end' => '07:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-06:00'), 'y' => 0)), array('start' => '07:00', 'end' => '08:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-07:00'), 'y' => 0)), array('start' => '08:00', 'end' => '09:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-08:00'), 'y' => 0)), array('start' => '09:00', 'end' => '10:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-09:00'), 'y' => 0)), array('start' => '10:00', 'end' => '11:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-10:00'), 'y' => 0)), array('start' => '11:00', 'end' => '12:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-11:00'), 'y' => 0)), array('start' => '12:00', 'end' => '13:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-12:00'), 'y' => 0)), array('start' => '13:00', 'end' => '14:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-13:00'), 'y' => 0)), array('start' => '14:00', 'end' => '15:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-14:00'), 'y' => 0)), array('start' => '15:00', 'end' => '16:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-15:00'), 'y' => 0)), array('start' => '16:00', 'end' => '17:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-16:00'), 'y' => 0)), array('start' => '17:00', 'end' => '18:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-17:00'), 'y' => 0)), array('start' => '18:00', 'end' => '19:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-18:00'), 'y' => 0)), array('start' => '19:00', 'end' => '20:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-19:00'), 'y' => 0)), array('start' => '20:00', 'end' => '21:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-20:00'), 'y' => 0)), array('start' => '21:00', 'end' => '22:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-21:00'), 'y' => 0)), array('start' => '22:00', 'end' => '23:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-22:00'), 'y' => 0)), array('start' => '23:00', 'end' => '00:00', 'flowRate' => 0, 'graph' => array('x' => str_replace(array('-', ':'), ',', $tommorow . '-23:00'), 'y' => 0))
        );

        $result = array();
        $val1 = array();
        $val2 = array();

        $upcoming_orders = array();
        $date = date('Y-m-d h:i:s');

        $site_url = base_url() . 'assets/meterprofiles/';
        $columns = array('tbl_water_orders.*', 'tbl_meter_connections.id as meterid', 'tbl_meter_connections.meter_name as meter_name', 'tbl_meter_connections.serial_number as serial_number', 'tbl_meter_connections.property as property', 'tbl_meter_connections.id as meterid', 'tbl_meter_connections.userid as meteruserid', "CONCAT('$site_url', tbl_meter_connections.image) as meterimage", 'tbl_channels.channel_name as channel_name', 'tbl_metertype.type as type', 'tbl_water_right_alloc.wr_number as wr_number', 'tbl_water_right_alloc.wr_volume as wr_volume', 'tbl_users.username as username', 'tbl_users.contact_name as contact_name', 'tbl_users.email as email');
        $where = array('tbl_water_orders.isActive' => $status);
        $join = array(
            array('table' => 'tbl_meter_connections', 'condition' => 'tbl_meter_connections.id=tbl_water_orders.meter', 'jointype' => 'LEFT'),
            array('table' => 'tbl_channels', 'condition' => 'tbl_channels.id=tbl_meter_connections.channel_name', 'jointype' => 'LEFT'),
            array('table' => 'tbl_metertype', 'condition' => 'tbl_metertype.id=tbl_meter_connections.meter_type', 'jointype' => 'LEFT'),
            array('table' => 'tbl_water_right_alloc', 'condition' => 'tbl_water_right_alloc.id=tbl_meter_connections.water_right', 'jointype' => 'LEFT'),
            array('table' => 'tbl_users', 'condition' => 'tbl_users.id=tbl_water_orders.userid', 'jointype' => 'LEFT'),
        );
        $orderExists = $this->user_model->get_joins('tbl_water_orders', $where, $join, $columns, '', '', 'tbl_water_orders.startTime');

        if ($orderExists) {
            foreach ($orderExists as $key => $orders) {
                $dt = new DateTime($orders['startTime']);

                $startdate = $dt->format('Y-m-d');

                $dt = new DateTime($orders['endTime']);

                $enddate = $dt->format('Y-m-d');
                $dt = new DateTime($orders['endTime']);

                $endTime = $dt->format('H');
                $dt = new DateTime($orders['startTime']);

                $startTime = $dt->format('H');
                if ($startdate < $current_date && $enddate < $current_date) {
                } else {

                    if ($startdate < $current_date && $enddate == $current_date) {


                        $data1 = array('start' => 0, 'end' => $endTime + 1, 'flowRate' => $orders['flowRate'], 'date' => $enddate);
                        array_push($result, $data1);
                    } else if ($startdate < $current_date && $enddate > $current_date) {
                        $data1 = array('start' => 0, 'end' => 24, 'flowRate' => $orders['flowRate'], 'date' => $current_date);
                        array_push($result, $data1);

                        if ($enddate == $tommorow) {
                            $data1 = array('start' => 0, 'end' => $endTime, 'flowRate' => $orders['flowRate'], 'date' => $tommorow);
                            array_push($result, $data1);
                        } else if ($enddate > $tommorow) {
                            $data1 = array('start' => 0, 'end' => 24, 'flowRate' => $orders['flowRate'], 'date' => $tommorow);
                            array_push($result, $data1);
                        }
                    } else if ($startdate == $current_date && $enddate == $current_date) {
                        $data1 = array('start' => $startTime, 'end' => $endTime, 'flowRate' => $orders['flowRate'], 'date' => $current_date);
                        array_push($result, $data1);
                    } else if ($startdate > $current_date) {

                        if ($startdate == $tommorow && $enddate == $tommorow) {
                            $data1 = array('start' => $startTime + 1, 'end' => $endTime + 1, 'flowRate' => $orders['flowRate'], 'date' => $tommorow);
                            array_push($result, $data1);
                        } else if ($startdate == $tommorow && $enddate > $tommorow) {
                            $data1 = array('start' => $startTime, 'end' => 24, 'flowRate' => $orders['flowRate'], 'date' => $tommorow);
                            array_push($result, $data1);
                        }
                    }
                    if ($startdate == $current_date && $enddate == $tommorow) {
                        $data1 = array('start' => $startTime, 'end' => 24, 'flowRate' => $orders['flowRate'], 'date' => $current_date);
                        array_push($result, $data1);

                        $data1 = array('start' => 0, 'end' => $endTime, 'flowRate' => $orders['flowRate'], 'date' => $tommorow);
                        array_push($result, $data1);
                    }
                }
            }
        }

        foreach ($result as $key => $value) {
            // code...
            if ($value['date'] == $current_date) {
                array_push($val1, $value);
            }
            if ($value['date'] == $tommorow) {
                array_push($val2, $value);
            }
        }

        foreach ($val1 as $key => $value) {
            for ($i = $value['start']; $i < $value['end']; $i++) {
                $data[$i]['flowRate'] = $data[$i]['flowRate'] + $value['flowRate'];
                $data[$i]['date'] = $value['date'];
                $time =   $value['date'] . '-' . $data[$i]['start'];
                $time = str_replace(array('-', ':'), ',', $time);

                $data[$i]['graph'] = array('x' => $time, 'y' => $data[$i]['flowRate']);
            }
            // code...
        }
        foreach ($val2 as $key => $value) {
            for ($i = $value['start']; $i < $value['end']; $i++) {
                $datas[$i]['flowRate'] = $datas[$i]['flowRate'] + $value['flowRate'];
                $datas[$i]['date'] = $value['date'];
                $time =   $value['date'] . '-' . $datas[$i]['start'];
                $time = str_replace(array('-', ':'), ',', $time);
                $datas[$i]['graph'] = array('x' => $time, 'y' => $datas[$i]['flowRate']);
            }
            // code...
        }
        return (array_merge($data, $datas));
        // echo "<pre>";
        // print_r(array_merge($data,$datas));
        // exit;
    }
}
