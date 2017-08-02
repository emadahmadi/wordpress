/**
 * File customizer-controls.js
 *
 * The file for generic customizer controls.
 */

jQuery(document).ready( function() {
    'use strict';

    jQuery('#customizer-repeater-hestia_team_content-colector').on('change', function(){

        var authors_values = wp.customize._value.hestia_authors_on_blog();
        var result = '';
        jQuery('#customize-control-hestia_team_content .customizer-repeater-general-control-repeater-container').each( function () {
            var title = jQuery(this).find('.customizer-repeater-title-control').val();
            var id = jQuery(this).find('.social-repeater-box-id').val();
            if( typeof (title) !== 'undefined' && title !== '' &&  typeof (id) !== 'undefined' && id !== '' ) {
                result += '<option value="' + id + '" ';
                if( authors_values.indexOf( id ) !== -1 ){
                    result += 'selected';
                }
                result += '>' + title + '</option>';
            }
        });

        jQuery('#customize-control-hestia_authors_on_blog .repeater-multiselect-team').html( result );

    });

    /* Move controls to Widgets sections. Used for sidebar placeholders */
    if ( typeof wp.customize.control( 'hestia_placeholder_sidebar_1' ) !== 'undefined' ) {
        wp.customize.control('hestia_placeholder_sidebar_1').section('sidebar-widgets-sidebar-1');
    }
    if ( typeof wp.customize.control( 'hestia_placeholder_sidebar_woocommerce' ) !== 'undefined' ) {
        wp.customize.control('hestia_placeholder_sidebar_woocommerce').section('sidebar-widgets-sidebar-woocommerce');
    }
});
