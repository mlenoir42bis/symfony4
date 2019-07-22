<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookRepository")
 */
class Book
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="Ce champs ne peux etre vide")
     * @Assert\Length(
     *      min = 10,
     *      max = 100,
     *      minMessage = "Trop court : entre 10 et 100 characteres",
     *      maxMessage = "Trop long : entre 10 et 100 characteres"
     * )
     * @ORM\Column(type="string", length=85)
     */
    private $title;

    /**
     * @Assert\NotBlank(message="Ce champs ne peux etre vide")
     * @Assert\Length(
     *      min = 15,
     *      minMessage = "Trop court : Plus de 15 characteres"
     * )
     * @ORM\Column(type="string", length=2500)
     */
    private $content;

    /**
     * @ORM\OneToOne(targetEntity="Image", cascade={"persist", "remove"})
     */
    private $image;

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }
    
    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage($image): self
    {
        $this->image = $image;

        return $this;
    }
    
}
