<?php
/*
Template Name: Search Page
*/
get_header(); ?>

    <div id="main" class="container">
        
        <div class="row">
            
            <?php 
            if ( have_posts() ) : ?>
                <h1 class="col-md-12">
                    <?php echo "Pesquisando por: "; the_search_query(); ?>
                </h1>

                <div id="content-blog" class="col-md-7"> 
                    <?php 
                    // The Query
                    //query_posts( 'cat=-7&posts_per_page=3' );

                    // The Loop
                    while ( have_posts() ) : the_post(); 
                        get_template_part('content','index'); 
                    endwhile;

                    // Reset Query
                    //wp_reset_query(); ?>

                    <nav>
                        <div class="nav-previous alignleft"><?php next_posts_link('&laquo; Posts antigos'); ?></div>
                        <div class="nav-next alignright"><?php previous_posts_link('Novos posts &raquo;'); ?></div>
                    </nav>

                </div> <!-- #content-blog -->
            <?php
            endif; ?>
            
            <section id="sidebar" class="col-md-4 col-md-offset-1">
                <?php get_sidebar(); ?>
            </section><!-- #sidebar -->
        
        </div><!-- .row-->
        
    </div><!-- #main -->
    <!--section id="sidebar" class="col-md-4 col-md-offset-1">
        <?php //get_sidebar(); ?>
    </section><!-- #sidebar -->

<?php get_footer(); ?>