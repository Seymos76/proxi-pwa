<?php

namespace App\Entity;

use App\Repository\BusinessRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=BusinessRepository::class)
 */
class Business
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"business_page"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"business_page"})
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"business_page"})
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"business_page"})
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Groups({"business_page"})
     */
    private $phoneNumber;

    /**
     * @ORM\ManyToOne(targetEntity=City::class, inversedBy="businesses")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"business_page"})
     */
    private $city;

    /**
     * @ORM\Column(type="datetime")
     */
    private $registeredAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="businesses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=TimeTable::class, mappedBy="business", cascade={"persist","remove"}, orphanRemoval=true)
     */
    private $timeTables;

    /**
     * @ORM\ManyToOne(targetEntity=BusinessCategory::class, inversedBy="business")
     * @ORM\JoinColumn(nullable=false)
     */
    private $businessCategory;

    public function __construct()
    {
        $this->registeredAt = new \DateTime('now');
        $this->timeTables = new ArrayCollection();
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getRegisteredAt(): ?\DateTimeInterface
    {
        return $this->registeredAt;
    }

    public function setRegisteredAt(\DateTimeInterface $registeredAt): self
    {
        $this->registeredAt = $registeredAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|TimeTable[]
     */
    public function getTimeTables(): Collection
    {
        return $this->timeTables;
    }

    public function addTimeTable(TimeTable $timeTable): self
    {
        if (!$this->timeTables->contains($timeTable)) {
            $this->timeTables[] = $timeTable;
            $timeTable->setBusiness($this);
        }

        return $this;
    }

    public function removeTimeTable(TimeTable $timeTable): self
    {
        if ($this->timeTables->contains($timeTable)) {
            $this->timeTables->removeElement($timeTable);
            // set the owning side to null (unless already changed)
            if ($timeTable->getBusiness() === $this) {
                $timeTable->setBusiness(null);
            }
        }

        return $this;
    }

    public function getBusinessCategory(): ?BusinessCategory
    {
        return $this->businessCategory;
    }

    public function setBusinessCategory(?BusinessCategory $businessCategory): self
    {
        $this->businessCategory = $businessCategory;

        return $this;
    }
}
