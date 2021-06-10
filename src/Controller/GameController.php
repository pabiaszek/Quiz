<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Quiz;
use App\Entity\QuizGame;
use App\Entity\QuizGameQuestion;
use App\Repository\CategoryRepository;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;

class GameController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * GameController constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function startQuizAction(Quiz $quiz)
    {
        $game = new QuizGame();
        $game->setQuiz($quiz);
        $this->entityManager->persist($game);
        $this->entityManager->flush();

        return $this->redirectToRoute('game_categories', ['game' => $game->getId()]);
    }

    public function categoriesAction(QuizGame $game, CategoryRepository $repository)
    {
        $categories = $repository->getAvailableCategories($game);

        return $this->render('/Game/admin/categories.html.twig', [
            'categories' => $categories,
            'game'  => $game,
        ]);
    }

    public function questionAction(QuizGame $game, Category $category, QuestionRepository $repository)
    {
        $question = $repository->getQuestionForGame($game, $category);
        if (!$question) {
            return $this->redirectToRoute('game_categories', [
                'game' => $game->getId(),
            ]);
        }

        if (!$question[1]) {
            $gameQuestion = new QuizGameQuestion();
            $gameQuestion->setQuizGame($game);
            $gameQuestion->setQuestion($question[0]);
            $this->entityManager->persist($gameQuestion);
            $this->entityManager->flush();
        }


        return $this->render('/Game/admin/question.html.twig', [
            'question' => $question[0],
            'game'  => $game,
            'category' => $category,
        ]);
    }
}