=== Lazy Load for Images ===
Contributors: jumedeenkhan
Donate link: https://www.paypal.me/jumedeenkhan
Tags: lazyload, lazy load, lazy load for images, image optimization, compress images
Requires at least: 4.7
Requires PHP: 7.4
Tested up to: 6.5.2
Stable tag: 1.5
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Lazy Load WordPress images with a small javascript. Load images only after scrolling down and when viewport and improve page speed and SEO rankings.


== Description ==
Lazy Load for Images plugin make lazy load WordPress Images with less then 2kb small pure javascript code, no need jQuerry.

It's help to increase performance of your website and make it fast loading and improve your website SEO rankins.

This plugin make lazy load of all type images like **thumbnail, post content images, avatars, gravatars, widget images .etc**.

All images load only when users scroll down and they are on viewport. It's SEO and user friendly, working well with all browsers.

This plugin is structured very simple and does not need any settings. Activate it, Done!

> #### Lazy Load for Images - Features & Advantages ####
>
> - Load images only when required.<br />
> - **Improve page loading speed.**<br />
> - Reduce no. of HTTP requests.<br />
> - Lazy load also working on mobiles.<br />
> - Plugin used pure JS, no need of jQuery.<br />
> - Plugin used less than **2kb** Javascript.<br />
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
2. Activate plugin, All Done!.
3. No need any manual configurations. Enjoy!


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


= How can I deactivate Lazy Load for some images? = 
You can use <em>no-lazyload</em> class in images.

= How can I deactivate Lazy Load on some pages? = 

You can use this filter to exclude lazy load images.

`
add_filter( 'lazy_load_for_images', '__return_false' );
`

If you want stop lazyload on special pages, use it.

`
add_action( 'init', 'deactivate_lazy_load_for_images' );
function deactivate_lazy_load_for_images() {
	if ( is_single() ) { // apply filter here
		add_filter( 'lazy_load_for_images', '__return_false' );
	}
}
`

= How do I lazy load other images in my theme? =
If lazy load not working for your theme, you can add a `add_filter` in plugin class PHP files at hooks section, i.e. like this:

`add_filter( 'post_thumbnail_html', array( __CLASS__, 'enable_lazy_load_for_images' ) );`


= How can I use custom placeholder image or GIF? =
By default, we use `"data:image/gif;base64"` or SVG for placeholder image. You can change via Plugin Code.


= Does this plugin work with any caching plugins? =
Yes, Lazy Load Images plugin work very well with every cache plugin.

== Upgrade Notice ==

= 1.5 =

* Tested for WordPress 6.5.2
* PHP Improvements for latest version.
* Javascript Improvement.
* Convert functions into class.
* Performance improvement.
* Fix image size for null sizes
* Change placeholder to SVG
* Some more improments, Enjoy!

== Changelog ==

= 1.5 =

* Tested for WordPress 6.5.2
* PHP Improvements for latest version.
* Javascript Improvement.
* Convert functions into class.
* Performance improvement.
* Fix image size for null sizes
* Change placeholder to SVG
* Some more improments, Enjoy!

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
