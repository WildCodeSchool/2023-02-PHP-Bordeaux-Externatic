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
        $this->addReference('category_technologies', $category);
        $manager->persist($category);

        $category = new Category();
        $category->setName('Management / Marketing');
        $this->addReference('category_management', $category);
        $manager->persist($category);

        $category = new Category();
        $category->setName('DATA');
        $this->addReference('category_data', $category);
        $manager->persist($category);

        $category = new Category();
        $category->setName('Ressources humaines');
        $this->addReference('category_rh', $category);
        $manager->persist($category);

        $manager->flush();
    }
}
