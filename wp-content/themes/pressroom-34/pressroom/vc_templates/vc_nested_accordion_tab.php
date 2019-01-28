<?php
$output = $title = '';

extract(shortcode_atts(array(
	'tab_id' => '',
	'title' => __("Section", "pressroom")
), $atts));

$output .= "\n\t\t\t" . '<li>';
        $output .= "\n\t\t\t\t" . '<div id="accordion-' . (empty($tab_id) ? sanitize_title($title) : $tab_id) . '"><h3>' . $title . '</h3></div>';
		$output .= "\n\t\t\t\t" . '<div class="clearfix">';
        $output .= ($content=='' || $content==' ') ? __("Empty section. Edit page to add content here.", "pressroom") : "\n\t\t\t\t" . wpb_js_remove_wpautop($content);
        $output .= "\n\t\t\t\t" . '</div>';
        //$output .= "\n\t\t\t\t" . '</div></div>';
        $output .= "\n\t\t\t" . '</li> ' . $this->endBlockComment('.wpb_accordion_section') . "\n";

echo $output;