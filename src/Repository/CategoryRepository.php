<?php

declare(strict_types=1);

namespace App\Repository;


use App\Entity\Category;
use App\Entity\Question;
use App\Entity\QuizGame;
use App\Entity\QuizGameQuestion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use function Doctrine\ORM\QueryBuilder;

class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function getAvailableCategories(QuizGame $game)
    {
        $qb = $this->createQueryBuilder('c');
        $qb
            ->join(Question::class, 'q', 'WITH', 'q.category = c')
            ->leftJoin(QuizGameQuestion::class, 'gq', 'WITH', 'gq.question = q AND gq.quizGame = :game')->setParameter('game', $game)
            ->where($qb->expr()->isNull('gq'))
            ->andWhere('q.quiz = :quiz')->setParameter('quiz', $game->getQuiz())
        ;

        return $qb->getQuery()->getResult();
    }
}