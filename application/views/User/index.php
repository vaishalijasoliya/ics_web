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
<link rel="icon" href="https://portal.intelligentcanalsystems.com/assets/operators/img/ICS-logo.png">
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
                           <li class="nav-item"><a  href="<?php echo base_url('User'); ?>">Home</a></li>
                           <!-- submenu start-->
                           <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle <?php if($page_title=='Add Water Order'||$page_title=='Orders'){?> active<?php }?>" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Orders <span class="caret"></span> </a>
                              <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                 <li><a class="dropdown-item" href="<?php echo base_url('User/add_water_right'); ?>">Add Water Order</a></li>
                                 <li><a class="dropdown-item" href="<?php echo base_url('User/history_orders'); ?>">Orders</a></li>
                              </ul>
                           </li>
                           <!-- submenu start-->
                           <li class="nav-item dropdown ">
                              <a class="nav-link dropdown-toggle <?php if($page_title=='Client Details'||$page_title=='Usage Information'){?> active<?php }?>" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Account <span class="caret"></span>  </a>
                              <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                 <li><a class="dropdown-item" href="<?php echo base_url('User/client_details'); ?>">Client Details</a></li>
                                 <li><a class="dropdown-item" href="<?php echo base_url('User/usage'); ?>">Usage Information</a></li>
                              </ul>
                           </li>
                           <li class="nav-item"><a href="<?php echo base_url('User/notification'); ?>">Notification</a></li>

                           <li class="nav-item active "><a href="<?php echo base_url('User/contact'); ?>">Contact</a></li>
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
                        <a href="<?php echo base_url('User/logout'); ?>" class="btn btn-danger" >Yes</a>

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
        <?php $this->load->view('User/script');?>

   </body>
   <script type="text/javascript">
     $('.picker').datetimepicker({
      format:'Y-m-d H:i:s',
 minDate:'0',//yesterday is minimum date(for today use 0 or -1970/01/01)
})

$('.time_picker').datetimepicker({
  datepicker:false,
  format:'H:i'
});
$("#end_time_btn").click(function() {
   $("#end_time_btn").addClass("order_btn_color");

   $("#duration_btn").removeClass("order_btn_color");
   $("#volume_btn").removeClass("order_btn_color");

     $("#duration").css("display", "none");
     $("#volume").css("display", "none");
     $("#end_time").css("display", "block");

             });

 $("#end_time").change(function(){
 var text;
 var start_date=$('#start_date').val()
 var flow_rate=$('#flow_rate').val()

 var end_date=$('#end_time').val()
text=calculate_for_end_date(start_date,flow_rate,end_date)

   $("#add_calculation").html(text);

});


$("#duration").change(function(){
 var text;
       var start_date=$('#start_date').val()
       var flow_rate=$('#flow_rate').val()
       var duration=$('#duration').val()
  text= calculate_for_duration(start_date,flow_rate,duration)

   $("#add_calculation").html(text);

});

$("#volume").change(function(){
       var text;
       var start_date=$('#start_date').val()
       var flow_rate=$('#flow_rate').val()
       var volume=$('#volume').val()
   text= calculate_for_volume(start_date,flow_rate,volume)

   $("#add_calculation").html(text);

});

$("#duration_btn").click(function() {

   $("#duration_btn").addClass("order_btn_color");

   $("#end_time_btn").removeClass("order_btn_color");
   $("#volume_btn").removeClass("order_btn_color");

     $("#duration").css("display", "block");
     $("#volume").css("display", "none");
     $("#end_time").css("display", "none");
             });
   $("#volume_btn").click(function() {
      $("#volume_btn").addClass("order_btn_color");


      $("#end_time_btn").removeClass("order_btn_color");
   $("#duration_btn").removeClass("order_btn_color");

     $("#duration").css("display", "none");
     $("#volume").css("display", "block");
     $("#end_time").css("display", "none");
             });


         $(".toggle-password").click(function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
          input = $(this).parent().find("input");
          if ($(".login-password").attr("type") == "password") {
          $(".login-password").attr("type", "text");
      } else {
          $(".login-password").attr("type", "password");
      }
             });


  function formatDate(date) {
    var d = new Date(date),
      month = '' + (d.getMonth() + 1),
      day = '' + d.getDate(),
      year = d.getFullYear(),
      hr = d.getHours(),
      min = d.getMinutes(),
      sec = d.getSeconds();

    if (month.length < 2)
      month = '0' + month;
    if (day.length < 2)
      day = '0' + day;
    if (hr < 10)
      hr = "0" + hr;
    if (min < 10)
      min = "0" + min;
    if (sec < 10)
      sec = "0" + sec;
    // 2020-10-09 04:27:00
    return year + '-' + month + '-' + day + ' ' + hr + ':' + min + ':' + sec;

  }

function calculate_for_duration(start_date,flow_rate,duration)
{

 var test;
 if(start_date == '' || flow_rate == '')
{
   text='please select both start date and flow rate';
$('#duration').val('')
$('#end_time').val('')
$('#volume').val('')

}
else
{
  test=duration.split(':');
var datetime=new Date(start_date);
duration=parseInt(test[0]);
datetime.setHours(datetime.getHours()+duration)

volume=(flow_rate/24)*duration;

  text='<b>End Time :</b>'+formatDate(datetime)+'<br><b>Volume :</b>'+volume.toFixed(2)+'ML';

$('#end_date_data').val(formatDate(datetime))
$('#duration_data').val(duration)
$('#volume_data').val(volume.toFixed(2))

}

return text;

}

function calculate_for_end_date(start_date,flow_rate,end_time)
{

 var test;
var text;
 if(start_date == '' || flow_rate == '')
{
   text='please select both start date and flow rate';
$('#duration').val('')
$('#end_time').val('')
$('#volume').val('')

}
else
{

var fromDate = parseInt(new Date(start_date).getTime()/1000);
    var toDate = parseInt(new Date(end_time).getTime()/1000);
    var timeDiff = (toDate - fromDate)/3600;
    timeDiff= timeDiff.toString().split(".")[0];
   volume=(flow_rate/24)*timeDiff

 text='<b>Volume :</b>'+volume.toFixed(2)+'ML <br><b>Duration :</b>'+timeDiff+'Hrs';

$('#end_date_data').val(end_time)
$('#duration_data').val(timeDiff)
$('#volume_data').val(volume.toFixed(2))

}

return text;



}

function calculate_for_volume(start_date,flow_rate,volume)
{
 var test;
var text;
 if(start_date == '' || flow_rate == '')
{
   text='please select both start date and flow rate';
$('#duration').val('')
$('#end_time').val('')
$('#volume').val('')

}
else
{

duration=volume*(24/flow_rate)
duration=deciHours(duration)

var datetime=new Date(start_date);
datetime.setHours(datetime.getHours()+duration)


 text='<b>End Time :</b>'+formatDate(datetime)+'<br><b>Duration :</b>'+duration+'Hrs';

$('#end_date_data').val(formatDate(datetime))
$('#duration_data').val(duration)
$('#volume_data').val(volume)


}

return text;


}

function deciHours(time) {
    return (function(i) {return i + (Math.round(((time-i) * 60), 10) / 100);})(parseInt(time, 10));
}



   </script>
</html>
