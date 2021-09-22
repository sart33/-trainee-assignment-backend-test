<?php ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set("xdebug.var_display_max_children", '-1');
ini_set("xdebug.var_display_max_data", '-1');
ini_set("xdebug.var_display_max_depth", '-1');
define('VG_ACCESS', true);

header('Content-Type:text/html;charset=utf8');


require_once __DIR__ . '/App/Config/settings.php';

try {
    spl_autoload_register(function ($className) {
        include_once __DIR__ . '/' . str_replace('\\', '/', $className) . '.php';
    });

    (new \App\Controller\AdsController())->api();

}
catch(\Exception $e) {
    exit($e->getMessage());
}


