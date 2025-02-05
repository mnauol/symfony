<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['task:list'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['task:list'])]
    private ?string $Task = null;

    #[ORM\Column(length: 255)]
    #[Groups(['task:list'])]
    private ?string $Description = null;

    #[ORM\Column]
    #[Groups(['task:list'])]
    private ?bool $Completed = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTask(): ?string
    {
        return $this->Task;
    }

    public function setTask(string $Task): static
    {
        $this->Task = $Task;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    public function isComplsted(): ?bool
    {
        return $this->Completed;
    }

    public function setCompleted(bool $Completed): static
    {
        $this->Completed = $Completed;

        return $this;
    }
}
