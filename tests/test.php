<?php

require 'bootstrap.php';

use Srdante\AntiBotLinks\AntiBotLinks;

$antiBotLinks = AntiBotLinks::make('1', 60);

var_dump($antiBotLinks->generateLinks());
