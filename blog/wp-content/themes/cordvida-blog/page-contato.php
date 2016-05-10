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
                <article class="col-md-7">
                    
                    <div class="col-md-4">
                        <h2>0800 707-2673</h2>
                        <p><strong>Grande São Paulo</strong><br>
                        11 3094-2673<br>
                        11 2199-2673</p>
                        <div class="redes-contato">
                            <a href="https://www.facebook.com/cordvida.celulastronco" class="facebook" target="_blank">Facebook</a>
                            <a href="https://twitter.com/cordvida" class="twitter" target="_blank">Twitter</a>
                            <a href="http://instagram.com/cordvida" class="instagram" target="_blank">Instagram</a>
                        </div>
                        <address>
                            Rua Alvarenga, 2226<br />
                            Butantã - São Paulo - SP<br />
                            CEP 05509-006
                        </address>
                    </div>                   

                    <div id="conteudo" class="col-md-8">
                        <h3 class="tel"><?php the_title(); ?></h3>
                        <p><?php the_content(); ?></p>
                    </div>
                    
                    <div class="clear"></div>

                    <footer class="col-md-12">
                        <?php edit_post_link('Editar', '<p>', '</p>'); ?>
                    </footer>

                </article>
            
            <?php endwhile; ?>
            
            <section id="sidebar" class="col-md-4 col-md-offset-1">
                <?php get_sidebar(); ?>
            </section><!-- #sidebar -->
        </div><!-- .row -->

    </div><!-- #main -->

<?php get_footer(); ?>