<script type="text/javascript">

$(window).load(function() {
    setTimeout(function() {
        $('.gone').fadeOut()
    }, 5000);
});

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

$(".file-data").change(function() {
    readURL(this);
});

function readImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#add-preview').attr('src', e.target.result);
            $('#add-preview').hide();
            $('#add-preview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$(".add-meter").change(function() {
    readImage(this);
});

function changeImage(input)
{
  if (input.files && input.files[0]) {
   var reader = new FileReader();
   reader.onload = function(e) {

         $('#img-preview').attr('src', e.target.result);
         $('#img-preview').hide();
         $('#img-preview').fadeIn(650);
   }
   reader.readAsDataURL(input.files[0]);



  }
}

$(".editmeter").change(function() {
    changeImage(this);
});

$("#example1").DataTable();

function myFunction() {

    table = document.getElementById("example");
    tr = table.getElementsByTagName("tr");
}

function callAjax(action, method, data, dataType) {
    var origin = window.location.origin;
    var siteurl = origin + '/operator/' + action;
    var res = $.ajax({
        url: siteurl,
        method: method ? method : "POST",
        data: data ? data : null,
        dataType: dataType ? dataType : "html",
        success: function(data) {},
        async: false,
        error: function(err) {
            console.log(err);
        }
    }).responseText;
    return res;
}

function load_meter_connections() {
    var userid = $('.ud_detail_id').val()
    let action = 'load_meter_connections';

    var water_right=$('#water_right_number').val()

    let data = {
        userid: userid,
        water_right:water_right,
    };
    let dataType = "html";
    var response = JSON.parse(callAjax(action, '', data, dataType));
    if (response.status != false) {

        var rows = ''
        response.forEach(element => {
            rows += '<tr><td>' + element.serial_number + '</td><td>' + element.meter_name + '</td><td>' + element.channel_name + '</td><td>' + element.property + '</td><td>' + element.meter_type + '</td><td> <a href="#"  data-toggle="modal" data-target="#edit-details" data-id="' + element.id + '" data-image="' + element.image + '"  data-wr_number="' + element.wr_number + '" data-meter_name="' + element.meter_name + '" data-serial_number="' + element.serial_number + '" data-property="' + element.property + '" data-channel_id="' + element.channel_id + '"  data-type_id="' + element.type_id + '" ><img src="https://portal.intelligentcanalsystems.com/assets/operators/img/edit-meter.png" alt="meter"></a> <a href="#"  data-toggle="modal" data-target="#myModal" data-id="' + element.id + '" data-name="' + element.meter_name + '"><img src="https://portal.intelligentcanalsystems.com/assets/operators/img/delete-icon.png" alt="delete-icon"></a></td></tr>'
        });
        $('#tbl_meter_connections > tbody').html(rows);
        // $('#tbl_meter_connections > tbody:last-child').html(rows);
    } else {
        $("#table_meters_response").html('<span class="async_response" style="color:red">' + response.message + '</span>')
        $('.async_response').delay(2500).fadeOut();
        $('#tbl_meter_connections > tbody').html('<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>');
    }
}

function setButtonToEdit() {
    $("#ud_detail_onesubmit").attr({
        "class": "submit btn btn-warning",
        "value": "Edit"
    });
}
$('#show_all').change(function() {
  if ($('#show_all').is(':checked'))
  {
    // document.getElementById("show").innerHTML = "Hide Inactive Connections(Unchecked)";

    $("#show_all").val(1)
     load_usage_history()
  }
  else {
    document.getElementById("show").innerHTML = "Show Inactive Connections";
    $("#show_all").val('')

     load_usage_history()
  }

});
$('#history_username').change(function() {
    var userid = $("#history_username").val()
    var origin = window.location.origin;
    var siteurl = origin + '/operator/get_contactname';
    var request = $.ajax({
        url: siteurl,
        method: "GET",
        data: {
            userid: userid
        },
        dataType: "html"
    });
    request.done(function(msg) {
        var result = JSON.parse(msg);
        var contactname = result[0].contact_name;
        $('#h_contactname').val(contactname);
        getWaterRightNumbers(userid)
        load_usage_history()
        get_meterconnection()
        get_serialnumber()

    })


})

$('#tr_volume').keyup(function() {

    var tr_volume = $("#tr_volume").val()
    var waterid = $("#tr_metername").val()

    var origin = window.location.origin;
    var siteurl = origin + '/operator/get_volumeallocation';
    var request = $.ajax({
        url: siteurl,
        method: "GET",
        data: {
            waterid: waterid
        },
        dataType: "html"
    });
    request.done(function(msg) {
        var result = JSON.parse(msg);

        var vol=result[0]['wr_volume']

       if(tr_volume>vol)
       {
         $('#button_execute').prop("disabled", true);
               // alert('Volume should be less or equal to ')
       }
       else{
         $('#button_execute').prop("disabled", false);

       }

    })


})


$('#tr_username').change(function() {
  $("#tr_volume").val('')
  $("#tr_metername").val('')
    var userid = $("#tr_username").val()
    var origin = window.location.origin;
    var siteurl = origin + '/operator/get_contactname';
    var request = $.ajax({
        url: siteurl,
        method: "GET",
        data: {
            userid: userid
        },
        dataType: "html"
    });
    request.done(function(msg) {
        var result = JSON.parse(msg);
        var contactname = result[0].contact_name;
        $('#tr_contactname').val(contactname);

    })


})

$('#tr_clientdetail_username').change(function() {
    var userid = $("#tr_clientdetail_username").val()
    var origin = window.location.origin;
    var siteurl = origin + '/operator/get_contactname';
    var request = $.ajax({
        url: siteurl,
        method: "GET",
        data: {
            userid: userid
        },
        dataType: "html"
    });
    request.done(function(msg) {
        var result = JSON.parse(msg);
        var contactname = result[0].contact_name;
        $('#tr_clientdetail_contactname').val(contactname);

    })


})

$('#history_username').change(function() {
    var userid = $("#history_username").val()
    var origin = window.location.origin;
    var siteurl = origin + '/operator/get_contactname';
    var request = $.ajax({
        url: siteurl,
        method: "GET",
        data: {
            userid: userid
        },
        dataType: "html"
    });
    request.done(function(msg) {
        var result = JSON.parse(msg);
        var contactname = result[0].contact_name;
        $('#h_contactname').val(contactname);

    })


})

$('#ud_clientdetail_form select').change(function() {

    var username = $("#ud_clientdetail_username").val()
    var contact_name = $(".ud_clientdetail_contactname").val()
    var origin = window.location.origin;
    var siteurl = origin + '/operator/ud_clientdetail_onchange';
    var request = $.ajax({
        url: siteurl,
        method: "POST",
        data: {
            username: username,
            contact_name: contact_name
        },
        dataType: "html"
    });
    request.done(function(msg) {
        if (msg === "") {
            $("#ud_detail_one")[0].reset();
            $(".ud_detail_id").val('');
            removeWaterRightOptions()
        } else {
            var details = JSON.parse(msg);
            details[0].id != "" && $(".ud_detail_id").val(details[0].id);
            $("#ud_detail_username").val(details[0].username);
            $("#ud_detail_contact_name").val(details[0].contact_name);
            $("#ud_clientdetail_contactname").val(details[0].contact_name);
            $("#ud_detail_address").val(details[0].address);
            $("#ud_detail_email").val(details[0].email);
            $("#ud_detail_property").val(details[0].property);
            $("#ud_detail_phone").val(details[0].phone);
            $("#ud_detail_mobile").val(details[0].contact);
            $("#permanent_alloc").val(details[0].allocation_volume);
            details[0].stock_supply === '1' ? $("#stock_domestic").attr('checked', true) : $("#stock_domestic").attr('checked', false)
            // if (details[0].water_right_number === "") {
            //     removeWaterRightOptions()
            // } else {
                getWaterRightDetails(details[0].id)
                $("#button_add_connection").attr({
                    "disabled": false
                });

            $("#button_add_water_right").attr({
                "disabled": false
            });
            load_meter_connections()
        }
        setButtonToEdit()
    });
    request.fail(function(jqXHR, textStatus) {
        console.log("email check fail", textStatus);
    });
});


function removeWaterRightOptions() {
    $("#water_right_number").html('<option value="">Water Right Number</option>');
}

function getWaterRightNumberDetail(r) {
    let action = 'load_water_right_detail';
    let data = {
        userid: r
    };
    let dataType = "script";
    return callAjax(action, '', data, dataType);
}

function getWaterRightNumbers(id) {

  let action = 'load_water_right_data';
  let data = {
      id: id,
  };
  let dataType = "html";
  var response = JSON.parse(callAjax(action, '', data, dataType));
  var rightnumber = '<option value="">Water Right Number</option>';
  response.forEach(element => {
      rightnumber += '<option value=' + element.id + '>' + element.wr_number + '</option>'
  });
  $(".water_right_number_user").html(rightnumber);
}

function setWaterRightNumbers(id) {
    var waterdetail = JSON.parse(getWaterRightNumberDetail(id))
    // should be for each rights if added (,) separated
    var rightnumber = '';
    waterdetail.forEach(element => {
        rightnumber += '<option value=' + element.id + '>' + element.wr_number + '</option>'
    });

    $("#water_right_number").html(rightnumber);
    $("#water_right_number_user").html(rightnumber);
    $(".water_right_number_user").html(rightnumber);
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

function setButtonToSave() {
    $("#ud_detail_onesubmit").attr({
        "class": "submit btn btn-success",
        "value": "Save changes"
    });
}
$("#ud_detail_one").validate({
    rules: {
        email: {
            required: true,
            email: true
        },
        username: {
            required: true,
            minlength: 3
        },
        password: {
            required: true,
            minlength: 3
        },

    },
    messages: {
        email: {
            required: 'Email is required',
        },
        username: {
            required: 'Username is required',

        },
        password: {
            required: 'Password is required',

        },


    },
    submitHandler: function(form) {
        var userid = $(form).find('input[name="userid"]').val()
        var username = $(form).find('input[name="username"]').val()
        var contact_name = $(form).find('input[name="contact_name"]').val()
        var address = $(form).find('input[name="address"]').val()
        var email = $(form).find('input[name="email"]').val()
        var password = $(form).find('input[name="password"]').val()
        var property = $(form).find('input[name="property"]').val()
        var phone = $(form).find('input[name="phone"]').val()
        var mobile = $(form).find('input[name="mobile"]').val()
        var stockdomestic = $(form).find('input[name="stockdomestic"]').is(":checked") ? stockdomestic = 1 : stockdomestic = 0;

        var origin = window.location.origin;
        var siteurl = origin + '/operator/edit_userdetail';
        var request = $.ajax({
            url: siteurl,
            method: "POST",
            data: {
                userid: userid,
                username: username,
                contact_name: contact_name,
                address: address,
                email: email,
                password: password,
                property: property,
                phone: phone,
                mobile: mobile,
                stockdomestic: stockdomestic
            },
            dataType: "html"
        });
        request.done(function(msg) {
            var result = JSON.parse(msg);
            if (result.status == true) {
                $("#ud_detail_response").html('<span class="async_response" style="color:green">' + result.message + '</span>');

            } else {
                $("#ud_detail_response").html('<span class="async_response" style="color:red">' + result.message + '</span>')
            }
            $('.async_response').delay(2500).fadeOut();
            $("#ud_detail_onesubmit").attr({
                "class": "submit btn btn-warning",
                "value": "Edit"
            });
        });
        request.fail(function(jqXHR, textStatus) {
            $("#ud_detail_response").html('<span class="async_response" style="color:red">' + textStatus + '</span>')
        });
    }
});
/* SAVE WATER RIGHT FOR THE USER */
$("#savenewright_form").validate({
    rules: {
        water_right_number: {
            required: true,
            number: true
        },
    },
    messages: {
        water_right_number: {
            required: "Please select water right",
            number: "Please select valid water right"
        },
    },
    submitHandler: function(form) {
        if ($(form).find('input[name="userid"]').val() === '') {
            $("#savenewright_alert").html('<span class="async_response" style="color:red">Please select client</span>')
            $('.async_response').delay(2500).fadeOut();
        } else {
            $('#new_water_right').modal('toggle');

            var userid = $(form).find('input[name="userid"]').val()
            var water_right_number = $(form).find('select[name="water_right_number"]').val()

            let action = 'assign_water_right';
            let data = {
                userid: userid,
                water_right_number: water_right_number
            };
            let dataType = "html";
            var response = JSON.parse(callAjax(action, '', data, dataType));
            if (response.status == true) {
                $("#savenewright_response").html('<span class="async_response" style="color:green">' + response.message + '</span>');
                setWaterRightNumbers(userid)
                $("#button_add_connection").attr({
                    "disabled": false
                });

                load_meter_connections()
            } else {
                $("#savenewright_response").html('<span class="async_response" style="color:red">' + response.message + '</span>')
            }
            $('.async_response').delay(2500).fadeOut();
            //   $("#savenewright_form")[0].reset();

        }
    }
});
// NEW METER CONNECTION FORM
$("#meter_connection_form").validate({
    rules: {
        meter_name: {
            required: true,
        },
        channel_name: {
            required: true,
            number: true
        },
        serial_number: {
            required: true,
        },
        water_right_number: {
            required: true,
            number: true
        },
        property: {
            required: true,
            minlength: 4,
        },
        meter_type: {
            required: true,
            number: true
        },
    },
    messages: {
        meter_name: {
            required: "Please enter Meter Name",
        },
        channel_name: {
            required: "Please enter Channel Name",
            number: "Please enter valid channel"
        },
        water_right_number: {
            required: "Please enter Water Right",
            number: "Please enter valid water right"
        },
        serial_number: {
            required: "Please enter Serial Number",
        },
        property: {
            required: "Please enter Property",
        },
        meter_type: {
            required: "Please enter Meter Type",
            number: "Please enter valid meter type"
        },
    },
    submitHandler: function(form) {
        if ($(form).find('input[name="userid"]').val() === '') {
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
            var serial_number = $(form).find('input[name="serial_number"]').val()
            var property = $(form).find('input[name="property"]').val()
            var meter_type = $(form).find('select[name="meter_type"]').val()
            var fd = new FormData();
            var files = $('#file-input')[0].files[0];
            fd.append('file', files);


            // let action = 'add_meter_connection';
            // let data = { userid : userid, meter_name : meter_name, channel_name : channel_name, water_right_number : water_right_number, property : property, meter_type : meter_type};
            // let dataType = "html";
            var origin = window.location.origin;
            var siteurl = origin + '/operator/upload_meter_image';
            fd.append('userid', userid);
            fd.append('meter_name', meter_name);
            fd.append('channel_name', channel_name);
            fd.append('water_right_number', water_right_number);
            fd.append('property', property);
            fd.append('meter_type', meter_type);
            fd.append('serial_number', serial_number);

            $.ajax({
                url: siteurl,
                type: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    var response = JSON.parse(data)
                    if (response.status == true) {
                        $("#savenewright_response").html('<span class="async_response" style="color:green">' + response.message + '</span>');
                        load_meter_connections()
                    } else {
                        $("#savenewright_response").html('<span class="async_response" style="color:red">' + response.message + '</span>')
                    }
                },
            });


            $('.async_response').delay(2500).fadeOut();
            $("#meter_connection_form")[0].reset();
        }
    }
})

// NEW METER CONNECTION FORM
$("#ud_permanent_alloc").validate({
    rules: {
        permanent_alloc: {
            required: true,
        }
    },
    messages: {
        permanent_alloc: {
            required: "Please enter Allocation Volume",
        },
    },
    submitHandler: function(form) {
        if ($(form).find('input[name="userid"]').val() === '') {
            $("#permanent_alloc_alert").html('<span class="async_response" style="color:red">Please select client</span>')
            $('.async_response').delay(2500).fadeOut();
            setTimeout(() => {
                $("#ud_permanent_alloc")[0].reset();
            }, 2500)
        } else {
            var userid = $(form).find('input[name="userid"]').val()
            var permanent_alloc = $(form).find('input[name="permanent_alloc"]').val()

            let action = 'edit_permanent_allocation';
            let data = {
                userid: userid,
                permanent_alloc: permanent_alloc
            };
            let dataType = "html";
            var response = JSON.parse(callAjax(action, '', data, dataType));

            if (response.status == true) {
                $("#permanent_alloc_alert").html('<span class="async_response" style="color:green">' + response.message + '</span>');
            }

        }
    }
})

load_season_details()

load_wateruser_details()
load_channels()
load_metertypes()
// load_water_rights()
load_meter_connections()
load_system_total_report()
function load_wateruser_details() {
    var origin = window.location.origin;
    var siteurl = origin + '/operator/load_water_users';
    var request = $.ajax({
        url: siteurl,
        method: "GET",
        dataType: "html"
    });
    request.done(function(msg) {
        var users = JSON.parse(msg)
        var username = '';
        var contactname = '';
        var i = 0;
        users.forEach(element => {
            username += i == 0 ? '<option value=""> Username</option><option value=' + element.id + '>' + element.username + '</option>' : '<option value=' + element.id + '>' + element.username + '</option>'
            contactname += i == 0 ? '<option value=""> select</option><option value=' + element.id + '>' + element.contact_name + '</option>' : '<option value=' + element.id + '>' + element.contact_name + '</option>'
            i++;
        });
        $("#ud_clientdetail_username").html(username);
        $("#tr_clientdetail_username").html(username);
        $(".load_client_username").html(username);
        $("#ud_username").html(username);
        $("#tr_username").html(username);
        $("#ud_clientdetail_contactname").html(contactname);
    });
    request.fail(function(jqXHR, textStatus) {
        console.log("email check fail", textStatus);
    });
}

function load_channels() {
    var origin = window.location.origin;
    var siteurl = origin + '/operator/load_channels';
    var request = $.ajax({
        url: siteurl,
        method: "GET",
        dataType: "html"
    });
    request.done(function(msg) {
        var data = JSON.parse(msg)
        var channels = '';
        data.forEach(element => {
            channels += '<option value=' + element.id + '>' + element.channel_name + '</option>'
        });
        $(".channel_name").append(channels);

    });
    request.fail(function(jqXHR, textStatus) {
        console.log("load_channels check fail", textStatus);
    });
}

function load_metertypes() {
    var origin = window.location.origin;
    var siteurl = origin + '/operator/load_metertypes';
    var request = $.ajax({
        url: siteurl,
        method: "GET",
        dataType: "html"
    });
    request.done(function(msg) {
        var data = JSON.parse(msg)
        var metertypes = '';
        data.forEach(element => {
            metertypes += '<option value=' + element.id + '>' + element.type + '</option>'
        });
        $(".meter_type").append(metertypes);
    });
    request.fail(function(jqXHR, textStatus) {
        console.log("load_metertypes check fail", textStatus);
    });
}

function load_water_rights() {
    var origin = window.location.origin;
    var siteurl = origin + '/operator/load_water_rights';
    var request = $.ajax({
        url: siteurl,
        method: "GET",
        dataType: "html"
    });
    request.done(function(msg) {
        var data = JSON.parse(msg)
        var righttypes = '';
        data.forEach(element => {
            righttypes += '<option value=' + element.id + '>' + element.wr_number + '</option>'
        });
        $(".load_water_rights").append(righttypes);
    });
    request.fail(function(jqXHR, textStatus) {
        console.log("load_water_rights check fail", textStatus);
    });
}

$("#addnew-client-form").validate({
    rules: {
        username: {
            required: true,
            minlength: 3
        },
    },
    messages: {
        username: {
            required: "User Name is mandatory.",
            minlength: "Please enter minimum 3 character.",
        },
    },
    submitHandler: function(form) {
        var username = $(form).find('input[name="username"]').val()
        var contactname = $(form).find('input[name="contactname"]').val()
        var origin = window.location.origin;
        var siteurl = origin + '/operator/add_new_client';
        var request = $.ajax({
            url: siteurl,
            method: "POST",
            data: {
                username: username,
                contactname: contactname
            },
            dataType: "html"
        });
        request.done(function(msg) {
            var result = JSON.parse(msg);
            if (result.status == true) {
                $("#addnewclient_result").html('<span class="async_response" style="color:green">' + result.message + '</span>');
            } else {
                $("#addnewclient_result").html('<span class="async_response" style="color:red">' + result.message + '</span>')
            }
            $("#addnew-client-form")[0].reset();
            load_wateruser_details();
            $('.async_response').delay(2500).fadeOut();
        });
        request.fail(function(jqXHR, textStatus) {
            console.log("email check fail", textStatus);
            $("#addnewclient_result").html(textStatus);
        });
    }
});
$('#newoperator').validate({
    rules: {
        username: {
            required: true,
            minlength: 3
        },
        email: {
            required: true,
            minlength: 3
        },
        password: {
            required: true,
            minlength: 3
        },
    },
    messages: {
        username: {
            required: "User Name is mandatory."
        },
        email: {
            required: "Email is mandatory.",
        },
        password: {
            required: "Password is mandatory.",
        }
    }
});
///////////////////Client details usages
$('#ud_username').change(function() {
    var userid = $('#ud_username').val()
    var origin = window.location.origin;
    var siteurl = origin + '/operator/get_waterright';
    var request = $.ajax({
        url: siteurl,
        method: "GET",
        data: {
            userid: userid
        },
        dataType: "html"
    });
    request.done(function(msg) {
        var result = JSON.parse(msg);
        var contactname = result[0].contact_name;
        $('#ud_contactname').val(contactname);
        var meter = result[1].meter_name;
        var metername = '<option value="">Water Right Number</option>';
        meter.forEach(element => {
            metername += '<option value=' + element.id + '>' + element.wr_number + '</option>'
        });

        $('#ud_metername').html(metername);
        load_client_usage_report()

    });
});
$('#tr_username').change(function() {
    var userid = $('#tr_username').val()
    var origin = window.location.origin;
    var siteurl = origin + '/operator/get_waterright';
    var request = $.ajax({
        url: siteurl,
        method: "GET",
        data: {
            userid: userid
        },
        dataType: "html"
    });
    request.done(function(msg) {
        var result = JSON.parse(msg);
        var contactname = result[0].contact_name;
        $('#ud_contactname').val(contactname);
        var meter = result[1].meter_name;
        var metername = '<option value="">Water Right Number</option>';
        meter.forEach(element => {
            metername += '<option value=' + element.id + '>' + element.wr_number + '</option>'
        });

        $('#tr_metername').html(metername);

    });
});

$('#tr_metername').change(function() {
    var waterid = $('#tr_metername').val()
    var origin = window.location.origin;
    var siteurl = origin + '/operator/get_volumeallocation';
    var request = $.ajax({
        url: siteurl,
        method: "GET",
        data: {
            waterid: waterid
        },
        dataType: "html"
    });
    request.done(function(msg) {
        var result = JSON.parse(msg);
        console.log(msg)
        var wr_volume = result[0].wr_volume;
        $('#tr_volume').val(wr_volume);


    });
});
$('#tr_clientdetail_username').change(function() {
    var userid = $('#tr_clientdetail_username').val()
    var origin = window.location.origin;
    var siteurl = origin + '/operator/get_waterright';
    var request = $.ajax({
        url: siteurl,
        method: "GET",
        data: {
            userid: userid
        },
        dataType: "html"
    });
    request.done(function(msg) {
        var result = JSON.parse(msg);
        var contactname = result[0].contact_name;
        $('#ud_contactname').val(contactname);
        var meter = result[1].meter_name;
        var metername = '<option value="">Water Right Number</option>';
        meter.forEach(element => {
            metername += '<option value=' + element.id + '>' + element.wr_number + '</option>'
        });

        $('#tr_meternames').html(metername);

    });
});


$('#tr_duration').change(function() {
    var userid = $('#tr_duration').val()
    console.log(userid)
    if(userid==1)
    {

      $("#temporary_check").css('display','block');

    }
    if(userid==2){


            $("#temporary_check").css('display','none');


    }
});

function load_season_details() {
    var origin = window.location.origin;
    var siteurl = origin + '/operator/get_seasondata';
    var request = $.ajax({
        url: siteurl,
        method: "GET",
        dataType: "html"
    });
    request.done(function(msg) {
        var data = JSON.parse(msg)
        var seasontypes = '';
        data.forEach(element => {
            seasontypes += '<option value=' + element.id + '>' + element.season_name + '</option>'
        });
        $(".season_data").append(seasontypes);
    });
}

$('#ud_seasons').change(function() {
    var seasonid = $('#ud_seasons').val()
    if (seasonid == 0) {

        $('#ud_fromdate').val('');
        $('#ud_todate').val('');
        load_client_usage_report()
        load_water_usage_report()


    } else {

        var origin = window.location.origin;
        var siteurl = origin + '/operator/get_seasondate';
        var request = $.ajax({
            url: siteurl,
            method: "GET",
            data: {
                seasonid: seasonid
            },
            dataType: "html"
        });
        request.done(function(msg) {
            var result = JSON.parse(msg);
            $('#ud_fromdate').val(result[0]['start_date']);
            $('#ud_todate').val(result[0]['end_date']);
            $("#ud_fromdate").attr({
                "disabled": false
            });
            $("#ud_todate").attr({
                 "disabled": false
             });
            load_client_usage_report()
            load_water_usage_report()

        });
    }

});

$('#individual_meter').click(function() {
  if(document.getElementById('individual_meter').checked) {
  $('#individual_meter').val(1);
  load_client_usage_report()
} else {
  $("#highlight_usage").prop("checked", false);

  $('#individual_meter').val(0);
  load_client_usage_report()
}
});

function load_client_usage_report() {
    var userid = $('#ud_username').val();
    var fromdate = $('#ud_fromdate').val();
    var todate = $('#ud_todate').val();
    var meterid = $('#ud_metername').val();
    var allmeter = $('#all_meters').val();

    var individual_meter = $('#individual_meter').val();
    if (fromdate == '') {
        var data = {
            userid: userid,
            meterid:meterid,
            individual_meter:individual_meter,
            allmeter:allmeter,
        };
    } else {
        var data = {
            userid: userid,
            fromdate: fromdate,
            todate: todate,
            meterid,meterid,
            individual_meter:individual_meter,
            allmeter:allmeter,

        };

    }
    var origin = window.location.origin;
    var siteurl = origin + '/operator/load_client_usage_report';

    var request = $.ajax({
        url: siteurl,
        method: "POST",
        data: data,
        dataType: "html"
    });
    request.done(function(msg) {

        console.log(msg)
        var data = JSON.parse(msg)
        var rows = ''
        var count = 1;
        data.forEach(element => {
            rows += '<tr  class="'+ element.sign +'" ><td>' + count + '</td><td>' + element.wr_number + '</td><td>' + element.serial_number + '</td><td>' + element.meter_name + '</td><td>'+ element.meter_reading +'</td><td>' + element.meter_vol + '&nbsp ML</td><td>' + element.remaining + '&nbsp ML</td><td>'+ element.wr_volume +'</td><td>' + element.date_of_reading + '</td><td>' + element.channel_name + '</td><td>' + element.charge_code + '</td><td>' + element.type + '</td></tr>';
            count++;
        });
        $('#client_usage > tbody').html(rows);
        btnGetCount()

    });

}
$('#channels').change(function() {
  $('#all_meter').val('');
  $("#all_meter").prop("checked", false);
  $("#ud_seasons").prop("disabled", false);
  $("#ud_fromdate").prop("disabled", false);
  $("#ud_todate").prop("disabled", false);
    load_water_usage_report()
});

$('#all_meter').change(function() {
if ($('#all_meter').is(':checked'))
{
  $("#all_meter").val(1)
   load_water_usage_report()
}
else {
  $("#all_meter").val('')
   load_water_usage_report()
}
});

 load_water_usage_report()

function load_water_usage_report() {
    var channels = $('#channels').val()
    var fromdate = $('#ud_fromdate').val();
    var todate = $('#ud_todate').val();



    if(channels == 'All Channels')
    {
      var all_meter=1;

      if (fromdate == '' || todate == '') {
          var data = {
              all_meter: all_meter
          };
      } else {
          var data = {
              all_meter: all_meter,
              fromdate: fromdate,
              todate: todate
          };

      }

    }

    else {
      if (fromdate == '' || todate == '') {
          var data = {
              channels: channels
          };
      } else {
          var data = {
              channels: channels,
              fromdate: fromdate,
              todate: todate
          };

      }
    }


    var origin = window.location.origin;
    var siteurl = origin + '/operator/load_water_usage_report';
    // var data=data;
    var request = $.ajax({
        url: siteurl,
        method: "POST",
        data: data,
        dataType: "html"
    });
    request.done(function(msg) {
        var data = JSON.parse(msg)
        var rows = ''
        var count = 1;
        data.forEach(element => {
            rows += '<tr class="'+ element.sign +'"><td>' + element.username + '</td><td>' + element.contact_name + '</td><td>' + element.wr_number + '</td><td>' + element.meter_reading + '&nbsp ML</td><td>'+ element.remaining +' ML</td><td>'+ element.wr_volume  +'</td><td>' + element.channel_name + '</td></tr>';
            count++;
        });
        $('#water_usage_data > tbody').html(rows);
        btnGetWaterusageCount()


    });
}

function delete_meter_connection() {
    var id = $('#delete_meterid').val()

    let action = 'delete_meter_connection';
    let data = {
        id: id
    };
    let dataType = "html";
    var response = JSON.parse(callAjax(action, '', data, dataType));
    if (response.status != false) {
        $("#table_meters_response").html('<span class="async_response" style="color:green">' + response.message + '</span>')
        $('.async_response').delay(2500).fadeOut();
        $("#myModal").modal('hide');
        load_meter_connections()
    } else {

        $("#table_meters_response").html('<span class="async_response" style="color:red">' + response.message + '</span>')
        $('.async_response').delay(2500).fadeOut();
        load_meter_connections()
    }
}

$('#h_waterright').change(function() {
    load_usage_history()
});

load_usage_history()

function load_usage_history() {
  var userid = $('#history_username').val()
  var water_right = $('#h_waterright').val()
  var show_all = $('#show_all').val()
var data={show_all:show_all};
    if(userid)
    {
      var data = {
          userid: userid,
          show_all:show_all
      };
    }
    if(water_right)
    {
      var data = {
          userid: userid,
          water_right:water_right,
          show_all:show_all
      };
    }

    var origin = window.location.origin;
    var siteurl = origin + '/operator/load_usage_history';
    var request = $.ajax({
        url: siteurl,
        method: "POST",
        data:data,
        dataType: "html"
    });
    request.done(function(msg) {
        var data = JSON.parse(msg)
        var rows = ''
        var count = 1;
        data.forEach(element => {
            rows += '<tr class="display'+ element.active +'"><td><img src="<?php echo base_url(); ?>assets/meterimages/' + element.photo + '" height="50" width="50"></td><td>' + element.serial_number + '</td><td>' + element.meter_name + '</td><td>' + element.meter_reading + '&nbspML</td><td>' + element.date_of_reading + '</td><td>'+ element.remaining +'&nbsp ML</td><td>' + element.channel_name + '</td><td>' + element.charge_code_value + '</td><td>' + element.type + '</td><td><a href="#" data-toggle="modal" data-keyboard="false" data-backdrop="static" data-target="#edit-meter" data-id="' + element.id + '" data-userid="' + element.userid + '" data-imagename="' + element.photo + '" data-meter_name="' + element.meter_name + '" data-serial_number="' + element.serial_number + '" data-meter_reading="' + element.meter_reading + '" data-date_of_reading="' + element.date_of_reading + '" data-channel="' + element.channel_id + '" data-charge_code="' + element.charge_code + '" data-type="' + element.type_id + '"> <img src="https://portal.intelligentcanalsystems.com/assets/operators/img/edit-meter.png" alt="meter"></a></td></tr>';
            count++;
        });

        $('#example > tbody').html(rows);
    });

    load_usage_summary()
}

$(function() {
    $('#edit-meter').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); /*Button that triggered the modal*/
        var id = button.data('id');
        var link = "https://portal.intelligentcanalsystems.com/assets/meterimages/";
        var userid = button.data('userid');
        var meter_name = button.data('meter_name');
        var serial_number = button.data('serial_number');
        var meter_reading = button.data('meter_reading');
        var date_of_reading = button.data('date_of_reading');
        var channel = button.data('channel');
        var charge_code = button.data('charge_code');
        var imagename = button.data('imagename');
        var type = button.data('type');
        var modal = $(this);

        modal.find('#edit_userid').val(userid);
        modal.find('#meter_name').val(meter_name);
        modal.find('#serial_number').val(serial_number);
        modal.find('#meter_reading').val(meter_reading);
        modal.find('#date_of_reading').val(date_of_reading);
        modal.find('#channel').val(channel);
        modal.find('#charge_code').val(charge_code);
        modal.find('#imagename').val(imagename);
        modal.find('#type').val(type);
        modal.find('#meter_id').val(id);

        document.getElementById("image-preview").src = link + imagename;
    });
    $('#myModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); /*Button that triggered the modal*/
        var id = button.data('id');
        var modal = $(this);
        modal.find('#delete_meterid').val(id);

    });
});

$(function() {
    $('#edit_order').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); /*Button that triggered the modal*/
        var id = button.data('id');
        var userid = button.data('userid');
        var user_name = button.data('user_name');
        var flow_rate = button.data('flow_rate');
        var startTime = button.data('start');
        var endTime = button.data('end');
        var duration = button.data('duration');
        var volume = button.data('volume');
        var modal = $(this);
        modal.find('#order_id').val(id);
        modal.find('#order_userid').val(userid);
        modal.find('#order_flow_rate').val(flow_rate);
        modal.find('#order_user_name').val(user_name);
        modal.find('#order_endTime').val(endTime);
        modal.find('#order_startTime').val(startTime);
        modal.find('#order_duration').val(duration);
        modal.find('#order_volume').val(volume);



    });
});

$(function() {
    $('#edit-details').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); /*Button that triggered the modal*/
        var id = button.data('id');
        var meter_name = button.data('meter_name');
        var serial_number = button.data('serial_number');
        var property = button.data('property');
        var channel_id = button.data('channel_id');
        var type_id = button.data('type_id');
        var wr_number = button.data('wr_number');
        var link = "https://portal.intelligentcanalsystems.com/assets/meterprofiles/";
        var imagename = button.data('image');
        var modal = $(this);
        modal.find('#edit_id').val(id);
        modal.find('#edit_meter_name').val(meter_name);
        modal.find('#edit_serial_number').val(serial_number);
        modal.find('#edit_property').val(property);
        modal.find('#edit_channel_id').val(channel_id);
        modal.find('#edit_type_id').val(type_id);
        modal.find('#edit_imagename').val(imagename);
        modal.find('#edit_wr_number').val(wr_number);
        document.getElementById("img-preview").src = link + imagename;
    });
});
// NEW METER CONNECTION FORM
$("#edit_meter_connection").validate({
    rules: {
        meter_name: {
            required: true,
        },
        channel_name: {
            required: true,
            number: true
        },
        serial_number: {
            required: true,
        },
        water_right_number: {
            required: true,
        },
        property: {
            required: true,
            minlength: 4,
        },
        meter_type: {
            required: true,
            number: true
        },
    },
    messages: {
        meter_name: {
            required: "Please enter Meter Name",
        },
        channel_name: {
            required: "Please enter Channel Name",
            number: "Please enter valid channel"
        },
        water_right_number: {
            required: "Please enter Water Right",
        },
        serial_number: {
            required: "Please enter Serial Number",
        },
        property: {
            required: "Please enter Property",
        },
        meter_type: {
            required: "Please enter Meter Type",
            number: "Please enter valid meter type"
        },
    },
    submitHandler: function(form) {

        if ($(form).find('input[name="userid"]').val() === '') {
            $("#meter_connection_alert").html('<span class="async_response" style="color:red">Please select client</span>')
            $('.async_response').delay(2500).fadeOut();
            setTimeout(() => {
                $("#edit_meter_connection")[0].reset();
            }, 2500)
        } else {

            var id = $(form).find('input[name="id"]').val()
            var meter_name = $(form).find('input[name="meter_name"]').val()
            var channel_name = $(form).find('select[name="channel_name"]').val()
            var water_right_number = $(form).find('input[name="water_right_number"]').val()
            var serial_number = $(form).find('input[name="serial_number"]').val()
            var property = $(form).find('input[name="property"]').val()
            var meter_type = $(form).find('select[name="meter_type"]').val()
            var imagename = $(form).find('input[name="imagename"]').val()
            var fd = new FormData();
            var files = $('#edit-input')[0].files[0];
            fd.append('file', files);
            var origin = window.location.origin;
            var siteurl = origin + '/operator/edit_meter_connection';
            fd.append('id', id);
            fd.append('meter_name', meter_name);
            fd.append('channel_name', channel_name);
            fd.append('water_right_number', water_right_number);
            fd.append('property', property);
            fd.append('meter_type', meter_type);
            fd.append('serial_number', serial_number);
            fd.append('imagename', imagename);
            $.ajax({
                url: siteurl,
                type: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    var response = JSON.parse(data)
                    if (response.status == true) {
                        $("#savenewright_response").html('<span class="async_response" style="color:green">' + response.message + '</span>');
                        $("#edit-details").modal('hide');
                    } else {
                        $("#savenewright_response").html('<span class="async_response" style="color:red">' + response.message + '</span>');
                        $("#edit-details").modal('hide');

                    }
                    load_meter_connections()


                }
            });

        }
    }
})
//excel
  $(".saveAsExcel").click(function(){
    var workbook = XLSX.utils.book_new();
      var worksheet_data  = document.getElementById("water_usage_data");
      var worksheet = XLSX.utils.table_to_sheet(worksheet_data);
      workbook.SheetNames.push("Test");
      workbook.Sheets["Test"] = worksheet;
       exportExcelFile(workbook);

  });

  function exportExcelFile(workbook) {
    return XLSX.writeFile(workbook, "water_usage_report.xlsx");
  }

  $(".saveCSV").click(function(){
    var workbook = XLSX.utils.book_new();
      var worksheet_data  = document.getElementById("client_usage");
      var worksheet = XLSX.utils.table_to_sheet(worksheet_data);
      workbook.SheetNames.push("Test");
      workbook.Sheets["Test"] = worksheet;

       exportCSVFile(workbook);

  });

  function exportCSVFile(workbook) {
    return XLSX.writeFile(workbook, "client_usage_report.xlsx");
  }
//Pdf
function generatePDF() {
let doc = new jsPDF('l', 'pt');
var channel=$('#channels').val()
var origin = window.location.origin;
var siteurl = origin + '/operator/get_channel_by_id';
var data = {
  id: channel,
};
var request = $.ajax({
    url: siteurl,
    method: "POST",
    data: data,
    dataType: "html"
});
request.done(function(msg) {

  var data=JSON.parse(msg)
  var chnl=data[0].channel_name
  var today = new Date();
  var dd = String(today.getDate()).padStart(2, '0');
  var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
  var yyyy = today.getFullYear();
  today = mm + '/' + dd + '/' + yyyy;

  const header = function(data) {
    doc.setFontSize(18);
    // doc.setTextColor(200, 0, 255);
    // doc.setFontStyle('normal');
    doc.text('Water Usage Report', data.settings.margin.left + 0, 60);
  };

  doc.setFontSize(10);
  doc.text(40, 130, 'Report Date:'+' '+today)

  doc.text(40, 110, 'Channel:'+chnl)

  const totalPagesExp = '{total_pages_count_string}';
  const footer = function(data) {
    let str = 'Page ' + data.pageCount;
    // Total page number plugin only available in jspdf v1.0+
    if (typeof doc.putTotalPages === 'function') {
      str = str + ' of ' + totalPagesExp;
    }
    doc.text(str, data.settings.margin.left, doc.internal.pageSize.height - 30);
  };

  const options = {
    createdCell: function(cell, opts) {

if (opts.column.index == 5) {
  if(cell.raw.replace(' ML','')<0)
  {
    cell.styles.textColor = "#FF0000";
  }

}
 },
    beforePageContent: header,
    afterPageContent: footer,
    margin: {
      top: 150
    }
  };

  var elem = document.getElementById('water_usage_data');
  var data = doc.autoTableHtmlToJson(elem);


  doc.autoTable(data.columns, data.rows, options);

  // Total page number plugin only available in jspdf v1.0+
  if (typeof doc.putTotalPages === 'function') {
    doc.putTotalPages(totalPagesExp);
  }
  doc.save('water_usage_data.pdf');

});
}
function generate() {


let doc = new jsPDF('l', 'pt');
var ud_username=$('#ud_username').val()
var ud_fromdate=$('#ud_fromdate').val()
var ud_todate=$('#ud_todate').val()
if(ud_fromdate=='' && ud_todate=='')
{
 var dates=''
}
else
{
   var dates='(From: '+ ud_fromdate +' - To:' + ud_todate + ')'
}

var origin = window.location.origin;
var siteurl = origin + '/operator/load_details';
var data = {
  id: ud_username,
};
var request = $.ajax({
    url: siteurl,
    method: "POST",
    data: data,
    dataType: "html"
});
request.done(function(msg) {
  var data=JSON.parse(msg)
  var name=data[0].username
  var contact =data[0].contact_name
  var today = new Date();
  var dd = String(today.getDate()).padStart(2, '0');
  var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
  var yyyy = today.getFullYear();

  today = mm + '/' + dd + '/' + yyyy;

  const header = function(data) {
    doc.setFontSize(18);
    // doc.setTextColor(200, 0, 255);
    // doc.setFontStyle('normal');
    doc.text('Client Usage Report', data.settings.margin.left + 0, 60);
    doc.setFontSize(12);
    doc.text(40,80,dates);
  };
  doc.setFontSize(10);
  doc.text(40, 110, 'Username:'+' '+name+' '+contact)
  doc.text(40, 130, 'Report Date:'+' '+today)
  const totalPagesExp = '{total_pages_count_string}';
  const footer = function(data) {
    let str = 'Page ' + data.pageCount;
    // Total page number plugin only available in jspdf v1.0+
    if (typeof doc.putTotalPages === 'function') {
      str = str + ' of ' + totalPagesExp;
    }
    doc.text(str, data.settings.margin.left, doc.internal.pageSize.height - 30);
  };

  const options = {
    createdCell: function(cell, opts) {


 },
    beforePageContent: header,
    afterPageContent: footer,
    margin: {
      top: 150
    }
  };

  var elem = document.getElementById('client_usage');
  var data = doc.autoTableHtmlToJson(elem);
  doc.autoTable(data.columns, data.rows, options);

  // Total page number plugin only available in jspdf v1.0+
  if (typeof doc.putTotalPages === 'function') {
    doc.putTotalPages(totalPagesExp);
  }

  doc.save('client_usage_report.pdf');
});
}
 function btnGetCount() {
       var totalRowCount = $("#client_usage tr").length;
       var rowCount = $("#client_usage td").closest("tr").length;

    if(rowCount>0)
    {
      $("#exportbtn").css('display','block');
    }


 }
 function btnGetWaterusageCount() {
       var totalRowCount = $("#water_usage_data tr").length;
       var rowCount = $("#water_usage_data td").closest("tr").length;
    if(rowCount>0)
    {
      $("#exportbtn").css('display','block');
    }
    if(rowCount==0)
    {
      $("#exportbtn").css('display','none');
    }
 }
 $("#addmeterdata").validate({
     rules: {
         meter_id: {
             required: true,
         },
         meter_reading:{
           required: true,
         },
         date_of_reading:{
           required: true,
         },
         charge_code:{
           required: true,
         },
         file:{
           required: true,
         },

     },
     messages: {
         meter_id: {
             required: "Meter Connection is mandatory.",
         },
         meter_reading:{
           required: "Meter  Reading is required",
         },
         date_of_reading:{
           required: "Date of reading is required",
         },
         charge_code:{
           required: "Charge code is required",
         },
         file:{
           required: "Meter Image is required",
         },
     }

 });


 /* SAVE WATER RIGHT FOR THE USER */
 $("#addnewright_form").validate({
     rules: {
         water_right_number: {
             required: true,
         },
         volume_alloc: {
             required: true,
             number: true
         },
     },
     messages: {
         water_right_number: {
             required: "Please Enter water right",
         },
         volume_alloc: {
             required: "Please enter Volume",
         },
     },
     submitHandler: function(form) {

         if ($(form).find('input[name="userid"]').val() === '') {
             $("#savenewright_alert").html('<span class="async_response" style="color:red">Please select client</span>')
             $('.async_response').delay(2500).fadeOut();
         } else {
             // $('#new_water_right').modal('toggle');
             var userid = $(form).find('input[name="userid"]').val()
             var water_right_number = $(form).find('input[name="water_right_number"]').val()
             var volume_alloc = $(form).find('input[name="volume_alloc"]').val()

             let action = 'add_water_right';
             let data = {
                 userid: userid,
                 water_right_number: water_right_number,
                   volume_alloc:volume_alloc
             };
             let dataType = "html";
             var response = JSON.parse(callAjax(action, '', data, dataType));
             if (response.status == true) {
                 $("#savenewright_response").html('<span class="async_response" style="color:green">' + response.message + '</span>');
                 getWaterRightDetails(userid)
                 $("#button_add_connection").attr({
                     "disabled": false
                 });
             //
             //     load_meter_connections()
             }
             else {
                 $("#savenewright_response").html('<span class="async_response" style="color:red">' + response.message + '</span>')
             }
             $('.async_response').delay(2500).fadeOut();
               $("#addnewright_form")[0].reset();

         }
     }
 });


 function getWaterRightDetails(id) {
   let action = 'load_water_right_data';
   let data = {
       id: id,
   };
   let dataType = "html";
   var response = JSON.parse(callAjax(action, '', data, dataType));
   if (response.length === 0) {
       removeWaterRightOptions()
   } else {
   var rightnumber = '<option value="">Water Right Number</option>';
   response.forEach(element => {
       rightnumber += '<option value=' + element.id + '>' + element.wr_number + '</option>'
   });
   $("#water_right_number").html(rightnumber);
   $("#water_right_number_user").html(rightnumber);
   $(".water_right_number_user").html(rightnumber);
}
 }

$('#ud_fromdate').change(function() {
  var fromdate = $('#ud_fromdate').val()
  var ud_todate = $('#ud_todate').val()
  load_client_usage_report()
  load_water_usage_report()
});
$('#ud_todate').change(function() {
  var fromdate = $('#ud_fromdate').val()
  var ud_todate = $('#ud_todate').val()
  load_client_usage_report()
  load_water_usage_report()
});


$('#highlight_usage').change(function() {
  if ($('#highlight_usage').is(':checked'))
  {
    $(".negative").css("color","red");
  }
  else {
    $(".negative").css("color","#878787");

  }
});


$('#all_meters').change(function() {
  if ($('#all_meters').is(':checked'))
  {
    $('#individual_meter').val(0)

  $('#all_meters').val(1)
  }
  else {

  $('#all_meters').val(0)
    $('#individual_meter').val(1)
  }



  load_client_usage_report()
});

function load_usage_summary()
{
  var history_username = $('#history_username').val()
  var h_waterright = $('#h_waterright').val()
  if(history_username !='')
  {
    var origin = window.location.origin;
    var siteurl = origin + '/operator/load_usage_summary';
    var data = {
      user_id: history_username,
      wr_number: h_waterright,
    };
    var request = $.ajax({
        url: siteurl,
        method: "POST",
        data: data,
        dataType: "html"
    });
    request.done(function(msg) {
      if(msg !='')
      {
        var data=JSON.parse(msg)

        $('#property').text(data.property)
        $('#remaining').text(data.remaining)
        $('#permanent').text(data.permanent)
        $('#usage').text(data.usage)
        $('#allocation').text(data.allocation)
        $('#temporary').text(data.temporary)

      }

    })
  }

}


$('#mailform').validate({
    rules: {
        name: {
            required: true,
            minlength: 3
        },
        email: {
            required: true,
            minlength: 3
        },
        subject: {
            required: true,
            minlength: 3
        },
        message: {
            required: true,
            minlength: 3
        },
    },
    messages: {
        name: {
            required: "User Name is mandatory."
        },
        email: {
            required: "Email is mandatory.",
        },
        subject: {
            required: "Subject is mandatory.",
        },
        message: {
          required: "Message is mandatory.",

        },
    }
});

$('#water_right_number').change(function() {
  var data=$('#water_right_number').val()
load_meter_connections()

});

$('#ud_metername').change(function() {
load_client_usage_report()

});

function btnGetSystemTotalReport() {
      var totalRowCount = $("#system_total_report tr").length;
      var rowCount = $("#system_total_report td").closest("tr").length;

   if(rowCount>0)
   {
     $("#exportbtndata").css('display','block');
   }
   if(rowCount==0)
   {
     $("#exportbtndata").css('display','none');
   }
}


function load_system_total_report()
{

    var origin = window.location.origin;
    var siteurl = origin + '/operator/load_system_total_report';
    var request = $.ajax({
        url: siteurl,
        method: "GET",
        dataType: "html"
    });
    request.done(function(msg) {
      var data = JSON.parse(msg)
      var rows = ''
      var count = 1;
      data.forEach(element => {
          rows += '<tr class="'+ element.sign +'"><td>' + count + '</td><td>' + element.username + ' '+ element.contact_name +'</td><td>' + element.serial_number + '</td><td>' + element.wr_number + '</td><td>' + element.meter_name + '</td><td>' + element.meter_reading + ' ML</td><td>'+ element.remaining +' ML</td><td>'+ element.wr_volume  +' ML</td><td>' + element.charge_code + '</td><td>' + element.channel_name + '</td><td>' + element.type + '</td></tr>';
          count++;
      });
      $('#system_total_report > tbody').html(rows);



    })
btnGetSystemTotalReport()
}

function generatePDFtotal() {


let doc = new jsPDF('l', 'pt');

  var today = new Date();
  var dd = String(today.getDate()).padStart(2, '0');
  var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
  var yyyy = today.getFullYear();

  today = mm + '/' + dd + '/' + yyyy;

  const header = function(data) {
    doc.setFontSize(18);
    // doc.setTextColor(200, 0, 255);
    // doc.setFontStyle('normal');
    doc.text('System Total Report', data.settings.margin.left + 0, 60);
    doc.setFontSize(12);
  };
  doc.setFontSize(10);
  doc.text(40, 130, 'Report Date:'+' '+today)

  const totalPagesExp = '{total_pages_count_string}';
  const footer = function(data) {
    let str = 'Page ' + data.pageCount;
    // Total page number plugin only available in jspdf v1.0+
    if (typeof doc.putTotalPages === 'function') {
      str = str + ' of ' + totalPagesExp;
    }
    doc.text(str, data.settings.margin.left, doc.internal.pageSize.height - 30);
  };

  const options = {
    beforePageContent: header,
    afterPageContent: footer,
    margin: {
      top: 150
    }
  };

  var elem = document.getElementById('system_total_report');
  var data = doc.autoTableHtmlToJson(elem);
  doc.autoTable(data.columns, data.rows, options);

  // Total page number plugin only available in jspdf v1.0+
  if (typeof doc.putTotalPages === 'function') {
    doc.putTotalPages(totalPagesExp);
  }

  doc.save('system_total_report.pdf');
}


$(".saveAsExcelTotal").click(function(){
  var workbook = XLSX.utils.book_new();
    var worksheet_data  = document.getElementById("system_total_report");
    var worksheet = XLSX.utils.table_to_sheet(worksheet_data);
    workbook.SheetNames.push("Test");
    workbook.Sheets["Test"] = worksheet;
     exportExcelFileTotal(workbook);

});

function exportExcelFileTotal(workbook) {
  return XLSX.writeFile(workbook, "system_total_report.xlsx");
}

$("#serial_number_usage").change(function() {
  var meter_id=$('#serial_number_usage').val()

      $('#meter_name_usage').val(meter_id)

});

$("#meter_name_usage").change(function() {
  var meter_id=$('#meter_name_usage').val()

   $('#serial_number_usage').val(meter_id)

});

get_meterconnection()

function get_meterconnection()
{
  var user_id=$('#history_username').val()
  var origin = window.location.origin;
  var siteurl = origin + '/operator/get_meterconnection';
  var request = $.ajax({
      url: siteurl,
      method: "POST",
      data: {
          user_id : user_id,
      },
      dataType: "html"
  });
  request.done(function(msg) {
    var data = JSON.parse(msg)
    var rows = "<option value=''>Select Meter Connection</option>"
    var count = 1;
    data.forEach(element => {
      rows += '<option value=' + element.id + '>' + element.meter_name + '</option>'

    });
    $('#meter_name_usage').html(rows);


  })
}


get_serialnumber()

function get_serialnumber()
{
  var user_id=$('#history_username').val()


  var origin = window.location.origin;
  var siteurl = origin + '/operator/get_serialnumber';
  var request = $.ajax({
      url: siteurl,
      method: "POST",
      data: {
          user_id : user_id,
      },
      dataType: "html"
  });
  request.done(function(msg) {
    var data = JSON.parse(msg)
    var rows = "<option value=''>Select Serial Number</option>"
    var count = 1;
    data.forEach(element => {
      rows += '<option value=' + element.id + '>' + element.serial_number + '</option>'

    });
    $('#serial_number_usage').html(rows);


  })
}


//for order filter

$("#order_status,#order_channels,#order_usernames").change(function() {

   var order_status= $('#order_status').val();
   var order_channels= $('#order_channels').val();
   var order_usernames= $('#order_usernames').val();
   load_water_order_data(order_status,order_channels,order_usernames);

});


load_water_order_data(3,0,0)


function  load_water_order_data(order_status,order_channels,order_usernames)
{
 let end_point;
 if(order_status==1) {
    end_point='load_current_water_order';
 }
 else if(order_status==2) {
    end_point='load_upcoming_water_order';
 }
 else if(order_status==3){
    end_point='load_allwater_orders';
 }
 else if(order_status==4){
    end_point='load_new_water_orders';
 }

  var origin = window.location.origin;
  var siteurl = origin + '/operator/'+end_point;
  var request = $.ajax({
      url: siteurl,
      method: "POST",
      data: {
          channel_id : order_channels,
          userid: order_usernames,
      },
      dataType: "html"
  });
  request.done(function(msg) {

    var data = JSON.parse(msg)
      var rows = ''
      var count = 1;
      data.forEach(element => {
          rows += '<tr><td>' + element.username + '</td><td>' + element.startTime  +'</td><td>' + element.flowRate + '</td><td>' + element.meter_name + '</td><td>' + element.duration + '</td><td>' + element.endTime + '</td><td>' + element.totalVolume + ' ML</td><td>'+ toStatus(element.isActive)  +' </td><td>'+ element.channel_name +'</td><td>' + element.action +' '+element.modal +' </td></tr>';

          count++;
      });
      $('#water_order_system > tbody').html(rows);


    })

}

function toStatus(s){
    var text;
    if(s==='1'){
        text = '<span class="btn btn-sm btn-success">Approved</span>';
    }
    else if(s==='0'){
        text = '<span class="btn btn-sm btn-default">Pending</span>';
    }
    else {
        text = '<span class="btn btn-sm btn-danger">Denied</span>';
    }
    return text;
}

setInterval(update_message_count,3000);
function update_message_count()
{
    var origin = window.location.origin;
    var siteurl = origin + '/operator/message_count';

    var request = $.ajax({
        url: siteurl,
        method: "GET",
        dataType: "html"
    });

    request.done(function(msg) {
      $('#count').html(msg);
    })
}

$("#meter_reading_usage").change(function() {
  var origin = window.location.origin;
  var siteurl = origin + '/operator/check_meter_reading';
  var meter_id=$('#meter_name_usage').val();
  var meter_reading=$('#meter_reading_usage').val();


  var request = $.ajax({
      url: siteurl,
      method: "POST",
      data: {
        meter_id : meter_id,
        meter_reading : meter_reading,
      },
      dataType: "html"
  });
  request.done(function(msg) {
    console.log(msg)
    if(msg==1)
    {
      $("#add_meter_usage").attr("disabled", false);
      $("#msg_usage").html('');

    }
    else {
    $("#add_meter_usage").attr("disabled", true);
    $("#msg_usage").html('<p style="color:red">Meter Reading should be greater '+msg+'</p>');

    }
  })

  });

  $("#order_flow_rate").change(function(){
    var order_flow_rate=$('#order_flow_rate').val();
    var order_startTime=$('#order_startTime').val();
    var order_duration=$('#order_duration').val();

    var volume=order_duration*(order_flow_rate/24)
    $('#order_volume').val(volume);
    var datetime=new Date(order_startTime);
    datetime.setHours(datetime.getHours()+parseInt(order_duration))
    $('#order_endTime').val(formatDate(datetime))

  });
  $("#order_startTime").change(function(){
    var order_flow_rate=$('#order_flow_rate').val();
    var order_startTime=$('#order_startTime').val();
    var order_duration=$('#order_duration').val();
    var order_volume=$('#order_volume').val();
    var order_endTime=$('#order_endTime').val();

    var volume=order_duration*(order_flow_rate/24)
    $('#order_volume').val(volume);
    var datetime=new Date(order_startTime);
    datetime.setHours(datetime.getHours()+parseInt(order_duration))
    $('#order_endTime').val(formatDate(datetime))

  });
  $("#order_duration").change(function(){
    var order_flow_rate=$('#order_flow_rate').val();
    var order_startTime=$('#order_startTime').val();
    var order_duration=$('#order_duration').val();
    var order_volume=$('#order_volume').val();
    var order_endTime=$('#order_endTime').val();

    var volume=order_duration*(order_flow_rate/24)
    $('#order_volume').val(volume);
    var datetime=new Date(order_startTime);
    datetime.setHours(datetime.getHours()+parseInt(order_duration))
    $('#order_endTime').val(formatDate(datetime))

  });
  $("#order_volume").change(function(){
    var order_flow_rate=$('#order_flow_rate').val();
    var order_startTime=$('#order_startTime').val();
    var order_duration=$('#order_duration').val();
    var order_volume=$('#order_volume').val();
    var order_endTime=$('#order_endTime').val();

    var duration=Math.round(order_volume*(24/order_flow_rate))
    console.log(duration)
    $('#order_duration').val(duration);
    var datetime=new Date(order_startTime);
    datetime.setHours(datetime.getHours()+parseInt(duration))
    $('#order_endTime').val(formatDate(datetime))

  });


    function formatDate(date) {
      var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear(),
        hr = d.getHours(),
        min = d.getMinutes(),
        sec = d.getSeconds();

      if (month.length < 2)
        month = '0' + month;
      if (day.length < 2)
        day = '0' + day;
      if (hr < 10)
        hr = "0" + hr;
      if (min < 10)
        min = "0" + min;
      if (sec < 10)
        sec = "0" + sec;
      // 2020-10-09 04:27:00
      return year + '-' + month + '-' + day + ' ' + hr + ':' + min + ':' + sec;

    }

  $("#end_time_btn").click(function() {
     $("#end_time_btn").addClass("order_btn_color");

     $("#duration_btn").removeClass("order_btn_color");
     $("#volume_btn").removeClass("order_btn_color");

       $("#order_duration").css("display", "none");
       $("#order_volume").css("display", "none");
       $("#order_endTime").css("display", "block");
   });

   $("#duration_btn").click(function() {

      $("#duration_btn").addClass("order_btn_color");

      $("#end_time_btn").removeClass("order_btn_color");
      $("#volume_btn").removeClass("order_btn_color");

        $("#order_duration").css("display", "block");
        $("#order_volume").css("display", "none");
        $("#order_endTime").css("display", "none");
                });


            $("#volume_btn").click(function() {
            $("#volume_btn").addClass("order_btn_color");


            $("#end_time_btn").removeClass("order_btn_color");
            $("#duration_btn").removeClass("order_btn_color");

            $("#order_duration").css("display", "none");
            $("#order_volume").css("display", "block");
            $("#order_endTime").css("display", "none");
                });

                $("#meter_reading_usage").change(function() {
                  var origin = window.location.origin;
                  var siteurl = origin + '/ICSweb/operator/check_meter_reading';
                  var meter_id=$('#meter_name_usage').val();
                  var meter_reading=$('#meter_reading_usage').val();


                  var request = $.ajax({
                      url: siteurl,
                      method: "POST",
                      data: {
                        meter_id : meter_id,
                        meter_reading : meter_reading,
                      },
                      dataType: "html"
                  });
                  request.done(function(msg) {
                    console.log(msg)
                    if(msg==1)
                    {
                      $("#add_meter_usage").attr("disabled", false);
                      $("#msg_usage").html('');

                    }
                    else {
                    $("#add_meter_usage").attr("disabled", true);
                    $("#msg_usage").html('<p style="color:red">Meter Reading should be greater '+msg+'</p>');

                    }
                  })

                  });


                                  $("#transfer_form").validate({
                                      rules: {
                                          tr_username_1: {
                                              required: true,
                                          },
                                          tr_water_right_1: {
                                              required: true,

                                          },
                                          tr_duration: {
                                              required: true,

                                          },
                                          tr_volume: {
                                              required: true,

                                          },
                                          tr_username_2: {
                                              required: true,

                                          },
                                          tr_water_right_2: {
                                              required: true,

                                          }
                                      },
                                      messages: {
                                          tr_username_1: {
                                              required: "Please select first Username",
                                          },
                                          tr_water_right_1: {
                                              required: "Please select first Water Right",

                                          },
                                          tr_duration: {
                                              required: "Please select Duration",

                                          },
                                          tr_volume: {
                                              required: "Please Select Volume",

                                          },
                                          tr_username_2: {
                                              required: "Please select second Username",

                                          },
                                          tr_water_right_2: {
                                              required: "Please select second water right",

                                          }
                                      }

                                  });

</script>
