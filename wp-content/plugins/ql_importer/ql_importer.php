<?php
/*
Plugin Name: Theme Dummy Content Importer
Plugin URI: http://themeforest.net/user/QuanticaLabs/portfolio?ref=QuanticaLabs
Description: Import posts, pages, comments, custom fields, categories, tags and more from a WordPress export file.
Author: QuanticaLabs
Author URI: http://themeforest.net/user/QuanticaLabs/portfolio?ref=QuanticaLabs
Version: 1.1
Text Domain: ql_importer
*/

//translation
function ql_importer_load_textdomain()
{
	load_plugin_textdomain("ql_importer", false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'ql_importer_load_textdomain');
//admin
if(is_admin())
{
	function ql_importer_get_new_widget_name( $widget_name, $widget_index ) 
	{
		$current_sidebars = get_option( 'sidebars_widgets' );
		$all_widget_array = array( );
		foreach ( $current_sidebars as $sidebar => $widgets ) {
			if ( !empty( $widgets ) && is_array( $widgets ) && $sidebar != 'wp_inactive_widgets' ) {
				foreach ( $widgets as $widget ) {
					$all_widget_array[] = $widget;
				}
			}
		}
		while ( in_array( $widget_name . '-' . $widget_index, $all_widget_array ) ) {
			$widget_index++;
		}
		$new_widget_name = $widget_name . '-' . $widget_index;
		return $new_widget_name;
	}
	function ql_importer_download_import_file($file, $themename)
	{	
		if($themename=="cleanmate")
			$url = "http://quanticalabs.com/wptest/cleanmate/files/2017/11/" . $file["name"] . "." . $file["extension"];
		else if($themename=="pressroom")
			$url = "http://quanticalabs.com/wptest/pressroom/files/2015/01/" . $file["name"] . "." . $file["extension"];
		$attachment = get_page_by_title($file["name"], "OBJECT", "attachment");
		if($attachment!=null)
			$id = $attachment->ID;
		else
		{
			$tmp = download_url($url);
			$file_array = array(
				'name' => basename($url),
				'tmp_name' => $tmp
			);

			// Check for download errors
			if(is_wp_error($tmp)) 
			{
				@unlink($file_array['tmp_name']);
				return $tmp;
			}

			$id = media_handle_sideload($file_array, 0);
			// Check for handle sideload errors.
			if(is_wp_error($id))
			{
				@unlink($file_array['tmp_name']);
				return $id;
			}
		}
		return get_attached_file($id);
	}
	function ql_importer_import_shop_dummy()
	{
		ob_start();
		$result = array("info" => "");
		//import dummy content
		$fetch_attachments = true;
		$file = ql_importer_download_import_file(array(
			"name" => "dummy-shop.xml",
			"extension" => "gz"
		), $_POST["themename"]);
		if(!is_wp_error($file))
			require_once('importer.php');
		else
			$result["info"] = __("Import file dummy-shop.xml.gz not found! Please upload import file manually into Media library. You can find this file in 'dummy content files' directory inside zip archive downloaded from ThemeForest.", 'ql_importer');
		if($result["info"]=="")
			$result["info"] = __("dummy-shop.xml file content has been imported successfully!", 'ql_importer');
		$system_message = ob_get_clean();
		$result["system_message"] = $system_message;
		echo "dummy_import_start" . json_encode($result) . "dummy_import_end";
		exit();
	}
	add_action('wp_ajax_ql_importer_import_shop_dummy', 'ql_importer_import_shop_dummy');
	function ql_importer_import_dummy()
	{
		ob_start();
		$result = array("info" => "");
		$import_templates_sidebars = $_POST["import_templates_sidebars"];
		if($import_templates_sidebars)
		{
			echo "dummy_import_start" . json_encode($result) . "dummy_import_end";
			exit();
		}
		//import dummy content
		$fetch_attachments = true;
		$file = ql_importer_download_import_file(array(
			"name" => "dummy-images.xml",
			"extension" => "gz"
		), $_POST["themename"]);
		if(!is_wp_error($file))
			require_once('importer.php');
		else
			$result["info"] = __("Import file dummy-images.xml.gz not found! Please upload import file manually into Media library. You can find this file in 'dummy content files' directory inside zip archive downloaded from ThemeForest.", 'ql_importer');
		if($result["info"]=="")
			$result["info"] = __("dummy-images.xml file content has been imported successfully!", 'ql_importer');
		$system_message = ob_get_clean();
		$result["system_message"] = $system_message;
		echo "dummy_import_start" . json_encode($result) . "dummy_import_end";
		exit();
	}
	add_action('wp_ajax_ql_importer_import_dummy', 'ql_importer_import_dummy');

	function ql_importer_import_dummy2()
	{
		ob_start();
		$creds = request_filesystem_credentials(admin_url('themes.php?page=ThemeOptions'), '', false, false, array());
		if(!WP_Filesystem($creds))
		{
			$result["info"] .= __("Filesystem initialization error.", 'ql_importer');
			echo "dummy_import_start" . json_encode($result) . "dummy_import_end";
			exit();
		}	
		global $wp_filesystem;
		$themename = $_POST["themename"];
		$theme_prefix = $themename;
		if($themename=="cleanmate")
			$theme_prefix = "cm";
		else if($themename=="pressroom")
			$theme_prefix = "pressroom";
		$result = array("info" => "");
		//import dummy content
		$import_templates_sidebars = (int)$_POST["import_templates_sidebars"];
		$fetch_attachments = false;
		$file = ql_importer_download_import_file(array(
			"name" => "dummy-data" . ($import_templates_sidebars ? '-templates-sidebars' : '') . ".xml",
			"extension" => "gz"
		), $themename);
		if(!is_wp_error($file))
			require_once('importer.php');
		else
		{
			$result["info"] .= sprintf(__("Import file: dummy-data%s.xml.gz not found! Please upload import file manually into Media library. You can find this file in 'dummy content files' directory inside zip archive downloaded from ThemeForest.", 'ql_importer'), ($import_templates_sidebars ? '-templates-sidebars' : ''));
			echo "dummy_import_start" . json_encode($result) . "dummy_import_end";
			exit();
		}
		if($import_templates_sidebars)
		{
			$result["info"] .= __("Template pages and sidebars has been imported successfully!", 'ql_importer');
			echo "dummy_import_start" . json_encode($result) . "dummy_import_end";
			exit();
		}
		//set menu
		$locations = get_theme_mod('nav_menu_locations');
		$menus = wp_get_nav_menus();
		foreach($menus as $menu)
			$locations[$menu->slug] = $menu->term_id;
		
		set_theme_mod('nav_menu_locations', $locations);
		//set front page
		$home = get_page_by_title('HOME');
		update_option('page_on_front', $home->ID);
		update_option('show_on_front', 'page');
		//set blog description
		if($themename=="cleanmate")
			update_option("blogdescription", "Cleaning Company Maid Gardening Theme");
		else if($themename=="pressroom")
			update_option("blogdescription", "News and Magazine Theme");
		//set top and menu sidebars
		$theme_sidebars_array = get_posts(array(
			'post_type' => $theme_prefix . '_sidebars',
			'posts_per_page' => '-1',
			'nopaging' => true,
			'post_status' => 'publish',
			'orderby' => 'menu_order',
			'order' => 'ASC'
		));
		$theme_options = get_option($theme_prefix . "_options", true);
		$needed_id = 0;
		foreach($theme_sidebars_array as $theme_sidebar)
		{	
			if($theme_sidebar->post_title=="Sidebar Header")
			{
				$needed_id = $theme_sidebar->ID;
				break;
			}
		}
		$theme_options["header_top_sidebar"] = $needed_id;
		if($themename=="cleanmate")
		{
			$needed_id = 0;
			foreach($theme_sidebars_array as $theme_sidebar)
			{	
				if($theme_sidebar->post_title=="Sidebar Menu")
				{
					$needed_id = $theme_sidebar->ID;
					break;
				}
			}
			$theme_options["header_menu_sidebar"] = $needed_id;
		}
		else if($themename=="pressroom")
		{
			$needed_id = 0;
			foreach($theme_sidebars_array as $theme_sidebar)
			{	
				if($theme_sidebar->post_title=="Sidebar Header Right")
				{
					$needed_id = $theme_sidebar->ID;
					break;
				}
			}
			$theme_options["header_top_right_sidebar"] = $needed_id;
		}
		update_option($theme_prefix . "_options", $theme_options);
		
		if($themename=="cleanmate")
		{
			//slider import
			$Slider=new RevSlider();
			$Slider->importSliderFromPost(true,true,ql_importer_download_import_file(array(
				"name" => "home",
				"extension" => "zip"
			), $themename));
			$Slider->importSliderFromPost(true,true,ql_importer_download_import_file(array(
				"name" => "home-2",
				"extension" => "zip"
			), $themename));
		}
		
		//widget import
		$response = array(
			'what' => 'widget_import_export',
			'action' => 'import_submit'
		);

		$widgets = isset( $_POST['widgets'] ) ? $_POST['widgets'] : false;
		$json_file = ql_importer_download_import_file(array(
			"name" => "widget_data",
			"extension" => "json"
		), $themename);
		if(!is_wp_error($json_file))
		{
			$json_data = $wp_filesystem->get_contents($json_file);
			$json_data = json_decode( $json_data, true );
			$sidebars_data = $json_data[0];
			$widget_data = $json_data[1];
			$current_sidebars = get_option( 'sidebars_widgets' );
			//remove inactive widgets
			$current_sidebars['wp_inactive_widgets'] = array();
			update_option('sidebars_widgets', $current_sidebars);
			$new_widgets = array( );
			foreach ( $sidebars_data as $import_sidebar => $import_widgets ) :

				foreach ( $import_widgets as $import_widget ) :
					//if the sidebar exists
					//if ( isset( $current_sidebars[$import_sidebar] ) ) :
						$title = trim( substr( $import_widget, 0, strrpos( $import_widget, '-' ) ) );
						$index = trim( substr( $import_widget, strrpos( $import_widget, '-' ) + 1 ) );
						$current_widget_data = get_option( 'widget_' . $title );
						$new_widget_name = ql_importer_get_new_widget_name( $title, $index );
						$new_index = trim( substr( $new_widget_name, strrpos( $new_widget_name, '-' ) + 1 ) );

						if ( !empty( $new_widgets[ $title ] ) && is_array( $new_widgets[$title] ) ) {
							while ( array_key_exists( $new_index, $new_widgets[$title] ) ) {
								$new_index++;
							}
						}
						$current_sidebars[$import_sidebar][] = $title . '-' . $new_index;
						if ( array_key_exists( $title, $new_widgets ) ) {
							$new_widgets[$title][$new_index] = $widget_data[$title][$index];
							$multiwidget = $new_widgets[$title]['_multiwidget'];
							unset( $new_widgets[$title]['_multiwidget'] );
							$new_widgets[$title]['_multiwidget'] = $multiwidget;
						} else {
							$current_widget_data[$new_index] = $widget_data[$title][$index];
							$current_multiwidget = isset($current_widget_data['_multiwidget']) ? $current_widget_data['_multiwidget'] : "";
							$new_multiwidget = isset($widget_data[$title]['_multiwidget']) ? $widget_data[$title]['_multiwidget'] : "";
							$multiwidget = ($current_multiwidget != $new_multiwidget) ? $current_multiwidget : 1;
							unset( $current_widget_data['_multiwidget'] );
							$current_widget_data['_multiwidget'] = $multiwidget;
							$new_widgets[$title] = $current_widget_data;
						}

					//endif;
				endforeach;
			endforeach;
			if ( isset( $new_widgets ) && isset( $current_sidebars ) ) {
				update_option( 'sidebars_widgets', $current_sidebars );

				foreach ( $new_widgets as $title => $content ) {
					$content["_multiwidget"] = 1;
					$content = apply_filters( 'widget_data_import', $content, $title );
					update_option( 'widget_' . $title, $content );
				}

			}
		}
		else
		{
			$result["info"] .= __("Widgets data file not found! Please upload widgets data file manually.", 'ql_importer');
			echo "dummy_import_start" . json_encode($result) . "dummy_import_end";
			exit();
		}
		if($result["info"]=="")
		{
			//set shop page
			$shop = get_page_by_title('Shop');
			update_option('woocommerce_shop_page_id', $shop->ID);
			//set my-account page
			$myaccount = get_page_by_title('My Account');
			update_option('woocommerce_myaccount_page_id', $myaccount->ID);
			//set cart page
			$cart = get_page_by_title('Cart');
			update_option('woocommerce_cart_page_id', $cart->ID);
			//set checkout page
			$checkout = get_page_by_title('Checkout');
			update_option('woocommerce_checkout_page_id', $checkout->ID);
			
			$hide_notice = sanitize_text_field("install");
			$notices = array_diff(get_option('woocommerce_admin_notices', array()), array("install"));
			update_option('woocommerce_admin_notices', $notices);
			do_action('woocommerce_hide_install_notice');
			$result["info"] = sprintf(__("dummy-data%s.xml file content and widgets settings has been imported successfully!", 'ql_importer'), ($import_templates_sidebars ? '-templates-sidebars' : ''));;
			$system_message = ob_get_clean();
			$result["system_message"] = $system_message;
		}
		echo "dummy_import_start" . json_encode($result) . "dummy_import_end";
		exit();
	}
	add_action('wp_ajax_ql_importer_import_dummy2', 'ql_importer_import_dummy2');
}