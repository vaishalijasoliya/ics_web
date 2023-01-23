<?php
function time_elapsed_string($datetime, $full = false)
{
   $now = new DateTime;
   $ago = new DateTime($datetime);
   $diff = $now->diff($ago);

   $diff->w = floor($diff->d / 7);
   $diff->d -= $diff->w * 7;

   $string = array(
      'y' => 'year',
      'm' => 'month',
      'w' => 'week',
      'd' => 'day',
      'h' => 'hour',
      'i' => 'minute',
      's' => 'second',
   );
   foreach ($string as $k => &$v) {
      if ($diff->$k) {
         $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
      } else {
         unset($string[$k]);
      }
   }

   if (!$full) $string = array_slice($string, 0, 1);
   return $string ? implode(', ', $string) . ' ago' : 'just now';
}
?>
<!-- main section start -->
<section class="system-report" style="margin-top:20px;">
   <div class="container">
      <div class="row">
         <div class="total-report">
            <!-- main content start -->


            <!-- total-report-btn start-->
            <div class="total-report-btn">
               <a href="<?= base_url('User/notification') ?>" class="usage-report">
                  Notification
               </a>
               <a href="<?= base_url('User/notification_archive') ?>" class="usage-report" style="margin-left:5px;">
                  Archive Notification
               </a>
            </div>

            <!-- total-report-btn end-->
            <!--total-report-table start-->

            <div class="total-report-table">

               <!-- meters table start-->
               <div class="table-responsive text-nowrap">
                  <table class="table order-table" id="">
                     <thead>
                        <tr>
                           <td></td>
                           <td>User</td>
                           <td>Title</td>
                           <td>Message</td>
                           <td>Status</td>
                           <td>Time</td>
                           <td>Action</td>
                        </tr>
                     </thead>

                     <tbody>
                        <?php
                        $count = 1;
                        foreach ($notifications as $notify) {
                        ?>
                           <tr>
                              <th scope="row"><img class="round" width="40" height="40" avatar="<?php echo $notify['username']; ?>"></th>

                              <td><?php echo $notify['username']; ?> </td>
                              <td><?php echo $notify['title']; ?></td>
                              <td><?php echo $notify['message']; ?></td>
                              <td>
                                 <?php if ($notify['status'] == 'Pending') { ?><button type="button" class="btn btn-sm btn-default"><?php echo $notify['status']; ?></button><?php } ?>
                                 <?php if ($notify['status'] == 'Approved') { ?><button type="button" class="btn btn-sm btn-success"><?php echo $notify['status']; ?></button><?php } ?>
                                 <?php if ($notify['status'] == 'Denied') { ?><button type="button" class="btn btn-sm btn-danger"><?php echo $notify['status']; ?></button><?php } ?>
                                 <?php if ($notify['status'] == 'Edited') { ?><button type="button" class="btn btn-sm btn-primary"><?php echo $notify['status']; ?></button><?php } ?></td>
                              <td><i class="fa fa-clock-o mx-3" aria-hidden="true"></i> <?php echo time_elapsed_string($notify['date']); ?></td>
                              <td><a href="" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-trash fa-2x text-danger" aria-hidden="true"></i></a> </td>

                              <!-- Modal -->
                              <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                 <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                       <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLabel">Delete Notification</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                             <span aria-hidden="true">&times;</span>
                                          </button>
                                       </div>
                                       <div class="modal-body">
                                          Are you sure you want to delete this notification?
                                       </div>
                                       <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                          <button type="button" class="btn btn-danger">Delete</button>
                                       </div>
                                    </div>
                                 </div>
                              </div>

                           </tr>
                        <?php
                           $count++;
                        } ?>


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
<script src="<?php echo base_url(); ?>assets/operators/js/jquery.min.js"></script>

<script>
   var origin = window.location.origin;
   var siteurl = origin + '/user/update_message_count';

   var request = $.ajax({
      url: siteurl,
      method: "GET",
      dataType: "html"
   });

   request.done(function(msg) {
      console.log(msg)
   })
</script>