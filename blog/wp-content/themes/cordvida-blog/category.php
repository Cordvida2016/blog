<?php
/**
 * The template for displaying Category pages
 *
 * Used to display archive-type pages for posts in a category.
 *
 *
 * @package WordPress
 * @subpackage TT Host Padrão
 * @since TT Host 1.0
 */
// $category = get_the_category();
//echo '<pre>'; print_r($category); echo '</pre>';

get_header(); ?>

    <div id="main" class="container">

        <div class="row">

            <h1><?php single_cat_title(''); ?></h1>

            <div id="content-blog" class="col-md-7">
                <?php
                if (have_posts()):

                    // The Loop
                    while ( have_posts() ) : the_post();
                        get_template_part('content','index');
                    endwhile;

                else:
                    echo "Nenhum post publicado!";
                endif; ?>

                <nav>
                    <?php
                    global $wp_query;

                    $big = 999999999; // need an unlikely integer

                    echo paginate_links(array(
                        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                        'format' => '?paged=%#%',
                        'current' => max(1, get_query_var('paged')),
                        'total' => $wp_query->max_num_pages
                    ));
                    ?>
                </nav>

            </div> <!-- #content-blog -->

            <section id="sidebar" class="col-md-4 col-md-offset-1">
                <?php get_sidebar(); ?>
            </section><!-- #sidebar -->

        </div><!-- .row-->

    </div><!-- #main -->
    <!--section id="sidebar" class="col-md-4 col-md-offset-1">
        <?php //get_sidebar(); ?>
    </section><!-- #sidebar -->

<?php get_footer(); ?>
