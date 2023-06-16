<?php

namespace App\DataFixtures;

use App\Entity\Company;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CompanyFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        // $fakerSiret = new Generator();
        // $fakerSiret->addProvider(new FakerCompany($fakerSiret));

        for ($i = 0; $i < 50; $i++) {
            $company = new Company();
            $company->setName($faker->company)
               ->setCity($faker->city)
               ->setEmail($faker->email)
               ->setPhone($faker->phoneNumber)
               ->setSiret('14430323700834')
               ->setLogo($faker->imageUrl(640, 480, 'cats'));
                $this->addReference('company_' . $i, $company);
            $manager->persist($company);
        }
           $manager->flush();
    }
}
