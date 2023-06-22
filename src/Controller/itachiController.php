<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use DateTime;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CandidatController extends AbstractController
{
    #[Route('/candidat/{id}', name: 'app_candidat')]
    public function index(User $user): Response
    {
        $date = new DateTime();
        $dateString = $date->format('Y-m-d H:i:s');

        return $this->render('candidat/index.html.twig', [
            'currentDateTime' => $dateString
        ]);
    }
}
