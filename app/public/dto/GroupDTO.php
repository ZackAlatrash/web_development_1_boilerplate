<?php

class GroupDTO
{
    private int $id;
    private string $name;
    private ?string $description;
    private int $createdBy; // User ID of the creator

    public function __construct(
        int $id,
        string $name,
        ?string $description,
        int $createdBy
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->createdBy = $createdBy;
    }

    // Getters
    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getCreatedBy(): int
    {
        return $this->createdBy;
    }
}
