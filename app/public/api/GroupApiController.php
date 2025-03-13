<?php
require_once(__DIR__ . '/../models/GroupModel.php');
require_once(__DIR__ . '/../models/GroupMemberModel.php');
require_once(__DIR__ . '/utils/ResponseHelper.php');
require_once(__DIR__ . '/../models/TasksModel.php');
require_once(__DIR__ . '/../models/UserModel.php');


class GroupApiController {
    private $groupModel;
    private $groupMemberModel;
    private $tasksModel;
    private $userModel;


    public function __construct() {
        $this->groupModel = new GroupModel();
        $this->groupMemberModel = new GroupMemberModel();
        $this->tasksModel = new TasksModel();
        $this->userModel = new UserModel();

    }

    // Fetch groups by user
    public function getGroupsByUser() {
        if (!isset($_SESSION['user_id'])) {
            ResponseHelper::sendError('User not authenticated', 401);
            return;
        }

        $userId = $_SESSION['user_id'];

        try {
            $groups = $this->groupModel->getGroupsByUserId($userId);
            ResponseHelper::sendJson($groups);
        } catch (Exception $e) {
            ResponseHelper::sendError('Failed to fetch groups', 500);
        }
    }

    // Create a new group
    public function createGroup() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $groupName = $data['name'] ?? '';
            $description = $data['description'] ?? '';

            if (empty($groupName)) {
                ResponseHelper::sendError('Group name is required', 400);
                return;
            }


            try {
                $userId = $_SESSION['user_id'];
                $group = new GroupDTO(0, $groupName, $description, $userId);
                $groupId = $this->groupModel->createGroup($group);
                
                $groupMember = new GroupMemberDTO(0, $groupId, $userId);
                $newgroupMember = $this->groupMemberModel->addMember($groupMember);
                ResponseHelper::sendJson(['message' => 'Group created successfully', 'group_id' => $groupId, " group member id" => $newgroupMember]);
            } catch (Exception $e) {
                ResponseHelper::sendError('Failed to create group', 500);
            }
        }
    }

    // Delete a group
    public function deleteGroup($groupId) {
        try {
            $this->groupModel->deleteGroup($groupId);
            ResponseHelper::sendJson(['message' => 'Group deleted successfully']);
        } catch (Exception $e) {
            ResponseHelper::sendError('Failed to delete group', 500);
        }
    }

    public function addUserToGroup($groupId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['user_id'])) {
                ResponseHelper::sendError('User not authenticated', 401);
                return;
            }
    
            $adminId = $_SESSION['user_id'];
            $data = json_decode(file_get_contents('php://input'), true);
            $userIdentifier = $data['user_id'] ?? null;
    
            if (empty($userIdentifier)) {
                ResponseHelper::sendError('User email or username is required', 400);
                return;
            }
    
            try {
                // Fetch user details
                
                $user = $this->userModel->getUserByEmailOrUsername($userIdentifier);
    
                if (!$user) {
                    ResponseHelper::sendError('User not found', 404);
                    return;
                }
    
                // Check if user is already in group
                $userIdToAdd = $user['id'];
                if ($this->groupMemberModel->isUserInGroup($groupId, $userIdToAdd)) {
                    ResponseHelper::sendError('User is already in the group', 409);
                    return;
                }
    
                // Add user to group
                $groupMember = new GroupMemberDTO(0, $groupId, $userIdToAdd);
                $this->groupMemberModel->addMember($groupMember);
    
                ResponseHelper::sendJson([
                    'message' => 'User added to group successfully',
                    'user' => ['id' => $userIdToAdd, 'email_or_username' => $userIdentifier]
                ]);
            } catch (Exception $e) {
                error_log('Error adding user to group: ' . $e->getMessage());
                ResponseHelper::sendError('Failed to add user to group', 500);
            }
        }
    }
    
    
    public function getGroupDetails($groupId) {
        try {
            $group = $this->groupModel->getGroupById($groupId);
            $members = $this->groupMemberModel->getMembersByGroupId($groupId);
            $tasks = $this->tasksModel->getTasksByGroupId($groupId);
    
            // Check if group exists
            if (!$group) {
                ResponseHelper::sendError('Group not found', 404);
                return;
            }
    
            ResponseHelper::sendJson([
                'group' => $group,
                'members' => $members,
                'tasks' => $tasks
            ]);
        } catch (Exception $e) {
            ResponseHelper::sendError('Failed to fetch group details', 500);
        }
    }
    
    
    public function removeUserFromGroup($groupId, $userId) {
        try {
            $this->groupMemberModel->removeMemberByGroupAndUserId($groupId, $userId);
            ResponseHelper::sendJson(['message' => 'User removed from group']);
        } catch (Exception $e) {
            ResponseHelper::sendError('Failed to remove user', 500);
        }
    }
    public function removeMember(int $memberId)
    {
        try {
            $this->groupMemberModel->removeMember($memberId);
            ResponseHelper::sendJson(['message' => 'User removed from group']);
        } catch (Exception $e) {
            ResponseHelper::sendError('Failed to remove user', 500);
        }
    }
}
