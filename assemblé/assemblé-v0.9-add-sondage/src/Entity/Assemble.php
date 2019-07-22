<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AssembleRepository")
 */
class Assemble
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=500)
     * @Assert\NotBlank
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     */
    private $subject;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $resume;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $prev_analyse;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\DateTime
     * @var string A "Y-m-d H:i:s" formatted value
     */
    private $date_crea;

    /** 
     * @ORM\Column(type="datetime", nullable=true) 
     * 
     * */
    private $date_upd;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="assembles")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Htag", mappedBy="assemble", cascade={"persist", "remove"})
     */
    private $htag;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Files", mappedBy="assemble", cascade={"persist", "remove"})
     */
    private $files;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="assemble", cascade={"persist", "remove"})
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Survey", mappedBy="assemble", cascade={"persist", "remove"})
     */
    private $surveys;

    public function __construct()
    {
        $this->htag = new ArrayCollection();
        $this->files = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->surveys = new ArrayCollection();
    }
    
    public function getFiles()
    {
        return $this->files;
    }

    public function addFil(Files $files)
    {
        $this->files->add($files);
        $files->setAssemble($this);
    }

    public function removeFil(Files $files)
    {
        $this->files->removeElement($files);
    }

    public function getHtag()
    {
        return $this->htag;
    }

    public function addHtag(Htag $htag)
    {
        $this->htag->add($htag);
        $htag->setAssemble($this);
    }

    public function removeHtag(Htag $htag)
    {
        $this->htag->removeElement($htag);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(?string $resume): self
    {
        $this->resume = $resume;

        return $this;
    }

    public function getPrevAnalyse(): ?string
    {
        return $this->prev_analyse;
    }
    public function getprev_analyse(): ?string
    {
        return $this->prev_analyse;
    }

    public function setPrevAnalyse(?string $analyse): self
    {
        $this->prev_analyse = $analyse;

        return $this;
    }

    public function getDateCrea(): ?\DateTimeInterface
    {
        return $this->date_crea;
    }

    public function setDateCrea(): self
    {
        $this->date_crea = new \DateTime("now");

        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }
    public function setUser($user): void
    {
        $this->user = $user;
    }

    public function setDateUpd()
    {
        // will NOT be saved in the database
        $this->date_upd = new \DateTime("now");
        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setAssemble($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getAssemble() === $this) {
                $comment->setAssemble(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Survey[]
     */
    public function getSurveys(): Collection
    {
        return $this->surveys;
    }

    public function addSurvey(Survey $survey): self
    {
        if (!$this->surveys->contains($survey)) {
            $this->surveys[] = $survey;
            $survey->setAssemble($this);
        }

        return $this;
    }

    public function removeSurvey(Survey $survey): self
    {
        if ($this->surveys->contains($survey)) {
            $this->surveys->removeElement($survey);
            // set the owning side to null (unless already changed)
            if ($survey->getAssemble() === $this) {
                $survey->setAssemble(null);
            }
        }

        return $this;
    }
}
