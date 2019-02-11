<?php
include 'bootstrap/Prs4AutoLoad.php';
include 'bootstrap/Start.php';
include 'bootstrap/alias.php';
$config = include 'config/config.php';
Start::init();
Start::router();
