<?php

namespace App\Controller\Api;

use App\Repository\CoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/cours', name: 'cours_')]
class CoursController extends AbstractController
{
    #[Route('', name: 'list', methods: ['GET'])]
    public function getAllCours(CoursRepository $repository): JsonResponse
    {
        $cours = $repository->findAll();
        return $this->json($cours);
    }

    #[Route('/cours-from-date', name: 'list', methods: ['GET'])]
    public function getCoursFromDate(Request $request, CoursRepository $repository): JsonResponse
    {
        $jour = $request->query->get("jour");
        $mois = $request->query->get("mois");
        $annee = $request->query->get("annee");
        $requestedDate = $annee . "-" . $mois . "-" . $jour;

        if (is_null($jour) || is_null($mois) || is_null($annee)) {
            return $this->json(["error" => "Requête mal formattée"], Response::HTTP_BAD_REQUEST);
        }
        // var_dump($requestedDate);
        $coursFromDate = $repository->findByDateField($requestedDate);
        // var_dump($coursFromDate);
        return $this->json($coursFromDate, Response::HTTP_OK);
        // $date = new DateTimeImmutable($data);
        // return 
    }
}
