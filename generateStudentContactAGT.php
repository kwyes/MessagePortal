<?php
function dbclean($val)
{
    return str_replace("'", "''", trim($val));
}
function makeInsertQuery($table, array $data) {
    if(count($data) <= 0) {
        return;
    }
    $i = 0;
    $fields = '';
    $values = '';
    foreach($data as $name => $value) {
        if($i++ == 0) {
            $fields .= $name;
            $value = dbclean($value);
            $values .= "'$value'";
        } else {
            $fields .= ','.$name;
            $value = dbclean($value);
            $values .= ','."'$value'";
        }
    }
    $sql = "INSERT $table ($fields) VALUES ($values);\n";
    return $sql;
}
$dsn = "odbc:Driver={SQL Server};Server=10.0.0.108;Database=Bodwell;Uid=sa;Pwd=Yv9FrUpx0a;";
// $dsn = "odbc:Driver={SQL Server};Server=10.0.0.209;Database=Bodwell;Uid=sa;Pwd=pm2em9GhOOWt;";
$conn = new PDO($dsn);
$query = "SELECT Distinct c.StudentID, s.AgentID, a.Email, a.AgentName, a.ContactFName, a.ContactLName, a.Address1, a.City, a.Province, a.PostalCode, a.Country FROM tblBHSStudentContact c
LEFT JOIN tblBHSStudent s on s.StudentID = c.StudentID
LEFT JOIN tblAgent a on a.AgentID = s.AgentID
WHERE c.StudentID NOT IN (SELECT StudentID
from tblBHSStudentContact WHERE ContactTab = 'AGT') AND s.AgentID != 0 and c.StudentID > 201500000
order by c.StudentID DESC";


$stmt = $conn->prepare($query);
$tQuery = "";
$tQuery2 = "";
$sql = "";
$studentContactData3 = "";
if ($stmt->execute()) {
  $i = 0;
    while ($row = $stmt->fetch()) {
      $studentID = $row['StudentID'];
      $studentContactData3 = array(
        'StudentID'=>$studentID,
        'ContactTab'=>'AGT',
        'RelationshipToStudent'=>'AG',
        'RTSOther'=>'',
        'EmergencyContactInCanada'=>'0',
        'LastName'=>$row['ContactLName'],
        'FirstName'=>$row['ContactLName'],
        'OtherName'=>'',
        'Gender'=>'Z',
        'MaritalStatus'=>'',
        'DOB'=>'',
        'EmailPersonal'=>$row['Email'],
        'EVInternal'=>'0',
        'EVExternal'=>'0',
        'StreetAddress'=>$row['Address1'],
        'Locality'=>$row['City'],
        'AAL1'=>$row['Province'],
        'CountryOld'=>$row['Country'],
        'PostalCode'=>$row['PostalCode'],
        // 'Phone1CountryCode'=>$contact['a']['CountryCodePhone1'],
        // 'Phone1AreaCode'=>$contact['a']['CityAreaCodePhone1'],
        // 'Phone1LocalNumber'=>$contact['a']['LocalNumberPhone1'],
        // 'Phone2CountryCode'=>$contact['a']['CountryCodePhone2'],
        // 'Phone2AreaCode'=>$contact['a']['CityAreaCodePhone2'],
        // 'Phone2LocalNumber'=>$contact['a']['LocalNumberPhone2'],
        'AgentID' => $row['AgentID'],
        'AgencyName' => $row['AgentName'],
        'ModifyUserID'=>'F2178',
        'CreateUserID'=>'F2178',
      );
      $sql .= makeInsertQuery('tblBHSStudentContact', $studentContactData3)."<br />";



   }
   // $stmt2 = $conn->prepare($tQuery);
   // $stmt2->execute();
   echo $sql;
}




?>
