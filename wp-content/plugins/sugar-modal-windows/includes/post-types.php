<?php
/******************************
create the Modal Window post type
*******************************/

function smw_create_post_type() {
	global $smw_base_dir;
	
	$labels = array(
		'name' => _x( 'Modals', 'post type general name', 'sugar_modal'  ), // Tip: _x('') is used for localization
		'singular_name' => _x( 'Modal Window', 'post type singular name', 'sugar_modal'  ),
		'add_new' => _x( 'New Modal Window', 'Modal', 'sugar_modal'  ),
		'add_new_item' => __( 'Add New Modal Window', 'sugar_modal'  ),
		'edit_item' => __( 'Edit Modal Window', 'sugar_modal'  ),
		'new_item' => __( 'New Modal Window', 'sugar_modal'  ),
		'view_item' => null,
		'search_items' => __( 'Search Modal Windows', 'sugar_modal'  ),
		'not_found' =>  __( 'No Modal Windows found', 'sugar_modal'  ),
		'not_found_in_trash' => __( 'No Modal Windows found in Trash', 'sugar_modal'  ),
		'parent_item_colon' => ''
	);

 	$modal_args = array(
     	'labels' => $labels,
     	'singular_label' => __('Modal Window', 'sugar_modal' ),
     	'public' => true,
		'publicly_queryable' => true,
     	'show_ui' => true,
	  	'capability_type' => 'post',
     	'hierarchical' => false,
     	'rewrite' => false,
     	'has_archive' => false,
     	'supports' => array('title', 'editor', 'revisions'),
		'menu_position' => 100,
		'show_in_nav_menus' => false,
		'menu_icon' => $smw_base_dir . 'includes/images/icon.png'
     );
 	register_post_type('modals', $modal_args);
}
add_action('init', 'smw_create_post_type');

//modify column content

add_action("manage_posts_custom_column",  "modal_show_column");
add_filter("manage_edit-modals_columns", "modal_content_column");

function modal_content_column($columns){
  $columns = array(
    "cb" => "<input type=\"checkbox\" />",
    "title" => "Title",
    "modal_excerpt" => "Excerpt",
    "modal_shortcode" => "Short Code",
    "date" => "Date",
  );

  return $columns;
}

function modal_show_column($column){
  global $post;

  switch ($column) {
    case "modal_excerpt":
		$content_excerpt = $post->post_excerpt;
		if($content_excerpt == '') {
			$content_excerpt = $post->post_content;
		}
		$content_excerpt = strip_tags(stripslashes($content_excerpt), '<a><em><strong>');
		$excerpt_length = 20;
		$content_excerpt = preg_split('/\b/', $content_excerpt, $excerpt_length*2+1);
		$body_excerpt_waste = array_pop($content_excerpt);
		$content_excerpt = implode($content_excerpt);
		$content_excerpt .= '...';
		echo apply_filters('the_content',$content_excerpt);
											
    break;
	  
	case "modal_shortcode":
		echo '[modal id="' . absint( $post->ID ) . '"]Link Text[/modal]';
	break;
  }
}

