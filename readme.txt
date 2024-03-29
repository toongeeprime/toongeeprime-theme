Plugin Name: ToongeePrime Theme
Donate link: https://akawey.com/donate/
Tags: form, post, frontend, add, edit
Requires at least: 6.3
Tested up to: 6.4
Stable tag: 1.0.78
Requires PHP: 8.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A WordPress theme with options for customization, design and development flexibility.


== Description ==


== Changelog ==

= 1.0.78 =
* Live search added to prime2g_wp_block_search_form() & shortcode
* Functions: prime2g_mega_menu_css() & prime2g_mega_menu_js(), prime2g_ajax_search_js() & prime2g_ajax_search_css()
* Readme.txt goes online @ https://dev.akawey.com/wp/themes/toongeeprime-theme/readme.txt
* Mega Menu options: full width, page width

= 1.0.77 =
* File: single-prime_template_parts.php because of Elementor
* Template Parts block editor template restricted to HTML blocks
* Functions: prime_post_types_group() & prime_taxonomies_group()

= 1.0.76 =
* Custom login url bug fix
* Custom capability @ admin access control
* Function: prime_strip_url_end()
* Menu: Allow for Mega Menu HTML

= 1.0.75 =
* Work JS by custom field at custom login page, hence restored legacy custom JS field

= 1.0.74 =
OPTIMIZATIONS

= 1.0.73 =
* Added: prime2g_admin_metabox_css(), prime2g_metabox_javascript(), prime2g_view_password_toggler()
* Dirs: /login/, /deprecated/
* LOGIN PAGE REVAMP:
	* Class: Prime2gLoginPage
	* Added: login-form.php, prime2g_theme_styles_at_login_page(), prime2g_parent_enqueues_at_login(), prime2g_login_page_css(),
	prime2g_login_form() and shortcode
	* Updates @ login-page.php
	* Admin access controls @ wp.php

= 1.0.72 =
* Fixed website shutdown loophole

= 1.0.71 =
* Added prime2g_get_posts_output() and use in prime2g_posts_shortcode()

= 1.0.70 =
* Homepage Slideshow
* Added: prime2g_fields_in_post_types(), prime2g_get_stickies_by_customizer(), prime2g_stickies_css(), prime2g_get_post_object_template(), prime_url_is_ok()
* Class: Prime2gJSBits
* @includes: helpers-for-templates.php
* Deprecated prime2g_include_post_types() & prime2g_exclude_post_types()
* Header image CSS option added to 'remove_header' field
* @Customizer: add code to <head> and <body>
* Added "Template Part Shortcode" column to Template Parts Edit Screen
* Added 'device' parameter to prime_insert_template_part shortcode
* prime2g_display_posts shortcode now works with multisite; added image_size, image_to_video, site_id and randomize_sites parameters

= 1.0.60 =
* prime2g_load_fonts_and_icons() renamed to prime2g_load_theme_fonts()
* Added performance.php @ init/
* files-loader.php renamed to run.php, with matters brought from init.php
* Font custom field

= 1.0.59 =
* Conditionally use theme's jQuery
* Performance section added to Customizer

= 1.0.58 =
* Do not use cached styles in Customizer

= 1.0.57 =
* Added functions in css.php, mini-features.php & menus.php
* Helper: prime2g_constant_is_true()
* Method mods_cache() added to ToongeePrime_Styles class
* jQuery 3.7.1

= 1.0.56 =
* Deprecated theme.css to theme-old.css, to strip down the file and pass more style control to child theme
* More conditions to css.php
* Functions: prime_child_min_version(), prime2g_menu_togglers(), prime2g_chache_control_headers()
* @ customizer: cache controls @ site settings

= 1.0.55 =
Several features & updates across the theme
* Introduced theme's PROGRESSIVE WEB APP (PWA)
* HEADER VIDEO
* SMTP Mail Config
* Overhaul Google Fonts system, added prime2g_get_google_fonts_remote() and prime2g_get_gfont_category()
* @ Class: Prime2gThemeUpdater - overhauling former update system
* @ Class: Prime2g_PWA_Features
* @ Class: Prime2gMailer
* @ Class: @ ToongeePrime_Styles, allow child overriding of defaults
* @ Child Theme Optional Constants: *CHILD_BUTTONTEXT, CHILD_BUTTONBG, CHILD_BRANDCOLOR, CHILD_BRANDCOLOR2,
CHILD_SITEBG, CHILD_HEADERBG, CHILD_CONTENTBG, CHILD_FOOTERBG
* @ customizer: File: customizer-theme-menus.php
* @ customizer: Theme Fonts Section
* @ customizer: Alt Fonts Fallbacks
* @ customizer: Page Titles Font Weight
* @ customizer: Header Height Controls, added render-site-parts.php
* @ customizer: Site shutdown: added options to use a page as display
* @ customizer: Archive columns
* @ customizer: Video Features with fields, templates and functions
* @ customizer: Footer columns with accompanying setups
* @ customizer: Remove sidebar controls (Archives / Singular)
* @ customizer: Left/Right sidebar
* @ customizer: Archive Pagination Type
* @ customizer: Place Menu over header
* @ customizer: Page title over header video
* @ customizer: Byline Options
* @ customizer: 404 Error Page Options
* @ customizer: Show/Hide Socials & contacts icon links
* @ Menus: Added Site Top Menu
* @ parts: Added adjust-templates.php for conditional adjustments
* @ plugins: Added plugin-helpers.php
* @ includes: Added css.php & js.php
* @ js: Added insertAfter
* @ Preloader: Custom CSS/JS can be added
* @ Sidebars: aboveheader-widgets, belowheader-widgets, aboveposts-widgets,
* @ Hooks: prime2g_before_head, prime2g_before_body, prime2g_before_header_title,
	prime2g_after_header_title, prime2g_after_home_main_headline, prime2g_after_home_headlines
* @ Features: Multislide capability added to HTML Slider
* @ Mini Cart: @version 7.8.0
* @ Features: accordion-frame-set.php
* Add more navigation menu locations + select location to use per page:
	-	Menus have to be created to link to locations
* Pagination by numbers
* Work Custom logo width and height attributes
* Shortcodes: prime_site_logo, prime_search_form, prime_site_title_and_description, prime_nav_menu, prime_video,
prime_map, prime_site_footer_credits, prime2g_lottie
* Internalized jQuery
* Updated screenshot

= 1.0.51 =
* JS: prime2g_isMobile(), prime2g_isTouchDevice(), prime2g_screenIsSmaller()
* Feature: multi-html-slider-with-shortcodes.php
* Extras: multi-frame-posts-slider.php
* WP: prime2g_disable_wpautop() with custom field
* Shortcode: [prime_redirect_to], [prime_show_content_to]
* Reworked prime2g_show_sticky_posts()
* wp_title() removed from header

= 1.0.50 =
MAJOR UPDATE
* @ includes: custom-post-types.php, custom-taxonomies.php & custom-admin-menu-actions.php
* @ customizer: Adding of Custom Post Types in Theme Extras
* Deprecated prime2g_add_template_part() & shortcode, in favour of new prime2g_insert_template_part() + shortcode
* Removed ajaxing in Dark Theme Switching
* Reworked prime2g_wp_query() & [prime2g_display_posts] to support caching
* Added $text and $length args to prime2g_read_more_excerpt_link() and associated functions
* Added $post arg to prime2g_archive_post_top_filter_part()
* Created prime2g_get_archive_loop_post_object()
* prime2g_categs_array() now prime2g_categs_and_ids_array() & moved to helpers.php from customizer-front-page.php
* Added prime2g_posttypes_names_array()
* Added News Reel feature and Customizer settings
* Added prime2g_customizer_media_features()
* Added admin_enqueue_scripts, customize_controls_enqueue_scripts & customize_preview_init
* Added customizer.js & customizer-preview.js
* add_theme_support( 'customize-selective-refresh-widgets' )

= 1.0.49.05 =
* Dark Theme Updates
* Introduced ajax directory
* Added $getSrc parameter to prime2g_siteLogo()
* Add "preloaded" class when preloader is active & page is fully loaded
* Reworked theme Classes

= 1.0.49 =
* Added JS prime2g_get_sibling()
* Added previous/next functionality to html slider
* Added $darklogo parameter to prime2g_siteLogo()
* Added [prime2g_social_and_contacts]
* Added [prime2g_add_template_part]
* Bootstrap icons update
* @ Customizer: 'prime2g_stop_wp_heartbeat'
* Added prime2g_stop_wp_heartbeat()
* Added prime2g_get_site_domain()
* Introduced Dark Theme Feature, & @ Customizer: 'prime2g_dark_theme_switch'
* Introduced init directory, to offload functions.php

= 1.0.48.50 =
* Added prime2g_customizer_site_settings() & theme_mod: prime2g_footer_credit_append
* Added JS prime2g_count_to(), prime2g_inViewport_get()

= 1.0.48.10 =
* Added prime2g_add_template_part()
* Added JS function prime2g_class_on_scroll()

= 1.0.48 =
* Tested on WP 6.1 requiring at least 6.0
* Header image size @ Customizer
* Created extras folder @features
* Introduced Extra Features section @ Customizer
* Preloader feature at @ Customizer
* Added prime2g_add_jp_related_posts() to hook prime2g_after_post
* Added prime2g_use_extras()

= 1.0.47 =
* Added helper prime2g_get_country_by_code()
* Created get-theme-template-file.php to separate prime2g_get_theme_template()
* Created plugins folder to contain 3rd party plugins related functions
* Added JetPack Infinite Scroll support

= 1.0.46 =
* [prime2g_display_posts] now supports template attribute @ looptemplate
* @ includes: Introduced ajax.php
* Added prime2g_element_observerJQuery() to [prime2g_animation_script]

= 1.0.45.50 =
* Added prime2g_get_woo_mini_cart()

= 1.0.45 =
* Added HTML slider 'frame' feature with JS and CSS shortcodes
* Upgraded the function prime2g_posts_shortcode()
* Added prime2g_get_archive_loop() to return template and prime2g_archive_loop() now echoes it
* Added filter functions: prime2g_archive_post_top_filter_part() and prime2g_archive_post_footer_filter_part()
* Added prime2g_edit_entry_get() and prime2g_edit_entry() echoes it
* Added prime2g_is_post_author()

= 1.0.44 =
* WooCommerce Mini-cart workings
* JS function with shortcode to add basic animation support

= 1.0.43 =
* Introduced deprecated file
* Deprecated query functions in favour of more concise new functions
* Extended prime2g_post_object_template() to allow excerpts
* Extended prime2g_posted_by() to pass in post object parameter
* Added Telegram and TikTok icons to Customizer
* More Google Fonts (75 total)
* Deleted WP icons
* Other code updates and optimizations

= 1.0.42.51 =
* CSS and various edits

= 1.0.42.50 =
* Added Bootstrap icons via CSS... to delete WP icons later

= 1.0.42.11 =
* Header Image Attachment option in Customizer

= 1.0.42 =
* Detect Post Type Archive Template

= 1.0.41 =
* Added Front-page settings to Customizer

= 1.0.40.971 =
* Up to this update were Template detecting and CSS updates

= 1.0.40.2 =
* CSS and other edits.

= 1.0.40 =
* Added option to replace header image with post thumbnail. Default: replace

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


== Theme Filters ==
@since version 1.0.45
* prime2g_archive_post_top_filter
* prime2g_archive_post_footer_filter


== Theme Hooks ==
* prime2g_before_header
* prime2g_sub_header
* prime2g_after_header
* prime2g_before_title @since 1.0.50
* prime2g_after_title
* prime2g_before_post
* prime2g_after_post
* prime2g_archive_post_top
* prime2g_archive_post_footer
* prime2g_site_base_strip
* prime2g_before_head @since 1.0.55:
* prime2g_before_body
* prime2g_before_header_title
* prime2g_after_header_title
* prime2g_page_title_hook
* prime2g_after_home_main_headline
* prime2g_after_home_headlines

Hooked to prime2g_before_header: @since 1.0.55
	prime2g_widgets_above_header

Hooked to prime2g_sub_header:  @since 1.0.55
	prime2g_widgets_below_header

Hooked to prime2g_after_header:
	prime2g_breadcrumbs, 7 priority
	prime2g_show_sticky_posts
	prime2g_home_headlines, 12 priority

Hooked to prime2g_after_title:
	prime2g_postmeta_top

Hooked to prime2g_before_post:
	prime2g_pageCSS, 2 priority
	prime2g_edit_entry, 5 priority
	prime2g_widgets_above_post @since 1.0.55

Hooked to prime2g_after_post:
	prime2g_postmeta_bottom, 5 priority
	prime2g_prev_next_post, 7 priority
	prime2g_add_jp_related_posts, 8 priority
	prime2g_comments
	prime2g_below_posts_widgets, 20 priority
	prime2g_pageJS, 50 priority

Hooked to prime2g_archive_post_top:
	prime2g_archive_postmeta

Hooked to prime2g_archive_post_footer:
	prime2g_edit_entry, 5 priority
	prime2g_archive_postbase


== WooCommerce ==
Hooked to woocommerce_after_single_product_summary:
	prime2g_product_in_view

Removed:
	woocommerce_breadcrumb
