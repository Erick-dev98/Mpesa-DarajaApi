<?php
$phone = "254768003470";
$money = '1';

date_default_timezone_set('Africa/Nairobi');

# access token
$consumerKey = 'CgK8y9CGBmJwwKPDNK36HHhUzfSztvF4wVEdDe1QzvUK0cS5';
$consumerSecret = 'RYyflMjaRAsrXTkOZjdLU8LVGJfHJV4zLBfBuZV0iQRkzsSmfLgZrkSclnBTnUHL';
$BusinessShortCode = '174379';
$Passkey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';

$PartyA = $phone; // This is your phone number, 
$PartyB = '254708374149'; //This os the sane as business short code
$AccountReference = 'EverosaCollections';
$TransactionDesc = 'Please cornfirm payment made to EverosaCollections.';
$Amount = $money;

# Get the timestamp, format YYYYmmddhms -> 20181004151020
$Timestamp = date('YmdHis');

# Get the base64 encoded string -> $password. The passkey is the M-PESA Public Key
$Password = base64_encode($BusinessShortCode . $Passkey . $Timestamp);

# header for access token
$headers = ['Content-Type:application/json; charset=utf8'];

# M-PESA endpoint urls
$access_token_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
$initiate_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

# callback url 
$CallBackURL = 'https://everosacollections.com/darajaapp/callback.php';

$curl = curl_init($access_token_url);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($curl, CURLOPT_HEADER, FALSE);
curl_setopt($curl, CURLOPT_USERPWD, $consumerKey . ':' . $consumerSecret);
$result = curl_exec($curl);
$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
$result = json_decode($result);
$access_token = $result->access_token;
curl_close($curl);

# header for stk push
$stkheader = ['Content-Type:application/json', 'Authorization:Bearer ' . $access_token];

# initiating the transaction
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $initiate_url);
curl_setopt($curl, CURLOPT_HTTPHEADER, $stkheader); //setting custom header

$curl_post_data = array(
    //Fill in the request parameters with valid values
    'BusinessShortCode' => $BusinessShortCode,
    'Password' => $Password,
    'Timestamp' => $Timestamp,
    'TransactionType' => 'CustomerPayBillOnline',
    'Amount' => $Amount,
    'PartyA' => $PartyA,
    'PartyB' => $BusinessShortCode,
    'PhoneNumber' => $PartyA,
    'CallBackURL' => $CallBackURL,
    'AccountReference' => $AccountReference,
    'TransactionDesc' => $TransactionDesc
);

$data_string = json_encode($curl_post_data);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
$curl_response = curl_exec($curl);



$data_to = json_decode($curl_response);
if ($data_to->ResponseCode == '0') {
    $CheckoutRequestID = $data_to->CheckoutRequestID;
    echo "STK PROMPT SUCCESSFULY";
} else {
    echo "THE TRANSACTION REQUEST FAILED";
}