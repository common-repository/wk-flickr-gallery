<?php
/*
 * wk-flickr-integration
 * Loader Class
 */

namespace WebKinder\FlickrPlugin\Init;

class ScriptLoader {

	private $wk_flickr_version;

	/*
	 * Constructor
	 */
	public function __construct($version) {
		$this->wk_flickr_version = $version;
	}

	/*
	 * Load admin scripts
	 */
	public function load_admin_scripts() {

		wp_register_script( 'wk-flickr-admin.js', plugin_dir_url( __FILE__ ) . '../../js/admin/wk-flickr-admin.js', array( 'jquery' ), $this->wk_flickr_version, $in_footer = true );
		wp_enqueue_script( 'wk-flickr-admin.js' );

		$defaults = array( 'api-field' => '', 'hide-on' => '');

		$translation_array = array(
			'confirm_delete' => __( 'Do you really want to delete this entry?', 'wk-flickr-gallery' ),
			'select_user' => __( 'Please select a flickr user.', 'wk-flickr-gallery' ),
			'no_user_id' => __( 'No user ID set.', 'wk-flickr-gallery' ),
			'user_id_exists' => __( 'User ID already exist!', 'wk-flickr-gallery' ),
			'checking_progress' => __( 'checking...', 'wk-flickr-gallery' ),
			'display_gallery' => __( 'Display the gallery by adding the shortcode to your page: ', 'wk-flickr-gallery' ),
			'copy_button' => __( 'copy', 'wk-flickr-gallery' ),
			'copied' => __( 'Copied to clipboard!', 'wk-flickr-gallery' ),
			'unable_to_copy' => __( 'Unable to copy!', 'wk-flickr-gallery' ),
			'add_api_key' => __( 'Please set an API key before adding User!', 'wk-flickr-gallery' ),
		);

		wp_localize_script( 'wk-flickr-admin.js', 'local', [wp_parse_args( get_option( 'wk_flickr_settings' ), $defaults )['hide-on'], get_field('user'), $translation_array] );

	}

	/*
	 * Load styles
	 */
	public function load_admin_styles() {

		wp_register_style( 'wk-flickr-admin.css', plugin_dir_url( __FILE__ ) . '../../css/admin/wk-flickr-admin.css', array(), $this->wk_flickr_version );
		wp_enqueue_style( 'wk-flickr-admin.css' );

		$handleCss = 'font-awesome';
		$handleMinCss = 'font-awesome.min';
		$list = 'enqueued';
		if ( wp_style_is( $handleCss, $list ) || wp_style_is( $handleMinCss, $list )) {
			return;
		} else {
			wp_register_style( 'font-awesome.min.css', plugin_dir_url( __FILE__ ) . '../../css/admin/lib/font-awesome/css/font-awesome.min.css', array(), $this->wk_flickr_version );
			wp_enqueue_style( 'font-awesome.min.css' );
		}

	}

	/*
	 * Load styles
	 */
	public function load_styles() {

		wp_register_style( 'wk-flickr.css', plugin_dir_url( __FILE__ ) . '../../css/public/wk-flickr.css', array(), $this->wk_flickr_version );
        wp_enqueue_style( 'wk-flickr.css' );

	}

	/*
	 * Load styles
	 */
	public function load_scripts() {

		wp_register_script( 'wk-flickr.js', plugin_dir_url(__FILE__) . '../../js/public/wk-flickr.js', array( 'jquery' ), $this->wk_flickr_version );
		wp_enqueue_script( 'wk-flickr.js' );

	}

	/*
	 * Load light gallery
	 */
	static function load_light_gallery() {

		wp_register_style( 'lightgallery.min.css', plugin_dir_url(__FILE__) .'../../js/public/lib/lightGallery/css/lightgallery.min.css' );
		wp_enqueue_style( 'lightgallery.min.css' );

		wp_register_script( 'lightgallery.min.js', plugin_dir_url(__FILE__) .'../../js/public/lib/lightGallery/js/lightgallery.min.js',  array( 'jquery' ) );
		wp_enqueue_script( 'lightgallery.min.js' );

		wp_register_script( 'lg-thumbnail.min.js', plugin_dir_url(__FILE__) .'../../js/public/lib/lightGallery/js/lg-thumbnail.min.js',  array( 'jquery' ) );
		wp_enqueue_script( 'lg-thumbnail.min.js' );

		wp_register_script( 'lg-fullscreen.min.js', plugin_dir_url(__FILE__) .'../../js/public/lib/lightGallery/js/lg-fullscreen.min.js',  array( 'jquery' ) );
		wp_enqueue_script( 'lg-fullscreen.min.js' );

	}

}
