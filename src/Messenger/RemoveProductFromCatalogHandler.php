<?php

namespace App\Messenger;

use App\Service\Catalog\ProductService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class RemoveProductFromCatalogHandler implements MessageHandlerInterface
{
    public function __construct(private ProductService $service) { }

    public function __invoke(RemoveProductFromCatalog $command): void
    {
        $this->service->remove($command->productId);
    }
}
