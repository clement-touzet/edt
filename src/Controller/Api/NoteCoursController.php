<?php

namespace App\Controller\Api;

use App\Repository\NoteCoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('api/notecours/', name: 'notecours_')]
class NoteCoursController extends AbstractController
{
    #[Route('', name: 'notes')]
    public function index(NoteCoursRepository $repo): JsonResponse
    {
        $notesCours = $repo->findAll();
        return $this->json($notesCours);
    }
}
