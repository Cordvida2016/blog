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

    <div id="main" <?php post_class('container') ?>>
        
        <div class="row">

            <?php while (have_posts()) : the_post(); ?>
                <article>
                    <header>
                        <h1><?php the_title(); ?></h1>            
                    </header>

                    <p id="conteudo">
                        <?php the_content(); ?>
                    </p>

                    <footer>
                        <?php edit_post_link('Editar', '<p>', '</p>'); ?>
                    </footer>

                </article>
            <?php endwhile; ?>
            
        </div>

    </div>

<?php get_footer(); ?>