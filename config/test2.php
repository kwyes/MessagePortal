<?php
require_once 'sendEmailClass.php';

$from = array('email' => 'helpdesk@bodwell.edu', 'name' => 'BHS IT Help Desk');
$cc = '';
$subject = 'test2';
$body = 'test2';

$to = array(
    array('email' => 'chanho.lee@bodwell.edu', 'name' => "Chanho Lee")
);
$res = sendEmail($from, $to, $cc, $subject, $body);
echo $res;
 ?>
