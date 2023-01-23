<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php if($page_title){echo $page_title;}else{echo "default";} ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
  <style>
  .alert-dismissible {
    position: absolute;
    right: 0;
  }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <!-- <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li> -->
    </ul>

    <!-- SEARCH FORM -->
    <!-- <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form> -->

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-danger">
        <i class="fa fa-sign-out"></i>
        </button>
      </li>

    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="<?php echo base_url(); ?>assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light"><strong>ICS</strong></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php //echo base_url(); ?>assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><strong><?php // print_r($this->session->userdata('name'));?></strong> </a>
        </div>
      </div> -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="<?php echo base_url('admin'); ?>" class="nav-link <?php
            if(($page_title == 'Dashboard') || ($page_title == 'Operators') || ($page_title == 'Users')){echo 'active';}?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url('admin/canal_info'); ?>" class="nav-link <?php
            if($page_title == 'Canal Info'){ echo 'active'; }?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Canal Info</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url('admin/water_right'); ?>" class="nav-link <?php
            if($page_title == 'Water Right'){ echo 'active'; }?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Water Right</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?php echo base_url('admin/edit_profile'); ?>" class="nav-link <?php
            if($page_title == 'Edit Profile'){ echo 'active'; }?>">
          &nbsp  <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
              &nbsp   <p>Edit Profile</p>
            </a>
          </li>

          <!-- <li class="nav-item">
            <a href="<?php //echo base_url('admin/operators'); ?>" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Operators
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php //echo base_url('admin/users'); ?>" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Users
              </p>
            </a>
          </li> -->
          <li class="nav-item">
            <a href="<?php echo base_url('admin/seasons'); ?>" class="nav-link  <?php
            if($page_title == 'Seasons Schedules'){ echo 'active'; }?>">
              <i class="nav-icon fas fa-cloud"></i>
              <p>
                Seasons Schedules
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
<?php $this->load->view($page_name); ?>
  <!-- Content Wrapper. Contains page content -->

  <!-- /.content-wrapper -->
  <!-- <footer class="main-footer">
    <strong>Copyright &copy; 2020-2022 <a href="http://adminlte.io">ICS</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.0.2
    </div>
  </footer> -->
  <div class="modal fade" id="modal-danger">
    <div class="modal-dialog">
      <div class="modal-content bg-danger">
        <div class="modal-header">
          <h4 class="modal-title">Logout</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to Exit?</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
          <a href="<?php echo base_url('Admin/signout'); ?>" class="btn btn-outline-light">Logout</a>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url(); ?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo base_url(); ?>assets/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo base_url(); ?>assets/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="<?php echo base_url(); ?>assets/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url(); ?>assets/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url(); ?>assets/plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo base_url(); ?>assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?php echo base_url(); ?>assets/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url(); ?>assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>assets/dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo base_url(); ?>assets/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>assets/dist/js/demo.js"></script>

<!-- DataTables -->
<script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script>
  $(function () {
    $('.alert-dismissible').delay(3000).fadeOut();
    $("#example1").DataTable();
    $('#example2').DataTable();
    $('#summer').daterangepicker()
    $('#winter1').daterangepicker()
    $('#winter2').daterangepicker()

  });

  function editField()
  {
      $('#replace_email').html('<input class="form-control" id="edit_email" type="email" value="'+$('#replace_email').text()+'"><i class="fa fa-check" onclick="saveField()" style="float:right;color:red;"></i>')
  }
  function saveField()
  {
    var email=$('#edit_email').val()

    var origin = window.location.origin;
    var siteurl = origin + '/ICSweb/admin/edit_email';
    var request = $.ajax({
        url: siteurl,
        method: "POST",
        data: {
            email: email,
        },
        dataType: "html"
    });
    request.done(function(msg) {
      // alert("ok")
    })

       $('#replace_email').html($('.form-control').val()+'<i class="fa fa-edit mx-3" onclick="editField()"></i>')
  }

  function editName()
  {
      $('#replace_name').html('<input class="form-control" id="edit_name" type="text" value="'+$('#replace_name').text()+'"><i class="fa fa-check" onclick="saveName()" style="float:right;color:red;"></i>')
  }
  function saveName()
  {
    var email=$('#edit_name').val()

    var origin = window.location.origin;
    var siteurl = origin + '/ICSweb/admin/edit_name';
    var request = $.ajax({
        url: siteurl,
        method: "POST",
        data: {
            email: email,
        },
        dataType: "html"
    });
    request.done(function(msg) {
      // alert("ok")
    })

       $('#replace_name').html($('.form-control').val()+'<i class="fa fa-edit mx-3" onclick="editName()"></i>')
  }

  $(".toggle-password").click(function() {

  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});


function editPassword()
{
  var password=$('#password-field').val()

  var origin = window.location.origin;
  var siteurl = origin + '/ICSweb/admin/edit_password';
  var request = $.ajax({
      url: siteurl,
      method: "POST",
      data: {
          password: password,
      },
      dataType: "html"
  });
  request.done(function(msg) {
    // alert("ok")
    $('#pass').addClass('fa-pencil-square-o').removeClass('fa-check');

  })
}

$('#password-field').keyup(function() {

 $('#pass').addClass('fa-check').removeClass('fa-pencil-square-o');
})

</script>
</body>
</html>
