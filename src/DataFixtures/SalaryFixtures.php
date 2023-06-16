<?php

namespace App\DataFixtures;

use App\Entity\Salary;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class SalaryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $salary = new Salary();
            $salary->setMin($faker->numberBetween(15000, 20000));
            $salary->setMax($faker->numberBetween(20000, 70000));
            $this->addReference('salary_' . $i, $salary);

            $manager->persist($salary);
        }

        $manager->flush();
    }
}
