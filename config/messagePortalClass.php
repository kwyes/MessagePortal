<?php

session_start();
const EXPO_API_URL = 'https://exp.host/--/api/v2/push/send';

require_once 'sql.php';
require_once 'sendEmailClass.php';
class messagePortalClass extends DBController {
    function getSql($name) {
        global $_SQL;
        return $_SQL[$name];
    }


    public function sendMessage($emailArr, $msgType, $toType, $category, $title, $parentsAuthCheck, $body, $plain){
      $c = new messagePortalClass();
      $expiry = 0;
      $expiryDate = '';
      $pmCheck = 0;
      $post = 0;
      $publish = '';
      $publishAt = date('Y-m-d H:i:s');
      $pwCheck = 0;
      $smCheck = 0;
      $swCheck  = 0;
      $msgStatusCode = 'sent';
      $fromType = 'int_user_staff_admin';
      $fromSystem = 'sas_admin';
      $fromDept = 'administration_school_mgmt';
      $toScope = 'everyone';
      $saveMessage = $c->saveMessage($body, $plain, $category, $expiry, $expiryDate,
         $pmCheck, $post, $publish, $publishAt, $pwCheck, $smCheck,
         $swCheck, $title, $msgType,$msgStatusCode,$fromType,
         $fromSystem,$fromDept,$toType,$toScope);

       $stmt2 = $this->db->prepare("SELECT TOP 1 MessageID FROM tblBHSMessageHeader ORDER BY MessageID DESC");
       $stmt2->execute();
       $row2 = $stmt2->fetch();
       $tmp['id'] = $row2['MessageID'];

       $sendEmail = $c->sendEmailFromAjax($emailArr, $title, $row2['MessageID'], $category, $msgType, $MsgStatusCode, $fromType, 'verified_internal', $toType, 'verified_internal', 'job_completed', '', '', '','','','');
       $resultList = $sendEmail['resultList'];


       $test['body'] = $body;
       $test['plain'] = $plain;
       $test['category'] = $category;
       $test['expiry'] = $expiry;
       $test['expiryDate'] = $expiryDate;
       $test['pmCheck'] = $pmCheck;
       $test['pmCheck'] = $pmCheck;
       $test['post'] = $post;
       $test['publish'] = $publish;
       $test['publishAt'] = $publishAt;
       $test['pwCheck'] = $pwCheck;
       $test['smCheck'] = $smCheck;
       $test['swCheck'] = $swCheck;
       $test['title'] = $title;
       $test['msgType'] = $msgType;
       $test['msgStatusCode'] = $msgStatusCode;
       $test['fromType'] = $fromType;
       $test['fromSystem'] = $fromSystem;
       $test['fromDept'] = $fromDept;
       $test['toType'] = $toType;
       $test['toScope'] = $toScope;


       $response['result'] = 1;
       $response['size'] = sizeof($emailArr);
       return $response;
    }

    public function insertMessageResult($MessageID,$MsgCategory,$MsgType,$MsgStatusCode,$FromType,$FromVerifyCode,$ToType,$ToEmail,$ToVerifyCode,$IntReturnCode1,$IntReturnCode2,$IntReturnCode3,$ExtReturnCode1,$ExtReturnCode2,$ExtReturnCode3,$EmailSMTP) {

      $query = $this->getSql('insert-message-result');

      $query=str_replace('{MessageID}', $MessageID, $query);
      $query=str_replace('{MsgCategory}', $MsgCategory, $query);
      $query=str_replace('{MsgType}', $MsgType, $query);
      $query=str_replace('{MsgStatusCode}', $MsgStatusCode, $query);
      $query=str_replace('{FromType}', $FromType, $query);
      $query=str_replace('{FromVerifyCode}', $FromVerifyCode, $query);
      $query=str_replace('{ToType}', $ToType, $query);
      $query=str_replace('{ToEmail}', $ToEmail, $query);
      $query=str_replace('{ToVerifyCode}', $ToVerifyCode, $query);
      $query=str_replace('{IntReturnCode1}', $IntReturnCode1, $query);
      $query=str_replace('{IntReturnCode2}', $IntReturnCode2, $query);
      $query=str_replace('{IntReturnCode3}', $IntReturnCode3, $query);
      $query=str_replace('{ExtReturnCode1}', $ExtReturnCode1, $query);
      $query=str_replace('{ExtReturnCode2}', $ExtReturnCode2, $query);
      $query=str_replace('{ExtReturnCode3}', $ExtReturnCode3, $query);
      $query=str_replace('{EmailSMTP}', $EmailSMTP, $query);
      $stmt = $this->db->prepare($query);

      if ($stmt->execute()) {
          $response = array();
          $tmp = array();
          $tmp['result'] = 1;
          array_push($response, $tmp);
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();

    }

    public function sendEmailFromAjax($emailArr, $title, $MessageID,$MsgCategory,$MsgType,$MsgStatusCode,$FromType,$FromVerifyCode,$ToType,$ToVerifyCode,$IntReturnCode1,$IntReturnCode2,$IntReturnCode3,$ExtReturnCode1,$ExtReturnCode2,$ExtReturnCode3,$EmailSMTP) {
        $from = array('email' => 'no-reply@bodwell.edu', 'name' => 'No Reply');
        for ($i=339; $i < sizeof($emailArr); $i++) {
          $firstName = $emailArr[$i]['PFirstName'];
          $lastName = $emailArr[$i]['PLastName'];
          $email = $emailArr[$i]['Email'];
          $sfirstName = $emailArr[$i]['FirstName'];
          $slastName = $emailArr[$i]['LastName'];
          $relationship = $emailArr[$i]['PRelationship'];
          $pw = $emailArr[$i]['PW2'];
          $loginid = $emailArr[$i]['LoginIDParent'];
          $c = new messagePortalClass();
          $body  = $c->createAuthEmailBody($firstName,$lastName,$email,$sfirstName,$slastName,$relationship,$pw,$loginid);

          $subject = $title;
          $to = array(
              array('email' => $email, 'name' => "{$firstName} {$lastName}")
          );
          $cc = array();
          $res = sendEmail($from, $to, $cc, $subject, $body);
          $response['resultList'][$i]['email'] = $email;
          $response['resultList'][$i]['res'] = $res;

          if($response['resultList'][$i]['res'] == true){
            $MsgStatusCode = 'sent_success';
          } else {
            $MsgStatusCode = 'sent_fail';
          }

          $c->insertMessageResult($MessageID,$MsgCategory,$MsgType,$MsgStatusCode,$FromType,$FromVerifyCode,$ToType,$response['resultList'][$i]['email'],$ToVerifyCode,$IntReturnCode1,$IntReturnCode2,$IntReturnCode3,$ExtReturnCode1,$ExtReturnCode2,$ExtReturnCode3,$EmailSMTP);


        }
        $response['result'] = 1;
        return $response;
    }

    public function createAuthEmailBody($firstName,$lastName,$email,$sfirstName,$slastName,$relationship,$pw,$loginid) {
      $body = "<p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:106%;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;text-align:center;'>".
        "<img width='666' src='https://admin.bodwell.edu/MsgCtr/assets/img/emailHeader.jpg'>".
      "</p>".
      "<br />".
      "<p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:106%;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;'><span style='font-family:&quot;Arial&quot;,sans-serif;'>Dear parent/guardian of <strong>$firstName $lastName</strong>, please find your <strong>MyBodwell Mobile App</strong> login information below.</span></p>".
      "<p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:106%;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;'><span style='font-family:&quot;Arial&quot;,sans-serif;'>===============================</span></p>".
      "<p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:106%;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;'><span style='font-family:&quot;Arial&quot;,sans-serif;'>IMPORTANT NOTICE</span></p>".
      "<p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:106%;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;'><span style='font-family:&quot;Arial&quot;,sans-serif;'>===============================</span></p>".
      "<p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:106%;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;'><em><span style='font-family:&quot;Arial&quot;,sans-serif;color:red;'>Please keep your username and password secured to protect your child’s data from unauthorized access!</span></em></p>".
      "<br />".
      "<p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:106%;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;'><span style='font-family:&quot;Arial&quot;,sans-serif;'>===============================</span></p>".
      "<p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:106%;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;'><span style='font-family:&quot;Arial&quot;,sans-serif;'>STUDENT INFO</span></p>".
      "<p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:106%;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;'><span style='font-family:&quot;Arial&quot;,sans-serif;'>===============================</span></p>".
      "<ul style='margin-bottom:0cm;margin-top:0cm;' type='disc'>".
        "<li style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:106%;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;'><span style='font-family:&quot;Arial&quot;,sans-serif;'>Student's First Name: <strong>$sfirstName</strong></span></li>".
        "<li style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:106%;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;'><span style='font-family:&quot;Arial&quot;,sans-serif;'>Student's Last Name: <strong>$slastName</strong></span></li>".
      "</ul>".
      "<br />".
      "<p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:106%;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;'><span style='font-family:&quot;Arial&quot;,sans-serif;'>===============================</span></p>".
      "<p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:106%;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;'><span style='font-family:&quot;Arial&quot;,sans-serif;'>PARENT INFO</span></p>".
      "<p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:106%;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;'><span style='font-family:&quot;Arial&quot;,sans-serif;'>===============================</span></p>".
      "<ul style='margin-bottom:0cm;margin-top:0cm;' type='disc'>".
        "<li style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:106%;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;'><span style='font-family:&quot;Arial&quot;,sans-serif;'>Parent's First Name: <strong>$firstName</strong></span></li>".
        "<li style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:106%;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;'><span style='font-family:&quot;Arial&quot;,sans-serif;'>Parent's Last Name: <strong>$lastName</strong></span></li>".
        "<li style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:106%;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;'><span style='font-family:&quot;Arial&quot;,sans-serif;'>Relationship to Student: <strong>$relationship</strong></span></li>".
        "<li style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:106%;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;'><span style='font-family:&quot;Arial&quot;,sans-serif;'>Parent Email Address:".
            "<a href='mailto:$email'>$email</a>".
          "</span></li>".
      "</ul>".
      "<br />".
      "<p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:106%;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;'><span style='font-family:&quot;Arial&quot;,sans-serif;'>===============================</span></p>".
      "<p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:106%;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;'><span style='font-family:&quot;Arial&quot;,sans-serif;'>WHERE TO DOWNLOAD MOBILE APP</span></p>".
      "<p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:106%;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;'><span style='font-family:&quot;Arial&quot;,sans-serif;'>===============================</span></p>".
      "<div style='display:flex'>".
        "<div>".
          "<a href='https://apps.apple.com/us/app/mybodwell-mobile/id1486680935'><img src='https://admin.bodwell.edu/MsgCtr/assets/img/appstore.png' width='150px'/></a>".
        "</div>".
        "<div>".
          "<a href='https://play.google.com/store/apps/details?id=app.bodwell.com'><img src='https://admin.bodwell.edu/MsgCtr/assets/img/googleplay.png' width='150px'/></a>".
        "</div>".
      "</div>".
      "<br />".
      "<p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:106%;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;'><span style='font-family:&quot;Arial&quot;,sans-serif;'>===============================</span></p>".
      "<p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:106%;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;'><span style='font-family:&quot;Arial&quot;,sans-serif;'>LOGIN INFO</span></p>".
      "<p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:106%;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;'><span style='font-family:&quot;Arial&quot;,sans-serif;'>===============================</span></p>".
      "<ul style='margin-bottom:0cm;margin-top:0cm;' type='disc'>".
        "<li style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:106%;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;'><span style='font-family:&quot;Arial&quot;,sans-serif;'>Username (Parent):&nbsp;</span><span style='font-family:&quot;Courier New&quot;;'>$loginid</span></li>".
        "<li style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:106%;font-size:15px;font-family:&quot;Calibri&quot;,sans-serif;'><span style='font-family:&quot;Arial&quot;,sans-serif;'>Password (Parent):&nbsp;</span><span style='font-family:&quot;Courier New&quot;;'>$pw</span></li>".
      "</ul>";

      return $body;
    }

    public function getParentsEmailList() {
      $query = $this->getSql('parents-email-list');
      $stmt = $this->db->prepare($query);
      if ($stmt->execute()) {
        $i=0;
          while ($row = $stmt->fetch()) {

              if($row['PEmailVerified'] == 1) {
                $response[$i]['Email'] = $row['PEmail'];
                $response[$i]['FirstName'] = $row['FirstName'];
                $response[$i]['LastName'] = $row['LastName'];
                $response[$i]['EnglishName'] = $row['EnglishName'];
                $response[$i]['PFirstName'] = $row['PFirstName'];
                $response[$i]['PLastName'] = $row['PLastName'];
                $response[$i]['PRelationship'] = $row['PRelationship'];
                $response[$i]['LoginIDParent'] = $row['LoginIDParent'];
                $response[$i]['PW2'] = $row['PW2'];
                $i++;
              }

              // if($row['MEmailVerified'] == 1) {
              //   $response[$row['MEmail']]['FirstName'] = $row['FirstName'];
              //   $response[$row['MEmail']]['LastName'] = $row['LastName'];
              //   $response[$row['MEmail']]['EnglishName'] = $row['EnglishName'];
              //   $response[$row['MEmail']]['PFirstName'] = $row['MFirstName'];
              //   $response[$row['MEmail']]['PLastName'] = $row['MLastName'];
              //   $response[$row['MEmail']]['PRelationship'] = $row['MRelationship'];
              //   $response[$row['MEmail']]['LoginIDParent'] = $row['LoginIDParent'];
              //   $response[$row['MEmail']]['PW2'] = $row['PW2'];
              // }

         }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    public function saveMessage($body, $plain, $category, $expiry, $expiryDate, $pmCheck, $post, $publish, $publishAt, $pwCheck, $smCheck, $swCheck, $title, $msgType,$msgStatusCode,$fromType,$fromSystem,$fromDept,$toType,$toScope){
      $MsgCategory = $category;
      $staffId = $_SESSION['staffId'];
      $MsgType = $msgType;
      $MsgStatusCode = $msgStatusCode;
      $FromType = $fromType;
      $FromSystem = $fromSystem;
      $FromDept = $fromDept;
      $FromStaffID = $staffId;
      $FromStaffEmail = $_SESSION['staffEmail'];
      $FromSysEmail = '';
      $Subject = $title;
      $Body = $body;
      $BodyFormat = 'HTML';
      $Attachment = 0;
      $ToType = $toType;
      $ToScope = $toScope;
      $ToParentWeb = ($pwCheck === 'true') ? 1 : 0;
      $ToParentMobile = ($pmCheck === 'true') ? 1 : 0;
      $ToStudentWeb = ($swCheck === 'true') ? 1 : 0;
      $ToStudentMobile = ($smCheck === 'true') ? 1 : 0;
      $ToFrontPage = $post;
      $Alert = 1;
      $AlertLevel = 'H';
      $Expiry = $expiry;
      $ExpiryDate = date("Y-m-d H:i:s", strtotime($expiryDate));
      $publishAt = date("Y-m-d H:i:s", strtotime($publishAt));
      $ModifyDate = date('Y-m-d H:i:s');
      $CreateDate = date('Y-m-d H:i:s');
      $query = $this->getSql('insert-message');

      $stmt = $this->db->prepare($query);
      $stmt->bindValue(":MsgCategory", $MsgCategory);
      $stmt->bindValue(":MsgType", $MsgType);
      $stmt->bindValue(":MsgStatusCode", $MsgStatusCode);
      $stmt->bindValue(":FromType", $FromType);
      $stmt->bindValue(":FromSystem", $FromSystem);
      $stmt->bindValue(":FromDept", $FromDept);
      $stmt->bindValue(":FromStaffID", $FromStaffID);
      $stmt->bindValue(":FromStaffEmail", $FromStaffEmail);
      $stmt->bindValue(":FromSysEmail", $FromSysEmail);
      $stmt->bindValue(":Subject", $Subject);
      $stmt->bindValue(":Body", $Body);
      $stmt->bindValue(":BodyFormat", $BodyFormat);
      $stmt->bindValue(":BodyHTML", $plain);
      $stmt->bindValue(":Attachment", $Attachment);
      $stmt->bindValue(":ToType", $ToType);
      $stmt->bindValue(":ToScope", $ToScope);
      $stmt->bindValue(":ToParentWeb", $ToParentWeb);
      $stmt->bindValue(":ToParentMobile", $ToParentMobile);
      $stmt->bindValue(":ToStudentWeb", $ToStudentWeb);
      $stmt->bindValue(":ToStudentMobile", $ToStudentMobile);
      $stmt->bindValue(":ToFrontPage", $ToFrontPage);
      $stmt->bindValue(":Alert", $Alert);
      $stmt->bindValue(":AlertLevel", $AlertLevel);
      $stmt->bindValue(":Expiry", $Expiry);
      $stmt->bindValue(":ExpiryDate", $ExpiryDate);
      $stmt->bindValue(":PublishDate", $publishAt);
      $stmt->bindValue(":ModifyDate", $ModifyDate);
      $stmt->bindValue(":ModifyUserID", $staffId);
      $stmt->bindValue(":CreateDate", $CreateDate);
      $stmt->bindValue(":CreateUserID", $staffId);

      if ($stmt->execute()) {
          $response = array();
          $tmp = array();

          if($MsgType == 'app_notify') {
            $c = new messagePortalClass();
            $tokenList = $c->getTokenList();
            $chunkList = array_chunk($tokenList, 50);
            for ($i=0; $i < sizeof($chunkList); $i++) {
              // $temmptokenList = addslashes(urldecode(json_encode($chunkList[$i], true)));
              $temmptokenList = $chunkList[$i];
              $result = $c->pushNotification($temmptokenList, $Subject);
            }
            $size = sizeof($tokenList);
            $c->insertNotificationLog($size, $staffId);
            $tmp['array'] = json_encode($tokenList);
          }
          $tmp['result'] = 1;
          $tmp['size'] = $size;
          array_push($response, $tmp);
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();

    }

    public function insertNotificationLog($num, $staffId) {
      $query = $this->getSql('insert-notification-log');
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(":num", $num);
      $stmt->bindValue(":staffId", $staffId);

      if ($stmt->execute()) {
          $response['result'] = 1;
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    public function getTokenList() {
      $query = $this->getSql('token-list');
      $stmt = $this->db->prepare($query);
      $response = array();
      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            // $response[] =  trim(preg_replace('/\s+/', ' ', $row['Token']));
            array_push($response, $row['Token']);
            // $response[] =  $row['Token'];
         }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    public function getMessageList() {
      $query = $this->getSql('message-list');
      $stmt = $this->db->prepare($query);
      if ($stmt->execute()) {
          while ($row = $stmt->fetch()) {
            $response[] =  $row;
         }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    public function GetUserName($id){
      $query = $this->getSql('get-staff-FullName');
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(":StaffID", $id);
      if ($stmt->execute()) {
        $row = $stmt->fetch();
        $response[] = $row;
        return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    public function updateMessage($body, $edate, $expires, $frontpage, $msgCategory, $msgId, $subject) {
      $staffId = $_SESSION['staffId'];
      $ExpiryDate = date("Y-m-d H:i:s", strtotime($edate));
      $ModifyDate = date('Y-m-d H:i:s');
      $query = $this->getSql('update-message');
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(":MsgCategory", $msgCategory);
      $stmt->bindValue(":Subject", $subject);
      $stmt->bindValue(":Body", $body);
      $stmt->bindValue(":ToFrontPage", $frontpage);
      $stmt->bindValue(":Expiry", $expires);
      $stmt->bindValue(":ExpiryDate", $ExpiryDate);
      $stmt->bindValue(":ModifyDate", $ModifyDate);
      $stmt->bindValue(":ModifyUserID", $staffId);
      $stmt->bindValue(":MessageID", $msgId);

      if ($stmt->execute()) {
          $response['result'] = 1;
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    public function currentterm(){
      $query = $this->getSql('term-list');
      $stmt = $this->db->prepare($query);
      if ($stmt->execute()) {
          $response = array();
          while ($row = $stmt->fetch()) {
            $tmp = array();
            $tmp["SemesterID"] = $row["SemesterID"];
            $today = date('Y-m-d');


            if($row['CurrentSemester'] == 'Y') {
                $_SESSION["SemesterID"] = $row["SemesterID"];
                $_SESSION["SemesterName"] = $row["SemesterName"];
                $_SESSION["StartDate"] = $row["StartDate"];
                $_SESSION["NextStartDate"] = $row["NextStartDate"];
                if ($today < $row["StartDate"]){
                  $txt = "Term Not Started";
                } elseif ($today >= $row["StartDate"] && $today < $row["MidCutOffDate"]) {
                  $txt = "Midterm In Progress";
                } elseif ($today >= $row["MidCutOffDate"] && $today <= $row["EndDate"]) {
                  $txt = "Final In Progress";
                } else {
                  $txt = "Term Ended";
                }
            } else {
              $txt = "Term Ended";
            }
            $_SESSION['termStatus'] = $txt;
            $tmp["termStatus"] = $txt;
            $tmp["SemesterName"] = $row["SemesterName"];
            $tmp["StartDate"] = $row["StartDate"];
            $tmp["EndDate"] = $row["EndDate"];
            $tmp["MidCutOffDate"] = $row["MidCutOffDate"];
            $tmp["FExam1"] = $row["FExam1"];
            $tmp["FExam2"] = $row["FExam2"];
            $tmp["NextStartDate"] = $row["NextStartDate"];

            array_push($response, $tmp);
         }
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();

    }

    public function updateMessageStatusCode($id, $status) {
      $staffId = $_SESSION['staffId'];
      $ModifyDate = date('Y-m-d H:i:s');

      $query = $this->getSql('update-message-statusCode');
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(":MsgStatusCode", $status);
      $stmt->bindValue(":ModifyUserID", $staffId);
      $stmt->bindValue(":ModifyDate", $ModifyDate);
      $stmt->bindValue(":MessageID", $id);

      if ($stmt->execute()) {
          $response['result'] = 1;
         return $response;
      } else {
          return NULL;
      }
      $stmt->close();
    }

    public function pushNotification($token, $body){

      $ch = curl_init();
      // Set cURL opts
      curl_setopt($ch, CURLOPT_URL, EXPO_API_URL);
      curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'accept: application/json',
          'content-type: application/json'
      ]);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


      $postData = [
          "to" => $token,
          "body" => $body
        ];

      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
      $file_contents = curl_exec ( $ch );


      if (curl_errno ( $ch )) {
          echo curl_error ( $ch );
          curl_close ( $ch );
          exit ();
      }
      curl_close ( $ch );
    }
}
?>
