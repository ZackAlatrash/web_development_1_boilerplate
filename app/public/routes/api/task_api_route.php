<?php

require_once(__DIR__. "/../../api/TasksControllerApi.php");

Route::add('/api/tasks', function () {
    $taskApiController = new TaskApiController();
    $taskApiController->getTasksByUser(); 
}, 'GET');

Route::add('/api/tasks', function () {
    $taskApiController = new TaskApiController();
    $taskApiController->addTask(); 
}, 'POST');

Route::add('/api/tasks/delete/([0-9]+)', function ($id) {
    $taskApiController = new TaskApiController();
    $taskApiController->deleteTask(intval($id));
}, 'DELETE');

Route::add('/api/tasks/complete/([0-9]+)', function ($id) {
    $taskApiController = new TaskApiController();
    $taskApiController->completeTask(intval($id));
}, 'PATCH');
