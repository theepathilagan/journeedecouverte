<?php

namespace App\DataFixtures;

use App\Entity\Niveau;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class NiveauFixtures extends Fixture
{
    public const NIVEAU_OR = 'or';
    public const NIVEAU_ARGENT = 'argent';
    public const NIVEAU_BRONZE = 'bronze';

    public function load(ObjectManager $manager): void
    {
        $niveauBronze = new Niveau();
        $niveauBronze->setNom('Bronze');
        $niveauBronze->setMinPoints(0);
        $manager->persist($niveauBronze);

        $niveauArgent = new Niveau();
        $niveauArgent->setNom('Argent');
        $niveauArgent->setMinPoints(10);
        $manager->persist($niveauArgent);

        $niveauOr = new Niveau();
        $niveauOr->setNom('Or');
        $niveauOr->setMinPoints(30);
        $manager->persist($niveauOr);

        $manager->flush();

        $this->addReference(self::NIVEAU_OR, $niveauOr);
        $this->addReference(self::NIVEAU_ARGENT, $niveauArgent);
        $this->addReference(self::NIVEAU_BRONZE, $niveauBronze);
    }
}
