<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ErrorController extends AbstractController
{
    #[Route('/error/{code}', name: 'custom_error')]
    public function showError(int $code): Response
    {
        return $this->render('errors/error.html.twig', [
            'error_code' => $code,
            'message' => $this->getErrorMessage($code),
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