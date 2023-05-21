<?php
  date_default_timezone_set('Asia/Jakarta');
  ini_set('date.timezone', 'Asia/Jakarta');
  require __DIR__ . '/vendor/autoload.php';

  $options = array(
    'cluster' => 'ap1',
    'useTLS' => false
  );
  
  #'YOUR_APP_ID';
  $app_id = '1604614';

  #'YOUR_APP_KEY';
  $app_key = '743996c65a2c3b504344';

  #'YOUR_APP_SECRET';
  $app_secret = '9317a9ca542aef9b4343';

  #'YOUR_APP_CLUSTER';
  $app_cluster = array(
    'cluster' => 'ap1',
    'useTLS' => false
  );

  $pusher = new Pusher\Pusher($app_key, $app_secret, $app_id, $app_cluster);

  print_r($_POST);
  $data =   ['datetime'		=> date("d-m-Y H:i:s"),
			'from_channel' 	=> $_POST['from_channel'],
			'from_event' 	=> $_POST['from_event'],
			'message' 		=> $_POST['message']  ];
  $channel_to				= $_POST['channel_to'];
  $event_to					= $_POST['event_to'];
  $pusher->trigger($channel_to, $event_to, $data);
?>
