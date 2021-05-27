<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
const EXPO_API_URL = 'https://exp.host/--/api/v2/push/send';

$list = array();

array_push($list, "ExponentPushToken[0VeCqnOw7Rx-BTKc3MheGB]","ExponentPushToken[1-Ia99BjptQO3MsTC34zaO]");
$b = 'test';
echo pushNotification($list, $b);
function pushNotification($token, $body){

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
  return $file_contents;
}
