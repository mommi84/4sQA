<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="microphone/microphone.min.css">
</head>
<body style="text-align: center;">
<center><div id="microphone"></div></center>
<div id="result"></div>
<div id="info"></div>
<div id="error"></div>
<script src="https://code.jquery.com/jquery.js"></script>
<script src="microphone/microphone.min.js"></script>

<script>
  var mic = new Wit.Microphone(document.getElementById("microphone"));
  var info = function (msg) {
    document.getElementById("info").innerHTML = msg;
  };
  var error = function (msg) {
    document.getElementById("error").innerHTML = msg;
  };
  mic.onready = function () {
    info("Microphone is ready to record");
  };
  mic.onaudiostart = function () {
    info("Recording started");
    error("");
  };
  mic.onaudioend = function () {
    info("Recording stopped, processing started");
  };
  mic.onresult = function (intent, entities) {
	  
	var jqxhr = $.ajax({
		method: "GET",
		url: "controller.php",
		data: {
			intent: intent,
			entities: entities
		}
	})
	  .done(function( msg ) {
		  // alert( "Data Saved: " + msg );
		  $("#result").html(msg);
	  })
	  .fail(function() {
	    alert( "error" );
	  })
	  .always(function() {
	    // alert( "complete" );
	  });
	  
    // var r = kv("intent", intent);
    //
    // for (var k in entities) {
    //   var e = entities[k];
    //
    //   if (!(e instanceof Array)) {
    //     r += kv(k, e.value);
    //   } else {
    //     for (var i = 0; i < e.length; i++) {
    //       r += kv(k, e[i].value);
    //     }
    //   }
    // }
    //
    // document.getElementById("result").innerHTML = r;
  };
  mic.onerror = function (err) {
    error("Error: " + err);
  };
  mic.onconnecting = function () {
    info("Microphone is connecting");
  };
  mic.ondisconnected = function () {
    info("Microphone is not connected");
  };

  mic.connect("QZ5ISMNKZDD5WP4RYP4JMVOQDGDTMXQ4");
  // mic.start();
  // mic.stop();

  function kv (k, v) {
    if (toString.call(v) !== "[object String]") {
      v = JSON.stringify(v);
    }
    return k + "=" + v + "\n";
  }
</script>
</body>
</html>