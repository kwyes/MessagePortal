<?php
$size = 'test';
$today = date('Y-m-d');
$myfile = fopen("../notificationLog.txt", "w") or die("Unable to open file!");
$txt = "$size sent $today\n";
fwrite($myfile, $txt);
fclose($myfile);


 ?>
