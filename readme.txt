Plugin Name: ToongeePrime Theme
Donate link: https://akawey.com/donate/
Tags: form, post, frontend, add, edit
Requires at least: 5.5
Tested up to: 5.9
Stable tag: 1.0
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A WordPress theme with several options for customization and design flexibility.


== Description ==


== Changelog ==

= 1.0 =

* First release



== Hooked Functions ==
Hooked to wp_head:
	prime2g_theme_root_styles()
	prime2g_preload_webfonts()
	toongeeprime_pingback_header()

Hooked to wp_footer:
	prime2g_toTop()

Hooked to the_title:
	prime2g_post_no_title()

Hooked to excerpt_more:
	prime2g_read_more_excerpt_link()

Hooked to the_content_more_link:
	prime2g_read_more_link()

Hooked to comment_form_defaults:
	toongeeprime_comment_form_defaults()



== Theme Hooks ==
* prime2g_before_header
* prime2g_after_header
* prime2g_after_title
* prime2g_before_post
* prime2g_after_post
* prime2g_archive_post_top
* prime2g_archive_post_footer

Hooked to prime2g_after_header:
	prime2g_breadcrumbs(), 7 priority
	prime2g_show_sticky_posts()
	prime2g_home_headlines(), 12 priority

Hooked to prime2g_after_title:
	prime2g_postmeta_top()

Hooked to prime2g_before_post:
	prime2g_pageCSS(), 2 priority
	prime2g_edit_entry(), 5 priority

Hooked to prime2g_after_post:
	prime2g_postmeta_bottom, 5 priority
	prime2g_prev_next_post, 7 priority
	comment_form
	prime2g_below_posts_widgets(), 20 priority
	prime2g_pageJS(), 50 priority

Hooked to prime2g_archive_post_top:
	prime2g_archive_postmeta()

Hooked to prime2g_archive_post_footer:
	prime2g_archive_postbase()



