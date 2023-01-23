<section class="system-report-transfer">
   <div class="container">
      <!-- execution upper form start -->
        <form id="transfer_form" action="<?php echo base_url('operator/transfers'); ?>" method="post">
          <div class="row">

         <div class="col-sm-12 col-md-8 col-lg-8 nopadding">
            <div class="head-execution">
               <h3>From</h3>
            </div>
            <div class="execution-from">
               <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                       <input class="" name="userid" value="" type="hidden">
                       <label for="">Username</label>
                       <select class="form-control form-control-lg" data-style="btn-info"  name="tr_username_1" id="tr_username">
                       </select>  </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                       <input class="" name="userid" value="" type="hidden">
                       <label for="">Contact Name</label>
                       <input type="text"  id="tr_contactname"  name="contact_name" style="font-size: 1.5rem !important;" class="form-control" placeholder="Contact Name" value="" />
                    </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="">Water Right Number</label>
                       <select class="form-control form-control-lg" data-style="btn-info"   name="tr_water_right_1" id="tr_metername">
                         <option selected value="">Water Right Number</option>
                       </select>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="">Duration</label>
                       <select class="form-control form-control-lg" data-style="btn-info"  name="tr_duration" id="tr_duration">
                         <option selected value="">Select Duartion</option>
                         <option value="1">Temporary</option>
                         <option value="2">Permanent</option>
                       </select>
                    </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                       <input class="" name="userid" value="" type="hidden">
                       <label for="">Volume Allocation</label>
                       <input type="text"  id="tr_volume"  name="tr_volume"  class="form-control" placeholder="Volume Allocation" value="" />
                    </div>
                  </div>
                  <div class="col-sm-6" >
                    <div class="form-group" id="temporary_check"  style="display:none;" >
                       <label for="">Seasons</label>
                       <select class="form-control form-control-lg season_data mygroup" data-style="btn-info"  name="tr_season" id="tr_seasons">

                       </select>  </div>
                  </div>
               </div>
               <div class="permanent_check" style="display:none;">
                 <input class="mygroup" type="checkbox" id="tr_permanent_check" name="tr_permanent_check" value="1"><span style="margin:10px;">Transfer entire Water Right</span>

               </div>

            </div>
         </div>
      </div>
      <!-- execution upper form end -->
      <!-- execution btn start -->
      <div class="row">

         <div class="col-sm-12">
            <div class="save-btn" style="margin-left:45%;margin-top:10px;">
               <!-- <button class="btn addnew-btn"  id="button_add_water_right" data-toggle="modal" data-target="#new_water_right" disabled >Add New</button> -->
               <button type="button" class="btn btn-primary"  id="button_execute" data-toggle="modal" data-target="#exampleModalLong" ><img src="<?php echo base_url(); ?>assets/operators/img/execute-btn.png" alt="execute-btn" width="25px" />Execute</button>
            </div>
         </div>
      </div>

<!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Are you Sure?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      Are you sure you want to transfer volume?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" id="add_transfer" name="add_transfer" value="transfer" class="btn btn-primary">Transfer</button>
      </div>
    </div>
  </div>
</div>
      <!-- execution btn end-->
      <!-- execution bottom form start -->
      <div class="row">
         <div class="col-md-offset-2 col-md-10 nopadding">
            <div class="bottom-execution">
               <h3>To</h3>
            </div>
            <div class="execution-to">
               <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                       <label for="">Username</label>
                       <select class="form-control form-control-lg" data-style="btn-info"  name="tr_username_2" id="tr_clientdetail_username">
                       </select>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                       <input class="" name="userid" value="" type="hidden">
                       <label for="">Contact Name</label>
                       <input type="text"  id="tr_clientdetail_contactname" style="font-size: 1.5rem !important;" class="form-control" placeholder="User Name" value="" />
                    </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="">Water Right Number</label>
                       <select class="form-control form-control-lg" data-style="btn-info"  name="tr_water_right_2" id="tr_meternames">
                         <option selected value="">Water Right Number</option>
                       </select>
                    </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
    </form>
      <!-- execution bottom form end -->
   </div>
</section>
<!-- end main section -->
