<?php

require_once(__DIR__ . '/../models/UserModel.php');
require_once(__DIR__ . '/utils/ResponseHelper.php');

class AdminController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    
    public function addUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstname = trim($_POST['firstname']);
            $lastname = trim($_POST['lastname']);
            $email = trim($_POST['email']);
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
            $role = trim($_POST['role']);

            if (empty($firstname) || empty($lastname) || empty($email) || empty($username) || empty($password) || empty($role)) {
                ResponseHelper::sendError('All fields are required.', 400);
                return;
            }

            try {
                $userId = $this->userModel->addUser($firstname, $lastname, $email, $username, $password, $role);
                ResponseHelper::sendJson(['message' => 'User added successfully', 'user_id' => $userId]);
            } catch (Exception $e) {
                ResponseHelper::sendError('Failed to add user: ' . $e->getMessage(), 500);
            }
        } else {
            ResponseHelper::sendError('Invalid request method', 405);
        }
    }

    
    public function deleteUser(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                
                $this->userModel->deleteUser($id);
            
                
                ResponseHelper::sendJson(['message' => 'User deleted successfully']);
            } catch (Exception $e) {
                
                ResponseHelper::sendError('Failed to delete user: ' . $e->getMessage(), 500);
            }
        } else {
            
            ResponseHelper::sendError('Invalid request method', 405);
        }
    }


    
    public function getAllUsers()
    {
        try {
            $users = $this->userModel->getAllUsers();
            ResponseHelper::sendJson($users);
        } catch (Exception $e) {
            ResponseHelper::sendError('Failed to fetch users: ' . $e->getMessage(), 500);
        }
    }
}
