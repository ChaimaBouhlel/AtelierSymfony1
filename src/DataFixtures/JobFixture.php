<?php

namespace App\DataFixtures;

use App\Entity\Job;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class JobFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $jobs = ['Aéronautique Et Espace',
            'Agriculture - Agroalimentaire',
            'Artisanat',
            'Audiovisuel, Cinéma',
            'Audit, Comptabilité, Gestion',
            'Automobile',
            'Banque, Assurance',
            'Bâtiment, Travaux Publics',
            'Biologie, Chimie, Pharmacie',
            'Commerce, Distribution',
            'Communication',
            "Création, Métiers D'art",
            "Culture, Patrimoine",
            "Enseignement",
            "Fonction Publique",
            "Hôtellerie, Restauration"
            ];

        foreach ($jobs as $designation ){
            $job = new Job();
            $job->setDesignation($designation);
            $manager->persist($job);
        }
        $manager->flush();
    }
}
