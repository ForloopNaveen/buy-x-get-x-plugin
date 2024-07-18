<?php
/**
 * Plugin Name: Buy X Get X Free
 * Description: A custom WooCommerce plugin to enable Buy X Get X Free functionality.
 * Version: 1.8
 * Author: Naveen kumar
 * Text Domain: buy-x-get-x
 * Domain Path: i18n/languages/
 * Slug: buy-x-get-x
 */

defined("ABSPATH") or die();
defined('BXGX_PLUGIN_PATH') or define('BXGX_PLUGIN_PATH', plugin_dir_path(__FILE__));
defined('BXGX_PLUGIN_URL') or define('BXGX_PLUGIN_URL', plugin_dir_url(__FILE__));

if(file_exists(__DIR__ . "/vendor/autoload.php")){
    require_once __DIR__ . "/vendor/autoload.php";
}

if(class_exists('\Bxgx\App\Router')){
    $router = new \Bxgx\App\Router();
    $router->init();
}
