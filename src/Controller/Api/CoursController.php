<?php

namespace App\Controller\Api;

use App\Entity\Cours;
use App\Entity\NoteCours;
use App\Repository\CoursRepository;
use App\Repository\NoteCoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/cours', name: 'cours_')]
class CoursController extends AbstractController
{
    #[Route('', name: 'list', methods: ['GET'])]
    public function getAllCours(CoursRepository $repository): JsonResponse
    {
        $cours = $repository->findAll();
        return $this->json($cours);
    }


    #[Route('/cours-from-date', name: 'list_from_a_day', methods: ['GET'])]
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

    #[Route('/{id}', name: 'cours', methods: ['GET'])]
    public function getCours(Cours $cours): JsonResponse
    {
        if (is_null($cours)) {
            return $this->json(["error" => "Cours non trouvé"], Response::HTTP_NOT_FOUND);
        }
        return $this->json($cours, Response::HTTP_OK);
    }

    #[Route('/{id}/notes', name: 'get_note', methods: ['GET'])]
    public function getNote(Cours $cours): JsonResponse
    {
        if (is_null($cours)) {
            return $this->json(["error" => "Cours non trouvé"], Response::HTTP_NOT_FOUND);
        }
        $notes = $cours->getNoteCours();
        return $this->json($notes, Response::HTTP_OK);
    }

    #[Route('/{id}/create-note', name: 'create_note', methods: ['POST'])]
    public function createNote(Cours $cours, Request $request, NoteCoursRepository $repo, ValidatorInterface $validator)
    {
        $data = json_decode($request->getContent(), true);
        if (is_null($data)) {
            return $this->json(['message' => 'Requete mal formatee (aucune données trouvées)'], Response::HTTP_BAD_REQUEST);
        }

        $noteCours = (new NoteCours)
            ->fromArray($data)
            ->setCours($cours);


        $errors = $validator->validate($noteCours);
        if ($errors->count() > 0) {
            $messages = [];
            foreach ($errors as $error) {
                $messages[$error->getPropertyPath()] = $error->getMessage();
            }
            return $this->json($messages, Response::HTTP_BAD_REQUEST);
        }

        $repo->save($noteCours, true);

        return $this->json($noteCours, Response::HTTP_OK);
    }
}
