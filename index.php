<!DOCTYPE html>
<head>
   <title>Pusher Chat HadiKIT</title>
   <meta name="viewport" content="width=device-width">
   <link rel="icon" type="image/x-icon" href="favicon.png">
   <script src="pusher.min.js"></script>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
   <script>
      var channel_me, event_me, channel_to, event_to, message;
      function channel_mefunction ()
      {
      channel_me = document.getElementById("channel_me").value;
      console.log('this channel me :'+channel_me);
      }
      function event_mefunction ()
      {
      event_me = document.getElementById("event_me").value;
      console.log('this event me :'+event_me);
      $("#event_to").val(event_me);
      event_to = event_me;
	  
      // Enable pusher logging - don't include this in production
      // Pusher.logToConsole = true;
	  
      var app_key = '743996c65a2c3b504344';
      var pusher = new Pusher(app_key, {
      cluster: 'ap1',
      forceTLS: false
      });
      channel = pusher.subscribe(channel_me);
      channel.bind(event_me, function(data) {
	  if (data.from_channel == document.getElementById("channel_me").value && data.from_event == document.getElementById("event_me").value)
	  {
		  console.log("duplicate disabled");
	  }
	  else
	  {
	  var html = ''; html +='<div style="background-color: #bfd2dc; width:50%; margin-right:51%; border-radius:5px; padding-left:0.5%;"><label>Received :</label><small> [Time : '+data.datetime+' ] <br>From Channel : ' +data.From_channel+' Event : '+data.From_event+'</small><br><pre>'+data.Message+'</pre></div>';
        $('#received').append(html);
        console.log(data);
	  }

      });
      
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
      Hello <code>please input about Channel Me To and Messages.</code>
   </p>
   <form action="" method="post" id="formnya" >
      <input type="text" name="from_channel" oninput="channel_mefunction()" id="channel_me" size="14px" placeholder="Channel">&nbsp;&nbsp;
	  <input type="text" name="from_event" onfocusout="event_mefunction()" id="event_me" size="14px" placeholder="Event From Me">&nbsp;&nbsp;
      <input type="text" name="event_to" oninput="event_tofunction()" size="14px" placeholder="Event Dear To" id="event_to">
      <hr>
      <div id="received"></div>
	  <br>
      <hr>
      <label>Write Messages :</label><br>
      <textarea rows="4" cols="40" name="message" oninput="messagefunction()" id="message" style="width:100%"></textarea>
      <br>
      <button type="button" onclick="send()" style="position: absolute; right:0%; width: 120px;"> Send </button>
   </form>
   <br>
   <div class="copyright">
   <small>
		© <?php echo date('Y'); ?> made with <i class="tim-icons icon-heart-2"></i> by &#x1f49d;
		<a href="https://www.youtube.com/c/hadikit?sub_confirmation=1" target="_blank">Hadi Khoirudin, S.Kom - @HadiKIT</a> for a better web.
	</small>
   </div>
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
				var html = ''; html +='<div style="background-color: #dcbfbf; width:50%; margin-left:51%; border-radius:5px; padding-left:0.5%;"><label>Sent :</label><small> [Time : '+dateTime+' ]<br> To Channel : ' +document.getElementById("channel_me").value+' Event : '+document.getElementById("event_to").value+'</small><br><pre>'+document.getElementById("message").value+'</pre></div>'; document.getElementById("message").value = "";
				$('#received').append(html);
				
			  },
              error: function (jqXHR, textStatus, errorThrown)
              {
				  
                  alert("Mohon maaf! Sepertinya ada masalah dengan server!");
      
              }
          });
     }
</script>