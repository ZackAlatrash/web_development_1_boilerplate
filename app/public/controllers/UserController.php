<?php

require_once(__DIR__. "/../models/UserModel.php");
require_once(__DIR__ . "/../dto/UserDTO.php");

class UserController
{
    private $userModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Capture user input
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
        
            // Validate input
            if (empty($username) || empty($password)) {
                $error = "Username and password are required.";
                require_once '../views/pages/login.php';
                return;
            }
        
            // Fetch user details by username
            $user = $this->userModel->getUserByUsername($username);
        
            // Verify password and check if user exists
            if ($user && password_verify($password, $user['password'])) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
            
                // Set session variables
                $_SESSION["user_id"] = $user['id'];
                $_SESSION["username"] = $user['username'];
                $_SESSION["role"] = $user['role']; // Save the user's role in the session
            
                // Redirect based on role
                if ($user['role'] === 'admin') {
                    header('Location: /admin'); // Redirect to the admin page
                } else {
                    header('Location: /dashboard'); // Redirect to the dashboard for regular users
                }
                exit;
            } else {
                // Invalid credentials
                $error = "Invalid username or password.";
                require_once(__DIR__ . "/../views/pages/login.php");
            }
        }
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstname = trim($_POST['firstname']);
            $lastname = trim($_POST['lastname']);
            $email = trim($_POST['email']);
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
            $confirmPassword = trim($_POST['confirm_password']);

            // Validate inputs
            if (empty($firstname) || empty($lastname) || empty($email) || empty($username) || empty($password) || empty($confirmPassword)) {
                $error = "All fields are required.";
                require_once(__DIR__ . '/../views/pages/register.php');
                return;
            }

            if ($password !== $confirmPassword) {
                $error = "Passwords do not match.";
                require_once(__DIR__ . '/../views/pages/register.php');
                return;
            }

            if ($this->userModel->getUserByEmailOrUsername($email) || $this->userModel->getUserByEmailOrUsername($username)) {
                $error = "Email or username already exists.";
                require_once(__DIR__ . '/../views/pages/register.php');
                return;
            }

            // Create user
            try {
                $userId = $this->userModel->createUser($firstname, $lastname, $email, $username, $password);

                if ($userId) {
                    // Redirect to login after successful registration
                    header('Location: /login');
                    exit;
                } else {
                    $error = "Registration failed. Please try again.";
                }
            } catch (Exception $e) {
                $error = "An error occurred during registration: " . $e->getMessage();
            }
        }

        // Load the registration page
        require_once(__DIR__ . '/../views/pages/register.php');
    }
}
