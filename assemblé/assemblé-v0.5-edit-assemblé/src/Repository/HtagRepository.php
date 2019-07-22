<?php

namespace App\Repository;

use App\Entity\Htag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Htag|null find($id, $lockMode = null, $lockVersion = null)
 * @method Htag|null findOneBy(array $criteria, array $orderBy = null)
 * @method Htag[]    findAll()
 * @method Htag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HtagRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Htag::class);
    }

    // /**
    //  * @return Htag[] Returns an array of Htag objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Htag
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
