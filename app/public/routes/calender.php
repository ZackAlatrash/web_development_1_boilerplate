<?php
Route::add('/calender', function () {
    require_once(__DIR__. "/../views/pages/calender.php");
}, ['GET', 'POST']);