<?php

declare(strict_types=1);

namespace App\Controller;



use App\Entity\Quiz;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DashboardController extends AbstractController
{
    public function dashboardAction(EntityManagerInterface $entityManager)
    {
        $quizzes = $entityManager->getRepository(Quiz::class)->findAll();

        return $this->render('/dashboard.html.twig', [
            'quizzes' => $quizzes,
        ]);
    }
}