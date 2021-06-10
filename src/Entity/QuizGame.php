<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * QuizGame
 *
 * @ORM\Table(name="quiz_game", indexes={@ORM\Index(name="FK_quiz_game_quiz", columns={"quiz_id"})})
 * @ORM\Entity
 */
class QuizGame
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
     * @var \DateTime
     *
     * @ORM\Column(name="started_at", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $startedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ended_at", type="datetime", nullable=true)
     */
    private $endedAt = null;

    /**
     * @var Quiz
     *
     * @ORM\ManyToOne(targetEntity="Quiz")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="quiz_id", referencedColumnName="id")
     * })
     */
    private $quiz;

    public function __construct()
    {
        $this->startedAt = new \DateTime();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getStartedAt(): \DateTime
    {
        return $this->startedAt;
    }

    /**
     * @param \DateTime $startedAt
     */
    public function setStartedAt(\DateTime $startedAt): void
    {
        $this->startedAt = $startedAt;
    }

    /**
     * @return \DateTime
     */
    public function getEndedAt(): ?\DateTime
    {
        return $this->endedAt;
    }

    /**
     * @return bool
     */
    public function isEnded(): bool
    {
        return $this->endedAt && 1;
    }

    public function end(): void
    {
        $this->endedAt = new \DateTime();
    }

    /**
     * @return Quiz
     */
    public function getQuiz(): Quiz
    {
        return $this->quiz;
    }

    /**
     * @param Quiz $quiz
     */
    public function setQuiz(Quiz $quiz): void
    {
        $this->quiz = $quiz;
    }



}
