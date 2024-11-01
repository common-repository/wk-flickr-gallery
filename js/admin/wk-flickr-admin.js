(function() {
    jQuery(document).ready(function() {

        /* Settings page */

        if(jQuery('.wk-json-value-container').length != 0) {
            var last_user_id = 0;
            var json_field = [];

            init_json_field();

            //add action on click
            jQuery('.wk-add-user').click(function(e) {
                e.preventDefault();
                add_user_field(jQuery('.wk-new-user').val());
            });

            //add action on enter
            jQuery('.wk-new-user').keyup(function(e) {
                if (e.keyCode === 13) {
                    e.preventDefault();
                    add_user_field(jQuery('.wk-new-user').val());
                }
            });

            //edit action
            jQuery('.wk-user-edit').live("click", function(e) {
                e.preventDefault();
                edit_user_field(jQuery(this).parent().parent());
            });

            //remove action
            jQuery('.wk-user-remove').live("click", function(e) {
                e.preventDefault();

                if (window.confirm(local[2].confirm_delete)) {
                    remove_user_field(jQuery(this).parent().parent());
                }
            });
        }

        /* create photoset page */

        var user_array = local[0].split(',').filter(Boolean).sort();
        var user_select_box = jQuery('#acf-field-user');

        user_select_box.html('');

        if (!local[1]) {
            user_select_box.append('<option value="false">' + local[2].select_user + '</option>');
        }

        user_array.forEach(create_select_options);

        if(jQuery('body').hasClass('post-type-wk-flickr')) {
            displayShortcode();
        }
    });

    function create_select_options(name, index, array) {
        if(local[1] == name) {
            jQuery('#acf-field-user').append('<option value="' + name + '" selected>' + name + '</option>');
            return false;
        }

        jQuery('#acf-field-user').append('<option value="' + name + '">' + name + '</option>');
    }

    function init_json_field() {

        //kill form submitting by enter
        jQuery('#wk-flickr-integration-settings-form').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

        json_field = jQuery('.wk-json-value-container').val().split(',');
        json_field.forEach(loop_json_fields);
    }


    function add_user_field(user_name) {

        hide_error();

        if (user_id_empty(user_name)) {
            show_error(local[2].no_user_id);
            return false;
        } else if (user_id_exist(user_name)) {
            show_error(local[2].user_id_exists);
            return false;
        }

        json_field.push(user_name);
        jQuery('.wk-json-value-container').val(json_field);
        last_user_id = json_field.length;

        generate_user_field(user_name, last_user_id);

        check_if_user_exist(user_name, jQuery("#wk-user-" + (last_user_id - 1)).find(".wk-user-name"));

        jQuery('.wk-new-user').val('');
    }


    function edit_user_field(element) {
        var edit_field = element.find('.wk-user-id');
        var save_field = element.find('.wk-user-edit');
        var current_value = edit_field.html();

        edit_field.html('<input type="text" value="' + current_value + '" class="wk-user-edit-input">');

        save_field.removeClass('wk-user-edit').addClass('wk-user-edit-save');
        save_field.html('<i class="fa fa-floppy-o" aria-hidden="true"></i>');

        //add action on enter
        jQuery('.wk-user-edit-input').keyup(function(e) {
            if (e.keyCode === 13) {
                e.preventDefault();
                save_edited_field(element, save_field, edit_field);
            }
        });

        jQuery('.wk-user-edit-save').live("click", function(e) {
            e.preventDefault();
            save_edited_field(element, save_field, edit_field);
        });

    }


    function remove_user_field(element) {

        var id = element.attr('id').charAt(element.attr('id').length - 1);
        json_field.splice(id, 1);
        last_user_id = json_field.length - 1;
        set_value_of_json_field(json_field);
        element.remove();

        jQuery('.wk-user').each(function(i) {
            jQuery(this).attr('id', 'wk-user-' + i);
        });
    }


    function loop_json_fields(name, index, array) {
        if (name) {
            generate_user_field(name, index + 1);
            check_if_user_exist(name, jQuery("#wk-user-" + (index)).find(".wk-user-name"));
        }
    }


    //validation
    function user_id_empty(user_id) {
        if (!user_id) {
            return true;
        }

        return false;
    }

    //validation
    function user_id_exist(user_id) {
        var exist = false;

        jQuery('.wk-user').each(function() {
            if (jQuery(this).find('.wk-user-id').html().toLowerCase() === user_id.toLowerCase()) {
                exist = true;
                return false;
            }
        });

        if (exist) {
            return true;
        }

        return false;
    }


    function show_error(message) {
        jQuery('.wk-error-message').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ' + message);
    }

    function hide_error(message) {
        jQuery('.wk-error-message').html('');
    }

    function check_if_user_exist(user_name, element) {

        var api_field = jQuery('.api_field').val();
        var url = "https://api.flickr.com/services/rest/?method=flickr.people.findByUsername&api_key=" + api_field + "&username=" + user_name + "&format=json&nojsoncallback=1";

        if (!api_field) {
            show_error(local[2].add_api_key);
            return false;
        }

        jQuery.ajax(url, {
            success: function(data) {
                if (data.stat === "fail") {
                    element.html('<span class="wk-user-not-found"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ' + data.message + '</span>');
                    return false;
                }

                element.html('<i class="fa fa-check" aria-hidden="true"></i> ' + data.user.id);
            },
            error: function(e) {
                return e;
            }
        });
    }

    function save_edited_field(element, save_field, edit_field) {
        var new_value = element.find('.wk-user-edit-input').val();
        edit_field.html(new_value);
        save_field.removeClass('wk-user-edit-save').addClass('wk-user-edit');
        save_field.html('<i class="fa fa-pencil" aria-hidden="true"></i>');

        var user_name = element.find('.wk-user-name');

        var id = element.attr('id').charAt(element.attr('id').length - 1);
        json_field[id] = new_value;
        set_value_of_json_field(json_field);

        user_name.html(local[2].checking_progress);
        check_if_user_exist(new_value, user_name);
    }

    function set_value_of_json_field(value) {
        jQuery('.wk-json-value-container').val(value);
    }

    function generate_user_field(user_name, index) {
        jQuery('#users-table').append(
            "<tr id='wk-user-" + (index - 1) + "' class='wk-user'>" +
            "<td class='wk-user-name'>" + local[2].checking_progress + "</td>" +
            "<td class='wk-user-id'>" + user_name + "</td>" +
            "<td><a href=''  class='wk-user-edit'><i class='fa fa-pencil' aria-hidden='true'></i></a></td>" +
            "<td><a href='' class='wk-user-remove'><i class='fa fa-trash-o' aria-hidden='true'></i></a></td>" +
            "</tr>"
        );
    }

    function displayShortcode() {
        var postId = jQuery("#post_ID").val();
        var shortcode = "<span class='wk-flickr-shortcode'>" + local[2].display_gallery + "<strong>[flickr-grid id='" + postId + "']</strong><a class='copy-button'><i class='fa fa-files-o' aria-hidden='true'></i> " + local[2].copy_button + "</a><input class='copy-text' value='[flickr-grid id=\"" + postId + "\"]'></span>"
        jQuery("#titlediv").append(shortcode);

        copyShortcode();
    }

    function copyShortcode() {
        jQuery(".wk-flickr-shortcode .copy-button").click(function() {
            var copyTextarea = document.querySelector('.wk-flickr-shortcode .copy-text');
            copyTextarea.select();
            try {
                document.execCommand("copy");              
                var successMessage = "<span class='wk-flickr-copy-message wk-flickr-copy-success-message'><i class='fa fa-check' aria-hidden='true'></i> " + local[2].copied + "</span>";
                var message = appendCopyMessage(successMessage);
            } catch (err) {
                var errorMessage = "<span class='wk-flickr-copy-message wk-flickr-copy-error-message'><i class='fa fa-times-circle' aria-hidden='true'></i> " + local[2].unable_to_copy + "</span>";
                var message = appendCopyMessage(errorMessage);
            }
        });
    }

    function appendCopyMessage(message) {
        var message = jQuery(message).hide().appendTo("#titlediv").fadeIn(600);

        setTimeout(function() {
            message.fadeOut( 600, function() {
                jQuery(this).remove();
            });
        }, 5000);

        return message;
    }
})(jQuery);
