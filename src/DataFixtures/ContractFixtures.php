<?php

namespace App\DataFixtures;

use App\Entity\Contract;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ContractFixtures extends Fixture
{
    private const CONTRACTS = [
        'CDI',
        'CDD',
        'Stage',
        'Alternance',
        'Freelance',
        'Intérim',
        'Indépendant',
        'Apprentissage',
        'Temps partiel',
        'Temps plein',
    ];

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $contract = new Contract();
            $contract->setType(self::CONTRACTS[$i]);
            $this->addReference('contract_' . $i, $contract);

            $manager->persist($contract);
        }
        $manager->flush();
    }
}
