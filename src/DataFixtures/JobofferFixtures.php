<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Joboffer;
use Faker\Factory;

class JobofferFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 5; $i++) {//anti phpcs
            $joboffer = new Joboffer();

            $joboffer
                ->setTitle($faker->word)
                ->setDescription($faker->text)
                ->setCompany($this->getReference('company_' . $i))
                ->setJob($this->getReference('job_0'))
                ->setSalary($this->getReference('salary_' . $i))
                ->setCity($faker->city)
                ->setContract($this->getReference('contract_' . $i));

            $manager->persist($joboffer);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CompanyFixtures::class,
            ContractFixtures::class,
            JobFixtures::class,
            SalaryFixtures::class,
        ];
    }
}
