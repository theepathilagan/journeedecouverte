<?php

namespace App\DataFixtures;

use App\Entity\Commentaire;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CommentaireFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 3; $i++) {
            $commentaire[$i] = new Commentaire();
            $commentaire[$i]->setContent('Mon commentaire qui veut rien dire ' . $i);
            $commentaire[$i]->setUser($this->getReference(UserFixtures::USER_BRONZE));
            $commentaire[$i]->setJd($this->getReference(JdFixtures::JD_PAST));
            $manager->persist($commentaire[$i]);
        }

        for ($i = 3; $i < 6; $i++) {
            $commentaire[$i] = new Commentaire();
            $commentaire[$i]->setContent('Je test mon commentaire ' . $i);
            $commentaire[$i]->setUser($this->getReference(UserFixtures::USER_ARGENT));
            $commentaire[$i]->setJd($this->getReference(JdFixtures::JD_PAST));
            $manager->persist($commentaire[$i]);
        }

        for ($i = 6; $i < 9; $i++) {
            $commentaire[$i] = new Commentaire();
            $commentaire[$i]->setContent('Je test ce commentaire de tesst ' . $i);
            $commentaire[$i]->setUser($this->getReference(UserFixtures::USER_OR));
            $commentaire[$i]->setJd($this->getReference(JdFixtures::JD_PAST));
            $manager->persist($commentaire[$i]);
        }
        $manager->flush();
    }
}
