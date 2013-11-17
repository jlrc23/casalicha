<?php

function smw_help_page() {
	global $smw_base_dir;
	?>
	<div class="wrap">
		<div id="smw-wrap" class="smw-help-page">
			<h2>Sugar Modal Windows Help</h2>
			<p>Index</p>
			<ul>
				<li><a href="#creating-modal-windows">Creating Modal Windows</a>
					<ul>
						<li><a href="#adding-modal-windows">Adding New Modal Windows</a></li>
						<li><a href="#configuring-modal-windows">Configuring Modal Windows</a></li>
					</ul>				
				</li>
				<li><a href="#showing-modal-windows">Showing Modal Windows</a>
					<ul>
						<li><a href="#tinymce-button">The Tiny MCE Button</a></li>
						<li><a href="#shortcode-parameters">The Short Code and Parameters</a></li>
						<li><a href="#custom-links">Opening a Modal with a Custom Link</a></li>
					</ul>				
				</li>
			</ul>
			
			<!------------------------
			end Index
			------------------------->
			
			<h3 id="creating-modal-windows">Creating Modal Windows</h3>
				<p id="adding-modal-windows" class="smw_title"><strong>Adding New / Editing Modal Windows</strong> - <a href="#smw-wrap">Back to Top</a></p>
				<div class="smw_section smw-clearfix">
					<img src="<?php echo $smw_base_dir; ?>includes/images/help-add-new.png" class="smw-right"/>
					<p>Adding new modal windows is very simple, just click "New Modal Window" under the "Modals" menu entry in the left navigation menu of the WordPress Dashboard.</p>
					<p>
					
					<p>Modal windows that you have created will show up in the "Modals" list just like other post types.</p>
					
					<p>Every modal window has 15 options that you may configure on a per-modal basis. These options are covered in the next section.</p>
					
					<p>Once Modals are created, they may be edited just like editing any other post or page. Just click on the title or the "Edit" link when hovering over the Modal you wish to edit in the Modal list</p>
				</div>
				
				<p id="configuring-modal-windows" class="smw_title"><strong>Configuring Modal Windows</strong> - <a href="#smw-wrap">Back to Top</a></p>
				<div class="smw_section">
					<p>Each Modal Window has 15 options that can be configured on a per-modal basis, meaning that every single modal can be completely unique and different from the next.</p>
					<ol>
						<li><strong>The Modal Title</strong> - This is the title of the modal window and it may be displayed by leaving the "Disable the title bar" option unchecked.</li>
						<li><strong>The Modal Content</strong> - This is the content that will be displaye when the modal window pops up. You may enter any kind of content here you wish, including texts, images, videos, short codes, and more.</li>
						<li><strong>Width</strong> - This option allows you to define the width of the modal popup window. Maximum width is 800px.</li>
						<li><strong>Auto Height</strong> - This option allows you to choose whether the window height should be calculated automatically, or set manually using the next option</li>
						<li><strong>Height</strong> - This option allows you to give a set height in pixels to your modal window. You want to use this option if your modal contains too much info to fit on the screen and you need a scroll bar.</li>
						<li><strong>Window Transparency</strong> - This option allows you to set how transparent the modal should be. Values range from 0, completely transparent, to 100, completely opaque.</li>
						<li><strong>Overlay Opacity</strong> - This option lets you set the level of opacity for the overlay. The overlay is the dark "mask" that will be displayed behind the modal window. It is designed to darken the site and bring focus to the window. Opacity can range from 0, invisible, to 100, solid black.</li>
						<li><strong>Speed</strong> - This option determines how quickly the modal window pops up when the link/button is clicked. The time is in milliseconds.</li>
						<li><strong>Border Color</strong> - With this is the color of the window border. Enter the hex code for your desired color, or click "Select a color" and choose with the color picker.</li>
						<li><strong>Border Width</strong> - This is the width of the modal window border in pixels. Setting this option to 0 disables the border. Maximum width is 20px.</li>
						<li><strong>Border Radius</strong> - This is the "roundness" of the modal window border corners. <em>Note</em>, rounded corners will only be shown to users browsing on a modern browser. Internet Explorer users will not see rounded corners.</li>
						<li><strong>Disable the Title Bar</strong> - This option will allow you to disable the title bar. If this box is checked, neither the title bar nor the title will be displayed.</li>
						<li><strong>Title Bar Color</strong> - With this option you can choose the background color of the title bar. Enter the hex code for your desired color, or click "Select a color" and choose with the color picker.</li>
						<li><strong>Title Text Color</strong> - Here you can define the text color for the title bar. Enter the hex code for your desired color, or click "Select a color" and choose with the color picker.</li>
						<li><strong>Content Background Color</strong> - This is the backround color that will be used for the modal window content area. Enter the hex code for your desired color, or click "Select a color" and choose with the color picker.</li>
						<li><strong>Content Text Color</strong> - This option defines the text color for the modal window content. Enter the hex code for your desired color, or click "Select a color" and choose with the color picker.</li>
						<li><strong>Disable the Close Button</strong>By default, each modal window will have a red X icon in the top right that can be clicked to close the modal window. By check this box, the X button will not be displayed.</li>
					</ol>					
				</div>
				

			<h3 id="showing-modal-windows">Showing Modal Windows</h3>
				
				<div class="smw_section">
					<p>Modal Windows can be inserted into any post, page, or custom post type using the provided short code. Short codes can be inserted manually or with the TinyMCE button that has been added to your editor's tool bar.</p>
					
					<p>The necessary short code and all of its parameters can be seen on the Edit Modal Window screen, just below the main content section.</p>
				</div>
				<p id="tinymce-button" class="smw_title"><strong>The Tiny MCE Button</strong> - <a href="#smw-wrap">Back to Top</a></p>
				<div class="smw_section">
					<p>When inserting a Modal Window into a post, page, or custom post type, look for this button in the editor's tool bar: <img src="<?php echo $smw_base_dir; ?>includes/images/icon.png" style="position: relative; top: 6px; margin-top: -6px;"/></p>
					
					<p>Once you click on the Insert Modal button, a small popup will appear with several options:</p>
					
					<ul>
						<li><strong>Link Text</strong> - This is the text that will be made into a clickable link, which will open the specified modal.</li>
						<li><strong>Choose Modal</strong> - Choose the modal you wish to insert from the drop down list.</li>
						<li><strong>Style</strong> - Modal links may be inserted as either a button or plain text. Choose the style you wish to use.</li>
						<li><strong>Button Size</strong> - If you've chosen the Button style, then select the size of button you'd like to show.</li>
						<li><strong>Button Color</strong> - If you've chose the Button style, then select the color of button you'd like to show.</li>
					</ul>
					
					<p>After you have selected each of your "Insert Modal" options, click the "Insert" button to generate the short code. It will be placed into the content of your post, page, or custom post type.</p>
				</div>
				
				<p id="shortcode-parameters" class="smw_title"><strong>The Short Code and Parameters</strong> - <a href="#smw-wrap">Back to Top</a></p>
				<div class="smw_section">
					<p>Modal Windows are inserted into posts, pages, and custom post types using a short code.</p>
					<p>The short code is: <strong>[modal <em>parameters</em>]Link Text[/modal]</strong></p>
					<p>The parameters are:</p>
					<ul>
						<li>name={name of your modal window} <em>required</em> - Enter the value of the Title field</li>
						<li>style={plain,button} - This is the style of link to show</li>
						<li>size={small,default,large} - If using a button style, the size of the button</li>
						<li>color={default,blue,red,green,purple,black} - If using a button style, the color of the button</li>
					</ul>
				
					<p>The <em>name</em> parameter is the only required option. The value you enter here must match the value of the Modal's Title field exactly. Do <em>not</em> use the modal's slug.</p>
					
					<p><strong>Example shortcode</strong> - This is what yout short code might look like:</p>
					
					<p><em>[modal name="My Modal Window Title" style=button color=purple size=large]Open Modal[/modal]</em></p>
					
					<p><em>Note</em>, quotes are required around the title value, but not the other parameters.</p>
					
				</div>
				
				<p id="custom-links" class="smw_title"><strong>Opening a Modal with a Custom Link</strong> - <a href="#smw-wrap">Back to Top</a></p>
				<div class="smw_section">
					<p>At times, you may wish to provide an extra link that can be used to open a modal window. To do this:</p>
					<ol>
						<li>Insert the modal like normal with the short code</li>
						<li>Add a link anywhere in your post/page content with the following structure:<br/>
						<strong>&lt;a href="#your-modal-slug" class="modal-link"&gt;Link Text&lt;a&gt;</strong>
					</ol>
					<p>If you need help finding the slug of your modal window, look at the link created by the short code. The HREF attributes need to be identical.</p>
				</div>
				
		</div><!--end smw-wrap-->
	<div><!--end wrap-->
	<?php

}

?>