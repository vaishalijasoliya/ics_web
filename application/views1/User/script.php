<script  type="text/javascript">

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



$('#water_order_form').validate({
    rules: {
        meter_name: {
            required: true,
             },
      start_date: {
            required: true,
        },
        flow_rate: {
            required: true,
        },
       end_date:{
           required:function(element) {
            return $("#duration,#volume").is(':empty');
        }

       },
       duration:{
           required:function(element) {
            return $("#end_date,#volume").is(':empty');
        }


       },
       volume:{
           required:function(element) {
            return $("#end_date,#duration").is(':empty');
        }


       },



    },
    messages: {
        meter_name: {
            required: "Meter Name is mandatory."
        },
        start_date: {
            required: "Start Date is mandatory.",
        },
        flow_rate: {
            required: "Flow Rate is mandatory.",
        },
        end_date: {
            required: "End Date is mandatory.",
        },
        duration: {
            required: "Duration is mandatory.",
        },
        volume: {
            required: "Volume is mandatory.",
        },

    }
});

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
        "value": "Save changes",
        "name":"ud_detail_onesubmit",
    });
}

/*
* LetterAvatar
*
* Artur Heinze
* Create Letter avatar based on Initials
* based on https://gist.github.com/leecrossley/6027780
*/
(function(w, d){


function LetterAvatar (name, size) {

name  = name || '';
size  = size || 60;

var colours = [
    "#1abc9c", "#2ecc71", "#3498db", "#9b59b6", "#34495e", "#16a085", "#27ae60", "#2980b9", "#8e44ad", "#2c3e50",
    "#f1c40f", "#e67e22", "#e74c3c", "#ecf0f1", "#95a5a6", "#f39c12", "#d35400", "#c0392b", "#bdc3c7", "#7f8c8d"
],

nameSplit = String(name).toUpperCase().split(' '),
initials, charIndex, colourIndex, canvas, context, dataURI;


if (nameSplit.length == 1) {
initials = nameSplit[0] ? nameSplit[0].charAt(0):'?';
} else {
initials = nameSplit[0].charAt(0) + nameSplit[1].charAt(0);
}

if (w.devicePixelRatio) {
size = (size * w.devicePixelRatio);
}

charIndex     = (initials == '?' ? 72 : initials.charCodeAt(0)) - 64;
colourIndex   = charIndex % 20;
canvas        = d.createElement('canvas');
canvas.width  = size;
canvas.height = size;
context       = canvas.getContext("2d");

context.fillStyle = colours[colourIndex - 1];
context.fillRect (0, 0, canvas.width, canvas.height);
context.font = Math.round(canvas.width/2)+"px Arial";
context.textAlign = "center";
context.fillStyle = "#FFF";
context.fillText(initials, size / 2, size / 1.5);

dataURI = canvas.toDataURL();
canvas  = null;

return dataURI;
}

LetterAvatar.transform = function() {

Array.prototype.forEach.call(d.querySelectorAll('img[avatar]'), function(img, name) {
name = img.getAttribute('avatar');
img.src = LetterAvatar(name, img.getAttribute('width'));
img.removeAttribute('avatar');
img.setAttribute('alt', name);
});
};


// AMD support
if (typeof define === 'function' && define.amd) {

define(function () { return LetterAvatar; });

// CommonJS and Node.js module support.
} else if (typeof exports !== 'undefined') {

// Support Node.js specific `module.exports` (which can be a function)
if (typeof module != 'undefined' && module.exports) {
exports = module.exports = LetterAvatar;
}

// But always support CommonJS module 1.1.1 spec (`exports` cannot be a function)
exports.LetterAvatar = LetterAvatar;

} else {

window.LetterAvatar = LetterAvatar;

d.addEventListener('DOMContentLoaded', function(event) {
LetterAvatar.transform();
});
}

})(window, document);


(function(document) {
'use strict';

var LightTableFilter = (function(Arr) {

var _input;

function _onInputEvent(e) {
_input = e.target;
var tables = document.getElementsByClassName(_input.getAttribute('data-table'));
Arr.forEach.call(tables, function(table) {
Arr.forEach.call(table.tBodies, function(tbody) {
  Arr.forEach.call(tbody.rows, _filter);
});
});
}

function _filter(row) {
var text = row.textContent.toLowerCase(), val = _input.value.toLowerCase();
row.style.display = text.indexOf(val) === -1 ? 'none' : 'table-row';
}

return {
init: function() {
var inputs = document.getElementsByClassName('light-table-filter');
Arr.forEach.call(inputs, function(input) {
  input.oninput = _onInputEvent;
});
}
};
})(Array.prototype);

document.addEventListener('readystatechange', function() {
if (document.readyState === 'complete') {
LightTableFilter.init();
}
});

})(document);


setInterval(update_message_count,3000);
function update_message_count()
{
    var origin = window.location.origin;
    var siteurl = origin + '/user/message_count';

    var request = $.ajax({
        url: siteurl,
        method: "GET",
        dataType: "html"
    });

    request.done(function(msg) {
      document.getElementById('count').innerHTML=msg;
    })
}
</script>
