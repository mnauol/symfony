<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ErrorController extends AbstractController
{
    #[Route('/error/{code}', name: 'custom_error')]
    public function showError(int $code): JsonResponse
    {
        return new JsonResponse([
            'message' => $this->getErrorMessage($code),
            'error_code' => $code,
        ]);
    }

    private function getErrorMessage(int $code): string
    {
        return match ($code) {
            404 => 'Oops... page not found',
            500 => 'Server error! Something went wrong!',
            default => 'An unknown error occurred!'
        };
    }
}