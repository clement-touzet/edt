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
        $requestedDate = $request->query->get("date");

        if (is_null($requestedDate)) {
            return $this->json(["error" => "Requête mal formattée"], Response::HTTP_BAD_REQUEST);
        }
        $coursFromDate = $repository->findByDateField($requestedDate);
        return $coursFromDate;
        // $date = new DateTimeImmutable($data);
        // return 
    }
}
