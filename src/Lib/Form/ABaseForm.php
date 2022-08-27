<?php

namespace App\Lib\Form;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;


abstract class ABaseForm implements IBaseForm
{
    public function __construct(
        private readonly ValidatorInterface    $validator,
        private readonly TokenStorageInterface $tokenStorage,
    )
    {
    }

    public static function getParams(Request $request): array
    {
        return [
            'body' => self::getBodyParams($request),
            'query' => self::getQueryParams($request),
            'route' => self::getRouteParams($request)
        ];
    }

    public function validate(Request $request): array
    {
        $input = [
            'body' => self::getBodyParams($request),
            'query' => self::getQueryParams($request),
            'route' => self::getRouteParams($request),
        ];

        $constraints = new Assert\Collection([
            'body' => new Assert\Collection($this->constraints()['body'] ?? []),
            'query' => new Assert\Collection($this->constraints()['query'] ?? []),
            'route' => new Assert\Collection($this->constraints()['route'] ?? []),
        ]);

        $errors = $this->validator->validate($input, $constraints);

        if ($errors->count()) {
            $messages = [];
            foreach ($errors as $error) {
                $messages[] = $error->getMessage();
            }
            return $messages;
        }
        return [];

    }

    public static function getBodyParams(Request $request): array
    {
        return json_decode($request->getContent(), true) ?? [];
    }

    public static function getQueryParams(Request $request): array
    {
        return $request->query->all() ?? [];
    }

    public static function getRouteParams(Request $request): array
    {
        return $request->attributes->get('_route_params') ?? [];
    }

    public abstract function constraints();

    public function getUser()
    {
        return $this->tokenStorage->getToken()->getUser();
    }

    public abstract function execute(Request $request);
}