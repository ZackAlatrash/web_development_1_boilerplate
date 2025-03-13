<?php
Route::add('/groups', function () {
    require_once(__DIR__. "/../views/pages/groups.php");
}, ['GET', 'POST']);

Route::add('/group-details', function () {
    require_once(__DIR__ . '/../views/pages/group-details.php');
}, 'GET');
