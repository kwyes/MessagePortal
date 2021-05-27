<?php
if(isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST"){
  @extract($_POST);
  if(isset($emailArr)) {
    include_once '../config/dbconnect.php';
    require_once '../config/messagePortalClass.php';
    $c = new messagePortalClass();
    $mob = $c->sendMessage(json_decode($emailArr,true), $type, $toType, $category, $title, $parentsAuthCheck, $body, $plain);
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
