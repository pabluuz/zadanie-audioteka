<?php

namespace App\Controller\Catalog;

use App\Entity\Product;
use App\Messenger\AddProductToCatalog;
use App\Messenger\EditProductInCatalog;
use App\Messenger\MessageBusAwareInterface;
use App\Messenger\MessageBusTrait;
use App\ResponseBuilder\ErrorBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/products/{product}", methods={"PUT"}, name="product-edit")
 */
class EditController extends AbstractController implements MessageBusAwareInterface
{
    use MessageBusTrait;

    public function __construct(private ErrorBuilder $errorBuilder) { }

    public function __invoke(Request $request, ?Product $product): Response
    {
        $name = trim($request->get('name'));
        $price = (int)$request->get('price');

        if ($product === null) {
            return new JsonResponse(
                $this->errorBuilder->__invoke('Invalid product.'),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
        if ($name === '' || $price < 1) {
            return new JsonResponse(
                $this->errorBuilder->__invoke('Invalid name or price.'),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $this->dispatch(new EditProductInCatalog($product->getId(), $name, $price));

        return new Response('', Response::HTTP_ACCEPTED);
    }
}