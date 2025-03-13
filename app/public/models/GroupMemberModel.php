<?php
require_once(__DIR__ . "/BaseModel.php");
require_once(__DIR__ . "/../dto/GroupMemberDTO.php");

class GroupMemberModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
    }

    // Fetch all members of a group
    public function getMembersByGroupId(int $groupId): array
    {
        $sql = "SELECT gm.*, u.username FROM GroupMembers gm
                INNER JOIN Users u ON gm.user_id = u.id
                WHERE gm.group_id = :group_id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':group_id', $groupId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Add a member to a group
    public function addMember(GroupMemberDTO $groupMember): void
    {
        $sql = "INSERT INTO GroupMembers (group_id, user_id) 
                VALUES (:group_id, :user_id)";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':group_id', $groupMember->getGroupId(), PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $groupMember->getUserId(), PDO::PARAM_INT);
        $stmt->execute();
    }

    // Remove a member from a group
    public function removeMember(int $groupMemberId): void
    {
        $sql = "DELETE FROM GroupMembers WHERE id = :id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':id', $groupMemberId, PDO::PARAM_INT);
        $stmt->execute();
    }

    // Remove all members of a group
    public function removeMembersByGroupId(int $groupId): void
    {
        $sql = "DELETE FROM GroupMember WHERE group_id = :group_id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':group_id', $groupId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function isUserInGroup(int $groupId, int $userId): bool {
        $sql = "SELECT COUNT(*) as count FROM GroupMembers WHERE group_id = :group_id AND user_id = :user_id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':group_id', $groupId, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }
    // Remove a member by group ID and user ID
    public function removeMemberByGroupAndUserId(int $groupId, int $userId): void {
        $sql = "DELETE FROM GroupMembers WHERE group_id = :group_id AND user_id = :user_id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':group_id', $groupId, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
    }

}
