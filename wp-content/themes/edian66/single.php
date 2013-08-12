<?php get_header(); ?>
    <div class="container clearfix">
        <div class="content-wrapper clearfix">
            <div class="location">
                <a href="<?php bloginfo('siteurl'); ?>">首页</a>
                <span class="location-div">>></span>
				<?php 
					edian66_set_post_views();
					$categories = get_the_category();
					edian66_category_parents_list($categories[0]->cat_ID, ' <span class="location-div">>></span>'); ?>
            </div>
            <div class="content">
                <?php 
                    if ( have_posts() ) : the_post(); 
                        update_post_caches($post);
                ?>
                <h2><?php the_title(); ?></h2>
                <div class="swf-wrapper">
                    <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="540" height="320">
                        <param name="movie" value="<?php the_swf_src(); ?>">
                        <param name="quality" value="high">
                        <param name="wmode" value="transparent">
                        <embed src="<?php the_swf_src(); ?>" width="540" height="320" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" wmode="transparent">
                        </embed>
                    </object>
                    <div class="control-panel">
                        <a class="play-btn" href="#">
                            &nbsp;
                        </a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <div class="container-right">
                <p class="more-video-title">更多视频</p>
				<?php
					$args = Array(
						'post__not_in' => Array($post->ID),
						'posts_per_page' => 3,
						'cat' => $categories[0]->cat_ID,
						'orderby' => 'rand',
					);
					$mores = new WP_Query($args);
					
					//echo count($posts);
					if( $mores->have_posts() ) {
				?>			
						<ul class="more-video-area">				
					<?php
						while( $mores->have_posts() ) {						
					?>				    
					    <li>
                            <img src="<?php $mores->the_post(); the_cover_src(); ?>" width="120" height='90'>
                            <p>
                                <a class="title" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>                    
                            </p>
							<p>
								<span class="playnum">播放： 20次</span>
							</p>
                        </li>
					<?php	
						}
					?>
					</ul>
				<?php
					}else { 
					?>
						<p>没有更多的视频哦</p>
					<?php
					}
					wp_reset_postdata();
					//echo $post;
					?>
            </div>
        </div>  
    </div>
<?php get_footer(); ?>
