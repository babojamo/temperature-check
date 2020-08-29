<?php
namespace App\Temperature\Contracts;

interface SystemApiInterface 
{

    public function executeApi();

    public function errorHandler($exception);

    public function addHeader($key,$value);

    public function getHeaders();

    public function setParameter($key,$value);

    public function getParameter($key);

    public function getUrl();

    public function setBaseUrl(string $url);

    public function getBaseUrl();

    public function result($payload);
}