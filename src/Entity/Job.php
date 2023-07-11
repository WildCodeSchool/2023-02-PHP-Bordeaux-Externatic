<?php

namespace App\Entity;

use App\Repository\JobRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JobRepository::class)]
class Job
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'jobs')]
    private ?Category $category = null;

    #[ORM\OneToMany(mappedBy: 'job', targetEntity: Joboffer::class)]
    private Collection $joboffers;

    #[ORM\OneToMany(mappedBy: 'job', targetEntity: Search::class)]
    private Collection $searches;

    public function __construct()
    {
        $this->joboffers = new ArrayCollection();
        $this->searches = new ArrayCollection();
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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Joboffer>
     */
    public function getJoboffers(): Collection
    {
        return $this->joboffers;
    }

    public function addJoboffer(Joboffer $joboffer): self
    {
        if (!$this->joboffers->contains($joboffer)) {
            $this->joboffers->add($joboffer);
            $joboffer->setJob($this);
        }

        return $this;
    }

    public function removeJoboffer(Joboffer $joboffer): self
    {
        if ($this->joboffers->removeElement($joboffer)) {
            // set the owning side to null (unless already changed)
            if ($joboffer->getJob() === $this) {
                $joboffer->setJob(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        // TODO: Implement __toString() method.
        return $this->name;
    }

    /**
     * @return Collection<int, Search>
     */
    public function getSearches(): Collection
    {
        return $this->searches;
    }

    public function addSearch(Search $search): static
    {
        if (!$this->searches->contains($search)) {
            $this->searches->add($search);
            $search->setJob($this);
        }

        return $this;
    }

    public function removeSearch(Search $search): static
    {
        if ($this->searches->removeElement($search)) {
            // set the owning side to null (unless already changed)
            if ($search->getJob() === $this) {
                $search->setJob(null);
            }
        }

        return $this;
    }
}
