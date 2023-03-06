<?php

namespace App\Controller\Api;

use App\Entity\Avis;
use App\Repository\AvisRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/avis', name: 'api_avis_')]
class AvisController extends AbstractController
{
    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(AvisRepository $repository, ?Avis $avis): JsonResponse
    {
        if (is_null($avis)) {
            return $this->json([
                'message' => 'Cet avis est introuvable'
            ]);
        }
        $repository->remove($avis, true);
        return $this->json([], Response::HTTP_NO_CONTENT);
    }

    #[Route('/{id}', name: 'edit', methods: ['PATCH'])]
    public function edit(Request $request, AvisRepository $repository, ValidatorInterface $validator, ?Avis $avis): JsonResponse
    {
        if (is_null($avis)) {
            return $this->json(["error" => "No avis found"], Response::HTTP_BAD_REQUEST);
        }
        $data = json_decode($request->getContent(), true);

        if (is_null($data)) {
            return $this->json(["error" => "Requête mal formattée"], Response::HTTP_BAD_REQUEST);
        }

        $avis->fromArray($data);

        $errors = $validator->validate($avis);
        if ($errors->count() > 0) {
            $messages = [];
            foreach ($errors as $error) {
                $messages[$error->getPropertyPath()] = $error->getMessage();
            }
            return $this->json($messages, Response::HTTP_BAD_REQUEST);
        }

        $repository->save($avis, true);
        return $this->json($avis, Response::HTTP_OK);
    }
}
