<?php
/**
 * The template used for displaying page content
 *
 * @package WordPress
 * @subpackage Cordvida_Blog
 * @since Cordvida Blog 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('row'); ?>>

    <header class="posts-header col-md-7">
    <?php
      if (has_post_thumbnail()) {
        posts_thumbnail();
      } elseif (get_the_terms($post->ID, 'especialistas')) {
          foreach((get_the_terms($post->ID, 'especialistas')) as $term) {
              $imagem = get_field("foto", "especialistas_" . $term->term_id . '');
              echo '<a href="' . get_permalink($post->ID) . '">';
                  echo '<img src="' . $imagem . '" alt="especialista">';
              echo '</a>';
          }
      } ?>
    </header><!-- .posts-header -->

    <div class="posts-content col-md-5">
        <a href="<?php the_permalink(); ?>"><?php the_title('<h4 class="posts-title">', '</h4>'); ?></a>
        <div class="clearfix"></div>
        <span class="posts-autor"><?php the_author(); ?></span>
        <!-- <?php if (is_post_type_archive('colunas')) { ?>
            <span class="cel-tronco">Células Tronco e gravidez</span>
        <?php } ?> -->
        <span class="posts-data"><?php the_time('d'); ?> de <?php the_time('F - Y'); ?></span>
        <div class="clearfix"></div>
        <?php the_excerpt(); ?>
        <div class="clearfix"></div>
        <a href="<?php the_permalink(); ?>" class="btn btn-index">Ler Mais</a>
    </div><!-- .posts-content -->

    <footer class="col-md-12 posts-footer">
        <?php edit_post_link(); ?>
    </footer><!-- .posts-footer -->

</article><!-- #post-<?php the_ID(); ?> -->
