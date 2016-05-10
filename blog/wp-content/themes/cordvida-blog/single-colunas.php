<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage TT Host Padrão
 * @since TT Host 1.0
 */
get_header(); ?>

<div id="main" <?php post_class('container') ?>>
    <div class="row">
        <div class="col-md-7 content-post">
            <?php while (have_posts()) : the_post(); 
                $viewPost = get_post(); //print_r($viewPost);die;
                $category = get_the_category($viewPost->ID); //print_r($category); ?>
                <article>
                    <header>
                        <h1><?php the_title(); ?></h1>            
                    </header>

                    <div id="conteudo">
                        <?php the_content(); ?>
                    </div>

                    <div class="minibio">
                    <?php
                    foreach((get_the_terms($post->ID, 'especialistas')) as $term) {
                        $imagem = get_field('foto', 'especialistas_' . $term->term_id . '');
                        echo '<div class="foto" style="background: url(' . $imagem . ') 50% 50% no-repeat; background-size:cover;">';
                            // echo '<img src="' . $imagem . '" alt="especialistas">';
                        echo '</div>';
                        echo '<div class="texto">';
                            echo '<p>' . the_field("minibio", "especialistas_" . $term->term_id . '') . '</p>';
                    }

                            global $post;
                            $nome_do_termo = get_the_terms($post->id, 'especialistas');
                            echo '<h4>' . $nome_do_termo[0]->name . '</h4>';
                        echo '</div>';
                    ?>
                    </div>

                    <footer>
                        <?php edit_post_link('Editar', '<p>', '</p>'); ?>
                    </footer>
                </article>
            <?php endwhile; ?>

            <div class="clearfix"></div>

            <div class="largo">
                <label for="assine" class="cta-texto largo">
                    <h2>Inscreva-se agora no blog CordVida</h2>
                    + de 5.000 mães recebem nosso conteúdo sobre gravidez e saúde familiar. Cadastre seu e-mail e acompanhe você também!
                </label>

                <script charset="utf-8" src="//js.hsforms.net/forms/current.js"></script>
                <script>
                  hbspt.forms.create({ 
                    portalId: '457831',
                    formId: '421c6631-c2a1-4ccc-8b75-80370e0e3b30',
                    css:''
                  });
                </script>

            </div>
            
            <div class="clearfix"></div>
            
            <div class="cta-posts">
                <!--HubSpot Call-to-Action Code -->
                <span class="hs-cta-wrapper" id="hs-cta-wrapper-17b376a7-ce8c-4ec5-8a4a-54bc300cf8e0">
                    <span class="hs-cta-node hs-cta-17b376a7-ce8c-4ec5-8a4a-54bc300cf8e0" id="hs-cta-17b376a7-ce8c-4ec5-8a4a-54bc300cf8e0">
                        <!--[if lte IE 8]><div id="hs-cta-ie-element"></div><![endif]-->
                        <a href="http://cta-redirect.hubspot.com/cta/redirect/457831/17b376a7-ce8c-4ec5-8a4a-54bc300cf8e0"  target="_blank" ><img class="hs-cta-img" id="hs-cta-img-17b376a7-ce8c-4ec5-8a4a-54bc300cf8e0" style="border-width:0px;" src="https://no-cache.hubspot.com/cta/default/457831/17b376a7-ce8c-4ec5-8a4a-54bc300cf8e0.png"  alt="eBook "Agenda da Gravidez""/></a>
                    </span>
                    <script charset="utf-8" src="https://js.hscta.net/cta/current.js"></script>
                    <script type="text/javascript">
                        hbspt.cta.load(457831, '17b376a7-ce8c-4ec5-8a4a-54bc300cf8e0');
                    </script>
                </span>
                <!-- end HubSpot Call-to-Action Code -->

                <?php 
                /*
                Programação removida. No lugar dela entrou o script do HubSpot. Excluir estas linhas futuramente.
                // The Query
                query_posts( 'cat=8&posts_per_page=1&orderby=rand' );

                // The Loop
                while ( have_posts() ) : the_post(); 
                    $dadosPost = get_post(); 
                    $link_cta = get_post_meta( $dadosPost->ID, 'link_cta' ); 
                    if (has_post_thumbnail()) : */ ?>
                        <!-- <a href="<?php //echo $link_cta[0]; ?>">
                            <?php //the_post_thumbnail( 'full', array( 'alt' => $dadosPost->post_title, 'class' => 'img-responsive' ) ); ?>
                        </a> -->
                    <?php //endif; ?>
                <?php 
                //endwhile; 
                
                // Reset Query
                //wp_reset_query(); ?>
            </div><!-- cta-posts -->
            
            <div class="clearfix"></div>
            
            <div class="posts-rel">
                <h3>Posts Relacionados</h3>
                <ul>
                <?php 
                // The Query
                $args = array(
                    'cat' => $category[0]->cat_ID,
                    'showposts' => 5,
                    'post__not_in' => array($viewPost->ID),
                    'orderby' => 'rand'
                );
                $the_query = new WP_Query( $args );
                
                // The Loop
                if ( $the_query->have_posts() ) :
                    while ( $the_query->have_posts() ): 
                        $the_query->the_post(); ?>
                        <li>
                            <a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a>
                        </li>
                    <?php 
                    endwhile;
                else : ?>
                    <li>Não existem posts relacionados</li>                        
                <?php 
                endif;
                
                 // Reset Query
                wp_reset_postdata(); ?>
                </ul>
            </div>



            <div class="disclaimer">
                <p>“Caro Leitor,</p>
                <p>A CordVida produz o conteúdo desse blog com muito carinho e com o objetivo de divulgar informações relevantes para as futuras mães e pais sobre assuntos que rondam o universo da gravidez.</p>
                <p>Todos os artigos são constituídos por informações de caráter geral, experiências de outros pais, opiniões médicas e por nosso conhecimento científico de temas relacionados às células-tronco. Os dados e estudos mencionados nos artigos são suportados por referências bibliográficas públicas.</p>
                <p>A CordVida não tem como objetivo a divulgação de um blog exaustivo e completo que faça recomendações médicas. O juízo de valor final sobre os temas levantados nesse blog deve ser estabelecido por você em conjunto com seus médicos e especialistas.</p>
            </div>
            
        </div><!-- content-post -->
        <section id="sidebar" class="col-md-4 col-md-offset-1">
            <?php get_sidebar(); ?>
        </section><!-- #sidebar -->
    </div>
</div>


<?php get_footer(); ?>