<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController
{

    #[Route('/first', name: 'first')]
    public function index(): Response
    {
        return $this->render('first/index.html.twig', [
            'controller_name' => 'FirstController',
        ]);
    }

    public function passerMessage($name):Response
    {
        return $this->render('first/message.html.twig',[
            'nom'=>$name,
        ]);
    }

    #[Route('/sayHello/{name}', name: 'say.hello')]
    public function sayHello($name):Response
    {
        return $this->render('first/hello.html.twig',[
            'nom'=>$name,
            'path' =>'   '
        ]);
    }

    #[Route('multi/{entier1<\d+>}/{entier2<\d+>}',
        name:'multiplication'
    )]
    public function multiplication($entier1, $entier2):Response{
        $resultat = $entier1 * $entier2;
        return new Response("<h1>$resultat</h1>");
    }

    #[Route('/template', name: 'template')]
    public function template(): Response
    {
        return $this->render('template.html.twig');
    }
}
