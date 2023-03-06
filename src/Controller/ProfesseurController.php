<?php

namespace App\Controller;

use App\Entity\Professeur;
use App\Form\ProfesseurType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProfesseurRepository;
use Symfony\Component\HttpFoundation\Request;

#[Route('/professeur', name: 'professeur_')]
class ProfesseurController extends AbstractController
{
    #[Route('', name: 'list', methods: ['GET'])]
    public function list(ProfesseurRepository $repository): Response
    {
        $professeurs = $repository->findAll();
        return $this->render('professeur/list.html.twig', ['professeurs' => $professeurs,]);
    }

    #[Route('/create', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, ProfesseurRepository $repository): Response
    {
        $professeur = new Professeur;
        $form = $this->createForm(ProfesseurType::class, $professeur);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $professeur = $form->getData();
            $repository->save($professeur, true);
            return $this->redirectToRoute('professeur_list');
        }
        return $this->render('professeur/create.html.twig', ['form' => $form->createView()]);
    }


    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ProfesseurRepository $repository, Professeur $professeur): Response
    {
        $form = $this->createForm(ProfesseurType::class, $professeur);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $professeur = $form->getData();
            $repository->save($professeur, true);
            return $this->redirectToRoute('professeur_list');
        }
        return $this->render('professeur/create.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/{id}/delete', name: 'delete', methods: ['GET'])]
    public function delete(ProfesseurRepository $repository, Professeur $professeur): Response
    {
        $repository->remove($professeur, true);
        return $this->redirectToRoute('professeur_list');
    }
}
