<?php

namespace WebKinder\FlickrPlugin;
    use WebKinder\FlickrPlugin\Init\ScriptLoader;
    use WebKinder\FlickrPlugin\Data\BackendApi;
    use WebKinder\FlickrPlugin\Data\FlickrApi;
    use WebKinder\FlickrPlugin\Shared\ErrorHandler;
    use WebKinder\FlickrPlugin\View\Templates\PhotosetList;
    use WebKinder\FlickrPlugin\View\Templates\SinglePhotoset;
    use WebKinder\FlickrPlugin\View\ShortcodePrimary;
    use WebKinder\FlickrPlugin\Admin\Settings;
    use WebKinder\FlickrPlugin\Admin\BackendFields;
    use WebKinder\FlickrPlugin\Admin\PostTypeGrid;

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
include_once 'Init/ScriptLoader.php';
include_once 'Shared/ErrorHandler.php';
include_once 'View/ShortcodePrimary.php';
include_once 'Admin/BackendFields.php';
include_once 'Admin/PostTypeGrid.php';
include_once 'Admin/Settings.php';
include_once 'Data/BackendApi.php';
include_once 'Data/FlickrApi.php';
include_once 'View/Templates/PhotosetList.php';
include_once 'View/Templates/SinglePhotoset.php';

final class Plugin
{
    /**
     * Execution function which is called after the class has been initialized.
     * This contains hook and filter assignments, etc.
     */
    public function run()
    {
        add_action('plugins_loaded', array($this, 'loadPluginTextdomain'));
        
        $this->prefix = 'wk-flickr-integration';
        $this->version = '0.1.0';
        $this->script_loader = (new ScriptLoader($this->version));
        $this->shortcode_primary = (new ShortcodePrimary());
        $this->settings = (new Settings($this->prefix));

        add_action( 'admin_init', array( $this->settings, 'register' ) );
        add_action( 'admin_menu', array( $this->settings, 'render' ) );
        add_action( 'init', array( $this, 'add_post_type' ) );
        add_action('wp_enqueue_scripts', array( $this->script_loader, 'load_styles' ));
        add_action('wp_enqueue_scripts', array( $this->script_loader, 'load_scripts' ));
        add_action( 'admin_enqueue_scripts', array( $this->script_loader, 'load_admin_scripts' ));
        add_action('admin_enqueue_scripts', array( $this->script_loader, 'load_admin_styles' ));
        add_shortcode('flickr-grid', array( $this->shortcode_primary, 'add_shortcode' ));
        add_action( 'admin_menu', array( $this, 'remove_acf_menu' ), 999);

        if (!is_plugin_active( 'acf/acf.php' )) {
            add_filter( 'acf/settings/path', array( $this, 'wk_flickr_acf_settings_path' ) );
            add_filter( 'acf/settings/dir', array( $this, 'wk_flickr_acf_settings_dir' ) );
            add_filter( 'acf/settings/show_admin', '__return_false' );
            include_once( $dir = plugin_dir_path(__FILE__) . '../wp-content/plugins/advanced-custom-fields/acf.php' );
        }

        BackendFields::wk_flickr_register_backend_fields();
    }

    /**
     * Load translation files from the indicated directory.
     */
    public function loadPluginTextdomain()
    {
        load_plugin_textdomain('wk-flickr-gallery', false, basename(dirname(__FILE__, 2)) . '/languages');
    }

    /**
     * Runs on plugin activation
     *
     * @since 0.1.0
     */
    public function remove_acf_menu() {
        remove_menu_page( 'edit.php?post_type=acf' );
    }

    /**
     * Returns the acf settings path
     *
     * @since 0.1.0
     */
    public function wk_flickr_acf_settings_path( $path ) {
        // update path
        $path = $dir = plugin_dir_path( __FILE__ ) . '/acf/';
        // return
        return $path;
    }

    /**
     * Returns the acf settings dir
     *
     * @since 0.1.0
     */
    public function wk_flickr_acf_settings_dir( $dir ) {
        $dir = get_stylesheet_directory_uri() . '/acf/';
        return $dir;
    }

    /**
     * Adds the post type
     *
     * @since 0.1.0
     */
    public function add_post_type() {
        PostTypeGrid::wk_flickr_add_post_type();
    }
}
