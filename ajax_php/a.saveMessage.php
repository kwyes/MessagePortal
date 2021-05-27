<?php
if(isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST"){
  @extract($_POST);
  if(isset($category)) {
    include_once '../config/dbconnect.php';
    require_once '../config/messagePortalClass.php';
    $c = new messagePortalClass();
    $mob = $c->saveMessage($body, $plain, $category, $expiry, $expiryDate, $pmCheck, $post, $publish, $publishAt, $pwCheck, $smCheck, $swCheck, $title, $msgType,$msgStatusCode,$fromType,$fromSystem,$fromDept,$toType,$toScope);    
  		if ($mob != false) {
  			echo json_encode($mob);
  		} else {
  			echo json_encode(array('result' => '0'));
  		}
  } else {
    echo json_encode(array('result' => '0'));
  }
} else {
	echo 0;
	exit;
}
?>
