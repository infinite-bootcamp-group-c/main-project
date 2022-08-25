<?php
namespace App\Lib\View;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface IBaseView
{
    static function execute(array $params): void;
    function createResponse(array $responseArray): Response;
}