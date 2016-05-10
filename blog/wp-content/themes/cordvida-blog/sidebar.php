<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<section id="sidebar-content" class="row">
    <div class="col-md-12">
        <div id="newsletter">
            <h5>Mais de 10.000 mães estão acompanhando nosso conteúdo! Cadastre seu e-mail e Junte-se a elas!</h5>
            <div class="clearfix"></div>
            <script charset="utf-8" src="//js.hsforms.net/forms/current.js"></script>
            <script>
              hbspt.forms.create({
                portalId: '457831',
                formId: '3ceb9e5f-d1c2-4983-b8d4-4cf6bd629868',
                css:''
              });
            </script>
        </div>

        <div class="clearfix"></div>

        <div id="txt-blog">
            <?php
            // The Query
            query_posts( 'page_id=37' );

            while ( have_posts() ) : the_post(); ?>
                <?php the_content(); ?>
            <?php
            endwhile;

            // Reset Query
            wp_reset_query(); ?>
        </div>

        <div class="clearfix"></div>

        <div id="ebook">
		<!--HubSpot Call-to-Action Code -->
		<span class="hs-cta-wrapper" id="hs-cta-wrapper-6a0ff232-d4c0-4e87-96ef-2ad2e418040f">
		    <span class="hs-cta-node hs-cta-6a0ff232-d4c0-4e87-96ef-2ad2e418040f" id="hs-cta-6a0ff232-d4c0-4e87-96ef-2ad2e418040f">
		        <!--[if lte IE 8]><div id="hs-cta-ie-element"></div><![endif]-->
		        <a href="http://cta-redirect.hubspot.com/cta/redirect/457831/6a0ff232-d4c0-4e87-96ef-2ad2e418040f"  target="_blank" ><img class="hs-cta-img" id="hs-cta-img-6a0ff232-d4c0-4e87-96ef-2ad2e418040f" style="border-width:0px;" src="https://no-cache.hubspot.com/cta/default/457831/6a0ff232-d4c0-4e87-96ef-2ad2e418040f.png"  alt="Ebook grátis: A chegada do bebê"/></a>
		    </span>
		    <script charset="utf-8" src="https://js.hscta.net/cta/current.js"></script>
		    <script type="text/javascript">
		        hbspt.cta.load(457831, '6a0ff232-d4c0-4e87-96ef-2ad2e418040f', {});
		    </script>
		</span>
		<!-- end HubSpot Call-to-Action Code -->
        </div>

		<div class="clearfix"></div>

	    <div class="fb-page" style="margin-top:20px;" 
            data-href="https://www.facebook.com/cordvida.celulastronco"
            data-width="284" 
            data-hide-cover="false"
            data-show-facepile="true" 
            data-show-posts="false">
    	</div>

        <!--h4>NOTÍCIAS PELO MUNDO</h4-->
        <?php
        // The Query
        query_posts( 'cat=6&posts_per_page=1' );

        if ( have_posts() ) : ?>

            <div id="noticias-mundo">
            
                <?php
                // The Loop
                while ( have_posts() ) : the_post(); ?>
                    <article id="posts-depoimentos">
                        <h3 class="tag"><?php echo get_cat_name(6)  ?></h3>
                        <?php if ( has_post_thumbnail() ) : ?>
                            <a class="post-thumbnail" href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('large', array('alt' => get_the_title(),'class'=>'img-responsive')); ?>
                            </a>
                        <?php endif; ?>
                        <?php the_title('<h4>','</h4>'); ?>
                    </article>
                <?php
                endwhile; ?>

            </div><!-- #noticias-mundo -->
        <?php

        endif;
        // Reset Query
        wp_reset_query(); ?>

        <!--HubSpot Call-to-Action Code -->
        <span class="hs-cta-wrapper" id="hs-cta-wrapper-6b32d070-d88a-4d41-a1ee-cec092f5dcb8">
            <span class="hs-cta-node hs-cta-6b32d070-d88a-4d41-a1ee-cec092f5dcb8" id="hs-cta-6b32d070-d88a-4d41-a1ee-cec092f5dcb8">
                <!--[if lte IE 8]><div id="hs-cta-ie-element"></div><![endif]-->
                <a href="http://cta-redirect.hubspot.com/cta/redirect/457831/6b32d070-d88a-4d41-a1ee-cec092f5dcb8"  target="_blank" ><img class="hs-cta-img" id="hs-cta-img-6b32d070-d88a-4d41-a1ee-cec092f5dcb8" style="border-width:0px;" src="https://no-cache.hubspot.com/cta/default/457831/6b32d070-d88a-4d41-a1ee-cec092f5dcb8.png"  alt="Tudo sobre células-tronco do cordão umbilical"/></a>
            </span>
            <script charset="utf-8" src="https://js.hscta.net/cta/current.js"></script>
            <script type="text/javascript">
                hbspt.cta.load(457831, '6b32d070-d88a-4d41-a1ee-cec092f5dcb8', {});
            </script>
        </span>
        <!-- end HubSpot Call-to-Action Code -->


        <!-- <div id="colunaDoEspecialista">

        <?php
            $especialistaQuery = array(
                'category_name' => 'colunas',
                'posts_per_page' => 1
            );

            $query = new WP_Query( $especialistaQuery );

            if ($query -> have_posts()) {
                while ($query->have_posts()) : $query->the_post();
                    echo '<h3 class="tag">Coluna do especialista</h3>';

                    foreach((get_the_terms($post->ID, 'especialistas')) as $term) {
                        // $imagem = get_field("foto", "especialistas_" . $term->term_id . '');
                        $imagem = wp_get_attachment_url( get_post_thumbnail_id() );
                        echo '<a href="' . get_permalink($post->ID) . '" style="background: url(' . $imagem . ') 50% 50% no-repeat; background-size:cover;">';
                            // echo '<img src="' . $imagem . '" alt="especialistas">';
                        echo '</a>';
                        // echo '<p>' . the_field("minibio", "especialistas_" . $term->term_id . '') . '</p>';
                        // echo '<h4>' . get_the_terms($post->ID, "especialistas")[0]->name . '' . '</h4>';
                    }

                    $termos = get_the_terms( $post->ID, 'especialistas' );

                    if ( $termos && ! is_wp_error( $termos ) ) :
                        $especialistas_terms = array();
                        foreach ( $termos as $termo ) {
                            $especialistas_terms[] = $termo->name;
                        }
                        $nome_do_especialista = join( ", ", $especialistas_terms );

                        echo '<h4>' . get_the_title() . '<br /><span>por '. $nome_do_especialista .'</span></h4>';

                    endif;

                    // global $post;
                    // $nome_do_termo = get_the_terms($post->id, 'especialistas');
                    // echo '<h4>' . $nome_do_termo[0]->name . '</h4>';

                endwhile;
            }
        ?>

        </div> -->

        <!-- Widget -->
        <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar')) : ?><?php endif; ?>
    </div>
</section>
