<?php
define( 'ABSPATH', __DIR__ . '/../' );
global $homepage;
$homepage = file_get_contents(ABSPATH . 'homepage.txt');