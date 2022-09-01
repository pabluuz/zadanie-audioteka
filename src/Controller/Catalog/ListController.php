<?php

namespace App\Controller\Catalog;

use App\ResponseBuilder\ProductListBuilder;
use App\Service\Catalog\ProductProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/products", methods={"GET"}, name="product-list")
 */
class ListController extends AbstractController
{
    private const MAX_PER_PAGE = 3;

    public function __construct(private ProductProvider $productProvider, private ProductListBuilder $productListBuilder) { }

    public function __invoke(Request $request): Response
    {
        $page = max(0, (int)$request->get('page', 0));

        $products = $this->productProvider->getProducts($page, self::MAX_PER_PAGE);
        $totalCount = $this->productProvider->getTotalCount();

        return new JsonResponse(
            $this->productListBuilder->__invoke($products, $page, self::MAX_PER_PAGE, $totalCount),
            Response::HTTP_OK
        );
    }
}
