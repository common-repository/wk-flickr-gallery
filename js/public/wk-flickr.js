(function() {
    jQuery(document).ready(function() {

        var flickrWrapper = jQuery('.wk-flickr-integration-wrapper');

        if(flickrWrapper.length) {
            var dataProperties = getDataProperties(flickrWrapper);
            var gallery = jQuery("#lightgallery");
            gallery.lightGallery();

            jQuery(".wk-flickr-integration-single-image").each(function () {
                jQuery(this).height(dataProperties.rowHeight).css({"padding": "0 " + dataProperties.space / 2 + "px", "margin-bottom": dataProperties.space + "px"});
                jQuery(this).find('img').height(dataProperties.rowHeight);
                var topSpace = (jQuery(this).find("img").height() / 2) - (jQuery(this).find(".overlay h2").height() / 2);
                jQuery(this).find('.overlay h2').css("top", topSpace);
            });
        }

    });

    jQuery(window).load(function() {
        imageSizingFallback();
    });

    jQuery(document).scroll(function () {

        var flickrWrapper = jQuery('.wk-flickr-integration-wrapper');

        if(flickrWrapper.length) {
            var photosets =  JSON.parse(jQuery(".lazy-load-values").val());
            var dataProperties = getDataProperties(flickrWrapper);
            var lastImage = jQuery(".wk-flickr-integration-single-image:last-child");
            var gallery = jQuery("#lightgallery").lightGallery();

            //lazy load mobile or desktop scroll difference
            var scrollDifference = jQuery(window).width() > 768 ? jQuery(window).height() + 300: 400;

            if((lastImage.offset().top - jQuery(window).scrollTop()) < scrollDifference && dataProperties.type === 'lp') {
                lazyLoadListOfPhotosets(dataProperties, photosets);
            } else if((lastImage.offset().top - jQuery(window).scrollTop()) < scrollDifference && dataProperties.type === 'sp') {
                gallery.data('lightGallery').destroy(true);
                lazyLoadSinglePhotoset(dataProperties, photosets);
                gallery.lightGallery();
            }
        }

    });


    function getDataProperties(flickrWrapper) {

        return {
            type: flickrWrapper.attr('data-type'),
            userId: flickrWrapper.attr('data-id'),
            space: flickrWrapper.attr('data-space'),
            rowHeight: flickrWrapper.attr('data-row-height'),
            cols: flickrWrapper.attr('data-cols'),
            primary: flickrWrapper.attr('data-primary'),
            albumId: flickrWrapper.attr('data-album')
        }
    }

    function lazyLoadListOfPhotosets(dataProperties, photosets) {
        for(var i = 0; i < 6; i++) {
            if(photosets.length != 0) {
                jQuery(".wk-flickr-integration-wrapper").append("<a class='wk-flickr-integration-single-image wk-flickr-integration-col-" + dataProperties.cols + " wk-flickr-integration-item-0' href='https://www.flickr.com/photos/" + dataProperties.userId + "/albums/" + photosets[0].id + "' target='_blank'><img src='https://farm" + photosets[0].farm + ".staticflickr.com/" + photosets[0].server + "/" + photosets[0].primary + "_" + photosets[0].secret + ".jpg/in/album-" + photosets[0].id + "/' style='height: 300px;'><div class='overlay'> <h2 style='top: 129px;'>" + photosets[0].title._content + "</h2> </div></a>");
                photosets = removeCurrentPhotoSetFromArry(photosets);
                appendLazyLoadImage(dataProperties);
            }
        }
    }

    function lazyLoadSinglePhotoset(dataProperties, photosets) {
        for(var i = 0; i < 6; i++) {
            if(photosets.length != 0) {
                jQuery(".wk-flickr-integration-wrapper").append("<a class='wk-flickr-integration-single-image wk-flickr-integration-col-" + dataProperties.cols + " wk-flickr-integration-item-0' href='https://farm" + photosets[0].farm + ".staticflickr.com/" + photosets[0].server + "/" + photosets[0].id + "_" + photosets[0].secret + ".jpg/in/album-" + dataProperties.albumId + "/' target='_blank'><img src='https://farm" + photosets[0].farm + ".staticflickr.com/" + photosets[0].server + "/" + photosets[0].id + "_" + photosets[0].secret + ".jpg/in/album-" + dataProperties.albumId + "/' style='height: 300px;'><div class='overlay'> <h2 style='top: 129px;'>" + photosets[0].title + "</h2> </div></a>");
                photosets = removeCurrentPhotoSetFromArry(photosets);
                appendLazyLoadImage(dataProperties);
            }
        }
    }

    function removeCurrentPhotoSetFromArry(photosets) {
        photosets.splice(0 ,1);
        jQuery(".lazy-load-values").val(JSON.stringify(photosets));
        return photosets;
    }

    function appendLazyLoadImage(dataProperties) {
        var newElement = jQuery(".wk-flickr-integration-single-image:last-child");
        newElement.height(dataProperties.rowHeight).css({"padding": "0 " + dataProperties.space / 2  + "px", "margin-bottom": dataProperties.space + "px"});
        newElement.find("img").height(dataProperties.rowHeight);
        var topSpace = (jQuery(newElement).find(".overlay").height() / 2) - (jQuery(newElement).find(".overlay h2").height() / 2);
        jQuery(newElement).find(".overlay h2").css("top", topSpace);
    }

    function imageSizingFallback() {
        if(isBrowserIE() || isBrowserEdge()) {
            var flickrWrapper = jQuery('.wk-flickr-integration-wrapper');

            jQuery(".wk-flickr-integration-single-image").each(function() {
                var image = jQuery(this).find("img");
                var currentWidth = image.prop("width");
                var originalWidth = image.prop("naturalWidth");
                var originalHeight = image.prop("naturalHeight");
    
                if(currentWidth < originalWidth) {
                    var dataProperties = getDataProperties(flickrWrapper);
                    var offset = (originalWidth - currentWidth) / 2 * -1;
                    image.width(originalWidth / originalHeight * dataProperties.rowHeight);
                    image.css({"margin-left": offset});
                    jQuery(this).addClass("image-crop");
                }
            });
        }
    }

    function isBrowserIE() {
        return /*@cc_on!@*/false || !!document.documentMode;
    }

    function isBrowserEdge() {
        var isIE = isBrowserIE();
        return !isIE && !!window.StyleMedia;
    }
})(jQuery);