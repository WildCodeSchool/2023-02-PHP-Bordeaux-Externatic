<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Job;

class JobFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $job = new Job();
        $job->setName('Développeur web');
        $job->setCategory($this->getReference('category_technologies'));

        $manager->persist($job);

        $job = new Job();
        $job->setName('Développeur mobile');
        $job->setCategory($this->getReference('category_technologies'));

        $manager->persist($job);

        $job = new Job();
        $job->setName('Scrum master');
        $job->setCategory($this->getReference('category_technologies'));

        $manager->persist($job);

        $job = new Job();
        $job->setName('Chef de projet');
        $job->setCategory($this->getReference('category_management'));

        $manager->persist($job);

        $job = new Job();
        $job->setName('Busniess developer');
        $job->setCategory($this->getReference('category_management'));

        $manager->persist($job);

        $job = new Job();
        $job->setName('Data scientist');
        $job->setCategory($this->getReference('category_data'));

        $manager->persist($job);

        $job = new Job();
        $job->setName('Data analyst');
        $job->setCategory($this->getReference('category_data'));

        $manager->persist($job);

        $job = new Job();
        $job->setName('Chargé de recrutement');
        $job->setCategory($this->getReference('category_rh'));

        $manager->persist($job);

        $job = new Job();
        $job->setName('Responsable formation');
        $job->setCategory($this->getReference('category_rh'));

        $manager->persist($job);

        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
