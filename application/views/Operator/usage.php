
         <!--   main section start  -->
         <section class="historical-meters-entries">

            <div class="container">

           <div class="container-fluid">

  <div class="row">
    <div class="col-sm-4" >
      <h3>Details</h3>
      <div class="m-3">

            <p><b>Property Name :</b><span id="property"></span></p>
            <p> <b>Allocation :</b>&nbsp&nbsp<span id="allocation"></span></p>
            <p><b>Permanent :</b><span id="permanent"></span></p>
      </div>
      <input type="checkbox"  id="show_all" value="0" style="margin-top:50px;">&nbsp<span id="show">Show Inactive Connections<span>

    </div>
    <div class="col-sm-4" style="margin-top:25px;">
      <h3></h3>
      <div >
        <p><b>Usage :</b> <span id="usage"></span> </p>
        <p> <b>Remaining :</b><span id="remaining"></span></p>
        <p><b>Temporary :</b><span id="temporary"></span></p>
      </div>
    </div>
    <div class="col-sm-4">
      <h3 class="pull-right">Clients</h3>
      <div class="form-group">
        <select class="form-control form-control-lg load_client_username" data-style="btn-info"  name="ud_clientdetail_username" id="history_username">
           <option value="">Username </option>
        </select>
      </div>
      <div class="form-group">
         <input type="text"  id="h_contactname"  class="form-control" placeholder="Contact Name" value="" readonly />
      </div>
      <div class="form-group">
        <select class="form-control form-control-lg water_right_number_user" data-style="btn-info" id="h_waterright">
           <option value="">Water Right Number </option>
        </select>
      </div>
    </div>
  </div>
</div>
 <div class="row">
      <div class="all-entries">
                    <div class="save-btn">
                       <button class="btn addnew-btn"  data-toggle="modal" data-target="#add-meter" style="float:right;margin-right: 10px;" >Add New</button>
                    </div>
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
                                    <th scope="col">Remaining</th>
                                    <th scope="col">Channel</th>
                                    <th scope="col">Charge Code</th>
                                    <th scope="col">Meter type</th>
                                    <th scope="col">Action</th>
                                 </tr>
                              </thead>
                              <tbody>

                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- Modal Update-->
         <div class="modal fade" id="edit-meter">
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

                 <input type="hidden" name="imagename" id="imagename" value="">
                 <input type="hidden" name="userid" id="edit_userid" value="">

                 <div class="image-upload">
                      <label for="file-input">
                      <img id="image-preview" src="<?php echo base_url(); ?>assets/operators/img/upload-file.png" alt="Browse"  width="317" height="163" style="border-radius:20px;" />
                      </label>
                      <input id="file-input" type="file" name="file" class="form-control file-data" />
                  </div>
                 <div class="form-group">
                   <input type="hidden" name="meter_id" id="meter_id" value="">
                   <label for="">Meter Name</label>
                   <input type="text" class="form-control" id="meter_name" name="meter_name" value="" readonly>
                 </div>
                 <div class="form-group">
                   <label for="">Serial Numver</label>
                   <input type="text" class="form-control" id="serial_number" name="serial_number" value="" readonly>
                 </div>
                 <div class="form-group">
                   <label for="">Reading</label>
                   <input type="text" class="form-control" name="meter_reading" id="meter_reading" value="" >
                 </div>

                 <div class="form-group">
                   <label for="">Read Date</label>
                   <input type="text" class="form-control picker" name="date_of_reading" id="date_of_reading" value="">
                 </div>

                 <div class="form-group">
                   <label for="">Channel</label>

                     <select class="form-control" name="channel" id="channel" disabled>
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
                   <select class="form-control" name="charge_code" id="charge_code">
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

                 <div class="form-group">
                   <label for="">Meter Type</label>

                     <select class="form-control" name="meter_type" disabled id="type">
                       <option value="">Select Meter Type</option>
                       <?php
                       foreach($metertype as $type)
                       {
                        ?>
                        <option value="<?php echo $type['id']; ?>" ><?php echo $type['type']; ?></option>
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
         <!-- add meter reading -->
         <div class="modal fade" id="add-meter">
           <div class="modal-dialog">
             <div class="modal-content">
               <div class="modal-header">
                 <h4 class="modal-title">Add Meter Reading</h4>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
                 </button>
               </div>
               <form id="addmeterdata" action="<?php echo base_url('operator/usage'); ?>" method="post" enctype="multipart/form-data">

               <div class="modal-body">

                 <div class="img-upload">
                      <label for="edit-input">
                      <img id="img-preview" src="<?php echo base_url(); ?>assets/operators/img/upload-file.png" alt="Browse"  width="317" height="163" style="border-radius:20px;" />
                      </label>
                      <input id="edit-input" type="file" name="file" class="form-control editmeter" />
                  </div>

                 <div class="form-group">
                   <label for="">Meter Connection</label>
                   <select class="form-control" name="meter_id" id="meter_name_usage">

                   </select>
                 </div>
                 <div class="form-group">
                   <label for="">Serial Number</label>
                   <select class="form-control" id="serial_number_usage">

                   </select>
                 </div>
                 <div class="form-group">
                   <label for="">Reading</label>
                   <input type="text" id="meter_reading_usage" class="form-control" name="meter_reading" value="" autocomplete="off">
                 </div>
                 <span id="msg_usage"></span>
                 <div class="form-group">
                   <label for="">Read Date</label>
                   <input type="text" class="form-control picker" name="date_of_reading" value="" autocomplete="off">
                 </div>

               <div class="form-group">
                   <label for="">Charge Code</label>
                   <select class="form-control" name="charge_code">
                     <option value="">Select Charge Code</option>
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
                 <button type="submit" class="btn btn-primary" id="add_meter_usage" name="add_meter_readings" value="save">Save changes</button>
               </div>
             </form>

             </div>
             <!-- /.modal-content -->
           </div>
           <!-- /.modal-dialog -->
         </div>
