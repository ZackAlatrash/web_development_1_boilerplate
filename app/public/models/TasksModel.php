<?php
require_once(__DIR__ . "/BaseModel.php");
require_once(__DIR__ . "/../dto/TasksDTO.php");
require_once(__DIR__ . '/../dto/Priority.php');

class TasksModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
    }

    
    public function getAllTasks(): array
    {
        
        $sql = "SELECT * FROM Tasks ORDER BY due_date ASC";

        $stmt = self::$pdo->prepare($sql);
        $stmt->execute();

        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $tasks;
    }

    
    public function getTasksByUserId(int $userId): array
    {
        
        $sql = "SELECT * FROM Tasks WHERE user_id = :user_id ORDER BY due_date ASC";

        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $tasks;
    }

    public function getTasksByGroupId(int $groupId): array
    {
        $sql = "SELECT * FROM Tasks WHERE group_id = :group_id ORDER BY due_date ASC";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':group_id', $groupId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

        
    public function createTask(TasksDTO $task): void
    {
        $sql = "INSERT INTO Tasks (user_id, group_id, subject_id, title, description, priority, due_date, is_completed) 
                VALUES (:user_id, :group_id, :subject_id, :title, :description, :priority, :due_date, :is_completed)";
        $stmt = self::$pdo->prepare($sql);

        
        $userId = $task->getUserId(); 
        $groupId = $task->getGroupId(); 
        $subjectId = $task->getSubjectId(); 
        $title = $task->getTitle();
        $description = $task->getDescription();
        $priority = $task->getPriority()->value; 
        $dueDate = $task->getDueDate()?->format('Y-m-d'); 
        $isCompleted = $task->isCompleted() ? 1 : 0;

        
        $stmt->bindValue(':user_id', $userId, $userId === null ? PDO::PARAM_NULL : PDO::PARAM_INT);
        $stmt->bindValue(':group_id', $groupId, PDO::PARAM_INT);
        $stmt->bindValue(':subject_id', $subjectId, $subjectId === null ? PDO::PARAM_NULL : PDO::PARAM_INT);
        $stmt->bindValue(':title', $title, PDO::PARAM_STR);
        $stmt->bindValue(':description', $description, PDO::PARAM_STR);
        $stmt->bindValue(':priority', $priority, PDO::PARAM_STR);
        $stmt->bindValue(':due_date', $dueDate, $dueDate === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(':is_completed', $isCompleted, PDO::PARAM_BOOL);

        
        $stmt->execute();
    }


    
    public function completeTask(int $taskId): void
    {
        $sql = "UPDATE Tasks SET is_completed = 1, completed_at = NOW() WHERE id = :taskId";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':taskId', $taskId, PDO::PARAM_INT);
        $stmt->execute();
    }

    
    public function deleteTask(int $taskId): void
    {
        $sql = "DELETE FROM Tasks WHERE id = :taskId";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':taskId', $taskId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function countTotalTasks(int $userId): int {
        $sql = "SELECT COUNT(*) as total FROM Tasks WHERE user_id = :userId";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
    
    public function countTasksByStatus(int $userId): array {
        $sql = "SELECT is_completed, COUNT(*) as count 
                FROM Tasks 
                WHERE user_id = :userId 
                GROUP BY is_completed";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function groupTasksByPriority(int $userId): array {
        $sql = "SELECT priority, COUNT(*) as count 
                FROM Tasks 
                WHERE user_id = :userId 
                GROUP BY priority";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function getUpcomingDeadlines(int $userId): array {
        $sql = "SELECT * FROM Tasks 
                WHERE user_id = :userId AND due_date >= CURDATE() and is_completed = 0
                ORDER BY due_date ASC 
                LIMIT 5";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTasksDueSoon($userId) {
        try {
            
            $currentDate = new DateTime();
            
            $startOfDay = $currentDate->setTime(0, 0, 0)->format('Y-m-d H:i:s');
            $endOfDay = $currentDate->setTime(23, 59, 59)->format('Y-m-d H:i:s');
    
            
            $query = "SELECT * FROM Tasks 
                      WHERE user_id = :user_id 
                      AND is_completed = 0 
                      AND due_date BETWEEN :start_of_day AND :end_of_day";
    
            
            $stmt = self::$pdo->prepare($query);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT); 
            $stmt->bindParam(':start_of_day', $startOfDay); 
            $stmt->bindParam(':end_of_day', $endOfDay); 
            $stmt->execute(); 
    
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            
            error_log('Error fetching tasks due today: ' . $e->getMessage());
            
            return [];
        }
    }
    public function getTasksForUserAndGroup(int $userId, int $groupId = null): array
    {
        $sql = "SELECT * FROM Tasks 
                WHERE (user_id = :user_id AND group_id IS NULL) 
                OR (group_id = :group_id) 
                ORDER BY due_date ASC";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':group_id', $groupId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    
    
    
}
