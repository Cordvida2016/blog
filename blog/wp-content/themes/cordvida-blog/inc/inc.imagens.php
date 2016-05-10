<?php

// Exibe as fotos do posts em formatos diferentes de acordo com a página.
if (!function_exists('posts_thumbnail')) :
    
    function posts_thumbnail() {
        
        if (is_singular()) : ?>
            <div class="post-thumbnail">
                <?php the_post_thumbnail(); ?>
            </div><!-- .post-thumbnail -->
        <?php else : ?>
            <a class="post-thumbnail" href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail(array(300,263), array('alt' => get_the_title())); ?>
            </a>
        <?php
        endif; // End is_singular()
    }

endif;