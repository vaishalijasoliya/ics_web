<div>
<input type="text" id="search" placeholder="Search Operator">  
</div>
<div class="table-responsive">         
    <table id="adminuserconfig" class="table">
        <thead>
        <tr>
            <th>Sno</th>
            <th>Username</th>
            <th>Email</th>
            <th>Password</th>
            <th>Created Date</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 1; foreach ($data as $value): ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $value['username']; ?></td>
                <td><?php echo $value['email']; ?></td>
                <td><?php echo $value['password']; ?></td>
                <td><?php echo date('Y-m-d',strtotime($value['created_at'])); ?></td>
                <td>                 
                    <div class="btn-group btn-group-sm">
                    <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#updateoperator<?php echo $value['id']; ?>"><i class="fa fa-edit"></i></a>
                    <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#deleteoperator<?php echo $value['id']; ?>"><i class="fa fa-trash"></i></a>
                    </div>                  
                </td>
            </tr>
            <!-- update modal -->
            <div class="modal fade" id="updateoperator<?php echo $value['id']; ?>">
            <div class="modal-dialog">
                <div class="modal-content">                          
                <form action="<?php echo base_url('operator/admin_user_config'); ?>" method="post">
                <div class="modal-body">                            
                    <input type="hidden" name="id" value="<?php echo $value['id']; ?>" >
                    <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Enter username" value="<?php echo $value['username']; ?>" required>
                    </div>
                    <div class="form-group">
                    <label>Email <span class="emailvalid" style="color:red"></span></label>
                    <input type="email" name="email" class="form-control editemail" placeholder="Enter email" value="<?php echo $value['email']; ?>" required>
                    </div>   
                    <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter password" value="<?php echo $value['password']; ?>" required>
                    </div>                               
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info" name="updateoperator" value="save" >Save</button>
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
                    <form action="<?php echo base_url('operator/admin_user_config'); ?>" method="post">
                        <div class="modal-body">
                        <p>Are you sure want to remove <strong><?php echo $value['username']; ?></strong> ?</p>
                        <input type="hidden" name="id" value="<?php echo $value['id']; ?>" >
                        </div>
                        <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-danger" name="deleteoperator" value="save" >Yes</button>
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
</div>