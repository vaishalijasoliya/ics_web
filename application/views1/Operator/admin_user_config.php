<section class="system-info">
   <div class="system-info">
      <div class="all-oprators-heading">
         <h2>List of Operators</h2>
      </div>
   </div>
<div class="container">
  <div class="col-md-12">
  <a href="#" class="btn addnew-btn"  data-toggle="modal" data-target="#myModal" style="float:right;margin-bottom:10px;">Create New Operator</a>

  </div>
<div class="system-info-table">
      <table class="table table-responsive" id="example1">
         <thead>
            <tr>
               <th>S.No</th>
               <th>Name</th>
               <th>Email</th>
               <th>Actions </th>
            </tr>
         </thead>
         <tbody>
           <?php
           $i=1;
            foreach ($data as $operator) {
            ?>
            <tr>
               <td><?php echo $i; ?></td>
               <td><?php echo $operator['username']; ?></td>
               <td><?php echo $operator['email']; ?></td>
               <td><a href="#" class="system-info-edit-btn" data-toggle="modal" data-target="#editoperator<?php echo $operator['id']; ?>">EDIT OPERATOR</a><br>
                 <?php if ($_SESSION['user_id']!=$operator['id']): ?>
                   <a href="#" class="system-info-delete-btn" data-toggle="modal" data-target="#deleteoperator<?php echo $operator['id']; ?>">DELETE OPERATOR</a>
                 <?php endif; ?>
               </td>
            </tr>
            <div class="modal fade" id="editoperator<?php echo $operator['id']; ?>" role="dialog">
             <div class="modal-dialog modal-md">
               <div class="modal-content">
                 <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal">&times;</button>
                   <h4 class="modal-title">Edit Operator Details</h4>
                 </div>
                 <div class="modal-body" style="margin-bottom:20px">

                   <form  action="<?php echo base_url('Operator/admin_user_config'); ?>" method="post">
                     <div class="form-group">
                         <label for="email">Username:</label>
                         <input type="text" class="form-control" id="email" name="username" value="<?php echo $operator['username']; ?>">
                       </div>
                       <input type="hidden" name="id" value="<?php echo $operator['id']; ?>">
                       <div class="form-group">
                         <label for="pwd">Email:</label>
                         <input type="email" class="form-control" id="pwd" name="email" value="<?php echo $operator['email']; ?>" readonly>
                       </div>
                        <div class="row">
                          <div class="col-md-2">
                            <label for="pwd" style="padding-top:20px;">Password:</label>
                          </div>
                          <div class="col-md-10">
                            <div class="input-group">
                                <input type="password" class="form-control login-password" name="password" placeholder="Text input" value="<?php echo base64_decode($operator['password']); ?>"> <span class="input-group-btn">
                              <button type="button" class="btn btn-search"><i class="toggle-password fa fa-fw fa-eye-slash"></i></button>
                          </span>
                            </div>
                          </div>
                        </div>






                       <!-- <button type="submit" class="btn btn-primary" name="" value="save">Edit User Details</button> -->
                 </div>

                 <div class="modal-footer">
                   <button type="submit" class="btn btn-primary" name="updateoperator" value="save">Edit User Details</button>
                 </div>
               </form>

               </div>
             </div>
           </div>
           <div class="modal fade" id="deleteoperator<?php echo $operator['id']; ?>" role="dialog">
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <!-- <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Delete Operator</h4>
                </div> -->
                <div class="modal-body">
                  <p> Are you sure want to Delete <b><?php echo $operator['username']; ?></b>?</p>
                </div>
                <div class="modal-footer">
                  <form class="" action="<?php echo base_url('Operator/admin_user_config'); ?>" method="post">
                    <input type="hidden" name="id" value="<?php echo $operator['id']; ?>">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-danger" name="deleteoperator" value="save">Yes</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
            <?php
            $i++;
            }
            ?>
         </tbody>
      </table>
   </div>
</div>

   <!-- Trigger the modal with a button -->

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Create New Operator</h4>
      </div>
      <div class="modal-body">
        <form  id="newoperator" class="form-horizontal" action="<?php echo base_url('Operator/admin_user_config'); ?>" method="post">
          <div class="form-group">
            <label  class="control-label col-sm-2" for="exampleInputEmail1">Username</label>
             <div class="col-sm-10">
            <input type="text" class="form-control" name="username" placeholder="Enter Username">
          </div>
        </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="exampleInputEmail1">Email address</label>
            <div class="col-sm-10">
              <input type="email" class="form-control" name="email" placeholder="Enter email">
          </div>
        </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="exampleInputPassword1">Password</label>
                <div class="col-sm-10">
            <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Password">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="createoperator" value="save">Submit</button>
      </div>
    </form>
    </div>
  </div>
</div>
   <!-- table value end -->
</section>
<!-- main section end -->
