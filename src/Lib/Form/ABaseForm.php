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

    private Request $request;

    public function makeResponse(Request $request, ABaseView $view = null): JsonResponse
    {
        $this->request = $request;
        $validation = $this->validate();

        if (count($validation))
            return $this->json(['errors' => $validation], Response::HTTP_BAD_REQUEST);

        $form = $this->getParams();
        $formExecution = $this->execute($form);

        if (!$view)
            return $this->json(
                null,
                Response::HTTP_NO_CONTENT);

        return $this->json(
            $view->execute($formExecution),
            $view->getHTTPStatusCode()
        );
    }

    #[ArrayShape(['body' => "array", 'query' => "array", 'route' => "array", 'requestDetail' => "array"])]
    protected function getParams(): array
    {
        return [
            'body' => $this->getBodyParams(),
            'query' => $this->getQueryParams(),
            'route' => $this->getRouteParams(),
        ];
    }


    protected function getBodyParams(): array
    {
        return json_decode($this->request->getContent(), true) ?? [];
    }

    protected function getQueryParams(): array
    {
        return $this->request->query->all() ?? [];
    }

    protected function getRouteParams(): array
    {
        return $this->request->attributes->get('_route_params') ?? [];
    }

    #[ArrayShape(["cookies" => "array", "sessions" => "array", 'headers' => "mixed", "host" => "string", "ip" => "null|string", "contentType" => "null|string"])]
    protected function getRequestDetails(): array
    {
        return [
            "cookies" => $this->request->cookies->all(),
            "sessions" => $this->request->getSession()->all(),
            'headers' => $this->request->headers->all(),
            "host" => $this->request->getHost(),
            "ip" => $this->request->getClientIp(),
            "contentType" => $this->request->getContentType(),
        ];
    }

    protected function getUser(): ?UserInterface
    {
        return $this->tokenStorage->getToken()->getUser();
    }

    protected function validate(): array
    {
        $input = [
            'body' => $this->getBodyParams(),
            'query' => $this->getQueryParams(),
            'route' => $this->getRouteParams(),
        ];

        $allowMissingFields = $this->request->getMethod() === 'PATCH';

        $constraints = new Assert\Collection([
            'body' => new Assert\Collection($this->constraints()['body'] ?? [], allowMissingFields: $allowMissingFields),
            'query' => new Assert\Collection($this->constraints()['query'] ?? [], allowMissingFields: true),
            'route' => new Assert\Collection($this->constraints()['route'] ?? [], allowMissingFields: $allowMissingFields),
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

    protected function json(mixed $data, int $status = Response::HTTP_OK): JsonResponse
    {
        return new JsonResponse($data, $status);
    }

    protected abstract function execute(array $form);
}
