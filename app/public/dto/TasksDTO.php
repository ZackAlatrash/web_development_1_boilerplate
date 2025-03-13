<?php

require_once(__DIR__ . '/Priority.php'); // Include the PriorityEnum class

class TasksDTO
{
    private int $id;// Allow NULL values
    private ?int $userId; // Make userId nullable
    private string $title;
    private ?string $description;
    private PriorityEnum $priority;
    private ?DateTime $dueDate;
    private bool $isCompleted;
    private ?int $groupId;

    public function __construct(
        int $id,
        public ?int $subjectId, // Allow NULL values
        ?int $userId, // Make userId nullable
        string $title,
        ?string $description,
        PriorityEnum $priority,
        ?DateTime $dueDate,
        bool $isCompleted,
        ?int $groupId = null // Optional parameter moved to the end
    ) {
        $this->id = $id;
        $this->groupId = $groupId; // Allow null
        $this->subjectId = $subjectId;
        $this->userId = $userId;
        $this->title = $title;
        $this->description = $description;
        $this->priority = $priority;
        $this->dueDate = $dueDate;
        $this->isCompleted = $isCompleted;
    }
    

    // Getters
    public function getId(): int
    {
        return $this->id;
    }

    public function getSubjectId(): ?int {
        return $this->subjectId;
    }
    

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getPriority(): PriorityEnum
    {
        return $this->priority;
    }

    public function getDueDate(): ?DateTime
    {
        return $this->dueDate;
    }

    public function isCompleted(): bool
    {
        return $this->isCompleted;
    }
    public function getGroupId(): ?int
    {
        return $this->groupId;
    }
}
