<?php
require_once(__DIR__ . '/../../api/GroupTasksApiController.php');
Route::add('/api/group-tasks/([0-9]+)', function ($groupId) {
    $groupTasksApiController = new GroupTasksApiController();
    $groupTasksApiController->getTasksByGroup($groupId);
}, 'GET');

Route::add('/api/group-tasks', function () {
    $groupTasksApiController = new GroupTasksApiController();
    $groupTasksApiController->createGroupTask();
}, 'POST');
Route::add('/api/group-tasks/delete/([0-9]+)', function ($id) {
    $groupTasksApiController = new GroupTasksApiController();
    $groupTasksApiController->deleteGroupTask($id);
}, 'DELETE');

Route::add('/api/tasks/complete/([0-9]+)', function ($id) {
    $groupTasksApiController = new GroupTasksApiController();
    $groupTasksApiController->completeGroupTask($id);
}, 'PATCH');
