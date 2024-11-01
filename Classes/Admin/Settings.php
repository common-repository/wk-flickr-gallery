<?php
/*
 * Flickr Gallery
 * Settings Class
 */

namespace WebKinder\FlickrPlugin\Admin;

class Settings {

    /*==========================METHODS========================*/

    /*
     * Register Settings
     */
    public function register() {
        register_setting( 'wk_flickr_group', 'wk_flickr_settings' );
        add_settings_section(
            'api-section',
            __( 'API', 'wk-flickr-gallery' ),
            array( $this, 'api_section' ),
            'wk-flickr-integration'
        );
        add_settings_field(
            'api-field',
            __('API key', 'wk-flickr-gallery' ),
            array( $this, 'api_field' ),
            'wk-flickr-integration',
            'api-section'
        );
        add_settings_field(
            'hide-on',
            __('Users', 'wk-flickr-gallery' ),
            array( $this, 'hide_on' ),
            'wk-flickr-integration',
            'api-section'
        );
    }

    /*
     * Render
     */
    public function render() {
        add_options_page(
            'Flickr Gallery',
            'Flickr Gallery',
            'manage_options',
            'wk-flickr-integration',
            array( $this, 'content' )
        );
    }

    /*
     * Content
     */
    public function content() {
        ?>
        <div class="wrap">
            <h2><?php _e( 'Flickr Gallery settings', 'wk-flickr-gallery' ); ?></h2>
            <form action="options.php" method="POST" id="wk-flickr-integration-settings-form">
                <?php settings_fields( 'wk_flickr_group' ); ?>
                <?php do_settings_sections( 'wk-flickr-integration' ); ?>
                <?php submit_button( __( 'Save' , 'wk-flickr-gallery' ) ); ?>
            </form>
        </div>

        <?php
    }

    /*
     * Section: API Section
     * Name: 	api_section
     */
    public function api_section() {
        __( 'Holds the information for the Flickr API.', 'wk-flickr-gallery' );
    }

    /*
     * Section: Users Section
     * Name: 	users_section
     */
    public function users_section() {
        __( 'Holds the default flickr user ID.', 'wk-flickr-gallery' );
    }

    /*
     * Field: 	API Field
     * Name: 	api_field
     */
    public function api_field() {
        $field = 'api-field';
        $value = $this->get_wk_flickr_option( $field );

        echo "<input type='text' class='api_field' name='wk_flickr_settings[$field]' value='$value' /><span class='wk-field-hint'>get your API key <a href='https://www.flickr.com/services/apps/create/apply' target='_blank'>here</a></span>";
    }

    /**
     * Field: Hide on
     * Name: 	hide_on
     */
    public function hide_on() {
        $field = 'hide-on';
        $value = $this->get_wk_flickr_option( $field );
        ?>

        <div class="wk-json-setting">
            <form action="javascript:void(0)">
                <input type="text" class="wk-new-user" placeholder="Username">
            </form>
            <button class="wk-add-user"><i class="fa fa-plus" aria-hidden="true"></i> <?php printf( __( 'Add user', 'wk-flickr-gallery' ) ); ?> </button>
            <span class="wk-field-hint">find your username <a href='https://www.flickr.com/account/' target='_blank'>here</a></span>
            <input type="hidden" class="wk-json-value-container" name="wk_flickr_settings[<?php echo $field; ?>]" value="<?php echo $value; ?>" />
            <span class="wk-error-message"></span>
            <table id="users-table">
                <tr>
                    <th><?php printf( __( 'User ID', 'wk-flickr-gallery' ) ); ?> </th>
                    <th><?php printf( __( 'Username', 'wk-flickr-gallery' ) ); ?> </th>
                    <th><?php printf( __( 'Edit', 'wk-flickr-gallery' ) ); ?> </th>
                    <th><?php printf( __( 'Remove', 'wk-flickr-gallery' ) ); ?> </th>
                </tr>
            </table>
        </div>

        <?php
    }

    /*
     * Get Options Helper
     */
    public function get_wk_flickr_option( $optionname ) {
        $defaults = array(
            'api-field' => '',
            'hide-on' => ''
        );
        return wp_parse_args( get_option( 'wk_flickr_settings' ), $defaults )[ $optionname ];
    }
}
