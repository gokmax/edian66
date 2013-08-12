<?php
add_action('after_setup_theme', 'edian66_theme_setup');

function edian66_header_hook($name) {
	
}

function edian66_theme_setup() {
	add_action('get_header', 'edian66_header_hook');
}

function the_cover_src($post_obj = NULL) { 
	if (!$post_obj) {
		global $post, $posts;
		$post_obj = $post;
	}
    
    $src = ''; 

    ob_start(); 
    ob_end_clean();   
    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches); 
    $src = $matches[1][0]; 
    if(empty($src)) {  
        $src = bloginfo('template_url'). '/images/default-thumb.jpg';
    }
    // return $src; 
    echo $src;
}

function the_swf_src() {
    global $post, $posts; 
    
    $src = ''; 
    
    ob_start(); 
    ob_end_clean(); 
    $output = preg_match_all('/swf{([^\'{}"]+)}/i', $post->post_content, $matches); 
    $src = $matches[1][0];
    if(empty($src)) {  
        $src = bloginfo('template_url'). '/images/default-thumb.jpg';
    }
    // return $src; 
 
    echo $src;
}


function edian66_category_parents_list($cat, $seperator = '') {
	$cat_obj = get_category($cat);
	$out = Array('<a href="' . get_category_link($cat) . '">' . $cat_obj->name . '</a>');
	
	while ($cat_obj->parent != 0) {
		$cat_obj = get_category($cat_obj->parent);
		$out[] = '<a href="' . get_category_link($cat_obj->cat_ID) . '">' . $cat_obj->name . '</a>';
	}

	echo implode($seperator, array_reverse($out));
}


function edian66_root_category($cat) {
    $cat_obj = get_category($cat);
	while ($cat_obj->parent) {
		$cat_obj = get_category($cat_obj->parent);
	}
	return $cat_obj;
}

function edian66_root_category_title($cat) {
	echo edian66_root_category($cat)->cat_name;
}


function edian66_rearrange_categories($categories) {
	global $cat;
	$arranged_categories = Array();

	//put the parent directory to the first position
	foreach($categories as $sub_category) {
		if (cat_is_ancestor_of($sub_category->cat_ID, $cat) || ($sub_category->cat_ID == $cat))
			array_unshift($arranged_categories, $sub_category);
		else
			array_push($arranged_categories, $sub_category);
	}	
	return $arranged_categories;
}

function edian66_second_categories($cat) {
	$cat_obj = edian66_root_category($cat);
	$args = array(
		'hide_empty'=>0,
		'parent'=>$cat_obj->cat_ID,
	);
	$second_cats = get_categories($args);
	return edian66_rearrange_categories($second_cats);
}

function edian66_category_details($category) {
	global $cat;
	$args = array(
		'hide_empty'=>0,
		'parent'=>$category->cat_ID,
	);
	$categoris = edian66_rearrange_categories(get_categories($args));
	
	$out = "";
	$i = 0;

	foreach($categoris as $category) {
		if ($category->cat_ID == $cat) {
			$out .= "<li class='arrow'><a href='" . get_category_link($category->cat_ID) . "'>$category->cat_name</a>";
			$sub_categories = get_categories(Array('hide_empty'=>0, 'parent'=>$category->cat_ID));
			//echo count($sub_categories);
			foreach ($sub_categories as $sub_category) {
				$out .= "<li><a href='" . get_category_link($sub_category->cat_ID) . "'>$sub_category->cat_name</a>";
			}
		}
		else
			$out .= "<li><a href='" . get_category_link($category->cat_ID) . "'>$category->cat_name</a>";
			
	}
	echo $out;
}


function edian66_is_the_last2_category($cat) {
	$is_last2 = Array(0, 0);   // whether is the last category or the last but one category
	$sub_categories = get_categories(Array('hide_empty'=>0,'parent'=>$cat));
	if (count($sub_categories) == 0) {
		$is_last2[0] = 1;
	} else {
		$is_last2[1] = 1;
		$children = get_categories(Array('hide_empty'=>0,'parent'=>$sub_categories[0]->cat_ID));
		if (count($children))
			$is_last2[1] = 0;
	}
	return $is_last2;
}

function edian66_get_post_views($post_id = NULL) {
	if (!$post_id) {
		global $post;
		$post_id = $post->ID;
	}
	$count_key = 'views';
	$count = get_post_meta($post_id, $count_key, true);
	
	if ($count == "") {
		delete_post_meta($post_id, $count_key);
		add_post_meta($post_id, $count_key, '0');
		$count = '0';
	}
	
	echo number_format_i18n($count);
}

function edian66_set_post_views($post_id = NULL) {
	if (!$post_id) {
		global $post;
		$post_id = $post->ID;
	}
	
	$count_key = 'views';
	$count = get_post_meta($post_id, $count_key, true);
	
	if (is_single()) {
		if ($count == "") {
			delete_post_meta($post_id, $count_key);
			add_post_meta($post_id, $count_key, '1');
		} else {
			update_post_meta($post_id, $count_key, $count + 1);
		}
	}
}
?>