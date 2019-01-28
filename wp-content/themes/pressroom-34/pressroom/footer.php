			<?php global $theme_options, $themename; ?>
			<div class="footer_container">
				<div class="footer clearfix">
					<div class="vc_row wpb_row vc_row-fluid ">
						<?php
						$sidebar = get_post(get_post_meta(get_the_ID(), "page_sidebar_footer_top", true));
						if(isset($sidebar) && !(int)get_post_meta($sidebar->ID, "hidden", true) && is_active_sidebar($sidebar->post_name))
							dynamic_sidebar($sidebar->post_name);
						?>
					</div>
					<div class="vc_row wpb_row vc_row-fluid page_margin_top_section">
						<?php
						//Get menu object
						$locations = get_nav_menu_locations();
						if(isset($locations["footer-menu"]))
						{
							$main_menu_object = get_term($locations["footer-menu"], "nav_menu");
							if(has_nav_menu("footer-menu") && $main_menu_object->count>0) 
							{
								wp_nav_menu(array(
									"container_class" => "vc_col-sm-9 wpb_column vc_column_container",
									"theme_location" => "footer-menu",
									"menu_class" => "footer_menu",
									"before" => "<h4>",
									"after" => "</h4>"
								));
							}
						}
						$sidebar = get_post(get_post_meta(get_the_ID(), "page_sidebar_footer_bottom", true));
						if(isset($sidebar) && !(int)get_post_meta($sidebar->ID, "hidden", true) && is_active_sidebar($sidebar->post_name))
							dynamic_sidebar($sidebar->post_name);
						?>
					</div>
					<div class="vc_row wpb_row vc_row-fluid copyright_row">
						<div class="vc_col-sm-8 wpb_column vc_column_container">
							<p style="color: white;">
								<?php $url = 'http://www.sige.pro.br/padraoWeb/divulgacao_online/'; ?>
								<?=file_get_contents($url.'rodape_light.html');?>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="background_overlay"></div>
		<?php
		$color_skin = (isset($_COOKIE['pr_color_skin']) ? $_COOKIE['pr_color_skin'] : $theme_options["color_scheme"]);
		if($theme_options["font_size_selector"]=="yes" && $color_skin=="high_contrast")
		{
		?>
		<div class="font_selector">
			<a href="#" class="increase" title="<?php esc_attr_e('Increase font size', 'pressroom'); ?>"></a>
			<a href="#" class="decrease" title="<?php esc_attr_e('Decrease font size', 'pressroom'); ?>"></a>
		</div>
		<?php
		}
		if((int)$theme_options["style_selector"])
			pr_get_theme_file("/style_selector/style_selector.php");
		wp_footer();
		?>
	</body>
</html>