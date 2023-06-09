<?php

namespace App\Controller;

use App\Entity\Search;
use App\Form\SearchType;
use App\Repository\SearchRepository;
use App\Services\SearchService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/search')]
class SearchController extends AbstractController
{
    #[Route('/', name: 'app_search_index', methods: ['GET'])]
    public function index(SearchRepository $searchRepository): Response
    {
        return $this->render('search/index.html.twig', [
            'searches' => $searchRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_search_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SearchRepository $searchRepository): Response
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $searchRepository->save($search, true);

            return $this->redirectToRoute('app_search_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('search/new.html.twig', [
            'search' => $search,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_search_show', methods: ['GET'])]
    public function show(Search $search): Response
    {
        return $this->render('search/show.html.twig', [
            'search' => $search,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_search_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Search $search, SearchRepository $searchRepository): Response
    {
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $searchRepository->save($search, true);

            return $this->redirectToRoute('app_search_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('search/edit.html.twig', [
            'search' => $search,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_search_delete', methods: ['GET','POST'])]
    public function delete(
        Request $request,
        Search $search,
        SearchRepository $searchRepository,
        EntityManagerInterface $manager,
        SearchService $searchService
    ): Response {
        $user = $this->getUser();

        if ($searchService->hasSearch($search, $user)) {
            $searchService->removeSearch($search);
            $manager->flush();
        }
        $this->addFlash('success', 'Votre recherche a bien été supprimée');
        return $this->redirectToRoute('app_user_search', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
    }
}
