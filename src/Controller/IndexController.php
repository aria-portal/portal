<?php declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class IndexController
{
    /**
     * @return Response
     */
    public function index(): Response
    {
        return new JsonResponse(['data' => 'Hallo'], 200);
    }
}