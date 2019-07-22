<?php

namespace App\Repository;

use App\Entity\Assemble;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Assemble|null find($id, $lockMode = null, $lockVersion = null)
 * @method Assemble|null findOneBy(array $criteria, array $orderBy = null)
 * @method Assemble[]    findAll()
 * @method Assemble[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssembleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Assemble::class);
    }

    // /**
    //  * @return Assemble[] Returns an array of Assemble objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Assemble
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
