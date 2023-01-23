<section class="user-details" style="margin-left:30%;">
  <div class="container">

     <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-6">

           <!--  aside from details start -->
           <div class="formbox-details client-details">
              <h4>Add Water Order</h4>
              <form action="<?php echo base_url('user/add_water_right') ?>" method="POST" id="water_order_form">
              <div class="form-group" style="margin-top:10%;">
                <label for="">Meter Name</label>
                 <select class="form-control form-control-lg" data-style="btn-info"  name="meter_name" id="">
                  <option value="">Meter Name</option>
                <?php
                 foreach($meter_names as $data)
                 {
                ?>
                   <option value="<?php echo $data['id']; ?>"><?php echo $data['meter_name']; ?></option>
                <?php
                 }
                ?>              </select>
              </div>
              <div class="form-group">
                <label for="">Start Date</label>
                 <input type="text" name="start_date" id="start_date" autocomplete="off" class="form-control picker" value="" />
              </div>

              <div class="form-group">
                <label for="">Flow Rate</label>
                 <input type="text" autocomplete="off"  name="flow_rate"  id="flow_rate"  class="form-control" value="" />
              </div>
              <div class="save-btn" >
                 <button class="btn order_btn_color" id="end_time_btn"  style="margin-left:5%;" role="button"   type="button">End Time</button>
                 <button class="btn" id="duration_btn"  style="margin-left:5%;" role="button"  type="button">Duration</button>
                 <button class="btn" id="volume_btn"  style="margin-left:5%;" role="button"  type="button">Volume</button>
              </div>

              <div class="form-group">
                 <input type="text" name="end_date"  id="end_time" class="form-control picker" value="" autocomplete="off"  placeholder="End Time"  />
                 <input type="text" name="duration"  id="duration" class="form-control " value="" autocomplete="off" placeholder="Duration" style="display:none;"/>
                 <input type="text" name="volume"  id="volume"  placeholder="Volume" class="form-control" value="" style="display:none;"/>
              </div>

   <input type="hidden"  name="end_date" id="end_date_data">
   <input type="hidden" name="duration" id="duration_data">
   <input type="hidden" name="volume" id="volume_data">

              <div class="save-btn" >
                 <button class="btn"  role="button" name="save_order" value="save"  type="submit">Save</button>

              </div>

              <div id="add_calculation">

           </div>


            </form>
           </div>


        </div>
        <!--  aside from details start -->
     </div>
     <!--  row end -->
     <div class="row">
        <div class="col-sm-12 col-md-8 col-lg-8">

        </div>
     </div>
  </div>


 </div>
</section>
