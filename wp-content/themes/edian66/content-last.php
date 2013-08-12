     <?php $category = get_category($cat); ?>
		<div class="box">
                <div class="box-title">
                    <a href="<?php get_category_link($category->cat_ID); ?>"><?= $category->cat_name ?></a>
                </div>
                <div class="box-content playlist">
                    <ul>
                        <?php 
                            query_posts("cat=$category->cat_ID&posts_per_page=12");
                            while ( have_posts() ) : the_post();
                        ?>
                        <li>
                            <img src="<?php the_cover_src(); ?>" width="120" height='90'>
                            <p>
                                <a class="title" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
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
   