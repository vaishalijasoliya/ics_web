<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Users</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Home</a></li>
            <li class="breadcrumb-item active">Users</li>
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
                  <li class="nav-item">
                    <a class="nav-link active" href="#"  data-toggle="modal"  data-target="#addnewuser">  <i class="nav-icon fas fa-plus"></i>&nbspAdd Users</a>
                  </li>

                </ul>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

              <table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>S.No</th>
                  <th>Name</th>
                  <th>Surname</th>
                  <th>Operator</th>
                  <!-- <th>Contact</th> -->
                  <!-- <th>Gender</th> -->
                  <!-- <th>Address</th> -->
                  <!-- <th>Image</th> -->
                  <!-- <th>Channel</th> -->
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
                  <td><?php echo $value['surname']; ?></td>
                  <td><?php echo $value['operatorName']; ?></td>
                  <!-- <td><?php //echo $value['contact']; ?></td>
                  <td><?php //echo $value['gender']; ?></td>
                  <td><?php// echo $value['address']; ?></td> -->
                  <!-- <td><img src="<?php //echo $value['image']; ?>" class="profile-user-img img-fluid img-circle" alt=""> </td>
                  <td></td> -->
                  <!-- <td><?php //echo $value['channel']; ?></td> -->
                  <td>
                    <div class="btn-group btn-group-sm">
                      <a href="<?php echo base_url('Admin/viewuser/'.$value['id']); ?>" class="btn btn-info"><i class="fas fa-eye"></i></a>
                      <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#updateoperator<?php echo $value['id']; ?>"><i class="fas fa-edit"></i></a>
                      <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#deleteoperator<?php echo $value['id']; ?>"><i class="fas fa-trash"></i></a>
                    </div>
                  </td>
                </tr>
                 <!-- update modal -->
                 <div class="modal fade" id="updateoperator<?php echo $value['id']; ?>">
                  <div class="modal-dialog">

                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Edit Operator</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form action="<?php echo base_url('Admin/viewusers'); ?>" method="post">
                      <div class="modal-body">
                          <input type="hidden" name="id" value="<?php echo $value['id']; ?>" >
                        <div class="form-group">
                          <input type="text" name="username" class="form-control" placeholder="Enter firstname" value="<?php echo $value['username']; ?>" required>
                        </div>
                        <div class="form-group">
                          <input type="surname" name="surname" class="form-control" placeholder="Enter surname" value="<?php echo $value['surname']; ?>" required>
                        </div>
                        <div class="form-group">
                          <select class="form-control" name="opertor_id" required>
                            <option value="" disabled selected>Select Operator</option>
                          <?php
                           foreach ($operators as $values) {
                             ?>
                             <option value="<?php echo $values['id'] ?>" <?php if($value['operatorName']==$values['username']){ echo 'selected'; } ?>><?php echo  $values['username'] ?></option>

                             <?php
                           }
                           ?>
                          </select>
                        </div>
                        <!-- <div class="form-group">
                          <input type="text" name="contact" class="form-control" placeholder="Enter contact" value="<?php //echo $value['contact']; ?>" required>
                        </div>
                        <div class="form-group">
                          <select class="form-control select2" name="gender" required>
                            <option selected="selected" value="Male">Male</option>
                            <option value="Female">Female</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <input type="text" name="address" class="form-control" placeholder="Enter address" value="<?php //echo $value['address']; ?>" required>
                        </div> -->
                      </div>
                      <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="updateuser" value="save" >Save</button>
                      </div>
                      </form>
                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
                </div>
                <!-- update modal ends-->
                 <!-- deleteoperator modal -->
                 <div class="modal fade" id="deleteoperator<?php echo $value['id']; ?>">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <form action="<?php echo base_url('Admin/viewusers'); ?>" method="post">
                            <div class="modal-body">
                              <p>Are you sure want to remove <strong><?php echo $value['username']; ?></strong> ?</p>
                              <input type="hidden" name="id" value="<?php echo $value['id']; ?>" >
                            </div>
                            <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                            <button type="submit" class="btn btn-danger" name="deleteuser" value="save" >Yes</button>
                            </div>
                          </form>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                    <!-- deleteoperator modal ends-->
                <?php $i++; endforeach; ?>
                </tbody>
              </table>

              <div class="modal fade" id="addnewuser">
               <div class="modal-dialog">
                 <div class="modal-content">
                   <div class="modal-header">
                     <h4 class="modal-title">Add User</h4>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                     </button>
                   </div>
                   <form action="<?php echo base_url('Admin/viewusers'); ?>" method="post">
                   <div class="modal-body">
                     <div class="form-group">
                       <input type="text" name="username" class="form-control" placeholder="Enter username" required>
                     </div>
                     <div class="form-group">
                       <input type="test" name="surname" class="form-control" placeholder="Enter Surname" required>
                     </div>

                     <div class="form-group" >
                       <select class="form-control" name="opertor_id" required>
                         <option value="" disabled selected>Select Operator</option>
                       <?php
                        foreach ($operators as $value) {
                          ?>
                          <option value="<?php echo $value['id'] ?>"><?php echo  $value['username'] ?></option>

                          <?php
                        }
                        ?>
                       </select>
                     </div>
                   </div>
                   <div class="modal-footer justify-content-between">
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                     <button type="submit" class="btn btn-primary" name="addnewuser" value="save" >Save</button>
                   </div>
                   </form>
                 </div>
                 <!-- /.modal-content -->
               </div>
               <!-- /.modal-dialog -->
             </div>
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
