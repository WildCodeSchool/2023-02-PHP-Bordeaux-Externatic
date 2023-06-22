<?php

namespace App\DataFixtures;

use App\Entity\Company;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CompanyFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        // $fakerSiret = new Generator();
        // $fakerSiret->addProvider(new FakerCompany($fakerSiret));

        for ($i = 0; $i < 5; $i++) {
            $company = new Company();
            $company->setName($faker->company)
               ->setCity($faker->city)
               ->setPhone($faker->phoneNumber)
               ->setSiret('14430323700834')
               ->setLogo($faker->imageUrl(640, 480, 'cats'))
                ->setUser($this->getReference('user_' . $i));
            $this->addReference('company_' . $i, $company);
            $manager->persist($company);
        }
           $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class
        ];
    }
}
