<?php

$_SQL = array(
    'staff-list' => "SELECT
                    	  StaffID
                    	, CurrentStaff
                    	, Username
                    	, Phone1
                    	, ExtNo
                    	, FirstName
                    	, LastName
                    	, Email3
                    	, CONVERT(char(10), JoinDate, 126) as JoinDate
                    	, FullPart
                    	, CASE Department
                    		WHEN 1 THEN 'Administration'
                    		WHEN 2 THEN 'Teachers'
                    		WHEN 3 THEN 'Sat-E Instructor'
                    		WHEN 4 THEN 'Student Services'
                    		WHEN 5 THEN 'Boarding-FT'
                    		WHEN 6 THEN 'Boarding-PT'
                    		WHEN 7 THEN 'Support' END as Department
                    	, PositionTitle
                    FROM
                    	tblStaff
                    WHERE
                    	CurrentStaff = 'Y' and SchoolID = 'BHS'-- and Department in ('1','2','4','5','6')
                    ORDER BY
                    	SchoolID asc
                    	, Department asc
                    	, PositionTitle asc
                    	, Email3 asc",

      'student-list' => "SELECT s.StudentID,
                          FirstName,
                          LastName,
                          EnglishName,
                          SchoolEmail,
                          CONVERT(char(10), ReportToSchoolDate, 126) as ReportToSchoolDate,
                          i.expectedterm
                          FROM tblBHSStudent as s
                          LEFT Join tblBHSStudentInfo as i on s.StudentID = i.StudentID
                          WHERE SchoolID = 'BHS' AND CurrentStudent = 'Y' ",

      'incoming-student-list' => "SELECT *
                                  FROM tblBHSStudent
																	where CurrentStudent = 'A' and EnrolmentDate >= '2019-01-02'",

			'device-list' => "SELECT
													d.StudentID,
													s.FirstName + ' ' + s.LastName as FullName,
													s.EnglishName,
													s.CurrentStudent,
													d.DeviceID,
													d.DeviceCategory,
													d.BHSDNo,
													d.DeviceType,
													d.MACAddress,
													d.Network,
													d.NetworkRegStatus,
													d.DeviceStatus
												FROM
												tblBHSStudentEndDevice as d
												LEFT JOIN
												tblBHSStudent as s
												ON
													d.StudentID = s.StudentID
												ORDER BY
													s.StudentID asc, d.DeviceID asc",

      'insert-message' => "INSERT INTO tblBHSMessageHeader (MsgCategory,MsgType,MsgStatusCode,FromType,FromSystem,FromDept,FromStaffID,FromStaffEmail,FromSysEmail,Subject,Body,BodyFormat,BodyHTML,Attachment,ToType,ToScope,ToParentWeb,ToParentMobile,ToStudentWeb,ToStudentMobile,ToFrontPage,
        Alert,AlertLevel,PublishDate,Expiry,ExpiryDate,ModifyDate,ModifyUserID,CreateDate,CreateUserID)
        VALUES(:MsgCategory,:MsgType,:MsgStatusCode,:FromType,:FromSystem,:FromDept,:FromStaffID,:FromStaffEmail,:FromSysEmail,:Subject,:Body,:BodyFormat,:BodyHTML,:Attachment,:ToType,:ToScope,:ToParentWeb,:ToParentMobile,:ToStudentWeb,:ToStudentMobile,:ToFrontPage,
          :Alert,:AlertLevel,:PublishDate,:Expiry,:ExpiryDate,:ModifyDate,:ModifyUserID,:CreateDate,:CreateUserID)",

      'token-list' => "SELECT * FROM tblBHSMobilePushToken WHERE Source != 'mybodwell_expo'",

      'message-list' => "SELECT H.*, CONCAT(S.FirstName,' ',S.LastName) AS FromStaffName,
      SemesterName = (SELECT TOP 1 M.SemesterName From tblBHSSemester AS M WHERE H.PublishDate BETWEEN M.StartDate AND M.NextStartDate)
        FROM tblBHSMessageHeader AS H
      LEFT JOIN tblStaff S ON S.StaffID = H.FromStaffID
      WHERE H.MsgType = 'app_notify' AND H.MsgStatusCode = 'sent'",

      'delete-message' => "DELETE FROM tblBHSMessageHeader WHERE MessageID = :MessageID",

	  'update-message' => "UPDATE tblBHSMessageHeader
   SET MsgCategory = :MsgCategory, Subject = :Subject, Body = :Body,
    ToFrontPage = :ToFrontPage, Expiry = :Expiry, ExpiryDate = :ExpiryDate, ModifyDate = :ModifyDate,
    ModifyUserID = :ModifyUserID
    WHERE MessageID = :MessageID",

	  'get-staff-FullName' => "SELECT CONCAT(FirstName, ' ', LastName) FullName FROM tblStaff WHERE StaffID = :StaffID",

	  'term-list' => "SELECT SemesterID,SemesterName
          ,CONVERT(char(10), StartDate, 126) as StartDate
          ,CONVERT(char(10), EndDate, 126) as EndDate
          ,CONVERT(char(10), MidCutOffDate, 126) as MidCutOffDate
          ,CurrentSemester
          ,FExam1
          ,FExam2
          ,CONVERT(char(10), NextStartDate, 126) as NextStartDate
    FROM tblBHSSemester
    WHERE SemesterID BETWEEN 70 AND (SELECT SemesterID FROM tblBHSSemester WHERE CurrentSemester = 'Y')
    ORDER BY SemesterID DESC",

    'parents-email-list' => "SELECT S.StudentID
	  ,S.FirstName
	  ,S.LastName
	  ,S.EnglishName
	  ,S.PFirstName
	  ,S.PLastName
	  ,CASE S.PRelationship
		WHEN 'FA' THEN 'Father'
		WHEN 'MO' THEN 'Mother'
		WHEN 'MG' THEN 'Male Gauardian'
		WHEN 'FG' THEN 'Female Guardian'
		END AS PRelationship
	  ,S.PEmail
	  ,S.PEmailVerified
	  ,S.MFirstName
	  ,S.MLastName
	  ,S.MRelationship
	  ,S.MEmail
	  ,S.MEmailVerified
    ,A.LoginIDParent
    ,A.PW2
    ,A.VerificationEmail
  FROM tblBHSStudent S
  LEFT JOIN tblBHSUserAuth A ON S.StudentID = A.UserID
  WHERE S.CurrentStudent = 'Y' AND S.StudentID NOT IN (201700339,
201800281,
201900044,
201800314,
201800093,
201800381,
201800061,
201900054,
201800032,
201600303,
201900205,
201900237,
201700168,
201900081,
201800359,
201900069
)",

  'insert-message-result' => "INSERT INTO tblBHSMessageResult
             (MessageID
             ,MsgCategory
             ,MsgType
             ,MsgStatusCode
             ,FromType
             ,FromVerifyCode
             ,ToType
             ,ToEmail
             ,ToVerifyCode
             ,IntReturnCode1
             ,IntReturnCode2
             ,IntReturnCode3
             ,ExtReturnCode1
             ,ExtReturnCode2
             ,ExtReturnCode3
             ,EmailSMTP)
       VALUES
             ('{MessageID}'
             ,'{MsgCategory}'
             ,'{MsgType}'
             ,'{MsgStatusCode}'
             ,'{FromType}'
             ,'{FromVerifyCode}'
             ,'{ToType}'
             ,'{ToEmail}'
             ,'{ToVerifyCode}'
             ,'{IntReturnCode1}'
             ,'{IntReturnCode2}'
             ,'{IntReturnCode3}'
             ,'{ExtReturnCode1}'
             ,'{ExtReturnCode2}'
             ,'{ExtReturnCode3}'
             ,'{EmailSMTP}')",

  'insert-notification-log' => "INSERT INTO tblBHSMobilePushLog
            (Num,
            SentUser)
      VALUES
            (:num,
            :staffId)",

  'update-message-statusCode' => "UPDATE tblBHSMessageHeader
                                 SET MsgStatusCode = :MsgStatusCode,
                                     ModifyUserID = :ModifyUserID,
                                     ModifyDate = :ModifyDate
                               WHERE MessageID = :MessageID"

);

?>
