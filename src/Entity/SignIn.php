<?php

namespace App\Entity;

use App\Repository\SignInRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SignInRepository::class)]
class SignIn
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $timeStart = null;

    #[ORM\Column(length: 255)]
    private ?string $timeStop = null;

    #[ORM\Column(length: 255)]
    private ?string $timeFinish = null;

    #[ORM\Column(length: 255)]
    private ?string $hourCount = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTimeStart(): ?string
    {
        return $this->timeStart;
    }

    public function setTimeStart(string $timeStart): self
    {
        $this->timeStart = $timeStart;

        return $this;
    }

    public function getTimeStop(): ?string
    {
        return $this->timeStop;
    }

    public function setTimeStop(string $timeStop): self
    {
        $this->timeStop = $timeStop;

        return $this;
    }

    public function getTimeFinish(): ?string
    {
        return $this->timeFinish;
    }

    public function setTimeFinish(string $timeFinish): self
    {
        $this->timeFinish = $timeFinish;

        return $this;
    }

    public function getHourCount(): ?string
    {
        return $this->hourCount;
    }

    public function setHourCount(string $hourCount): self
    {
        $this->hourCount = $hourCount;

        return $this;
    }
}
