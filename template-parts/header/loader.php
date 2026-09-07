<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
	<div id="preloader"></div>
	<div class="up">
		<a href="#" class="scrollup text-center"><i class="fas fa-chevron-up"></i></a>
	</div>
	<script>
	// Plain JS, deliberately not part of any enqueued file: JS-delay/optimization
	// plugins (e.g. 10Web Speed Optimizer's "Delay JavaScript Execution") postpone
	// external scripts — including jQuery — until the visitor interacts with the
	// page, which can leave this fullscreen loader stuck forever if it depends on
	// jQuery/window-load in script.js. This inline block runs immediately and
	// removes the loader itself, independent of that optimization.
	(function(){
		var hide = function(){
			var el = document.getElementById('preloader');
			if ( ! el ) return;
			el.style.transition = 'opacity 400ms ease';
			el.style.opacity = '0';
			setTimeout( function(){ if ( el.parentNode ) el.parentNode.removeChild( el ); }, 400 );
		};
		window.addEventListener( 'load', hide );
		setTimeout( hide, 4000 );
	})();
	</script>
