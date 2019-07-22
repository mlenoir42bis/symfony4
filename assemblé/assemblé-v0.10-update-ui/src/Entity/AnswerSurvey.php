<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AnswerSurveyRepository")
 */
class AnswerSurvey
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\QuestionSurvey", inversedBy="answerSurveys")
     * @ORM\JoinColumn(nullable=false)
     */
    private $question;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AnswerQuestionSurvey", inversedBy="answerSurveys")
     * @ORM\JoinColumn(nullable=true)
     */
    private $answerQuestionSurvey;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="answerSurveys")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAnswerQuestionSurvey(): ?AnswerQuestionSurvey
    {
        return $this->answerQuestionSurvey;
    }

    public function setAnswerQuestionSurvey(?AnswerQuestionSurvey $answerQuestionSurvey): self
    {
        $this->answerQuestionSurvey = $answerQuestionSurvey;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
