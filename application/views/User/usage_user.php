
         <!--   main section start  -->
         <section class="historical-meters-entries">

            <div class="container">

              <div class="row">
              <div class="col-md-6">

              <form action="<?php echo base_url('user/usage') ?>" method="POST" id="water_order_form">
              <div class="form-group" style="margin-top:10%;">
              <label for="">Meter Name</label>
              <select class="form-control form-control-lg" id="show" onchange="this.form.submit()" data-style="btn-info"  name="meter_name">
              <option value="">Meter Name</option>
              <?php
              foreach($meter_name as $data)
              {
              ?>
              <option value="<?php echo $data['id']; ?>" <?php if(isset($_POST['meter_name']) && $_POST['meter_name'] == $data['id']) echo 'selected="selected"' ?>><?php echo $data['meter_name']; ?></option>
              <?php
              }
              ?>
              </select>
              </div>
              </form>

              </div>
              </div>

           <div class="container-fluid">

  <div class="row">

    <div class="total-report">
      <!-- main content start -->

      <!-- total-report-btn start-->
      <div class="total-report-btn">
         <a href="#" class="usage-report">
         Details
         </a>

      </div>
      <!-- total-report-btn end-->
      <!--total-report-table start-->
      <div class="total-report-table">
         <!-- meters table start-->
         <div class="table-responsive text-nowrap">
            <table class="table">
               <thead>
                  <tr>
                  <th scope='col'><b>Meter Name</b></th>
                  <th scope='col'><b>Serial Number</b></th>
                  <th scope='col'><b>Channel Name</b></th>
                  <th scope='col'><b>Meter Type</b></th>
                  <th scope='col'><b>Property</b></th>
                  <th scope='col'><b>Water Right</b></th>
                  <th scope='col'><b>Water Right Number</b></th>
                  <th scope='col'><b>Water Right Volume</b></th>
                  <th scope='col'><b>Usage</b></th>
                  <th scope='col'><b>Flow Rate</b></th>
                  </tr>
               </thead>
               <tbody>
                   <?php
                   foreach($usage as $value)
                   {
                     $class="";
                     if($value['flow_rate'] > 0){
                       $class="green";
                     }
                     $reading = $value['telementry'] == 1?$value['reading']:$value['meter_reading'];
                     //print_r($value);
                   ?>
                  <tr class="<?php echo $class; ?>">
                  <td><?php echo $value['meter_name']; ?></td>
                  <td><?php echo $value['serial_number']; ?></td>
                  <td><?php echo $value['channel_name']; ?></td>
                  <td><?php echo $value['meter_type']; ?></td>
                  <td><?php echo $value['property']; ?></td>
                  <td><?php echo $value['water_right']; ?></td>
                  <td><?php echo $value['wr_number']; ?></td>
                  <td><?php echo $value['wr_volume']; ?></td>
                  
                  <td><?php echo $reading; ?></td>
                  <td><?php echo $value['flow_rate']; ?></td>
                  </tr>
                  <?php
                   }
                  ?>

               </tbody>
            </table>
         </div>
      </div>
      <!--total-report-table end-->
    </div>

    <div class="col-sm-6" >
      <!-- <h3>Details</h3>
      <div class="m-3">

            <p><b>Property Name :</b><span id="property"></span></p>
            <p> <b>Allocation :</b>&nbsp&nbsp<span id="allocation"></span></p>
            <p><b>Permanent :</b><span id="permanent"></span></p>
      </div>

    </div>
    <div class="col-sm-6" style="margin-top:25px;">
      <h3></h3>
      <div >
        <p><b>Usage :</b> <span id="usage"></span> </p>
        <p> <b>Remaining :</b><span id="remaining"></span></p>
        <p><b>Temporary :</b><span id="temporary"></span></p>
      </div>
    </div> -->

  </div>
</div>
 <div class="row">
      <div class="all-entries">



                  </div>
               </div>
            </div>
         </section>

         <script>
$(document).ready(function(){
  $("#hide").click(function(){
    $(".total-report").hide();
  });
  $("#show").click(function(){
    $(".total-report").show();
  });
});
</script>

         <!-- add meter reading -->
