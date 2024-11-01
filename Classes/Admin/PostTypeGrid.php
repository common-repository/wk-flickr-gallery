<?php

namespace WebKinder\FlickrPlugin\Admin;

class PostTypeGrid {

    static function wk_flickr_add_post_type() {
        $labels = array(
            'name' => _x('Flickr Gallery', 'Post Type General Name', 'wk-flickr-gallery'),
            'singular_name' => _x('Flickr Gallery', 'Post Type Singular Name', 'wk-flickr-gallery'),
            'menu_name' => __('Flickr Gallery', 'wk-flickr-gallery'),
            'name_admin_bar' => __('Ratings', 'wk-flickr-integration'),
            'parent_item_colon' => __('Parent Item:', 'wk-flickr-gallery'),
            'all_items' => __('All Items', 'wk-flickr-gallery'),
            'add_new_item' => __('Add New Item', 'wk-flickr-gallery'),
            'add_new' => __('Add New', 'wk-flickr-gallery'),
            'new_item' => __('New Item', 'wk-flickr-gallery'),
            'edit_item' => __('Edit Item', 'wk-flickr-gallery'),
            'update_item' => __('Update Item', 'wk-flickr-gallery'),
            'view_item' => __('View Item', 'wk-flickr-gallery'),
            'search_items' => __('Search Item', 'wk-flickr-gallery'),
            'not_found' => __('Not found', 'wk-flickr-gallery'),
            'not_found_in_trash' => __('Not found in Trash', 'wk-flickr-gallery'),
            'items_list' => __('Items list', 'wk-flickr-gallery'),
            'items_list_navigation' => __('Items list navigation', 'wk-flickr-gallery'),
            'filter_items_list' => __('Filter items list', 'wk-flickr-gallery'),
        );
        $args = array(
            'label' => __('Flickr Gallery', 'wk-flickr-gallery'),
            'labels' => $labels,
            'supports' => array(),
            'hierarchical' => false,
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => true,
            'can_export' => true,
            'has_archive' => true,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'capability_type' => 'post',
        );

        register_post_type( 'wk-flickr', $args );
        remove_post_type_support( 'wk-flickr', 'editor' );
    }

}
