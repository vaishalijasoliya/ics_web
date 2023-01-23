<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Canal Info</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Home</a></li>
            <li class="breadcrumb-item active">Canal Info</li>
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
  <div class="alert alert-danger alert-dismissible fade show m-4" role="alert">
  <?php echo $error; ?>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?php
}
?>
<?php
$success= $this->session->flashdata('success');
if($success){
?>
<div class="alert alert-success alert-dismissible fade show m-3" role="alert">
<?php echo $success; ?>
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>
</div>
<?php } ?>
  <!-- Main content -->
    <section class="content">
      <div class="row">

        <div class="col-md-4 my-2">
          <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addnewchannel"><i class="fas fa-plus"></i>&nbspAdd Channel</button>
        </div>
        <div class="col-md-4 my-2">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addnewmetertype"><i class="fas fa-plus"></i>&nbspAdd Meter Type</button>
        </div>
      </div>
    <!-- addnewright modal -->

    <!-- addnewright modal ends-->
     <!-- addnewchannel modal -->
     <div class="modal fade" id="addnewchannel">
      <div class="modal-dialog">
        <div class="modal-content">
          <form action="<?php echo base_url('Admin/canal_info'); ?>" method="post">
          <div class="modal-body">
            <div class="form-group">
              <input type="text" name="channel" class="form-control" placeholder="Enter channel name" required>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="addnewchannel" value="save" >Save</button>
          </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="addnewmetertype">
      <div class="modal-dialog">
        <div class="modal-content">
          <form action="<?php echo base_url('Admin/canal_info'); ?>" method="post">
          <div class="modal-body">
            <div class="form-group">
              <input type="text" name="meter_type" class="form-control" placeholder="Enter Meter Type" required>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="addnewmetertype" value="save" >Save</button>
          </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- addnewchannel modal ends-->
    </section>

   <!-- Main content -->
   <section class="content">
      <div class="row">
        
        <div class="col-md-4">
           <!-- /.card -->
           <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">Channels</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body p-0">
              <table class="table">
              <thead>
                  <tr>
                    <th> Name </th>
                    <th class="text-right py-0 align-middle">Actions</th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($channels as $value): ?>
                    <tr>
                        <td><?php echo $value['channel_name']; ?></td>
                        <td class="text-right py-0 align-middle">
                            <div class="btn-group btn-group-sm">
                              <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#updatechannel<?php echo $value['id']; ?>"><i class="fas fa-edit"></i></a>
                              <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#deletechannel<?php echo $value['id']; ?>"><i class="fas fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                    <!-- update modal -->
                    <div class="modal fade" id="updatechannel<?php echo $value['id']; ?>">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <form action="<?php echo base_url('Admin/canal_info'); ?>" method="post">
                          <div class="modal-body">
                            <div class="form-group">
                            <input type="hidden" name="id" value="<?php echo $value['id']; ?>" >
                              <input type="text" name="channel" class="form-control" placeholder="Enter channel name" value="<?php echo $value['channel_name']; ?>" required>
                            </div>
                          </div>
                          <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="updatechannel" value="save" >Save</button>
                          </div>
                          </form>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                    <!-- update modal ends-->
                     <!-- delete modal -->
                     <div class="modal fade" id="deletechannel<?php echo $value['id']; ?>">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <form action="<?php echo base_url('Admin/canal_info'); ?>" method="post">
                            <div class="modal-body">
                              <p>Are you sure want to remove <strong><?php echo $value['channel_name']; ?></strong> ?</p>
                              <input type="hidden" name="id" value="<?php echo $value['id']; ?>" >
                            </div>
                            <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                            <button type="submit" class="btn btn-danger" name="deletechannel" value="save" >Yes</button>
                            </div>
                          </form>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                    <!-- delete modal ends-->
                    <?php $i++; endforeach; ?>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <div class="col-md-4">
           <!-- /.card -->
           <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">Meter Type</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body p-0">
              <table class="table">
              <thead>
                  <tr>
                    <th> Type </th>
                    <th class="text-right py-0 align-middle">Actions</th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($metertype as $value): ?>
                    <tr>
                        <td><?php echo $value['type']; ?></td>
                        <td class="text-right py-0 align-middle">
                            <div class="btn-group btn-group-sm">
                              <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#updatemetertype<?php echo $value['id']; ?>"><i class="fas fa-edit"></i></a>
                              <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#deletemetertype<?php echo $value['id']; ?>"><i class="fas fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                    <!-- update modal -->
                    <div class="modal fade" id="updatemetertype<?php echo $value['id']; ?>">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <form action="<?php echo base_url('Admin/canal_info'); ?>" method="post">
                          <div class="modal-body">
                            <div class="form-group">
                            <input type="hidden" name="id" value="<?php echo $value['id']; ?>" >
                              <input type="text" name="type" class="form-control" placeholder="Enter Meter Type" value="<?php echo $value['type']; ?>" required>
                            </div>
                          </div>
                          <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="updatemetertype" value="save" >Save</button>
                          </div>
                          </form>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                    <!-- update modal ends-->
                     <!-- delete modal -->
                     <div class="modal fade" id="deletemetertype<?php echo $value['id']; ?>">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <form action="<?php echo base_url('Admin/canal_info'); ?>" method="post">
                            <div class="modal-body">
                              <p>Are you sure want to remove <strong><?php echo $value['type']; ?></strong> ?</p>
                              <input type="hidden" name="id" value="<?php echo $value['id']; ?>" >
                            </div>
                            <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                            <button type="submit" class="btn btn-danger" name="deletemetertype" value="save" >Yes</button>
                            </div>
                          </form>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                    <!-- delete modal ends-->
                    <?php $i++; endforeach; ?>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>

      </div>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-md-4 my-2">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addnewchargecode"><i class="fas fa-plus"></i>&nbspAdd Charge Code</button>
        </div>
        <div class="col-md-4 my-2">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addnewallocationtype"><i class="fas fa-plus"></i>&nbspAdd Allocation Type</button>
        </div>
        <!-- <div class="col-md-4 my-2">
          <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addnewdebator"><i class="fas fa-plus"></i>&nbspAdd Debator</button>
        </div> -->


      </div>
    <!-- addnewright modal -->
    <div class="modal fade" id="addnewchargecode">
      <div class="modal-dialog">
        <div class="modal-content">
          <form action="<?php echo base_url('Admin/canal_info'); ?>" method="post">
          <div class="modal-body">
            <div class="form-group">
              <input type="text" name="charge_code" class="form-control" placeholder="Enter Charge Code" required>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="addnewchargecode" value="save" >Save</button>
          </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- addnewright modal ends-->
     <!-- addnewchannel modal -->
     <div class="modal fade" id="addnewallocationtype">
      <div class="modal-dialog">
        <div class="modal-content">
          <form action="<?php echo base_url('Admin/canal_info'); ?>" method="post">
          <div class="modal-body">
            <div class="form-group">
              <input type="text" name="allocation_type" class="form-control" placeholder="Enter Allocation Type" required>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="addnewallocationtype" value="save" >Save</button>
          </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <div class="modal fade" id="addnewdebator">
     <div class="modal-dialog">
       <div class="modal-content">
         <form action="<?php echo base_url('Admin/canal_info'); ?>" method="post">
         <div class="modal-body">
           <div class="form-group">
             <input type="text" name="debator_code" class="form-control" placeholder="Enter Debator Code" required>
           </div>
         </div>
         <div class="modal-footer justify-content-between">
           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
           <button type="submit" class="btn btn-primary" name="addnewdebator" value="save" >Save</button>
         </div>
         </form>
       </div>
       <!-- /.modal-content -->
     </div>
     <!-- /.modal-dialog -->
   </div>
    <!-- addnewchannel modal ends-->
    </section>

   <!-- Main content -->
   <section class="content">
      <div class="row">
        <div class="col-md-4">
          <!-- /.card -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Charge Code</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body p-0">
              <table class="table">
                <thead>
                  <tr>
                    <th> Charge Code</th>
                    <!-- <th> Surname</th>
                    <th> Firstname</th>                     -->
                    <th class="text-right py-0 align-middle">Actions</th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($charge_codes as $value): ?>
                    <tr>
                      <td><?php echo $value['charge_code']; ?></td>
                      <!-- <td><?php // echo $value['wr_surname']; ?></td> -->
                      <!-- <td><?php //echo $value['wr_firstname']; ?></td> -->
                      <td class="text-right py-0 align-middle">
                        <div class="btn-group btn-group-sm">
                          <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#updatenewchargecode<?php echo $value['id']; ?>"><i class="fas fa-edit"></i></a>
                          <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#deletenewchargecode<?php echo $value['id']; ?>"><i class="fas fa-trash"></i></a>
                        </div>
                      </td>
                    </tr>
                    <!-- update modal -->
                    <div class="modal fade" id="updatenewchargecode<?php echo $value['id']; ?>">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <form action="<?php echo base_url('Admin/canal_info'); ?>" method="post">
                          <div class="modal-body">
                            <div class="form-group">
                            <input type="hidden" name="id" value="<?php echo $value['id']; ?>" >
                              <input type="text" name="charge_code" class="form-control" placeholder="Enter Charge Code" value="<?php echo $value['charge_code']; ?>" required>
                            </div>
                          </div>
                          <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="updatenewchargecode" value="save" >Save</button>
                          </div>
                          </form>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                    <!-- update modal ends-->
                     <!-- deletenewright modal -->
                     <div class="modal fade" id="deletenewchargecode<?php echo $value['id']; ?>">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <form action="<?php echo base_url('Admin/canal_info'); ?>" method="post">
                            <div class="modal-body">
                              <p>Are you sure want to remove <strong><?php echo $value['charge_code']; ?></strong> ?</p>
                              <input type="hidden" name="id" value="<?php echo $value['id']; ?>" >
                            </div>
                            <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                            <button type="submit" class="btn btn-danger" name="deletenewchargecode" value="save" >Yes</button>
                            </div>
                          </form>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                    <!-- deletenewright modal ends-->
                    <?php $i++; endforeach; ?>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
          <!-- /.card -->
        </div>
        <div class="col-md-4">
           <!-- /.card -->
           <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">Allocation Type</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body p-0">
              <table class="table">
              <thead>
                  <tr>
                    <th> Type </th>
                    <th class="text-right py-0 align-middle">Actions</th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($allocation_type as $value): ?>
                    <tr>
                        <td><?php echo $value['type']; ?></td>
                        <td class="text-right py-0 align-middle">
                            <div class="btn-group btn-group-sm">
                              <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#updateallowcationtype<?php echo $value['id']; ?>"><i class="fas fa-edit"></i></a>
                              <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#deleteallowcationtype<?php echo $value['id']; ?>"><i class="fas fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                    <!-- update modal -->
                    <div class="modal fade" id="updateallowcationtype<?php echo $value['id']; ?>">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <form action="<?php echo base_url('Admin/canal_info'); ?>" method="post">
                          <div class="modal-body">
                            <div class="form-group">
                            <input type="hidden" name="id" value="<?php echo $value['id']; ?>" >
                              <input type="text" name="type" class="form-control" placeholder="Enter Allocation Type" value="<?php echo $value['type']; ?>" required>
                            </div>
                          </div>
                          <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="updateallowcationtype" value="save" >Save</button>
                          </div>
                          </form>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                    <!-- update modal ends-->
                     <!-- delete modal -->
                     <div class="modal fade" id="deleteallowcationtype<?php echo $value['id']; ?>">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <form action="<?php echo base_url('Admin/canal_info'); ?>" method="post">
                            <div class="modal-body">
                              <p>Are you sure want to remove <strong><?php echo $value['type']; ?></strong> ?</p>
                              <input type="hidden" name="id" value="<?php echo $value['id']; ?>" >
                            </div>
                            <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                            <button type="submit" class="btn btn-danger" name="deleteallowcationtype" value="save" >Yes</button>
                            </div>
                          </form>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                    <!-- delete modal ends-->
                    <?php $i++; endforeach; ?>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>


      </div>
    </section>
  <!-- /.content -->
</div>
