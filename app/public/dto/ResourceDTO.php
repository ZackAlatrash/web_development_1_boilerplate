<?php

class ResourceDTO
{
    private int $id;
    private ?int $taskId;
    private ?int $subjectId;
    private string $type;
    private ?string $resourcePath;
    private ?string $note;

    public function __construct($id, $taskId, $subjectId, $type, $resourcePath, $note)
    {
        $this->id = $id;
        $this->taskId = $taskId;
        $this->subjectId = $subjectId;
        $this->type = $type;
        $this->resourcePath = $resourcePath;
        $this->note = $note;
    }

    public function getId(): int { return $this->id; }
    public function getTaskId(): ?int { return $this->taskId; }
    public function getSubjectId(): ?int { return $this->subjectId; }
    public function getType(): string { return $this->type; }
    public function getResourcePath(): ?string { return $this->resourcePath; }
    public function getNote(): ?string { return $this->note; }
}
