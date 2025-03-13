<?php

require_once(__DIR__. "/../../api/SubjectControllerApi.php");

Route::add('/api/subjects', function () {
    $subjectApiController = new SubjectApiController();
    $subjectApiController->getSubjectsByUser(); 
}, 'GET');
Route::add('/api/subjects/overview', function () {
    $subjectApiController = new SubjectApiController();
    $subjectApiController->getSubjectsOverview(); 
}, 'GET');

Route::add('/api/subjects', function () {
    $subjectApiController = new SubjectApiController();
    $subjectApiController->addSubject(); 
}, 'POST');

Route::add('/api/subjects/([0-9]+)', function ($id) {
    $subjectApiController = new SubjectApiController();
    $subjectApiController->deleteSubject(intval($id)); 
}, 'DELETE');