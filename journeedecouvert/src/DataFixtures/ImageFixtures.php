<?php

namespace App\DataFixtures;

use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ImageFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i=1; $i<=10; $i++){
            $image[$i] = new Image();
            $image[$i]->setName("image-$i.png");
            $image[$i]->setJd($this->getReference(JdFixtures::JD_PAST));

            $manager->persist($image[$i]);
        }
        $manager->flush();
    }
}
