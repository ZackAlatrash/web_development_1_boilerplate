<?php
require_once(__DIR__ . '/../../api/UserApiController.php');

Route::add('/api/user', function () {
    $userApiController = new UserApiController();
    $userApiController->getUserById();
}, 'GET');
