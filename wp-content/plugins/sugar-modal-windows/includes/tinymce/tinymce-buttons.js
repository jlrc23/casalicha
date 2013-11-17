(function() {
	tinymce.create('tinymce.plugins.modalPlugin', {
		init : function(ed, url) {
			// Register commands
			ed.addCommand('modalbutton', function() {
				ed.windowManager.open({
					file : url + '/button_popup.php', // file that contains HTML for our modal window
					width : 300 + parseInt(ed.getLang('button.delta_width', 0)), // size of our window
					height : 210 + parseInt(ed.getLang('button.delta_height', 0)), // size of our window
					inline : 1
				}, {
					plugin_url : url
				});
			});
			 
			// Register buttons
			ed.addButton('modal_button', {title : 'Insert Modal', cmd : 'modalbutton', image: url + '/includes/images/icon.png' });
		},
		 
		getInfo : function() {
			return {
				longname : 'Insert Modal',
				author : 'Pippin Williamson',
				authorurl : 'http://pippinsplugins.com',
				infourl : 'http://pippinsplugins.com',
				version : tinymce.majorVersion + "." + tinymce.minorVersion
			};
		}
	});
	 
	// Register plugin
	// first parameter is the button ID and must match ID elsewhere
	// second parameter must match the first parameter of the tinymce.create() function above
	tinymce.PluginManager.add('modal_button', tinymce.plugins.modalPlugin);

})();