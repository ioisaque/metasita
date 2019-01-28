<?php
//columns
function pr_theme_columns($atts, $content)
{	
	extract(shortcode_atts(array(
		"class" => ""
	), $atts));
	return '<div class="columns' . ($class!='' ? ' ' . esc_attr($class) : '') . '">' . do_shortcode($content) . '</div>';
}

//column left
function pr_theme_column_left($atts, $content)
{
	return '<div class="column_left">' . do_shortcode($content) . '</div>';
}

//column right
function pr_theme_column_right($atts, $content)
{
	return '<div class="column_right">' . do_shortcode($content) . '</div>';
}
?>
