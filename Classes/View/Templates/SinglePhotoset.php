<?php

namespace WebKinder\FlickrPlugin\View\Templates;

class SinglePhotoset {

    static function print_template( $backendData, $photoset ) {
        ?>

        <div class="wk-flickr-integration-wrapper wk-flickr-integration-images" id="lightgallery" data-id="<?php echo $backendData['user_id'] ?>" data-album="<?php echo $photoset['id'] ?>" data-type="<?php echo $backendData['type'] ?>" data-cols="<?php echo $backendData['columns'] ?>" data-row-height="<?php echo $backendData['row_height'] ?>" data-space="<?php echo $backendData['space_between'] ?>" data-lazy-load="<?php echo $backendData['lazy_load'] ?>" data-pre-load-items="<?php echo $backendData['lazy_load'] ?>" data-primary="<?php echo $backendData['primary'] ?>">
            <?php foreach ( $photoset["photo"] as $key=>$single_image ): ?>
                <?php if ( $key < $backendData['pre_load_items'] && $photoset ): ?>
                    <a class="wk-flickr-integration-single-image wk-flickr-integration-col-<?php echo $backendData['columns'] ?> wk-flickr-integration-item-<?php echo $key ?>" href="https://farm<?php echo $single_image['farm']; ?>.staticflickr.com/<?php echo $single_image['server']; ?>/<?php echo $single_image['id']; ?>_<?php echo $single_image['secret']; ?>.jpg/in/album-<?php echo $photoset['id']; ?>/"
                       target="_blank">
                       <div class="image-container">
                            <img src="https://farm<?php echo $single_image['farm']; ?>.staticflickr.com/<?php echo $single_image['server']; ?>/<?php echo $single_image['id']; ?>_<?php echo $single_image['secret']; ?>.jpg/in/album-<?php echo $photoset['id']; ?> /">
                            <?php if( !$backendData['hide_title'] ): ?>
                                <div class="overlay">
                                    <h2><?php echo $single_image['title']; ?></h2>
                                </div>
                            <?php endif; ?>
                       </div>
                    </a>
                    <?php unset( $photoset['photo'][ $key ] ); ?>
                <?php endif; ?>
            <?php endforeach; ?>

        </div>
        <input type="hidden" class="lazy-load-values" value="<?php echo htmlspecialchars( json_encode( array_values( $photoset['photo'] ) ) ) ?>">

        <?php
    }

}
