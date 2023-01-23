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
<style>
   .active_a {
      color: #000 !important;
      border: 1px solid #000 !important;
      border-bottom: 2px solid #efefef !important;
      border-bottom-right-radius: 0 !important;
      border-bottom-left-radius: 0 !important;
      outline: none !important;
   }

   .active_b {
      border: 1px solid !important;
      border-bottom: none !important;
      border-left: none !important;
      border-right: none !important;
      border-bottom-right-radius: 0 !important;
      border-bottom-left-radius: 0 !important;
      border-color: #333 !important;
      outline: none !important;
   }
</style>
<!-- main section start -->
<section class="system-report" style="margin-top:20px;">
   <div class="container">
      <div class="row">
         <div class="total-report">
            <!-- main content start -->

            <!-- total-report-btn start-->
            <div class="total-report-btn">

               <a href="<?= base_url('Operator/notification') ?>" class="usage-report active_a" id="home-tab">
                  Notification
               </a>

               <a href="<?= base_url('Operator/notification_archive') ?>" class="usage-report" id="profile-tab" style="margin-left:5px;">
                  Archive Notification
               </a>

            </div>
            <!-- total-report-btn end-->

            <!--total-report-table start-->
            <div class="total-report-table">
               <!-- meters table start-->
               <div class="table-responsive text-nowrap active_b" class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
                  <table class="table" id="">
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
                        foreach ($notifications as $notify) {
                        ?>
                           <tr>
                              <th scope="row"><img class="round" width="40" height="40" avatar="<?php echo $notify['username']; ?>"></th>
                              <td><?php echo $notify['username']; ?> </td>
                              <td><?php echo $notify['title']; ?></td>
                              <td><?php echo $notify['message']; ?></td>
                              <td><?php if ($notify['status'] == 'Pending') { ?>
                                    <button type="button" class="btn btn-sm btn-default"><?php echo $notify['status']; ?></button>
                                 <?php } ?>
                              </td>
                              <td><i class="fa fa-clock-o mx-3" aria-hidden="true"></i> <?php echo time_elapsed_string($notify['date']); ?></td>
                              <td><a href="#"><i class="fa fa-trash fa-2x text-danger" aria-hidden="true"></i></a> </td>
                           </tr>
                        <?php
                        }
                        if (empty($notifications)) {
                        ?>
                           <tr>
                              <td></td>                     
                              <td colspan="6">No Records Found</td>
                           </tr>
                           
                        <?php }
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
<script src="<?php echo base_url(); ?>assets/operators/js/jquery.min.js"></script>

<script>
   var origin = window.location.origin;
   var siteurl = origin + '/operator/update_message_count';

   var request = $.ajax({
      url: siteurl,
      method: "GET",
      dataType: "html"
   });

   request.done(function(msg) {
      console.log(msg)
   })

   $(document).ready(function() {

      $('#home-tab').click(function(e) {
         e.preventDefault();
         $("#home-tab").addClass("active_a");
         $("#home").addClass("active_b");
      });

   });
</script>
<!-- main section end -->