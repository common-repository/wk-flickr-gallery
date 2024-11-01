<?php

namespace WebKinder\FlickrPlugin\View;
    use WebKinder\FlickrPlugin\Init\ScriptLoader;
    use WebKinder\FlickrPlugin\Data\BackendApi;
    use WebKinder\FlickrPlugin\Data\FlickrApi;
    use WebKinder\FlickrPlugin\Shared\ErrorHandler;
    use WebKinder\FlickrPlugin\View\Templates\PhotosetList;
    use WebKinder\FlickrPlugin\View\Templates\SinglePhotoset;

class ShortcodePrimary {

    public function add_shortcode( $atts = '' ) {

        if( !isset( $atts['id'] ) || !is_numeric( $atts['id'] ) ) {
            ErrorHandler::display_error( __('Please use a valid id in the shortcode.', 'wk-flickr-gallery') );
            return false;
        };

        $backendData = BackendApi::get_backend_fields( $atts['id'] );

        if( !$backendData ) {
            ErrorHandler::display_error( __('The id in the shortcode does not exist or is not a Flickr Gallery Element!', 'wk-flickr-gallery') );
            return false;
        };

        ScriptLoader::load_light_gallery();

        if( $backendData['type'] == 'lp' ) {
            $photosets = FlickrApi::wk_flickr_get_all_photosets_of_user( $backendData['api_key'], $backendData['user_id'] )['photosets']['photoset'];

            if( !$photosets ) {
                return false;
            } elseif( sizeof($photosets) && $backendData['lazy_load'] != '' ) {
                $backendData['pre_load_items'] = sizeof($photosets);
                PhotosetList::print_template( $backendData, $photosets );
            } elseif( sizeof($photosets) ) {
                PhotosetList::print_template( $backendData, $photosets );
            } else {
                ErrorHandler::display_error( __('No photosets found on this account! Or maybe they are not public till now.', 'wk-flickr-gallery') );
            }

        } elseif( $backendData['type'] == 'sp' ) {
            $backendData['photoset_id'] = get_field( 'photoset_id', $atts['id'] );
            $photoset = FlickrApi::wk_flickr_get_single_photoset( $backendData['photoset_id'], $backendData['api_key'], $backendData['user_id'] );
            $backendData['primary'] = $photoset['primary'];

            if( !$photoset ) {
                return false;
            } elseif( sizeof( $photoset ) && $backendData['lazy_load'] != '' ) {
                $backendData['pre_load_items'] = sizeof( $photoset );
                SinglePhotoset::print_template( $backendData, $photoset );
            } elseif( sizeof( $photoset ) ) {
                SinglePhotoset::print_template( $backendData, $photoset );
            } else {
                ErrorHandler::display_error( __('No images found in this album! Or maybe they are not public till now.', 'wk-flickr-gallery') );
            }

        } else {
            ErrorHandler::display_error( __('Layout does not exist! Please try to use another.', 'wk-flickr-gallery') );
        }
    }
}
