<?php

namespace WebKinder\FlickrPlugin;

final class PluginFactory
{
    public static function create()
    {
        static $plugin = null;

        if ($plugin === null) {
            $plugin = new Plugin();
        }

        return $plugin;
    }
}
