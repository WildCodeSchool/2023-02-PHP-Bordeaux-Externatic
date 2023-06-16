<?php

namespace App\DataFixtures;

use App\Entity\Company;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CompanyFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 50; $i++) {
            $company = new Company();
            $company->setName($faker->company)
               ->setCity($faker->city)
               ->setEmail($faker->email)
               ->setPhone($faker->phoneNumber)
               ->setSiret($faker->randomNumber(9, true))
               ->setLogo($faker->imageUrl(640, 480, 'cats'));
            $manager->persist($company);
        }
           $manager->flush();
    }
}
