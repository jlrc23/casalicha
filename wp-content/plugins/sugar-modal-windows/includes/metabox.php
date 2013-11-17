<?php

include_once('metabox/meta-box-3.2.class.php');

function smw_load_metaboxes() {

    global $smw_base_dir;

    $prefix = 'smw_';
    $smw_meta_boxes = array();

    $smw_meta_boxes[] = array(
        'id' => 'modal-meta',
        'title' => __('Modal Window Configuration', 'sugar_modal' ),
        'pages' => array('modals'),
        'context' => 'side',
        'priority' => 'core',
        'fields' => array(
            array(
                'name' => __('Width', 'sugar_modal' ),
                'desc' => __('Choose a size in PX, such as <em>600</em>', 'sugar_modal' ),
                'id' => $prefix . 'width',
                'type' => 'slider',
    			'step' => 1,
    			'max' => 800,
                'std' => 600
            ),
    		array(
                'name' => __('Auto Height', 'sugar_modal' ),
                'desc' => __('Set height automatically', 'sugar_modal' ),
                'id' => $prefix . 'auto_height',
                'type' => 'checkbox'
            ),
    		array(
                'name' => __('Height', 'sugar_modal' ),
                'desc' => __('Choose a size in PX, such as <em>300</em>', 'sugar_modal' ),
                'id' => $prefix . 'height',
                'type' => 'slider',
    			'step' => 1,
    			'max' => 800,
                'std' => 400
            ),
    		array(
                'name' => __('Speed', 'sugar_modal' ),
                'desc' => __('Popup speed in MS', 'sugar_modal' ),
                'id' => $prefix . 'speed',
                'type' => 'slider',
    			'max' => 3000,
    			'step' => 1,
                'std' => 600
            ),
    		array(
                'name' => __('Title', 'sugar_modal' ),
                'desc' => __('Disable the title bar', 'sugar_modal' ),
                'id' => $prefix . 'title',
                'type' => 'checkbox'
            ),
    		array(
                'name' => __('Close', 'sugar_modal' ),
                'desc' => __('Disable the close button', 'sugar_modal' ),
                'id' => $prefix . 'close',
                'type' => 'checkbox'
            )
        )
    );

    $smw_meta_boxes[] = array(
        'id' => 'modal-open-meta',
        'title' => __('Auto Open Configuration', 'sugar_modal' ),
        'pages' => array('modals'),
        'context' => 'side',
        'priority' => 'core',
        'fields' => array(

    		array(
                'name' => __('Open on Load', 'sugar_modal' ),
                'desc' => __('Auto open on page load?', 'sugar_modal' ),
                'id' => $prefix . 'auto_open',
                'type' => 'checkbox'
            ),
    		array(
                'name' => __('First Load', 'sugar_modal' ),
                'desc' => __('Auto open on first load only?', 'sugar_modal' ),
                'id' => $prefix . 'first_load',
                'type' => 'checkbox'
            ),
    		array(
                'name' => __('Delay', 'sugar_modal' ),
                'desc' => __('Wait X number of MS?', 'sugar_modal' ),
                'id' => $prefix . 'delay',
                'type' => 'checkbox'
            ),
    		array(
                'name' => __('Delay', 'sugar_modal' ),
                'desc' => __('Time in MS', 'sugar_modal' ),
                'id' => $prefix . 'delay_time',
                'type' => 'slider',
    			'max' => 10000,
    			'step' => 1,
                'std' => 3000
            )
        )
    );

    $smw_meta_boxes[] = array(
        'id' => 'advanced-modal-meta',
        'title' => __('Advanced Modal Window Configuration', 'sugar_modal' ),
        'pages' => array('modals'),
        'context' => 'normal',
        'priority' => 'high',
        'fields' => array(
    		array(
                'name' => __('Transparency', 'sugar_modal' ),
                'desc' => __('Window transparency. Between 0-100. For no transparency, set to 100', 'sugar_modal' ),
                'id' => $prefix . 'trans',
                'type' => 'slider',
    			'step' => 1,
    			'max' => 100,
                'std' => 90
            ),
    		array(
                'name' => __('Opacity', 'sugar_modal' ),
                'desc' => __('Overlay opacity. Between 0-100', 'sugar_modal' ),
                'id' => $prefix . 'opacity',
                'type' => 'slider',
    			'step' => 1,
    			'max' => 100,
                'std' => 80
            ),
    		array(
                'name' => __('Border Color', 'sugar_modal' ),
                'desc' => __('Choose your modal window border color', 'sugar_modal' ),
                'id' => $prefix . 'color',
                'type' => 'color',
    			'std' => '#adadad'
            ),
    		array(
                'name' => __('Border Width', 'sugar_modal' ),
                'desc' => __('Choose your border width', 'sugar_modal' ),
                'id' => $prefix . 'border_width',
                'type' => 'slider',
    			'max' => 20,
    			'step' => 1,
    			'std' => 8
            ),
    		array(
                'name' => __('Border Radius', 'sugar_modal' ),
                'desc' => __('Choose your border radius', 'sugar_modal' ),
                'id' => $prefix . 'border_radius',
                'type' => 'slider',
    			'max' => 20,
    			'step' => 1,
    			'std' => 8
            ),
    		array(
                'name' => __('Title Bar Color', 'sugar_modal' ),
                'desc' => __('Choose the background color for the title bar', 'sugar_modal' ),
                'id' => $prefix . 'title_color',
                'type' => 'color',
    			'std' => '#cccccc'
            ),
    		array(
                'name' => __('Title Text Color', 'sugar_modal' ),
                'desc' => __('Choose the text color for the title bar', 'sugar_modal' ),
                'id' => $prefix . 'title_text_color',
                'type' => 'color',
    			'std' => '#666666'
            ),
    		array(
                'name' => __('Content Color', 'sugar_modal' ),
                'desc' => __('Choose your content background color'), 'sugar_modal' ,
                'id' => $prefix . 'content_color',
                'type' => 'color',
    			'std' => '#fff'
            ),
    		array(
                'name' => __('Content Text Color', 'sugar_modal' ),
                'desc' => __('Choose your content text color', 'sugar_modal' ),
                'id' => $prefix . 'content_text_color',
                'type' => 'color',
    			'std' => '#333'
            )
        )
    );

    $smw_meta_boxes[] = array(
        'id' => 'modal-shortcode',
        'title' => __('Modal Window Short Code', 'sugar_modal' ),
        'pages' => array('modals'),
        'context' => 'normal',
        'priority' => 'high',
        'fields' => array(
    		array(
                'name' => __('Editor Button', 'sugar_modal' ),
                'desc' => __('A button has been placed in your Editor controls that will allow you to insert / configure the modal short code in any post or page</br>Look for this button: <img src="'. $smw_base_dir . 'includes/tinymce/includes/images/icon.png"/>', 'sugar_modal' ),
                'id' => $prefix . 'shortcode_info',
                'type' => 'plaintext',
            ),
    		array(
                'name' => __('Use This Short Code to Display Your Modal', 'sugar_modal' ),
                'desc' => __('[modal name="Replace with the Title of Your Modal"]Your Link Text[/modal]', 'sugar_modal' ),
                'id' => $prefix . 'shortcode_info',
                'type' => 'plaintext',
            ),
    		array(
                'name' => __('Additional Shortcode Parameters', 'sugar_modal' ),
                'desc' => 'style={plain,button}<br/>size={small,default,large}<br/>color={default,blue,red,green,purple,black}',
                'id' => $prefix . 'shortcode_info',
                'type' => 'plaintext',
            ),
    		array(
                'name' => __('Need more help?', 'sugar_modal' ),
                'desc' => __('The Help page has extensive explanations of how the short code works, it\'s options and more. Go to the <a href="' . get_bloginfo("wpurl") . '/wp-admin/admin.php?page=sugar-modal-windows/sugar-modal-windows.php">Help Page</a>', 'sugar_modal' ),
    			'id' => 'more_help',
                'type' => 'plaintext'
            )
        )
    );

    foreach ($smw_meta_boxes as $meta_box) {
        new smw_meta_box($meta_box);
    }
}
add_action( 'admin_init', 'smw_load_metaboxes' );