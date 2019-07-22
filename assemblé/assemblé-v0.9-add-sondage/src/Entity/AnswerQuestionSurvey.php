<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AnswerQuestionSurveyRepository")
 */
class AnswerQuestionSurvey
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
     * @ORM\ManyToOne(targetEntity="App\Entity\QuestionSurvey", inversedBy="answerQuestionSurveys")
     * @ORM\JoinColumn(nullable=false)
     */
    private $question;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AnswerSurvey", mappedBy="answerQuestionSurvey", cascade={"persist", "remove"})
     */
    private $answerSurveys;

    public function __construct()
    {
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

    public function getQuestion(): ?QuestionSurvey
    {
        return $this->question;
    }

    public function setQuestion(?QuestionSurvey $question): self
    {
        $this->question = $question;

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
            $answerSurvey->setAnswerQuestionSurvey($this);
        }

        return $this;
    }

    public function removeAnswerSurvey(AnswerSurvey $answerSurvey): self
    {
        if ($this->answerSurveys->contains($answerSurvey)) {
            $this->answerSurveys->removeElement($answerSurvey);
            // set the owning side to null (unless already changed)
            if ($answerSurvey->getAnswerQuestionSurvey() === $this) {
                $answerSurvey->setAnswerQuestionSurvey(null);
            }
        }

        return $this;
    }
}
