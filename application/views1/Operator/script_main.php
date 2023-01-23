
 <script type="text/javascript">
 function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('#image-preview').attr('src', e.target.result);
      $('#image-preview').hide();
      $('#image-preview').fadeIn(650);
    }
    reader.readAsDataURL(input.files[0]);
  }
}

$("#file-input").change(function() {
  readURL(this);
});

 $("#example1").DataTable();
function myFunction() {
   var input, filter, table, tr, td, i, txtValue;
   input = document.getElementById("myInput");
   filter = input.value.toUpperCase();
  alert(filter)
}
 function callAjax(action, method, data, dataType){
   var origin = window.location.origin;
   var siteurl = origin + '/ICSweb/operator/'+ action;
   var res = $.ajax({
     url: siteurl,
     method: method ? method : "POST",
     data: data ? data : null,
     dataType: dataType ? dataType :"html",
     success: function (data) {},
     async: false,
     error: function (err) {
       console.log(err);
     }
   }).responseText;
   return res;
 }

 function load_meter_connections(){
   var userid = $('.ud_detail_id').val()
   let action = 'load_meter_connections';
   let data = { userid : userid };
   let dataType = "html";
   var response = JSON.parse(callAjax(action, '', data, dataType));
   if(response.status!=false){
     console.log("METER CONNECTION : ", response + " length : " +  response.length)
     var rows = ''
     response.forEach(element => {
       rows+='<tr><td>' + element.id + '</td><td>' + element.meter_name +  '</td><td>' + element.channel_name +  '</td><td>' + element.property +  '</td><td>' + element.meter_type +  '</td><td><a href="#"><img src="http://server1.dayopeters.com/ICSweb/assets/operators/img/delete-icon.png" alt="delete-icon"></a></td></tr>'
     });
     $('#tbl_meter_connections > tbody').html(rows);
     // $('#tbl_meter_connections > tbody:last-child').html(rows);
   }
   else {
     $("#table_meters_response").html('<span class="async_response" style="color:red">'+ response.message +'</span>')
     $('.async_response').delay(2500).fadeOut();
     $('#tbl_meter_connections > tbody').html('<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>');
   }
 }
 function setButtonToEdit(){
   $("#ud_detail_onesubmit").attr({"class":"submit btn btn-warning", "value":"Edit"});
 }

       $('#ud_clientdetail_form select').change(function()  {

               var username = $("#ud_clientdetail_username").val()
               var contact_name = $(".ud_clientdetail_contactname").val()
                     var origin = window.location.origin;
                     var siteurl = origin + '/ICSweb/operator/ud_clientdetail_onchange';
                     var request = $.ajax({
                       url: siteurl,
                       method: "POST",
                       data: { username : username, contact_name : contact_name },
                       dataType: "html"
                     });
                     request.done(function( msg ) {
                        console.log("CLIENT DETAIL : ",msg);
                        if(msg === "") {
                          console.log("reset");
                          $("#ud_detail_one")[0].reset();
                          $(".ud_detail_id").val('');
                          removeWaterRightOptions()
                                      }
                                      else {
                                    var details = JSON.parse(msg);
                                    console.log(details);
                                    details[0].id!="" && $(".ud_detail_id").val(details[0].id);
                                    $("#ud_detail_username").val(details[0].username);
                                    $("#ud_detail_contact_name").val(details[0].contact_name);
                                    $("#ud_clientdetail_contactname").val(details[0].contact_name);
                                    $("#ud_detail_address").val(details[0].address);
                                    $("#ud_detail_email").val(details[0].email);
                                    $("#ud_detail_property").val(details[0].property);
                                    $("#ud_detail_phone").val(details[0].phone);
                                    $("#ud_detail_mobile").val(details[0].contact);
                                    $("#permanent_alloc").val(details[0].allocation_volume);
                                    details[0].stock_supply==='1' ? $("#stock_domestic").attr('checked', true) : $("#stock_domestic").attr('checked', false)
                                    console.log("WATER RIGHTS : ", details[0].water_right_number)
                                      if(details[0].water_right_number===""){
                                        removeWaterRightOptions()
                                      }
                                      else{
                                        setWaterRightNumbers(details[0].id)
                                         $("#button_add_connection").attr({"disabled": false});
                                      }
                                 $("#button_add_water_right").attr({"disabled": false});
                                       load_meter_connections()
                                      }
                                          setButtonToEdit()
              });
              request.fail(function( jqXHR, textStatus ) {
                console.log("email check fail", textStatus);
              });
       });


           function removeWaterRightOptions(){
             $("#water_right_number").html('<option value="">Water Right Number</option>');
           }
           function getWaterRightNumberDetail(r){
             let action = 'load_water_right_detail';
             let data = { userid : r };
             let dataType = "script";
             return callAjax(action, '', data, dataType);
           }
           function setWaterRightNumbers(id){
             var waterdetail = JSON.parse(getWaterRightNumberDetail(id))
             console.log("WATER RIGHT INFO : ", waterdetail)
             // should be for each rights if added (,) separated
             var rightnumber = '';
             waterdetail.forEach(element => {
               rightnumber += '<option value='+element.id+'>'+element.wr_number+'</option>'
             });

             $("#water_right_number").html(rightnumber);
           }
           $('#ud_detail_one input').keyup(function() {
             console.log("ud_detail_one change > ");
             setButtonToSave()
           }).change(function() {
             console.log("ud_detail_one change > ");
             setButtonToSave()
           })
           $('#ud_detail_one textarea').keypress(function() {
             console.log("ud_detail_one change > ");
             setButtonToSave()
           }).change(function() {
             console.log("ud_detail_one change > ");
             setButtonToSave()
           });
           function setButtonToSave(){
             $("#ud_detail_onesubmit").attr({"class":"submit btn btn-success", "value":"Save changes"});
           }
           $("#ud_detail_one").validate({
             rules: {
               email : {
                 required: true,
                 email:true
               },
               username : {
                 required: true,
                 minlength: 3
               },
               phone : {
                 required: true,
                 number:true,
                 minlength: 10
               },
               mobile : {
                 required: true,
                 number: true,
                 minlength: 10
               },
             },
             messages : {
               email : {
                 required: 'Email is required',
                       },
               username : {
                 required: 'Username is required',

               },
               phone : {
                 required: 'Phone Number is required',

               },
               mobile : {
                 required: 'Mobile Number is required',
               },

             },
             submitHandler: function(form) {
               var userid = $(form).find('input[name="userid"]').val()
               var username = $(form).find('input[name="username"]').val()
               var contact_name = $(form).find('input[name="contact_name"]').val()
               var address = $(form).find('input[name="address"]').val()
               var email = $(form).find('input[name="email"]').val()
               var property = $(form).find('input[name="property"]').val()
               var phone = $(form).find('input[name="phone"]').val()
               var mobile = $(form).find('input[name="mobile"]').val()
               var stockdomestic = $(form).find('input[name="stockdomestic"]').is(":checked") ? stockdomestic=1 : stockdomestic=0;

               // console.log("form check", userid +' * '+ username+' * '+ contact_name+' * '+ address+' * '+ email+' * '+ property+' * '+ phone+' * '+ mobile+' * '+ stockdomestic);
               var origin = window.location.origin;
               var siteurl = origin + '/ICSweb/operator/edit_userdetail';
               var request = $.ajax({
                 url: siteurl,
                 method: "POST",
                 data: { userid : userid, username : username, contact_name : contact_name, address : address, email : email, property : property, phone : phone, mobile : mobile, stockdomestic : stockdomestic },
                 dataType: "html"
               });
               request.done(function( msg ) {
                 var result = JSON.parse(msg);
                 if(result.status==true){
                   $("#ud_detail_response").html('<span class="async_response" style="color:green">'+ result.message +'</span>');

                 }
                 else {
                   $("#ud_detail_response").html('<span class="async_response" style="color:red">'+ result.message +'</span>')
                 }
                 $('.async_response').delay(2500).fadeOut();
                 $("#ud_detail_onesubmit").attr({"class":"submit btn btn-warning", "value":"Edit"});
               });
               request.fail(function( jqXHR, textStatus ) {
                 console.log("email check fail", textStatus);
                 $("#ud_detail_response").html('<span class="async_response" style="color:red">'+ textStatus +'</span>')
               });
             }
           });
           /* SAVE WATER RIGHT FOR THE USER */
           $("#savenewright_form").validate({
             rules: {
               water_right_number : {
                 required: true,
                 number: true
               },
             },
             messages : {
               water_right_number : {
                 required: "Please select water right",
                 number: "Please select valid water right"
               },
             },
             submitHandler: function(form) {
               console.log("SUBMIT")
               if($(form).find('input[name="userid"]').val()===''){
                 $("#savenewright_alert").html('<span class="async_response" style="color:red">Please select client</span>')
                 $('.async_response').delay(2500).fadeOut();
               }
               else {
                 $('#new_water_right').modal('toggle');

                 var userid = $(form).find('input[name="userid"]').val()
                 var water_right_number = $(form).find('select[name="water_right_number"]').val()
                 console.log("userid : ", userid + ' water_right_number : '+ water_right_number)

                 let action = 'assign_water_right';
                 let data = { userid : userid, water_right_number : water_right_number};
                 let dataType = "html";
                 var response = JSON.parse(callAjax(action, '', data, dataType));
                 console.log("RESPONSE : ", response)
                 if(response.status==true){
                   $("#savenewright_response").html('<span class="async_response" style="color:green">'+ response.message +'</span>');
                   setWaterRightNumbers(userid)
                   load_meter_connections()
                 }
                 else {
                   $("#savenewright_response").html('<span class="async_response" style="color:red">'+ response.message +'</span>')
                 }
                 $('.async_response').delay(2500).fadeOut();
               //   $("#savenewright_form")[0].reset();

               }
             }
           });
           // NEW METER CONNECTION FORM
           $("#meter_connection_form").validate({
             rules: {
               meter_name : {
                 required: true,
               },
               channel_name : {
                 required: true,
                 number:true
               },
               water_right_number : {
                 required: true,
                 number: true
               },
               property : {
                 required: true,
                 minlength: 4,
               },
               meter_type : {
                 required: true,
                 number:true
               },
             },
             messages : {
                meter_name : {
                 required: "Please enter Meter Name",
               },
               channel_name : {
                 required: "Please enter Channel Name",
                 number: "Please enter valid channel"
               },
               water_right_number : {
                 required: "Please enter Water Right",
                 number: "Please enter valid water right"
               },
               property : {
                 required: "Please enter Property",
               },
               meter_type : {
                 required: "Please enter Meter Type",
                 number: "Please enter valid meter type"
               },
             },
             submitHandler: function(form) {
               if($(form).find('input[name="userid"]').val()===''){
                 $("#meter_connection_alert").html('<span class="async_response" style="color:red">Please select client</span>')
                 $('.async_response').delay(2500).fadeOut();
                 setTimeout(() => {
                   $("#meter_connection_form")[0].reset();
                 }, 2500)
               } else {
                 $('#add_meter_connection').modal('toggle');

                 var userid = $(form).find('input[name="userid"]').val()
                 var meter_name = $(form).find('input[name="meter_name"]').val()
                 var channel_name = $(form).find('select[name="channel_name"]').val()
                 var water_right_number = $(form).find('select[name="water_right_number"]').val()
                 var property = $(form).find('input[name="property"]').val()
                 var meter_type = $(form).find('select[name="meter_type"]').val()

                 console.log("userid : ", userid + ' meter_name : '+ meter_name+ ' channel_name : '+ channel_name+ ' water_right_number : '+ water_right_number+ ' property : '+ property+ ' meter_type : '+ meter_type)

                 let action = 'add_meter_connection';
                 let data = { userid : userid, meter_name : meter_name, channel_name : channel_name, water_right_number : water_right_number, property : property, meter_type : meter_type};
                 let dataType = "html";
                 var response = JSON.parse(callAjax(action, '', data, dataType));
                 console.log("METER CONNECTION : ", response + " type : " + typeof response)

                 if(response.status==true){
                   $("#savenewright_response").html('<span class="async_response" style="color:green">'+ response.message +'</span>');
                   load_meter_connections()
                 }
                 else {
                   $("#savenewright_response").html('<span class="async_response" style="color:red">'+ response.message +'</span>')
                 }
                 $('.async_response').delay(2500).fadeOut();
                 $("#meter_connection_form")[0].reset();
               }
             }
           })

           // NEW METER CONNECTION FORM
           $("#ud_permanent_alloc").validate({
             rules: {
               permanent_alloc : {
                 required: true,
               }
             },
             messages : {
               permanent_alloc : {
                 required: "Please enter Allocation Volume",
               },
             },
             submitHandler: function(form) {
               if($(form).find('input[name="userid"]').val()===''){
                 $("#permanent_alloc_alert").html('<span class="async_response" style="color:red">Please select client</span>')
                 $('.async_response').delay(2500).fadeOut();
                 setTimeout(() => {
                   $("#ud_permanent_alloc")[0].reset();
                 }, 2500)
               }
               else {
                 var userid = $(form).find('input[name="userid"]').val()
                 var permanent_alloc = $(form).find('input[name="permanent_alloc"]').val()

                let action = 'edit_permanent_allocation';
                let data = { userid : userid, permanent_alloc : permanent_alloc};
                let dataType = "html";
                var response = JSON.parse(callAjax(action, '', data, dataType));

                if(response.status==true){
                  $("#permanent_alloc_alert").html('<span class="async_response" style="color:green">'+ response.message +'</span>');
                      }

               }
             }
           })

               load_season_details()

               load_wateruser_details()
               load_channels()
               load_metertypes()
               load_water_rights()
               load_meter_connections()
               function load_wateruser_details(){
                   var origin = window.location.origin;
                   var siteurl = origin + '/ICSweb/operator/load_water_users';
                   var request = $.ajax({
                     url: siteurl,
                     method: "GET",
                     dataType: "html"
                   });
                   request.done(function( msg ) {
                     var users = JSON.parse(msg)
                     var username = '';
                     var contactname = '';
                     var i=0;
                     users.forEach(element => {
                       username += i==0 ? '<option value=""> Username</option><option value='+element.id+'>'+element.username+'</option>' : '<option value='+element.id+'>'+element.username+'</option>'
                       contactname += i==0 ? '<option value=""> select</option><option value='+element.id+'>'+element.contact_name+'</option>' : '<option value='+element.id+'>'+element.contact_name+'</option>'
                       i++;
                     });
                     $("#ud_clientdetail_username").html( username );
                     $("#ud_username").html( username );
                     $("#ud_clientdetail_contactname").html( contactname );
                   });
                   request.fail(function( jqXHR, textStatus ) {
                     console.log("email check fail", textStatus);
                   });
               }
               function load_channels(){
                   var origin = window.location.origin;
                   var siteurl = origin + '/ICSweb/operator/load_channels';
                   var request = $.ajax({
                     url: siteurl,
                     method: "GET",
                     dataType: "html"
                   });
                   request.done(function( msg ) {
                     var data = JSON.parse(msg)
                     var channels = '';
                     data.forEach(element => {
                       channels += '<option value='+element.id+'>'+element.channel_name+'</option>'
                     });
                     $(".channel_name").append( channels );

                   });
                   request.fail(function( jqXHR, textStatus ) {
                     console.log("load_channels check fail", textStatus);
                   });
               }
               function load_metertypes(){
                 var origin = window.location.origin;
                 var siteurl = origin + '/ICSweb/operator/load_metertypes';
                 var request = $.ajax({
                   url: siteurl,
                   method: "GET",
                   dataType: "html"
                 });
                 request.done(function( msg ) {
                   var data = JSON.parse(msg)
                   var metertypes = '';
                   data.forEach(element => {
                     metertypes += '<option value='+element.id+'>'+element.type+'</option>'
                   });
                   $(".meter_type").append( metertypes );
                 });
                 request.fail(function( jqXHR, textStatus ) {
                   console.log("load_metertypes check fail", textStatus);
                 });
               }
               function load_water_rights(){
                 var origin = window.location.origin;
                 var siteurl = origin + '/ICSweb/operator/load_water_rights';
                 var request = $.ajax({
                   url: siteurl,
                   method: "GET",
                   dataType: "html"
                 });
                 request.done(function( msg ) {
                   var data = JSON.parse(msg)
                   var righttypes = '';
                   data.forEach(element => {
                     righttypes += '<option value='+element.id+'>'+element.wr_number+'</option>'
                   });
                   $(".load_water_rights").append( righttypes );
                 });
                 request.fail(function( jqXHR, textStatus ) {
                   console.log("load_water_rights check fail", textStatus);
                 });
               }

               $("#addnew-client-form").validate({
                 rules: {
                   username : {
                     required: true,
                     minlength: 3
                   },
                 },
                 messages : {
                   username: {
                     required: "User Name is mandatory.",
                     minlength: "Please enter minimum 3 character.",
                   },        
                 },
                 submitHandler: function(form) {
                   var username = $(form).find('input[name="username"]').val()
                   var contactname = $(form).find('input[name="contactname"]').val()
                   var origin = window.location.origin;
                   var siteurl = origin + '/ICSweb/operator/add_new_client';
                   var request = $.ajax({
                     url: siteurl,
                     method: "POST",
                     data: { username : username, contactname : contactname },
                     dataType: "html"
                   });
                   request.done(function( msg ) {
                     var result = JSON.parse(msg);
                     if(result.status==true){
                       $("#addnewclient_result").html('<span class="async_response" style="color:green">'+ result.message +'</span>');
                     }
                     else {
                       $("#addnewclient_result").html('<span class="async_response" style="color:red">'+ result.message +'</span>')
                     }
                     $("#addnew-client-form")[0].reset();
                     load_wateruser_details();
                     $('.async_response').delay(2500).fadeOut();
                   });
                   request.fail(function( jqXHR, textStatus ) {
                     console.log("email check fail", textStatus);
                     $("#addnewclient_result").html( textStatus );
                   });
                 }
               });
  $('#newoperator').validate({
    rules: {
      username : {
        required: true,
        minlength: 3
      },
      email : {
        required: true,
        minlength: 3
      },
      password : {
        required: true,
        minlength: 3
      },
    },
    messages : {
      username: {
        required: "User Name is mandatory."
      },
    email : {
      required: "Email is mandatory.",
    },
    password : {
      required: "Password is mandatory.",
    }
  }
  });
  ///////////////////Client details usages
  $('#ud_username').change(function()  {
    var userid = $('#ud_username').val()
    var origin = window.location.origin;
    var siteurl = origin + '/ICSweb/operator/get_contactname';
    var request = $.ajax({
      url: siteurl,
      method: "GET",
      data: { userid : userid },
      dataType: "html"
    });
    request.done(function( msg ) {
       var result = JSON.parse(msg);
       var contactname=result[0].contact_name;
      $('#ud_contactname').val(contactname);
      load_client_usage_report()

    });
  });

  function load_season_details()
  {
    var origin = window.location.origin;
    var siteurl = origin + '/ICSweb/operator/get_seasondata';
    var request = $.ajax({
      url: siteurl,
      method: "GET",
      dataType: "html"
    });
      request.done(function( msg ) {
         var data = JSON.parse(msg)
         var seasontypes = '<option >Time Span</option><option value="0" >Full Year</option>';
         data.forEach(element => {
           seasontypes += '<option value='+element.id+'>'+element.season_name+'</option>'
         });
        $(".season_data").append( seasontypes );
      });
  }

    $('#ud_seasons').change(function()  {
      var seasonid = $('#ud_seasons').val()
     if(seasonid==0)
     {
       $('#ud_fromdate').val('');
       $('#ud_todate').val('');
       load_client_usage_report()

     }
     else{

       var origin = window.location.origin;
        var siteurl = origin + '/ICSweb/operator/get_seasondate';
        var request = $.ajax({
          url: siteurl,
          method: "GET",
          data: { seasonid : seasonid },
          dataType: "html"
        });
        request.done(function( msg ) {
           var result = JSON.parse(msg);
           $('#ud_fromdate').val(result[0]['start_date']);
           $('#ud_todate').val(result[0]['end_date']);
           load_client_usage_report()
        });
     }

    });

    function load_client_usage_report()
    {
      var userid=$('#ud_username').val();
      var fromdate=$('#ud_fromdate').val();
      var todate=$('#ud_todate').val();

      if(fromdate=='')
      {
        var data={ userid : userid };
      }
      else {
        var data={ userid : userid,fromdate : fromdate,todate : todate };

      }
      var origin = window.location.origin;
      var siteurl = origin + '/ICSweb/operator/load_client_usage_report';
      var request = $.ajax({
        url: siteurl,
        method: "POST",
        data: data,
        dataType: "html"
      });
      request.done(function( msg ) {

        var data = JSON.parse(msg)
        var rows = ''
        var count=1;
        data.forEach(element => {
          rows+='<tr><td>' + count + '</td><td>' + element.username +  '</td><td>' + element.wr_number +  '</td><td>' + element.serial_number +  '</td><td>' + element.meter_reading +  '</td><td>' + element.date_of_reading + '</td><td></td><td></td><td></td><td>'+ element.channel_name +'</td><td>'+ element.charge_code +'</td><td>'+ element.type +'</td></tr>';
           count++;
        });
          $('#example > tbody').html(rows);
      });

    }

 </script>
