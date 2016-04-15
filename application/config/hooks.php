<?php

defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/
$hook['post_controller_constructor'][] = [
    'class'    => 'FAT_Hooks',
    'function' => 'set_cache',
    'filename' => 'FAT_Hooks.php',
    'filepath' => 'hooks',
];
$hook['post_controller_constructor'][] = [
    'class'    => 'FAT_Hooks',
    'function' => 'set_profiler',
    'filename' => 'FAT_Hooks.php',
    'filepath' => 'hooks',
];
$hook['post_controller'][] = [
    'class'    => 'FAT_Layout',
    'function' => 'layout',
    'filename' => 'FAT_Layout.php',
    'filepath' => 'libraries',
];
