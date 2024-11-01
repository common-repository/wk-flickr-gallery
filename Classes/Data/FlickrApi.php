<?php

namespace WebKinder\FlickrPlugin\Data;
    use WebKinder\FlickrPlugin\Shared\ErrorHandler;

class FlickrApi {

    static function wk_flickr_get_all_photosets_of_user( $api_key, $user_id ) {


        $response = wp_remote_get( 'https://api.flickr.com/services/rest/?method=flickr.photosets.getList&api_key=' . $api_key . '&user_id=' . $user_id . '&format=json&nojsoncallback=1' );

        if( is_array( $response ) ) {
            $body = json_decode( $response['body'], true );

            if($body['stat'] == 'fail') {
                ErrorHandler::display_error( $body['message'] );
                return false;
            }

            return $body;
        }
        if( is_wp_error( $response ) ) {
            ErrorHandler::display_error( __('Flickr API is currently not available!', 'wk-flickr-gallery') );
            return false;
        }

        return false;
    }


    static function wk_flickr_get_single_photoset( $photoset_id, $api_key, $user_id ) {


        $response = wp_remote_get( 'https://api.flickr.com/services/rest/?method=flickr.photosets.getPhotos&api_key=' . $api_key . '&photoset_id=' . $photoset_id . '&user_id=' . $user_id . '&format=json&nojsoncallback=1' );

        if( is_array( $response ) ) {
            $body = json_decode( $response['body'], true );

            if( $body['stat'] == 'fail' ) {
                ErrorHandler::display_error( $body['message'] );
                return false;
            }

            return $body['photoset'];
        }
        if( is_wp_error( $response ) ) {
            ErrorHandler::display_error( __('Flickr API is currently not available!', 'wk-flickr-gallery') );
            return false;
        }

        return false;
    }

    static function wk_flickr_get_user_id_by_name( $username, $api_key ) {


        $response = wp_remote_get( 'https://api.flickr.com/services/rest/?method=flickr.people.findByUsername&api_key=' . $api_key . '&username=' . $username . '&format=json&nojsoncallback=1' );

        if( is_array( $response ) ) {
            $body = json_decode( $response['body'], true );

            if( $body['stat'] == 'fail' ) {
                ErrorHandler::display_error( $body['message'] );
                return false;
            }

            return $body['user']['id'];
        }
        if( is_wp_error( $response ) ) {
            ErrorHandler::display_error( __('Flickr API is currently not available!', 'wk-flickr-gallery') );
            return false;
        }

        return false;
    }


}
