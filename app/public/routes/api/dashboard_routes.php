<?php
require_once(__DIR__ . '/../../api/DashboardApiController.php');

Route::add('/api/dashboard/summary', function () {
    $dashboardController = new DashboardApiController();
    $dashboardController->getSummary();
}, 'GET');
