<?php
require_once(__DIR__ . '/../../api/AdminApiController.php');

// Add User
Route::add('/api/admin/addUser', function () {
    $controller = new AdminController();
    $controller->addUser();
}, ['POST']);

// Delete User
Route::add('/api/admin/deleteUser/([0-9]+)', function ($id) {
    $controller = new AdminController();
    $controller->deleteUser(intval($id));
}, ['POST']);

// Get All Users
Route::add('/api/admin/users', function () {
    $controller = new AdminController();
    $controller->getAllUsers();
}, ['GET']);
?>