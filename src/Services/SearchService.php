<?php

namespace App\Services;

use AllowDynamicProperties;
use App\Entity\Search;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

#[AllowDynamicProperties] class SearchService
{
    public Search $search;
    private EntityManagerInterface $manager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->search = new Search();
        $this->manager = $entityManager;
    }

    public function addSearch(User $user, Search $search): static
    {
//        if (!$this->searches->contains($search)) {
//            $this->searches->add($search);
//            $search->setUser($this);
//        }
//        $this->search->setUser($user);
//        $this->search->setCity($search->getCity());
//        $this->search->setCompany($search->getCompany());
//        $this->search->setJob($search->getJob());
//        $this->search->setContract($search->getContract());
//        $this->search->setSalary($search->getSalary());
        $this->manager->persist($search);
        $this->manager->flush();

        return $this;
    }

    public function removeSearch(Search $search): static
    {
//        if ($this->searches->removeElement($search)) {
//            // set the owning side to null (unless already changed)
//            if ($search->getUser() === $this) {
//                $search->setUser(null);
//            }
//        }
//        $this->search->setUser(null);
//        $this->search->setCity(null);
//        $this->search->setCompany(null);
//        $this->search->setJob(null);
//        $this->search->setContract(null);
//        $this->search->setSalary(null);
        $this->manager->remove($search);

        return $this;
    }
    public function hasSearch(Search $search, User $user): bool
    {
        return $search->getUser() === $user;
    }
}
