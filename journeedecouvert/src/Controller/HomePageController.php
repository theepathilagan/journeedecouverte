<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        return $this->render('/home-page.html.twig');
    }

    #[Route('/home', name: 'logged')]
    public function home(): Response
    {
        if($this->get('security.token_storage')->getToken()->getUser() !== null){
            return $this->render('home-page.html.twig');
        }
    }
}
