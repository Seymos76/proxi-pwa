<?php

namespace App\Entity;

use App\Repository\TimeTableRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=TimeTableRepository::class)
 */
class TimeTable
{
    public const MONDAY = 'monday';
    public const TUESDAY = 'tuesday';
    public const WEDNESDAY = 'wednesday';
    public const THURSDAY = 'thursday';
    public const FRIDAY = 'friday';
    public const SATURDAY = 'saturday';
    public const SUNDAY = 'sunday';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="array", length=100)
     * @Groups({"business_page"})
     */
    private array $days = [];

    /**
     * @ORM\Column(type="time")
     * @Groups({"business_page"})
     */
    private \DateTime $openingTime;

    /**
     * @ORM\Column(type="time")
     * @Groups({"business_page"})
     */
    private \DateTime $closingTime;

    /**
     * @ORM\ManyToOne(targetEntity=Business::class, inversedBy="timeTables")
     * @ORM\JoinColumn(nullable=false)
     */
    private Business $business;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDays(): ?array
    {
        return $this->days;
    }

    public function addDay(string $day): self
    {
        if (!in_array($day, $this->days, true)) {
            $this->days[] = $day;
            return $this;
        }
        return $this;
    }

    public function addDays(array $days): self
    {
        foreach ($days as $day) {
            if (!in_array($day, $this->days, true)) {
                $this->days[] = $day;
            }
        }
        return $this;
    }

    public function removeDay(string $day): self
    {
        if (($key = array_search($day, $this->days, true)) !== false) {
            unset($this->days[$key]);
            return $this;
        }

        return $this;
    }

    public function removeDays(array $days): self
    {
        foreach ($days as $day) {
            if (($key = array_search($day, $this->days, true)) !== false) {
                unset($this->days[$key]);
            }
        }

        return $this;
    }

    public function getOpeningTime(): ?\DateTimeInterface
    {
        return $this->openingTime;
    }

    public function setOpeningTime(\DateTimeInterface $openingTime): self
    {
        $this->openingTime = $openingTime;

        return $this;
    }

    public function getClosingTime(): ?\DateTimeInterface
    {
        return $this->closingTime;
    }

    public function setClosingTime(\DateTimeInterface $closingTime): self
    {
        $this->closingTime = $closingTime;

        return $this;
    }

    public function getBusiness(): ?Business
    {
        return $this->business;
    }

    public function setBusiness(?Business $business): self
    {
        $this->business = $business;

        return $this;
    }
}
