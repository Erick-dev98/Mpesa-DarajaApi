<?php
include 'accessToken.php';
include 'securitycridential.php';
$b2c_url = 'https://sandbox.safaricom.co.ke/mpesa/b2c/v1/paymentrequest';
$InitiatorName = 'testapi';
$pass = "Safaricom999!*!";
$BusinessShortCode = "600997";
$phone = "254708374149";
$amountsend = '1';
// $SecurityCredential ='jSDG3NEAUlT77cXKjDaTvuJp09ZD4ec/sXlJ9gJsSe2HdYpydpx8GoJPmwKLkopRYYe3DYlbNEDwZZD3XqXaDwOEh4dl0TbCzNLnbFVyYkwOY+YvWyc7Xm7o7i4ikgW1x+BRrWokiSMagq4ensIwge+y93lRv2WmCOkIfdv8U7hmHrAW4iZcaquZPIPw3b50SUDOWT2DoHxgaeNQB03/vjH9YP2FVL5zDQ09Y5HmC6LVonDYPcby8jFl9jxK8jAgy/zMwmaE6/GKZXCSHJMjmUqbPIlK0vCGqGQAU0Zwnw8x4XRktXo/O1IAiNzf0NUmoZ51MRmRG5QiyJqQFU80pg==';
$CommandID = 'SalaryPayment'; // SalaryPayment, BusinessPayment, PromotionPayment
$Amount = $amountsend;
$PartyA = $BusinessShortCode;
$PartyB = $phone;
$Remarks = 'Umeskia Withdrawal';
$QueueTimeOutURL = 'https://1c95-105-161-14-223.ngrok-free.app/MPEsa-Daraja-Api/b2cCallbackurl.php';
$ResultURL = 'https://1c95-105-161-14-223.ngrok-free.app/MPEsa-Daraja-Api/dataMaxcallbackurl.php';
$Occasion = 'Online Payment';
/* Main B2C Request to the API */
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $b2c_url);
curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type:application/json', 'Authorization:Bearer ' . $access_token]);
$curl_post_data = array(
    'InitiatorName' => $InitiatorName,
    'SecurityCredential' => $SecurityCredential,
    'CommandID' => $CommandID,
    'Amount' => $Amount,
    'PartyA' => $PartyA,
    'PartyB' => $PartyB,
    'Remarks' => $Remarks,
    'QueueTimeOutURL' => $QueueTimeOutURL,
    'ResultURL' => $ResultURL,
    'Occasion' => $Occasion
);
$data_string = json_encode($curl_post_data);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
$curl_response = curl_exec($curl);
echo $curl_response;