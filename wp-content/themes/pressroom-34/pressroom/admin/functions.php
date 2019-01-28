<?php
function pr_theme_admin_init()
{
	wp_register_script("theme-colorpicker", get_template_directory_uri() . "/admin/js/colorpicker.js", array("jquery"));
	wp_register_script("theme-admin", get_template_directory_uri() . "/admin/js/theme_admin.js", array("jquery", "theme-colorpicker"));
	wp_register_script("jquery-bqq", get_template_directory_uri() . "/admin/js/jquery.ba-bbq.min.js", array("jquery"));
	wp_register_style("theme-colorpicker", get_template_directory_uri() . "/admin/style/colorpicker.css");
	wp_register_style("theme-admin-style", get_template_directory_uri() . "/admin/style/style.css");
	wp_register_style("theme-admin-style-rtl", get_template_directory_uri() . "/admin/style/rtl.css");
}
add_action("admin_init", "pr_theme_admin_init");

function pr_theme_admin_print_scripts()
{
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-bqq');
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-tabs');
	wp_enqueue_script('theme-admin');
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_enqueue_style('thickbox');
	wp_enqueue_style("google-font-open-sans", "http://fonts.googleapis.com/css?family=Open+Sans:400,600");
	
	$sidebars = array(
		"default" => array(
			array(
				"name" => "footer_top",
				"label" => __("footer top", 'pressroom')
			),
			array(
				"name" => "footer_bottom",
				"label" => __("footer bottom", 'pressroom')
			)
		),
		"template-blog.php" => array(
			array(
				"name" => "footer_top",
				"label" => __("footer top", 'pressroom')
			),
			array(
				"name" => "footer_bottom",
				"label" => __("footer bottom", 'pressroom')
			)
		),
		"single.php" => array(
			array(
				"name" => "footer_top",
				"label" => __("footer top", 'pressroom')
			),
			array(
				"name" => "footer_bottom",
				"label" => __("footer bottom", 'pressroom')
			)
		),
		"author.php" => array(
			array(
				"name" => "footer_top",
				"label" => __("footer top", 'pressroom')
			),
			array(
				"name" => "footer_bottom",
				"label" => __("footer bottom", 'pressroom')
			)
		),
		"search.php" => array(
			array(
				"name" => "footer_top",
				"label" => __("footer top", 'pressroom')
			),
			array(
				"name" => "footer_bottom",
				"label" => __("footer bottom", 'pressroom')
			)
		),
		"template-default-without-breadcrumbs.php" => array(
			array(
				"name" => "footer_top",
				"label" => __("footer top", 'pressroom')
			),
			array(
				"name" => "footer_bottom",
				"label" => __("footer bottom", 'pressroom')
			)
		),
		"404.php" => array(
			array(
				"name" => "footer_top",
				"label" => __("footer top", 'pressroom')
			),
			array(
				"name" => "footer_bottom",
				"label" => __("footer bottom", 'pressroom')
			)
		)
	);
	//get theme sidebars
	$theme_sidebars = array();
	$theme_sidebars_array = get_posts(array(
		'post_type' => 'pressroom_sidebars',
		'posts_per_page' => '-1',
		'post_status' => 'publish',
		'orderby' => 'menu_order',
		'order' => 'ASC'
	));
	for($i=0; $i<count($theme_sidebars_array); $i++)
	{
		$theme_sidebars[$i]["id"] = $theme_sidebars_array[$i]->ID;
		$theme_sidebars[$i]["title"] = $theme_sidebars_array[$i]->post_title;
	}
	
	$data = array(
		'img_url' =>  get_template_directory_uri() . "/images/",
		'admin_img_url' =>  get_template_directory_uri() . "/admin/images/",
		'sidebar_label' => __('Sidebar', 'pressroom'),
		'sidebars' => $sidebars,
		'theme_sidebars' => $theme_sidebars,
		'page_sidebars' => get_post_meta(get_the_ID(), "pressroom_page_sidebars", true),
		'themename' => 'pressroom'
	);
	//pass data to javascript
	$params = array(
		'l10n_print_after' => 'config = ' . json_encode($data) . ';'
	);
	wp_localize_script("theme-admin", "config", $params);
}

function pr_theme_admin_print_scripts_colorpicker()
{	
	wp_enqueue_script('theme-admin');
	wp_enqueue_script('theme-colorpicker');
	wp_enqueue_style('theme-colorpicker');
}

function pr_theme_admin_print_scripts_all()
{
	global $theme_options;
	wp_enqueue_style('theme-admin-style');
	if((is_rtl() || (isset($theme_options['direction']) && $theme_options["direction"]=='rtl')) && $_COOKIE["pr_direction"]!="LTR")
		wp_enqueue_style('theme-admin-style-rtl');
}

function pr_theme_admin_menu_theme_options() 
{
	add_action("admin_print_scripts", "pr_theme_admin_print_scripts_all");
	add_action("admin_print_scripts-post-new.php", "pr_theme_admin_print_scripts");
	add_action("admin_print_scripts-post.php", "pr_theme_admin_print_scripts");
	add_action("admin_print_scripts-appearance_page_ThemeOptions", "pr_theme_admin_print_scripts");
	add_action("admin_print_scripts-appearance_page_ThemeOptions", "pr_theme_admin_print_scripts_colorpicker");
	add_action("admin_print_scripts-edit-tags.php", "pr_theme_admin_print_scripts_colorpicker");
	add_action("admin_print_scripts-term.php", "pr_theme_admin_print_scripts_colorpicker");
}
add_action("admin_menu", "pr_theme_admin_menu_theme_options");

function pr_rename_post_formats($translation, $text, $context, $domain) 
{
	$names = array(
		'Image'  => 'Small Image'
	);
    if($context == 'Post format') 
		$translation = str_replace(array_keys($names), array_values($names), $text);
    return $translation;
}
add_filter('gettext_with_context', 'pr_rename_post_formats', 10, 4);

//http://wpthemetutorial.com/2013/02/21/adding-custom-meta-to-wordpress-taxonomies/
add_action('category_edit_form_fields', 'pr_edit_category_color_field', 10, 2);
function pr_edit_category_color_field($term)
{
	$term_id = $term->term_id;
	$term_meta = get_option( "taxonomy_$term_id");
	$category_color = $term_meta['color'] ? $term_meta['color'] : '';
?>
	<tr class="form-field">
		<th scope="row">
			<label for="color"><?php _e("Category color", 'pressroom'); ?></label>
			<td>
				<span class="color_preview" style="background-color: #<?php echo ($category_color!="" ? $category_color : ''); ?>;"></span>
				<input style="width: 70px;" type="text" class="regular-text color" value="<?php echo esc_attr($category_color); ?>" id="color" name="color" data-default-color="transparent">
				<script type="text/javascript">
		jQuery(document).ready(function($){
			$(".color").ColorPicker({
				onChange: function(hsb, hex, rgb, el) {
					$(el).val(hex);
					$(el).prev(".color_preview").css("background-color", "#" + hex);
				},
				onSubmit: function(hsb, hex, rgb, el){
					$(el).val(hex);
					$(el).ColorPickerHide();
				},
				onBeforeShow: function (){
					var color = (this.value!="" ? this.value : $(this).attr("data-default-color"));
					$(this).ColorPickerSetColor(color);
					$(this).prev(".color_preview").css("background-color", color);
				}
			}).on('keyup', function(event, param){
				$(this).ColorPickerSetColor(this.value);

				var default_color = $(this).attr("data-default-color");
				$(this).prev(".color_preview").css("background-color", (this.value!="none" ? "#" + (this.value!="" ? (typeof(param)=="undefined" ? $(".colorpicker:visible .colorpicker_hex input").val() : this.value) : default_color) : "transparent"));
			});
			$("#color").change(function(){
				$(this).next().next().val($(this).val()).trigger("keyup", [1]);
			});
		});
		</script>
			</td>
		</th>
	</tr>
<?php
}

add_action('category_add_form_fields', 'pr_add_category_color_field');
function pr_add_category_color_field()
{
    ?>
	<div class="form-field">
		<label for="color"><?php _e("Category color", 'pressroom'); ?></label>
		<span class="color_preview" style="background-color: transparent;"></span>
		<input style="width: 70px;" type="text" class="regular-text color" value="" name="color" data-default-color="transparent">
	</div>
    <?php
}

add_action('edited_category', 'pr_save_tax_meta', 10, 2);
add_action('create_category', 'pr_save_tax_meta', 10, 2);
	
function pr_save_tax_meta($term_id)
{
	if(isset($_POST['color'])) 
	{
		$t_id = $term_id;
		$term_meta = array();

		$term_meta['color'] = isset ( $_POST['color'] ) ?  $_POST['color']  : '';
		// Save the option array.
		update_option( "taxonomy_$t_id", $term_meta );

	}
}
?>