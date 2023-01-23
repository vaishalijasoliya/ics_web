<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');


class Cron_job_model extends CI_Model {

    public function __construct() {
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

    function cron_job()
   {

     $this->email->to('apurva.dixit@newtechfusion.com','Apurva');
     $this->email->subject('Test');
     $this->email->message('Test');
     if($this->email->send())

     {
        echo "Success";
     }


   }

  }
