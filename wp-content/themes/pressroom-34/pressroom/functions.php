<?php
$themename = "pressroom";
/*function your_prefix_vcSetAsTheme() 
{
	vc_set_as_theme();
}
add_action('init', 'your_prefix_vcSetAsTheme');*/

//plugins activator
require_once("plugins_activator.php");

//for is_plugin_active
include_once( ABSPATH . 'wp-admin/includes/plugin.php');

//vc_remove_element("vc_row_inner");
if(function_exists("vc_remove_element"))
{
	vc_remove_element("vc_gmaps");
	vc_remove_element("vc_tour");
	vc_remove_element("vc_separator");
	vc_remove_element("vc_text_separator");
}

//theme options
pr_get_theme_file("/theme-options.php");

//menu walker
pr_get_theme_file("/mobile_menu_walker.php");

//custom meta box
pr_get_theme_file("/meta-box.php");

if(function_exists("vc_map"))
{
	//contact_form
	pr_get_theme_file("/contact_form.php");
	//shortcodes
	pr_get_theme_file("/shortcodes/shortcodes.php");
}

//comments
pr_get_theme_file("/comments-functions.php");

//sidebars
pr_get_theme_file("/sidebars.php");

//widgets
pr_get_theme_file("/widgets/widget-contact-details.php");
pr_get_theme_file("/widgets/widget-scrolling-posts.php");
pr_get_theme_file("/widgets/widget-scrolling-recent.php");
pr_get_theme_file("/widgets/widget-social-icons.php");
pr_get_theme_file("/widgets/widget-cart-icon.php");
pr_get_theme_file("/widgets/widget-high-contrast-switch-icon.php");

//menu
//pr_get_theme_file("/nav-menu-walker.php"));

function pr_theme_after_setup_theme()
{
	global $themename;
	//set default theme options
	if(!get_option($themename . "_installed"))
	{		
		$theme_options = array(
			"favicon_url" => get_template_directory_uri() . "/images/favicon.ico",
			"logo_url" => "",
			"logo_text" => "Pressroom",
			"footer_text" => 'Desenvolvido por <a target="_blank" title="TELECOM" href="http://telecom.inf.br">Telecomo</a> - Comunicação e Informática.',
			"sticky_menu" => 0,
			"responsive" => 1,
			"layout" => "fullwidth",
			"color_scheme" => "light",
			"style_selector" => 0,
			"direction" => "default",
			"collapsible_mobile_submenus" => 1,
			"google_api_code" => "",
			"ga_tracking_code" => "",
			"cf_admin_name" => get_option("admin_email"),
			"cf_admin_email" => get_option("admin_email"),
			"cf_smtp_host" => "",
			"cf_smtp_username" => "",
			"cf_smtp_password" => "",
			"cf_smtp_port" => "",
			"cf_smtp_secure" => "",
			"cf_email_subject" => "Pressroom WP: Contact from WWW",
			"cf_template" => "<html>
	<head>
	</head>
	<body>
		<div><b>Name</b>: [name]</div>
		<div><b>E-mail</b>: [email]</div>
		<div><b>Message</b>: [message]</div>
	</body>
</html>"
		);
		add_option($themename . "_options", $theme_options);
		
		global $wp_rewrite;
		$wp_rewrite->flush_rules();
		add_option($themename . "_installed", 1);
	}
	
	//Make theme available for translation
	//Translations can be filed in the /languages/ directory
	load_theme_textdomain('pressroom', get_template_directory() . '/languages');
	
	//woocommerce
	add_theme_support("woocommerce");
	add_theme_support("wc-product-gallery-zoom");
	add_theme_support("wc-product-gallery-lightbox");
	add_theme_support("wc-product-gallery-slider");
	
	//menus
	add_theme_support("menus");
	
	//register thumbnails
	add_theme_support("post-thumbnails");
	add_image_size("slider-thumb", 1250, 550, true);
	add_image_size("small-slider-thumb", 690, 450, true);
	add_image_size("blog-post-thumb-big", 510, 374, true);
	add_image_size("blog-post-thumb", 330, 242, true);
	add_image_size("blog-post-thumb-medium", 510, 187, true);
	add_image_size("post-grid-thumb-large", 787, 524, true);
	add_image_size("post-grid-thumb-big", 524, 524, true);
	add_image_size("post-grid-thumb-medium", 524, 261, true);
	add_image_size($themename . "-gallery-thumb-type-3", 130, 95, true);
	add_image_size($themename . "-small-thumb", 100, 100, true);
	
	//posts order
	add_post_type_support('post', 'page-attributes');
	
	//enable custom background
	add_theme_support("custom-background"); //3.4
	//add_custom_background(); //deprecated
	
	//enable feed links
	add_theme_support('automatic-feed-links');
	
	//post_formats
	add_theme_support('post-formats', array('gallery', 'image', 'video', 'link', 'quote', 'audio'));
	
	//title tag
	add_theme_support("title-tag");
	
	//register menus
	if(function_exists("register_nav_menu"))
	{
		register_nav_menu("main-menu", "Main Menu");
		register_nav_menu("footer-menu", "Footer Menu");
		register_nav_menu("footer-menu-2", "Footer Menu 2");
	}
	
	//custom theme filters
	add_filter('upload_mimes', 'pr_custom_upload_files');
	//using shortcodes in sidebar
	add_filter("widget_text", "do_shortcode");
	add_filter("image_size_names_choose", "pr_theme_image_sizes");
	add_filter('excerpt_more', 'pr_theme_excerpt_more', 99);
	add_filter('post_class', 'pr_check_image');
	add_filter('user_contactmethods', 'pr_contactmethods', 10, 1);
	add_filter('wp_title', 'pr_wp_title_filter', 10, 2);
	add_filter('site_transient_update_plugins', 'pressroom_filter_update_vc_plugin', 10, 2);
	
	//custom theme woocommerce filters
	add_filter('woocommerce_pagination_args' , 'pr_woo_custom_override_pagination_args');
	add_filter('woocommerce_product_single_add_to_cart_text', 'pr_woo_custom_cart_button_text');
	add_filter('woocommerce_product_add_to_cart_text', 'pr_woo_custom_cart_button_text');
	add_filter('loop_shop_columns', 'pr_woo_custom_loop_columns');
	add_filter('woocommerce_product_description_heading', 'pr_woo_custom_product_description_heading');
	add_filter('woocommerce_checkout_fields' , 'pr_woo_custom_override_checkout_fields');
	add_filter('woocommerce_show_page_title', 'pr_woo_custom_show_page_title');
	add_filter('loop_shop_per_page', create_function( '$cols', 'return 6;' ), 20);
	add_filter('woocommerce_review_gravatar_size', 'pr_woo_custom_review_gravatar_size');
	add_filter('theme_page_templates', 'pr_woocommerce_page_templates' , 11, 3);
	
	//custom theme ubermenu filters
	if(!is_plugin_active('ubermenu/ubermenu.php'))
		add_filter('nav_menu_css_class', 'pr_nav_menu_css_class', 10, 2 );
		
	//custom theme actions
	add_action('admin_menu', 'pr_remove_post_format_box');
	add_action('add_meta_boxes', 'pr_add_post_format_box');
	if(!function_exists('_wp_render_title_tag')) 
		add_action('wp_head', 'pr_theme_slug_render_title');
	
	//custom theme woocommerce actions
	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
	remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
	//remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
	add_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 5);
	add_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 10);
	add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
	//add_action('woocommerce_after_shop_loop', 'woocommerce_result_count', 20);
	
	//phpMailer
	add_action('phpmailer_init', 'pr_phpmailer_init');
	
	//content width
	if(!isset($content_width)) 
		$content_width = 1050;
	
	//register sidebars
	if(function_exists("register_sidebar"))
	{
		//register custom sidebars
		$sidebars_list = get_posts(array(
			'post_type' => $themename . '_sidebars',
			'posts_per_page' => '-1',
			'post_status' => 'publish',
			'orderby' => 'menu_order',
			'order' => 'ASC'
		));
		foreach($sidebars_list as $sidebar)
		{
			$before_widget = get_post_meta($sidebar->ID, "before_widget", true);
			$after_widget = get_post_meta($sidebar->ID, "after_widget", true);
			$before_title = get_post_meta($sidebar->ID, "before_title", true);
			$after_title = get_post_meta($sidebar->ID, "after_title", true);
			register_sidebar(array(
				"id" => $sidebar->post_name,
				"name" => $sidebar->post_title,
				'before_widget' => ($before_widget!='' && $before_widget!='empty' ? $before_widget : ''),
				'after_widget' => ($after_widget!='' && $after_widget!='empty' ? $after_widget : ''),
				'before_title' => ($before_title!='' && $before_title!='empty' ? $before_title : ''),
				'after_title' => ($after_title!='' && $after_title!='empty' ? $after_title : '')
			));
		}
	}
}
add_action("after_setup_theme", "pr_theme_after_setup_theme");
function pr_theme_switch_theme($theme_template)
{
	global $themename;
	delete_option($themename . "_installed");
}
add_action("switch_theme", "pr_theme_switch_theme");

/* --- phpMailer config --- */
function pr_phpmailer_init(PHPMailer $mail) 
{
	global $theme_options;
	$mail->CharSet='UTF-8';
	
	$smtp = $theme_options["cf_smtp_host"];
	if(!empty($smtp))
	{
		$mail->IsSMTP();
		$mail->SMTPAuth = true; 
		//$mail->SMTPDebug = 2;
		$mail->Host = $theme_options["cf_smtp_host"];
		$mail->Username = $theme_options["cf_smtp_username"];
		$mail->Password = $theme_options["cf_smtp_password"];
		if((int)$theme_options["cf_smtp_port"]>0)
			$mail->Port = (int)$theme_options["cf_smtp_port"];
		$mail->SMTPSecure = $theme_options["cf_smtp_secure"];
	}
}

/* --- Theme Custom Filters & Actions Functions --- */
//add new mimes for upload dummy content files (code can be removed after dummy content import)
function pr_custom_upload_files($mimes) 
{
    $mimes = array_merge($mimes, array('xml' => 'application/xml'), array('json' => 'application/json'), array('zip' => 'application/zip'), array('gz' => 'application/x-gzip'), array('ico' => 'image/x-icon'));
    return $mimes;
}
function pr_remove_post_format_box() 
{
	remove_meta_box('formatdiv', 'post', 'side'); 
}
function pr_theme_image_sizes($sizes)
{
	global $themename;
	$addsizes = array(
		"small-slider-thumb" => __("Small slider thumbnail", 'pressroom'),
		"blog-post-thumb" => __("Blog post thumbnail", 'pressroom'),
		$themename . "-gallery-thumb" => __("Gallery thumbnail", 'pressroom'),
		$themename . "-small-thumb" => __("Small thumbnail", 'pressroom')
	);
	$newsizes = array_merge($sizes, $addsizes);
	return $newsizes;
}
// Add post format meta box to a new position
function pr_add_post_format_box() 
{
    add_meta_box(
		'formatdiv', 
		_x( 'Format', 'post format', 'pressroom' ),
		'post_format_meta_box',
		'post', 
		'normal',
		'high'
	);
}
//excerpt
function pr_theme_excerpt_more($more) 
{
	return '';
}
//sticky
function pr_check_image($class) 
{
	if(is_sticky())
		$class[] = 'sticky';
	return $class;
}
//user info
function pr_contactmethods($contactmethods) 
{
	$contactmethods['twitter'] = 'Twitter';
	$contactmethods['facebook'] = 'Facebook';
	$contactmethods['linkedin'] = 'Linkedin';
	$contactmethods['skype'] = 'Skype';
	$contactmethods['googleplus'] = 'Google Plus';
	$contactmethods['instagram'] = 'Instagram';
	return $contactmethods;
}
if(!function_exists('_wp_render_title_tag')) 
{
    function pr_theme_slug_render_title() 
	{
		echo ''. wp_title('-', true, 'right') . '';
    }
}
function pr_wp_title_filter($title, $sep)
{
	//$title = get_bloginfo('name') . " | " . (is_home() || is_front_page() ? get_bloginfo('description') : $title);
	return $title;
}
function pressroom_filter_update_vc_plugin($date) 
{
    if(!empty($date->checked["js_composer/js_composer.php"]))
        unset($date->checked["js_composer/js_composer.php"]);
    if(!empty($date->response["js_composer/js_composer.php"]))
        unset($date->response["js_composer/js_composer.php"]);
    return $date;
}

/* --- Theme WooCommerce Custom Filters Functions --- */
function pr_woo_custom_override_pagination_args($args) 
{
	$args['prev_text'] = __('&lsaquo;', 'pressroom');
	$args['next_text'] = __('&rsaquo;', 'pressroom');
	return $args;
}
function pr_woo_custom_cart_button_text() 
{
	return __('ADD TO CART', 'pressroom');
}
if(!function_exists('loop_columns')) 
{
	function pr_woo_custom_loop_columns() 
	{
		return 3; // 3 products per row
	}
}
function pr_woo_custom_product_description_heading() 
{
    return '';
}
function pr_woo_custom_show_page_title()
{
	return false;
}
function pr_woo_custom_override_checkout_fields($fields) 
{
	$fields['billing']['billing_first_name']['placeholder'] = 'First Name';
	$fields['billing']['billing_last_name']['placeholder'] = 'Last Name';
	$fields['billing']['billing_company']['placeholder'] = 'Company Name';
	$fields['billing']['billing_email']['placeholder'] = 'Email Address';
	$fields['billing']['billing_phone']['placeholder'] = 'Phone';
	return $fields;
}
function pr_woo_custom_review_gravatar_size()
{
	return 100;
}
function pr_woocommerce_page_templates($page_templates, $class, $post)
{
	if(is_plugin_active('woocommerce/woocommerce.php'))
	{
		$shop_page_id = wc_get_page_id('shop');
		if($post && absint($shop_page_id) === absint($post->ID))
		{
			$page_templates["path-to-template/full-width.php"] = "Template Name";
		}
	}
 	return $page_templates;
}
/* --- Theme Ubermenu Custom Filters Functions --- */
function pr_nav_menu_css_class($classes, $item) 
{
	if(empty($classes))
	{
		$classes = array();
	}
	else
	{
		foreach ((array) $classes as $key=>$value)
			$classes[$key] = ($value!="" ? (substr($value, 0, 4)=="menu" ? 'uber' : 'ubermenu-') . esc_attr($value) : '');
	
	}
    return $classes;
}

//admin functions
pr_get_theme_file("/admin/functions.php");

//theme options
global $theme_options;
$theme_options = array(
	"favicon_url" => '',
	"logo_url" => '',
	"logo_text" => '',
	"footer_text" => '',
	"sticky_menu" => '',
	"responsive" => '',
	"layout" => '',
	"layout_style" => '',
	"layout_image_overlay" => '',
	"style_selector" => '',
	"direction" => '',
	"collapsible_mobile_submenus" => '',
	"google_api_code" => '',
	"ga_tracking_code" => '',
	"cf_admin_name" => '',
	"cf_admin_email" => '',
	"cf_smtp_host" => '',
	"cf_smtp_username" => '',
	"cf_smtp_password" => '',
	"cf_smtp_port" => '',
	"cf_smtp_secure" => '',
	"cf_email_subject" => '',
	"cf_template" => '',
	"color_scheme" => '',
	"font_size_selector" => '',
	"site_background_color" => '',
	"main_color" => '',
	"header_style" => '',
	"header_container" => '',
	"menu_container" => '',
	"header_top_sidebar" => '',
	"header_top_right_sidebar" => '',
	"primary_font" => '',
	"primary_font_custom" => '',
	"secondary_font" => '',
	"secondary_font_custom" => '',
	"text_font" => '',
	"text_font_custom" => ''
);
$theme_options = pr_theme_stripslashes_deep(array_merge($theme_options, (array)get_option($themename . "_options")));

function pr_theme_enqueue_scripts()
{
	global $themename;
	global $theme_options;
	//style
	if($theme_options["primary_font"]!="" && $theme_options["primary_font_custom"]=="")
		wp_enqueue_style("google-font-primary", "//fonts.googleapis.com/css?family=" . urlencode($theme_options["primary_font"]) . (!empty($theme_options["primary_font_subset"]) ? "&subset=" . implode(",", $theme_options["primary_font_subset"]) : ""));
	else if($theme_options["primary_font_custom"]=="")
		wp_enqueue_style("google-font-roboto", "//fonts.googleapis.com/css?family=Roboto:300,400,700");
	if($theme_options["secondary_font"]!="")
		wp_enqueue_style("google-font-secondary", "//fonts.googleapis.com/css?family=" . urlencode($theme_options["secondary_font"]) . (!empty($theme_options["secondary_font_subset"]) ? "&subset=" . implode(",", $theme_options["secondary_font_subset"]) : ""));
	else if($theme_options["secondary_font_custom"]=="")
		wp_enqueue_style("google-font-roboto-condensed", "//fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700");
	if($theme_options["text_font"]!="" && $theme_options["text_font_custom"]=="")
		wp_enqueue_style("google-font-text", "//fonts.googleapis.com/css?family=" . urlencode($theme_options["text_font"]) . (!empty($theme_options["text_font_subset"]) ? "&subset=" . implode(",", $theme_options["text_font_subset"]) : ""));
	wp_enqueue_style("reset", get_template_directory_uri() . "/style/reset.css");
	wp_enqueue_style("superfish", get_template_directory_uri() ."/style/superfish.css");
	wp_enqueue_style("prettyPhoto", get_template_directory_uri() ."/style/prettyPhoto.css");
	wp_enqueue_style("jquery-qtip", get_template_directory_uri() ."/style/jquery.qtip.css");
	wp_enqueue_style("odometer", get_template_directory_uri() ."/style/odometer-theme-default.css");
	wp_enqueue_style("animations", get_template_directory_uri() ."/style/animations.css");
	wp_enqueue_style("main-style", get_stylesheet_uri());
	if((isset($theme_options["menu_container"]) && $theme_options["menu_container"]!="") || (int)$theme_options["style_selector"])
		wp_enqueue_style("menu-styles", get_template_directory_uri() ."/style/menu_styles.css");
	if((int)$theme_options["responsive"])
		wp_enqueue_style("responsive", get_template_directory_uri() ."/style/responsive.css");
	else
		wp_enqueue_style("no-responsive", get_template_directory_uri() ."/style/no_responsive.css");
	$color_skin = (isset($_COOKIE['pr_color_skin']) ? $_COOKIE['pr_color_skin'] : $theme_options["color_scheme"]);
	if($color_skin=="dark" || $color_skin=="high_contrast")
	{
		wp_enqueue_style("dark-skin", get_template_directory_uri() ."/style/dark_skin.css");
		if($color_skin=="high_contrast")
			wp_enqueue_style("high_contrast-skin", get_template_directory_uri() ."/style/high_contrast_skin.css");
	}
	if(is_plugin_active('woocommerce/woocommerce.php'))
	{
		wp_enqueue_style("woocommerce-custom", get_template_directory_uri() ."/woocommerce/style.css");
		if((int)$theme_options["responsive"])
			wp_enqueue_style("woocommerce-responsive", get_template_directory_uri() ."/woocommerce/responsive.css");
		else
			wp_dequeue_style("woocommerce-smallscreen");
		if($color_skin=="dark" || $color_skin=="high_contrast")
		{
			wp_enqueue_style("woocommerce-dark-skin", get_template_directory_uri() ."/woocommerce/dark_skin.css");
			if($color_skin=="high_contrast")
				wp_enqueue_style("woocommerce-high_contrast-skin", get_template_directory_uri() ."/woocommerce/high_contrast_skin.css");
		}
		if(is_rtl())
			wp_enqueue_style("woocommerce-rtl", get_template_directory_uri() ."/woocommerce/rtl.css");
	}
	if(is_plugin_active('ubermenu/ubermenu.php'))
	{
		wp_enqueue_style("ubermenu-pr-style", get_template_directory_uri() ."/style/ubermenu.css");
	}
	wp_enqueue_style("custom", get_template_directory_uri() ."/custom.css");
	//js
	wp_enqueue_script("jquery", false, array(), false, true);
	wp_enqueue_script("jquery-ui-core", false, array("jquery"), false, true);
	wp_enqueue_script("jquery-ui-accordion", false, array("jquery"), false, true);
	wp_enqueue_script("jquery-ui-tabs", false, array("jquery"), false, true);
	wp_enqueue_script("jquery-ba-bqq", get_template_directory_uri() ."/js/jquery.ba-bbq.min.js", array("jquery"), false, true);
	wp_enqueue_script("jquery-history", get_template_directory_uri() ."/js/jquery.history.js", array("jquery"), false, true);
	wp_enqueue_script("jquery-easing", get_template_directory_uri() ."/js/jquery.easing.1.3.js", array("jquery"), false, true);
	wp_enqueue_script("jquery-carouFredSel", get_template_directory_uri() ."/js/jquery.carouFredSel-6.2.1-packed.js", array("jquery"), false, true);
	wp_enqueue_script("jquery-touchSwipe", get_template_directory_uri() ."/js/jquery.touchSwipe.min.js", array("jquery"), false, true);
	wp_enqueue_script("jquery-transit", get_template_directory_uri() ."/js/jquery.transit.min.js", array("jquery"), false, true);
	wp_enqueue_script("jquery-sliderControl", get_template_directory_uri() ."/js/jquery.sliderControl.js", array("jquery"), false, true);
	wp_enqueue_script("jquery-timeago", get_template_directory_uri() ."/js/jquery.timeago.js", array("jquery"), false, true);
	wp_enqueue_script("jquery-hint", get_template_directory_uri() ."/js/jquery.hint.js", array("jquery"), false, true);
	wp_enqueue_script("jquery-qtip", get_template_directory_uri() ."/js/jquery.qtip.min.js", array("jquery"), false, true);
	wp_enqueue_script("jquery-block-ui", get_template_directory_uri() ."/js/jquery.blockUI.js", array("jquery"), false, true);
	wp_enqueue_script("jquery-prettyPhoto", get_template_directory_uri() ."/js/jquery.prettyPhoto.js", array("jquery"), false, true);
	wp_enqueue_script("jquery-odometer", get_template_directory_uri() ."/js/odometer.min.js", array("jquery"), false, true);
	wp_enqueue_script("google-maps-v3", "//maps.google.com/maps/api/js" . ($theme_options["google_api_code"]!="" ? "?key=" . esc_attr($theme_options["google_api_code"]) : ""), false, array(), false, true);
	if(!is_customize_preview())
		wp_enqueue_script("theme-main", get_template_directory_uri() ."/js/main.js", array("jquery", "jquery-ui-core", "jquery-ui-accordion", "jquery-ui-tabs"), false, true);
	
	//ajaxurl
	$data["ajaxurl"] = admin_url("admin-ajax.php");
	//themename
	$data["themename"] = $themename;
	//home url
	$data["home_url"] = get_home_url();
	//is_rtl
	$data["is_rtl"] = ((is_rtl() || $theme_options["direction"]=='rtl') && ((isset($_COOKIE["pr_direction"]) && $_COOKIE["pr_direction"]!="LTR") || !isset($_COOKIE["pr_direction"]))) || (isset($_COOKIE["pr_direction"]) && $_COOKIE["pr_direction"]=="RTL") ? 1 : 0;
	//color scheme
	$data["color_scheme"] = $theme_options["color_scheme"];
	//page number
	global $paged, $page;	
	$data["page_number"] = max($paged, $page);
	
	//pass data to javascript
	$params = array(
		'l10n_print_after' => 'config = ' . json_encode($data) . ';'
	);
	wp_localize_script("theme-main", "config", $params);
}
add_action("wp_enqueue_scripts", "pr_theme_enqueue_scripts");

//function to display number of posts
function getPostViews($postID)
{
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count=='')
	{
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }
    return (int)$count;
}

//function to count views
function setPostViews($postID) 
{
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count=='')
	{
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, 1);
    }
	else
	{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

/**
 * Returns datetime in iso8601 format
 * @param type $time - optional string representation of datetime
 * @return type - datetime in iso8601 format
 */
function get_datetime_iso8601($time = null) 
{
	$offset = get_option('gmt_offset');
	$timezone = ($offset < 0 ? '-' : '+') . (abs($offset)<10 ? '0'.abs($offset) : abs($offset)) . '00' ;
	return date('Y-m-d\TH:i:s', (empty($time) ? time() : strtotime($time))) . $timezone;
}

function pr_theme_direction() 
{
	global $wp_locale, $theme_options;
	if(isset($theme_options['direction']) || (isset($_COOKIE["pr_direction"]) && ($_COOKIE["pr_direction"]=="LTR" || $_COOKIE["pr_direction"]=="RTL")))
	{
		if($theme_options['direction']=='default' && empty($_COOKIE["pr_direction"]))
			return;
		$wp_locale->text_direction = ($theme_options['direction']=='rtl' && ((isset($_COOKIE["pr_direction"]) && $_COOKIE["pr_direction"]!="LTR") || !isset($_COOKIE["pr_direction"])) || (isset($_COOKIE["pr_direction"]) && $_COOKIE["pr_direction"]=="RTL") ? 'rtl' : 'ltr');
	}
}
add_action("after_setup_theme", "pr_theme_direction");
//pressroom get_font_subsets
function pr_ajax_get_font_subsets()
{
	if($_POST["font"]!="")
	{
		$subsets = '';
		$fontExplode = explode(":", $_POST["font"]);
		$subsets_array = pr_get_google_font_subset($fontExplode[0]);
		
		foreach($subsets_array as $subset)
			$subsets .= '<option value="' . esc_attr($subset) . '">' . $subset . '</option>';
		
		echo "pr_start" . $subsets . "pr_end";
	}
	exit();
}
add_action('wp_ajax_pressroom_get_font_subsets', 'pr_ajax_get_font_subsets');

/**
 * Returns array of Google Fonts
 * @return array of Google Fonts
 */
function pr_get_google_fonts()
{
	//get google fonts
	$fontsArray = get_option("pressroom_google_fonts");
	//update if option doesn't exist or it was modified more than 2 weeks ago
	if($fontsArray===FALSE || (time()-$fontsArray->last_update>2*7*24*60*60)) {
		$google_api_url = 'http://quanticalabs.com/.tools/GoogleFont/font.txt';
		$fontsJson = wp_remote_retrieve_body(wp_remote_get($google_api_url, array('sslverify' => false )));
		$fontsArray = json_decode($fontsJson);
		$fontsArray->last_update = time();		
		update_option("pressroom_google_fonts", $fontsArray);
	}
	return $fontsArray;
}

/**
 * Returns array of subsets for provided Google Font
 * @param type $font - Google font
 * @return array of subsets for provided Google Font
 */
function pr_get_google_font_subset($font)
{
	$subsets = array();
	//get google fonts
	$fontsArray = pr_get_google_fonts();		
	$fontsCount = count($fontsArray->items);
	for($i=0; $i<$fontsCount; $i++)
	{
		if($fontsArray->items[$i]->family==$font)
		{
			for($j=0, $max=count($fontsArray->items[$i]->subsets); $j<$max; $j++)
			{
				$subsets[] = $fontsArray->items[$i]->subsets[$j];
			}
			break;
		}
	}
	return $subsets;
}

/**
 * Checks if $var is empty
 * @param type $var - tested value
 * @return bool - return's false if $var is empty
 */
function pr_filter_empty_value($var)
{
	return ($var !== NULL && $var !== FALSE && $var !== '');
}

/**
 * Includes a theme file, supports child themes.
 * 
 * @param string $file - file path relative to theme root directory.
 */
function pr_get_theme_file($file)
{
	if(file_exists($file_path = get_stylesheet_directory() . $file))
        require_once($file_path);
    else
        require_once(get_template_directory() . $file);
}
?>