<?php
/*
Plugin Name: Pressroom Theme Shortcodes
Plugin URI: http://themeforest.net/user/QuanticaLabs/portfolio?ref=QuanticaLabs
Description: Pressroom Theme Shortcodes plugin
Author: QuanticaLabs
Author URI: http://themeforest.net/user/QuanticaLabs/portfolio?ref=QuanticaLabs
Version: 1.0
*/

function pressroom_shortcodes_vc_init()
{
	//if(function_exists("vc_map"))
	//{
		add_shortcode("pressroom_contact_form", "pr_theme_contact_form_shortcode");
		add_shortcode("about_box", "pr_theme_about_box");
		add_shortcode("accordion", "pr_theme_accordion");
		add_shortcode("accordion_item", "pr_theme_accordion_item");
		add_shortcode("announcement_box", "pr_theme_announcement_box_shortcode");
		add_shortcode("pr_authors_carousel", "pr_theme_authors_carousel_shortcode");
		add_shortcode("pr_authors_list", "pr_theme_authors_list_shortcode");
		add_shortcode("blog_1_column", "pr_theme_blog_1_column");
		add_shortcode("blog_2_columns", "pr_theme_blog_2_columns");
		add_shortcode("blog_3_columns", "pr_theme_blog_3_columns");
		add_shortcode("blog_big", "pr_theme_blog_big");
		add_shortcode("blog_medium", "pr_theme_blog_medium");
		add_shortcode("blog_small", "pr_theme_blog_small");
		add_shortcode("columns", "pr_theme_columns");
		add_shortcode("column_left", "pr_theme_column_left");
		add_shortcode("column_right", "pr_theme_column_right");
		add_shortcode("comments", "pr_theme_comments");
		add_shortcode("featured_item", "pr_theme_featured_item");
		add_shortcode("items_list", "pr_theme_items_list");
		add_shortcode("item", "pr_theme_item");
		add_shortcode("pressroom_map", "pr_theme_map_shortcode");
		add_shortcode("pr_post_carousel", "pr_theme_post_carousel_shortcode");
		add_shortcode("pr_post_grid", "pr_theme_post_grid_shortcode");
		add_shortcode("pr_rank_list", "pr_theme_rank_list_shortcode");
		add_shortcode("pr_search_box", "pr_theme_search_box_shortcode");
		add_shortcode("vc_separator_pr", "pr_theme_vc_separator_pr");
		add_shortcode("box_header", "pr_theme_box_header");
		add_shortcode("dropcap", "pr_theme_dropcap");
		add_shortcode("read_more_button", "pr_theme_read_more_button");
		add_shortcode("scroll_top", "pr_theme_scroll_top");
		add_shortcode("single_author", "pr_theme_single_author");
		add_shortcode("single_post", "pr_theme_single_post");
		add_shortcode("slider", "pr_theme_slider");
		add_shortcode("small_slider", "pr_theme_small_slider_shortcode");
		add_shortcode("tabs", "pr_theme_tabs");
		add_shortcode("tabs_navigation", "pr_theme_tabs_navigation");
		add_shortcode("tab", "pr_theme_tab");
		add_shortcode("tab_content", "pr_theme_tab_content");
		add_shortcode("pr_top_authors", "pr_theme_top_authors_shortcode");
	//}
}
add_action("init", "pressroom_shortcodes_vc_init");
?>