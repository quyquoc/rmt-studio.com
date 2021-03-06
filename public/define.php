<?php
//Duong dan den thu muc chua ung dung
defined('ROOT_PATH') || define('ROOT_PATH', realpath(dirname(dirname(__FILE__))).'/');

//-------------------- KHAI BAO DUONG DAN THUC DEN CAC THU MUC ---------------------
//Duong dan den thu muc apps/
define('APPS_PATH', ROOT_PATH.'apps/');
//Duong dan den thu muc public/
define('PUBLIC_PATH', ROOT_PATH.'public/');
//Duong dan den thu muc public/library/
define('LIBRARY_PATH', PUBLIC_PATH.'library/');
//Duong dan den thu muc apps/frontend/elements
define('ELEMENTS_PATH', APPS_PATH.'/frontend/elements/');

//-------------------- KHAI BAO DUONG DAN URL DEN CAC THU MUC ---------------------
//Duong dan den thu muc ung dung
define('ROOT_URL', '/rmt-studio.com');
//Duong dan den thu muc /apps
define('APPS_URL', ROOT_URL.'/apps');
//Duong dan den thu muc /public
define('PUBLIC_URL', ROOT_URL.'/public');
//Duong dan den thu muc /public/library
define('LIBRARY_URL', PUBLIC_URL.'/library');

// Thư mục update file
define('UPLOAD_DIR', PUBLIC_URL.'/files/'); 

// Thư mực upload
define('ROOT_UPLOAD_DIR', realpath(dirname(__FILE__)).'/'); 


