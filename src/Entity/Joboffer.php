<?php

namespace App\Entity;

use App\Repository\JobofferRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: JobofferRepository::class)]
#[ORM\Table(name: 'joboffer')]
#[ORM\Index(columns: ['title', 'city'], flags: ['fulltext'])]
class Joboffer
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 50)]
    private ?string $city = null;

    #[ORM\ManyToOne(inversedBy: 'joboffers')]
    private ?Company $company = null;

    #[ORM\ManyToOne(inversedBy: 'joboffers')]
    private ?Job $job = null;

    #[ORM\ManyToOne(inversedBy: 'joboffers')]
    private ?Contract $contract = null;

    #[ORM\ManyToOne(inversedBy: 'joboffers')]
    private ?Salary $salary = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $salaryMin = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $salaryMax = null;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getJob(): ?Job
    {
        return $this->job;
    }

    public function setJob(?Job $job): self
    {
        $this->job = $job;

        return $this;
    }

    public function getContract(): ?Contract
    {
        return $this->contract;
    }

    public function setContract(?Contract $contract): self
    {
        $this->contract = $contract;

        return $this;
    }

    public function getSalary(): ?Salary
    {
        return $this->salary;
    }

    public function setSalary(?Salary $salary): self
    {
        $this->salary = $salary;

        return $this;
    }

    public function getSalaryMin(): ?int
    {
        return $this->salaryMin;
    }

    public function getSalaryMax(): int
    {
        return $this->salaryMax;
    }

    public function setSalaryMin(?int $salaryMin): self
    {
        $this->salaryMin = $salaryMin;

        return $this;
    }

    public function setSalaryMax(?int $salaryMax): self
    {
        $this->salaryMax = $salaryMax;

        return $this;
    }
}
