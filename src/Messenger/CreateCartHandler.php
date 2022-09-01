<?php

namespace App\Messenger;

use App\Service\Cart\Cart;
use App\Service\Cart\CartService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateCartHandler implements MessageHandlerInterface
{
    public function __construct(private CartService $service) { }

    public function __invoke(CreateCart $command): Cart
    {
        return $this->service->create();
    }
}
