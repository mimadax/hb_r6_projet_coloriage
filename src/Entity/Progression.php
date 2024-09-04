<?php

namespace App\Entity;

use App\Repository\ProgressionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProgressionRepository::class)]
class Progression
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $isChecked = null;

    #[ORM\Column]
    private ?int $buttonNumber = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isChecked(): ?bool
    {
        return $this->isChecked;
    }

    public function setChecked(bool $isChecked): static
    {
        $this->isChecked = $isChecked;

        return $this;
    }

    public function getButtonNumber(): ?int
    {
        return $this->buttonNumber;
    }

    public function setButtonNumber(int $buttonNumber): static
    {
        $this->buttonNumber = $buttonNumber;

        return $this;
    }
}
