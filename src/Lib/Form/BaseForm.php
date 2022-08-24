<?php

namespace App\Lib\Form;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BaseForm implements ParamConverterInterface
{
    public function __construct(private readonly ValidatorInterface $validator,)
    {
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        $className = $configuration->getClass();

        $createdForm = new $className();
        $jsonResult = $createdForm->validate($request, $this->validator);

        $request->attributes->set('validationForm', $jsonResult);
        return true;
    }

    public function supports(ParamConverter $configuration)
    {
        if (null === $configuration->getClass()) {
            return false;
        }
        return is_subclass_of($configuration->getClass(), ABaseForm::class);
    }
}