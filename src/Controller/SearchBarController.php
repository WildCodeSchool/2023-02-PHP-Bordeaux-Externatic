<?php

namespace App\Controller;

use App\Form\SearchOfferType;
use App\Repository\JobofferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\isEmpty;

class SearchBarController extends AbstractController
{
    #[Route('/search', name: 'app_joboffer_search', methods: ['POST'])]
    public function search(
        FormFactoryInterface $formFactory,
        JobofferRepository $jobofferRepository,
        Request $request
    ): Response {

        $form = $formFactory->create(SearchOfferType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $credentials = $form->getData();
            $results = $jobofferRepository->search($credentials);
            return $this->render('joboffer/search.html.twig', [
                'joboffers' => $results,
            ]);
        }

        return $this->render('barSearch/_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
