<?php
require_once(__DIR__ . '/../../api/ResourceApiController.php');

Route::add('/api/resources/upload', function () {
    $controller = new ResourceApiController();
    $controller->uploadResource();
}, 'POST');

Route::add('/api/resources', function () {
    $controller = new ResourceApiController();
    $controller->getUserResources();
}, 'GET');
Route::add('/api/resources', function () {
    $resourceApiController = new ResourceApiController();
    $resourceApiController->uploadResource();
}, 'POST');

Route::add('/api/resources/subject/([0-9]+)', function ($subjectId) {
    $resourceApiController = new ResourceApiController();
    $resourceApiController->getResourcesBySubject($subjectId);
}, 'GET');
