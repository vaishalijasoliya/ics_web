
         <!-- main section start -->
         <section class="system-report" style="margin-top:20px;">
            <div class="container">
               <div class="row">

                   <div class="total-report">
                     <!-- main content start -->
                   
                     <!-- total-report-btn start-->
                     <div class="total-report-btn">
                        <a href="<?= base_url('User/history_orders')?>" class="usage-report">
                        Orders History
                        </a>
                        <a href="<?= base_url('User/archive_history_orders')?>" class="usage-report"  style="margin-left:5px;">
                        Orders Archive
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
                                    <th scope="col">S No.</th>
                                    <th scope="col">Meter Name</th>
                                    <th scope="col">Start Time</th>
                                    <th scope="col">Flow Rate</th>
                                    <th scope="col">End Date</th>
                                    <th scope="col">Duration</th>
                                    <th scope="col">Volume</th>
                                    <th scope="col">Status</th>                               
                                 </tr>
                              </thead>
                              <tbody>
                                  <?php
                                  $count=1;
                                  foreach($water_orders as $orders)
                                  {
                                  ?>
                                 <tr>
                                    <th scope="row"><?php echo $count; ?></th>
                                    <td><?php echo $orders['meter_name']; ?></td>
                                    <td><?php echo $orders['startTime']; ?></td>
                                    <td><?php echo $orders['flowRate']; ?></td>
                                    <td><?php echo $orders['endTime']; ?></td>
                                    <td><?php echo $orders['duration']; ?></td>
                                    <td><?php echo $orders['totalVolume']; ?></td>
                                    <td><?php if($orders['isActive']==2){
                                       echo '<button type="button" class="btn btn-sm btn-danger">Deny</button>';

                                    } if($orders['isActive']==1){
                                       echo '<button type="button" class="btn btn-sm btn-success">Approved</button>';

                                    }
                                    if($orders['isActive']==0)
                                    {
                                       echo '<button type="button" class="btn btn-sm btn-default">Pending</button>';
                                    }  ?></td>
                                 </tr>
                                 <?php
                                 $count++;
                                  }
                                 ?>  
                              </tbody>
                           </table>
                        </div>
                     </div>
                     <!--total-report-table end-->
                  </div>
                  <!-- main content end-->
               </div>
            </div>
         </section>
         <!-- main section end -->
