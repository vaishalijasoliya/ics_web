
<script>
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	title:{
		text: "Order Next 48 Hrs"
	},
	axisX:{
		title: "Time",
		 intervalType: "hour",
		  valueFormatString: "DD-MM hh tt",

	},
	axisY: {
		title: "Order Ml/Day",
	},
	legend:{
		cursor: "pointer",
		fontSize: 16,
		itemclick: toggleDataSeries
	},
	toolTip:{
		shared: true
	},
	data: [<?php if(!empty($p_graph_value)){
		?>

	{
		name: "Pending Order",
		type: "column",

		showInLegend: true,
		dataPoints: [<?php foreach ($p_graph_value as $key => $value) {
    echo "{x:new Date(".$value['graph']['x']."),y:".$value['graph']['y']."},";
    }  ?>]
	},<?php }?>

	<?php if(!empty($a_graph_value)){
		?>

	{
		name: "Approve Order",
		type: "column",
		color:"grey",
		showInLegend: true,
		dataPoints: [<?php foreach ($a_graph_value as $key => $value) {
    echo "{x:new Date(".$value['graph']['x']."),y:".$value['graph']['y']."},";
    }  ?>]
	}<?php }?>]
});

chart.render();

chart.set("dataPointWidth",Math.ceil(chart.axisX[0].bounds.width/chart.data[0].dataPoints.length),true);
function toggleDataSeries(e){
	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	}
	else{
		e.dataSeries.visible = true;
	}

	chart.render();
}


$('#chartContainer1').hide();

$('#order_status').click(function () {
	var testing = document.getElementById("order_status").value;
	console.log(testing);

	if(testing == 4){
		var name = "Pending Order";
		var color = "lightblue";
	}else if(testing == 2){
		var name = "";
		var color = "gray";
	}
	else{
		var name = "Approve Order";
		var color = "gray";
	}

	var jsonData = {
	  "1": [
			<?php foreach ($a_graph_value as $key => $value) {
	    echo "{x:new Date(".$value['graph']['x']."),y:".$value['graph']['y']."},";
	    }  ?>
	  ],
	  "2": [
			<?php foreach ($c_graph_value as $key => $value) {
	    echo "{x:new Date(".$value['graph']['x']."),y:".$value['graph']['y']."},";
	    }  ?>
	  ],
	  "3": [
			<?php foreach ($a_graph_value as $key => $value) {
	    echo "{x:new Date(".$value['graph']['x']."),y:".$value['graph']['y']."},";
	    }  ?>
	  ],
	  "4": [
			<?php foreach ($p_graph_value as $key => $value) {
	    echo "{x:new Date(".$value['graph']['x']."),y:".$value['graph']['y']."},";
	    }  ?>
	  ]}
		var dataPoints = [];
	var chart = new CanvasJS.Chart("chartContainer1", {
		animationEnabled: true,
		title:{
			text: "Order Next 48 Hrs"
		},
		axisX:{
			title: "Time",
			 intervalType: "hour",
			  valueFormatString: "DD-MM hh tt",

		},
		axisY: {
			title: "Order Ml/Day",
		},
		legend:{
			cursor: "pointer",
			fontSize: 16,
		},
		toolTip:{
			shared: true
		},
	  data: [{
			name: name,
			type: "column",
			color: color,
			showInLegend: true,
	    dataPoints:  dataPoints
			 // this should contain only specific serial number data
	  }]
	});

	chart.options.data[0].dataPoints = [];
	var element = document.getElementById("order_status");

	console.log(element);
	selectDataSeries();


	$( ".dropdown" ).change(function() {
	  chart.options.data[0].dataPoints = [];
	  selectDataSeries(element.selectedIndex);
	});


	function selectDataSeries(){
	  var selected = element.options[element.selectedIndex].value;
	  dps = jsonData[selected];
	  for(var i in dps) {
	    var xVal = dps[i].x;
	    chart.options.data[0].dataPoints.push({x: new Date(xVal), y: dps[i].y});
	  }
	  chart.render();
	}
	chart.set("dataPointWidth",Math.ceil(chart.axisX[0].bounds.width/chart.data[0].dataPoints.length),true);
	$('#chartContainer1').show();
	$('#chartContainer').hide();

});
}
</script>

         <!-- main section start -->
         <section class="water-usage">

					 <div class="container">
							<div class="water-usage-report">
								 <div class="row">
										<!-- row start-->
										<div class="water-usage-form">
											 <div class="col-sm-12" >
													<div class="col-sm-4 col-lg-4">
														 <div class="form-group">
															 <select class="form-control form-control-lg " data-style="btn-info" name="" id="order_status">
																	<option value="3" selected>All Orders</option>
																	<option value="4" >New Orders</option>
																	<option value="1" >Current Orders</option>
																	<option value="2" >Upcoming Orders</option>
																</select>
														 </div>
													 </div>
															<div class="col-sm-4 col-lg-4">


														 <div class="form-group">
															 <select class="form-control form-control-lg channel_name" data-style="btn-info" id="order_channels">
																	<option value="0" selected>Channels</option>
																</select>
														 </div>
													 </div>
															<div class="col-sm-4 col-lg-4">
														 <div class="form-group">
															 <select class="form-control form-control-lg load_client_username" data-style="btn-info" name="pending" id="order_usernames">
																	<option value="All Channels" selected>Username</option>
																</select>
														 </div>
													 </div>
													</div>

											 </div>

											 <div class="col-sm-12 col-lg-12">

												 <div id="chartContainer" style="height: 300px; width: 100% !important;"></div>
												 <div id="chartContainer1" style="height: 300px; width: 100% !important;"></div>
											 </div>

										</div>
								 </div>


								 <div class="row">

										<!-- row start-->
										<div class="water-usage-btn" style="margin-top:5%;">
											 <!-- meters control btn start-->
											 <a href="#" class="usage-report">
											 Live Orders
											 </a>
										</div>
										<!-- meters control btn end-->
										<div class="usage-table">
											 <!-- meters table start-->
											 <div class="table-responsive text-nowrap">
													<table class="table"  id="water_order_system" >
														 <thead>
																<tr>
																	 <th scope="col">Name</th>
																	 <th scope="col">Start Time</th>
																	 <th scope="col">Flow</th>
																	 <th scope="col">Outlet</th>
																	 <th scope="col">Duration</th>
																	 <th scope="col">End Time</th>
																	 <th scope="col">Total Volume</th>
																	 <th scope="col">Status</th>
																	 <th scope="col">Channel</th>
																	 <th scope="col">Actions</th>
																</tr>
														 </thead>
														 <tbody>

<!-- Modal -->
<div class="modal fade" id="edit_order" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
 <div class="modal-dialog" role="document">
	 <div class="modal-content">
		 <div class="modal-header">
			 <h3 class="modal-title" id="exampleModalLabel">Edit Order</h3>
			 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				 <span aria-hidden="true">&times;</span>
			 </button>
		 </div>
		 <form class="" action="<?php echo base_url('Operator/edit_water_orders'); ?>" method="post">

		 <div class="modal-body">
					 <input type="hidden" id="order_id" name="id" value="">
					 <input type="hidden" id="order_userid" name="userid" value="">
					 <div class="form-group">
						 <label for="">User Name</label>
						 <input type="text" id="order_user_name" name="user_name" readonly class="form-control" value="" placeholder="">
					 </div>
					 <div class="form-group" >
						 <label for="">Flow Rate</label>
						 <input type="text" id="order_flow_rate" name="flow_rate" class="form-control" value="" placeholder="ML/Day">
					 </div>

					 <div class="form-group" >
								 <label for="">Start</label>
								 <input type="text"  id="order_startTime" name="start_time" class="form-control picker" placeholder="Start" value="" >
						 </div>
						 <div class="save-btn" >
								<button class="btn order_btn_color" id="end_time_btn"  style="margin-left:5%;" role="button"   type="button">End Time</button>
								<button class="btn" id="duration_btn"  style="margin-left:5%;" role="button"  type="button">Duration</button>
								<button class="btn" id="volume_btn"  style="margin-left:5%;" role="button"  type="button">Volume</button>
						 </div>
						 <div class="form-group">
								<input type="text"  id="order_endTime" name="end_time" class="form-control picker" value="" autocomplete="off"  placeholder="End Time"  />
								<input type="text"  id="order_duration" name="duration" class="form-control time_picker" value="" autocomplete="off" placeholder="Duration" style="display:none;"/>
								<input type="text"  id="order_volume" name="volume" placeholder="Volume" class="form-control" value="" style="display:none;"/>
						 </div>


		 <div class="" >
			 <hr>
			 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			 <button style="margin:5px;" type="submit" class="btn btn-primary">Save Changes</button>
		 </div>

	 </div>
 </form>

 </div>
</div>


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
         <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
