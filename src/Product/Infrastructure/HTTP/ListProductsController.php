<?php

namespace App\Product\Infrastructure\HTTP;

use App\Common\Infrastructure\HTTP\AbstractHTTPController;
use App\Product\Application\ListProductsRequest;
use App\Product\Application\ListProductsResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;
class ListProductsController extends AbstractHTTPController
{
    #[Route('/products', name: 'product_list', methods: Request::METHOD_GET)]
    function index(
        #[MapQueryParameter] ?string $category, # appart of the string that should be filtered
        #[MapQueryParameter] ?int $priceLessThan, # appart of the string that should be filtered
    ): JsonResponse
    {
        if (!is_null($priceLessThan) && $priceLessThan < 1) {
            return $this->json(['error' => 'priceLessThan must be a positive value'], Response::HTTP_BAD_REQUEST);
        }
        /**
         * @var ListProductsResponse $response
         */
        $response = $this->commandBus->handle(new ListProductsRequest($category, $priceLessThan));
        return $this->json($response->products);
    }
}
