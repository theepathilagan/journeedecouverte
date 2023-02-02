<?php

namespace App\Controller;

use App\Entity\JourneeDecouverte;
use App\Entity\Participation;
use App\Entity\User;
use App\Repository\ParticipationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ParticipationController extends AbstractController
{
    protected $participationRepository;

    public function __construct(ParticipationRepository $participationRepository)
    {
        $this->participationRepository = $participationRepository;
    }

    #[Route('/nouvelle-participation/{jd}', name: 'participation.add')]
    public function add(JourneeDecouverte $jd, EntityManagerInterface $manager): Response
    {
        if($this->getUser() && $jd) {
            $participation = new Participation();
            $participation->setUser($this->getUser());
            $participation->setJd($jd);
            $participation->setPresent(false);

            $manager->persist($participation);
            $manager->flush();

            return $this->redirectToRoute('jd.detail', ['id' => $jd->getId()]);
        }
        else {
            return $this->redirectToRoute('app_register');
        }
    }

    #[Route('/participation/{jd}', name: 'participation.update', methods: 'post')]
    public function setPrensence(JourneeDecouverte $jd, Request $request, EntityManagerInterface $manager){
        $data = $request->request->all();
        $participations = $this->participationRepository->findBy(['jd' => $jd->getId()]);
        foreach ($participations as $participation) {
            if (array_key_exists($participation->getUser()->getId(), $data)){
                $participation->setPresent(true);
            } else {
                $participation->setPresent(false);
            }
                $manager->persist($participation);
        }
        $manager->flush();

        return $this->redirectToRoute('jd.detail', ['id' => $jd->getId()]);
    }

    #[Route('/participation/delete/{jd}', name: 'participation.delete', methods: 'post')]
    public function unsubscribe(JourneeDecouverte $jd, EntityManagerInterface $manager){
        if($this->getUser()) {
            $participation = $this->participationRepository->findOneBy([
                'user' => $this->getUser()->getId(),
                'jd' => $jd->getId(),
            ]);
            $manager->remove($participation);
            $manager->flush();

            return $this->redirectToRoute('jd.detail', ['id' => $jd->getId()]);
        }
        else {
            return $this->redirectToRoute('app_register');
        }
    }

}
