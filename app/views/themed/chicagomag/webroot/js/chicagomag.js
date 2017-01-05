function fixie(fixedID,wrapperID) {
	// Let's make the navigation persist.
	var fixed = $(fixedID); // The element we want to stick to the top
	var wrapper = $(wrapperID); // A reference point


	
	$(window).scroll(function() { 

		var wposition = wrapper.position();
		var trigger = wposition.top + wrapper.height() - fixed.height();
		var position = $(window).scrollTop();

		if (position > trigger) { // If the user has scrolled up, lock the nav to the top of the screen.
			$(fixedID).css('position','fixed');
			$(fixedID).css('left', wposition.left);
			$(fixedID).css('top', 0);
		}

		else { // If some of the header shows, let the nav align with the content box, as normal
			$(fixedID).css('position','relative');
			$(fixedID).css('left', 0);
			$(fixedID).css('top',0);

		}
	});

	$(window).resize(function() { // In case the window gets resized
		var trigger = wposition.top + wrapper.height() - fixed.height();
		var wposition = wrapper.position();
		var position = $(window).scrollTop();
		if (position > trigger){
			$(fixedID).css('left', wposition.left+1);
		}
		else {
			$(fixedID).css('left', 0);
		}
		});

}