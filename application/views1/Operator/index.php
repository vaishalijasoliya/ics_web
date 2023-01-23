<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <title><?php echo $page_title; ?></title>
      <!-- Bootstrap -->
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/operators/css/bootstrap.min.css">
      <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/operators/css/style.css">
      <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/operators/css/custom.css">
      <!-- DataTables -->
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css" integrity="sha512-f0tzWhCwVFS3WeYaofoLWkTP62ObhewQ1EZn65oSYDZUg1+CyywGKkWzm8BxaJj5HGKI72PnMH9jYyIFz+GH7g==" crossorigin="anonymous" />
      <link rel="icon" href="https://portal.intelligentcanalsystems.com/assets/operators/img/ICS-logo-tab.jpg">

      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

      <style>
         .alert-dismissible {
            position: absolute;
            right: 0;
         }
      </style>
   </head>
   <body>
      <!-- ---start-wrapper-area-- -->
      <div class="wrapper-area">
         <header>
            <!-- ---start-header-area-- -->
            <nav class="navbar navbar-custum navbar-fixed-top">
               <!-- nav start---->
               <div class="container">
                  <div class="row">
                     <!-- Brand and toggle get grouped for better mobile display -->
                     <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#"><img src="<?php echo base_url(); ?>assets/operators/img/ICS-logo.png" alt="brand-logo" width="200px"></a>
                     </div>
                     <!-- Collect the nav links, forms, and other content for toggling -->
                     <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav  navbar-right">
                           <li class="nav-item"><a  href="<?php echo base_url('Operator'); ?>">Home</a></li>
                           <!-- submenu start-->
                           <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle <?php if($page_title=='Admin User Config'||$page_title=='Water Usage Report'||$page_title=='System Total Reports'||$page_title=='Transfers'){?> active<?php }?>" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> System Information <span class="caret"></span> </a>
                              <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                 <li><a class="dropdown-item" href="<?php echo base_url('Operator/admin_user_config'); ?>">Admin User Config</a></li>
                                 <li class="dropdown-submenu">
                                    <a class="dropdown-item dropdown-toggle" href="#">System Reports</a>
                                    <ul class="dropdown-menu">
                                       <li><a class="dropdown-item" href="<?php echo base_url('Operator/water_usage_report'); ?>">Water Usage Accounts</a></li>
                                       <li><a class="dropdown-item" href="<?php echo base_url('Operator/system_total_report'); ?>">System total Reports</a></li>
                                    </ul>
                                 </li>
                                 <li><a class="dropdown-item" href="<?php echo base_url('Operator/transfers'); ?>">Transfers</a></li>
                              </ul>
                           </li>
                           <!-- submenu start-->
                           <li class="nav-item dropdown ">
                              <a class="nav-link dropdown-toggle <?php if($page_title=='Usage'||$page_title=='User Details'||$page_title=='Client Usage Report'){?> active<?php }?>" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Water Users <span class="caret"></span>  </a>
                              <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                 <li><a class="dropdown-item" href="<?php echo base_url('c'); ?>">Usage</a></li>
                                 <li><a class="dropdown-item" href="<?php echo base_url('Operator/user_details'); ?>">User Details</a></li>
                                 <li><a class="dropdown-item" href="<?php echo base_url('Operator/client_usage_report'); ?>">Client Usage Report1</a></li>

                              </ul>
                           </li>
                           <li class="nav-item"><a class="nav-link dropdown-toggle <?php if($page_title=='Water Order System'){?> active<?php }?>"  href="<?php echo base_url('Operator/orders'); ?>">Orders</a></li>

                           <li class="nav-item active "><a href="<?php echo base_url('Operator/contact'); ?>">Contact</a></li>
                           <li class="nav-item active "><a href="<?php echo base_url('Operator/notification'); ?>"><i class="fa

fa-envelope fa-2x" aria-hidden="true"></i><span class="badge" id="count"></span></a></li>
                           <li class="nav-item sign-btn"><a href="#"  data-toggle="modal" data-target="#signout">Signout</a></li>
                        </ul>
                     </div>
                  </div>
                  <!--row-->
               </div>
               <!-- container- -->
            </nav>
            <!-- nav end -->
            <div class="banner2-section">
               <div class="overlay"></div>
               <div class="overlay-shadow"></div>
               <div class="banner-content">
                  <h3><?php echo $page_title; ?></h3>
                  <!-- <p> Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                     Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a
                     galley of type and scrambled it to make a type specimen book.
                  </p> -->

                  <?php if(!empty($this->session->flashdata('error'))){ ?>
  <div class="alert alert-danger alert-dismissible" style="margin:20px;">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error!</strong> <?php   print_r($this->session->flashdata('error')); ?>
  </div>
  <?php } ?>
<?php if(!empty($this->session->flashdata('success'))){ ?>
<div class="alert alert-success alert-dismissible gone" style="margin:20px;">
 <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
 <strong>Success!</strong> <?php   print_r($this->session->flashdata('success')); ?>
</div>
<?php } ?>

               </div>
            </div>
         </header>
         <!-- ---end-header-area-- -->
         <!--   main section start  -->

         <?php $this->load->view($page_name);?>
         <!--   main section end  -->
          <!-- Modal start -->
          <div class="modal fade" id="signout" role="dialog">
               <div class="modal-dialog modal-sm">
                  <div class="modal-content">
                     <!-- <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Sign-Out</h4>
                     </div> -->
                     <div class="modal-body">
                        <p style="text-align: center;"> Are you sure want to Signout?</p>
                     </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        <a href="<?php echo base_url('Operator/logout'); ?>" class="btn btn-danger" >Yes</a>

                     </div>
                  </div>
               </div>
            </div>
            <!-- Modal end -->
         <!-- footer start -->
         <!-- Footer -->
         <!-- Footer -->
         <footer class="footer-bg">
            <img src="<?php echo base_url(); ?>assets/operators/img/modified.png" alt="" width="100%">
            <div class="footer-icon">
               <a href="#">
               Privacy Policy | Terms Of Service
               </a>
               <a href="#">
               <img src="<?php echo base_url(); ?>assets/operators/img/social_icons.png" alt="social_icons" width="100%">
               </a>
               <!-- Copyright -->
               <a href="#">
               clis@live.com.au
               </a>
            </div>
         </footer>
         <!-- Footer -->
         <div class="footer-bottom">
            <p>  Copyright @ics 2020.All rights reserved</p>
         </div>
      </div>
      <!-- ---end-wrapper-area-- -->
      <script src="<?php echo base_url(); ?>assets/operators/js/jquery.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/operators/js/jquery-1.12.4.js"></script>
      <script src="<?php echo base_url(); ?>assets/operators/js/bootstrap.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/operators/js/main.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.0/moment.min.js" charset="utf-8"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.js" charset="utf-8"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.4.4/umd/popper.min.js" integrity="sha512-eUQ9hGdLjBjY3F41CScH3UX+4JDSI9zXeroz7hJ+RteoCaY+GP/LDoM8AO+Pt+DRFw3nXqsjh9Zsts8hnYv8/A==" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js" integrity="sha512-AIOTidJAcHBH2G/oZv9viEGXRqDNmfdPVPYOYKGy3fti0xIplnlgMHUGfuNRzC6FkzIo0iIxgFnr9RikFxK+sw==" crossorigin="anonymous"></script>
      <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/additional-methods.js" charset="utf-8"></script>
       <!---Excel Sheet---->
       <script src="<?php echo base_url(); ?>assets/operators/js/FileSaver.js"></script>
       <script src="<?php echo base_url(); ?>assets/operators/js/xlsx.full.min.js"></script>
<!-- Pdf Maker -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/2.0.37/jspdf.plugin.autotable.js"></script>
        <!-- jquery-validation -->
        <script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/jquery.validate.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/additional-methods.min.js"></script>
        <!-- DataTables -->
        <script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
        <?php $this->load->view('Operator/script');?>

   </body>
   <script type="text/javascript">
     $('.picker').datetimepicker()


         $(".toggle-password").click(function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
          input = $(this).parent().find("input");
          if ($(".login-password").attr("type") == "password") {
          $(".login-password").attr("type", "text");
      } else {
          $(".login-password").attr("type", "password");
      }
             });

             /*
     * LetterAvatar
     *
     * Artur Heinze
     * Create Letter avatar based on Initials
     * based on https://gist.github.com/leecrossley/6027780
     */
    (function(w, d){


function LetterAvatar (name, size) {

    name  = name || '';
    size  = size || 60;

    var colours = [
            "#1abc9c", "#2ecc71", "#3498db", "#9b59b6", "#34495e", "#16a085", "#27ae60", "#2980b9", "#8e44ad", "#2c3e50",
            "#f1c40f", "#e67e22", "#e74c3c", "#ecf0f1", "#95a5a6", "#f39c12", "#d35400", "#c0392b", "#bdc3c7", "#7f8c8d"
        ],

        nameSplit = String(name).toUpperCase().split(' '),
        initials, charIndex, colourIndex, canvas, context, dataURI;


    if (nameSplit.length == 1) {
        initials = nameSplit[0] ? nameSplit[0].charAt(0):'?';
    } else {
        initials = nameSplit[0].charAt(0) + nameSplit[1].charAt(0);
    }

    if (w.devicePixelRatio) {
        size = (size * w.devicePixelRatio);
    }

    charIndex     = (initials == '?' ? 72 : initials.charCodeAt(0)) - 64;
    colourIndex   = charIndex % 20;
    canvas        = d.createElement('canvas');
    canvas.width  = size;
    canvas.height = size;
    context       = canvas.getContext("2d");

    context.fillStyle = colours[colourIndex - 1];
    context.fillRect (0, 0, canvas.width, canvas.height);
    context.font = Math.round(canvas.width/2)+"px Arial";
    context.textAlign = "center";
    context.fillStyle = "#FFF";
    context.fillText(initials, size / 2, size / 1.5);

    dataURI = canvas.toDataURL();
    canvas  = null;

    return dataURI;
}

LetterAvatar.transform = function() {

    Array.prototype.forEach.call(d.querySelectorAll('img[avatar]'), function(img, name) {
        name = img.getAttribute('avatar');
        img.src = LetterAvatar(name, img.getAttribute('width'));
        img.removeAttribute('avatar');
        img.setAttribute('alt', name);
    });
};


// AMD support
if (typeof define === 'function' && define.amd) {

    define(function () { return LetterAvatar; });

// CommonJS and Node.js module support.
} else if (typeof exports !== 'undefined') {

    // Support Node.js specific `module.exports` (which can be a function)
    if (typeof module != 'undefined' && module.exports) {
        exports = module.exports = LetterAvatar;
    }

    // But always support CommonJS module 1.1.1 spec (`exports` cannot be a function)
    exports.LetterAvatar = LetterAvatar;

} else {

    window.LetterAvatar = LetterAvatar;

    d.addEventListener('DOMContentLoaded', function(event) {
        LetterAvatar.transform();
    });
}

})(window, document);
   </script>
</html>
