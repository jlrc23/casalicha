<!-- NOTE: If you need to make changes to this file, copy it to your current theme's main
	directory so your changes won't be overwritten when the plugin is upgraded. -->

<!-- Start of Post Wrap -->
<div class="post hentry ivycat-post">

	<!-- This is the output of the EXCERPT -->
	<div class="entry-summary">
		<?php the_content(); //the_excerpt(); ?>
		<p class="resenas"><b><?php the_title();?></b><br>
		
		<?php  
  $custom_fields = get_post_custom(get_the_ID());
  if(isset($custom_fields['Fuente'][0]) && !empty($custom_fields['Fuente'][0])){
     if(preg_match("/foursquare.com/", $custom_fields['Fuente'][0]))
    	 echo "<a href='" .$custom_fields['Fuente'][0]. "' target='_blank' class='lnkResenas'>Ver en foursquare</a>";
  }
     
?>
		</p>
	</div>
    

<?php

/*  $mykey_values = get_post_custom_values(get_the_ID());
  foreach ( $mykey_values as $key => $value ) {
    echo "$key  => $value ('my_key')<br />"; 
  }*/

?>
	<!-- This is the output of the META information 
	 <div class="entry-utility">
		<?php if ( count( get_the_category() ) ) : ?>
			<span class="cat-links">
				<?php printf( __( '<span class="%1$s">Posted in</span> %2$s', 'twentyten' ), 'entry-utility-prep entry-utility-prep-cat-links', get_the_category_list( ', ' ) ); ?>
			</span>
			<span class="meta-sep">|</span>
		<?php endif; ?>
		<?php
			$tags_list = get_the_tag_list( '', ', ' );
			if ( $tags_list ):
		?>
			<span class="tag-links">
				<?php printf( __( '<span class="%1$s">Tagged</span> %2$s', 'twentyten' ), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list ); ?>
			</span>
			<span class="meta-sep">|</span>
		<?php endif; ?>
		<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'twentyten' ), __( '1 Comment', 'twentyten' ), __( '% Comments', 'twentyten' ) ); ?></span>
		<?php edit_post_link( __( 'Edit', 'twentyten' ), '<span class="meta-sep">|</span> <span class="edit-link">', '</span>' ); ?>
	</div> -->
</div>
<div class="divider"></div>	
<!-- // End of Post Wrap -->
