<?php

namespace App\Controller;

use App\Entity\Joboffer;
use App\Entity\Salary;
use App\Form\JobofferApplyType;
use App\Form\JobofferType;
use App\Repository\JobofferRepository;
use App\Repository\SalaryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Part\DataPart;

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
    public function new(
        Request $request,
        JobofferRepository $jobofferRepository,
        SalaryRepository $salaryRepository
    ): Response {
        $joboffer = new Joboffer();
        $salary = new Salary();
        $form = $this->createForm(JobofferType::class, $joboffer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $salaryMin = $form->get('salaryMin')->getData();
            $salaryMax = $form->get('salaryMax')->getData();

            $joboffer->setSalaryMin($salaryMin);
            $joboffer->setSalaryMax($salaryMax);
            $salary->setMin($salaryMin);
            $salary->setMax($salaryMax);

            $salaryRepository->save($salary, true);
            $jobofferRepository->save($joboffer, true);

            return $this->redirectToRoute('app_joboffer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('joboffer/new.html.twig', [
            'joboffer' => $joboffer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_joboffer_show', methods: ['GET', 'POST'])]
    public function show(
        Joboffer $joboffer,
        Request $request,
        EntityManagerInterface $manager,
        MailerInterface $mailer
    ): Response {
        $user = $this->getUser();
        $form = $this->createForm(JobofferApplyType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $candidate = $form->getData();
            $candidate->addJobOffer($joboffer);
            $manager->persist($candidate);
            $message = $request->get('message');
            $resumes = $candidate->getResumes();
            $attachment = null;
            foreach ($resumes as $resume) {
                $attachment = new File(
                    $this->getParameter('kernel.project_dir') . '/public/uploads/resume/' . $resume->getPath()
                );
            }

            $email = (new TemplatedEmail())
                ->from('your_email@example.com')
                ->to('a.sale@hotmail.fr')
                ->subject('Nouvelle candidature')
                ->addPart(new DataPart(fopen($attachment, 'r')))
                ->html($this->renderView('joboffer/jobOfferEmail.html.twig', [
                    'joboffer' => $joboffer,
                    'user' => $user,
                    'message' => $message,
                ]));


            $mailer->send($email);

            $this->addFlash('success', 'Votre candidature a bien été envoyée !');

            return $this->redirectToRoute('app_joboffer_index', [], Response::HTTP_SEE_OTHER);
        }

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

    #[Route('/{id}/favlist', name: 'app_joboffer_favlist', methods: ['GET', 'POST'])]
    public function addToFavlist(Joboffer $joboffer, UserRepository $userRepository): Response
    {
        /** @var  \App\Entity\User $user */
        $user = $this->getUser();

        if ($user->isInFavlist($joboffer)) {
            $user->removeFromFavlist($joboffer);
        } else {
            $user->addToFavlist($joboffer);
        }

        $userRepository->save($user, true);


        return $this->json([
            'isInFavlist' => $user->isInFavlist($joboffer)
        ]);
    }
}
