<?php get_header(); ?>
    <div class="container clearfix">
        <div>
            <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="990" height="550">
                <param name="movie" value="/wp-content/themes/edian66/ed66.swf">
                <param name="quality" value="high">
                <param name="wmode" value="transparent">
                <embed src="<?php echo bloginfo('template_url') . "/ed66.swf"; ?>" width="990" height="550" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" wmode="transparent">
                </embed>
            </object>
        </div>
        <div class="news">
            <ul>
                <li><strong>最新资源：</strong></li>
                <li>两小儿辩日</li>
                <li>蓝猫淘气</li>
            </ul>
        </div>
        <div class="search">
            <input type="text" name="" value="" placeholder="search">
        </div>
		<?php
			$args = array(
				'category_in' => array(5),
				'paged' => 2,
				'showposts' => 2,
			);
			$args = array_merge($args, $wp_query->query);
			query_posts($args);
			if (have_posts()) {
				while (have_posts()) {
					the_post();
					the_title();
				}
			}
			else{
				echo 'no post';
			}
			wp_reset_query();
			if ( is_category() )
				echo 'category';
			if ( is_home() ) 
				echo 'home';
			if ( is_single() ) 
				echo 'single';
		?>
			
    </div>
<?php get_footer(); ?>
