<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FilesRepository")
 */
class Files
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=520)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=520)
     * @Assert\File(
     *     maxSize = "100024k",
     *     mimeTypes = {"application/pdf", "application/x-pdf", "image/*"},
     *     mimeTypesMessage = "Please upload a valid files"
     * )
     */
    private $myFile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="Assemble", inversedBy="Files")
     * @ORM\JoinColumn(nullable=false)
     */
    private $assemble;

    public function getAssemble()
    {
        return $this->assemble;
    }

    public function setAssemble($assemble): void
    {
        $this->assemble = $assemble;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getMyFile()
    {
        return $this->myFile;
    }

    public function setMyFile($myFile): self
    {
        $this->myFile = $myFile;

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
}
