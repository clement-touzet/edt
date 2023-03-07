<?php

namespace App\Controller\Api;

use App\Repository\SalleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/salles', name: 'salles_')]
class SallesController extends AbstractController
{
    #[Route('', name: 'list')]
    public function index(SalleRepository $repo): JsonResponse
    {
        $salles = $repo->findAll();
        return $this->json($salles);
    }
}
