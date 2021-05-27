<?php

function jdecode($data) {
    $arr = json_decode($data, true);
    foreach($arr as $key => $val) {
        $arr[$key] = base64_decode($val);
    }
    return $arr;
}

$conn = new PDO($dsn);
$query = "SELECT F.*,U.LastLogIn, U.RelationshipToStudent,U.CreateDate as AccountCreatedDate FROM tblBHSApplicationUnfinished F
LEFT JOIN tblBHSApplicationUser U ON U.LoginID = F.LoginID
WHERE F.CreateDate > '2020-01-01' order by CreateDate desc";

$stmt = $conn->prepare($query);


$tr = '';
if ($stmt->execute()) {
  $i = 0;
    while ($row = $stmt->fetch()) {
      $i++;
      $applicationID = $row['ApplicationID'];
      $LoginID = $row['LoginID'];
      $AccountCreatedDate = $row['AccountCreatedDate'];
      $RelaitionShipToStudent = $row['RelationshipToStudent'];
      $LastLogin = $row['LastLogIn'];
      $data = jdecode($row['JsonData']);
      $GradeApplied = $data['_grade'];
      $CountryOfOrigin = $data['_scountry'];
      $tr .= "<tr>
      <td>$applicationID</td><td>$LoginID</td><td>$AccountCreatedDate</td>
      <td>$LastLogin</td><td>$RelaitionShipToStudent</td><td>$CountryOfOrigin</td><td>$GradeApplied</td>
      </tr>";


   }
   // $stmt2 = $conn->prepare($tQuery);
   // $stmt2->execute();
}




?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <table border=1>
      <thead>
        <th>ApplicationID</th>
        <th>LoginID</th>
        <th>Account Created Date</th>
        <th>Last Login</th>
        <th>RelaitionShipToStudent</th>
        <th>CountryOfOrigin</th>
        <th>Grade Applied</th>
      </thead>
      <tbody>
        <?=$tr?>
      </tbody>
    </table>

  </body>
</html>
