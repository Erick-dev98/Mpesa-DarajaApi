<?php
header("Content-Type: application/json");
$QueueTimeOutURLCallbackResponse = file_get_contents('php://input');
$logFile = "QueueTimeOutURL.json";
$log = fopen($logFile, "a");
fwrite($log, $QueueTimeOutURLCallbackResponse);
fclose($log);