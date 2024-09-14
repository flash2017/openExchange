<?php

namespace Apitest\Api\OpenExchange\Latest;

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

class Response
{

    public function __construct(
        private string $disclaimer,
        private string $license,
        private string $timestamp,
        private string $base,
        private array $rates
    ) {
        
    }

    public function getDisclaimer(): string
    {
        return $this->disclaimer;
    }

    public function getLicense(): string
    {
        return $this->license;
    }

    public function getTimestamp(): string
    {
        return $this->timestamp;
    }

    public function getBase(): string
    {
        return $this->base;
    }

    public function getRates(): array
    {
        return $this->rates;
    }
}
