<?php
function pr_theme_announcement_box_shortcode($atts)
{
	extract(shortcode_atts(array(
		"header" => "",
		"header_expose" => "",
		"button_label" => "",
		"button_url" => "#",
		"button_size" => "big",
		/*"button_color" => "#ED1C24",
		"button_custom_color" => "",
		"button_hover_color" => "#ED1C24",
		"button_hover_custom_color" => "",
		"button_text_color" => "#FFFFFF",
		"button_hover_text_color" => "#ED1C24",*/
		"top_margin" => "page_margin_top_section"
	), $atts));
	
	/*$button_color = ($button_custom_color!="" ? $button_custom_color : $button_color);
	$button_hover_color = ($button_hover_custom_color!="" ? $button_hover_custom_color : $button_hover_color);*/
	
	$output = '<div class="announcement clearfix' . ($top_margin!="none" ? ' ' . esc_attr($top_margin) : '') . '">
					<ul class="columns no_width">
						<li class="column_left column">
							<div class="vertical_align">
								<div class="vertical_align_cell">
									' . ($header!="" ? '<h2>' . $header . '</h2>' : '')	. ($header_expose!="" ? '<h2 class="expose">' . $header_expose . '</h2>' : '') . '
								</div>
							</div>
						</li>';
	if($button_label!="")
		$output .= '<li class="column_right column">
						<div class="vertical_align">
							<div class="vertical_align_cell">
								<a title="' . esc_attr($button_label) . '" href="' . esc_url($button_url) . '" class="more active' . ' ' . esc_attr($button_size) . '">' . $button_label . '</a>
							</div>
						</div>
					</li>';
	$output .= '</ul>
			</div>';
	//<a' . ($button_color!="" || $button_text_color!="" ? ' style="' . ($button_color!="" ? 'background-color:' . esc_attr($button_color) . ';border-color:' . esc_attr($button_color) . ';' : '') . ($button_text_color!="" ? 'color:' . esc_attr($button_text_color) . ';': '') . '"' : '') . ($button_hover_color!="" || $button_hover_text_color!="" ? ' onMouseOver="' . ($button_hover_color!="" ? 'this.style.backgroundColor=\''.esc_attr($button_hover_color).'\';this.style.borderColor=\''.esc_attr($button_hover_color).'\';' : '' ) . ($button_hover_text_color!="" ? 'this.style.color=\''.esc_attr($button_hover_text_color).'\';' : '' ) . '" onMouseOut="' . ($button_hover_color!="" ? 'this.style.backgroundColor=\''.esc_attr($button_color).'\';this.style.borderColor=\''.esc_attr($button_color).'\';' : '' ) . ($button_hover_text_color!="" ? 'this.style.color=\''.esc_attr($button_text_color).'\';' : '') . '"' : '') . ' title="' . esc_attr($button_label) . '" href="' . esc_attr($button_url) . '" class="more active' . ' ' . esc_attr($button_size) . ($animation!='' ? ' animated_element animation-' . esc_attr($animation) . ((int)$animation_duration>0 && (int)$animation_duration!=600 ? ' duration-' . (int)esc_attr($animation_duration) : '') . ((int)$animation_delay>0 ? ' delay-' . (int)esc_attr($animation_delay) : '') : '') . '">' . $button_label . '</a>
	return $output;
}

//visual composer
function pr_theme_announcement_box_vc_init()
{
	$pr_colors_arr = array(__("Red", "pressroom") => "#ed1c24", __("Dark red", "pressroom") => "#c03427", __("Light red", "pressroom") => "#f37548", __("Dark blue", "pressroom") => "#3156a3", __("Blue", "pressroom") => "#0384ce", __("Light blue", "pressroom") => "#42b3e5", __("Black", "pressroom") => "#000000", __("Gray", "pressroom") => "#AAAAAA", __("Dark gray", "pressroom") => "#444444", __("Light gray", "pressroom") => "#CCCCCC", __("Green", "pressroom") => "#43a140", __("Dark green", "pressroom") => "#008238", __("Light green", "pressroom") => "#7cba3d", __("Orange", "pressroom") => "#f17800", __("Dark orange", "pressroom") => "#cb451b", __("Light orange", "pressroom") => "#ffa800", __("Turquoise", "pressroom") => "#0097b5", __("Dark turquoise", "pressroom") => "#006688", __("Turquoise", "pressroom") => "#00b6cc", __("Light turquoise", "pressroom") => "#00b6cc", __("Violet", "pressroom") => "#6969b3", __("Dark violet", "pressroom") => "#3e4c94", __("Light violet", "pressroom") => "#9187c4", __("White", "pressroom") => "#FFFFFF", __("Yellow", "pressroom") => "#fec110");
	vc_map( array(
		"name" => __("Announcement box", 'pressroom'),
		"base" => "announcement_box",
		"class" => "",
		"controls" => "full",
		"show_settings_on_create" => true,
		"icon" => "icon-wpb-layer-announcement-box",
		"category" => __('Pressroom', 'pressroom'),
		"params" => array(
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __("Header", 'pressroom'),
				"param_name" => "header",
				"value" => ""
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __("Header expose", 'pressroom'),
				"param_name" => "header_expose",
				"value" => ""
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Button label", 'pressroom'),
				"param_name" => "button_label",
				"value" => ""
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Button url", 'pressroom'),
				"param_name" => "button_url",
				"value" => ""
			),
			/*array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Button color", 'pressroom'),
				"param_name" => "button_color",
				"value" => array(__("Dark blue", 'pressroom') => "blue", __("Blue", 'pressroom') => "dark_blue", __("Light", 'pressroom') => "light")
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => __("or pick custom button color", 'pressroom'),
				"param_name" => "custom_button_color",
				"value" => ""
			),*/
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Button size", 'pressroom'),
				"param_name" => "button_size",
				"value" => array(__("Big", 'pressroom') => "big", __("Medium", 'pressroom') => "medium", __("Small", 'pressroom') => "")
			),
		   /* array(
				"type" => "dropdown",
				"heading" => __("Button color", "pressroom"),
				"param_name" => "button_color",
				"value" => $pr_colors_arr
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => __("or pick custom button color", 'pressroom'),
				"param_name" => "button_custom_color",
				"value" => ""
			),
			array(
				"type" => "dropdown",
				"heading" => __("Button hover Color", "pressroom"),
				"param_name" => "button_hover_color",
				"value" => $pr_colors_arr
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => __("or pick custom button hover color", 'pressroom'),
				"param_name" => "button_hover_custom_color",
				"value" => ""
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => __("Button text color", 'pressroom'),
				"param_name" => "button_text_color",
				"value" => "#FFFFFF"
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => __("Button Hover text color", 'pressroom'),
				"param_name" => "button_hover_text_color",
				"value" => "#ED1C24"
			),*/
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Top margin", 'pressroom'),
				"param_name" => "top_margin",
				"value" => array(__("Section (large)", 'pressroom') => "page_margin_top_section", __("Page (small)", 'pressroom') => "page_margin_top", __("None", 'pressroom') => "none")
			)
		)
	));
}
add_action("init", "pr_theme_announcement_box_vc_init");
?>
