<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Faker\Factory;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    private UserPasswordHasherInterface $hasher;

    /**
     * @param UserPasswordHasherInterface $hasher
     */
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $admin = new User();
        $admin->setFirstname($faker->firstName());
        $admin->setLastname($faker->lastName());
        $admin->setEmail('admin@jobitbetter.com');
        $admin->setPassword($this->hasher->hashPassword($admin, 'admin'));
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        for ($i = 0; $i < 10; $i++) {
            $company = new User();
            $company->setFirstname($faker->firstName());
            $company->setLastname($faker->lastName());
            $company->setEmail('company' . $i . '@jobitbetter.com');
            $company->setPassword($this->hasher->hashPassword($company, 'company'));
            $company->setRoles(['ROLE_COMPANY']);
            $this->addReference('user_' . $i, $company);
            $manager->persist($company);
        }

        $user = new User();
        $user->setFirstname($faker->firstName());
        $user->setLastname($faker->lastName());
        $user->setEmail('user@jobitbetter.com');
        $user->setPassword($this->hasher->hashPassword($user, 'user'));
        $user->setRoles(['ROLE_USER']);
        $user->addResume($this->getReference('resume-1'));
        $user->addResume($this->getReference('resume-2'));
        $manager->persist($user);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ResumeFixtures::class,
        ];
    }
}
