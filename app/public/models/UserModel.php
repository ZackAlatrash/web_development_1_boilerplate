<?php

require_once(__DIR__ . "/BaseModel.php");
require_once(__DIR__ . "/../dto/UserDTO.php");

class UserModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getAllUsers()
    {
        $sql = "SELECT id, firstname, lastname, email, username, role FROM Users";
        $stmt = self::$pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getUserBiId(int $id)
    {
        $sql = "SELECT * FROM Users WHERE id = :id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserByUsername(string $username)
    {
        $sql = "SELECT * FROM Users WHERE username = :username";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":username", $username, PDO::PARAM_STR_CHAR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function createUser(string $firstname, string $lastname, string $email, string $username, string $password)
    {
        $sql = "INSERT INTO Users (firstname, lastname, email, username, password) 
            VALUES (:firstname, :lastname, :email, :username, :password)";
        $stmt = self::$pdo->prepare($sql);

        
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    
        
        $stmt->execute([
            ':firstname' => $firstname,
            ':lastname' => $lastname,
            ':email' => $email,
            ':username' => $username,
            ':password' => $hashedPassword
        ]);
    
        
        return self::$pdo->lastInsertId();
    }

    public function getUserByEmailOrUsername(string $identifier): ?array {
        $sql = "SELECT * FROM Users WHERE email = :identifier OR username = :identifier LIMIT 1";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':identifier', $identifier, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function addUser(string $firstname, string $lastname, string $email, string $username, string $password, string $role = 'user')
    {
        $sql = "INSERT INTO Users (firstname, lastname, email, username, password, role) 
                VALUES (:firstname, :lastname, :email, :username, :password, :role)";
        $stmt = self::$pdo->prepare($sql);
    
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    
        $stmt->execute([
            ':firstname' => $firstname,
            ':lastname' => $lastname,
            ':email' => $email,
            ':username' => $username,
            ':password' => $hashedPassword,
            ':role' => $role,
        ]);
    
        return self::$pdo->lastInsertId();
    }
    
    public function deleteUser(int $userId)
    {
        $sql = "DELETE FROM Users WHERE id = :id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();
    }

    
    
}
