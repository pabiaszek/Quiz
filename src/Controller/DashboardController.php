<?php

declare(strict_types=1);

namespace App\Controller;



use App\Entity\Quiz;
use App\Repository\QuizRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DashboardController extends AbstractController
{
    public function dashboardAction(QuizRepository $quizRepository)
    {
        $quizzes = $quizRepository->getQuizzesWithGames();

        return $this->render('/dashboard.html.twig', [
            'quizzes' => $quizzes,
        ]);
    }

    public function questionsAction(Quiz $quiz)
    {
        return $this->render('/questions.html.twig', [
            'quiz' => $quiz,
        ]);
    }
}