<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SurveyRepository")
 */
class Survey
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
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Assemble", inversedBy="surveys")
     * @ORM\JoinColumn(nullable=false)
     */
    private $assemble;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\QuestionSurvey", mappedBy="survey", cascade={"persist", "remove"})
     */
    private $questionSurveys;

    public function __construct()
    {
        $this->questionSurveys = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAssemble(): ?Assemble
    {
        return $this->assemble;
    }

    public function setAssemble(?Assemble $assemble): self
    {
        $this->assemble = $assemble;

        return $this;
    }

    public function getQuestionSurveys(): Collection
    {
        return $this->questionSurveys;
    }

    public function addQuestionSurvey(QuestionSurvey $questionSurvey): self
    {
        if (!$this->questionSurveys->contains($questionSurvey)) {
            $this->questionSurveys[] = $questionSurvey;
            $questionSurvey->setSurvey($this);
        }

        return $this;
    }

    public function removeQuestionSurvey(QuestionSurvey $questionSurvey): self
    {
        if ($this->questionSurveys->contains($questionSurvey)) {
            $this->questionSurveys->removeElement($questionSurvey);
            // set the owning side to null (unless already changed)
            if ($questionSurvey->getSurvey() === $this) {
                $questionSurvey->setSurvey(null);
            }
        }

        return $this;
    }
}
