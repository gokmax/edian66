<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
</head>
<?php
/**
 *Purpose: Scan the content of given directory and update the wordpress database
 *Usage: Put the file into some directory of webroot, maybe you should change the $dir
		to find the resource directory correctly, and then run it, it will automatically update
		the data in the database
	For example, if you put this file in web-content/edian66/, you can run it in browser
	with the address "http://edian66.com/data_init.php"
 */

$siteurl = "http://localhost/edian66";
$dblink = NULL;
$cat_id = 0;    // Global category id, term_id
$swf_id = 1;
$term_taxonomy_id = 1;
$resource_dir = 'wp-content/uploads/swf/kid.qq.com';


define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PWD', 'lxr');
define('DB_NAME', 'wp');


function connect_db()
{
	global $dblink;
	$dblink = mysql_connect(DB_HOST, DB_USER, DB_PWD);
	if (!$dblink)
		die (mysql_error());
	$sql = "CREATE DATABASE IF NOT EXISTS ". DB_NAME;
	if (!mysql_query($sql))
		die (mysql_error());
	mysql_select_db(DB_NAME, $dblink);
	$sql = "set names utf8";
	if (!mysql_query($sql)) 
		die (mysql_error());
}


/** 
 * Update ed66_terms and ed66_term_taxonomy tables
 */
function update_cat($curr_dir, $parent_cat_id, $swf_nums)
{
	global $cat_id;
	$cat_id += 1;
	$curr_dir = iconv("GBK", "UTF-8", $curr_dir);
	
	$name = substr($curr_dir, strrpos($curr_dir, "/")+1);
	echo $name . "<br />";    // print category
	
	$sql1 = "INSERT INTO ed66_terms (term_id,name,slug,term_group) VALUES ($cat_id, '$name', '$cat_id', 0)";
	$sql2 = "INSERT INTO ed66_term_taxonomy (term_taxonomy_id,term_id,taxonomy,description,parent,count)
		VALUES ($cat_id, $cat_id, 'category', '', '$parent_cat_id', '$swf_nums')";
	if (!mysql_query($sql1) || !mysql_query($sql2)) {
		$cat_id -= 1;
		die (mysql_error());
	}
}

/** 
 * Update ed66_posts and ed66_postmeta tables
 */
function update_post($dir, $swf_name)
{
	global $swf_id, $siteurl, $cat_id;
	//echo $dir . $swf_name . "<br />";
	$dir = iconv("GBK", "UTF-8", $dir);
	$swf_name = iconv("GBK", "UTF-8", $swf_name);
	
	//echo $dir . $swf_name . "<br />";
	$post_content = '';
	
	$jpg_link = $siteurl . "/" . $dir . "/" . $swf_name . ".jpg";
	$post_content .= '<img src="' . $jpg_link . '" alt="' . $swf_name . '" />';

	$post_content .= " swf{" . $siteurl . "/" . $dir . "/" . $swf_name . ".swf}";

	//echo htmlentities($post_content) . "<br />";
	
	$guid = $siteurl . "/?p=" . strval($swf_id);
	$sql1 = "INSERT INTO ed66_posts (ID,post_content,post_excerpt,post_title,post_name,to_ping,pinged,post_content_filtered,guid)
		VALUES ('$swf_id', '$post_content', '$swf_name', '$swf_name', '$swf_name', '', '', '', '$guid')";
	$sql2 = "INSERT INTO ed66_term_relationships (object_id, term_taxonomy_id, term_order) 
		VALUES ('$swf_id', '$cat_id', '0')";
	
	if (!mysql_query($sql1)) {
		die (mysql_error() . $sql1);
	}
	if (!mysql_query($sql2)) {
		die (mysql_error() . $sql2);
	}
	$swf_id += 1;	
}

function process_swf($dir)
{
	$swfs = glob($dir . "/*.swf");
	foreach ($swfs as $swf_file) {
		// Find the swf name of addrsss "wp-content/uploads/.../name.swf"
		$slash_pos = strrpos($swf_file, "/");
		$swf_name = substr($swf_file, $slash_pos+1, strrpos($swf_file, '.')-$slash_pos-1);
		//echo $swf_name, $dir;
		update_post($dir, $swf_name);
	}
}


/**
 * Scan the flash resource directory 
 * and initialize the data
 */
function process_dir($curr_dir, $parent_cat_id)
{
	//echo iconv("GBK", "UTF-8", $curr_dir . "<br />");
	global $cat_id;

	if ($handle = opendir($curr_dir)) {
		while (false !== ($entry = readdir($handle))) {
		
			if ($entry == '.' || $entry == '..')
				continue;
				
			$entry = $curr_dir . "/" . $entry;

			if (is_dir($entry)) {	
				$to_find = $entry . "/*.swf";
				$swf_nums = count(glob($to_find));
				update_cat($entry, $parent_cat_id, $swf_nums);   // Store the category information
				if ($swf_nums) {   // Reach the final directory
					process_swf($entry);
				} else {
					process_dir($entry, $cat_id);
				}
				
			}
				
		}
		closedir($handle);
	}else {
		echo  $curr_dir . " not exits!";
	}
}

connect_db();

process_dir($resource_dir, 0);

mysql_close($dblink);

?>
</html>