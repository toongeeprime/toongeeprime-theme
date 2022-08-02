Plugin Name: ToongeePrime Theme
Donate link: https://akawey.com/donate/
Tags: form, post, frontend, add, edit
Requires at least: 5.9
Tested up to: 6.0
Stable tag: 1.0.40.1
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A WordPress theme with options for customization, design and development flexibility.


== Description ==


== Changelog ==

= 1.0.40.1 =

* CSS and other edits.

= 1.0.40 =

* Added option to replace header image with post thumbnail. Default: replace.

= 1.0.39.1 =

* Added wrapping tags to some text

= 1.0.39 =

* Add JS function to close mobile menu using CSS class: close_mobile_menu
* CSS edits

= 1.0.38 =

* Add Edit post link to archive post entries

= 1.0.37 =

* Edit post link updated
* Breadcrumbs avoids some errors

= 1.0.36 =

* Marked PHP 7.4 compatible
* Automate Customizer Panel naming for active Child Theme

= 1.0.35 =

* Added placeholder image possibility for posts without thumbnails in archives

= 1.0.3 =

* Template selection process refactored

= 1.0.25 =

* Added Option to hide header in theme's custom templates
* Added YouTube url to social media links in theme's Customizer options

= 1.0.2 =

* Added Empty Page template and accompanying edits

= 1.0.1 =

* Important Edits

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
* prime2g_site_base_strip

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
	prime2g_comments
	prime2g_below_posts_widgets(), 20 priority
	prime2g_pageJS(), 50 priority

Hooked to prime2g_archive_post_top:
	prime2g_archive_postmeta()

Hooked to prime2g_archive_post_footer:
	prime2g_edit_entry(), 5 priority
	prime2g_archive_postbase()


== WooCommerce ==
Hooked to woocommerce_after_single_product_summary:
	prime2g_product_in_view()

Removed:
	woocommerce_breadcrumb

