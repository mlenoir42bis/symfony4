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
     * @ORM\Column(type="text", nullable=true)
     */
    private $answerText;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var string A "Y-m-d H:i:s" formatted value
     */
    private $answerDate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $answerNumber;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var string A "Y-m-d H:i:s" formatted value
     */
    private $createdAt;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(): self
    {
        $this->createdAt = new \DateTime("now");

        return $this;
    }

    public function getAnswerText(): ?string
    {
        return $this->answerText;
    }

    public function setAnswerText($answerText): self
    {
        $this->answerText = $answerText;

        return $this;
    }


    public function getAnswerDate(): ?string
    {
        return $this->answerDate;
    }

    public function setAnswer($answerDate): self
    {
        $this->answerDate = $answerDate;

        return $this;
    }


    public function getAnswerNumber(): ?string
    {
        return $this->answerNumber;
    }

    public function setAnswerNumber($answerNumber): self
    {
        $this->answerNumber = $answerNumber;

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
