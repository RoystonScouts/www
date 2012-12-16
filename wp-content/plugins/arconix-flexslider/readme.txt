=== Arconix Flexslider ===
Contributors: jgardner03
Donate link: http://arcnx.co/acfsdonation
Tags: arconix, flexslider, slider
Requires at least: 3.4
Tested up to: 3.4.2
Stable tag: 0.5.3

A multi-purpose responsive jQuery slider that supports custom post types and responsive themes.

== Description ==

Arconix Flexslider is a plugin that utilizes the excellent, responsive FlexSlider jQuery plugin. This plugin supports a user-selected post types in addition to posts and pages on a per-widget basis, which is perfect for featured posts or recent portfolio items on the homepage. It can be called by placing the widget in a widget area or by using the shortcode `[ac-flexslider]`

= Features =
* Resizes based on the user's device
* Supports built-in and user-created post-types and image sizes for maximum flexibility

== Installation ==

You can download and install Arconix FlexSlider using the built in WordPress plugin installer. If you download the plugin manually, make sure the files are uploaded to `/wp-content/plugins/arconix-flexslider/`.

Activate Arconix-FlexSlider in the "Plugins" admin panel using the "Activate" link.

== Upgrade Notice ==

Upgrade normally via your WordPress admin -> Plugins panel.

== Frequently Asked Questions ==

= How do I use the slider?  =

* Place the Arconix - Flexslider widget in the desired widget area
* Use the shortcode `[ac-flexslider]` on a post, page or other area
* Place `<?php echo do_shortcode( "[ac-flexslider post-type='post']" ); ?>` in the desired page template

= Is there any other documentation? =
* Visit the plugin's [Wiki Page](http://arcnx.co/afswiki) for all the plugin's documentation
* Tutorials on advanced plugin usage can be found at [Arconix Computers](http://arconixpc.com/tag/arconix-flexslider)

= The slider isn't styled properly =
* With no 2 themes exactly alike, it's extremely difficult to style a plugin that seamlessly integrates without issue. That's why I made the plugin flexible -- If you'd like tighter integration between your theme and the flexslider, copy `includes/flexslider.css` to the root of your theme's folder and rename it to `arconix-flexslider.css`. My plugin will try to load that file first, which means you can make your changes and not risk losing them on a plugin upgrade.

= What is responsive design? =
Responsive design is in essence designing a website to cater to the dimensions of the user's device. It has become very popular with the proliferation of web-enabled smartphones and tablets.

= Do I need a responsive theme to use this plugin? =
Absolutely not. The slider will conform to the dimensions provided to it

= I need help, or I found a bug =

* Check out the WordPress [support forum](http://arcnx.co/afshelp) or the [Issues section on Github](http://arcnx.co/afsissues)

= I have a great idea for your plugin! =

That's fantastic! Feel free to submit a pull request over at [Github](http://arcnx.co/afssource), or you can contact me through [Twitter](http://arcnx.co/twitter), [Facebook](http://arcnx.co/facebook) or my [Website](http://arcnx.co/1).

== Screenshots ==
1. Widget Options overview
2. Standard and user-created post-type selection box
3. Builtin and user-added image sizes

== Changelog ==

= 0.5.3 =
* Fixed a bug in the widget update function
* Fixed a bug which was preventing category and tag filters from firing properly.

= 0.5.2 =
* Fixed an error with the Widget Title that was preventing it from saving
* Reworked some function names to minimize potential conflicts with other plugins

= 0.5.1 =
* Added a filter to the flexslider script registration, allowing the use of a different flexslider script than what's supplied in the plugin

= 0.5 =
* Added ability to call the slider from a shortcode
* Added the ability to display the chosen post-type's content (either in whole or just the excerpt)
* Added the option to display just the images without link tags (making the images un-clickable)
* Added the ability to display specific categories or tags (works with 'posts' only)

= 0.2.1 =
* fixed ie8 image scale issue

= 0.2 =
* Added additional options for image captions
* Only return posts to display if they have featured images

= 0.1 =
* Initial release