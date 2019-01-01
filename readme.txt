=== Lazy Load for Images ===
Contributors:      jumedeenkhan
Donate link:       https://www.paypal.me/iamjdk
Tags:              lazy, load, images, lazy load for images, lazyload, loading, performance
Requires at least: 4.0
Tested up to:      5.0
Requires PHP:      5.6
Stable tag:        1.0.4
License:           GPLv2 or later
License URI:       https://www.gnu.org/licenses/gpl-2.0.html

Lazy Load WordPress images. Load images only after scrolling down and when viewport and improve page speed.


== Description ==
Lazy load WordPress Images without any configurations and helps increasing performance of your blog or website.

All images load only when users scroll down and they are on viewport. It's SEO and user friendly, working well with all browsers.

This plugin is structured very simple and does not need any settings. Activate, Done! Plugin use less than 1kb JavaScript. no need of jQuery.

== Exclude images ==
Yes, you can exclude some images to lazy loading. This can be done by adding `data-lazy="1"` attribute to images that should not be lazy loaded.


> #### Lazy Load for Images - Features & Advantages
>
> - Load images only when required.<br />
> - **Improve page loading speed.**<br />
> - Reduce no. of HTTP requests.<br />
> - Lazy load also working on mobiles.<br />
> - Plugin used only 506 bytes Javascript.<br />
> - Plugin total size is less than **10kb**.<br />
> - No need configurations (Just activate, It's Done!)<br />
> - SEO friendly (search engine optimized).<br />
> - Of course, available on [GitHub](https://github.com/jumedeenkhan/lazy-load-for-images)<br />


== Installation ==


= Installing this plugin - Simple =
1. In your WordPress admin panel, go to *Plugins > New Plugin*, search for **Lazy Load for Images** and click "*Install now*"
2. Otherwise, download plugin and upload to your plugins directory, which usually is `/wp-content/plugins/`.
3. Activate plugin, All Done!.


= Need more help? =
Feel free to [open a support ticket](https://wordpress.org/support/plugin/lazy-load-for-images/).


= Missing something? =
If you would like to have an additional feature for this plugin, [let me know](https://www.supportmeindia.com/contact/)


== Frequently Asked Questions ==
= Does this plugin lazy load all images on a post? =
Yes, All images that uploaded via you media library loaded with lazy load, with featured images.

= How do I lazy load other images in my theme? =
If lazy load not working, you will need to add a `add_filter` in plugin class PHP files at hooks section, i.e. like this:

`add_filter( 'post_thumbnail_html', array( __CLASS__, 'lli_images' ) );`


= How can I use custom placeholder image or GIF? =
By default, we use `"data:image/gif;base64"` for placeholder image. You can change it url with custom URL.


= How can I deactivate Lazy Load on some images? =
Simply add a `data-lazy="1"` attribute tag in your specific image.


= Does this plugin work with any caching plugins? =
Yes, Lazy Load Images plugin work very well with every cache plugin.


== Changelog ==
= 1.0 =
* First version.
