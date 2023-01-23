<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Water Rights</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Home</a></li>
            <li class="breadcrumb-item active">Water Right</li>
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
          <div class="card">
            <div class="card-header">
              <div class="card-tools">
                <ul class="nav nav-pills ml-auto">


                </ul>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

              <table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>S.No</th>
                  <th>User</th>
                  <th>Water Right Number</th>
                  <th>Water Right Volume</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
            
                  <?php
                  $i = 1;
                  foreach ($data as $value): ?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <td><?php echo $value['username']; ?></td>
                  <td><?php echo $value['wr_number']; ?></td>
                  <td><?php echo $value['wr_volume']; ?></td>
                  <!-- <td><?php //echo $value['contact']; ?></td>
                  <td><?php //echo $value['gender']; ?></td>
                  <td><?php// echo $value['address']; ?></td> -->
                  <!-- <td><img src="<?php //echo $value['image']; ?>" class="profile-user-img img-fluid img-circle" alt=""> </td>
                  <td></td> -->
                  <!-- <td><?php //echo $value['channel']; ?></td> -->
                  <td>
                    <div class="btn-group btn-group-sm">
                      <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#updateoperator<?php echo $value['id']; ?>"><i class="fas fa-edit"></i></a>
                    </div>
                  </td>
                </tr>
                 <!-- update modal -->
                 <div class="modal fade" id="updateoperator<?php echo $value['id']; ?>">
                  <div class="modal-dialog">

                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Edit Water Right</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form action="<?php echo base_url('Admin/water_right'); ?>" method="post">
                      <div class="modal-body">
                              <input type="hidden" name="id" value="<?php echo $value['id']; ?>" >
                        <div class="form-group">
                          <label for="">Water Right Number</label>
                          <input type="text" name="wr_number" class="form-control" placeholder="Enter Water right number" value="<?php echo $value['wr_number']; ?>" required>
                        </div>
                        <div class="form-group">
                          <label for="">Water Right Volume</label>

                          <input type="text" name="wr_volume" class="form-control" placeholder="Enter water right vol" value="<?php echo $value['wr_volume']; ?>" required>
                        </div>

                      </div>
                      <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="updatewaterright" value="save" >Save</button>
                      </div>
                      </form>
                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
                </div>
                <!-- update modal ends-->

                <?php $i++; endforeach; ?>
                </tbody>
              </table>


            </div>
            <!-- /.card-body -->
          </div>
        </div>
        <!-- /.card -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
