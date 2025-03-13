<?php
require_once(__DIR__ . '/../../api/GroupApiController.php');

Route::add('/api/groups', function () {
    $groupApiController = new GroupApiController();
    $groupApiController->getGroupsByUser();
}, 'GET');

Route::add('/api/groups', function () {
    $groupApiController = new GroupApiController();
    $groupApiController->createGroup();
}, 'POST');

Route::add('/api/groups/delete/([0-9]+)', function ($groupId) {
    $groupApiController = new GroupApiController();
    $groupApiController->deleteGroup($groupId);
}, 'DELETE');

Route::add('/api/groups/([0-9]+)/add-user', function ($groupId) {
    $controller = new GroupApiController();
    $controller->addUserToGroup($groupId);
}, 'POST');


Route::add('/api/groups/([0-9]+)', function ($groupId) {
    $controller = new GroupApiController();
    $controller->getGroupDetails($groupId);
}, 'GET');

Route::add('/api/groups/remove-member/([0-9]+)', function ($memberId) {
    $controller = new GroupApiController();
    $controller->removeMember(intval($memberId));
}, 'DELETE');

Route::add('/api/groups/([0-9]+)/tasks', function ($groupId) {
    $controller = new GroupTasksApiController();
    $controller->getTasksByGroup($groupId);
}, 'GET');

Route::add('/api/groups/([0-9]+)/tasks', function ($groupId) {
    $controller = new GroupTasksApiController();
    $controller->createGroupTask($groupId);
}, 'POST');

Route::add('/api/groups/tasks/delete/([0-9]+)', function ($taskId) {
    $controller = new GroupTasksApiController();
    $controller->deleteGroupTask($taskId);
}, 'DELETE');

Route::add('/api/groups/tasks/complete/([0-9]+)', function ($taskId) {
    $controller = new GroupTasksApiController();
    $controller->completeGroupTask($taskId);
}, 'PUT');
