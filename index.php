<?php
/**
 * CoursePlanner API
 * @author oliviercardoen
 */
require 'vendor/autoload.php';
require 'config.php';

use App\App;

$app = new App();
$app->run();