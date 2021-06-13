<?php

declare(strict_types=1);

namespace App\Repository;


use App\Entity\Quiz;
use App\Entity\QuizGame;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class QuizRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Quiz::class);
    }

    public function getQuizzesWithGames()
    {
        $qb = $this->createQueryBuilder('q');
        $qb
            ->leftJoin(QuizGame::class, 'g', 'WITH', 'g.quiz = q')
            ->orderBy('q.id', 'desc')
        ;

        return $qb->getQuery()->getResult();
    }
}