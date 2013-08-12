<?php get_header(); echo $cat; 
	$this_cat = get_category($cat);
	global $query_string;
	echo $query_string;
	the_swf_src();
	the_category(",", "multiple");
	$cat_id = get_cat_ID('儿童故事');
	$cat_link = get_category_link($cat_id);
	echo $cat_link;
	
	$args = Array('parent'=>1, 'hide_empty'=>0);
	echo count(get_categories($args));
	//echo cat_is_ancestor_of($cat, 2);
	
	?>
    <div class="banner-nav">
        <ul class="sub-nav">
            <li><a href="/">首页</a></li>
            <li>&nbsp;|&nbsp;</li>
            <li><a href="/">登陆</a></li>
        </ul>
        <ul class="main-nav">
            <li><a href="<? echo get_category_link(get_cat_ID('儿童故事')); ?>">儿童故事</a></li>
            <li><a href="<? echo get_category_link(get_cat_ID('才艺馆')); ?>">才艺馆</a></li>
            <li><a href="<? echo get_category_link(get_cat_ID('学习乐园')); ?>">学习乐园</a></li>
            <li><a href="<? echo get_category_link(get_cat_ID('趣味游戏')); ?>">趣味游戏</a></li>
            <li><a href="<? echo get_category_link(get_cat_ID('欢乐童谣')); ?>">欢乐童谣</a></li>
        </ul>
    </div>
    <div class="header">
        <div class="search-bar">
            <form action="/" method="get">
                <input type="text" class="search-input-text">
                <button class="search-input-btn">&nbsp;</button>
            </form>
            <ul class="hot-words">
                <li class="title">热门搜索：</li>
                <li><a href="#">小毛驴</a></li>
                <li><a href="#">语文</a></li>
                <li><a href="#">英语</a></li>
                <li><a href="#">蓝猫</a></li>
                <li><a href="#">拼音学习</a></li>
            </ul>
        </div>
        <div class="slider">
            <a class="slider-prev"></a>
            <div class="slider-container">
                <ul class="slider-list">
                    <?php 
                        while ( have_posts() ) : the_post();
                    ?>
                    <li>
                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                            <img src="<?php the_cover_src(); ?>" width="150" height='115'>
                        </a>
                    </li>
                    <?php
                        endwhile;
                        wp_reset_query();
                    ?>
                </ul>
            </div>
            <a class="slider-next"></a>
        </div>
    </div>
    <div class="container clearfix">

	    <?php get_template_part('sidebar', 'left'); ?>
		
        <div class="container-center">
            <div class="location">
                <a href="<?php bloginfo('siteurl'); ?>">首页</a>
                <span class="location-div">&nbsp;</span>
                <?php edian66_category_parents_list($cat,' <span class="location-div">&nbsp;</span>'); ?>
            </div>
			
			<?php
				$is_last2 = edian66_is_the_last2_category($cat);
				if($is_last2[0]) 
						get_template_part('content', 'last');
				else if($is_last2[1])
						get_template_part('content', 'last2');
				else
						get_template_part('content', 'first');
			?>    
        </div>
        <?php get_template_part('sidebar', 'right'); ?>
    </div>
<?php get_footer(); ?>