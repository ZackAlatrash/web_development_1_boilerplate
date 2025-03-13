<?php
require_once(__DIR__ . '/../../api/NotificationsApiController.php');

Route::add('/api/notifications', function () {
    $notificationsController = new NotificationsApiController();
    $notificationsController->getNotifications();
}, 'GET');
