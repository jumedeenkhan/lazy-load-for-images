<?php

/**
 * Plugin Name: Lazy Load for Images
 * Plugin URI:  https://www.mozedia.com/lazy-load-images-in-wordpress/
 * Description: Lazyload wordpress images with a small javascript without jQuery or others libraries.
 * Author:      Jumedeen khan
 * Author URI:  https://www.mozedia.com/
 * Text Domain: lazy-load-for-images
 * Version:     1.4.2
 *
 */

//* Add filter to replace gravatar, post content and widget images
add_filter( 'get_avatar', 'mozedia_lazyload_images', PHP_INT_MAX );
add_filter( 'the_content', 'mozedia_lazyload_images', PHP_INT_MAX );
add_filter( 'widget_text', 'mozedia_lazyload_images', PHP_INT_MAX );
add_filter( 'post_thumbnail_html', 'mozedia_lazyload_images', PHP_INT_MAX );

//* Also support genesis thumbnails (if is available)
add_filter( 'genesis_get_image', 'mozedia_lazyload_images', PHP_INT_MAX );

//* start function for lazy load images
function mozedia_lazyload_images( $html ) {
	// Don't LazyLoad if the thumbnail is in
	if( is_admin() || is_feed() || is_preview() || empty( $html ) ) {
		return $html;
	}

	// Stop LalyLoad process with this hook
	if ( ! apply_filters( 'do_not_lazyload', true ) ) {
		return $html;
	}

	$html = preg_replace_callback( '#<img([^>]*) src=("(?:[^"]+)"|\'(?:[^\']+)\'|(?:[^ >]+))([^>]*)>#', '__mozedia_lazyload_replace_callback', $html );

	return $html;
}


//* Used to check if LazyLoad this or not
function __mozedia_lazyload_replace_callback( $matches ) {
	if ( strpos( $matches[1] . $matches[3], 'data-no-lazy=' ) === false && strpos( $matches[1] . $matches[3], 'data-src=' ) === false && strpos( $matches[2], '/wpcf7_captcha/' ) === false ) {
		$html = sprintf( '<img%1$s src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src=%2$s%3$s><noscript><img%1$s src=%2$s%3$s></noscript>',
						$matches[1], $matches[2], $matches[3] );

		//* Filter the LazyLoad HTML output
		$html = apply_filters( 'mozedia_lazyload_html', $html, true );

		return $html;
	} else {
		return $matches[0];
	}
}

// Add lazy load script in footer inline HTML
add_action( 'wp_footer', 'mozedia_lazyload_script', PHP_INT_MAX );
function mozedia_lazyload_script() {
	if ( ! apply_filters( 'do_not_lazyload', true ) ) {
		return;
	}

	echo '<script type="text/javascript">(function(a,e){function f(){var d=0;if(e.body&&e.body.offsetWidth){d=e.body.offsetHeight}if(e.compatMode=="CSS1Compat"&&e.documentElement&&e.documentElement.offsetWidth){d=e.documentElement.offsetHeight}if(a.innerWidth&&a.innerHeight){d=a.innerHeight}return d}function b(g){var d=ot=0;if(g.offsetParent){do{d+=g.offsetLeft;ot+=g.offsetTop}while(g=g.offsetParent)}return{left:d,top:ot}}function c(){var l=e.querySelectorAll("[data-src]");var j=a.pageYOffset||e.documentElement.scrollTop||e.body.scrollTop;var d=f();for(var k=0;k<l.length;k++){var h=l[k];var g=b(h).top;if(g<(d+j)){h.src=h.getAttribute("data-src");h.removeAttribute("data-src")}}}if(a.addEventListener){a.addEventListener("DOMContentLoaded",c,false);a.addEventListener("scroll",c,false)}else{a.attachEvent("onload",c);a.attachEvent("onscroll",c)}})(window,document);</script>';
}
