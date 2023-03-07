<?php

namespace App\Controller\Api;

use App\Repository\MatiereRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/matiere', name: 'matiere')]
class MatiereController extends AbstractController
{
    #[Route('', name: '_list', methods: ['GET'])]
    public function getMatieres(MatiereRepository $repo): JsonResponse
    {
        $matieres = $repo->findAll();
        return $this->json($matieres);
    }

    #[Route('/professeurs', name: '_list', methods: ['GET'])]
    public function getProfEachMatiere(MatiereRepository $repo): JsonResponse
    {
        $matieres = $repo->findAll();
        $listeProf = [];
        foreach ($matieres as $matiere) {
            $titre = $matiere->getTitre();
            $listeProf[$titre] = $matiere->getProfesseurs()->toArray();
        }
        return $this->json($listeProf, Response::HTTP_OK);
    }
}
