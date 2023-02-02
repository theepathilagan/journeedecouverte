<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\JourneeDecouverte;
use App\Entity\Participation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentaireController extends AbstractController
{
    #[Route('jd/commentaire', name: 'commentaires')]
    public function index(Request $request): Response
    {
        $jd_id = $request->query->get('id');

        $cmt = $this->getDoctrine()
            ->getRepository(Commentaire::class)
            ->findByJdID($jd_id);

        return $this->render('commentaire/index.html.twig', [
            'commentaires' => $cmt,
            'jd_id' => $jd_id
        ]);
    }

    #[Route('jd/{jd_id}/commentaire/{id}', name: 'commentaireDetails')]
    public function details($id, $jd_id): Response
    {
        $commentaire = $this->getDoctrine()
            ->getRepository(Commentaire::class)
            ->find($id);

        return $this->render('commentaire/details.html.twig',[
            'commentaire' => $commentaire,
            'jd_id' => $jd_id
        ]);
    }


    #[Route('journee-decouverte/{jd_id}/commentaires/add', name: 'commentaireAdd',methods: 'GET')]
    public function add($jd_id): Response {
        return $this->render('commentaire/add.html.twig',[
            'jd_id' => $jd_id
        ]);
    }
    #[Route('jd/{jd_id}/commentaires/add', name: 'commentaireStore',methods: 'POST')]
    public function store($jd_id, Request $request,EntityManagerInterface $entityManager): Response {
        $user = $this->getUser();

        $req = $request->request->all();
        $comment = new Commentaire();
        $comment->setContent($req['content']);
        $comment->setUser($user);

        $jd = $this->getDoctrine()
            ->getRepository(JourneeDecouverte::class)
            ->find($jd_id);

        $comment->setJd($jd);

        $entityManager->persist($comment);
        $entityManager->flush();

        return $this->redirectToRoute('jd.detail',[
            'id' => $jd_id
        ]);
    }
}
