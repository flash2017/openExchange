<?php

namespace Apitest\Api\OpenExchange\Latest;
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */


use \GuzzleHttp\Utils;

/**
 * Description of Converter
 *
 * @author flash
 */
class Converter
{
    /**
     * 
     * @param array $body
     * @return array
     */
    public function convert(array $body): Response
    {
        $Validator = new Validator();
        $Validator->validate($body);
        
        return new Response(
            $body['disclaimer'],
            $body['license'],
            $body['timestamp'],
            $body['base'],
            $body['rates']);
    }
}
