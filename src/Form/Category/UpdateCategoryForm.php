<?php

namespace App\Form\Category;

use App\Form\Traits\HasValidateOwnership;
use App\Lib\Form\ABaseForm;
use App\Repository\CategoryRepository;
use App\Repository\ShopRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateCategoryForm extends ABaseForm
{

    use HasValidateOwnership;

    public function __construct(
        private readonly CategoryRepository $categoryRepository,
        private readonly ShopRepository $shopRepository
    )
    {
    }

    public function constraints(): array
    {
        return [
            'route' => [
                'id' => [
                    new Assert\NotBlank(),
                    new Assert\Positive(),
                ],
            ],
            'body' => [
                'title' => [
                    new Assert\Length(min: 4, max: 255),
                    new Assert\Regex(pattern: '/^\w+/'
                        , message: 'The category name {{ value }} is not valid.'),
                ],
                'shop_id' => [
                    new Assert\Positive(),
                    new Assert\Type('integer'),
                ],
            ],
        ];
    }

    public function execute(Request $request)
    {
        $form = self::getParams($request);

        $categoryId = $form['route']['id'];
        $category = $this->categoryRepository->find($categoryId);

        if(!$category) {
            throw new BadRequestHttpException("Category ${categoryId} not found");
        }

        $this->validateOwnership($category->getShop(), $this->getUser()->getId());

        if(isset($form['body']['title'])) {
            $category->setTitle($form['body']['title']);
        }

        if(isset($form["body"]["shop_id"])) {

            $shopId = $form['body']['shop_id'];
            $shop = $this->shopRepository->find($shopId);

            if(!$shop) {
                throw new BadRequestHttpException("Shop ${shopId} not found");
            }

            $this->validateOwnership($shop, $this->getUser()->getId());

            $category->setShop($shop);
        }
        $this->categoryRepository->flush();

        return $category;
    }
}