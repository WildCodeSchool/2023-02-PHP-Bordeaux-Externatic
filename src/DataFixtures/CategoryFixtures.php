<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $category = new Category();
        $category->setName('Technologies');
        $manager->persist($category);

        $category = new Category();
        $category->setName('Management / Marketing');
        $manager->persist($category);

        $category = new Category();
        $category->setName('DATA');
        $manager->persist($category);

        $category = new Category();
        $category->setName('Ressources humaines');
        $manager->persist($category);

        $manager->flush();
    }
}
