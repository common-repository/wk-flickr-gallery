<?php

namespace WebKinder\FlickrPlugin\Admin;

class BackendFields {
    static function wk_flickr_register_backend_fields() {
        if(function_exists('register_field_group')) {
            register_field_group(array (
                'id' => 'acf_layout',
                'title' => __('Layout', 'wk-flickr-gallery'),
                'fields' => array (
                    array (
                        'key' => 'field_588a2155f2a56',
                        'label' => 'Layout',
                        'name' => 'layout',
                        'type' => 'select',
                        'choices' => array (
                            'classic' => __('Classic grid (same image width)', 'wk-flickr-gallery'),
                            'fancy' => __('Fancy grid (different image width)', 'wk-flickr-gallery'),
                        ),
                        'default_value' => '',
                        'allow_null' => 0,
                        'multiple' => 0,
                    ),
                    array (
                        'key' => 'field_588a19e66ac64',
                        'label' => __('Cols (grid)', 'wk-flickr-gallery'),
                        'name' => 'grid',
                        'type' => 'select',
                        'choices' => array (
                            1 => __('1 column', 'wk-flickr-gallery'),
                            2 => __('2 column', 'wk-flickr-gallery'),
                            3 => __('3 column', 'wk-flickr-gallery'),
                            4 => __('4 column', 'wk-flickr-gallery'),
                            5 => __('5 column', 'wk-flickr-gallery'),
                        ),
                        'default_value' => '',
                        'allow_null' => 0,
                        'multiple' => 0,
                    ),
                    array (
                        'key' => 'field_588a1a6c6ac65',
                        'label' => __('Row height (default 300 pixel)', 'wk-flickr-gallery'),
                        'name' => 'row_height',
                        'type' => 'number',
                        'default_value' => 300,
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'min' => '',
                        'max' => '',
                        'step' => '',
                    ),
                    array (
                        'key' => 'field_588a1aba6ac66',
                        'label' => __('Space between images (padding in pixel))', 'wk-flickr-gallery'),
                        'name' => 'space_between_images',
                        'type' => 'number',
                        'default_value' => 5,
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'min' => '',
                        'max' => '',
                        'step' => '',
                    ),
                    array (
                        'key' => 'field_588a1afc6ac67',
                        'label' => __('Title (default shown)', 'wk-flickr-gallery'),
                        'name' => 'title',
                        'type' => 'checkbox',
                        'choices' => array (
                            'hide' => 'hide',
                        ),
                        'default_value' => '',
                        'layout' => 'vertical',
                    ),
                    array (
                        'key' => 'field_588a21ddf2a57',
                        'label' => __('Lightbox', 'wk-flickr-gallery'),
                        'name' => 'lightbox',
                        'type' => 'checkbox',
                        'instructions' => __('Lightbox appears by clicking on an image.', 'wk-flickr-gallery'),
                        'conditional_logic' => array (
                            'status' => 1,
                            'rules' => array (
                                array (
                                    'field' => 'field_588a19e66ac64',
                                    'operator' => '==',
                                    'value' => '1',
                                ),
                            ),
                            'allorany' => 'all',
                        ),
                        'choices' => array (
                            'enable' => 'enable',
                        ),
                        'default_value' => '',
                        'layout' => 'vertical',
                    ),
                ),
                'location' => array (
                    array (
                        array (
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'wk-flickr',
                            'order_no' => 0,
                            'group_no' => 0,
                        ),
                    ),
                ),
                'options' => array (
                    'position' => 'normal',
                    'layout' => 'default',
                    'hide_on_screen' => array (
                    ),
                ),
                'menu_order' => 0,
            ));
            register_field_group(array (
                'id' => 'acf_performance',
                'title' => __('Performance', 'wk-flickr-gallery'),
                'fields' => array (
                    array (
                        'key' => 'field_588a1963fd30a',
                        'label' => __('Lazy loading images', 'wk-flickr-gallery'),
                        'name' => 'disable_lazy_loading',
                        'type' => 'checkbox',
                        'instructions' => __('Default is enabled. (recommended)', 'wk-flickr-gallery'),
                        'choices' => array (
                            'disable' => __('disable (not recommended)', 'wk-flickr-gallery'),
                        ),
                        'default_value' => '',
                        'layout' => 'vertical',
                    ),
                    array (
                        'key' => 'field_588f44abae9c2',
                        'label' => __('Number of preloaded items (default 12)', 'wk-flickr-gallery'),
                        'name' => 'pre_load_items',
                        'type' => 'number',
                        'instructions' => __('All the other items will dynamically be loaded while scrolling. (lazy loading)', 'wk-flickr-gallery'),
                        'conditional_logic' => array (
                            'status' => 1,
                            'rules' => array (
                                array (
                                    'field' => 'field_588a1963fd30a',
                                    'operator' => '!=',
                                    'value' => 'disable',
                                ),
                            ),
                            'allorany' => 'all',
                        ),
                        'default_value' => 12,
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'min' => '',
                        'max' => '',
                        'step' => '',
                    ),
                ),
                'location' => array (
                    array (
                        array (
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'wk-flickr',
                            'order_no' => 0,
                            'group_no' => 0,
                        ),
                    ),
                ),
                'options' => array (
                    'position' => 'normal',
                    'layout' => 'default',
                    'hide_on_screen' => array (
                    ),
                ),
                'menu_order' => 0,
            ));
            register_field_group(array (
                'id' => 'acf_settings',
                'title' => __('Settings', 'wk-flickr-gallery'),
                'fields' => array (
                    array (
                        'key' => 'field_5888aaac1aba1',
                        'label' => __('Flickr user', 'wk-flickr-gallery'),
                        'name' => 'user',
                        'type' => 'select',
                        'instructions' => __('or learn how to add a new user <a onclick="addUserLink()" style="cursor: pointer;">here</a>.
                        <script>function addUserLink() { window.open("", "_blank") }</script>', 'wk-flickr-gallery'),
                        'choices' => array (
                        ),
                        'default_value' => '',
                        'allow_null' => 0,
                        'multiple' => 0,
                    ),
                    array (
                        'key' => 'field_5888aade1aba2',
                        'label' => __('Content element', 'wk-flickr-gallery'),
                        'name' => 'content_type',
                        'type' => 'select',
                        'choices' => array (
                            'sp' => __('single album (photoset)', 'wk-flickr-gallery'),
                            'lp' => __('list of albums (all of a user)', 'wk-flickr-gallery'),
                        ),
                        'default_value' => '',
                        'allow_null' => 0,
                        'multiple' => 0,
                    ),
                    array (
                        'key' => 'field_5889ac0878353',
                        'label' => __('Photoset ID', 'wk-flickr-gallery'),
                        'name' => 'photoset_id',
                        'type' => 'text',
                        'conditional_logic' => array (
                            'status' => 1,
                            'rules' => array (
                                array (
                                    'field' => 'field_5888aade1aba2',
                                    'operator' => '==',
                                    'value' => 'sp',
                                ),
                            ),
                            'allorany' => 'all',
                        ),
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'formatting' => 'html',
                        'maxlength' => '',
                    ),
                ),
                'location' => array (
                    array (
                        array (
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'wk-flickr',
                            'order_no' => 0,
                            'group_no' => 0,
                        ),
                    ),
                ),
                'options' => array (
                    'position' => 'acf_after_title',
                    'layout' => 'default',
                    'hide_on_screen' => array (
                    ),
                ),
                'menu_order' => 0,
            ));
        }
    }
}
