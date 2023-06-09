<?php

namespace App\Entity;

use App\Repository\ContractRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContractRepository::class)]
class Contract
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\OneToMany(mappedBy: 'contract', targetEntity: Joboffer::class)]
    private Collection $joboffers;

    #[ORM\OneToMany(mappedBy: 'contract', targetEntity: Search::class)]
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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
            $joboffer->setContract($this);
        }

        return $this;
    }

    public function removeJoboffer(Joboffer $joboffer): self
    {
        if ($this->joboffers->removeElement($joboffer)) {
            // set the owning side to null (unless already changed)
            if ($joboffer->getContract() === $this) {
                $joboffer->setContract(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        // TODO: Implement __toString() method.
        return $this->getType();
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
            $search->setContract($this);
        }

        return $this;
    }

    public function removeSearch(Search $search): static
    {
        if ($this->searches->removeElement($search)) {
            // set the owning side to null (unless already changed)
            if ($search->getContract() === $this) {
                $search->setContract(null);
            }
        }

        return $this;
    }
}
