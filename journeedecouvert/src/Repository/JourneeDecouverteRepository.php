<?php

namespace App\Repository;

use App\Entity\JourneeDecouverte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method JourneeDecouverte|null find($id, $lockMode = null, $lockVersion = null)
 * @method JourneeDecouverte|null findOneBy(array $criteria, array $orderBy = null)
 * @method JourneeDecouverte[]    findAll()
 * @method JourneeDecouverte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JourneeDecouverteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JourneeDecouverte::class);
    }

    // /**
    //  * @return JourneeDecouverte[] Returns an array of JourneeDecouverte objects
    //  */

    public function findAllOrderByDate()
    {
        return $this->createQueryBuilder('j')
            ->orderBy('j.date', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?JourneeDecouverte
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
