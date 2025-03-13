<?php

class SubjectDTO
{
    private int $id;
    private int $userId;
    private string $name;

    public function __construct(int $id, int $userId, string $name)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->name = $name;
    }

    // Getters
    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getName(): string
    {
        return $this->name;
    }
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->userId,
            'name' => $this->name,
        ];
    }
}
