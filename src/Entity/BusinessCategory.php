<?php

namespace App\Entity;

use App\Repository\BusinessCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BusinessCategoryRepository::class)
 */
class BusinessCategory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $icon;

    /**
     * @ORM\OneToMany(targetEntity=Business::class, mappedBy="businessCategory")
     */
    private $business;

    public function __construct()
    {
        $this->business = new ArrayCollection();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @return Collection|Business[]
     */
    public function getBusiness(): Collection
    {
        return $this->business;
    }

    public function addBusiness(Business $business): self
    {
        if (!$this->business->contains($business)) {
            $this->business[] = $business;
            $business->setBusinessCategory($this);
        }

        return $this;
    }

    public function removeBusiness(Business $business): self
    {
        if ($this->business->contains($business)) {
            $this->business->removeElement($business);
            // set the owning side to null (unless already changed)
            if ($business->getBusinessCategory() === $this) {
                $business->setBusinessCategory(null);
            }
        }

        return $this;
    }
}
