<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Config\Framework\RequestConfig;

class FirstController extends AbstractController
{
    #[Route('/first', name: 'app_first')]
    public function index(): Response
    {
        return $this->render('first/index.html.twig', [
            'controller_name' => 'FirstController',
        ]);
    }

    #[Route('/sayHello/{name}', name: 'say.hello')]
    public function sayHello(Request $request,$name):Response
    {
        dd($request);
        return $this->render('first/hello.html.twig',[
            'nom'=>$name
        ]);
    }
}
