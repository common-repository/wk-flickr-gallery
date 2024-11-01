<?php

namespace WebKinder\FlickrPlugin\Data;

class BackendApi {
    static function get_backend_fields( $post_id ) {

        if( !get_field('content_type', $post_id ) ) return false;

        $type = get_field( 'content_type', $post_id );
        $columns = get_field( 'grid', $post_id );
        $hide_title = get_field( 'title', $post_id );
        $row_height = get_field( 'row_height', $post_id );
        $space_between = get_field( 'space_between_images', $post_id );
        $lazy_load = get_field( 'disable_lazy_loading', $post_id );
        $pre_load_items = get_field( 'pre_load_items', $post_id );
        $layout = get_field( 'layout', $post_id );

        $user = get_field( 'user', $post_id );
        $defaults = array( 'api-field' => '', 'hide-on' => '' );
        $api_key = wp_parse_args( get_option( 'wk_flickr_settings' ), $defaults )['api-field'];
        $user_id = FlickrApi::wk_flickr_get_user_id_by_name( $user, $api_key );

        return array(
            'type' => $type,
            'columns' => $columns,
            'row_height' => $row_height,
            'space_between' => $space_between,
            'lazy_load' => $lazy_load,
            'hide_title' => $hide_title,
            'pre_load_items' => $pre_load_items,
            'layout' => $layout,
            'user_id' => $user_id,
            'api_key' => $api_key
        );
    }

}