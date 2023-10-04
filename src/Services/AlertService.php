<?php

namespace App\Services;

use App\Entity\Alerte;
use App\Entity\User;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Cache\CacheItem;

class AlertService
{
    private Alerte $alerte;
    public function __construct()
    {
        $this->alerte = new Alerte();
    }

    public function addAlert(UserInterface $user, User $resumeUser): void
    {
        $this->alerte->setApplicant($resumeUser);
        $this->alerte->setEmployer($user->getCompany());
        $this->alerte->setMessage('Votre candidture  été vu');
        $this->alerte->setState(true);
    }
}
