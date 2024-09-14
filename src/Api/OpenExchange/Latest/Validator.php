<?php
namespace Apitest\Api\OpenExchange\Latest;

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */
use GuzzleHttp\Client;
use \Apitest\Api\Exception\ValidationException;
use RuntimeException;

/**
 * Description of Api
 *
 * @author flash
 */
class Validator
{
    /**
     * 
     * @param array $param
     * @throws ResponseException
     */
    public function validate(array $param)
    {
        $errors = [];
        if (isset($param['error']) && $param['error'] === true) {
            $message = $param['message'] ?? 'Ошибка в ответе не определена';
            $description = $param['description'] ?? '';
            $code = $param['status'] ?? 0;
            $errors[] = sprintf('%s %s (%s)', $message, $description, $code);
        } else {
            $requiredKeys = [];
            foreach($requiredKeys as $needKey) {
                try {
                    $this->hasPart($needKey, $data);
                } catch (RuntimeException $e) {
                    $errors[$needKey] = $e;
                    continue;
                }
            }
        }
        
        if ($errors !== []) {
            $message = implode(', ', $errors);
            throw new ValidationException(sprintf('ответ содержит ошибки: %s', $message));
        }
    }
    
    private function hasPart(string $needKey, $data): bool
    {
        if (!array_key_exists($needKey, $data)) {
            throw new RuntimeException(sprintf('ключ %s не определён'));
        }
        
        return true;
        
    }
}
