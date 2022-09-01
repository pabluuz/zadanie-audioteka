<?php

namespace App\Controller\Cart;

use App\Entity\Cart;
use App\ResponseBuilder\CartBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cart/{cart}", methods={"GET"}, name="cart-show")
 */
class ShowCartController extends AbstractController
{
    public function __construct(private CartBuilder $cartBuilder) { }

    public function __invoke(Cart $cart): Response
    {
        return new JsonResponse($this->cartBuilder->__invoke($cart), Response::HTTP_OK);
    }
}
