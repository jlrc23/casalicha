<?php 
include("../wp-load.php");
$page =  get_page( 288 ); 
function getTitleMenu(){ global $page; echo $page->post_title; }
function udesign_page_title() {  global $page;  echo "<div id='page-content-title'> <div id='page-content-header' class='container_24'> <div id='page-title'> <h1 class='pagetitle'> $page->post_title; </h1></div></div></div><div class='clear'></div>"; }
//function getImages($idGallery){  echo do_shortcode("[nggallery id=$idGallery]"); }
wp_enqueue_script('jquery');
wp_register_script('menuJSCRIPT','/js/menu.js');
wp_enqueue_script('menuJSCRIPT'); 
wp_register_style('menuStyle','/css/menu.css');
wp_enqueue_style('menuStyle');
add_filter( 'wp_title', 'getTitleMenu', 10, 3 );
get_header(); ?>
<div class="container_24">
<div id="main-content" class="grid_24">
	<div class="main-content-padding">
		<div class="post" id="post-14">
		    <div class="entry">  		    
		        <?php echo get_the_content(); //get_the_content("¡Tenemos un delicioso menú para ti!"); // echo $page->post_content; ?> 
		    </div>
		</div>
	</div>
	    <div class="clear"></div>

</div><!-- end main-content-padding -->
</div>
<?php get_footer();