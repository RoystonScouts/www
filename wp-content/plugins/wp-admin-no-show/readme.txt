=== WP Admin No Show ===
Contributors: scriptrunner
Donate link: http://www.dougsparling.org/
Tags: admin bar, admin menu, dashboard, disable, remove, hide
Requires at least: 3.1
Tested up to: 3.5
Stable tag: 1.4.0
License: MIT License
License URI: http://www.opensource.org/licenses/mit-license.php

Block subscribers from accessing wp-admin pages. Disable the WP Admin Bar in WordPress 3.1+.

== Description ==

This plugin will redirect users assigned to the <em>subscriber</em> role when they try to access any wp-admin page (is_admin() is true). This plugin will also hide the admin bar for those users in WordPress 3.1+.

Users belonging to any of the other WordPress roles will continue to see and have access to the other sections of the WordPress admin that correspond to their role's capabilities.

<strong>Note: Version 1.0.0+ requires a minimum of WordPress 3.1. If you are running a version less than that, please upgrade your WordPress install before installing or upgrading.</strong>

== Support ==

Support is provided at: http://wordpress.org/support/plugin/wp-admin-no-show

== Installation ==

1. Upload `wp-admin-no-show.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

**Q. Why whould I need to block admin/profile from a user?**

WP Admin No Show was originally written for a WordPress site that used 3rd party authentication and used none of the normal WordPress admin pages, including profile.php.

== Screenshots ==

1. **WP Admin No Show Settings** - Set up per-site settings (blacklist user roles, redirect location)

== Changelog ==

= 1.4.0 =
* Tested for WordPress 3.5 compatibility.
* Removed administrator role/checkbox from blacklist.

= 1.3.0 =
* Whitelist multisite super admin. (thanks to rangiesrule for the request)
* Fixed bug in logic preventing regular admin from redirecting.

= 1.2.3 =
* Replaced multi-select dropdown with checkboxes.

= 1.2.2 =
* Updated multi-select dropdown to allow toggling of option items.

= 1.2.1 =
* Removed 28px white space in front end when admin bar is disabled.
* Thanks to Max Bond for pointing out the problem and Samuel Aguilera for the fix.

= 1.2.0 =
* Added ability to choose which page to redirect to or not at all.

= 1.1.0 =
* Added admin page and ability to blacklist user role.

= 1.0.0 =
* Initial release.

== Upgrade Notice ==
