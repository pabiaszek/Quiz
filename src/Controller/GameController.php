<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Quiz;
use App\Entity\QuizGame;
use App\Entity\QuizGameQuestion;
use App\Repository\CategoryRepository;
use App\Repository\QuestionRepository;
use App\Repository\QuizGameQuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

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
        $gameQuestion = $question[1];

        if (!$gameQuestion) {
            $gameQuestion = new QuizGameQuestion();
            $gameQuestion->setQuizGame($game);
            $gameQuestion->setQuestion($question[0]);
            $this->entityManager->persist($gameQuestion);
            $this->entityManager->flush();
        }


        return $this->render('/Game/admin/question.html.twig', [
            'question' => $question[0],
            'gameQuestion' => $gameQuestion,
            'game'  => $game,
            'category' => $category,
        ]);
    }

    public function continueAction(QuizGame $game, QuizGameQuestionRepository $repository)
    {
        $gameQuestion = $repository->findOneBy([
            'quizGame' => $game,
            'correct' => null,
        ]);

        if ($gameQuestion) {
            $question = $gameQuestion->getQuestion();

            return $this->render('/Game/admin/question.html.twig', [
                'question' => $question,
                'gameQuestion' => $gameQuestion,
                'game'  => $gameQuestion->getQuizGame(),
                'category' => $question->getCategory(),
            ]);
        }

        return $this->redirectToRoute('game_categories', [
            'game' => $game->getId(),
        ]);
    }

    public function questionResultAjaxAction(Request $request, QuizGameQuestion $question)
    {
        $result = (bool) $request->get('result');

        $question->setCorrect($result);
        $this->entityManager->flush();
        if ($result) {
            $message = 'Udzielona dpowiedź poprawna';
        } else {
            $message = 'Udzielona dpowiedź niepoprawna';
        }

        return new JsonResponse([
           'message' => $message,
        ]);
    }
}