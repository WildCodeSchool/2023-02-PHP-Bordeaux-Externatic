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
        for ($i = 0; $i < 50; $i++) {//anti phpcs
            $joboffer = new Joboffer();
            $array = [1,2,3,4,5,6,7,8,9];
            $rand = array_rand($array);
            $number = $array[$rand];
            $cities = [
                'Paris', 'Lyon', 'Marseille', 'Toulouse', 'Nice', 'Nantes', 'Strasbourg', 'Montpellier', 'Bordeaux'
            ];
            $randCity = array_rand($cities);
            $city = $cities[$randCity];

            $joboffer
                ->setTitle($this->getReference('job_' . $number))
                ->setDescription($faker->text)
                ->setCompany($this->getReference('company_' . $number))
                ->setJob($this->getReference('job_' . $number))
                ->setSalary($this->getReference('salary_' . $number))
                ->setCity($city)
                ->setContract($this->getReference('contract_' . $number));

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
