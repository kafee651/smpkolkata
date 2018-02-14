/**
 *	CrunchPress Edit Box File
 *	---------------------------------------------------------------------
 * 	@version	1.0
 * 	@author		CrunchPress
 * 	@link		http://crunchpress.com
 * 	@copyright	Copyright (c) CrunchPress
 * 	---------------------------------------------------------------------
 * 	This file contains the script of the editbox that create overlay over
 *	any elements and copy desired element to be showed in that overlay.
 *	---------------------------------------------------------------------
 */
jQuery(document).ready(function () {

    // initialize necessary variables
    var theneeds_div_wrapper = jQuery('#cp-overlay-wrapper');
    var theneeds_edit_box_elements = {
        editbox: '<div class="bootstrap_admin" id="cp-edit-box">\
					<div id="cp-overlay"></div>\
					<div id="cp-overlay2"></div>\
					<div class="" id="cp-inline-wrapper">\
						<div class="cp-inline-header">\
							<div class="cp-inline-header-wrapper">\
								<div class="cp-inline-header-inner-wrapper" >\
									<div class="cp-inline-header-text"> EDITOR </div>\
									<div id="cp-head-edit-img" class="cp-head-edit-img"></div>\
								</div>\
							</div>\
							<div id="close-cp-edit-box"></div>\
						</div>\
						<div class="container-fluid" id="cp-inline"></div>\
						<div class="cp-inline-footer">\
							<input type="button" value="Done" id="cp-inline-edit-done" class="cp-button">\
							<br class="clear">\
						</div>\
					</div>\
				</div>',
        opacity: 0.42
    };

    theneeds_div_wrapper.append(theneeds_edit_box_elements.editbox);

    var theneeds_editbox = theneeds_div_wrapper.find('#cp-edit-box');
    var theneeds_content = theneeds_editbox.siblings('#cp-overlay-content');
    var theneeds_overlay = theneeds_editbox.find('#cp-overlay');
    var theneeds_inline = theneeds_editbox.find('#cp-inline');
    var theneeds_clicked_item = '';
    var theneeds_item_size = '';
    var theneeds_edit_item = '';
    var theneeds_clone_item = '';

    // bind the initialize elements
    theneeds_editbox.children().css('display', 'none');
    theneeds_overlay.css('opacity', theneeds_edit_box_elements.opacity);
    jQuery('#close-cp-edit-box').click(function () {
        theneeds_close_editbox();
    });
    jQuery('#cp-inline-edit-done').click(function () {
        theneeds_close_editbox();
    });
    jQuery('div[rel="cp-edit-box"]').click(function () {
        theneeds_clicked_item = jQuery(this);
        theneeds_item_size = theneeds_clicked_item.parents('#page-element-item').find('#element-size-text').html();
        theneeds_item_size = parseInt(theneeds_item_size.substr(0, 1)) / parseInt(theneeds_item_size.substr(2, 1));
        theneeds_open_editbox();
    });
    jQuery('input#publish[name="save"]').click(function () {
        theneeds_close_editbox();
    });

    // copy the content and open the edit box to use
    function theneeds_open_editbox() {
        clicked_id = theneeds_clicked_item.attr('id');
        theneeds_edit_item = theneeds_clicked_item.parents('#page-element-item').siblings('#' + clicked_id);
        theneeds_clone_item = theneeds_edit_item.children().clone(true);

        var li_cloned = theneeds_clone_item.find('div.selected-image ul').children().clone(true);
        li_cloned = jQuery('<ul></ul>').append(li_cloned);
        theneeds_clone_item.find('div.selected-image ul').replaceWith(li_cloned)
        theneeds_clone_item.find('div.selected-image ul').sortable({
            tolerance: 'pointer',
            forcePlaceholderSize: true,
            placeholder: 'slider-placeholder',
            cancel: '.slider-detail-wrapper'
        });

        //theneeds_clone_item.css('display','block');

        // Remove unnecessary size
        theneeds_clone_item.find("#page-option-item-testimonial-size, #page-option-item-portfolio-size, \
			#page-option-item-blog-size, #page-option-item-page-size").children("option").each(function () {
            var item_size = jQuery(this).html();

            if (item_size == "Widget Style") {
                item_size = 1 / 8;
            } else {
                item_size = parseInt(item_size.substr(0, 1)) / parseInt(item_size.substr(2, 1));
            }

            if (theneeds_item_size >= item_size) {
                jQuery(this).css('display', 'block');
            } else {
                jQuery(this).css('display', 'none');
            }
        });

        theneeds_inline.append(theneeds_clone_item);

        // Open Process
        theneeds_editbox.children().fadeIn(600);
        theneeds_content.hide(function () {
            jQuery(this).css('position', 'absolute');
            jQuery(this).show();
        });

    }

    // manipulate the edited content and close editbox 
    function theneeds_close_editbox() {
        var theneeds_edited_item = theneeds_inline.children().clone(true);
        if (theneeds_edit_item) {
            theneeds_edit_item.html(theneeds_edited_item);
        }
        theneeds_clear_editbox();
    }

    // clear the editbox variables and internal content
    function theneeds_clear_editbox() {
        theneeds_content.hide(0, function () {
            theneeds_content.css('position', 'relative');
            theneeds_content.slideDown(600);
            theneeds_editbox.children().fadeOut(function () {
                theneeds_inline.children().remove();
                theneeds_edit_item = '';
                theneeds_clone_item = '';
                theneeds_clicked_item = '';
            });
        });
    }

    jQuery.fn.bindEditBox = function () {
        theneeds_clicked_item = jQuery(this);
        theneeds_open_editbox();
    }
});

// Fix the clone problem of <textarea> and <select> elements
(function (original) {
    jQuery.fn.clone = function () {
        var result = original.apply(this, arguments),
            my_textareas = this.find('textarea, select'),
            result_textareas = result.find('textarea, select');

        for (var i = 0, l = my_textareas.length; i < l; ++i)
        jQuery(result_textareas[i]).val(jQuery(my_textareas[i]).val());

        return result;
    };
})(jQuery.fn.clone);