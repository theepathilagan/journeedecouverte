<?php

namespace App\DataFixtures;

use App\Entity\Participation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ParticipationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i=0; $i<5; $i++){
            $participation[$i] = new Participation();
            $participation[$i]->setUser($this->getReference(UserFixtures::USER_ARGENT));
            $participation[$i]->setJd($this->getReference(JdFixtures::JD_PAST));
            $participation[$i]->setPresent(0);

            $manager->persist($participation[$i]);
        }

        for($i=5; $i<10; $i++){
            $participation[$i] = new Participation();
            $participation[$i]->setUser($this->getReference(UserFixtures::USER_OR));
            $participation[$i]->setJd($this->getReference(JdFixtures::JD_PAST));
            $participation[$i]->setPresent(1);

            $manager->persist($participation[$i]);
        }

        for($i=10; $i<20; $i++){
            $participation[$i] = new Participation();
            $participation[$i]->setUser($this->getReference(UserFixtures::USER_BRONZE));
            $participation[$i]->setJd($this->getReference(JdFixtures::JD_FUTUR));
            $participation[$i]->setPresent(0);

            $manager->persist($participation[$i]);
        }

        for($i=20; $i<30; $i++){
            $participation[$i] = new Participation();
            $participation[$i]->setUser($this->getReference(UserFixtures::USER_ARGENT));
            $participation[$i]->setJd($this->getReference(JdFixtures::JD_FUTUR));
            $participation[$i]->setPresent(0);

            $manager->persist($participation[$i]);
        }

        $manager->flush();
    }
}
