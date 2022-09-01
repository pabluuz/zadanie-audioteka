<?php

namespace App\Controller\Catalog;

use App\Entity\Product;
use App\Messenger\MessageBusAwareInterface;
use App\Messenger\MessageBusTrait;
use App\Messenger\RemoveProductFromCatalog;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/products/{product}", methods={"DELETE"}, name="product-delete")
 */
class RemoveController extends AbstractController implements MessageBusAwareInterface
{
    use MessageBusTrait;

    public function __invoke(?Product $product): Response
    {
        if ($product !== null) {
            $this->dispatch(new RemoveProductFromCatalog($product->getId()));
        }
        
        return new Response('', Response::HTTP_ACCEPTED);
    }
}
