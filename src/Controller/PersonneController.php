<?php

namespace App\Controller;

use App\Entity\Personne;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('personne')]

class PersonneController extends AbstractController
{
    #[Route('/', name: 'personne.list')]
    public function index(ManagerRegistry $doctrine):Response {
        $repository = $doctrine->getRepository(Personne::class);
        $personnes = $repository->findAll();
        return $this->render('personne/index.html.twig',[
            'personnes' => $personnes,
            'isPaginated' => false,
        ]);
    }

    #[Route('/all/age/{ageMin}/{ageMax}/', name: 'personne.list.age')]
    public function personnesByAge(ManagerRegistry $doctrine, $ageMin, $ageMax):Response {
        $repository = $doctrine->getRepository(Personne::class);
        $personnes = $repository->findPersonnesByAgeInterval($ageMin, $ageMax);
        return $this->render('personne/index.html.twig',[
            'personnes' => $personnes,
            'isPaginated' => false,
        ]);
    }

    #[Route('/stats/age/{ageMin}/{ageMax}/', name: 'personne.list.age')]
    public function statsPersonnesByAge(ManagerRegistry $doctrine, $ageMin, $ageMax):Response {
        $repository = $doctrine->getRepository(Personne::class);
        $stats = $repository->statsPersonnesByAgeInterval($ageMin, $ageMax);
        return $this->render('personne/stats.html.twig',[
            'stats' => $stats[0],
            'ageMin' => $ageMin,
            'ageMax' => $ageMax
        ]);
    }

    #[Route('/all/{page?1}/{nbre?12}', name: 'personne.list.all')]
    public function indexAll(ManagerRegistry $doctrine, $page, $nbre):Response {
        $repository = $doctrine->getRepository(Personne::class);
        $nbPersonnes = $repository->count([]);

        $nbPages = ceil($nbPersonnes /  $nbre);

        $personnes = $repository->findBy([],[],$nbre,($page - 1) * $nbre);

        return $this->render('personne/index.html.twig',[
            'personnes' => $personnes,
            'isPaginated' => true,
            'nbPages' => $nbPages,
            'page' => $page,
            'nbre' => $nbre
        ]);
    }

    #[Route('/{id<\d+>}', name: 'personne.detail')]
    public function detail(Personne $personne = null):Response {
        if (!$personne){
            $this->addFlash('error',"La personne n'existe pas.");
            return $this->redirectToRoute('personne.list');
        }
        return $this->render('personne/detail.html.twig',[
            'personne' => $personne
        ]);
    }

    #[Route('/add', name: 'personne.add')]
    public function addPersonne(ManagerRegistry $doctrine): Response
    {
        //$this->getDoctrine() : Version sf <=5
        $entityManager = $doctrine->getManager();
        $personne = new Personne();
        $personne->setFirstname("Chaima");
        $personne->setName("Bouhlel");
        $personne->setAge(21);

        //Ajouter l'opération d'insertion de la personne dans ma transaction
        $entityManager->persist($personne);

        //Exécuter ma transaction
        $entityManager->flush();

        return $this->render('personne/detail.html.twig', [
            'personne' => $personne,
        ]);
    }

    #[Route("/delete/all", name: 'personne.delete.all')]
    public function deleteAllPersonnes(ManagerRegistry $doctrine ):RedirectResponse{
        $repo = $doctrine->getRepository(Personne::class);
        $personnes = $repo->findAll();
        $manager = $doctrine->getManager();
        foreach ($personnes as $personne ){
            $manager->remove($personne);
        }
        $manager->flush();
        $this->addFlash("info", 'Toutes les personnes sont supprimées');
        return $this->redirectToRoute("personne.list");
    }

    #[Route("/delete/{id}", name: 'personne.delete')]
    public function deletePersonne(ManagerRegistry $doctrine, Personne $personne = null):RedirectResponse{
        if($personne){
            $manager = $doctrine->getManager();
            $manager->remove($personne);
            $manager->flush();
            $this->addFlash('success', 'La personne a été supprimée avec succès');
        }else{
            $this->addFlash('error', "La personne n'existe pas");
        }
        return $this->redirectToRoute("personne.list.all");
    }

    #[Route('/update/{id}/{name}/{firstname}/{age}', name: 'personne.update')]
    public function updatePersonne(Personne $personne = null, ManagerRegistry $doctrine, $name, $firstname, $age){
        if ($personne){
            $personne->setName($name);
            $personne->setFirstname($firstname);
            $personne->setAge($age);
            $manager = $doctrine->getManager();
            $manager->persist($personne);
            $manager->flush();
            $this->addFlash('success', 'La personne a été mise à jour avec succès');
        }else{
            $this->addFlash('error', "La personne n'existe pas");
        }
        return $this->redirectToRoute("personne.list.all");
    }


}
