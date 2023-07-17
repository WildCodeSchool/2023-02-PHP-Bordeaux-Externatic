<?php

namespace App\Controller;

use App\Form\SearchOfferType;
use App\Repository\JobofferRepository;
use App\Repository\SearchRepository;
use App\Services\AlertService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchBarController extends AbstractController
{
    #[Route('/search/all', name: 'app_joboffer_search_all', methods: ['GET', 'POST'])]
    public function searchAll(JobofferRepository $jobofferRepository): Response
    {
        return $this->render('joboffer/search.html.twig', [
            'joboffers' => $jobofferRepository->findAll(),
        ]);
    }

    #[Route('/search', name: 'app_joboffer_search', methods: ['GET', 'POST'])]
    public function search(
        FormFactoryInterface $formFactory,
        JobofferRepository $jobofferRepository,
        Request $request,
        AlertService $alertService
    ): Response {

        $form = $formFactory->create(SearchOfferType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $credentials = $form->getData();
            $results = $jobofferRepository->search($credentials);
            $alert = $alertService->setAlert($this->getUser());
            $alert = $alert->get();
            return $this->render('joboffer/search.html.twig', [
                'joboffers' => $results,
                'alerts' => $alert,
            ]);
        }


        return $this->render('barSearch/_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/search/ma-recherche', name: 'app_joboffer_Mysearch', methods: ['GET', 'POST'])]
    public function mySearch(
        Request $request,
        JobofferRepository $jobofferRepository,
        SearchRepository $searchRepository,
        AlertService $alertService
    ): Response {
        $searchId = $request->request->get('searchId');
        $search = $searchRepository->find($searchId);
        $alert = $alertService->setAlert($this->getUser());
        $alert = $alert->get();

        $result =  $jobofferRepository->findByMySearch($search);
        return $this->render('joboffer/search.html.twig', [
            'joboffers' => $result,
            'alerts' => $alert,
        ]);
    }
}
