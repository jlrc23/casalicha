<?php

// returns the modal ID from its slug
function smw_get_modal_by_title($modal_title, $output = OBJECT) {
    global $wpdb;
        $modal = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_title = %s AND post_type='modals'", $modal_title ));
        if ( $modal )
            return get_post($modal, $output);

    return null;
}