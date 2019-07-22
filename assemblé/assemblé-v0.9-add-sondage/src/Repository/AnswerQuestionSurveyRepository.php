<?php

namespace App\Repository;

use App\Entity\AnswerQuestionSurvey;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AnswerQuestionSurvey|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnswerQuestionSurvey|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnswerQuestionSurvey[]    findAll()
 * @method AnswerQuestionSurvey[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnswerQuestionSurveyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AnswerQuestionSurvey::class);
    }

    // /**
    //  * @return AnswerQuestionSurvey[] Returns an array of AnswerQuestionSurvey objects
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
    public function findOneBySomeField($value): ?AnswerQuestionSurvey
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
