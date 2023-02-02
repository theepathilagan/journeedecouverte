<?php

namespace App\DataFixtures;

use App\Entity\JourneeDecouverte;
use DateInterval;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class JdFixtures extends Fixture
{
    const JD_PAST = 'jd-past';
    const JD_FUTUR = 'jd-futur';

    public function load(ObjectManager $manager): void
    {
        $yesterday = new \DateTime('@'.strtotime('yesterday'));

        $jdPast = new JourneeDecouverte();
        $jdPast->setTitle('Une journée qui est passé');
        $jdPast->setDate($yesterday);
        $jdPast->setLieu('Alpes');
        $jdPast->setNbMaxGrimpeurs(10);
        $jdPast->setOrganisateur($this->getReference(UserFixtures::USER_OR));
        $jdPast->setNiveauMinimum($this->getReference(NiveauFixtures::NIVEAU_ARGENT));

        $manager->persist($jdPast);

        $tomorrow = new \DateTime('@'.strtotime('tomorrow'));

        $jdFutur = new JourneeDecouverte();
        $jdFutur->setTitle('Une journée dans le futur');
        $jdFutur->setDate($tomorrow);
        $jdFutur->setLieu('Paris');
        $jdFutur->setNbMaxGrimpeurs(30);
        $jdFutur->setOrganisateur($this->getReference(UserFixtures::USER_OR));
        $jdFutur->setNiveauMinimum($this->getReference(NiveauFixtures::NIVEAU_BRONZE));

        $manager->persist($jdFutur);

        $manager->flush();

        $this->addReference(self::JD_PAST, $jdPast);
        $this->addReference(self::JD_FUTUR, $jdFutur);
    }
}
