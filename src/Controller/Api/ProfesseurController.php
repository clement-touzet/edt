<?php

namespace App\Controller\Api;

use App\Entity\Avis;
use App\Entity\Professeur;
use App\Repository\AvisRepository;
use App\Repository\ProfesseurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/professeurs', name: 'api_professeurs_')]
class ProfesseurController extends AbstractController
{
    #[Route('', name: 'list', methods: ['GET'])]
    public function list(ProfesseurRepository $repository): JsonResponse
    {
        $professeurs = $repository->findAll();
        // return $this->json(array_map(fn ($professeur) => $professeur->toArray(), $professeurs));
        return $this->json($professeurs);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(?Professeur $professeur): JsonResponse
    {
        if (is_null($professeur)) {
            return $this->json(["error" => "Professeur not found"], Response::HTTP_NOT_FOUND);
        }
        return $this->json($professeur, JsonResponse::HTTP_OK);
    }

    #[Route('/{id}/avis', name: 'get_avis', methods: ['GET'])]
    public function getAvis(?Professeur $professeur): JsonResponse
    {
        if (is_null($professeur)) {
            return $this->json(["error" => "Professeur not found"], Response::HTTP_NOT_FOUND);
        }
        $avis = $professeur->getAvis()->toArray();
        $json = $this->json($avis, JsonResponse::HTTP_OK);
        return $json;
    }

    #[Route('/{id}/avis', name: 'create_avis', methods: ['POST'])]
    public function create_avis(Request $request, AvisRepository $repositoryAvis, ValidatorInterface $validator, ?Professeur $professeur): JsonResponse
    {
        if (is_null($professeur)) {
            return $this->json(["error" => "Professeur not found"], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        if (is_null($data)) {
            return $this->json(["error" => "Requête mal formattée"], Response::HTTP_BAD_REQUEST);
        }

        $avis = (new Avis)
            ->fromArray($data)
            ->setProfesseur($professeur);

        $errors = $validator->validate($avis);

        if ($errors->count() > 0) {
            $messages = [];
            foreach ($errors as $error) {
                $messages[$error->getPropertyPath()] = $error->getMessage();
            }
            return $this->json($messages, Response::HTTP_BAD_REQUEST);
        }

        $repositoryAvis->save($avis, true);

        return $this->json($avis, Response::HTTP_OK);
    }
}
