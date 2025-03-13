<?php
require_once(__DIR__ . '/../api/TasksControllerApi.php');

Route::add('/dashboard', function () {
    require_once(__DIR__ . '/../views/pages/dashboard.php');
}, 'GET');
