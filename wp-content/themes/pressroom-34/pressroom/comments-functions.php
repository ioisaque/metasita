<?php
//comment form submit
function pr_theme_comment_form()
{
	$result = array();
	$result["isOk"] = true;
	if($_POST["name"]!="" && $_POST["name"]!=__("Seu Nome *", 'pressroom') && $_POST["email"]!="" && $_POST["email"]!=__("Seu E-mail *", 'pressroom') && preg_match("#^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,12})$#", $_POST["email"]) && $_POST["Mensagem"]!="" && $_POST["Mensagem"]!=__("Comment *", 'pressroom'))
	{
		$values = array(
			"name" => $_POST["name"],
			"email" => $_POST["email"],
			"website" => $_POST["website"],
			"Mensagem" => $_POST["Mensagem"]
		);
		if((bool)ini_get("magic_quotes_gpc")) 
			$values = array_map("stripslashes", $values);
		$values = array_map("htmlspecialchars", $values);
	
		$time = current_time('mysql');

		$data = array(
			'comment_post_ID' => (int)$_POST['post_id'],
			'comment_author' => $values['name'],
			'comment_author_email' => $values['email'],
			'comment_author_url' => ($values['website']!=__("Website", 'pressroom') ? $values['website'] : ""),
			'comment_content' => $values['Mensagem'],
			'comment_parent' => (isset($_POST['parent_comment_id']) ? (int)$_POST['parent_comment_id'] : 0),
			'comment_date' => $time,
			'comment_approved' => ((int)get_option('comment_moderation') ? 0 : 1),
			'comment_parent' => (int)$_POST['comment_parent_id']
		);

		if($comment_id = wp_insert_comment($data))
		{
			$result["submit_Mensagem"] = __("Your comment has been added", 'pressroom');
			if(get_option('comments_notify'))
				wp_notify_postauthor($comment_id);
			//get post comments
			//post
			query_posts("p=" . (int)$_POST['post_id'] . "&post_type=" . $_POST["post_type"]);
			if(have_posts()) : the_post(); 
				ob_start();
				$result['comment_id'] = $comment_id;
				if(isset($_POST['comment_parent_id']) && (int)$_POST['comment_parent_id']==0)
				{
					global $wpdb;
					//$query = $wpdb->prepare("SELECT COUNT(*) AS count FROM $wpdb->comments WHERE comment_approved = 1 AND comment_post_ID = %d AND comment_parent = 0", get_the_ID());
					$query = $wpdb->prepare("SELECT COUNT(*) AS count FROM $wpdb->comments WHERE (comment_approved = '1' OR comment_approved = '0') AND comment_post_ID = %d AND comment_parent = 0", get_the_ID());
					$parents = $wpdb->get_row($query);
					$_GET["paged"] = ceil($parents->count/5);
					$result["change_url"] = "#page-" . esc_attr($_GET["paged"]);
				}
				else
					$_GET["paged"] = (int)$_POST["paged"];
				comments_template();
				$result['html'] = ob_get_contents();
				ob_end_clean();
			endif;
		}
		else 
		{
			$result["isOk"] = false;
			$result["submit_Mensagem"] = __("Error while adding comment", 'pressroom');
		}
	}
	else
	{
		$result["isOk"] = false;
		if($_POST["name"]=="" || $_POST["name"]==__("Seu Nome *", 'pressroom'))
			$result["error_name"] = __("Favor informar Seu Nome", 'pressroom');
		if($_POST["email"]=="" || $_POST["email"]==__("Seu E-mail *", 'pressroom') || !preg_match("#^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,12})$#", $_POST["email"]))
			$result["error_email"] = __("Favor informar um e-mail válido", 'pressroom');
		if($_POST["Mensagem"]=="" || $_POST["Mensagem"]==__("Comment *", 'pressroom'))
			$result["error_Mensagem"] = __("Favor informar your Mensagem", 'pressroom');
	}
	echo @json_encode($result);
	exit();
}
add_action("wp_ajax_theme_comment_form", "pr_theme_comment_form");
add_action("wp_ajax_nopriv_theme_comment_form", "pr_theme_comment_form");

//get comments list
function pr_theme_get_comments()
{
	$result = array();
	query_posts("p=" . $_GET["post_id"] . "&post_type=" . $_GET["post_type"]);
	if(have_posts()) : the_post();
	ob_start();
	comments_template();
	$result["html"] = ob_get_contents();
	ob_end_clean();
	endif;
	echo @json_encode($result);
	exit();
}
add_action("wp_ajax_theme_get_comments", "pr_theme_get_comments");
add_action("wp_ajax_nopriv_theme_get_comments", "pr_theme_get_comments");
?>