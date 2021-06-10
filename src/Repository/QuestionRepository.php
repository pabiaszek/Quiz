<?php

declare(strict_types=1);

namespace App\Repository;


use App\Entity\Category;
use App\Entity\Question;
use App\Entity\QuizGame;
use App\Entity\QuizGameQuestion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class QuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
    }

    public function  getQuestionForGame(QuizGame $game, Category $category)
    {
        $qb = $this->createQueryBuilder('q');
        $qb
            ->addSelect('gq')
            ->leftJoin(QuizGameQuestion::class, 'gq', 'WITH', 'gq.question = q AND gq.quizGame = :game')->setParameter('game', $game)
            ->where('q.category = :category')->setParameter('category', $category)
            ->andWhere('q.quiz = :quiz')->setParameter('quiz', $game->getQuiz())
            ->andWhere($qb->expr()->isNull('gq.correct'))
            ->setMaxResults(1)
        ;

        return $qb->getQuery()->getResult();
    }
}