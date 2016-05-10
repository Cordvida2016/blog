<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage TT Host Padrão
 * @since TT Host 1.0
 */
get_header(); ?>

    <div id="main" class="container">
        
        <div class="row">
            
            <h1><?php single_cat_title(''); ?></h1>
            
            <div id="content-blog" class="col-md-7"> 

                <?php $loop = new WP_Query( array( 'post_type' => 'colunas', 'posts_per_page' => -1 ) ); ?>
                <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
                    <?php the_title( '<h2 class="entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">', '</a></h2>' ); ?>
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                <?php endwhile; ?>
                
            </div> <!-- #content-blog -->
            
            <section id="sidebar" class="col-md-4 col-md-offset-1">
                <?php get_sidebar(); ?>
            </section><!-- #sidebar -->
        
        </div><!-- .row-->
        
    </div>

<?php get_footer(); ?>