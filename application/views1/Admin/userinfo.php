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

              <h3 class="profile-username text-center"><?php echo ucfirst($data[0]['username'])." ".ucfirst($data[0]['surname']); ?></h3>

              <p class="text-muted text-center"><?php echo ucfirst($data[0]['company_name']); ?></p>

              <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                  <b>First Name</b> <a class="float-right"><?php echo ucfirst($data[0]['username']); ?></a>
                </li>
                  <li class="list-group-item">
                    <b>Last Name</b> <a class="float-right"><?php echo ucfirst($data[0]['contact_name']); ?></a>
                </li>
                <li class="list-group-item">
                      <b>Operator Name</b> <a class="float-right"><?php echo ucfirst($data[0]['operatorName']); ?></a>
                </li>

                <li class="list-group-item">
                      <b>Contact</b> <a class="float-right"><?php echo ucfirst($data[0]['contact']); ?></a>
                </li>
                <li class="list-group-item">
                      <b>Phone</b> <a class="float-right"><?php echo ucfirst($data[0]['phone']); ?></a>
                </li>
                <li class="list-group-item">
                      <b>Address</b> <a class="float-right"><?php echo ucfirst($data[0]['address']); ?></a>
                </li>

                <li class="list-group-item">
                      <b>Contact</b> <a class="float-right"><?php echo ucfirst($data[0]['contact']); ?></a>
                </li>

              </ul>
              <div class="container">
                <h5>**Water Right Number**</h5>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>S No.</th>
                      <th>Water Right Numbers</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                     $i=1;
                     foreach ($water_right as $value) {

                       ?>
                       <tr>
                         <td><?php    echo $i; ?></td>
                         <td><?php    echo $value['wr_number']; ?></td>
                       </tr>
                       <?php
                       $i++;
                     }
                     ?>

                  </tbody>
                </table>
              </div>


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
