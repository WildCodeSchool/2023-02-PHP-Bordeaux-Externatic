<?php

namespace App\Security;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Bundle\SecurityBundle\Security as SecurityBundleSecurity;

class LoginFormAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';
    private $userRepository;
    private SecurityBundleSecurity $security;

    public function __construct(
        private UrlGeneratorInterface $urlGenerator,
        UserRepository $userRepository,
        SecurityBundleSecurity $security
    ) {
        $this->userRepository = $userRepository;
        $this->security = $security;
    }

    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('username');
        $user = $this->userRepository->findOneBy(['email' => $email]);
        if (!$user) {
            throw new CustomUserMessageAuthenticationException(
                'L\'email n\'existe pas.'
            );
        }
        if ($user->isVerified() === false) {
            throw new CustomUserMessageAuthenticationException(
                'Votre compte n\'est pas encore validé. Veuillez vérifier vos mails.'
            );
        }
        $request->getSession()->set(Security::LAST_USERNAME, $email);

        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($request->request->get('password', '')),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        if ($this->security->isGranted('ROLE_ADMIN')) {
            // c'est un admin : on le redirige vers l'espace admin
            $redirection = new RedirectResponse(
                $this->urlGenerator->generate('admin')
            );
        } elseif ($this->security->isGranted('ROLE_COMPANY')) {
            $idCompany = $this->security->getUser()->getCompany()->getId();
            // c'est une entreprise : on la redirige vers l'espace entreprise
            $redirection = new RedirectResponse(
                $this->urlGenerator->generate('app_company_show', ['id' => $idCompany])
            );
        } else {
            $idUser = $this->security->getUser()->getId();
            // c'est un utilisateur lambda : on le redirige vers l'espace candidat
            $redirection = new RedirectResponse(
                $this->urlGenerator->generate('app_user_show', ['id' => $idUser])
            );
        }
        return $redirection;
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
