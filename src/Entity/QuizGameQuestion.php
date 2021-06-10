<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * QuizGameQuestion
 *
 * @ORM\Table(name="quiz_game_question", uniqueConstraints={@ORM\UniqueConstraint(name="quiz_game_id_question_id", columns={"quiz_game_id", "question_id"})}, indexes={@ORM\Index(name="FK_quiz_game_question_question", columns={"question_id"}), @ORM\Index(name="IDX_370A6479F6D574A5", columns={"quiz_game_id"})})
 * @ORM\Entity
 */
class QuizGameQuestion
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="correct", type="boolean", nullable=true)
     */
    private $correct;

    /**
     * @var Question
     *
     * @ORM\ManyToOne(targetEntity="Question")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="question_id", referencedColumnName="id")
     * })
     */
    private $question;

    /**
     * @var QuizGame
     *
     * @ORM\ManyToOne(targetEntity="QuizGame")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="quiz_game_id", referencedColumnName="id")
     * })
     */
    private $quizGame;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return bool|null
     */
    public function isCorrect(): ?bool
    {
        return $this->correct;
    }

    /**
     * @param bool|null $correct
     */
    public function setCorrect(?bool$correct): void
    {
        $this->correct = $correct;
    }

    /**
     * @return Question
     */
    public function getQuestion(): Question
    {
        return $this->question;
    }

    /**
     * @param Question $question
     */
    public function setQuestion(Question $question): void
    {
        $this->question = $question;
    }

    /**
     * @return QuizGame
     */
    public function getQuizGame(): QuizGame
    {
        return $this->quizGame;
    }

    /**
     * @param QuizGame $quizGame
     */
    public function setQuizGame(QuizGame $quizGame): void
    {
        $this->quizGame = $quizGame;
    }


}
