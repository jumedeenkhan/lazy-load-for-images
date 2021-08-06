=== Lazy Load for Images ===
Contributors: jumedeenkhan, mozedia
Donate link: https://www.paypal.me/jumedeenkhan
Tags: lazyload, lazy load, images, thumbnail, thumbnails, avatar, gravatar, performance, photos, lazy load for images
Requires at least: 4.7
Tested up to: 5.8
Requires PHP: 5.6
Stable tag: 1.4.2

Lazy Load WordPress images with a small javascript. Load images only after scrolling down and when viewport and improve page speed.


== Description ==
Lazyload WordPress Images without any manual configurations and helps increasing performance of your blog or website.

This plugin make lazy load of all images **(like thumbnails, post content images, avatars, gravatars, widget images etc.)**.

All images load only when users scroll down and they are on viewport. It's SEO and user friendly, working well with all browsers.

This plugin is structured very simple and does not need any settings. Activate, Done! Plugin use less than 1kb JavaScript. no need of jQuery.

> #### Lazy Load for Images - Features & Advantages ####
>
> - Load images only when required.<br />
> - **Improve page loading speed.**<br />
> - Reduce no. of HTTP requests.<br />
> - Lazy load also working on mobiles.<br />
> - Plugin used pure JS, no need of jQuery.<br />
> - Plugin used less than **1kb** Javascript.<br />
> - Also support **Gravatar**.<br />
> - Also support **Genesis Framework**.<br />
> - SEO friendly (search engine optimized).<br />
> - Worked great with genesis framework.<br />
> - No need configurations (Just activate it, It's Done!)<br />
> - Of course, available on [GitHub](https://github.com/jumedeenkhan/lazy-load-for-images)<br />

Simply install the plugin to enjoy a faster website. No options are available : you install it and the plugin takes care of everything.


== Installation ==

= Installing this plugin - Simple =
1. In your WordPress admin panel, go to *Plugins > New Plugin*, search for **Lazy Load for Images** and click "*Install now*"
2. Otherwise, download plugin and upload to your plugins directory, which usually is `/wp-content/plugins/`.
3. Activate plugin, All Done!.


= Need more help? =
Feel free to [open a support ticket](https://wordpress.org/support/plugin/lazy-load-for-images/).


= Missing something? =
If you would like to have an additional feature for this plugin, [let me know](https://www.mozedia.com/contact/)


== Frequently Asked Questions ==
= Does this plugin lazy load all images on a post? =
Yes, All images that uploaded via you media library loaded with lazy load, with featured images.

and this plugin also support Genesis Framework speciailly.


= How can I deactivate Lazy Load on some images? =
Simply add a `data-no-lazy="1"` attribute tag in your specific image.


= How can i deactivate Lazy Load on some pages? = 

You can use <em>do_not_lazyload</em> filter.

Here, an example to put in functions.php files:
`
add_action( 'wp', 'deactivate_lli_lazyload_on_single' );
function deactivate_lli_lazyload_on_single() {
	if ( is_single() ) {
		add_filter( 'do_not_lazyload', '__return_false' );
	}
}
`

= How do I lazy load other images in my theme? =
If lazy load not working for your theme, you can add a `add_filter` in plugin class PHP files at hooks section, i.e. like this:

`add_filter( 'post_thumbnail_html', array( __CLASS__, 'lli_lazyload_images' ) );`


= How can I use custom placeholder image or GIF? =
By default, we use `"data:image/gif;base64"` for placeholder image. You can change it url with custom URL.


= Does this plugin work with any caching plugins? =
Yes, Lazy Load Images plugin work very well with every cache plugin.

== Upgrade Notice ==

= 1.4.2 =

* Tested for WordPress 5.8
* PHP Improvements.
* Plugin author and URL changed.

== Changelog ==

= 1.4.2 =

* Tested for WordPress 5.8
* PHP Improvements.
* Plugin author and URL changed.

= 1.4.0 =

* Upgrade for latest version.
* JavaScript improvements.
* Add genesis framework support.
* Delete unused javascrit liberaries.
* Added hooks for stop lazy load images.
* plugin php code replaced with new php.

= 1.3.4 =

* Fixed some buges.

= 1.3.3 =

* Ignore AMP Pages.

= 1.3.0 =

* Upgraded for version 5.3.

= 1.2.0 =

* Placeholder image changed.
* Improve PHP.
* Lazy load script improvement.

= 1.0.0 =

* First version.
