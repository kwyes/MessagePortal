<?php
// $dsn = "odbc:Driver={SQL Server};Server=10.0.0.209;Database=Bodwell;Uid=sa;Pwd=pm2em9GhOOWt;";
$dsn = "odbc:Driver={SQL Server};Server=10.0.0.108;Database=Bodwell;Uid=sa;Pwd=Yv9FrUpx0a;";
$conn = new PDO($dsn);
$query = "SELECT StudentID
      ,LastName
      ,FirstName
      ,EnglishName
      ,MiddleName
      ,DOB
      ,Sex
      ,Origin
      ,Photo
      ,Phone1
      ,Phone2
      ,Phone3
      ,Fax
      ,Email1
      ,Email2
      ,Address1
      ,Address2
      ,City
      ,Citizenship
      ,Province
      ,Country
      ,PostalCode
      ,MLastName
      ,MFirstName
      ,MMiddleName
      ,MEnglishName
      ,MRelationship
      ,MOther
      ,MMarital
      ,MDOB
      ,MPhone1
      ,Mphone2
      ,MFax
      ,MEmail
      ,MAddress1
      ,MAddress2
      ,MCity
      ,MProvince
      ,MCountry
      ,MPostalCode
      ,ELastName
      ,EFirstName
      ,EMiddleName
      ,EEnglishName
      ,ERelationship
      ,EOther
      ,EMarital
      ,EDOB
      ,EPhone1
      ,EPhone2
      ,EFax
      ,EEmail
      ,EAddress1
      ,EAddress2
      ,ECity
      ,EProvince
      ,ECountry
      ,EPostalCode
      ,PLastName
      ,PFirstName
      ,PMiddleName
      ,PEnglishName
      ,PMarital
      ,PRelationship
      ,POther
      ,PDOB
      ,PPhone1
      ,PPhone2
      ,PFax
      ,PEmail
      ,PAddress1
      ,PAddress2
      ,PCity
      ,PProvince
      ,PCountry
      ,PPostalCode
      ,GLastName
      ,GFirstName
      ,GMiddleName
      ,GEnglishName
      ,GRelationship
      ,GOther
      ,Gmarital
      ,GDOB
      ,GAddress1
      ,GAddress2
      ,GCity
      ,GProvince
      ,GCountry
      ,GPostalCode
      ,GPhone1
      ,GPhone2
      ,GFax
      ,GEmail
      ,WithdrawAdvice
      ,SEmailVerified
      ,PEmailVerified
      ,MEmailVerified
      ,EEmailVerified
      ,GEmailVerified
      ,HEmailVerified
  FROM tblBHSStudent
  where CurrentStudent != 'N' AND StudentID = '201900139'";

$insert_query = "INSERT INTO tblBHSStudentContact
           (StudentID
           ,ContactTab
           ,RelationshipToStudent
           ,RTSOther
           ,EmergencyContactInCanada
           ,LastName
           ,FirstName
           ,OtherName
           ,Gender
           ,MaritalStatus
           ,DOB
           ,EmailPersonal
           ,EVInternal
           ,EVExternal
           ,StreetAddress
           ,Locality
           ,AAL1
           ,CountryOld
           ,PostalCode
           ,Phone1LocalNumber
           ,Phone2LocalNumber
           ,AgentID
           ,AgencyName
           ,ModifyUserID
           ,CreateUserID
           ,CitizenshipPrimary
           ,COB
           ,StatusInCanada)
     VALUES
           ('{StudentID}'
           ,'{ContactTab}'
           ,'{RelationshipToStudent}'
           ,'{RTSOther}'
           ,'{EmergencyContactInCanada}'
           ,'{LastName}'
           ,'{FirstName}'
           ,'{OtherName}'
           ,'{Gender}'
           ,'{MaritalStatus}'
           ,'{DOB}'
           ,'{EmailPersonal}'
           ,'{EVInternal}'
           ,'false'
           ,'{StreetAddress}'
           ,'{Locality}'
           ,'{AAL1}'
           ,'{CountryOld}'
           ,'{PostalCode}'
           ,'{Phone1LocalNumber}'
           ,'{Phone2LocalNumber}'
           ,'{AgentID}'
           ,'{AgencyName}'
           ,'{ModifyUserID}'
           ,'{CreateUserID}'
           ,'{CitizenshipPrimary}'
           ,'{COB}'
           ,'{StatusInCanada}')";

$stmt = $conn->prepare($query);
$tQuery = "";
$tQuery2 = "";

$chk = 1;

if ($stmt->execute()) {
  $i = 0;
    while ($row = $stmt->fetch()) {
      $insert_query2 = $insert_query;
      $t = 'n';
      if($chk == 0) {
        // student first//
        $i++;
        $StudentID = $row['StudentID'];
        $EmergencyContactInCanada = "0";

        $RelationshipToStudent = 'ST';
        $RTSOther = '';
        $LastName = $row['LastName'];
        $FirstName = $row['FirstName'];
        $DOB = $row['DOB'];
        $MaritalStatus = '';
        $EmailPersonal = $row['Email1'];
        $EVInternal = $row['SEmailVerified'];

        $StreetAddress = $row['Address1']." ".$row['Address2'];
        $StreetAddress = str_replace("'", "''", $StreetAddress);
        // $StreetAddress = htmlspecialchars($StreetAddress, ENT_QUOTES);

        $Locality = $row['City'];
        $Locality = str_replace("'", "''", $Locality);

        $AAL1 = $row['Province'];
        $AAL1 = str_replace("'", "''", $AAL1);

        $Country = $row['Country'];
        $Country = str_replace("'", "''", $Country);

        $PostalCode = $row['PostalCode'];
        $PostalCode = str_replace("'", "''", $PostalCode);

        $Gender = $row['Sex'];
        $Gender = str_replace("'", "''", $Gender);

        $Phone1LocalNumber = $row['Phone1'];
        $Phone2LocalNumber = $row['Phone2'];



        $OtherName = $row['EnglishName'];
        $AgentID = '';
        $AgencyName = '';
        $ModifyUserID = 'F2178';
        $CreateUserID = 'F2178';
        $CitizenshipPrimary = $row['Origin'];
        $COB = $row['Origin'];
        $StatusInCanada = $row['Citizenship'];

        $ContactTab = 'STD';
        $insert_query2=str_replace('{ContactTab}', $ContactTab, $insert_query2);
        $insert_query2=str_replace('{StudentID}', $StudentID, $insert_query2);
        $insert_query2=str_replace('{RelationshipToStudent}', $RelationshipToStudent, $insert_query2);
        $insert_query2=str_replace('{RTSOther}', $RTSOther, $insert_query2);
        $insert_query2=str_replace('{EmergencyContactInCanada}', $EmergencyContactInCanada, $insert_query2);
        $insert_query2=str_replace('{LastName}', $LastName, $insert_query2);
        $insert_query2=str_replace('{FirstName}', $FirstName, $insert_query2);
        $insert_query2=str_replace('{OtherName}', $OtherName, $insert_query2);
        $insert_query2=str_replace('{Gender}', $Gender, $insert_query2);
        $insert_query2=str_replace('{MaritalStatus}', $MaritalStatus, $insert_query2);
        $insert_query2=str_replace('{DOB}', $DOB, $insert_query2);
        $insert_query2=str_replace('{EmailPersonal}', $EmailPersonal, $insert_query2);
        $insert_query2=str_replace('{EVInternal}', $EVInternal, $insert_query2);
        $insert_query2=str_replace('{StreetAddress}', $StreetAddress, $insert_query2);
        $insert_query2=str_replace('{Locality}', $Locality, $insert_query2);
        $insert_query2=str_replace('{AAL1}', $AAL1, $insert_query2);
        $insert_query2=str_replace('{CountryOld}', $Country, $insert_query2);
        $insert_query2=str_replace('{PostalCode}', $PostalCode, $insert_query2);
        $insert_query2=str_replace('{Phone1LocalNumber}', $Phone1LocalNumber, $insert_query2);
        $insert_query2=str_replace('{Phone2LocalNumber}', $Phone2LocalNumber, $insert_query2);
        $insert_query2=str_replace('{AgentID}', $AgentID, $insert_query2);
        $insert_query2=str_replace('{AgencyName}', $AgencyName, $insert_query2);
        $insert_query2=str_replace('{ModifyUserID}', $ModifyUserID, $insert_query2);
        $insert_query2=str_replace('{CreateUserID}', $CreateUserID, $insert_query2);
        $insert_query2=str_replace('{CitizenshipPrimary}', $CitizenshipPrimary, $insert_query2);
        $insert_query2=str_replace('{COB}', $COB, $insert_query2);
        $insert_query2=str_replace('{StatusInCanada}', $StatusInCanada, $insert_query2);
        $t = 'y';

      } elseif ($chk == 1) {
        if($row['PRelationship']) {
          $i++;
          $StudentID = $row['StudentID'];
          $EmergencyContactInCanada = "0";


          $RelationshipToStudent = $row['PRelationship'];
          $RTSOther = $row['POther'];
          $LastName = $row['PLastName'];
          $FirstName = $row['PFirstName'];
          $DOB = $row['PDOB'];
          $MaritalStatus = $row['PMarital'];
          $EmailPersonal = $row['PEmail'];
          $EVInternal = $row['PEmailVerified'];

          $StreetAddress = $row['PAddress1']." ".$row['PAddress2'];
          $StreetAddress = str_replace("'", "''", $StreetAddress);
          // $StreetAddress = htmlspecialchars($StreetAddress, ENT_QUOTES);

          $Locality = $row['PCity'];
          $Locality = str_replace("'", "''", $Locality);

          $AAL1 = $row['PProvince'];
          $AAL1 = str_replace("'", "''", $AAL1);

          $Country = $row['PCountry'];
          $Country = str_replace("'", "''", $Country);

          $PostalCode = $row['PPostalCode'];

          if($row['PRelationship'] == 'MO'){
            $Gender = 'F';
          } elseif ($row['PRelationship'] == 'FA') {
            $Gender = 'M';
          } else {
            $Gender = 'Z';
          }

          $PostalCode = str_replace("'", "''", $PostalCode);

          $Gender = str_replace("'", "''", $Gender);


          $Phone1LocalNumber = $row['PPhone1'];
          $Phone1LocalNumber = str_replace("'", "''", $Phone1LocalNumber);

          $Phone2LocalNumber = $row['PPhone2'];
          $Phone2LocalNumber = str_replace("'", "''", $Phone2LocalNumber);




          $OtherName = '';
          $AgentID = '';
          $AgencyName = '';
          $ModifyUserID = 'F2178';
          $CreateUserID = 'F2178';
          $CitizenshipPrimary = '';
          $COB = '';
          $StatusInCanada = '';

          $ContactTab = 'PG1';
          $insert_query2=str_replace('{ContactTab}', $ContactTab, $insert_query2);
          $insert_query2=str_replace('{StudentID}', $StudentID, $insert_query2);
          $insert_query2=str_replace('{RelationshipToStudent}', $RelationshipToStudent, $insert_query2);
          $insert_query2=str_replace('{RTSOther}', $RTSOther, $insert_query2);
          $insert_query2=str_replace('{EmergencyContactInCanada}', $EmergencyContactInCanada, $insert_query2);
          $insert_query2=str_replace('{LastName}', $LastName, $insert_query2);
          $insert_query2=str_replace('{FirstName}', $FirstName, $insert_query2);
          $insert_query2=str_replace('{OtherName}', $OtherName, $insert_query2);
          $insert_query2=str_replace('{Gender}', $Gender, $insert_query2);
          $insert_query2=str_replace('{MaritalStatus}', $MaritalStatus, $insert_query2);
          $insert_query2=str_replace('{DOB}', $DOB, $insert_query2);
          $insert_query2=str_replace('{EmailPersonal}', $EmailPersonal, $insert_query2);
          $insert_query2=str_replace('{EVInternal}', $EVInternal, $insert_query2);
          $insert_query2=str_replace('{StreetAddress}', $StreetAddress, $insert_query2);
          $insert_query2=str_replace('{Locality}', $Locality, $insert_query2);
          $insert_query2=str_replace('{AAL1}', $AAL1, $insert_query2);
          $insert_query2=str_replace('{CountryOld}', $Country, $insert_query2);
          $insert_query2=str_replace('{PostalCode}', $PostalCode, $insert_query2);
          $insert_query2=str_replace('{Phone1LocalNumber}', $Phone1LocalNumber, $insert_query2);
          $insert_query2=str_replace('{Phone2LocalNumber}', $Phone2LocalNumber, $insert_query2);
          $insert_query2=str_replace('{AgentID}', $AgentID, $insert_query2);
          $insert_query2=str_replace('{AgencyName}', $AgencyName, $insert_query2);
          $insert_query2=str_replace('{ModifyUserID}', $ModifyUserID, $insert_query2);
          $insert_query2=str_replace('{CreateUserID}', $CreateUserID, $insert_query2);
          $insert_query2=str_replace('{CitizenshipPrimary}', $CitizenshipPrimary, $insert_query2);
          $insert_query2=str_replace('{COB}', $COB, $insert_query2);
          $insert_query2=str_replace('{StatusInCanada}', $StatusInCanada, $insert_query2);
          $t = 'y';
        }
      } elseif ($chk == 2) {
        if($row['MRelationship']){
          $i++;
          $StudentID = $row['StudentID'];
          $EmergencyContactInCanada = "0";


          $RelationshipToStudent = $row['MRelationship'];
          $RTSOther = $row['MOther'];
          $LastName = $row['MLastName'];
          $FirstName = $row['MFirstName'];
          $DOB = $row['MDOB'];
          $MaritalStatus = $row['MMarital'];
          $EmailPersonal = $row['MEmail'];
          $EVInternal = $row['MEmailVerified'];

          $StreetAddress = $row['MAddress1']." ".$row['MAddress2'];
          $StreetAddress = str_replace("'", "''", $StreetAddress);
          // $StreetAddress = htmlspecialchars($StreetAddress, ENT_QUOTES);

          $Locality = $row['MCity'];
          $Locality = str_replace("'", "''", $Locality);

          $AAL1 = $row['MProvince'];
          $AAL1 = str_replace("'", "''", $AAL1);

          $Country = $row['MCountry'];
          $Country = str_replace("'", "''", $Country);

          $PostalCode = $row['MPostalCode'];

          if($row['MRelationship'] == 'MO'){
            $Gender = 'F';
          } elseif ($row['MRelationship'] == 'FA') {
            $Gender = 'M';
          } else {
            $Gender = 'Z';
          }

          $PostalCode = str_replace("'", "''", $PostalCode);

          $Gender = str_replace("'", "''", $Gender);

          $Phone1LocalNumber = $row['MPhone1'];
          $Phone1LocalNumber = str_replace("'", "''", $Phone1LocalNumber);

          $Phone2LocalNumber = $row['MPhone2'];
          $Phone2LocalNumber = str_replace("'", "''", $Phone2LocalNumber);




          $OtherName = '';
          $AgentID = '';
          $AgencyName = '';
          $ModifyUserID = 'F2178';
          $CreateUserID = 'F2178';
          $CitizenshipPrimary = '';
          $COB = '';
          $StatusInCanada = '';

          $ContactTab = 'PG2';
          $insert_query2=str_replace('{ContactTab}', $ContactTab, $insert_query2);
          $insert_query2=str_replace('{StudentID}', $StudentID, $insert_query2);
          $insert_query2=str_replace('{RelationshipToStudent}', $RelationshipToStudent, $insert_query2);
          $insert_query2=str_replace('{RTSOther}', $RTSOther, $insert_query2);
          $insert_query2=str_replace('{EmergencyContactInCanada}', $EmergencyContactInCanada, $insert_query2);
          $insert_query2=str_replace('{LastName}', $LastName, $insert_query2);
          $insert_query2=str_replace('{FirstName}', $FirstName, $insert_query2);
          $insert_query2=str_replace('{OtherName}', $OtherName, $insert_query2);
          $insert_query2=str_replace('{Gender}', $Gender, $insert_query2);
          $insert_query2=str_replace('{MaritalStatus}', $MaritalStatus, $insert_query2);
          $insert_query2=str_replace('{DOB}', $DOB, $insert_query2);
          $insert_query2=str_replace('{EmailPersonal}', $EmailPersonal, $insert_query2);
          $insert_query2=str_replace('{EVInternal}', $EVInternal, $insert_query2);
          $insert_query2=str_replace('{StreetAddress}', $StreetAddress, $insert_query2);
          $insert_query2=str_replace('{Locality}', $Locality, $insert_query2);
          $insert_query2=str_replace('{AAL1}', $AAL1, $insert_query2);
          $insert_query2=str_replace('{CountryOld}', $Country, $insert_query2);
          $insert_query2=str_replace('{PostalCode}', $PostalCode, $insert_query2);
          $insert_query2=str_replace('{Phone1LocalNumber}', $Phone1LocalNumber, $insert_query2);
          $insert_query2=str_replace('{Phone2LocalNumber}', $Phone2LocalNumber, $insert_query2);
          $insert_query2=str_replace('{AgentID}', $AgentID, $insert_query2);
          $insert_query2=str_replace('{AgencyName}', $AgencyName, $insert_query2);
          $insert_query2=str_replace('{ModifyUserID}', $ModifyUserID, $insert_query2);
          $insert_query2=str_replace('{CreateUserID}', $CreateUserID, $insert_query2);
          $insert_query2=str_replace('{CitizenshipPrimary}', $CitizenshipPrimary, $insert_query2);
          $insert_query2=str_replace('{COB}', $COB, $insert_query2);
          $insert_query2=str_replace('{StatusInCanada}', $StatusInCanada, $insert_query2);
          $t = 'y';
        }

      } elseif ($chk == 3) {

        if($row['ERelationship']){
          $i++;
          $StudentID = $row['StudentID'];
          $EmergencyContactInCanada = ($row['ERelationship'] !== '')?"1":"0";


          $RelationshipToStudent = $row['ERelationship'];
          $RTSOther = $row['EOther'];
          $LastName = $row['ELastName'];
          $FirstName = $row['EFirstName'];
          $DOB = $row['EDOB'];
          $MaritalStatus = $row['EMarital'];
          $EmailPersonal = $row['EEmail'];
          $EVInternal = $row['EEmailVerified'];

          $StreetAddress = $row['EAddress1']." ".$row['EAddress2'];
          $StreetAddress = str_replace("'", "''", $StreetAddress);
          // $StreetAddress = htmlspecialchars($StreetAddress, ENT_QUOTES);

          $Locality = $row['ECity'];
          $Locality = str_replace("'", "''", $Locality);

          $AAL1 = $row['EProvince'];
          $AAL1 = str_replace("'", "''", $AAL1);

          $Country = $row['ECountry'];
          $Country = str_replace("'", "''", $Country);

          $PostalCode = $row['EPostalCode'];

          if($row['ERelationship'] == 'MO'){
            $Gender = 'F';
          } elseif ($row['ERelationship'] == 'FA') {
            $Gender = 'M';
          } else {
            $Gender = 'Z';
          }

          $PostalCode = str_replace("'", "''", $PostalCode);

          $Gender = str_replace("'", "''", $Gender);

          $Phone1LocalNumber = $row['EPhone1'];
          $Phone1LocalNumber = str_replace("'", "''", $Phone1LocalNumber);

          $Phone2LocalNumber = $row['EPhone2'];
          $Phone2LocalNumber = str_replace("'", "''", $Phone2LocalNumber);




          $OtherName = '';
          $AgentID = '';
          $AgencyName = '';
          $ModifyUserID = 'F2178';
          $CreateUserID = 'F2178';
          $CitizenshipPrimary = '';
          $COB = '';
          $StatusInCanada = '';

          $ContactTab = 'EMR';
          $insert_query2=str_replace('{ContactTab}', $ContactTab, $insert_query2);
          $insert_query2=str_replace('{StudentID}', $StudentID, $insert_query2);
          $insert_query2=str_replace('{RelationshipToStudent}', $RelationshipToStudent, $insert_query2);
          $insert_query2=str_replace('{RTSOther}', $RTSOther, $insert_query2);
          $insert_query2=str_replace('{EmergencyContactInCanada}', $EmergencyContactInCanada, $insert_query2);
          $insert_query2=str_replace('{LastName}', $LastName, $insert_query2);
          $insert_query2=str_replace('{FirstName}', $FirstName, $insert_query2);
          $insert_query2=str_replace('{OtherName}', $OtherName, $insert_query2);
          $insert_query2=str_replace('{Gender}', $Gender, $insert_query2);
          $insert_query2=str_replace('{MaritalStatus}', $MaritalStatus, $insert_query2);
          $insert_query2=str_replace('{DOB}', $DOB, $insert_query2);
          $insert_query2=str_replace('{EmailPersonal}', $EmailPersonal, $insert_query2);
          $insert_query2=str_replace('{EVInternal}', $EVInternal, $insert_query2);
          $insert_query2=str_replace('{StreetAddress}', $StreetAddress, $insert_query2);
          $insert_query2=str_replace('{Locality}', $Locality, $insert_query2);
          $insert_query2=str_replace('{AAL1}', $AAL1, $insert_query2);
          $insert_query2=str_replace('{CountryOld}', $Country, $insert_query2);
          $insert_query2=str_replace('{PostalCode}', $PostalCode, $insert_query2);
          $insert_query2=str_replace('{Phone1LocalNumber}', $Phone1LocalNumber, $insert_query2);
          $insert_query2=str_replace('{Phone2LocalNumber}', $Phone2LocalNumber, $insert_query2);
          $insert_query2=str_replace('{AgentID}', $AgentID, $insert_query2);
          $insert_query2=str_replace('{AgencyName}', $AgencyName, $insert_query2);
          $insert_query2=str_replace('{ModifyUserID}', $ModifyUserID, $insert_query2);
          $insert_query2=str_replace('{CreateUserID}', $CreateUserID, $insert_query2);
          $insert_query2=str_replace('{CitizenshipPrimary}', $CitizenshipPrimary, $insert_query2);
          $insert_query2=str_replace('{COB}', $COB, $insert_query2);
          $insert_query2=str_replace('{StatusInCanada}', $StatusInCanada, $insert_query2);
          $t = 'y';
        }

      } elseif ($chk == 4) {
        if($row['GRelationship']){
        $i++;
        $StudentID = $row['StudentID'];
        $EmergencyContactInCanada = "0";


        $RelationshipToStudent = $row['GRelationship'];
        $RTSOther = $row['GOther'];
        $LastName = $row['GLastName'];
        $FirstName = $row['GFirstName'];
        $DOB = $row['GDOB'];
        $MaritalStatus = $row['GMarital'];
        $EmailPersonal = $row['GEmail'];
        $EVInternal = $row['GEmailVerified'];

        $StreetAddress = $row['GAddress1']." ".$row['GAddress2'];
        $StreetAddress = str_replace("'", "''", $StreetAddress);
        // $StreetAddress = htmlspecialchars($StreetAddress, ENT_QUOTES);

        $Locality = $row['GCity'];
        $Locality = str_replace("'", "''", $Locality);

        $AAL1 = $row['GProvince'];
        $AAL1 = str_replace("'", "''", $AAL1);

        $Country = $row['GCountry'];
        $Country = str_replace("'", "''", $Country);

        $PostalCode = $row['GPostalCode'];

        if($row['GRelationship'] == 'MO'){
          $Gender = 'F';
        } elseif ($row['GRelationship'] == 'FA') {
          $Gender = 'M';
        } else {
          $Gender = 'Z';
        }

        $PostalCode = str_replace("'", "''", $PostalCode);

        $Gender = str_replace("'", "''", $Gender);

        $Phone1LocalNumber = $row['GPhone1'];
        $Phone1LocalNumber = str_replace("'", "''", $Phone1LocalNumber);

        $Phone2LocalNumber = $row['GPhone2'];
        $Phone2LocalNumber = str_replace("'", "''", $Phone2LocalNumber);




        $OtherName = '';
        $AgentID = '';
        $AgencyName = '';
        $ModifyUserID = 'F2178';
        $CreateUserID = 'F2178';
        $CitizenshipPrimary = '';
        $COB = '';
        $StatusInCanada = '';

        $ContactTab = 'CST';
        $insert_query2=str_replace('{ContactTab}', $ContactTab, $insert_query2);
        $insert_query2=str_replace('{StudentID}', $StudentID, $insert_query2);
        $insert_query2=str_replace('{RelationshipToStudent}', $RelationshipToStudent, $insert_query2);
        $insert_query2=str_replace('{RTSOther}', $RTSOther, $insert_query2);
        $insert_query2=str_replace('{EmergencyContactInCanada}', $EmergencyContactInCanada, $insert_query2);
        $insert_query2=str_replace('{LastName}', $LastName, $insert_query2);
        $insert_query2=str_replace('{FirstName}', $FirstName, $insert_query2);
        $insert_query2=str_replace('{OtherName}', $OtherName, $insert_query2);
        $insert_query2=str_replace('{Gender}', $Gender, $insert_query2);
        $insert_query2=str_replace('{MaritalStatus}', $MaritalStatus, $insert_query2);
        $insert_query2=str_replace('{DOB}', $DOB, $insert_query2);
        $insert_query2=str_replace('{EmailPersonal}', $EmailPersonal, $insert_query2);
        $insert_query2=str_replace('{EVInternal}', $EVInternal, $insert_query2);
        $insert_query2=str_replace('{StreetAddress}', $StreetAddress, $insert_query2);
        $insert_query2=str_replace('{Locality}', $Locality, $insert_query2);
        $insert_query2=str_replace('{AAL1}', $AAL1, $insert_query2);
        $insert_query2=str_replace('{CountryOld}', $Country, $insert_query2);
        $insert_query2=str_replace('{PostalCode}', $PostalCode, $insert_query2);
        $insert_query2=str_replace('{Phone1LocalNumber}', $Phone1LocalNumber, $insert_query2);
        $insert_query2=str_replace('{Phone2LocalNumber}', $Phone2LocalNumber, $insert_query2);
        $insert_query2=str_replace('{AgentID}', $AgentID, $insert_query2);
        $insert_query2=str_replace('{AgencyName}', $AgencyName, $insert_query2);
        $insert_query2=str_replace('{ModifyUserID}', $ModifyUserID, $insert_query2);
        $insert_query2=str_replace('{CreateUserID}', $CreateUserID, $insert_query2);
        $insert_query2=str_replace('{CitizenshipPrimary}', $CitizenshipPrimary, $insert_query2);
        $insert_query2=str_replace('{COB}', $COB, $insert_query2);
        $insert_query2=str_replace('{StatusInCanada}', $StatusInCanada, $insert_query2);
        $t = 'y';
        }
      }


      $tQuery .= $insert_query2."\n";

      if($t == 'y'){
        $tQuery2 .= $insert_query2."<BR />";
      }


   }
   // $stmt2 = $conn->prepare($tQuery);
   // $stmt2->execute();

   echo $i."Number <br />".$tQuery2;
}




?>
