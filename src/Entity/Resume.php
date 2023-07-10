<?php

namespace App\Entity;

use App\Repository\ResumeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ResumeRepository::class)]
#[Vich\Uploadable]
class Resume
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'resumes')]
    private ?User $user = null;

    #[ORM\Column(length: 255)]
    private ?string $path = null;

    #[Assert\File(
        maxSize: '1024k',
        extensions: ['pdf'],
        extensionsMessage: 'Veuillez télécharger un fichier PDF valide'
    )]
    #[Vich\UploadableField(mapping: 'resume_file', fileNameProperty: 'path')]
    private ?File $pathFile = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path): static
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return File|null
     */
    public function getPathFile(): ?File
    {
        return $this->pathFile;
    }

    /**
     * @param File|null $pathFile
     */
    public function setPathFile(?File $pathFile): void
    {
        $this->pathFile = $pathFile;
    }
}
