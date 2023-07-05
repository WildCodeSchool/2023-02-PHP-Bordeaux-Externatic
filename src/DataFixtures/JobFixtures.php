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
        $this->addReference('job_0', $job);

        $manager->persist($job);

        $job = new Job();
        $job->setName('Développeur mobile');
        $job->setCategory($this->getReference('category_technologies'));
        $this->addReference('job_1', $job);

        $manager->persist($job);

        $job = new Job();
        $job->setName('Scrum master');
        $job->setCategory($this->getReference('category_technologies'));
        $this->addReference('job_2', $job);

        $manager->persist($job);

        $job = new Job();
        $job->setName('Chef de projet');
        $job->setCategory($this->getReference('category_management'));
        $this->addReference('job_3', $job);

        $manager->persist($job);

        $job = new Job();
        $job->setName('Business developer');
        $job->setCategory($this->getReference('category_management'));
        $this->addReference('job_4', $job);

        $manager->persist($job);

        $job = new Job();
        $job->setName('Data scientist');
        $job->setCategory($this->getReference('category_data'));
        $this->addReference('job_5', $job);

        $manager->persist($job);

        $job = new Job();
        $job->setName('Data analyst');
        $job->setCategory($this->getReference('category_data'));
        $this->addReference('job_6', $job);

        $manager->persist($job);

        $job = new Job();
        $job->setName('Chargé de recrutement');
        $job->setCategory($this->getReference('category_rh'));
        $this->addReference('job_7', $job);

        $manager->persist($job);

        $job = new Job();
        $job->setName('Responsable formation');
        $job->setCategory($this->getReference('category_rh'));
        $this->addReference('job_8', $job);

        $manager->persist($job);

        $job = new Job();
        $job->setName('Responsable RH');
        $job->setCategory($this->getReference('category_rh'));
        $this->addReference('job_9', $job);

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
