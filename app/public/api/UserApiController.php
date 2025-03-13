<?php
require_once(__DIR__ . '/../models/UserModel.php');
require_once(__DIR__ . '/../api/utils/ResponseHelper.php');

class UserApiController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel(); 
    }

    public function getUserById() {
        if (isset($_SESSION['user_id'])) {
            try {
                $user = $this->userModel->getUserBiId($_SESSION['user_id']); 
                if ($user) {
                    ResponseHelper::sendJson($user);
                } else {
                    ResponseHelper::sendError('User not found', 404);
                }
            } catch (Exception $e) {
                ResponseHelper::sendError('Failed to fetch user', 500);
            }
        } else {
            ResponseHelper::sendError('Unauthorized', 401);
        }
    }
}
