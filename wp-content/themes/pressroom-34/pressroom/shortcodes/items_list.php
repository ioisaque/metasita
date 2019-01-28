<?php
//items list
function pr_theme_items_list($atts, $content)
{
	extract(shortcode_atts(array(
		"class" => "",
		"top_margin" => "page_margin_top"
	), $atts));
	
	$output = '<ul class="list' . ($class!='' ? ' ' . esc_attr($class) : '') . ($top_margin!="none" ? ' ' . esc_attr($top_margin) : '') . ' clearfix">' . wpb_js_remove_wpautop($content) . '</ul>';
	return $output;
}

//items list
function pr_theme_item($atts, $content)
{
	extract(shortcode_atts(array(
		"icon" => "bullet style_1",
		"class" => "",
		"url" => "",
		"url_target" => "",
		"text_color" => ""
	), $atts));
	
	$output = '<li class="' . ($icon!="" || $class!="" ? ($icon!="" ? esc_attr($icon) . ' ': '') . ($class!="" ? esc_attr($class) . ' ' : '') : '') . 'clearfix"' . ($text_color!='' ? ' style="' . ($text_color!='' ? 'color:' . esc_attr($text_color) . ';' : '') . '"' : '') . '>
			' . '<' . ($url!="" ? 'a href="' . esc_attr($url) . '"' . ($url_target=='new_window' ? ' target="_blank"' : '') : 'span') . ($text_color!='' ? ' style="color: ' . esc_attr($text_color) . ';"' : '') . '>' . do_shortcode($content) . '</' . ($url!="" ? 'a' : 'span') . '>';
	$output .= '</li>';

	return $output;
}

//visual composer
vc_map( array(
	"name" => __("Items list", 'pressroom'),
	"base" => "items_list",
	"class" => "",
	"controls" => "full",
	"show_settings_on_create" => true,
	"icon" => "icon-wpb-layer-items-list",
	"category" => __('Pressroom', 'pressroom'),
	"params" => array(
		/*array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Type", 'pressroom'),
			"param_name" => "type",
			"value" => array(__("Items list", 'pressroom') => 'items', __("Info list", 'pressroom') => 'info', __("Scrolling list", 'pressroom') => 'scrolling', __("Simple list", 'pressroom') => 'simple',)
		),*/
		array(
			"type" => "textarea_html",
			"holder" => "div",
			"class" => "",
			"heading" => __("Content", 'pressroom'),
			"param_name" => "content",
			"value" => ""
		),
		array(
			"type" => "listitem",
			"class" => "",
			"param_name" => "additembutton",
			"value" => "Add list item"
		),
		array(
			"type" => "listitemwindow",
			"class" => "",
			"param_name" => "additemwindow",
			"value" => ""
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Top margin", 'pressroom'),
			"param_name" => "top_margin",
			"value" => array(__("Page (small)", 'pressroom') => "page_margin_top", __("Section (large)", 'pressroom') => "page_margin_top_section", __("None", 'pressroom') => "none")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Extra class name", 'pressroom'),
			"param_name" => "class",
			"value" => ""
		)
	)
));
?>