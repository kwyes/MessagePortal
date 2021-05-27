<?php

function generateRandomPassword($length=10) {
    $alt = time() % 2;
    $password = strtoupper(chr(rand(65, 72)));
    $password .= strtolower(chr(rand(74, 75)));
    $password .= strtolower(chr(rand(77, 78)));
    $password .= strtolower(chr(rand(80, 90)));
    $password .= rand(2, 9);
    $password .= rand(2, 9);
    $password .= rand(2, 9);
    $password .= rand(2, 9);
    $password .= strtoupper(chr(rand(65, 72)));
    $password .= strtolower(chr(rand(80, 90)));
    $password .= rand(2, 9);
    $password .= rand(2, 9);
    return substr($password,0,$length);
}


$dsn = "odbc:Driver={SQL Server};Server=10.0.0.108;Database=Bodwell;Uid=sa;Pwd=Yv9FrUpx0a;";
$conn = new PDO($dsn);
$query = "SELECT * FROM tblBHSUserAuth WHERE CreateUserID = 'F2178'";
$delete_query = "DELETE FROM tblBHSUserAuth WHERE UserID = '{UserID}'";
$update_query = "UPDATE tblBHSUserAuth SET PW2 = '{PW2}' WHERE UserID = '{UserID}'";


$stmt = $conn->prepare($query);
$tQuery = "";
$tQuery2 = "";


if ($stmt->execute()) {
  $i = 0;
    while ($row = $stmt->fetch()) {
        $update_query2 = $update_query;
        $i++;
        $UserID = $row['UserID'];
        $PW2 = generateRandomPassword(8);
        $update_query2=str_replace('{UserID}', $UserID, $update_query2);
        $update_query2=str_replace('{PW2}', $PW2, $update_query2);
        $tQuery2 .= $update_query2."<BR />";
   }
   // $stmt2 = $conn->prepare($tQuery);
   // $stmt2->execute();
   echo $i."Number"."<br />";
   echo $tQuery2;
}




?>
