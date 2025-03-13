<?php
require_once(__DIR__ . '/../dto/ResourceDTO.php');
require_once(__DIR__ . '/BaseModel.php');

class ResourceModel extends BaseModel
{
    // Add a new resource
    public function addResource($userId, $taskId, $subjectId, $type, $resourcePath, $note)
    {
        $sql = "INSERT INTO Resources (user_id, task_id, subject_id, type, resource_path, note) 
                VALUES (:user_id, :task_id, :subject_id, :type, :resource_path, :note)";
        $stmt = self::$pdo->prepare($sql);
    
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':task_id', $taskId, PDO::PARAM_INT);
        $stmt->bindParam(':subject_id', $subjectId, PDO::PARAM_INT);
        $stmt->bindParam(':type', $type, PDO::PARAM_STR);
        $stmt->bindParam(':resource_path', $resourcePath, PDO::PARAM_STR);
        $stmt->bindParam(':note', $note, PDO::PARAM_STR);
    
        $stmt->execute();
    }


    // Retrieve all resources
    public function getResources()
    {
        $sql = " SELECT 
            Resources.id,
            Resources.type,
            Resources.resource_path,
            Resources.note,
            Subjects.name AS subject_name
            FROM Resources
            LEFT JOIN Subjects ON Resources.subject_id = Subjects.id";
        $stmt = self::$pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getResourcesBySubject($subjectId)
    {
        $sql = "SELECT * FROM Resources WHERE subject_id = :subject_id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([':subject_id' => $subjectId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getResourcesByUserId($userId)
    {
        $sql = "SELECT 
                    Resources.id,
                    Resources.type,
                    Resources.resource_path,
                    Resources.note,
                    Subjects.name AS subject_name
                FROM Resources
                LEFT JOIN Subjects ON Resources.subject_id = Subjects.id
                WHERE Resources.user_id = :user_id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
}
