<?php

require_once(__DIR__ . "/BaseModel.php");
require_once(__DIR__ . "/../dto/SubjectDTO.php");

class SubjectModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
    }

    // Fetch all subjects for a specific user
    public function getSubjectsByUserId(int $userId): array
    {
        $sql = "SELECT * FROM Subjects WHERE user_id = :user_id ORDER BY name ASC";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
        error_log(print_r($subjects, true));
        


        return $subjects;
        
    }

    // Create a new subject
    public function createSubject(SubjectDTO $subject): void
    {
        $sql = "INSERT INTO Subjects (user_id, name) VALUES (:user_id, :name) ";
        $stmt = self::$pdo->prepare($sql);

        $userId = $subject->getUserId();
        $name = $subject->getName();

        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);

        $stmt->execute();
    }

    // Delete a subject
    public function deleteSubject(int $subjectId): void
    {
        $sql = "DELETE FROM Subjects WHERE id = :subject_id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':subject_id', $subjectId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getSubjectsWithTaskCount($userId) {
        $sql = "SELECT s.id, s.name, COUNT(t.id) AS taskCount FROM Subjects s LEFT JOIN Tasks t ON t.subject_id = s.id WHERE s.user_id = :user_id GROUP BY s.id";
    
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
    
        $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $subjects;

    }
    
    
}
