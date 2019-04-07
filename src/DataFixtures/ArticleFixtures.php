<?php

namespace App\DataFixtures;

use App\Entity\Player;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i = 1; $i <= 10; $i++){
            $player = new Player();
            $player->setName("Nom du joueur n $i")
            ->setLevel(1)
            ->setExperience(0)
            ->setSkillpnt(0)
            ->setHp(100)
            ->setAtk(2)
            ->setImage("http://placehold.it/350*150")
            ->setCreatedAt(new \DateTime());

            $manager->persist($player);
        }
        $manager->flush();
    }
}
