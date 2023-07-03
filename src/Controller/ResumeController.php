<?php

namespace App\Controller;

use App\Entity\Resume;
use App\Form\ResumeType;
use App\Repository\ResumeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/resume')]
class ResumeController extends AbstractController
{
    #[Route('/', name: 'app_resume_index', methods: ['GET'])]
    public function index(ResumeRepository $resumeRepository): Response
    {
        $resumes = $resumeRepository->findBy(['user' => $this->getUser()]);

        return $this->render('resume/index.html.twig', [
            'resumes' => $resumes,
        ]);
    }

    #[Route('/new', name: 'app_resume_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ResumeRepository $resumeRepository): Response
    {
        $resume = new Resume();
        $form = $this->createForm(ResumeType::class, $resume);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $resumeRepository->save($resume, true);

            return $this->redirectToRoute('app_resume_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('resume/new.html.twig', [
            'resume' => $resume,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_resume_show', methods: ['GET'])]
    public function show(Resume $resume): Response
    {
        return $this->render('resume/show.html.twig', [
            'resume' => $resume,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_resume_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Resume $resume, ResumeRepository $resumeRepository): Response
    {
        $form = $this->createForm(ResumeType::class, $resume);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $resumeRepository->save($resume, true);

            return $this->redirectToRoute('app_resume_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('resume/edit.html.twig', [
            'resume' => $resume,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_resume_delete', methods: ['POST'])]
    public function delete(Request $request, Resume $resume, ResumeRepository $resumeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $resume->getId(), $request->request->get('_token'))) {
            $resumeRepository->remove($resume, true);
        }

        return $this->redirectToRoute('app_resume_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/read', name: 'app_resume_read', methods: ['GET'])]
    public function readResume(Resume $resume): bool|int
    {
        $file = $this->getParameter('kernel.project_dir') . '/public/uploads/resume/' . $resume->getPath();
        header('Content-type: application/pdf');
        return readfile($file);
    }
}
