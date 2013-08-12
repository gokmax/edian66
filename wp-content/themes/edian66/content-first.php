    <?php 
		$categories = get_categories(Array('hide_empty'=>0, 'parent'=>$cat));
		foreach ($categories as $category) {
	?>
		<div class="box">
                <div class="box-title">
                    <a href="<?php get_category_link($category->cat_ID); ?>"><?= $category->cat_name ?></a>
                </div>
                <div class="box-content box-content-bg">
                    <ul>
                        <?php 
                            query_posts("cat=$category->cat_ID&posts_per_page=8");
                            while ( have_posts() ) : the_post(); $cur_cat = get_the_category();
                        ?>
                        <li>
                            <img src="<?php the_cover_src(); ?>" width="120" height='90'>
                            <p>
                                <a class="title" href="<?php the_permalink(); ?>" title="<?php the_title(); echo "【".$cur_cat[0]->cat_name."】"; ?>">
									<?php the_title(); ?>【<?php echo $cur_cat[0]->cat_name ?>】
								</a>
                                <br>
                                播放：<?php edian66_get_post_views(); ?>次
                            </p>
                        </li>
                        <?php
                            endwhile;
                            wp_reset_query();
                        ?>
                    </ul>
                </div>
            </div>
	<?php } ?>
  