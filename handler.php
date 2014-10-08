<?php
  include("vars.php");
  include("crypto.php");
  $key = base64_decode($key);

  $subject = "";
  $send_to = "";
  $message = "";
  $display = "";
  $type = "";

  if(isset($_POST["type"])) {
    $type = $_POST["type"];
  }

  if($type == "remove") {
    // This is coming from the web-form
    $send_to = $_POST["email"];
    $subject = "Unsubscribe from " . $club_name . "Mailing List";
    $iv = getIV();
    $encrypted_email = encode($send_to, $key, $iv);
    $link = $http_path . "?e=" . $encrypted_email . "&iv=" . $iv;
    $message = "To unsubscribe from the " . $club_name . " mailing list, please follow this link: " . $link;
    $display = "Please check your e-mail";
  } elseif(isset($_GET["e"]) && isset($_GET["iv"])) {
    // This is coming from the confirmation e-mail
    $send_to = $majordomo_email;
    $e = $_GET["e"];
    $iv = $_GET["iv"];
    $unsub_email = decode($e, $key, $iv);
    $message = "APPROVE	" . $mailing_list_password . "	UNSUBSCRIBE	" . $listserve . "	" . $unsub_email;
    $display = "Unsubscribe Request Sent";
  } elseif($type == "add"){
    $send_to = $majordomo_email;
    $sub_email = $_POST["email"];
    $message = "APPROVE " . $mailing_list_password . "  SUBSCRIBE     " . $listserve . "      " . $sub_email;
  } else {
    echo "An error occurred";
    exit();
  }

  $headers = 'From: ' . $from . "\r\n" .
    'Reply-To: ' . $reply_to . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

  mail($send_to, $subject, $message, $headers);

  echo $display;
?>
