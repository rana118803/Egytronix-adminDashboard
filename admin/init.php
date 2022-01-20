<?php

include 'connect.php';

/// Roots Dirs
$tpl 	= 'includes/templates/'; // Template Directory
$lang 	= 'includes/languages/'; // Language Directory
$func	= 'includes/functions/'; // Functions Directory
$css 	= 'layout/css/'; // Css Directory
$js 	= 'layout/js/'; // Js Directory



// Include The Important Files

include $func . 'functions.php';
include $lang . 'english.php';
include $tpl . 'header.php';

if (!isset($noNavbar)) { include $tpl . 'nav.php'; }