<?php
if(isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST"){
  @extract($_POST);
    include_once '../config/dbconnect.php';
    require_once '../config/messagePortalClass.php';
    $c = new messagePortalClass();
    $mob = $c->getParentsEmailList();
  		if ($mob != false) {
  			echo json_encode($mob);
  		} else {
  			echo json_encode(array('result' => '0'));
  		}
} else {
	echo 0;
	exit;
}
?>
