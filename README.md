# Smart LazyLoad – Lazy Load Images, Videos and Iframes  #

The best free, lightweight lazy load plugin for WordPress. Lazy loading images, videos, and iframes to improve performance and Core Web Vitals scores.

##  Description 

**Smart LazyLoad** is a fast, lightweight, and SEO-friendly lazy loading plugin for WordPress. It improves page speed and Core Web Vitals by loading images, iframes, videos, and background images **only when they are about to enter the viewport**.

Built with **pure JavaScript**, Smart Lazy Load does not rely on jQuery or other third-party libraries, keeping your site fast and bloat-free.

Unlike heavy optimization plugins, Smart LazyLoad focuses on one thing only: **reducing unnecessary resource loading while maintaining compatibility, accessibility, and SEO best practices.**

All features are optional — you can use the plugin with default settings or fine-tune it as needed.

## Features

* Lazy load images in posts, pages, widgets, thumbnails, avatars, and comments
* Lazy load iframes and embedded videos
* Lazy load background images from inline styles and data attributes
* Optional YouTube iframe replacement with video thumbnails
* Intelligent first-image skipping for better LCP scores
* Supports both JavaScript-based and native browser lazy loading
* Inline plugin CSS and JavaScript (optional)
* Option to disable lazy loading for logged-in users
* Fully responsive and mobile-friendly
* SEO-friendly with noscript fallbacks
* Accessibility-aware
* Pure JavaScript (no jQuery dependency)
* Lightweight and performance-focused
* Open source and available on [GitHub](https://github.com/jumedeenkhan/lazy-load-for-images)


## Installation

**Automatic Installation**

1. Open your WordPress site dashboard
2. Go to **Plugins → Add New** in your WordPress admin
3. Search for **Smart LazyLoad**
4. Click **Install Now**, then **Activate**

**Manual Installation**

1. Download the plugin ZIP file
2. Upload it to WP `/wp-content/plugins/`
3. Activate the plugin from **Plugins → Installed Plugins**
4. Go to the plugin **setting page** and enable lazy load
5. Now, lazy loading starts working automatically

## Configuration

You can configure the plugin from:

**Settings → LazyLoad**

Available options include:

* Enable or disable lazy loading
* Lazy load images, iframes, and videos
* Enable background image lazy loading
* Replace YouTube videos with thumbnails
* Adjust lazy load threshold
* Enable native browser lazy loading
* Inline plugin CSS and JavaScript
* Disable lazy loading for logged-in users

**Need more help?**

For detailed documentation, usage examples, available filters, and advanced configuration options for Smart LazyLoad are available.

See the [Lazy Load Configuration Guide](https://www.mozedia.com/lazy-load-wordpress/)

**Support**

We are here to help. Feel free to open a new thread on the [Support Forum](https://wordpress.org/support/plugin/lazy-load-for-images/).

## Frequently Asked Questions

**Does Smart LazyLoad lazy load all images?**

Yes. It supports lazy loading for:

* Post and page content images
* Featured images
* Widget images
* Avatars and comments
* Background images

You can control what is lazy loaded from the settings page.

**How can I exclude a specific image or iframe?**

Add one of the following attributes or classes to the element:

* `no-lazyload`
* `skip-lazy`
* `data-no-lazy`
* `data-skip-lazy`

You can also use filters:

* `mozedia_lazyload_excluded_attributes`
* `mozedia_lazyload_iframe_excluded_patterns`

**Can I disable lazy loading on specific pages?**

Yes. Use the following filter:

````
add_filter( 'do_mozedia_lazyload', '__return_false' );
````

Or conditionally disable it:

````
add_action( 'wp', 'disable_mozedia_lazyload' );
function disable_mozedia_lazyload() {
	if ( is_single() ) {
		add_filter( 'do_mozedia_lazyload', '__return_false' );
	}
}
````

**Is Smart LazyLoad compatible with caching and optimization plugins?**

Yes. It works well with most caching, CDN, and optimization plugins.

**Is this plugin SEO-friendly?**

Yes. Smart LazyLoad preserves original content using noscript fallbacks, supports native lazy loading, and allows skipping the first image for better LCP performance.

**Does it support background images?**

Yes. Smart LazyLoad can automatically lazy-load background images defined via the style attribute, such as:

````
<div style="background-image: url(image-slug.jpg);">
````

You can also apply it manually yourself.

Simply add this special markup to the element on which you want to apply lazy loading:

````
<div class="mozedia-lazyload" data-bg="url(../img/image-slug.jpg)"></div>
````

**Can I use a custom placeholder image or GIF?**

Yes. Change the SVG placeholder using this filter:

````
add_filter( 'mozedia_svg_placeholder', 'mozedia_replace_image_placeholder');
function mozedia_replace_image_placeholder() {
	return 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1 1"></svg>';
}
````

Lazy loaded iframes use a separate placeholder value (default: `about:blank`).

You can customize the iframe placeholder using the following filter:

````
add_filter( 'mozedia_lazyload_placeholder', function () {
	return 'about:blank';
});
````

## What should I do if the plugin is not working?

If Smart LazyLoad plugin is not working as expected, please check the following:

- Make sure the plugin is enabled
- Clear browser, plugin, and CDN caches
- Check if lazy loading is disabled for logged-in users
- Disable other lazy load plugins to avoid conflicts
- Ensure elements are not excluded using no-lazy attributes
- View the page on the frontend (not page builder editor)

If the issue persists, feel free to [contact us](https://www.mozedia.com/contact/)
