<?php
namespace App\Lib\View;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;

interface IBaseView
{
    function execute(array $params): static;
}