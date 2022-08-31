<?php

namespace App\Lib\Form;

use App\Lib\View\ABaseView;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Service\Attribute\Required;


abstract class ABaseForm implements IBaseForm
{
    #[Required]
    public ValidatorInterface $validator;

    #[Required]
    public TokenStorageInterface $tokenStorage;

    #[ArrayShape(['body' => "array", 'query' => "array", 'route' => "array"])]
    public static function getParams(Request $request): array
    {
        return [
            'body' => self::getBodyParams($request),
            'query' => self::getQueryParams($request),
            'route' => self::getRouteParams($request)
        ];
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

    public function getUser(): ?UserInterface
    {
        return $this->tokenStorage->getToken()->getUser();
    }

    public function makeResponse(Request $request, ABaseView $view = null): JsonResponse
    {
        $validation = $this->validate($request);

        if (count($validation))
            return $this->json(['errors' => $validation], Response::HTTP_BAD_REQUEST);

        $formExecution = $this->execute($request);

        if (!$view)
            return $this->json(
                null,
                Response::HTTP_NO_CONTENT);

        return $this->json(
            $view->execute($formExecution),
            $view->getHTTPStatusCode()
        );
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
                $messages[$error->getPropertyPath()] = $error->getMessage();
            }
            return $messages;
        }
        return [];

    }

    public abstract function constraints(): array;

    public function json(mixed $data, int $status = Response::HTTP_OK): JsonResponse
    {
        return new JsonResponse($data, $status);
    }

    public abstract function execute(Request $request);
}