<?php
require_once "includes/header.php";

$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'add':
        require "views/add.php";
        break;
    case 'home':
    default:
        require "views/home.php";
        break;
}

require_once "includes/footer.php";
