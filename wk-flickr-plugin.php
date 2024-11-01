<?php
/*
Plugin Name: Flickr Gallery by WebKinder
Plugin URI:  wk-flickr-gallery
Description: A plugin to easily integrate flickr photosets into your WordPress installation. If you have any questions or feature requests, feel free to contact us via support@webkinder.ch.
Version:     0.1.0
Author:      WebKinder
Author URI:  http://www.webkinder.ch
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: wk-flickr-gallery
*/

define('WK_SUPPORT_PLUGIN_DIR', dirname(__FILE__));

include_once 'Classes/PluginFactory.php';
include_once 'Classes/Plugin.php';

if (WebKinder\FlickrPlugin\PluginFactory::create() !== null) {
    (WebKinder\FlickrPlugin\PluginFactory::create())->run();
}