        <div class="container-right">
            <div class="xuexileyuan box">
                <div class="box-header">
                    <strong>
                        <?php edian66_root_category_title($cat); ?>
                    </strong>
                </div>
                <div class="box-body">
                    <ul>
                        <?php
							$i = 1;
							foreach(edian66_second_categories($cat) as $dir) {
						?>
								<li><a href="<?= get_category_link($dir->cat_ID); ?>"><?= $dir->cat_name ?></a></li>
							<?php 
								if ($i == 1) {
									edian66_category_details($dir);
									$i += 1;
								}
							?>
						
						<?php 
							}
						?>
						
                    </ul>
                </div>
                <div class="box-footer">
                    
                </div>
            </div>
            <div class="site-nav box">
                
            </div>
        </div>