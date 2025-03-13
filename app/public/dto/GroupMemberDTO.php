<?php

class GroupMemberDTO
{
    private int $id;
    private int $groupId;
    private int $userId;

    public function __construct(
        int $id,
        int $groupId,
        int $userId
    ) {
        $this->id = $id;
        $this->groupId = $groupId;
        $this->userId = $userId;
    }

    // Getters
    public function getId(): int
    {
        return $this->id;
    }

    public function getGroupId(): int
    {
        return $this->groupId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
