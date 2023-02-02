<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Image;
use App\Entity\JourneeDecouverte;
use App\Entity\Niveau;
use App\Entity\Participation;
use App\Form\JdFormType;
use App\Repository\JourneeDecouverteRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JdController extends AbstractController
{

    protected $jdRepository;

    public function __construct(JourneeDecouverteRepository $journeeDecouverteRepository)
    {
        $this->jdRepository = $journeeDecouverteRepository;
    }

    #[Route('/journees-decouverte', name: 'jd.index')]
    public function index(): Response
    {
        $jdAll = $this->jdRepository->findAllOrderByDate();
        $niveau_or = $this->getDoctrine()
            ->getRepository(Niveau::class)
            ->findOneBy(['nom' => 'Or']);
        $admin = false;
        if ($this->getUser() && $this->getUser()->getNbPointsCompetence() >= $niveau_or->getMinPoints()){
            $admin = true;
        }

        return $this->render('jd/index.html.twig', [
            'jdAll' => $jdAll,
            'admin' => $admin,
        ]);
    }

    #[Route('/journees-decouverte/ajouter', name: 'jd.add')]
    public function add(Request $request, EntityManagerInterface $manager, UserRepository $userRepository): Response
    {
        $form = $this->createForm(JdFormType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $jd = $form->getData();
            $jd->setOrganisateur($this->getUser());
            $manager->persist($jd);

            $participation = new Participation();
            $participation->setJd($jd);
            $participation->setUser($this->getUser());
            $participation->setPresent(true);
            $manager->persist($participation);

            $manager->flush();

            return $this->redirectToRoute('jd.index');
        }

        return $this->renderForm('jd/add.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/journees-decouverte/details/{id}', name: 'jd.detail')]
    public function detail($id): Response
    {
        $jd = $this->jdRepository->find($id);
        $images = $this->getDoctrine()->getRepository(Image::class)->findBy(['jd' => $jd]);
        $comments = $this->getDoctrine()->getRepository(Commentaire::class)->findBy(['jd' => $jd]);
        $inscrit = false;

        if ($this->getUser()) {
            foreach ($this->getUser()->getParticipations() as $participation) {
                if ($participation->getJd() == $jd) {
                    $inscrit = true;
                    break;
                }
            }
        }
        if ($this->getUser() && $jd->getDate() < new \DateTime() && $jd->getOrganisateur() != $this->getUser()){
            $participants = $this->getDoctrine()->getRepository(Participation::class)->findBy(['jd' => $jd, 'present' => true]);

        } else {
            $participants = $this->getDoctrine()->getRepository(Participation::class)->findBy(['jd' => $jd]);
        }

        return $this->render('jd/details.html.twig', [
            'jd' => $jd,
            'images' => $images,
            'comments' => $comments,
            'participants' => $participants,
            'inscrit' => $inscrit,
        ]);
    }

    #[Route('/journees-decouverte/modifier/{id}', name: 'jd.modifiy')]
    public function modify($id, Request $request, EntityManagerInterface $manager): Response
    {
        $jd = $this->jdRepository->find($id);

        $form = $this->createForm(JdFormType::class, $jd);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $jd = $form->getData();
            $manager->persist($jd);
            $manager->flush();
            return $this->redirectToRoute('jd.index');
        }

        return $this->renderForm('jd/modify.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/journees-decouverte/delete/{id}', name: 'jd.delete', methods: ['POST'])]
    public function delete(Request $request, JourneeDecouverte $jd, EntityManagerInterface $manager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$jd->getId(), $request->request->get('_token'))) {
            $manager->remove($jd);
            $manager->flush();
        }
        return $this->redirectToRoute('jd.index');
    }

}
