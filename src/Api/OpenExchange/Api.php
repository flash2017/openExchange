<?php
namespace Apitest\Api\OpenExchange;
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

use \GuzzleHttp\Client;
use Apitest\Api\HttpTrait;
use Apitest\Api\OpenExchange\Latest\Converter as LatestConverter;
use Apitest\Api\OpenExchange\Latest\Response as LatestResponse;
use \Apitest\Api\Exception\ValidationException;
use \Apitest\Api\Exception\ResponseException;

/**
 * Description of Api
 *
 * @author flash
 */
class Api
{
    use HttpTrait;
    
    private string $uri;


    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->uri = 'http://openexchangerates.org/api/';
    }
   
    /**
     * 
     * @param string $appId
     * @return LatestResponse
     * @throws HttpTransportException|ResponseException
     */
    public function latest(string $appId): LatestResponse
    {
        $parmas['query'] = ['app_id'=> $appId];
        $url = $this->uri . 'latest.json';
        $method = 'GET';
        
        $Response = $this->doRequest($method, $url, $parmas);
        $content = $this->parseResponse($Response, 'application/json');
       
        $Converter = new LatestConverter();
        
        try {
            return $Converter->convert($content);
        } catch (ValidationException $e) {
            throw new ResponseException(sprintf('не валидный ответ запроса %s %s', $method, $url), 0, $e);
        }
    }
}
