<?php

namespace App\Controller\Cart;

use App\Entity\Cart;
use App\Entity\Product;
use App\Messenger\MessageBusAwareInterface;
use App\Messenger\MessageBusTrait;
use App\Messenger\RemoveProductFromCart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cart/{cart}/{product}", methods={"DELETE"}, name="cart-remove-product")
 */
class RemoveProductController extends AbstractController implements MessageBusAwareInterface
{
    use MessageBusTrait;

    public function __invoke(Cart $cart, ?Product $product): Response
    {
        if ($product !== null) {
            $this->dispatch(new RemoveProductFromCart($cart->getId(), $product->getId()));
        }

        return new Response('', Response::HTTP_ACCEPTED);
    }
}
