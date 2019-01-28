<?php
global $pressroom_posts_array;
$pressroom_posts_array = array();
$count_posts = wp_count_posts();
if($count_posts->publish<100)
{
	$pressroom_posts_list = get_posts(array(
		'posts_per_page' => -1,
		'nopaging' => true,
		'orderby' => 'title',
		'order' => 'ASC',
		'post_type' => 'post'
	));
	$pressroom_posts_array[__("All", 'pressroom')] = "-";
	foreach($pressroom_posts_list as $post)
		$pressroom_posts_array[$post->post_title . " (id:" . $post->ID . ")"] = $post->ID;
}

global $pressroom_pages_array;
$pressroom_pages_array = array();
$count_pages = wp_count_posts('page');
if($count_pages->publish<100)
{
	$pages_list = get_posts(array(
		'posts_per_page' => -1,
		'orderby' => 'title',
		'order' => 'ASC',
		'post_type' => 'page'
	));
	$pressroom_pages_array = array();
	$pressroom_pages_array[__("none", 'pressroom')] = "-";
	foreach($pages_list as $single_page)
		$pressroom_pages_array[$single_page->post_title . " (id:" . $single_page->ID . ")"] = $single_page->ID;
}

//slider
pr_get_theme_file("/shortcodes/slider.php");
//blog 1 column
pr_get_theme_file("/shortcodes/blog_1_column.php");
//blog 2 columns
pr_get_theme_file("/shortcodes/blog_2_columns.php");
//blog 3 columns
pr_get_theme_file("/shortcodes/blog_3_columns.php");
//blog big
pr_get_theme_file("/shortcodes/blog_big.php");
//blog medium
pr_get_theme_file("/shortcodes/blog_medium.php");
//blog small
pr_get_theme_file("/shortcodes/blog_small.php");
//post
pr_get_theme_file("/shortcodes/single-post.php");
//comments
pr_get_theme_file("/shortcodes/comments.php");
//items_list
pr_get_theme_file("/shortcodes/items_list.php");
//columns
pr_get_theme_file("/shortcodes/columns.php");
//map
pr_get_theme_file("/shortcodes/map.php");
//accordion
//require_once("accordion.php");
//nested tabs
//require_once("nested_tabs.php");
//post carousel
pr_get_theme_file("/shortcodes/post_carousel.php");
//rank list
pr_get_theme_file("/shortcodes/rank_list.php");
//authors list
pr_get_theme_file("/shortcodes/authors_list.php");
//author single
pr_get_theme_file("/shortcodes/single-author.php");
//top authors
pr_get_theme_file("/shortcodes/top_authors.php");
//authors carousel
pr_get_theme_file("/shortcodes/authors_carousel.php");
//about box
pr_get_theme_file("/shortcodes/about_box.php");
//featured item
pr_get_theme_file("/shortcodes/featured_item.php");
//post grid
pr_get_theme_file("/shortcodes/post_grid.php");
//small slider
pr_get_theme_file("/shortcodes/small_slider.php");
//announcement box
pr_get_theme_file("/shortcodes/announcement_box.php");
//pricing table
if(is_plugin_active('css3_web_pricing_tables_grids/css3_web_pricing_tables_grids.php'))
	pr_get_theme_file("/shortcodes/pricing_table.php");
//search box
pr_get_theme_file("/shortcodes/search_box.php");

//row inner
$attributes = array(
	array(
		"type" => "dropdown",
		"class" => "",
		"heading" => __("Top margin", 'pressroom'),
		"param_name" => "top_margin",
		"value" => array(__("None", 'pressroom') => "none",  __("Page (small)", 'pressroom') => "page_margin_top", __("Section (large)", 'pressroom') => "page_margin_top_section"),
		"description" => __("Select top margin value for your row", "pressroom")
	)
);
vc_add_params('vc_row_inner', $attributes);
//row
vc_map( array(
	'name' => __( 'Row', 'pressroom' ),
	'base' => 'vc_row',
	'is_container' => true,
	'icon' => 'icon-wpb-row',
	'show_settings_on_create' => false,
	'category' => __( 'Content', 'pressroom' ),
	'class' => 'vc_main-sortable-element',
	'description' => __( 'Place content elements inside the row', 'pressroom' ),
	'params' => array(
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Type", 'pressroom'),
			"param_name" => "type",
			"value" => array(__("Default", 'pressroom') => "",  __("Full width", 'pressroom') => "full_width", __("Blog grid container", 'pressroom') => "blog_grid"),
			"description" => __("Select row type", "pressroom")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Top margin", 'pressroom'),
			"param_name" => "top_margin",
			"value" => array(__("None", 'pressroom') => "none",  __("Page (small)", 'pressroom') => "page_margin_top", __("Section (large)", 'pressroom') => "page_margin_top_section"),
			"description" => __("Select top margin value for your row", "pressroom")
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Row stretch', 'pressroom' ),
			'param_name' => 'full_width',
			'value' => array(
				__( 'Default', 'pressroom' ) => '',
				__( 'Stretch row', 'pressroom' ) => 'stretch_row',
				__( 'Stretch row and content', 'pressroom' ) => 'stretch_row_content',
				__( 'Stretch row and content (no paddings)', 'pressroom' ) => 'stretch_row_content_no_spaces',
			),
			'description' => __( 'Select stretching options for row and content (Note: stretched may not work properly if parent container has "overflow: hidden" CSS property).', 'pressroom' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Columns gap', 'pressroom' ),
			'param_name' => 'gap',
			'value' => array(
				'0px' => '0',
				'1px' => '1',
				'2px' => '2',
				'3px' => '3',
				'4px' => '4',
				'5px' => '5',
				'10px' => '10',
				'15px' => '15',
				'20px' => '20',
				'25px' => '25',
				'30px' => '30',
				'35px' => '35',
			),
			'std' => '0',
			'description' => __( 'Select gap between columns in row.', 'pressroom' ),
		),
		array(
			'type' => 'checkbox',
			'heading' => __( 'Full height row?', 'pressroom' ),
			'param_name' => 'full_height',
			'description' => __( 'If checked row will be set to full height.', 'pressroom' ),
			'value' => array( __( 'Yes', 'pressroom' ) => 'yes' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Columns position', 'pressroom' ),
			'param_name' => 'columns_placement',
			'value' => array(
				__( 'Middle', 'pressroom' ) => 'middle',
				__( 'Top', 'pressroom' ) => 'top',
				__( 'Bottom', 'pressroom' ) => 'bottom',
				__( 'Stretch', 'pressroom' ) => 'stretch',
			),
			'description' => __( 'Select columns position within row.', 'pressroom' ),
			'dependency' => array(
				'element' => 'full_height',
				'not_empty' => true,
			),
		),
		array(
			'type' => 'checkbox',
			'heading' => __( 'Equal height', 'pressroom' ),
			'param_name' => 'equal_height',
			'description' => __( 'If checked columns will be set to equal height.', 'pressroom' ),
			'value' => array( __( 'Yes', 'pressroom' ) => 'yes' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Content position', 'pressroom' ),
			'param_name' => 'content_placement',
			'value' => array(
				__( 'Default', 'pressroom' ) => '',
				__( 'Top', 'pressroom' ) => 'top',
				__( 'Middle', 'pressroom' ) => 'middle',
				__( 'Bottom', 'pressroom' ) => 'bottom',
			),
			'description' => __( 'Select content position within columns.', 'pressroom' ),
		),
		array(
			'type' => 'checkbox',
			'heading' => __( 'Use video background?', 'pressroom' ),
			'param_name' => 'video_bg',
			'description' => __( 'If checked, video will be used as row background.', 'pressroom' ),
			'value' => array( __( 'Yes', 'pressroom' ) => 'yes' ),
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'YouTube link', 'pressroom' ),
			'param_name' => 'video_bg_url',
			'value' => 'https://www.youtube.com/watch?v=lMJXxhRFO1k',
			// default video url
			'description' => __( 'Add YouTube link.', 'pressroom' ),
			'dependency' => array(
				'element' => 'video_bg',
				'not_empty' => true,
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Parallax', 'pressroom' ),
			'param_name' => 'video_bg_parallax',
			'value' => array(
				__( 'None', 'pressroom' ) => '',
				__( 'Simple', 'pressroom' ) => 'content-moving',
				__( 'With fade', 'pressroom' ) => 'content-moving-fade',
			),
			'description' => __( 'Add parallax type background for row.', 'pressroom' ),
			'dependency' => array(
				'element' => 'video_bg',
				'not_empty' => true,
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Parallax', 'pressroom' ),
			'param_name' => 'parallax',
			'value' => array(
				__( 'None', 'pressroom' ) => '',
				__( 'Simple', 'pressroom' ) => 'content-moving',
				__( 'With fade', 'pressroom' ) => 'content-moving-fade',
			),
			'description' => __( 'Add parallax type background for row (Note: If no image is specified, parallax will use background image from Design Options).', 'pressroom' ),
			'dependency' => array(
				'element' => 'video_bg',
				'is_empty' => true,
			),
		),
		array(
			'type' => 'attach_image',
			'heading' => __( 'Image', 'pressroom' ),
			'param_name' => 'parallax_image',
			'value' => '',
			'description' => __( 'Select image from media library.', 'pressroom' ),
			'dependency' => array(
				'element' => 'parallax',
				'not_empty' => true,
			),
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Parallax speed', 'pressroom' ),
			'param_name' => 'parallax_speed_video',
			'value' => '1.5',
			'description' => __( 'Enter parallax speed ratio (Note: Default value is 1.5, min value is 1)', 'pressroom' ),
			'dependency' => array(
				'element' => 'video_bg_parallax',
				'not_empty' => true,
			),
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Parallax speed', 'pressroom' ),
			'param_name' => 'parallax_speed_bg',
			'value' => '1.5',
			'description' => __( 'Enter parallax speed ratio (Note: Default value is 1.5, min value is 1)', 'pressroom' ),
			'dependency' => array(
				'element' => 'parallax',
				'not_empty' => true,
			),
		),
		vc_map_add_css_animation( false ),
		array(
			'type' => 'el_id',
			'heading' => __( 'Row ID', 'pressroom' ),
			'param_name' => 'el_id',
			'description' => sprintf( __( 'Enter row ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">w3c specification</a>).', 'pressroom' ), 'http://www.w3schools.com/tags/att_global_id.asp' ),
		),
		array(
			'type' => 'checkbox',
			'heading' => __( 'Disable row', 'pressroom' ),
			'param_name' => 'disable_element',
			// Inner param name.
			'description' => __( 'If checked the row won\'t be visible on the public side of your website. You can switch it back any time.', 'pressroom' ),
			'value' => array( __( 'Yes', 'pressroom' ) => 'yes' ),
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'pressroom' ),
			'param_name' => 'el_class',
			'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'pressroom' ),
		),
		array(
			'type' => 'css_editor',
			'heading' => __( 'CSS box', 'pressroom' ),
			'param_name' => 'css',
			'group' => __( 'Design Options', 'pressroom' ),
		)
	),
	'js_view' => 'VcRowView'
) );

//column
$vc_column_width_list = array(
	__('1 column - 1/12', 'pressroom') => '1/12',
	__('2 columns - 1/6', 'pressroom') => '1/6',
	__('3 columns - 1/4', 'pressroom') => '1/4',
	__('4 columns - 1/3', 'pressroom') => '1/3',
	__('5 columns - 5/12', 'pressroom') => '5/12',
	__('6 columns - 1/2', 'pressroom') => '1/2',
	__('7 columns - 7/12', 'pressroom') => '7/12',
	__('8 columns - 2/3', 'pressroom') => '2/3',
	__('9 columns - 3/4', 'pressroom') => '3/4',
	__('10 columns - 5/6', 'pressroom') => '5/6',
	__('11 columns - 11/12', 'pressroom') => '11/12',
	__('12 columns - 1/1', 'pressroom') => '1/1'
);
vc_map( array(
	'name' => __( 'Column', 'pressroom' ),
	'base' => 'vc_column',
	'icon' => 'icon-wpb-row',
	'is_container' => true,
	//"as_parent" => array('except' => 'vc_row'),
	'content_element' => false,
	'description' => __( 'Place content elements inside the column', 'pressroom' ),
	'params' => array(
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Column type", 'pressroom'),
			"param_name" => "type",
			"value" => array(__("Default", 'pressroom') => "",  __("Smart (sticky)", 'pressroom') => "pr_smart_column"),
			"dependency" => Array('element' => "width", 'value' => array_map('strval', array_values((array_slice($vc_column_width_list, 0, -1)))))
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Top margin", 'pressroom'),
			"param_name" => "top_margin",
			"value" => array(__("None", 'pressroom') => "none",  __("Page (small)", 'pressroom') => "page_margin_top", __("Section (large)", 'pressroom') => "page_margin_top_section"),
			"description" => __("Select top margin value for your column", "pressroom")
		),
		array(
			'type' => 'checkbox',
			'heading' => __( 'Use video background?', 'pressroom' ),
			'param_name' => 'video_bg',
			'description' => __( 'If checked, video will be used as row background.', 'pressroom' ),
			'value' => array( __( 'Yes', 'pressroom' ) => 'yes' ),
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'YouTube link', 'pressroom' ),
			'param_name' => 'video_bg_url',
			'value' => 'https://www.youtube.com/watch?v=lMJXxhRFO1k',
			// default video url
			'description' => __( 'Add YouTube link.', 'pressroom' ),
			'dependency' => array(
				'element' => 'video_bg',
				'not_empty' => true,
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Parallax', 'pressroom' ),
			'param_name' => 'video_bg_parallax',
			'value' => array(
				__( 'None', 'pressroom' ) => '',
				__( 'Simple', 'pressroom' ) => 'content-moving',
				__( 'With fade', 'pressroom' ) => 'content-moving-fade',
			),
			'description' => __( 'Add parallax type background for row.', 'pressroom' ),
			'dependency' => array(
				'element' => 'video_bg',
				'not_empty' => true,
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Parallax', 'pressroom' ),
			'param_name' => 'parallax',
			'value' => array(
				__( 'None', 'pressroom' ) => '',
				__( 'Simple', 'pressroom' ) => 'content-moving',
				__( 'With fade', 'pressroom' ) => 'content-moving-fade',
			),
			'description' => __( 'Add parallax type background for row (Note: If no image is specified, parallax will use background image from Design Options).', 'pressroom' ),
			'dependency' => array(
				'element' => 'video_bg',
				'is_empty' => true,
			),
		),
		array(
			'type' => 'attach_image',
			'heading' => __( 'Image', 'pressroom' ),
			'param_name' => 'parallax_image',
			'value' => '',
			'description' => __( 'Select image from media library.', 'pressroom' ),
			'dependency' => array(
				'element' => 'parallax',
				'not_empty' => true,
			),
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Parallax speed', 'pressroom' ),
			'param_name' => 'parallax_speed_video',
			'value' => '1.5',
			'description' => __( 'Enter parallax speed ratio (Note: Default value is 1.5, min value is 1)', 'pressroom' ),
			'dependency' => array(
				'element' => 'video_bg_parallax',
				'not_empty' => true,
			),
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Parallax speed', 'pressroom' ),
			'param_name' => 'parallax_speed_bg',
			'value' => '1.5',
			'description' => __( 'Enter parallax speed ratio (Note: Default value is 1.5, min value is 1)', 'pressroom' ),
			'dependency' => array(
				'element' => 'parallax',
				'not_empty' => true,
			),
		),
		vc_map_add_css_animation( false ),
		array(
			'type' => 'el_id',
			'heading' => __( 'Element ID', 'pressroom' ),
			'param_name' => 'el_id',
			'description' => sprintf( __( 'Enter element ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">w3c specification</a>).', 'pressroom' ), 'http://www.w3schools.com/tags/att_global_id.asp' ),
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'pressroom' ),
			'param_name' => 'el_class',
			'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'pressroom' ),
		),
		array(
			'type' => 'css_editor',
			'heading' => __( 'CSS box', 'pressroom' ),
			'param_name' => 'css',
			'group' => __( 'Design Options', 'pressroom' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Width', 'pressroom' ),
			'param_name' => 'width',
			'value' => $vc_column_width_list,
			'group' => __( 'Responsive Options', 'pressroom' ),
			'description' => __( 'Select column width.', 'pressroom' ),
			'std' => '1/1',
		),
		array(
			'type' => 'column_offset',
			'heading' => __( 'Responsiveness', 'pressroom' ),
			'param_name' => 'offset',
			'group' => __( 'Responsive Options', 'pressroom' ),
			'description' => __( 'Adjust column for different screen sizes. Control width, offset and visibility settings.', 'pressroom' ),
		)
	),
	'js_view' => 'VcColumnView'
) );

//widgetised sidebar
vc_map( array(
	'name' => __( 'Widgetised Sidebar', 'pressroom' ),
	'base' => 'vc_widget_sidebar',
	'class' => 'wpb_widget_sidebar_widget',
	'icon' => 'icon-wpb-layout_sidebar',
	'category' => __( 'Structure', 'pressroom' ),
	'description' => __( 'WordPress widgetised sidebar', 'pressroom' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Widget title', 'pressroom' ),
			'param_name' => 'title',
			'description' => __( 'Enter text used as widget title (Note: located above content element).', 'pressroom' )
		),
		array(
			'type' => 'widgetised_sidebars',
			'heading' => __( 'Sidebar', 'pressroom' ),
			'param_name' => 'sidebar_id',
			'description' => __( 'Select widget area to display.', 'pressroom' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'pressroom' ),
			'param_name' => 'el_class',
			'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'pressroom' )
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Top margin", 'pressroom'),
			"param_name" => "top_margin",
			"value" => array(__("None", 'pressroom') => "none",  __("Page (small)", 'pressroom') => "page_margin_top", __("Section (large)", 'pressroom') => "page_margin_top_section"),
			"description" => __("Select top margin value for your sidebar", "pressroom")
		)
	)
) );

//separator
function pr_theme_vc_separator_pr($atts)
{
	extract(shortcode_atts(array(
		"style" => "default",
		"el_class" => "",
		"top_margin" => "none"
	), $atts));
	if($style=="default")
		$output = '<hr class="divider' . ($top_margin!="none" ? ' ' . esc_attr($top_margin) : '') . ($el_class!="" ? ' ' . esc_attr($el_class) : '') . '">';
	else
		$output = '<div class="divider_block clearfix' . ($top_margin!="none" ? ' ' . esc_attr($top_margin) : '') . ($el_class!="" ? ' ' . esc_attr($el_class) : '') . '"><hr class="divider first"><hr class="divider subheader_arrow"><hr class="divider last"></div>';
	return $output;
}
/* Separator (Divider)
---------------------------------------------------------- */
vc_map( array(
	'name' => __( 'Separator', 'pressroom' ),
	'base' => 'vc_separator_pr',
	'icon' => 'icon-wpb-ui-separator',
	'show_settings_on_create' => true,
	'category' => __( 'Content', 'pressroom' ),
	'description' => __( 'Horizontal separator line', 'pressroom' ),
	'params' => array(
		array(
			'type' => 'dropdown',
			'heading' => __( 'Style', 'pressroom' ),
			'param_name' => 'style',
			'value' => array(__("Default", 'pressroom') => "default", __("With gap", 'pressroom') => "gap"),
			'description' => __( 'Separator style.', 'pressroom' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'pressroom' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'pressroom' )
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Top margin", 'pressroom'),
			"param_name" => "top_margin",
			"value" => array(__("None", 'pressroom') => "none", __("Page (small)", 'pressroom') => "page_margin_top", __("Section (large)", 'pressroom') => "page_margin_top_section")
		)
	)
) );

//box_header
function pr_theme_box_header($atts)
{
	extract(shortcode_atts(array(
		"title" => "Sample Header",
		"type" => "h4",
		"class" => "",
		"bottom_border" => 1,
		"top_margin" => "none"
	), $atts));
	if(strpos($title, "{CUR_AUTHOR}")!==false)
	{
		$author = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));
		$title = str_replace("{CUR_AUTHOR}", $author->display_name, $title);
	}
	return '<' . esc_attr($type) . ' class="box_header' . ($class!="" ? ' ' . esc_attr($class) : '') . ($top_margin!="none" ? ' ' . esc_attr($top_margin) : '') . '">' . do_shortcode($title) . '</' . esc_attr($type) . '>';
}

//visual composer
vc_map( array(
	"name" => __("Box header", 'pressroom'),
	"base" => "box_header",
	"class" => "",
	"controls" => "full",
	"show_settings_on_create" => true,
	"icon" => "icon-wpb-layer-box-header",
	"category" => __('Pressroom', 'pressroom'),
	"params" => array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Title", 'pressroom'),
			"param_name" => "title",
			"value" => "Sample Header"
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Type", 'pressroom'),
			"param_name" => "type",
			"value" => array(__("H4", 'pressroom') => "h4",  __("H1", 'pressroom') => "h1", __("H2", 'pressroom') => "h2", __("H3", 'pressroom') => "h3", __("H5", 'pressroom') => "h5")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Bottom border", 'pressroom'),
			"param_name" => "bottom_border",
			"value" => array(__("yes", 'pressroom') => 1,  __("no", 'pressroom') => 0)
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Extra class name", 'pressroom'),
			"param_name" => "class",
			"value" => ""
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Top margin", 'pressroom'),
			"param_name" => "top_margin",
			"value" => array(__("None", 'pressroom') => "none", __("Page (small)", 'pressroom') => "page_margin_top", __("Section (large)", 'pressroom') => "page_margin_top_section")
		)
	)
));

//dropcap
function pr_theme_dropcap($atts, $content)
{
	extract(shortcode_atts(array(
		"id" => "",
		"label" => "1",
		"label_background_color" => "#3156a3",
		"custom_label_background_color" => "",
		"label_color" => "",
		"content_text_color" => "",
		"class" => "",
		"top_margin" => "none"
	), $atts));
	
	$label_background_color = ($custom_label_background_color!="" ? $custom_label_background_color : $label_background_color);
	return ($content_text_color!="" && $id!="" ? '<style type="text/css">#' . $id . ' p{color:' . $content_text_color . ';}</style>': '') . '<div' . ($id!="" ? ' id="' . esc_attr($id) . '"' : '') . ' class="dropcap' . ($top_margin!="none" ? ' ' . esc_attr($top_margin) : '') . ($class!="" ? ' '. esc_attr($class) : '') . '"><div class="dropcap_label"' . ($label_background_color!="" ? ' style="background-color:' . esc_attr($label_background_color) . ';"' : '') . '><h3' . ($label_color!="" ? ' style="color:' . esc_attr($label_color) . ';"' : '') . '>' . $label . '</h3></div>' . wpb_js_remove_wpautop($content) . '</div>';
}

//visual composer
$pr_colors_arr = array(__("Dark blue", "pressroom") => "#3156a3", __("Blue", "pressroom") => "#0384ce", __("Light blue", "pressroom") => "#42b3e5", __("Black", "pressroom") => "#000000", __("Gray", "pressroom") => "#AAAAAA", __("Dark gray", "pressroom") => "#444444", __("Light gray", "pressroom") => "#CCCCCC", __("Green", "pressroom") => "#43a140", __("Dark green", "pressroom") => "#008238", __("Light green", "pressroom") => "#7cba3d", __("Orange", "pressroom") => "#f17800", __("Dark orange", "pressroom") => "#cb451b", __("Light orange", "pressroom") => "#ffa800", __("Red", "pressroom") => "#db5237", __("Dark red", "pressroom") => "#c03427", __("Light red", "pressroom") => "#f37548", __("Turquoise", "pressroom") => "#0097b5", __("Dark turquoise", "pressroom") => "#006688", __("Light turquoise", "pressroom") => "#00b6cc", __("Violet", "pressroom") => "#6969b3", __("Dark violet", "pressroom") => "#3e4c94", __("Light violet", "pressroom") => "#9187c4", __("White", "pressroom") => "#FFFFFF", __("Yellow", "pressroom") => "#fec110");
vc_map( array(
	"name" => __("Dropcap text", 'pressroom'),
	"base" => "dropcap",
	"class" => "",
	"controls" => "full",
	"show_settings_on_create" => true,
	"icon" => "icon-wpb-layer-dropcap",
	"category" => __('Pressroom', 'pressroom'),
	"params" => array(
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Id", 'pressroom'),
			"param_name" => "id",
			"value" => "",
			"description" => __("Please provide unique id for each dropcap on the same page/post if you would like to have custom content color for each one", 'pressroom')
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Label", 'pressroom'),
			"param_name" => "label",
			"value" => "1"
		),
		array(
			"type" => "textarea_html",
			"holder" => "div",
			"class" => "",
			"heading" => __("Content", 'pressroom'),
			"param_name" => "content",
			"value" => ""
		),
		array(
            "type" => "dropdown",
            "heading" => __("Label background color", "pressroom"),
            "param_name" => "label_background_color",
            "value" => $pr_colors_arr,
            "description" => __("Button color.", "pressroom")
        ),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("or pick custom label background color", 'pressroom'),
			"param_name" => "custom_label_background_color",
			"value" => ""
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("Label text color", 'pressroom'),
			"param_name" => "label_color",
			"value" => ""
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("Content text color", 'pressroom'),
			"param_name" => "content_text_color",
			"value" => "",
			"description" => __("If you would like to use 'Content text color', you need to fill 'Id' field", 'pressroom')
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Extra class name", 'pressroom'),
			"param_name" => "class",
			"value" => ""
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Top margin", 'pressroom'),
			"param_name" => "top_margin",
			"value" => array(__("None", 'pressroom') => "none", __("Page (small)", 'pressroom') => "page_margin_top", __("Section (large)", 'pressroom') => "page_margin_top_section")
		)
	)
));

//read more
function pr_theme_read_more_button($atts)
{
	extract(shortcode_atts(array(
		"url" => "blog",
		"title" => __("LEIA MAIS", 'pressroom'),
		"top_margin" => "none"
	), $atts));
	return '<a class="more' . ($top_margin!="none" ? ' ' . esc_attr($top_margin) : '') . '" href="' . esc_url($url) . '" title="' . esc_attr($title) . '">' . $title . '</a>';
}

//visual composer
vc_map( array(
	"name" => __("Read more button", 'pressroom'),
	"base" => "read_more_button",
	"class" => "",
	"controls" => "full",
	"show_settings_on_create" => true,
	"icon" => "icon-wpb-ui-button",
	"category" => __('Pressroom', 'pressroom'),
	"params" => array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Title", 'pressroom'),
			"param_name" => "title",
			"value" => __("LEIA MAIS", 'pressroom')
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Url", 'pressroom'),
			"param_name" => "url",
			"value" => "blog"
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Top margin", 'pressroom'),
			"param_name" => "top_margin",
			"value" => array(__("None", 'pressroom') => "none", __("Page (small)", 'pressroom') => "page_margin_top", __("Section (large)", 'pressroom') => "page_margin_top_section")
		)
	)
));

//scroll top
function pr_theme_scroll_top($atts, $content)
{
	extract(shortcode_atts(array(
		"title" => "Scroll to top",
		"label" => "Top"
	), $atts));
	
	return '<a class="scroll_top" href="#top" title="' . esc_attr($title) . '">' . esc_attr($label) . '</a>';
}
?>