<?php

declare(strict_types=1);

namespace App\Repository;


use App\Entity\QuizGame;
use App\Entity\QuizGameQuestion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class QuizGameQuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuizGameQuestion::class);
    }

    public function getResults(QuizGame $game)
    {
        $qb = $this->createQueryBuilder('q');
        $qb
            ->select("SUM(q.correct) as correct, COUNT(q.id) as all")
            ->where('q.quizGame = :game')->setParameter('game', $game)
            ->andWhere($qb->expr()->isNotNull('q.correct'))
            ->groupBy('q.quizGame')
        ;

        try {
            return $qb->getQuery()->getSingleResult();
        } catch (\Exception $e) {
            return null;
        }

    }

    public function getAnsweredQuestionsForGame(QuizGame $game)
    {
        $qb = $this->createQueryBuilder('q');
        $qb
            ->where('q.quizGame = :game')->setParameter('game', $game)
            ->andWhere($qb->expr()->isNotNull('q.correct'))
        ;

        return $qb->getQuery()->getResult();
    }
}