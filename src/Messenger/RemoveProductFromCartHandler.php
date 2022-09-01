<?php

namespace App\Messenger;

use App\Service\Cart\Cart;
use App\Service\Cart\CartService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class RemoveProductFromCartHandler implements MessageHandlerInterface
{
    public function __construct(private CartService $service) { }

    public function __invoke(RemoveProductFromCart $command): void
    {
        $this->service->removeProduct($command->cartId, $command->productId);
    }
}
