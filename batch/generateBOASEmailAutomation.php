<?php
require_once __DIR__.'/sendEmailClass.php';


$conn = new PDO($dsn);
$query = "SELECT A.LoginID, A.CreateDate, a.FirstName, A.LastName, count(U.ApplicationID) UCount, count(C.ApplicationID) ACount
  FROM tblBHSApplicationUser A
  LEFT JOIN tblBHSApplicationUnfinished U ON  U.LoginID = A.LoginID
  LEFT JOIN tblBHSApplication C ON  C.LoginID = A.LoginID
  group by A.LoginID, A.CreateDate, a.FirstName, A.LastName
  having count(U.ApplicationID) = 0 AND count(C.ApplicationID) = 0 AND A.CreateDate  > '2021-02-23'";


$stmt = $conn->prepare($query);



if ($stmt->execute()) {
  $folderDate = date('Y-m-d');
  $myfile = fopen("E:/batchlog/".$folderDate.".txt", "w") or die("Unable to open file!");

  $date2 = new DateTime(date("Y-m-d H:i:s"));
  // $date2 = new DateTime('2021-02-25 00:00:00');
  $from = array(
    array('email' => 'boas@bodwell.edu', 'name' => 'Bodwell Admissions')
  );
  $cc = array();
  $i = 0;
    while ($row = $stmt->fetch()) {
      $body = '';
      $date1 = new DateTime($row['CreateDate']);
      $diff = $date2->diff($date1);
      $hours = $diff->h;
      $hours = $hours + ($diff->days*24);

      if($hours >= 24 && $hours < 48){
        $fullName = $row['FirstName'].' '.$row['LastName'];
        $subject = 'Greetings from Bodwell! Here is some information to help with your application';
        echo $row['LoginID'].$hours."<br />";

        $to = array(
            array('email' => $row['LoginID'], 'name' => $fullName)
        );
        $body =
<<<BODY
<p>
    Hi $fullName,
</p>
<p>
    Thank you for beginning the online application process to attend Bodwell
    High School. You can continue your application where you left off at any
    time by clicking this <a href="http://apply.bodwell.edu/">link</a>.
</p>
<p>
    If you need assistance, please check out our
    <a
        href="https://bodwell.canto.com/download/presentation/7ftedjp9q53q9a2ghi7vsc6232/original"
        title="https://bodwell.canto.com/download/presentation/7ftedjp9q53q9a2ghi7vsc6232/original"
    >
        Step-By-Step Guide
    </a>
    or our
    <a
        href="https://bodwell.canto.com/direct/video/kdsjrnvisl23v474vkp5d3v76t/KukBVkAQy3_S7Z5zlDaTlm9dopA/original?content-type=video%2Fmp4&amp;name=Application+Walk-Through+V2.mp4"
    >
        video
    </a>
    on how our application process works. You can also reach out to us by
    emailing <a href="mailto:admissions@bodwell.edu">admissions@bodwell.edu</a>
    if you have additional questions on admissions or Bodwell.
</p>
<p>
    You will start by clicking "<strong>Apply New</strong>" and filling in all
    the required fields. Later at the Upload step, you will need to provide us
    the following documents:
</p>
<ol start="1" type="1">
    <li>
        Passport Copy (photo ID page)
    </li>
    <li>
        Transcript of your past 3 years
    </li>
</ol>
<p>
    Once all the documents are uploaded and the application is submitted, we
    will then set up an interview with you within a week. The purpose of the
    interview is to get to know you better and evaluate your acceptability for
    our school. We will be asking questions to understand your transcript,
    personality and motivations for coming to Bodwell and Canada.
</p>
<p>
    Here are some information about Bodwell that we think you and your parents
    might be interested in:
</p>
<ul type="square">
    <li>
        <a href="https://bodwell.edu/partner-resources/">
            Brochures and Materials
        </a>
        (<em>published in 18 different languages</em>)
    </li>
    <li>
        <a href="https://bodwell.canto.com/v/EnglishPortal/landing?viewIndex=1">
            Photos &amp; Videos
        </a>
    </li>
    <li>
        <a href="https://bodwell.edu/admissions/reviews/">
            Testimonials &amp; Online Reviews
        </a>
    </li>
    <li>
        <a href="https://bodwell.edu/all_about_bodwell/campus-facilities/">
            Virtual Campus Tour
        </a>
    </li>
    <li>
        Social Media Accounts:
    </li>
</ul>
<p>
    <a href="https://www.facebook.com/bodwellhighschool/" style="">
        <img
            border="0"
            width="27"
            height="27"
            src="cid:facebook"
            alt="Icon

Description automatically generated"
        />
    </a>
    &nbsp;	&nbsp;
    <a href="https://www.instagram.com/mybodwell" style="">
        <img
            border="0"
            width="26"
            height="26"
            src="cid:instagram"
            alt="Icon

Description automatically generated"
        />
    </a>
    &nbsp;	&nbsp;
    <a href="https://www.youtube.com/user/bodwellcollege" style="">
        <img
            border="0"
            width="38"
            height="24"
            src="cid:youtube"
        />
    </a>
    &nbsp;	&nbsp;
</p>
<p>
    Sincerely,
</p>
<p>
    Ms. Megumi Uehara<em></em>
</p>
<p>
    <em>Assistant Director of Recruitment</em>
</p>
<p>
    <img
        border="0"
        width="207"
        height="75"
        src="cid:school"
    />
</p>
BODY;

        $send = sendEmail($from, $to, $cc, $subject, $body, $altBody = '');
        if($send == true) {
          $myfile2 = fopen("E:/batchlog/".$folderDate.".txt", "a+");
          $txt = $row['LoginID']." - 24 Hours reminder sent"."\r\n";
          fwrite($myfile2, $txt);
          fclose($myfile);
        }
      } elseif ($hours >= 48 && $hours < 72) {
        $to = array(
            array('email' => $row['LoginID'], 'name' => $fullName)
        );
        echo $row['LoginID'].$hours."<br />";
        $fullName = $row['FirstName'].' '.$row['LastName'];
        $subject = 'Do you need help completing your Bodwell application?';
        $body =
<<<BODY
<p>
    Hi $fullName,
</p>
<p>
    Thank you for beginning the online application process to attend Bodwell
    High School. You can continue your application where you left off at any
    time by clicking this <a href="http://apply.bodwell.edu/">link</a>.
</p>
<p>
    I am Kaan, and I am here to help you during your applications process so you can register your child to Bodwell with ease. I see that it a few days since you started your application. If you need assistance, please check out our
    <a
        href="https://bodwell.canto.com/download/presentation/7ftedjp9q53q9a2ghi7vsc6232/original"
        title="https://bodwell.canto.com/download/presentation/7ftedjp9q53q9a2ghi7vsc6232/original"
    >
        Step-By-Step Guide
    </a>
    or our
    <a
        href="https://bodwell.canto.com/direct/video/kdsjrnvisl23v474vkp5d3v76t/KukBVkAQy3_S7Z5zlDaTlm9dopA/original?content-type=video%2Fmp4&amp;name=Application+Walk-Through+V2.mp4"
    >
        video
    </a>
    on how our application process works. You can also reply directly to this email if you would like to setup a 15-minute chat with me to discuss any questions, or if you are interested in learning more about Bodwell.
</p>
<p>
    You will start by clicking "<strong>Apply New</strong>" and filling in all
    the required fields. Later at the Upload step, you will need to provide us
    the following documents:
</p>
<ol start="1" type="1">
    <li>
        Passport Copy (photo ID page)
    </li>
    <li>
        Transcript of your past 3 years
    </li>
</ol>
<p>
    Once all the documents are uploaded and the application is submitted, we
    will then set up an interview with you within a week. The purpose of the
    interview is to get to know you better and evaluate your acceptability for
    our school. We will be asking questions to understand your transcript,
    personality and motivations for coming to Bodwell and Canada.
</p>
<p>
    Here are some information about Bodwell that we think you and your parents
    might be interested in:
</p>
<ul type="square">
    <li>
        <a href="https://bodwell.edu/partner-resources/">
            Brochures and Materials
        </a>
        (<em>published in 18 different languages</em>)
    </li>
    <li>
        <a href="https://bodwell.canto.com/v/EnglishPortal/landing?viewIndex=1">
            Photos &amp; Videos
        </a>
    </li>
    <li>
        <a href="https://bodwell.edu/admissions/reviews/">
            Testimonials &amp; Online Reviews
        </a>
    </li>
    <li>
        <a href="https://bodwell.edu/all_about_bodwell/campus-facilities/">
            Virtual Campus Tour
        </a>
    </li>
    <li>
        Social Media Accounts:
    </li>
</ul>
<p>
    <a href="https://www.facebook.com/bodwellhighschool/" style="">
        <img
            border="0"
            width="27"
            height="27"
            src="cid:facebook"
            alt="Icon

Description automatically generated"
        />
    </a>
    &nbsp;	&nbsp;
    <a href="https://www.instagram.com/mybodwell" style="">
        <img
            border="0"
            width="26"
            height="26"
            src="cid:instagram"
            alt="Icon

Description automatically generated"
        />
    </a>
    &nbsp;	&nbsp;
    <a href="https://www.youtube.com/user/bodwellcollege" style="">
        <img
            border="0"
            width="38"
            height="24"
            src="cid:youtube"
        />
    </a>
    &nbsp;	&nbsp;
</p>
<p>
    Sincerely,
</p>
<p>
    Mr. Kaan Turker<em></em>
</p>
<p>
    <em>Bodwell Admissions Department</em>
</p>
<p>
    <img
        border="0"
        width="207"
        height="75"
        src="cid:school"
    />
</p>
BODY;


$send = sendEmail($from, $to, $cc, $subject, $body, $altBody = '');
if($send == true) {
  $myfile2 = fopen("E:/batchlog/".$folderDate.".txt", "a+");
  $txt = $row['LoginID']." - 48 Hours reminder sent"."\r\n";
  fwrite($myfile2, $txt);
  fclose($myfile);
}
      }


    }


 }



 ?>
