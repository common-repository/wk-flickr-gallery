<?php

namespace WebKinder\FlickrPlugin\View\Templates;

class PhotosetList {
    static function print_template( $backendData, $photosets ) {
        ?>

        <div class="wk-flickr-integration-wrapper flickr-photosets wk-flickr-integration-images" data-id="<?php echo $backendData['user_id'] ?>" data-type="<?php echo $backendData['type'] ?>" data-layout="<?php echo $backendData['layout'] ?>" data-cols="<?php echo $backendData['columns'] ?>" data-row-height="<?php echo $backendData['row_height'] ?>" data-space="<?php echo $backendData['space_between'] ?>" data-lazy-load="<?php echo $backendData['lazy_load'] ?>" data-pre-load-items="<?php echo $backendData['lazy_load'] ?>">
            <?php foreach ( $photosets as $key=>$photoset ): ?>
                <?php if ( $key < $backendData['pre_load_items'] && $photoset ): ?>
                    <a class="wk-flickr-integration-single-image wk-flickr-integration-col-<?php echo $backendData['columns'] ?> wk-flickr-integration-item-<?php echo $key ?>" href="https://www.flickr.com/photos/<?php echo $backendData['user_id']; ?>/albums/<?php echo $photoset['id']; ?>"
                       target="_blank">
                       <div class="image-container">
                            <img src="https://farm<?php echo $photoset['farm']; ?>.staticflickr.com/<?php echo $photoset['server']; ?>/<?php echo $photoset['primary']; ?>_<?php echo $photoset['secret']; ?>.jpg/in/album-<?php echo $photoset['id']; ?> /">

                            <?php if( !$backendData['hide_title'] ): ?>
                                <div class="overlay">
                                    <h2><?php echo $photoset['title']['_content']; ?></h2>
                                </div>
                            <?php endif; ?>
                       </div>
                    </a>
                <?php unset( $photosets[ $key ] ); ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <input type="hidden" class="lazy-load-values" value="<?php echo htmlspecialchars( json_encode( array_values( $photosets ) ) ) ?>">

        <?php
    }
}
