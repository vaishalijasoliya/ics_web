<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <title>Intelligent Canal Systems</title>
      <!-- Bootstrap -->
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/operators/css/bootstrap.min.css">
      <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/operators/css/style.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   </head>
   <style media="screen">
   .toggle-password {
      float: right;
      cursor: pointer;
      margin-right: 10px;
      margin-top: -45px;
      font-size: 28px;
      position: relative;
      z-index: 2;
   }
   </style>
   <body>
      <div class="wrapper-area">
         <!-- ---start-wrapper-area-- -->
         <section class="login-page">
            <!-- ---start-login-area-- -->
            <div class="login-container">
               <div class="col-md-6 login-form-1">
                  <!-- login form-1 start -->
                  <div class="login-logo"> </div>
                  <img src="<?php echo base_url(); ?>assets/operators/img/ICS-Logo-Final-white2-.png" alt="ICS-Logo-Final-white"/>
               </div>
               <!-- login form-1 end -->
               <div class="col-md-6 login-form-2">
                 <?php
                 $error= $this->session->flashdata('error');
                 if($error)
                 {
                   ?>
                 <div class="alert alert-danger alert-dismissible gone">
     <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
     <strong>Error!</strong> <?php echo $error; ?>.
   </div>
    <?php } ?>
                  <!-- login form-2 start -->
                  <form class="" action="<?php echo base_url('Authentication/loginMe'); ?>" method="post">

                  <h3>SIGN IN</h3>

                  <div class="form-group">
                     <span class="user-img"><img src="<?php echo base_url(); ?>assets/operators/img/log-user.png" alt="log-user"/></span>
                     <input type="text" class="login-user" class="form-control" placeholder="Enter Username" value="" name="username" required  autocomplete="off"/>
                  </div>
                  <div class="form-group">
                     <span class="password-img"><img src="<?php echo base_url(); ?>assets/operators/img/log-pass.png" alt="log-pass"/></span>
                     <input type="password" class="login-password" class="form-control" placeholder=".........." name="password" value="" required />
                     <i class="toggle-password fa fa-fw fa-eye-slash"></i>
                     <!-- <span class="password-eye-img"><img src="<?php echo base_url(); ?>assets/operators/img/log-eye.png" alt="log-eye" id="myImg"/></span> -->
                  </div>
                  <div class="form-group">
                     <input type="submit" class="btnSubmit" value="SIGN IN"/>
                  </div>
                  <!-- <div class="form-group">
                     <a href="#" class="btnForgetPwd" value="Login">Forgot Password?</a>
                  </div> -->
               </div>
             </form>

               <!-- login form-2 end-->
            </div>
         </section>
         <!-- ---end-login-area-- -->
      </div>
      <!-- ---end-wrapper-area-- -->
      <script src="<?php echo base_url(); ?>assets/operators/js/jquery.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/operators/js/jquery-1.12.4.js"></script>
      <script src="<?php echo base_url(); ?>assets/operators/js/bootstrap.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/operators/js/main.js"></script>
      <script type="text/javascript">

      $(window).load(function(){
        setTimeout(function(){ $('.gone').fadeOut() }, 5000);
      });

    $(".toggle-password").click(function() {
   $(this).toggleClass("fa-eye fa-eye-slash");
     input = $(this).parent().find("input");
     if (input.attr("type") == "password") {
     input.attr("type", "text");
 } else {
     input.attr("type", "password");
 }
        });
      </script>
   </body>
</html>
