<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionSurveyRepository")
 */
class QuestionSurvey
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Survey", inversedBy="questionSurveys")
     * @ORM\JoinColumn(nullable=false)
     */
    private $survey;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AnswerQuestionSurvey", mappedBy="question", cascade={"persist", "remove"})
     */
    private $answerQuestionSurveys;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AnswerSurvey", mappedBy="question", cascade={"persist", "remove"})
     */
    private $answerSurveys;

    public function __construct()
    {
        $this->answerQuestionSurveys = new ArrayCollection();
        $this->answerSurveys = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSurvey(): ?Survey
    {
        return $this->survey;
    }

    public function setSurvey(?Survey $survey): self
    {
        $this->survey = $survey;

        return $this;
    }

    /**
     * @return Collection|AnswerQuestionSurvey[]
     */
    public function getAnswerQuestionSurveys(): Collection
    {
        return $this->answerQuestionSurveys;
    }

    public function addAnswerQuestionSurvey(AnswerQuestionSurvey $answerQuestionSurvey): self
    {
        if (!$this->answerQuestionSurveys->contains($answerQuestionSurvey)) {
            $this->answerQuestionSurveys[] = $answerQuestionSurvey;
            $answerQuestionSurvey->setQuestion($this);
        }

        return $this;
    }

    public function removeAnswerQuestionSurvey(AnswerQuestionSurvey $answerQuestionSurvey): self
    {
        if ($this->answerQuestionSurveys->contains($answerQuestionSurvey)) {
            $this->answerQuestionSurveys->removeElement($answerQuestionSurvey);
            // set the owning side to null (unless already changed)
            if ($answerQuestionSurvey->getQuestion() === $this) {
                $answerQuestionSurvey->setQuestion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|AnswerSurvey[]
     */
    public function getAnswerSurveys(): Collection
    {
        return $this->answerSurveys;
    }

    public function addAnswerSurvey(AnswerSurvey $answerSurvey): self
    {
        if (!$this->answerSurveys->contains($answerSurvey)) {
            $this->answerSurveys[] = $answerSurvey;
            $answerSurvey->setQuestion($this);
        }

        return $this;
    }

    public function removeAnswerSurvey(AnswerSurvey $answerSurvey): self
    {
        if ($this->answerSurveys->contains($answerSurvey)) {
            $this->answerSurveys->removeElement($answerSurvey);
            // set the owning side to null (unless already changed)
            if ($answerSurvey->getQuestion() === $this) {
                $answerSurvey->setQuestion(null);
            }
        }

        return $this;
    }
}
