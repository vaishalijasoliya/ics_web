<section class="client-usage-report">
   <div class="container">
      <div class="row">
        
         <div class="client-deatils-form">
            <!-- client-deatils-form start -->
            <div class="row">
               <div class="col-sm-4 col-lg-4">
                  <div class="form-group">
                    <select class="form-control form-control-lg" data-style="btn-info"  name="ud_clientdetail_username" id="ud_username">

                    </select>
                  </div>
               </div>
               <div class="col-sm-4 col-lg-4">
                  <div class="form-group">
                    <input type="text"  id="ud_contactname"  class="form-control" placeholder="Contact Name" value="" readonly />
                  </div>
               </div>

               <div class="col-sm-4 col-lg-4">
                  <div class="form-group">
                    <select class="form-control form-control-lg" data-style="btn-info"  name="" id="ud_metername">
                      <option value="">Water Right Number</option>

                    </select>
                  </div>
               </div>

            </div>
            <div class="row">
               <div class="col-sm-4 col-lg-4">
                  <div class="btn-group">
                    <select class="form-control form-control-lg season_data" data-style="btn-info"  name="ud_season" id="ud_seasons">
                      <option value="0">Seasons</option>
                    </select>
                  </div>
               </div>
               <div class="col-sm-4 col-lg-4">
                  <div class="form-group">
                    <input type="text"  id="ud_fromdate"  class="form-control picker" placeholder="From" value=""  />
                  </div>
               </div>
               <div class="col-sm-4 col-lg-4">
                 <div class="form-group">
                   <input type="text"  id="ud_todate"  class="form-control picker" placeholder="To" value=""  />
                 </div>
               </div>
            </div>
            <div class="row">
              <div class="col-sm-4">
                <div class="input-group">
                  <label class="checkbox-inline"><b>Individual Meter</b></label>
                  <input type="checkbox" style="margin-left:10px;" value="" id="individual_meter">
                </div>
              </div>
                <div class="col-sm-4">
                  <div class="input-group">
                    <label class="checkbox-inline"><b>Highlight OverUsage</b></label>
                    <input type="checkbox" style="margin-left:10px;" value="" id="highlight_usage">
                  </div>
                </div>

                  <div class="col-sm-4">
                    <div class="input-group">
                                    <label class="checkbox-inline"><b>All Meters</b></label>
                                    <input type="checkbox" style="margin-left:10px;" value="" id="all_meters">
                    </div>

                  </div>
            </div>
            <!-- checkbox--container-end-->
            <div class="container">
               <div class="row">
                  <div class="client-deatils-form-checkbox">
                     <div class="col-lg-12 nopadding">
                        <div class="input-group">
                           <!-- <label class="checkbox-inline">Individual meter<input type="checkbox" value=""></label>
                           <label class="checkbox-inline">Highlight Over Use<input type="checkbox" value=""></label> -->
                        </div>
                        <!-- /input-group -->
                     </div>
                     <!-- /.col-lg-6 -->
                     <div class="col-lg-12 nopadding">
                        <div class="input-group">
                           <!-- <label class="checkbox-inline">All Meter Reading<input type="checkbox" value=""></label> -->
                        </div>
                        <!-- /input-group -->
                     </div>
                     <!-- /.col-lg-12 -->
                  </div>
               </div>
               <!-- /.row -->
            </div>
            <!-- checkbox--container-end-->
         </div>
         <div id="exportbtn" style="display:none">
           <a href="#" class="btn btn-lg btn-primary saveCSV" style="float:right;margin-right:20px;">CSV</a>
           <a href="#"onclick="generate()" class="btn btn-lg btn-primary" style="float:right;margin-right:15px;">PDF</a>
         </div>

         <div class="client-usage-btn">
            <!--  btn start-->
            <a href="#" class="usage-report">
            Client Usage Report
            </a>

         </div>
         <!--  control btn end-->
         <div class="client-usage-table" style="margin-bottom:10px;">
            <!-- table start-->
            <!-- <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name"> -->
            <div class="table-responsive text-nowrap">
               <table class="table" id="client_usage" >
                  <thead>
                     <tr>
                        <th scope="col">S No</th>
                        <th scope="col">Water Right No</th>
                        <th scope="col">Serial No</th>
                        <th scope="col">Meter Name</th>
                        <th scope="col">Reading</th>
                        <th scope="col">Usage</th>
                        <th scope="col">Remaining</th>
                        <th scope="col">Allocation</th>
                        <th scope="col">Date Of Reading</th>
                        <th scope="col">Channel</th>
                        <th scope="col">Charge Code</th>
                        <th scope="col">Type</th>
                     </tr>
                   </thead>
                   <tbody>

                   </tbody>
                </table>
             </div>
          </div>
          <!--  table end-->
       </div>
    </div>
 </section>
