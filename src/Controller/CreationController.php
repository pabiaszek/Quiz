<?php

declare(strict_types=1);

namespace App\Controller;


use App\Entity\Quiz;
use App\Form\QuizType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CreationController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * CreationController constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createQuizAction(Request $request)
    {
        $form = $this->createForm(QuizType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entity = $form->getData();
            $this->entityManager->persist($entity);
            foreach ($entity->getQuestions() as $question) {
                $question->setQuiz($entity);
            }
            $this->entityManager->flush();

            return $this->redirectToRoute('dashboard');
        }

        return $this->render('/quiz_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}