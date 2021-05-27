<?php


$conn = new PDO($dsn);
$query = "SELECT Distinct A.ApplicationID, A.FirstName,
A.LastName1, A.CountryOfBirth,
A.FirstLanguage, S.RelationshipToStudent, A.GradeApplied,
A.ResidenceType, A.ApplicationStatus, CONCAT( DAO.FirstName, ' ' ,DAO.LastName ) AdmissionOfficer
,CONCAT(DMM.FirstName, ' ', DMM.LastName) Marketer,
(SELECT TOP 1 CommentText FROM tblBHSApplicationComments WHERE InterviewComment = 0 AND ApplicationID = A.ApplicationID) AS Comment,
(SELECT TOP 1 CommentText FROM tblBHSApplicationComments WHERE InterviewComment = 1 AND ApplicationID = A.ApplicationID) AS InterViewComment,
A.CreateDate SubmittedOn, A.AcceptedDate, A.RegisteredDate,
CASE WHEN (SELECT count(DocumentID) FROM tblBHSApplicationDocuments WHERE DocumentType = 'Application Form' AND ApplicationID = A.ApplicationID) > 0 THEN 'Y' ELSE 'N' END AS ApplicationUploaded,
CASE WHEN (SELECT count(DocumentID) FROM tblBHSApplicationDocuments WHERE DocumentType = 'Passport Copy' AND ApplicationID = A.ApplicationID) > 0 THEN 'Y' ELSE 'N' END AS PassportUploaded,
CASE WHEN (SELECT count(DocumentID) FROM tblBHSApplicationDocuments WHERE DocumentType = 'Current Digital Passport Size Photo' AND ApplicationID = A.ApplicationID) > 0 THEN 'Y' ELSE 'N' END AS CurrentPassPortSizePhotoUploaded,
CASE WHEN (SELECT count(DocumentID) FROM tblBHSApplicationDocuments WHERE DocumentType = 'Transcripts and Progress Reports' AND ApplicationID = A.ApplicationID) > 0 THEN 'Y' ELSE 'N' END AS TranscriptUploaded,
CASE WHEN (SELECT count(DocumentID) FROM tblBHSApplicationDocuments WHERE DocumentType = 'Teacher Reference Letter' AND ApplicationID = A.ApplicationID) > 0 THEN 'Y' ELSE 'N' END AS TeacherReferenceLetterUploaded,
CASE WHEN (SELECT count(DocumentID) FROM tblBHSApplicationDocuments WHERE DocumentType = 'Immunization Recordr' AND ApplicationID = A.ApplicationID) > 0 THEN 'Y' ELSE 'N' END AS ImmunizationRecordUploaded
FROM tblBHSApplication A
LEFT JOIN tblBHSApplicationUser S ON A.LoginID = S.LoginID
LEFT JOIN tblBHSApplicationConfigStaff U ON U.CitizenshipPrimary = A.CitizenshipPrimary
LEFT JOIN tblBHSApplicationAdminUser DAO on DAO.StaffID = U.StaffIDAO
LEFT JOIN tblBHSApplicationAdminUser DMM on DMM.StaffID = U.StaffIDMM
WHERE SemesterApplied = 'Fall 2019'";

$stmt = $conn->prepare($query);


$tr = '';
if ($stmt->execute()) {
  $i = 0;
    while ($row = $stmt->fetch()) {
      $i++;
      $ApplicationID = $row['ApplicationID'];
      $FirstName = $row['FirstName'];
      $LastName = $row['LastName1'];
      $CountryOfBirth = $row['CountryOfBirth'];
      $FirstLanguage = $row['FirstLanguage'];
      $RelationshipToStudent = $row['RelationshipToStudent'];
      $GradeApplied = $row['GradeApplied'];
      $ResidenceType = $row['ResidenceType'];
      $ApplicationStatus = $row['ApplicationStatus'];
      $AdmissionOfficer = $row['AdmissionOfficer'];
      $Marketer = $row['Marketer'];
      $Comment = $row['Comment'];
      $InterViewComment = $row['InterViewComment'];
      $SubmittedOn = $row['SubmittedOn'];
      $AcceptedDate = $row['AcceptedDate'];
      $RegisteredDate = $row['RegisteredDate'];
      $ApplicationUploaded = $row['ApplicationUploaded'];
      $PassportUploaded = $row['PassportUploaded'];
      $CurrentPassPortSizePhotoUploaded = $row['CurrentPassPortSizePhotoUploaded'];
      $TranscriptUploaded = $row['TranscriptUploaded'];
      $TeacherReferenceLetterUploaded = $row['TeacherReferenceLetterUploaded'];
      $ImmunizationRecordUploaded = $row['ImmunizationRecordUploaded'];

      $tr .= "<tr>
      <td>$ApplicationID</td><td>$FirstName</td><td>$LastName</td>
      <td>$CountryOfBirth</td><td>$FirstLanguage</td><td>$RelationshipToStudent</td><td>$GradeApplied</td>
      <td>$ResidenceType</td><td>$ApplicationStatus</td><td>$AdmissionOfficer</td><td>$Marketer</td>
      <td>$Comment</td><td>$InterViewComment</td><td>$SubmittedOn</td><td>$AcceptedDate</td>
      <td>$RegisteredDate</td><td>$ApplicationUploaded</td><td>$PassportUploaded</td><td>$CurrentPassPortSizePhotoUploaded</td>
      <td>$TranscriptUploaded</td><td>$TeacherReferenceLetterUploaded</td><td>$ImmunizationRecordUploaded</td>
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
        <th>FirstName</th>
        <th>LastName</th>
        <th>CountryOfBirth</th>
        <th>FirstLanguage</th>
        <th>RelationshipToStudent</th>
        <th>GradeApplied</th>
        <th>ResidenceType</th>
        <th>ApplicationStatus</th>
        <th>AdmissionOfficer</th>
        <th>Marketer</th>
        <th>Comment</th>
        <th>InterViewComment</th>
        <th>SubmittedOn</th>
        <th>AcceptedDate</th>
        <th>RegisteredDate</th>
        <th>ApplicationUploaded</th>
        <th>PassportUploaded</th>
        <th>CurrentPassPortSizePhotoUploadedt</th>
        <th>TranscriptUploaded</th>
        <th>TeacherReferenceLetterUploaded</th>
        <th>ImmunizationRecordUploaded</th>
      </thead>
      <tbody>
        <?=$tr?>
      </tbody>
    </table>

  </body>
</html>
