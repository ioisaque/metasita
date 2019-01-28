<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<?php global $theme_options; ?>
	<head>
		<!--meta-->
		<meta http-equiv="content-type" content="text/html; charset=<?php esc_attr(bloginfo("charset")); ?>" />
		<meta name="generator" content="WordPress <?php bloginfo("version"); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.2" />
		<meta name="description" content="<?php bloginfo('description'); ?>" />
		<meta name="format-detection" content="telephone=no" />
		<!--style-->
		<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo("rss2_url"); ?>" />
		<link rel="pingback" href="<?php bloginfo("pingback_url"); ?>" />
		<?php
		if(!function_exists('has_site_icon') || !has_site_icon())
		{
		?>
		<link rel="shortcut icon" href="<?php echo (empty($theme_options["favicon_url"]) ? esc_url(get_template_directory_uri() . "/images/favicon.ico") : esc_url($theme_options["favicon_url"])); ?>" />
		<?php
		}
		wp_head();
		$color_skin = (isset($_COOKIE['pr_color_skin']) ? $_COOKIE['pr_color_skin'] : $theme_options["color_scheme"]);
		if($color_skin!="high_contrast")
			pr_get_theme_file("/custom_colors.php");
		if(!empty($theme_options['ga_tracking_code']))
		{				
			if(strpos($theme_options['ga_tracking_code'],'<script') !== false)					
				echo $theme_options['ga_tracking_code'];
			else
				echo "<script type='text/javascript'>" . $theme_options['ga_tracking_code'] . "</script>";
		}
		?>
	</head>
	<?php
		$image_overlay = ((!isset($_COOKIE['pr_image_overlay']) && $theme_options['layout_image_overlay']=='overlay') || ((isset($_COOKIE['pr_image_overlay']) && $_COOKIE['pr_image_overlay']=='overlay') || (!isset($_COOKIE['pr_image_overlay']) && $theme_options['layout_image_overlay']=='')) ? ' overlay' : '');
		$layout_style_class = (isset($_COOKIE['pr_layout']) && $_COOKIE['pr_layout']=="boxed" ? (isset($_COOKIE['pr_layout_style']) && $_COOKIE['pr_layout_style']!="" ? $_COOKIE['pr_layout_style'] . esc_attr($image_overlay) : 'image_1' . esc_attr($image_overlay)) : (isset($theme_options['layout']) && $theme_options['layout']=="boxed" ? (isset($theme_options['layout_style']) && $theme_options['layout_style']!="" ? esc_attr($theme_options['layout_style']) . (substr($theme_options['layout_style'], 0, 5)=="image" && isset($theme_options['layout_image_overlay']) && $theme_options['layout_image_overlay']!="0" ? esc_attr($image_overlay) : '') : 'image_1' . esc_attr($image_overlay)) : ''));
	?>
	<body <?php body_class(($layout_style_class!="color_preview" ? $layout_style_class : "")); ?>>
		<div class="site_container<?php echo (isset($_COOKIE['pr_layout']) ? ($_COOKIE['pr_layout']=="boxed" ? ' boxed' : '') : ($theme_options['layout']=="boxed" ? ' boxed' : '')); ?>">
			<?php
			if($theme_options["header_top_sidebar"]!="")
			{
				$header_top_bar_container = (isset($color_skin) && $color_skin=='dark' ? ' style_4' : ($color_skin=='high_contrast' ? ' style_5 border' : ''));
				if(isset($theme_options["header_top_bar_container"]) && $theme_options["header_top_bar_container"]!="")
					$header_top_bar_container = $theme_options["header_top_bar_container"];
				?>
				<div class="header_top_bar_container clearfix<?php echo (isset($_COOKIE['pr_header_top_bar_container']) && $_COOKIE['pr_header_top_bar_container']!="" ? ' ' . esc_attr($_COOKIE['pr_header_top_bar_container']) : ($header_top_bar_container!="" ? ' ' : '') . esc_attr($header_top_bar_container)); ?>">
				<?php
				$sidebar = get_post($theme_options["header_top_sidebar"]);
				if(isset($sidebar) && !(int)get_post_meta($sidebar->ID, "hidden", true) && is_active_sidebar($sidebar->post_name)):
				?>
				<div class="header_top_bar clearfix">
					<?php
					dynamic_sidebar($sidebar->post_name);
					?>
				</div>
				<?php
				endif;
				?>
				</div>
				<?php
			}
			$header_container = (isset($color_skin) && $color_skin=='dark' ? ' style_2' : ($color_skin=='high_contrast' ? ' style_3' : ''));
			if($theme_options["header_container"]!="")
				$header_container = $theme_options["header_container"];
			?>
			<!-- Header -->
			<div class="header_container<?php echo (isset($_COOKIE['pr_header_container']) && $_COOKIE['pr_header_container']!="" ? ' ' . esc_attr($_COOKIE['pr_header_container']) : ($header_container!="" ? ' ' : '') . esc_attr($header_container)); ?>">
				<div class="header clearfix">
					<?php
					if(is_active_sidebar('header-top')):
					?>
					<div class="header_top_sidebar clearfix">
					<?php
					get_sidebar('header-top');
					?>
					</div>
					<?php
					endif;
					?>
					<div class="logo">
						<h1><a href="<?php echo esc_url(get_home_url()); ?>" title="<?php bloginfo("name"); ?>">&nbsp;</a></h1>

					  <div class="header_social_link"><a href="https://www.facebook.com/sindicatometasita" title="<?php bloginfo("name"); ?>" target="_blank"><img src="./wp-content/uploads/2018/06/fb.png" ></a>		
					  <a href="https://plus.google.com/105719111140333160556" title="<?php bloginfo("name"); ?>"target="_blank"><img src="./wp-content/uploads/2018/06/gplus.png"></a></div>	
					</div>
					<?php
					$header_top_right_sidebar_visible = false;
					if($theme_options["header_top_right_sidebar"]!="")
					{
						?>
						<div class="header_top_right_sidebar_container">
						<?php
						$sidebar = get_post($theme_options["header_top_right_sidebar"]);
						if(isset($sidebar) && !(int)get_post_meta($sidebar->ID, "hidden", true) && is_active_sidebar($sidebar->post_name)):
						?>
						<?php
						dynamic_sidebar($sidebar->post_name);
						$header_top_right_sidebar_visible = true;
						?>
						<?php
						endif;
						?>
						</div>
						<?php
					}
					?>
				</div>
			</div>
			<?php
			//Get menu object
			$locations = get_nav_menu_locations();
			if(isset($locations["main-menu"]))
			{
				$main_menu_object = get_term($locations["main-menu"], "nav_menu");
				if(has_nav_menu("main-menu") && $main_menu_object->count>0) 
				{
					$menu_container = ' ' . (isset($_COOKIE['pr_menu_container']) && $_COOKIE['pr_menu_container']!="" ? $_COOKIE['pr_menu_container'] : $theme_options['menu_container']);
					$menu_type = ' ' . (isset($_COOKIE['pr_menu_type']) && $_COOKIE['pr_menu_type']!="" ? $_COOKIE['pr_menu_type'] : ((int)$theme_options["sticky_menu"] ? 'sticky' : ''));
					?>
					<div class="menu_container<?php echo esc_attr($menu_container . $menu_type) . (!isset($theme_options["collapsible_mobile_submenus"]) || (int)$theme_options["collapsible_mobile_submenus"] ? " collapsible-mobile-submenus" : "");?>">
						<a href="#" class="mobile-menu-switch">
							<span class="line"></span>
							<span class="line"></span>
							<span class="line"></span>
						</a>
						<div class="mobile-menu-divider"></div>
					<?php
					wp_nav_menu(array(
						"container" => "nav",
						"container_class" => "ubermenu clearfix",
						"theme_location" => "main-menu",
						"menu_class" => "sf-menu ubermenu-nav",
						"walker" => (!isset($theme_options["collapsible_mobile_submenus"]) || (int)$theme_options["collapsible_mobile_submenus"] ? new Mobile_Menu_Walker_Nav_Menu() : '')
					));
					?>
					</div>
					<?php
					/*
					<div class="mobile_menu_container">
						<a href="#" class="mobile-menu-switch">
							<span class="line"></span>
							<span class="line"></span>
							<span class="line"></span>
						</a>
						<div class="mobile-menu-divider"></div>
					<?php
						wp_nav_menu(array(
							"container" => "nav",
							"container_class" => "ubermenu clearfix",
							"theme_location" => "main-menu",
							"menu_class" => "mobile-menu ubermenu-nav"/*,
							"walker" => new Walker_Test()*/
						/*));
					?>
					</div>
					<?php
					*/
				}
			}
			?>
		<!-- /Header -->