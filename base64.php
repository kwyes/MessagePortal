<?php

  $staffId = '1234567RjIxMTQ=1234567';
  $id = base64_decode(substr(substr($staffId, 0, -7), 7));
  echo $id;
  // echo 'test';
  // echo base64_encode('F2114');
 ?>
