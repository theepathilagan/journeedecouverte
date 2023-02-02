<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;

class UserFixtures extends Fixture
{
    const USER_OR = 'user-or';
    const USER_ARGENT = 'user-argent';
    const USER_BRONZE = 'user-bronze';

    public function load(ObjectManager $manager): void
    {
        $userBronze = new User();
        $userBronze->setNom('Bronze');
        $userBronze->setPrenom('Jean');
        $userBronze->setEmail('bronze@bronze.fr');
        $userBronze->setPassword('$2y$13$kbedYesdUeMI1H27p9LOauk7GB8ty4CZ3hwnlYdhkxuceZn7c7sTi');       //user
        $userBronze->setNbPointsCompetence(0);
        $userBronze->setRoles($this->getReference(NiveauFixtures::NIVEAU_BRONZE));

        $manager->persist($userBronze);

        $userArgent = new User();
        $userArgent->setNom('Argent');
        $userArgent->setPrenom('Michel');
        $userArgent->setEmail('argent@argent.fr');
        $userArgent->setPassword('$2y$13$kbedYesdUeMI1H27p9LOauk7GB8ty4CZ3hwnlYdhkxuceZn7c7sTi');       //user
        $userArgent->setNbPointsCompetence(10);
        $userArgent->setRoles($this->getReference(NiveauFixtures::NIVEAU_ARGENT));

        $manager->persist($userArgent);

        $userOr = new User();
        $userOr->setNom('Or');
        $userOr->setPrenom('Bouder');
        $userOr->setEmail('or@or.fr');
        $userOr->setPassword('$2y$13$kbedYesdUeMI1H27p9LOauk7GB8ty4CZ3hwnlYdhkxuceZn7c7sTi');           //user
        $userOr->setNbPointsCompetence(30);
        $userOr->setRoles($this->getReference(NiveauFixtures::NIVEAU_OR));

        $manager->persist($userOr);

        $manager->flush();

        $this->addReference(self::USER_OR, $userOr);
        $this->addReference(self::USER_ARGENT, $userArgent);
        $this->addReference(self::USER_BRONZE, $userBronze);
    }
}
