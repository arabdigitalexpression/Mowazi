<?php
// ajax handlers
// mimic the actuall admin-ajax
define('DOING_AJAX', true);

if (!isset($_POST['action'])) {
  die('-1');
}

//make sure you update this line
//to the relative location of the wp-load.php
$path = preg_replace('/wp-content.*$/', '', __DIR__);
require_once ($path.'/wp-load.php');

//Typical headers
header('Content-Type: text/html');
send_nosniff_header();

//Disable caching
header('Cache-Control: no-cache');
header('Pragma: no-cache');

$action = esc_attr(trim($_POST['action']));
$allowed_actions = array('newsletter_subscription', 'change_password');

if (in_array($action, $allowed_actions)) {
  if (is_user_logged_in()) {
    add_action('MY_AJAX_HANDLER_'.$action.'', ''.$action.'_callback');
    do_action('MY_AJAX_HANDLER_'.$action);
  } else {
    add_action('MY_AJAX_HANDLER_nopriv_'.$action.'', ''.$action.'_callback');
    do_action('MY_AJAX_HANDLER_nopriv_'.$action);
  }
} else {
  die('-1');
}


function change_password_callback() {
  $newpassword = $_POST[ 'password' ];
  $user_id = get_current_user_id();
  if($newpassword && $user_id) {
      wp_update_user( array( 'ID' => $user_id, 'user_pass' => $newpassword));
  }
}


function newsletter_subscription_callback() {

    $curl = curl_init();
    $email = $_POST[ 'email' ];

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.sendgrid.com/v3/marketing/contacts",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "PUT",
      CURLOPT_POSTFIELDS => "{\"list_ids\":[\"bf070288-3147-44cd-895d-065e7a624409\"],\"contacts\":[{\"email\":\"$email\",\"first_name\":\"string (optional)\",\"last_name\":\"string (optional)\"}]}",
      CURLOPT_HTTPHEADER => array(
        "authorization: Bearer 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",
        "content-type: application/json"
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      echo $response;
    }
}
?>