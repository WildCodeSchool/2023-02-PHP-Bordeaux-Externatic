<?php

namespace App\DataFixtures;

use App\Entity\Resume;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ResumeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $resume = new Resume();
        $resume->setName('CV principal');
        $resume->setPath('assets/uploads/resumes/CVKevindavoust.pdf');
        $this->addReference('resume-1', $resume);

        $manager->persist($resume);

        $manager->flush();
    }
}
