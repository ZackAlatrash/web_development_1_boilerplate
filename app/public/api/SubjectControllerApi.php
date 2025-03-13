<?php
require_once(__DIR__. "/../models/SubjectModel.php");
require_once(__DIR__."/../api/utils/ResponseHelper.php");
require_once(__DIR__. "/../dto/SubjectDTO.php");

class SubjectApiController
{
    private $subjectModel;
    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->subjectModel = new SubjectModel();
    }

    public function getSubjectsByUser()
    {
        if(isset($_SESSION["user_id"]))
        {
            try
            {
                $subjects = $this->subjectModel->getSubjectsByUserId($_SESSION["user_id"]);
                ResponseHelper::sendJson($subjects);
            }
            catch(Exception $e)
            {
                ResponseHelper::sendError("Failed to fetch subjects", 500);
            }
            
        }
        else
        {
            header('Location: /login');
        }
    }
    public function getSubjectsOverview() {

        if (!isset($_SESSION['user_id'])) {
            ResponseHelper::sendError('User not authenticated', 401);
            return;
        }
    
        $userId = $_SESSION['user_id'];
    
        try {
            $subjects = $this->subjectModel->getSubjectsWithTaskCount($userId);
            ResponseHelper::sendJson($subjects);
        } catch (Exception $e) {
            ResponseHelper::sendError('Failed to fetch subjects overview', 500);
        }
    }
    

    public function deleteSubject($subjectId)
    {
        try
        {
            $this->subjectModel->deleteSubject($subjectId);
            ResponseHelper::sendJson(['message' => 'Subject deleted successfully']);
        }
        catch(Exception $e)
        {
            ResponseHelper::sendError("Failed to delete subject", 500);
        }
    }

    public function addSubject()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $input = json_decode(file_get_contents('php://input'), true);
    
            if (empty($input['name'])) {
                ResponseHelper::sendError("Subject name is required", 400);
                return;
            }
    
            try {

                $subject = new SubjectDTO(0, $_SESSION["user_id"], $input['name']);
    
                $this->subjectModel->createSubject($subject);
    
                ResponseHelper::sendJson(['message' => 'Subject added successfully']);

            } catch (Exception $e) {
                ResponseHelper::sendError("Failed to add subject", 500);
            }
        }
    }
}