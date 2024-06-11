<?php
//YOUR MPESA API KEYS
$consumerKey = "CgK8y9CGBmJwwKPDNK36HHhUzfSztvF4wVEdDe1QzvUK0cS5";
$consumerSecret = "RYyflMjaRAsrXTkOZjdLU8LVGJfHJV4zLBfBuZV0iQRkzsSmfLgZrkSclnBTnUHL";
//ACCESS TOKEN URL
$access_token_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
$headers = ['Content-Type:application/json; charset=utf8'];
//INITIATE A CURL REQUEST
$curl = curl_init($access_token_url);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($curl, CURLOPT_HEADER, FALSE);
curl_setopt($curl, CURLOPT_USERPWD, $consumerKey . ':' . $consumerSecret);
$result = curl_exec($curl);
$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
$result;
 
$result = json_decode($result);
$access_token = $result->access_token;
curl_close($curl);