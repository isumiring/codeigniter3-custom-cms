<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
$hook['post_controller_constructor'] = array(
    'class'    => 'FAT_Hooks',
    'function' => 'post_construct',
    'filename' => 'FAT_Hooks.php',
    'filepath' => 'hooks'
);
$hook['post_controller_constructor'] = array(
    'class'    => 'FAT_Hooks',
    'function' => 'authentication',
    'filename' => 'FAT_Hooks.php',
    'filepath' => 'hooks'
);
$hook['post_controller'] = array(
    'class'    => 'FAT_Hooks',
    'function' => 'view',
    'filename' => 'FAT_Hooks.php',
    'filepath' => 'hooks'
);
