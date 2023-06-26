<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\User;
use App\Form\CompanyType;
use App\Form\RegistrationFormType;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager,
    ): Response {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user, (new TemplatedEmail())
                    ->from(new Address('bienvenue@jobitbetter.com', 'Validation de l\'adresse email Job IT Better'))
                    ->to($user->getEmail())
                    ->subject('Merci de confirmer ton email !')
                    ->htmlTemplate('registration/confirmation_email.html.twig'));
            // do anything else you need here, like send an email
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/register/company', name: 'app_register_company')]
    public function registerCompany(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager,
    ): Response {
        $user = new User();
        $company = new Company();

        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->add('company', CompanyType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setRoles(['ROLE_ENTERPRISE']);
            $user->setCompany($company);

            $entityManager->persist($user);

            $company->setName($form->get('company')->get('name')->getData());
            $company->setCity($form->get('company')->get('city')->getData());
            $company->setPhone($form->get('company')->get('phone')->getData());
            $company->setLogo($form->get('company')->get('logo')->getData());
            $company->setSiret($form->get('company')->get('siret')->getData());

            $entityManager->persist($company);
            $entityManager->flush();

            // generate a signed url and email it to the user
            //$this->emailVerifier->sendEmailConfirmation('app_verify_email', $user, (new TemplatedEmail())
            //    ->from(new Address('bienvenue@jobitbetter.com', 'Validation de l\'adresse email Job IT Better'))
            //    ->to($user->getEmail())
            //    ->subject('Merci de confirmer ton email !')
            //    ->htmlTemplate('registration/confirmation_email.html.twig'));
            // do anything else you need here, like send an email
        }

        return $this->render('registration/registerCompany.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_register');
        }

        $this->addFlash('success', 'Ton email est confirmé.');

        return $this->redirectToRoute('app_home');
    }
}
