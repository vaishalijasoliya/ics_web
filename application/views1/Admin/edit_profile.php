<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">User Info</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url('admin/viewusers'); ?>">Users</a></li>
            <li class="breadcrumb-item active">User Info</li>
          </ol>
        </div><!-- /.col -->

      </div><!-- /.row -->

    </div><!-- /.container-fluid -->

  </div>
  <!-- /.content-header -->
  <?php
  $error= $this->session->flashdata('error');
  if($error)
  {
  ?>
  <div class="row">
    <div class="col-md-12 mb-5">
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?php echo $error; ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    </div>
  </div>

  <?php
  }
  ?>
  <?php
  $success= $this->session->flashdata('success');
  if($success)
  {
  ?>
  <div class="row mb-1">
    <div class="col-md-12 mb-5">
      <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    </div>
  </div>
  <?php
  }
  ?>
  <!-- Main content -->
  <section class="content mx-2">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">

        <div class="col-md-12">
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <img class="profile-user-img img-fluid img-circle"
                     src="<?php echo base_url(); ?>/assets/dist/img/user4-128x128.jpg"
                     alt="User profile picture">
              </div>

              <h3 class="profile-username text-center"><?php echo ucfirst($data[0]['username']); ?></h3>

              <p class="text-muted text-center"></p>

              <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                  <b>First Name</b> <a  id="replace_name"  class="float-right"><?php echo ucfirst($data[0]['username']); ?><i class="fa fa-pencil-square-o mx-3" onclick="editName()" aria-hidden="true"></i></a>
                </li>
                  <li class="list-group-item">
                    <b>Email</b> <a id="replace_email" class="float-right"><?php echo $data[0]['email']; ?><i class="fa fa-pencil-square-o mx-3" onclick="editField()" aria-hidden="true"></i></a>
                </li>
                <li class="list-group-item">
                  <b>Change Password</b> <a class="float-right">   <input id="password-field" type="password" name="password" value="<?php echo base64_decode($data[0]['password']); ?>"><i  toggle="#password-field" class="fa fa-eye mx-1 toggle-password" aria-hidden="true"></i><i id="pass" class="fa fa-pencil-square-o mx-3" onclick="editPassword()"></i></a>
              </li>

              </ul>

            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
