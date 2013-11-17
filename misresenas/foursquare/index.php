<?php $json_content = file_get_contents("https://api.foursquare.com/v2/venues/4bf988f55317a5930473017f/tips?oauth_token=WFNLZUQILDD2XU3Z31OVIUJ5N3GAFTR4QO32SOFANUZUYFNW&v=20130705");
$jsonObj = json_decode($json_content); 
function getTitleMenu(){ echo "¡Mira nuestras reseñas! – foursquare"; }
function udesign_page_title(){ echo '<div id="page-content-title"> <div id="page-content-header" class="container_24"> <div id="page-title"> <h1 class="pagetitle">¡Mira nuestras reseñas! – foursquare</h1> </div> </div> </div> <div class="clear"></div>';  }
include("../../wp-load.php");
add_filter( 'wp_title', 'getTitleMenu', 10, 3 );
get_header(); ?>
<div class="container_24">
<div id="main-content" class="grid_24">

	<div class="grid_16 push_8">
		<div class="post" id="post-14">
		    <div class="entry">
		      <?php foreach($jsonObj->response->tips->items as $item): ?>
		         <div class="post hentry ivycat-post"> 
		           <div class="entry-summary">
		             <blockquote class="alignleft"><?php echo $item->text;?></blockquote>
		             		<p class="resenas"><b><?php echo $item->user->firstName. " " .$item->user->lastName; ?> </b><br> 
		             		<a href="https://foursquare.com/item/<?php echo $item->id; ?>" target="_blank" class="lnkResenas">Ver en foursquare</a>		</p>
		            </div>    
		         </div>
		         <div class="divider"></div>	
		      <?php endforeach; ?>
		    </div>
		</div><!-- end main-content-padding -->
	</div>

	<div id="sidebar" class="grid_8 pull_16 sidebar-box">
      <div id="sidebarSubnav">
        <div id="nav_menu-2" class="widget widget_nav_menu custom-formatting">
          <div class="menu-mnuresenas-container">
            <ul id="menu-mnuresenas" class="menu">
              <li id="menu-item-185" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-185"><a href="http://www.pozoleriacasalicha.com/mira-nuestras-resenas/mira-nuestras-resenas-tripadvisor/">tripadvisor</a></li>
              <li id="menu-item-278" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-278 current_page_item current-menu-item"><a href="/misresenas/foursquare/">foursquare</a></li>
              <li id="menu-item-189" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-189"><a href="http://www.pozoleriacasalicha.com/mira-nuestras-resenas/mira-nuestras-resenas-twitter/">twitter</a></li>
            </ul>
          </div>
        </div>
      </div>
	</div>		    

</div>
</div>
<?php get_footer();