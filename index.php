<!DOCTYPE html>
<head>
   <title>Pusher Chat HadiK</title>
   <meta name="viewport" content="width=device-width">
   <link rel="icon" type="image/x-icon" href="favicon.png">
   <script src="pusher.min.js"></script>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
   <script>
      var channel_me, event_us, channel_to, event_to, message;
      function channel_mefunction ()
      {
      channel_me = document.getElementById("channel_me").value;
      console.log('this channel me :'+channel_me);
      }
      function event_usfunction ()
      {
      event_us = document.getElementById("event_us").value;
      console.log('this event me :'+event_us);
      $("#event_to").val(event_us);
      event_to = event_us;
	  
      // Enable pusher logging - don't include this in production
      // Pusher.logToConsole = true;
	  
      var app_key = '743996c65a2c3b504344';
      var pusher = new Pusher(app_key, {
      cluster: 'ap1',
      forceTLS: false
      });
      channel = pusher.subscribe(channel_me);
      channel.bind(event_us, function(data) {
	  if (data.from_channel == document.getElementById("channel_me").value && data.from_event == document.getElementById("event_us").value)
	  {
		  console.log("duplicate disabled");
	  }
	  else
	  {
        var html = ''; html +='<div style="background-color: #bfd2dc; width:50%; margin-right:51%; border-radius:5px; padding-left:0.5%;"><label>Received :</label><br><small> [Time : '+data.datetime+' | From Channel : ' +data.From_channel+' Event : '+data.From_event+']</small><br><pre>'+data.Message+'</pre></div>';
        $('#received').append(html);
        console.log(data);
	  }

      });
      
      }
      function channel_tofunction ()
      {
      channel_to = document.getElementById("channel_to").value;
      console.log('this to channel :'+channel_to);
      }
      
      function event_tofunction ()
      {
      event_to = document.getElementById("event_to").value;
      console.log('this to event :'+event_to);
      }
      function messagefunction ()
      {
      
      message = document.getElementById("message").value;
      console.log('this message :'+message);
      
      }
      
   </script>
</head>
<body>
   <center>
      <h1>Chat Messages</h1>
   </center>
   <p style="text-align:center;">
      Hello <code>please input about Me</code>
   </p>
   <form action="" method="post" id="formnya" >
      <input type="text" name="from_channel" oninput="channel_mefunction()" id="channel_me" size="14px" placeholder="Channel Me">&nbsp;&nbsp;<input type="text" name="from_event" onfocusout="event_usfunction()" id="event_us" size="14px" placeholder="Event US"><br>
      <hr>
      <label>To Channel:</label><br>
      <input type="text" name="channel_to" oninput="channel_tofunction()" id="channel_to"><br>
      <label>To Event :</label><br>
      <input type="text" name="event_to" oninput="event_tofunction()" id="event_to"><br>
      <label>Messages :</label><br>
      <textarea rows="4" cols="40" name="message" oninput="messagefunction()" id="message"></textarea>
      <br>
      <button type="button" onclick="send()"> Send </button>
      <hr>
      <div id="received"></div>
   </form>
</body>
<script>
   function send(){
	var today = new Date();
	var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
	var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
	var dateTime = date+' '+time;
	var dataform = $('#formnya').serialize();
          $.ajax({
              url : "trigger.php",
              type: "POST",
              data: dataform,
              success: function(data)
              { 
				console.log('success!');
				var html = ''; html +='<div style="background-color: #dcbfbf; width:50%; margin-left:51%; border-radius:5px; padding-left:0.5%;"><label>Sent :</label><br><small> [Time : '+dateTime+' | To Channel : ' +document.getElementById("channel_to").value+' Event : '+document.getElementById("event_to").value+']</small><br><pre>'+document.getElementById("message").value+'</pre></div>'; document.getElementById("message").value = "";
				$('#received').append(html);
				
			  },
              error: function (jqXHR, textStatus, errorThrown)
              {
				  
                  alert("Mohon maaf! Sepertinya ada masalah dengan server!");
      
              }
          });
     }
</script>