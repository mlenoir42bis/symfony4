<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ShopRepository")
 */
class Shop
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=520)
     * @Assert\NotBlank
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=520)
     * @Assert\NotBlank
     */
    private $adress;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $postalCode;

    /**
     * @ORM\Column(type="string", length=520)
     * @Assert\NotBlank
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=520)
     * @Assert\NotBlank
     */
    private $siret;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\DateTime
     * @var string A "Y-m-d H:i:s" formatted value
     * @Assert\NotBlank
     */
    private $dateAd;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="shops")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $Title): self
    {
        $this->title = $Title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $Description): self
    {
        $this->description = $Description;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $Adress): self
    {
        $this->adress = $Adress;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $PostalCode): self
    {
        $this->postalCode = $PostalCode;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $Country): self
    {
        $this->country = $Country;

        return $this;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(string $Siret): self
    {
        $this->siret = $Siret;

        return $this;
    }

    public function getDateAd(): ?\DateTimeInterface
    {
        return $this->dateAd;
    }

    public function setDateAd(\DateTimeInterface $DateAd): self
    {
        $this->dateAd = $DateAd;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser($User): self
    {
        $this->user = $User;

        return $this;
    }
}
