<?php

namespace App\Repository;

use App\Entity\QuestionSurvey;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method QuestionSurvey|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuestionSurvey|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuestionSurvey[]    findAll()
 * @method QuestionSurvey[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionSurveyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, QuestionSurvey::class);
    }

    // /**
    //  * @return QuestionSurvey[] Returns an array of QuestionSurvey objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?QuestionSurvey
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
