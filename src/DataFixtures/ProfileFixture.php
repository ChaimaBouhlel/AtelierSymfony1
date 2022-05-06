<?php

namespace App\DataFixtures;

use App\Entity\Profile;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProfileFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $profile = new Profile();
        $profile->setUrl('https://www.facebook.com/chaima.bouhlel.77');
        $profile->setRs('Facebook');
        $profile1 = new Profile();
        $profile1->setUrl('https://twitter.com/chaimabouhlel1');
        $profile1->setRs('Twitter');
        $profile2 = new Profile();
        $profile2->setUrl('https://www.linkedin.com/in/chaima-bouhlel-179431206/');
        $profile2->setRs('Linkedin');
        $profile3 = new Profile();
        $profile3->setUrl('https://www.facebook.com/en.ligne.18');
        $profile3->setRs('Facebook');
        $profile4 = new Profile();
        $profile4->setUrl('https://github.com/ChaimaBouhlel');
        $profile4->setRs('Github');
        $manager->persist($profile);
        $manager->persist($profile1);
        $manager->persist($profile2);
        $manager->persist($profile3);
        $manager->persist($profile4);
        $manager->flush();
    }
}
