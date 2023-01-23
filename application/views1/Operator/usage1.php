
         <!--   main section start  -->
         <section class="historical-meters-entries">
            <div class="container">
              <?php
           if(!empty($this->session->flashdata('error'))){
             ?>
             <div class="alert alert-danger alert-dismissible gone" style="margin:20px;">
               <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
               <strong>Error!</strong> <?php   print_r($this->session->flashdata('error')); ?>
             </div>
             <?php
           }
           ?>
           <?php
           if(!empty($this->session->flashdata('success'))){
           ?>
           <div class="alert alert-success alert-dismissible gone" style="margin:20px;">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong> <?php   print_r($this->session->flashdata('success')); ?>
           </div>
           <?php
           }
           ?>
           <div class="row">
             <div class="col-md-12">
               <div class="save-btn">
                  <button class="btn addnew-btn"  data-toggle="modal" data-target="#add-meter" style="float:right;" >Add New</button>
               </div>
             </div>
           </div>
               <div class="row">

                  <div class="all-entries">

                     <div class="table-caption">
                        <h3>Usage History</h3>
                     </div>
                     <div class="all-entries-table">
                        <div class="table-responsive text-nowrap">
                           <table class="table"  id="example">
                              <thead>
                                 <tr>
                                    <th scope="col">Meter Pic</th>
                                    <th scope="col">Serial No</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Reading</th>
                                    <th scope="col">Read Date</th>
                                    <th scope="col">Usage</th>
                                    <th scope="col">Seasonal</th>
                                    <th scope="col">Channel</th>
                                    <th scope="col">Charge Code</th>
                                    <th scope="col">Meter type</th>
                                    <th scope="col">Edit</th>
                                 </tr>
                              </thead>
                              <tbody>
                                <?php foreach ($data as $value): ?>
                                  <tr>
                                    <th scope="row"><?php if($value['photo']==''){ ?>
                                    <img src="<?php echo base_url(); ?>assets/operators/img/meter.png" alt="meter" width="50" height="50">
                                    <?php }else{ ?><img src="<?php echo base_url(); ?>assets/meterimages/<?php echo $value['photo']; ?>" alt="meter" width="50" height="50"><?php }?></th>
                                    <td><?php if($value['serial_number']!=0){ echo $value['serial_number']; }?></td>
                                    <td><?php echo ucfirst($value['meter_name']); ?></td>
                                    <td><?php echo $value['meter_reading']; ?>&nbspML</td>
                                    <td><?php echo date('d-m-Y h:i A', strtotime($value['date_of_reading'])); ?></td>

                                    <td></td>
                                    <td></td>
                                    <td><?php echo $value['channel_name']; ?></td>
                                    <td><?php echo $value['charge_code_value']; ?></td>
                                    <td><?php echo $value['type']; ?></td>
                                    <td><a href="#"  data-toggle="modal" data-target="#edit-meter<?php echo $value['id']; ?>"> <img src="<?php echo base_url(); ?>assets/operators/img/edit-meter.png" alt="meter"></a></td>


                                  </tr>
                                  <div class="modal fade" id="edit-meter<?php echo $value['id']; ?>">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h4 class="modal-title">Edit Details</h4>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <form class="" action="<?php echo base_url('operator/usage'); ?>" method="post" enctype="multipart/form-data">

                                        <div class="modal-body">
                                          <div class="form-group">
                                            <?php if($value['photo']==''){ ?>
                                            <img  id="image-preview" src="<?php echo base_url(); ?>assets/operators/img/img-icon-0.jpg" alt="" style="height:150px;width:200px;margin-left:35%;">
                                            <?php }else{ ?>
                                          <img  id="image-preview" src="<?php echo base_url(); ?>assets/meterimages/<?php echo $value['photo']; ?>" alt="" style="height:150px;width:200px;margin-left:35%;"><?php }?>

                                          </div>
                                          <input type="hidden" name="imagename" value="<?php echo $value['photo']; ?>">

                                          <div class="form-group">
                                            <input type="file" name="file" class="form-control file-input"  id="" >
                                          </div>
                                          <div class="form-group">
                                            <input type="hidden" name="meter_id" value="<?php echo $value['id']; ?>">
                                            <label for="">Meter Name</label>
                                            <input type="text" class="form-control" name="meter_name" value="<?php echo $value['meter_name']; ?>" readonly>
                                          </div>
                                          <div class="form-group">
                                            <label for="">Serial Numver</label>
                                            <input type="text" class="form-control" name="serial_number" value="<?php echo $value['serial_number']; ?>" readonly>
                                          </div>
                                          <div class="form-group">
                                            <label for="">Reading</label>
                                            <input type="text" class="form-control" name="meter_reading" value="<?php echo $value['meter_reading']; ?>">
                                          </div>

                                          <div class="form-group">
                                            <label for="">Read Date</label>
                                            <input type="text" class="form-control picker" name="date_of_reading" value="<?php echo $value['date_of_reading']; ?>">
                                          </div>
                                          <div class="form-group">
                                            <label for="">Usage</label>
                                            <input type="text" class="form-control" name="usage" value="">
                                          </div>
                                          <div class="form-group">
                                            <label for="">Seasonal</label>
                                            <input type="text" class="form-control" name="season" value="">
                                          </div>

                                          <div class="form-group">
                                            <label for="">Channel</label>

                                              <select class="form-control" name="channel">
                                                <?php
                                                foreach($channels as $channel)
                                                {
                                                 ?>
                                                 <option value="<?php echo $channel['id']; ?>" <?php if($value['channel_name']==$channel['channel_name']){?>selected<?php }?>><?php echo $channel['channel_name']; ?></option>
                                                 <?php
                                               }
                                                  ?>


                                              </select>

                                          </div>
                                          <div class="form-group">
                                            <label for="">Charge Code</label>
                                            <select class="form-control" name="charge_code">
                                              <?php
                                              foreach($charge_codes as $charge_code)
                                              {
                                               ?>
                                               <option value="<?php echo $charge_code['id']; ?>" <?php if($value['charge_code_value']==$charge_code['charge_code']){?>selected<?php }?>><?php echo $charge_code['charge_code']; ?></option>
                                               <?php
                                             }
                                                ?>

                                            </select>
                                          </div>

                                          <div class="form-group">
                                            <label for="">Meter Type</label>

                                              <select class="form-control" name="meter_type" disabled>
                                                <option value="">Select Meter Type</option>
                                                <?php
                                                foreach($metertype as $type)
                                                {
                                                 ?>
                                                 <option value="<?php echo $type['id']; ?>" <?php if($value['type']==$type['type']){?>selected<?php }?>><?php echo $type['type']; ?></option>
                                                 <?php
                                               }
                                                  ?>
                                              </select>
                                          </div>

                                        </div>
                                        <div class="modal-footer justify-content-between">
                                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                          <button type="submit" class="btn btn-primary" name="edit_meter_readings" value="save">Save changes</button>
                                        </div>
                                      </form>

                                      </div>
                                      <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                  </div>
                                  <!-- /.modal -->
                                <?php endforeach; ?>

                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!--   main section end  -->
         <div class="modal fade" id="add-meter">
           <div class="modal-dialog">
             <div class="modal-content">
               <div class="modal-header">
                 <h4 class="modal-title">Add Meter Reading</h4>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
                 </button>
               </div>
               <form class="" action="<?php echo base_url('operator/usage'); ?>" method="post" enctype="multipart/form-data">

               <div class="modal-body">
                 <div class="form-group">
                   <img  id="image-preview" src="<?php echo base_url(); ?>assets/operators/img/img-icon-0.jpg" alt="" style="height:150px;width:200px;margin-left:35%;">
                 </div>
                 <div class="form-group">
                   <label for="">Meter Image</label>
                   <input type="file" name="file" class="form-control file-input"  id="file-input" style="padding:2px;">
                 </div>
                 <div class="form-group">
                   <label for="">Meter Connection</label>
                   <select class="form-control" name="meter_id">
                     <?php foreach ($connections as $connection): ?>
                       <option value="<?php echo $connection['id']; ?>"><?php echo $connection['meter_name']; ?></option>
                     <?php endforeach; ?>

                   </select>
                 </div>
                 <div class="form-group">
                   <label for="">Reading</label>
                   <input type="text" class="form-control" name="meter_reading" value="">
                 </div>

                 <div class="form-group">
                   <label for="">Read Date</label>
                   <input type="text" class="form-control picker" name="date_of_reading" value="">
                 </div>

                 <div class="form-group">
                   <label for="">Channel</label>

                     <select class="form-control" name="channel">
                       <?php
                       foreach($channels as $channel)
                       {
                        ?>
                        <option value="<?php echo $channel['id']; ?>" ><?php echo $channel['channel_name']; ?></option>
                        <?php
                      }
                         ?>


                     </select>

                 </div>
                 <div class="form-group">
                   <label for="">Charge Code</label>
                   <select class="form-control" name="charge_code">
                     <?php
                     foreach($charge_codes as $charge_code)
                     {
                      ?>
                      <option value="<?php echo $charge_code['id']; ?>" ><?php echo $charge_code['charge_code']; ?></option>
                      <?php
                    }
                       ?>

                   </select>
                 </div>

               </div>
               <div class="modal-footer justify-content-between">
                 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                 <button type="submit" class="btn btn-primary" name="add_meter_readings" value="save">Save changes</button>
               </div>
             </form>

             </div>
             <!-- /.modal-content -->
           </div>
           <!-- /.modal-dialog -->
         </div>
