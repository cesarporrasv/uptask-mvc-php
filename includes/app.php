<?php 

use Model\ActiveRecord;

require 'functions.php';
require 'database.php';
require __DIR__ . '/../vendor/autoload.php';

// Conectarnos a la base de datos
ActiveRecord::setDB($db);