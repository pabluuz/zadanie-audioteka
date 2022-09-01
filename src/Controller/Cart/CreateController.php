<?php

namespace App\Controller\Cart;

use App\Messenger\CreateCart;
use App\Service\Cart\Cart;
use App\Service\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cart", methods={"POST"}, name="cart-create")
 */
class CreateController extends AbstractController
{
    use HandleTrait;

    public function __construct(private CartService $cartService, MessageBusInterface $messageBus) {
        $this->messageBus = $messageBus;
    }

    public function __invoke(): Response
    {
        /** @var Cart $cart */
        $cart = $this->handle(new CreateCart());

        return new JsonResponse(['cart_id' => $cart->getId()], Response::HTTP_CREATED);
    }
}
