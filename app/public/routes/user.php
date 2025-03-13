<?php

require_once(__DIR__ . "/../controllers/UserController.php");

Route::add('/login', function () {
    $userController = new UserController();
    $userController->login();
    require_once(__DIR__. "/../views/pages/login.php");
}, ['GET', 'POST']);

Route::add('/subjects', function () {
    require_once(__DIR__. "/../views/pages/subjects.php");
}, ['GET', 'POST']);

Route::add('/tasks', function () {
    require_once(__DIR__. "/../views/pages/tasks.php");
}, ['GET', 'POST']);
Route::add('/groups', function () {
    require_once(__DIR__. "/../views/pages/groups.php");
}, ['GET', 'POST']);
Route::add('/resources', function () {
    require_once(__DIR__. "/../views/pages/resources.php");
}, ['GET', 'POST']);

Route::add('/register', function () {
    $userController = new UserController();
    $userController->register();
    require_once(__DIR__. "/../views/pages/register.php");
}, ['GET', 'POST']);
Route::add('/admin', function () {
    require_once(__DIR__. "/../views/pages/admin.php");
}, ['GET', 'POST']);

Route::add('/logout', function () {
    if (session_status() === PHP_SESSION_ACTIVE) {
        session_unset();        // Unset all session variables
        session_destroy();      // Destroy the session
    }
    header('Location: /login'); // Redirect to the login page
    exit;
}, 'GET');


