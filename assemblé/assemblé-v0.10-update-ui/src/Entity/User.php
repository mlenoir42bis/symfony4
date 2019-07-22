<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="Assemble", mappedBy="user", cascade={"remove"})
     */
    private $assembles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="User", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AnswerSurvey", mappedBy="user", orphanRemoval=true)
     */
    private $answerSurveys;

    public function __construct()
    {
        $this->assemble = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->answerSurveys = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getAssembles()
    {
        return $this->assembles;
    }

    public function addAssembles($assemble): void
    {
        if (!$this->assembles->contains($assemble)) {
            $this->assembles->add($assemble);
            $assemble->setUser($this);
        }
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
            $comment->setUser($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
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
            $answerSurvey->setUser($this);
        }

        return $this;
    }

    public function removeAnswerSurvey(AnswerSurvey $answerSurvey): self
    {
        if ($this->answerSurveys->contains($answerSurvey)) {
            $this->answerSurveys->removeElement($answerSurvey);
            // set the owning side to null (unless already changed)
            if ($answerSurvey->getUser() === $this) {
                $answerSurvey->setUser(null);
            }
        }

        return $this;
    }

}
