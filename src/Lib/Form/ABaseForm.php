<?php

namespace App\Lib\Form;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;


abstract class ABaseForm
{
    public abstract function constraints();

    /**
     * @throws \Exception
     */
    public function validate(Request $request, ValidatorInterface $validator): void
    {
        $input = [
            'body' => self::getBodyParams($request),
            'query' => self::getQueryParams($request),
            'route' => self::getRouteParams($request)
        ];

        $constraints = new Assert\Collection([
            'body' => new Assert\Collection($this->constraints()['body'] ?? []),
            'query' => new Assert\Collection($this->constraints()['query'] ?? []),
            'route' => new Assert\Collection($this->constraints()['route'] ?? []),
        ]);

        $errors = $validator->validate($input, $constraints);

        if ($errors->count()) {
            $messages = [];
            foreach ($errors as $error) {
                $messages[] = $error->getMessage();
            }
            throw new \Exception;
        }

    }

    public static function getQueryParams(Request $request): array
    {
        return $request->query->all();
    }

    public static function getBodyParams(Request $request): array
    {
        return $request->toArray();
    }

    public static function getRouteParams(Request $request): array
    {
        return $request->attributes->get('_route_params');
    }

    public static function getParams(Request $request): array
    {
        return [
            'body' => self::getBodyParams($request),
            'query' => self::getQueryParams($request),
            'route' => self::getRouteParams($request)
        ];
    }

    public abstract function execute(Request $request): void;
}