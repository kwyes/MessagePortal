<?php
error_reporting(E_ALL);
require_once __DIR__.'/settings.php';
global $settings;
require_once __DIR__.'/lib/is-authenticated.php';
if(!IsAuthenticated()) {
    header("HTTP/1.0 401 Unauthorized");
    echo 'Unauthorized';
    exit();
}

$layoutDir = "layout/";
$page = ($_GET['page']) ? $_GET['page'] : $_POST['page'];
$url = $_SERVER['REQUEST_URI'];


  include_once $layoutDir."header.html";
  include_once $layoutDir."sidebar.php";

	switch($page) {
		default : {
			include_once $layoutDir."list.php";
			break;
		}
		case "dashboard" : {
			include_once $layoutDir."main.html";
			break;
		}
    	case "message" : {
			include_once $layoutDir."message.html";
			break;
		}
		case "message2" : {
			include_once $layoutDir."messagetest.html";
			break;
		}
    	case "list" : {
			include_once $layoutDir."list.php";
			break;
		}
    	case "email" : {
			include_once $layoutDir."email.php";
			break;
		}
	}
	include_once $layoutDir."footer.html";
?>
