<?php

namespace App\Repository;

use App\Entity\AnswerSurvey;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AnswerSurvey|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnswerSurvey|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnswerSurvey[]    findAll()
 * @method AnswerSurvey[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnswerSurveyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AnswerSurvey::class);
    }

    // /**
    //  * @return AnswerSurvey[] Returns an array of AnswerSurvey objects
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
    public function findOneBySomeField($value): ?AnswerSurvey
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
