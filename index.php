<?php

$strAccessToken = "Mhq/9PgLvLSFnFTcW3hXTzbSEvhexgUxlNQcyVmlZHnPhtVlPXFH4Cc733BKr0QWdIkmCrafDzAL6veWRQTfDomxz0//x3Wte7G4teOqPyDTurua1UpMHA9Yng7f6EphpxwTFUoj9lMe5NVmbmXUZAdB04t89/1O/w1cDnyilFU=";

$content = file_get_contents('php://input');
$arrJson = json_decode($content, true);

$strUrl = "https://api.line.me/v2/bot/message/reply";

$arrHeader = array();
$arrHeader[] = "Content-Type: application/json";
$arrHeader[] = "Authorization: Bearer {$strAccessToken}";

$arrJsonMsg = (string)$arrJson['events'][0]['message']['text'];

if($arrJsonMsg == "สวัสดี"){
  $arrPostData = array();
  $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
  $arrPostData['messages'][0]['type'] = "text";
  $arrPostData['messages'][0]['text'] = "สวัสดี ID คุณคือ ".$arrJson['events'][0]['source']['userId'];
}

else if($arrJsonMsg == "ชื่ออะไร"){
  $arrPostData = array();
  $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
  $arrPostData['messages'][0]['type'] = "text";
  $arrPostData['messages'][0]['text'] = "I'm NUT-BOT";
}

else if($arrJsonMsg == "ทำอะไรได้บ้าง"){
  $arrPostData = array();
  $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
  $arrPostData['messages'][0]['type'] = "text";
  $arrPostData['messages'][0]['text'] = "ฉันทำอะไรไม่ได้เลย คุณต้องสอนฉันอีกเยอะ";
}

else if($arrJsonMsg == "วันที่")
{
  $arrPostData = array();
  $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
  $arrPostData['messages'][0]['type'] = "text";
  $arrPostData['messages'][0]['text'] = "Today is ".date("Y-m-d H:i:s");
}

else if($arrJsonMsg == "กินข้าวรึยัง" || $arrJsonMsg == "กินข้าวยัง" || $arrJsonMsg == "กินข้าวรึยัง?" || $arrJsonMsg == "กินข้าวยัง?")
{
  $arrPostData = array();
  $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
  $arrPostData['messages'][0]['type'] = "text";
  $arrPostData['messages'][0]['text'] = "หิวพอดี ไปกินด้วยม");
}

else if(strtoupper($arrJsonMsg) == "SERVER TEMP")
{
    header('Access-Control-Allow-Origin: *');
    $url = "https://api.netpie.io/topic/SmartServerMonitor/ServerRoom1?retain&auth=OLfJOENYvYLmbqG:J0o3U9oywRvgnLtl5lLhscdJ5";
    $response = file_get_contents($url);

    $obj = json_decode($response, true);

    /*echo "<pre>";*/
    /*print_r($obj);*/

    $strTemp = $obj[0]['payload'];
    $arrTemp = explode("|", $strTemp);
    
    $arrPostData = array();
    $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
    $arrPostData['messages'][0]['type'] = "text";
    $arrPostData['messages'][0]['text'] = "Server room temp : \n".$arrTemp[0]." °C";
}

else{
  $arrPostData = array();
  $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
  $arrPostData['messages'][0]['type'] = "text";
  $arrPostData['messages'][0]['text'] = "ฉันไม่เข้าใจคำสั่ง";
}


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$strUrl);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $arrHeader);

curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arrPostData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$result = curl_exec($ch);
curl_close ($ch);

?>