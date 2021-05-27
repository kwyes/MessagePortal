<?php
if(isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST"){
  @extract($_POST);
  if(isset($msgCategory)) {
    include_once '../config/dbconnect.php';
    require_once '../config/messagePortalClass.php';
    $c = new messagePortalClass();
    $mob = $c->updateMessage($body, $edate, $expires, $frontpage, $msgCategory, $msgId, $subject);
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
