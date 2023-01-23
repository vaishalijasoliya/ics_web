<section class="user-details">
  <div class="container">
     <div class="row">
        <!--  row start -->
        <div class="col-sm-12 col-md-12 col-lg-12">
           <div class="formbox-details">
              <form  action="<?php echo base_url('user/client_details'); ?>" id="ud_detail_one" method="POST">
                 <h4>Details</h4><span id="ud_detail_response"></span>
                 <div class="row">
                    <div class="col-sm-6">
                       <div class="form-group">
                          <input class="ud_detail_id" name="userid" value="<?php echo $_SESSION['user_id']; ?>" type="hidden">
                          <label for="">Username</label>
                          <input type="text"  id="ud_detail_username"  name="username"  class="form-control" placeholder="User Name" value="<?php echo $user_details[0]['username']; ?>" />
                       </div>
                    </div>
                    <div class="col-sm-6">
                       <div class="form-group">
                         <label for="">Contact Name</label>
                          <input type="text"  id="ud_detail_contact_name" class="form-control" placeholder="Contact Name" value="<?php echo $user_details[0]['contact_name']; ?>" name="contact_name"  />
                       </div>
                    </div>
                 </div>
                 <div class="row">
                    <div class="col-sm-12">
                       <div class="form-group">
                         <label for="">Address</label>
                          <input type="text" class="form-control address-field" placeholder="Address" name="address" id="ud_detail_address"  value="<?php echo $user_details[0]['address']; ?>" />
                       </div>
                    </div>
                 </div>
                 <div class="row">
                    <div class="col-sm-6">
                       <div class="form-group">
                         <label for="">Email</label>
                          <input type="email"  class="form-control" placeholder="Email" value="<?php echo $user_details[0]['email']; ?>" disabled name="email"  id="ud_detail_email" />
                       </div>
                    </div>
                    <div class="col-sm-6">
                       <div class="form-group">
                         <label for="">Password</label>
                          <input type="password" class="form-control" placeholder="******" value="<?php echo base64_decode($user_details[0]['password']); ?>" name="password" />
                       </div>
                    </div>
                 </div>
                 <div class="row">
                    <div class="col-sm-6">
                       <div class="form-group">
                         <label for="">Phone</label>
                          <input  id="ud_detail_phone" type="tel"  class="form-control" placeholder="Phone Number" value="<?php echo $user_details[0]['contact']; ?>"  name="phone"/>
                       </div>
                    </div>
                    <div class="col-sm-6">
                       <div class="form-group">
                         <label for="">Mobile</label>
                          <input id="ud_detail_mobile" type="tel"  class="form-control" placeholder="Mobile Number" value="<?php echo $user_details[0]['phone']; ?>"  name="mobile"/>
                       </div>
                    </div>
                 </div>
                 <div class="row">
                    <div class="col-sm-12">
                       <div class="form-group">
                          <label class="checkbox-inline">Stock & Domestic<input type="checkbox"  id="stock_domestic" <?php echo ($user_details[0]['stock_supply']==1 ? 'checked' : '');?>  name="stockdomestic"></label>
                       </div>
                    </div>
                 </div>
                 <div class="save-btn">
                    <input class="btn" role="button" type="submit" name="ud_detail_onesubmit" id="ud_detail_onesubmit" value="Edit" >
                 </div>
              </form>
           </div>
        </div>

        <!--  aside from details start -->
     </div>
     <!--  row end -->
     <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
           <div class="table-meters-from">
              <form id="" method="post">
                 <h4>Meter Details</h4><span id="savenewright_response"></span><span id="table_meters_response"></span><span id="permanent_alloc_alert"></span>

              </form>
              <div class="meter-control-btn">
                 <!-- meters control btn start-->
                 <a href="#" class="meter-connections"> Water Right Numbers </a><span id="table_meters_response"></span>

              </div>
              <!-- meters control btn end-->
              <div class="meters-table">
                 <!-- meters table start-->
                 <div class="table-responsive text-nowrap">
                    <table class="table"  id="tbl_meter_connections">
                       <thead>
                         <tr>
                            <th scope="col">Water Right Number</th>
                            <th scope="col">Volume</th>

                         </tr>
                       </thead>
                       <tbody>
                         <?php foreach ($water_rights as $key => $water_right) {
                           // code...
                          ?>
                          <tr>
                            <td><?php echo $water_right['wr_number']; ?></td>
                            <td><?php echo $water_right['wr_volume']; ?></td>
                          </tr>
                        <?php } ?>
                       </tbody>
                    </table>
                 </div>
              </div>
              <div class="meter-control-btn" style="margin-top:20px;">
                 <!-- meters control btn start-->
                 <a href="#" class="meter-connections"> Meter / Connections </a><span id="table_meters_response"></span>
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
                         </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($meter_details as $key => $meter) {
                          // code...
                         ?>
                        <tr>
                          <td><?php echo $meter['serial_number']; ?></td>
                          <td><?php echo $meter['meter_name']; ?></td>
                          <td><?php echo $meter['channel_name']; ?></td>
                          <td><?php echo $meter['property']; ?></td>
                          <td><?php echo $meter['wr_number']; ?></td>
                        </tr>
                        <?php }?>
                      </tbody>
                   </table>
                 </div>
              </div>
              <!-- meters table end-->
           </div>
        </div>
     </div>
  </div>


 <!-- /.modal-end -->

 <!-- /.modal-end -->
 <!-- Modal -->


</section>
