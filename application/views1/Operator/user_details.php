<section class="user-details">
  <div class="container">
     <div class="row">
        <!--  row start -->
        <div class="col-sm-12 col-md-8 col-lg-8">
           <div class="formbox-details">
              <form  id="ud_detail_one" method="POST">
                 <h4>Details</h4><span id="ud_detail_response"></span>
                 <div class="row">
                    <div class="col-sm-6">
                       <div class="form-group">
                          <input class="ud_detail_id" name="userid" value="" type="hidden">
                          <label for="">Username</label>
                          <input type="text"  id="ud_detail_username"  name="username"  class="form-control" placeholder="User Name" value="" />
                       </div>
                    </div>
                    <div class="col-sm-6">
                       <div class="form-group">
                         <label for="">Contact Name</label>
                          <input type="text"  id="ud_detail_contact_name" class="form-control" placeholder="Contact Name" value="" name="contact_name"  />
                       </div>
                    </div>
                 </div>
                 <div class="row">
                    <div class="col-sm-12">
                       <div class="form-group">
                         <label for="">Address</label>
                          <input type="text" class="form-control address-field" placeholder="Address" name="address" id="ud_detail_address"  value="" />
                       </div>
                    </div>
                 </div>
                 <div class="row">
                    <div class="col-sm-6">
                       <div class="form-group">
                         <label for="">Email</label>
                          <input type="email"  class="form-control" placeholder="Email" value="" name="email"  id="ud_detail_email" />
                       </div>
                    </div>
                    <div class="col-sm-6">
                       <div class="form-group">
                         <label for="">Password</label>
                          <input type="password" class="form-control" placeholder="******" value="" name="password" />
                       </div>
                    </div>
                 </div>
                 <div class="row">
                    <div class="col-sm-6">
                       <div class="form-group">
                         <label for="">Phone</label>
                          <input  id="ud_detail_phone" type="tel"  class="form-control" placeholder="Phone Number" value=""  name="phone"/>
                       </div>
                    </div>
                    <div class="col-sm-6">
                       <div class="form-group">
                         <label for="">Mobile</label>
                          <input id="ud_detail_mobile" type="tel"  class="form-control" placeholder="Mobile Number" value=""  name="mobile"/>
                       </div>
                    </div>
                 </div>
                 <div class="row">
                    <div class="col-sm-12">
                       <div class="form-group">
                          <label class="checkbox-inline">Stock & Domestic<input type="checkbox"  id="stock_domestic" value="" name="stockdomestic"></label>
                       </div>
                    </div>
                 </div>
                 <div class="save-btn">
                    <input class="btn" role="button" type="submit" id="ud_detail_onesubmit" value="Edit" >
                 </div>
              </form>
           </div>
        </div>
        <div class="col-sm-12 col-md-4 col-lg-4">
           <!--  aside from details start -->
           <div class="formbox-details client-details">
              <h4>Client Details</h4>
              <form id="ud_clientdetail_form" method="POST">
              <div class="form-group">
                <label for="">Username</label>
                 <select class="form-control form-control-lg" data-style="btn-info"  name="ud_clientdetail_username" id="ud_clientdetail_username">
                 </select>
              </div>
              <div class="form-group">
                <label for="">Contact Name</label>
                 <input type="text"  id="ud_clientdetail_contactname"  class="form-control" placeholder="Contact Name" value="" />
              </div>
            </form>
           </div>
           <div class="formbox-details add-new-client">
              <h4>Add New Client</h4><span id="addnewclient_result"></span>
              <form  id="addnew-client-form" method="POST">
              <div class="form-group">
                <label for="">Username</label>
                 <input type="text"  class="form-control" placeholder="Username" value=""  id="newclient_username" name="username" minlength="3" />
              </div>
              <div class="form-group">
                <label for="">Contact Name</label>
                 <input type="text"  class="form-control" placeholder="Contact Name" value=""  id="newclient_contactname" name="contactname" />
              </div>
              <div class="save-btn">
                 <button class="btn" role="button"  name="addnew" type="submit">Save</button>
              </div>
            </form>
           </div>
        </div>
        <!--  aside from details start -->
     </div>
     <!--  row end -->
     <div class="row">
        <div class="col-sm-12 col-md-8 col-lg-8">
           <div class="table-meters-from">
              <form id="" method="post">
                 <h4>Meter Details</h4><span id="savenewright_response"></span><span id="table_meters_response"></span><span id="permanent_alloc_alert"></span>
                 <div class="row">
                    <div class="col-sm-6">
                       <div class="form-group">
                         <label for="">Water Right Number</label>
                          <select class="form-control form-control-lg" data-style="btn-info"  name="water_right_number" id="water_right_number">
                             <option value="">Water Right Number </option>
                          </select>
                       </div>
                    </div>
                    <div class="col-sm-6">
                       <div class="save-btn">
                          <!-- <button class="btn addnew-btn"  id="button_add_water_right" data-toggle="modal" data-target="#new_water_right" disabled >Add New</button> -->
                          <button type="button" class="btn btn-primary"  id="button_add_water_right" data-toggle="modal" data-target="#exampleModalLong" disabled>Add New</button>
                       </div>
                    </div>
                 </div>
              </form>
              <div class="meter-control-btn">
                 <!-- meters control btn start-->
                 <a href="#" class="meter-connections"> Meter / Connections </a><span id="table_meters_response"></span>
                 <button id="button_add_connection" class="btn btn-primary" data-toggle="modal" data-target="#add_meter_connection" style="margin: 1% 3%;float:right" disabled > Add </button>
                 <!-- <a href="#" class="meter-edit">
                 Edit
                 </a> -->
              </div>
              <!-- meters control btn end-->
              <div class="meters-table">
                 <!-- meters table start-->
                 <div class="table-responsive text-nowrap">
                    <table class="table"  id="tbl_meter_connections">
                       <thead>
                          <tr>
                             <th scope="col">Serial No</th>
                             <th scope="col">Name</th>
                             <th scope="col">Channel</th>
                             <th scope="col">Property</th>
                             <th scope="col">Meter type</th>
                             <th scope="col">Action</th>
                          </tr>
                       </thead>
                       <tbody></tbody>
                    </table>
                 </div>
              </div>
              <!-- meters table end-->
           </div>
        </div>
     </div>
  </div>

<!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Water Right</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="addnewright_form" method="POST">

      <div class="modal-body">
        <div class="form-group">
        <label for="">Water Right Number</label>
          <input class="form-control" type="text" name="water_right_number" value="" required>
          <input class="ud_detail_id" name="userid" value="" type="hidden">
        </div>
        <div class="form-group">
          <label for="">Volume Allocation</label>
          <input class="form-control" type="text"  name="volume_alloc" value="">
        </div>
        <div id="savenewright_alert"></div>
       </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </form>
    </div>
  </div>
</div>
  <div class="modal fade" id="new_water_right">
   <div class="modal-dialog modal-dialog-centered">
     <div class="modal-content">
       <!-- <div class="modal-header">
         <h4 class="modal-title"></h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div> -->
       <form id="addnewright_form" method="POST">
         <div class="modal-body">
           <div class="form-group">
           <label for="">Water Right Number</label>
             <input class="form-control" type="text" name="water_right_number" value="" required>
             <input class="ud_detail_id" name="userid" value="" type="hidden">
           </div>
           <div class="form-group">
             <label for="">Volume Allocation</label>
             <input class="form-control" type="text"  name="volume_alloc" value="">
           </div>
           <div id="savenewright_alert"></div>
         </div>
         <div class="modal-footer justify-content-between">
           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
           <button type="submit" class="btn btn-success" id="savenewright">Save</button>
         </div>
       </form>
     </div>
   </div>
 </div>
 <!-- /.modal-end -->
 <div class="modal fade" id="add_meter_connection">
  <div class="modal-dialog">
    <div class="modal-content">

      <form id="meter_connection_form" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
         <div class="image-upload">
              <label for="file-input">
              <img id="image-preview" src="<?php echo base_url(); ?>assets/operators/img/upload-file.png" alt="Browse"  width="317" height="163" style="border-radius:20px;" />
              </label>
              <input id="file-input" type="file" name="file" class="form-control file-data" />
           </div>
        <!-- Browse Image  -->

          <div class="form-group">
            <input class="ud_detail_id" name="userid" value="" type="hidden">
            <label for="">Meter Name</label>
            <input type="text" name="meter_name" class="form-control" placeholder="Meter Name" required>
          </div>
          <div class="form-group">
            <label for="">Serial Number</label>
            <input type="text" name="serial_number" class="form-control" value="" placeholder="Serial Number" required>
          </div>
          <div class="form-group">
            <label for="">Channel Name</label>
            <select class="form-control form-control-lg channel_name" name="channel_name" data-style="btn-info"  >
              <option value="">Channel Name</option>
            </select>
          </div>
          <div class="form-group">
            <label for="">Water right Number</label>
            <select name="water_right_number"  class="form-control form-control-lg" id="water_right_number_user" data-style="btn-info" >
              <option value="">Water Right Number</option>
            </select>
          </div>
          <div class="form-group">
            <label for="">Property</label>
            <input type="text" name="property" class="form-control" placeholder="Property" required>
          </div>
          <div class="form-group">
            <label for="">Meter Type</label>
            <select  name="meter_type"  class="form-control form-control-lg meter_type" data-style="btn-info" >
              <option value="" disabled>Meter Type</option>
            </select>
          </div>
          <div id="meter_connection_alert"></div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success" id="meter_connection">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
 <!-- /.modal-end -->
 <!-- Modal -->
 <div class="modal fade" id="myModal" role="dialog">
   <div class="modal-dialog modal-sm">
     <!-- Modal content-->
     <div class="modal-content">
       <div class="modal-body">
         <p>Are you sure want to <strong> Inactive </strong> this connection.</p>
       </div>
       <input type="hidden" name="delete_meterid" id="delete_meterid" value="">
       <div class="modal-footer">
         <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
         <button type="submit" class="btn btn-danger" onclick="delete_meter_connection()">Yes</button>
       </div>
     </div>

   </div>
 </div>
 <div id="edit-details" class="modal fade" role="dialog">
   <div class="modal-dialog">

     <!-- Modal content-->
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 class="modal-title">Edit Meter Connection</h4>
       </div>
       <div class="modal-body">
         <form class=""  id="edit_meter_connection" method="post" enctype="multipart/form-data">
           <div class="form-group">
             <div class="img-upload">
                  <label for="edit-input">
                  <img id="img-preview" src="<?php echo base_url(); ?>assets/operators/img/upload-file.png" alt="Browse"  width="317" height="163" style="border-radius:20px;" />
                  </label>
                  <input id="edit-input" type="file" name="file" class="form-control editmeter" />
              </div>
           </div>
           <input type="hidden" id="edit_id" name="id" value="">
           <input type="hidden" id="edit_imagename" name="imagename" value="">
           <div class="form-group">
             <label for="">Meter Name</label>
             <input type="text" name="meter_name" placeholder="Meter Name" value="" id="edit_meter_name">
           </div>
           <div class="form-group">
             <label for="">Serial Number</label>
             <input type="text" name="serial_number" placeholder="Serial Number" value="" id="edit_serial_number">
           </div>
           <div class="form-group">
             <label for="">Channel Name</label>
             <select class="form-control form-control-lg channel_name" name="channel_name" data-style="btn-info" id="edit_channel_id" >
               <option value="">Channel Name</option>
             </select>
           </div>
           <div class="form-group">
             <label for="">Water Right Number</label>
             <input type="text" name="water_right_number" class="form-control"  id="edit_wr_number" readonly>
           </div>

           <div class="form-group">
             <label for="">Property</label>
             <input type="text" name="property" class="form-control" placeholder="Property" id="edit_property" required>
           </div>
           <div class="form-group">
             <label for="">Meter Type</label>
             <select  name="meter_type"  class="form-control form-control-lg meter_type" data-style="btn-info" id="edit_type_id">
               <option value="" disabled>Meter Type</option>
             </select>
           </div>
       </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         <button type="submit" class="btn btn-primary" >Edit</button>
       </div>
     </form>

     </div>

   </div>
 </div>
</section>
