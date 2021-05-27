<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\OneToMany;

/**
 * Quiz
 *
 * @ORM\Table(name="quiz")
 * @ORM\Entity(repositoryClass="App\Repository\QuizRepository")
 */
class Quiz
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var Collection
     *
     * @ManyToMany(targetEntity="Category")
     * @JoinTable(name="quiz_categories",
     *      joinColumns={@JoinColumn(name="quiz_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="category_id", referencedColumnName="id", unique=true)}
     *      )
     */
    private $categories;

    /**
     * @var Collection
     *
     * @OneToMany(targetEntity="Question", mappedBy="quiz")
     */
    private $questions;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->questions = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return Collection
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    /**
     * @param Collection $categories
     */
    public function setCategories(Collection $categories): void
    {
        $this->categories = $categories;
    }

    /**
     * @param Category $category
     */
    public function addCategory(Category $category): void
    {
        $this->categories->add($category);
    }

    /**
     * @param Category $category
     */
    public function removeCategory(Category $category): void
    {
        $this->categories->removeElement($category);
    }

    /**
     * @return Collection
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    /**
     * @param Collection $questions
     */
    public function setQuestions(Collection $questions): void
    {
        $this->questions = $questions;
    }


    /**
     * @param Question $question
     */
    public function addQuestion(Question $question): void
    {
        $this->questions->add($question);
    }

    /**
     * @param Question $question
     */
    public function removeQuestion(Question $question): void
    {
        $this->questions->removeElement($question);
    }
}
