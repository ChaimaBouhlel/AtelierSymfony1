<?php

namespace App\DataFixtures;

use App\Entity\Hobby;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HobbyFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $hobbies = ['soccer',
            'volleyball',
            'badminton',
            'yoga',
            'swimming',
            'ice skating',
            'rugby',
            'football',
            'ice hockey',
            'surfing',
            'tennis',
            'baseball',
            'gymnastics',
            'dancing',
            'gardening',
            'karate',
            'horse racing',
            'cycling',
            'fishing',
            'fencing',
            'singing',
            'skiing',
            'board games',
            'brewery games',
            'table tennis',
            'aerobics'];

        foreach ($hobbies as $designation ){
            $hobby = new Hobby();
            $hobby->setDesignation($designation);
            $manager->persist($hobby);
        }
        $manager->flush();
    }
}
