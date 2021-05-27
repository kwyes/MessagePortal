<?php
  $auth = "GOVFNTJRjE5MzY=YXXUEOS";
  echo base64_decode(substr(substr($auth, 0, -7), 7));

  $_SQL = array(
      'term-list' => "SELECT SemesterID,SemesterName,StartDate,EndDate
            ,MidCutOffDate
            ,CurrentSemester
            ,FExam1
            ,FExam2
            ,NextStartDate
        FROM tblBHSSemester
        WHERE CurrentSemester = 'Y'"
      );


?>
