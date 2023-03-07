<?php

namespace App\Controller\Api;

use App\Repository\NoteCoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class NoteCoursController extends AbstractController
{
    #[Route('api/cours/notes', name: 'note_cours')]
    public function index(NoteCoursRepository $repo): JsonResponse
    {
        $notesCours = $repo->findAll();
        return $this->json($notesCours);
    }
}
