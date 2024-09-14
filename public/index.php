<?php
/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
require '../vendor/autoload.php';

use GuzzleHttp\Client;
use Apitest\Api\OpenExchange\Latest;
use Apitest\Api\OpenExchange\Api as OpenExchangeApi;

$client = new Client();
$OpenExchangeApi = New OpenExchangeApi($client);
$appId = 'ENTER YOUR APP_ID';
try {
    $Response = $OpenExchangeApi->latest($appId);
    var_dump($Response);
} catch (Exception $ex) {
    echo $ex->getCode();
}
