<?php

namespace App\Entity;

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
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $subject;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $resume;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $analyse;

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
     * @ORM\OneToMany(targetEntity="Htag", mappedBy="assemble", cascade={"persist", "remove"})
     */
    private $htag;

    /**
     * @ORM\OneToMany(targetEntity="Files", mappedBy="assemble", cascade={"persist", "remove"})
     */
    private $files;

    public function __construct()
    {
        $this->htag = new ArrayCollection();
        $this->files = new ArrayCollection();
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

    public function getAnalyse(): ?string
    {
        return $this->analyse;
    }

    public function setAnalyse(?string $analyse): self
    {
        $this->analyse = $analyse;

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
}
