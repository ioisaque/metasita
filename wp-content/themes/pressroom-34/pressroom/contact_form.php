<?php
global $themename;
//contact form
function pr_theme_contact_form_shortcode($atts)
{
	extract(shortcode_atts(array(
		"id" => "contact_form",
		"top_margin" => "none",
		"el_class" => ""
	), $atts));
	
	$output = "";
	$output .= '<form class="contact_form ' . ($top_margin!="none" ? esc_attr($top_margin) : '') . ($el_class!="" ? ' ' . esc_attr($el_class) : '') . '" id="' . esc_attr($id) . '" method="post" action="#">
		<fieldset class="vc_col-sm-4 wpb_column vc_column_container">
			<div class="block">
				<input class="text_input" name="name" type="text" value="' . __("Seu Nome *", 'pressroom') . '" placeholder="' . __("Seu Nome *", 'pressroom') . '">
			</div>
		</fieldset>
		<fieldset class="vc_col-sm-4 wpb_column vc_column_container">
			<div class="block">
				<input class="text_input" name="email" type="text" value="' . __("Seu E-mail *", 'pressroom') . '" placeholder="' . __("Seu E-mail *", 'pressroom') . '">
			</div>
		</fieldset>
		<fieldset class="vc_col-sm-4 wpb_column vc_column_container">
			<div class="block">
				<input class="text_input" name="Assunto" type="text" value="' . __("Assunto", 'pressroom') . '" placeholder="' . __("Assunto", 'pressroom') . '">
			</div>
		</fieldset>
		<fieldset>
			<div class="block">
				<textarea class="margin_top_10" name="Mensagem" placeholder="' . __("Mensagem *", 'pressroom') . '">' . __("Mensagem *", 'pressroom') . '</textarea>
			</div>
		</fieldset>
		<fieldset>
			<input type="hidden" name="action" value="theme_contact_form">
			<input type="hidden" name="id" value="' . esc_attr($id) . '">
			<input type="submit" name="submit" value="' . __("Enviar Mensagem", 'pressroom') . '" class="more active">
		</fieldset>
	</form>';
	return $output;
}

//visual composer
function pr_theme_contact_form_vc_init()
{
	vc_map( array(
		"name" => __("Contact form", 'pressroom'),
		"base" => "pressroom_contact_form",
		"class" => "",
		"controls" => "full",
		"show_settings_on_create" => true,
		"icon" => "icon-wpb-layer-contact-form",
		"category" => __('Pressroom', 'pressroom'),
		"params" => array(
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Id", 'pressroom'),
				"param_name" => "id",
				"value" => "contact_form",
				"description" => __("Please provide unique id for each contact form on the same page/post", 'pressroom')
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Top margin", 'pressroom'),
				"param_name" => "top_margin",
				"value" => array(__("None", 'pressroom') => "none", __("Page (small)", 'pressroom') => "page_margin_top", __("Section (large)", 'pressroom') => "page_margin_top_section")
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Extra class name', 'pressroom' ),
				'param_name' => 'el_class',
				'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'pressroom' )
			)
		)
	));
}
add_action("init", "pr_theme_contact_form_vc_init");

//contact form submit
function pr_theme_contact_form()
{
	ob_start();
	global $theme_options;

    $result = array();
	$result["isOk"] = true;
	if($_POST["name"]!="" && $_POST["name"]!=__("Seu Nome *", 'pressroom') && $_POST["email"]!="" && $_POST["email"]!=__("Seu E-mail *", 'pressroom') && preg_match("#^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,12})$#", $_POST["email"]) && $_POST["Mensagem"]!="" && $_POST["Mensagem"]!=__("Mensagem *", 'pressroom'))
	{
		$values = array(
			"name" => $_POST["name"],
			"Assunto" => $_POST["Assunto"],
			"email" => $_POST["email"],
			"Mensagem" => $_POST["Mensagem"]
		);
		if((bool)ini_get("magic_quotes_gpc")) 
			$values = array_map("stripslashes", $values);
		$values = array_map("htmlspecialchars", $values);
		
		$headers[] = 'Reply-To: ' . $values["name"] . ' <' . $values["email"] . '>' . "\r\n";
		$headers[] = 'From: ' . $theme_options["cf_admin_name"] . ' <' . $theme_options["cf_admin_email"] . '>' . "\r\n";
		$headers[] = 'Content-type: text/html';		
		$Assunto = ($values["Assunto"]!=__("Assunto", 'pressroom') ? $values["Assunto"] : $theme_options["cf_email_Assunto"]);
		$Assunto = str_replace("[name]", $values["name"], $Assunto);
		$Assunto = str_replace("[email]", $values["email"], $Assunto);
		$Assunto = str_replace("[Mensagem]", $values["Mensagem"], $Assunto);
		$body = $theme_options["cf_template"];
		$body = str_replace("[name]", $values["name"], $body);
		$body = str_replace("[email]", $values["email"], $body);
		$body = str_replace("[Mensagem]", $values["Mensagem"], $body);

		if(wp_mail($theme_options["cf_admin_name"] . ' <' . $theme_options["cf_admin_email"] . '>', $Assunto, $body, $headers))
			$result["submit_Mensagem"] = __("Thank you for contacting us", 'pressroom');
		else
		{
			$result["isOk"] = false;
			$result["error_Mensagem"] = $GLOBALS['phpmailer']->ErrorInfo;
			$result["submit_Mensagem"] = __("Sorry, we can't Enviar this Mensagem", 'pressroom');
		}
	}
	else
	{
		$result["isOk"] = false;
		if($_POST["name"]=="" || $_POST["name"]==__("Seu Nome *", 'pressroom'))
			$result["error_name"] = __("Favor informar Seu Nome.", 'pressroom');
		if($_POST["email"]=="" || $_POST["email"]==__("Seu E-mail *", 'pressroom') || !preg_match("#^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,12})$#", $_POST["email"]))
			$result["error_email"] = __("Favor informar um e-mail válido.", 'pressroom');
		if($_POST["Mensagem"]=="" || $_POST["Mensagem"]==__("Mensagem *", 'pressroom'))
			$result["error_Mensagem"] = __("Favor informar your Mensagem.", 'pressroom');
	}
	$system_Mensagem = ob_get_clean();
	$result["system_Mensagem"] = $system_Mensagem;
	echo @json_encode($result);
	exit();
}
add_action("wp_ajax_theme_contact_form", "pr_theme_contact_form");
add_action("wp_ajax_nopriv_theme_contact_form", "pr_theme_contact_form");
?>