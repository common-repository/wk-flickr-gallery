<?php

namespace WebKinder\FlickrPlugin\Shared;

class ErrorHandler {
    static function display_error( $message ) {
        $error_template = '<div class="wk-flickr-integration-alert-box wk-flickr-integration-error"><span>Flickr error: ' . $message . '</span></div>';
        echo $error_template;
    }
}
