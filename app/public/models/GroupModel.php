<?php
require_once(__DIR__ . "/BaseModel.php");
require_once(__DIR__ . "/../dto/GroupDTO.php");

class GroupModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
    }

    // Fetch all groups
    public function getAllGroups(): array
    {
        $sql = "SELECT * FROM Groups ORDER BY id ASC";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch groups for a specific user
    public function getGroupsByUserId(int $userId): array
    {
        $sql = "SELECT g.* FROM Groups g 
                INNER JOIN GroupMembers gm ON g.id = gm.group_id 
                WHERE gm.user_id = :user_id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Create a new group
    public function createGroup(GroupDTO $group): int
    {
        $name = $group->getName();
        $description = $group->getDescription();
        $user = $group->getCreatedBy();
    
        $sql = "INSERT INTO Groups (name, description, created_by) 
                VALUES (:name, :description, :user)";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':user', $user, PDO::PARAM_INT);
    
        $stmt->execute();
        return self::$pdo->lastInsertId(); // Return the created group ID
    }


    // Update group details
    public function updateGroup(GroupDTO $group): bool
    {
        $sql = "UPDATE Groups SET name = :name, description = :description 
                WHERE id = :id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':name', $group->getName(), PDO::PARAM_STR);
        $stmt->bindParam(':description', $group->getDescription(), PDO::PARAM_STR);
        $stmt->bindParam(':id', $group->getId(), PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Delete a group
    public function deleteGroup(int $groupId): bool
    {
        $sql = "DELETE FROM Groups WHERE id = :id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':id', $groupId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    

    public function getGroupById(int $groupId)
    {
        $sql = "SELECT * FROM Groups WHERE id = :id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':id', $groupId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Return the group details as an associative array
    }

    
}
