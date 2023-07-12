<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StaticController extends AbstractController
{
    #[Route('/mentions-legales', name: 'app_legal_notice')]
    public function legalNotice(): Response
    {
        return $this->render('static/legal_notice.html.twig');
    }

    #[Route('/politique-de-confidentialite', name: 'app_privacy_policy')]
    public function privacyPolicy(): Response
    {
        return $this->render('static/privacy_policy.html.twig');
    }

    #[Route('/politique-de-cookies', name: 'app_cookie_policy')]
    public function cookiePolicy(): Response
    {
        return $this->render('static/cookie_policy.html.twig');
    }

    #[Route('/404error', name: '404_error')]
    public function error404(): Response
    {
        return $this->render('static/error404.html.twig');
    }

    #[Route('/403error', name: '403_error')]
    public function error403(): Response
    {
        return $this->render('static/error403.html.twig');
    }
}
