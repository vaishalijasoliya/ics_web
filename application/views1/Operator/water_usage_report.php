         <!-- main section start -->
         <section class="water-usage">
            <div class="container">
               <div class="water-usage-report">
                  <div class="row">
                     <!-- row start-->
                     <div class="water-usage-form">
                        <div class="col-sm-12">
                           <div class="col-sm-6 col-lg-6">

                              <div class="form-group">
                                <select class="form-control form-control-lg channel_name" data-style="btn-info" name="channel" id="channels">
                                   <option value="All Channels" selected>Channel</option>
                                 </select>
                              </div>
                           </div>
                           <div class="col-sm-6 col-lg-6">
                             <div class="form-group">
                               <select class="form-control form-control-lg season_data" data-style="btn-info" name="ud_season" id="ud_seasons">
                                  <option value="0">Seasons</option>
                                </select>
                             </div>
                           </div>
                        </div>
                        <div class="col-sm-12">
                           <div class="col-sm-6 col-lg-6">
                             <div class="form-group">
                               <input type="text"  id="ud_fromdate"  class="form-control picker" placeholder="From" value="" >
                             </div>
                              <div class="water-usage-checkbox">
                                 <div class="row">
                                    <div class="col-lg-12">
                                       <div class="input-group">
                                         <label class="checkbox-inline"><b>Highlight Over Usage</b><input type="checkbox" value="" id="highlight_usage"></label>
                                       </div>
                                       <!-- /input-group -->
                                    </div>
                                    <!-- /.col-lg-6 -->
                                 </div>
                                 <!-- /.row -->
                                 <input type="checkbox" value="" id="all_meter" hidden>

                              </div>
                           </div>
                           <div class="col-sm-6 col-lg-6">
                             <div class="form-group">
                               <input type="text"  id="ud_todate"  class="form-control picker" placeholder="To" value=""  />
                             </div>
                              <div class="water-usage-checkbox">
                                 <div class="row">
                                    <div class="col-lg-12">
                                       <div class="input-group">
                                       </div>
                                    </div>
                                 </div>
                                 <!-- /.row -->
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                         <div id="exportbtn" style="display:none">
                    <a href="#" class="btn btn-lg btn-primary saveAsExcel" style="float:right;margin-right:5px;">CSV</a>
                    <a href="#"onclick="generatePDF()" class="btn btn-lg btn-primary" style="float:right;margin-right:15px;">PDF</a>
                   </div>
                     <!-- row start-->
                     <div class="water-usage-btn">
                        <!-- meters control btn start-->
                        <a href="#" class="usage-report">
                        Usage Report
                        </a>

                     </div>
                     <!-- meters control btn end-->
                     <div class="usage-table">
                        <!-- meters table start-->
                        <div class="table-responsive text-nowrap">
                           <table class="table"  id="water_usage_data" >
                              <thead>
                                 <tr>
                                    <th scope="col">Username</th>
                                    <th scope="col">Contact Name</th>
                                    <th scope="col">Water Right No</th>
                                    <th scope="col">Total Usage</th>
                                    <th scope="col">Remaining</th>
                                    <th scope="col">Allocation</th>
                                    <th scope="col">Channel</th>
                                 </tr>
                              </thead>
                              <tbody>

                              </tbody>
                           </table>
                        </div>
                     </div>
                     <!-- meters table end-->
                  </div>
                  <!-- row end-->
               </div>
            </div>
            <!-- container end-->
         </section>
         <!-- main section end -->
