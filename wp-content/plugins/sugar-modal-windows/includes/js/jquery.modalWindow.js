(function($){

	$.fn.openModalWindow = function(href) {
		// data is the modal's content
		var data = $(href).html();
		boxInner.html(data);
	
		$(boxInner).css({
			width: settings.width+"px",
		});
		
		// this is to fix the bug where the height isn't calculated correctly on first load

		var boxOuterHeight = box.outerHeight();
		$(box).css({
			position: settings.position,
			left: ($(window).width() - box.outerWidth())/2,
			top: ($(window).height() - boxOuterHeight)/2
		});		
		
		if(settings.close != false) {
			box.append(close);
		}
		box.fadeTo(settings.speed, settings.trans).fadeIn(settings.speed);
		overlay.fadeTo(settings.speed, settings.opacity).fadeIn(settings.speed);
		
		setTimeout(function(){
			box.fadeIn(settings.speed);
		}, 500);
	
		
		box.find("#modalWindow-close").click(function(e){
			e.preventDefault();
			closeWindow();
		});	
		
	}

	$.fn.modalWindow = function(settings){
		
		var element = $(this);
		
		var defaultSettings = {			
			position	:	"fixed",
			width		:	600,
			trans		:	0.90,
			opacity		:	0.5,
			close		:	true,
			speed		:	600,
			className	:	'',
			borderWidth :	5
		};
		
		var settings = $.extend(defaultSettings, settings);
		
		var overlay = $('<div>', {
				'class': 'modalWindow-overlay'					
				});
		
		var box = $('<div>', {
				'class': 'modalWindow-box '+settings.className				
		});
		
		var boxInner = $('<div>', {
				'class': 'modalWindow-boxInner'					
		});
		
		var close = $('<a>', {
				'class': 'modalWindow-close'					
		});
	
		var loader = $('<div>', {
				'class': 'modalWindow-loader',
				html: 'Loading, please wait...'
		});
		
		$("body").append(overlay).append(box);
		$(box).append(boxInner);
		
		$(element).click(function(e){
			e.preventDefault();
			var href = $(this).attr("href");
			openWindow(href);
		});
		
		$('.modal-link').click(function(e){
			e.preventDefault();
			var href = $(this).attr("href");
			openWindow(href);
		});
		
		overlay.click(function(){							   
			closeWindow();			
		});
		
		close.click(function(){							   
			closeWindow();
		});
		
		function openWindow(href) {
		
			window.document.body.style.overflow = 'hidden';
		
			// data is the modal's content
			var data = $(href).html();
			boxInner.html(data);
		
			$(boxInner).css({
				width: settings.width+"px",
			});
			
			// this is to fix the bug where the height isn't calculated correctly on first load

			var boxOuterHeight = box.outerHeight();
			
			$(box).css({
				position: settings.position,
				left: ($(window).width() - box.outerWidth())/2,
				top: ($(window).height() - boxOuterHeight)/2
			});		
			
			if(settings.close != false) {
				box.append(close);
			}
			box.fadeTo(settings.speed, settings.trans).fadeIn(settings.speed);
			overlay.fadeTo(settings.speed, settings.opacity).fadeIn(settings.speed);
			
			setTimeout(function(){
				box.fadeIn(settings.speed);
			}, 500);
		
			box.find("#modalWindow-close").click(function(e){
				e.preventDefault();
				closeWindow();
			});		
		}
		
		function closeWindow(){
			window.document.body.style.overflow = 'scroll';
			
			//if(overlay.is(":animated") || box.is(":animated")){return false;}
			//box.fadeOut(settings.speed);
//			overlay.fadeOut(200);
            //var classBOX = box.attr('class');
            $(".modalWindow-box").each(function(){	
	            $(this).fadeOut(settings.speed);

            });
			$('.modalWindow-overlay').each(function(){
				$(this).fadeOut(200);
			});
		}

	}
	
})(jQuery);