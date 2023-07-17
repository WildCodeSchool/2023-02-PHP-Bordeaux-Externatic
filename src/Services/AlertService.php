<?php

namespace App\Services;

use App\Entity\User;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Cache\CacheItem;

class AlertService
{
    private CacheItem $cacheItem;

    public function __construct()
    {
        $this->cacheItem = new CacheItem();
    }

    public function addAlert(int $id, User $user): void
    {
        $cache = new FilesystemAdapter();
        $alert = $cache->getItem('alert_' . $id);


        if ($alert->isHit()) {
            $consultingCompany = $alert->get();
            $consultingCompany[] = $user;
            $alert->set($consultingCompany);
        } else {
            $consultingCompany = [];
            $consultingCompany[] = $user;
            $alert->set($consultingCompany);
        }
            $cache->save($alert);
    }
    public function setAlert(UserInterface $user): object
    {
        $cache = new FilesystemAdapter();
        $this->cacheItem = $cache->getItem('alert_' . $user->getId());
        $this->cacheItem->expiresAfter(3600);
        $this->cacheItem->tag(['user', 'user_' . $user->getId()]);
        $this->cacheItem->set($user);

        $cache->save($this->cacheItem);
        return $this->cacheItem;
    }
}
