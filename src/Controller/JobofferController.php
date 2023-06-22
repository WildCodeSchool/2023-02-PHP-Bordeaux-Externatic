<?php

namespace App\Controller;

use App\Entity\Joboffer;
use App\Form\JobofferApplyType;
use App\Form\JobofferType;
use App\Repository\JobofferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/joboffer')]
class JobofferController extends AbstractController
{
    #[Route('/', name: 'app_joboffer_index', methods: ['GET'])]
    public function index(JobofferRepository $jobofferRepository): Response
    {
        return $this->render('joboffer/index.html.twig', [
            'joboffers' => $jobofferRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_joboffer_new', methods: ['GET', 'POST'])]
    public function new(Request $request, JobofferRepository $jobofferRepository): Response
    {
        $joboffer = new Joboffer();
        $form = $this->createForm(JobofferType::class, $joboffer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $jobofferRepository->save($joboffer, true);

            return $this->redirectToRoute('app_joboffer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('joboffer/new.html.twig', [
            'joboffer' => $joboffer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_joboffer_show', methods: ['GET'])]
    public function show(Joboffer $joboffer): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(JobofferApplyType::class, $user);

        return $this->render('joboffer/show.html.twig', [
            'joboffer' => $joboffer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_joboffer_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Joboffer $joboffer, JobofferRepository $jobofferRepository): Response
    {
        $form = $this->createForm(JobofferType::class, $joboffer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $jobofferRepository->save($joboffer, true);

            return $this->redirectToRoute('app_joboffer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('joboffer/edit.html.twig', [
            'joboffer' => $joboffer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_joboffer_delete', methods: ['POST'])]
    public function delete(Request $request, Joboffer $joboffer, JobofferRepository $jobofferRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $joboffer->getId(), $request->request->get('_token'))) {
            $jobofferRepository->remove($joboffer, true);
        }

        return $this->redirectToRoute('app_joboffer_index', [], Response::HTTP_SEE_OTHER);
    }
}
