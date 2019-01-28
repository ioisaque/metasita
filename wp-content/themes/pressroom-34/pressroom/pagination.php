<?php
function kriesi_pagination($ajax = false, $pages = '', $range = 2, $query_string = false, $outputEcho = true, $action = '', $top_margin = 'none')
{
	$showitems = ($range * 2)+1;  

	global $paged;
	if(empty($paged)) $paged = 1;

	if($pages == '')
	{
		global $wp_query;
		$pages = $wp_query->max_num_pages;
		if(!$pages)
		{
			$pages = 1;
		}
	}

	if(1 != $pages)
	{
		if($query_string)
			parse_str($_SERVER["QUERY_STRING"], $query_string_array);
		
		$output = "<div class='pagination_container clearfix" . ($ajax ? " ajax" : "") . ($action ? " " . esc_attr($action) : "") . ($top_margin!="none" ? " " . esc_attr($top_margin) : "") . "'><ul class='pagination'>";
		if($paged > 2 && $paged > $range+1 && $showitems < $pages) $output .= "<li class='pr_pagination_first'><a href='".($query_string ? "?" . http_build_query(array_merge($query_string_array,  array("paged"=>1))) : pr_get_pagenum_link(1))."' data-page='1'>&laquo;</a></li>";
		if($paged > 1 && $showitems < $pages) $output .= "<li class='pr_pagination_prev'><a href='".($query_string ? "?" . http_build_query(array_merge($query_string_array,  array("paged"=>$paged-1))) :  pr_get_pagenum_link($paged - 1))."' data-page='".($paged - 1)."'>&lsaquo;</a></li>";

		for ($i=1; $i <= $pages; $i++)
		{
			if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
			{
				$output .= "<li" . ($paged == $i ? " class='selected'" : "") . ">" . ($paged == $i && !$ajax ? "<span>".$i."</span>":"<a href='".($query_string ? "?" . http_build_query(array_merge($query_string_array,  array("paged"=>$i))) :  pr_get_pagenum_link($i))."' data-page='".$i."'>".$i."</a>") . "</li>";
			}
		}

		if ($paged < $pages && $showitems < $pages) $output .= "<li class='pr_pagination_next'><a href='".($query_string ? "?" . http_build_query(array_merge($query_string_array,  array("paged"=>$paged + 1))) : pr_get_pagenum_link($paged + 1))."' data-page='".($paged + 1)."'>&rsaquo;</a></li>";  
		if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) $output .= "<li class='pr_pagination_last'><a href='".($query_string ? "?" . http_build_query(array_merge($query_string_array,  array("paged"=>$pages))) : pr_get_pagenum_link($pages))."' data-page='".($pages)."'>&raquo;</a></li>";
		$output .= "</ul>";
		if($ajax)
			$output .= "<span class='pr_preloader pagination_preloader'></span>";
		$output .= "</div>";
		if($outputEcho)
			echo $output;
		else
			return $output;
	}
}


/**
 * Original WP function get_pagenum_link() won't generate pretty permalink when 
 * is_admin() returns true,
 * that's why it's necessary to create custom function which will return address 
 * with correct permalink structure.
 * 
 * @global type $wp_rewrite
 * @param type $pagenum
 * @param type $escape
 * @return type*
 */
function pr_get_pagenum_link($pagenum = 1, $escape = true )
{
	global $wp_rewrite;

	$pagenum = (int) $pagenum;

	$request = remove_query_arg( 'paged' );

	$home_root = parse_url(home_url());
	$home_root = ( isset($home_root['path']) ) ? $home_root['path'] : '';
	$home_root = preg_quote( $home_root, '|' );

	$request = preg_replace('|^'. $home_root . '|i', '', $request);
	$request = preg_replace('|^/+|', '', $request);
	
	if ( !$wp_rewrite->using_permalinks() ) {
		$base = trailingslashit( get_home_url() );

		if ( $pagenum > 1 ) {
			$result = add_query_arg( 'paged', $pagenum, $base . $request );
		} else {
			$result = $base . $request;
		}
	} else {
		
		$qs_regex = '|\?.*?$|';
		preg_match( $qs_regex, $request, $qs_match );

		if ( !empty( $qs_match[0] ) ) {
			$query_string = $qs_match[0];
			$request = preg_replace( $qs_regex, '', $request );
		} else {
			$query_string = '';
		}

		$request = preg_replace( "|$wp_rewrite->pagination_base/\d+/?$|", '', $request);
		$request = preg_replace( '|^' . preg_quote( $wp_rewrite->index, '|' ) . '|i', '', $request);
		$request = ltrim($request, '/');

		$base = trailingslashit( get_home_url() );

		if ( $wp_rewrite->using_index_permalinks() && ( $pagenum > 1 || '' != $request ) )
			$base .= $wp_rewrite->index . '/';

		if ( $pagenum > 1 ) {
			$request = ( ( !empty( $request ) ) ? trailingslashit( $request ) : $request ) . user_trailingslashit( $wp_rewrite->pagination_base . "/" . $pagenum, 'paged' );
		}

		$result = $base . $request . $query_string;
	}

	/**
	 * Filter the page number link for the current request.
	 *
	 * @since 2.5.0
	 *
	 * @param string $result The page number link.
	 */
	$result = apply_filters( 'get_pagenum_link', $result );

	if ( $escape )
		return esc_url( $result );
	else
		return esc_url_raw( $result );
}
?>