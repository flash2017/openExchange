<?php
namespace Apitest\Api;
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Utils;
use \GuzzleHttp\Exception\GuzzleException;
use \GuzzleHttp\Exception\ClientException;
use Apitest\Api\Exception\HttpTransportException;
use Apitest\Api\Exception\ResponseException;

/**
 * Description of HttpTrait
 *
 * @author flash
 */
trait HttpTrait
{
    /**
     * 
     * @var ClientInterface
     */
    private ClientInterface $client;
    
    /**
     * 
     * @param ClientInterface $client
     * @return void
     */
    public function setClient(ClientInterface $client): void
    {
        $this->client = $client;
    }
    
    /**
     * 
     * @param string $methods
     * @param string $uri
     * @param array $params
     * @return RequestInterface
     * @throws HttpTransportException|ResponseException
     */
    protected function doRequest(string $methods, string $uri, array $options): ResponseInterface 
    {
        try {
            $Response = $this->client->request($methods, $uri, $options);
        } catch (ClientException|GuzzleException $e) {
            throw new HttpTransportException(sprintf('не удалось отправить HTTP-запрос %s %s', $methods, $uri), 0, $e);
        }    
        
        $this->validateResponse($Response);
        
        return $Response;
    }
    
    /**
     * 
     * @param ResponseInterface $Response
     * @return bool
     * @throws ResponseException
     */
    private function validateResponse(ResponseInterface $Response): bool
    {
        $statusCode = $Response->getStatusCode();
        $successStatus = [200, 201];
        if (!in_array($statusCode, $successStatus, true)) {
            throw new ResponseException(speintf('Получен некорректный ответ от сервиса ожидалось 200 (201) получен %s', $statusCode));
        }
        
        return true;
    }
    
    private function parseResponse(ResponseInterface $Response, string $mimeType)
    {
         try {
            $content = $Response->getBody()->getContents();
        } catch (RuntimeException $e) {
            throw new ResponseException(sprintf('не удалось получить содержимое ответа HTTP-запроса %s %s', $method,
                        $url), 0, $e);
        }
        
        switch($mimeType) {
            case 'application/json':
                try {
                    $responseData = Utils::jsonDecode($content, true, 512, JSON_THROW_ON_ERROR);
                } catch (InvalidArgumentException $e) {
                    throw new ResponseException('не удалось получить содержимое ответа HTTP-запроса', 0, $e);
                }
                break;
            default:
                throw new ResponseException(sprintf('не определено поведение для %s', $mimeType));
                break;
        }
        
        return $responseData;
    }
}
