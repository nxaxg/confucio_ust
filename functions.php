<?php

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////// Filtros y actions
////////////////////////////////////////////////////////////////////////////////

add_theme_support( 'title-tag' );
add_theme_support( 'post-thumbnails' );
add_theme_support('html5');
add_theme_support('menus');

add_action('after_setup_theme', 'confucio_langs');
function confucio_langs(){
    load_theme_textdomain('confucio', get_template_directory() . '/lang');
}

if( function_exists('acf_set_options_page_title') ){
    acf_set_options_page_title('Opciones del sitio');
}

if( function_exists('acf_set_options_page_menu') ){
    acf_set_options_page_menu('Opciones del sitio');
}

if( function_exists('acf_add_options_sub_page') ){
    // configuracion de portada
    acf_add_options_sub_page(array(
        'title' => 'Portada',
        'capability' => 'list_users'
    ));

    // configuracion de generales
    acf_add_options_sub_page(array(
        'title' => 'Generales',
        'capability' => 'list_users'
    ));

    acf_add_options_sub_page(array(
        'title' => 'Destacados',
        'capability' => 'list_users'
    ));
}


////// tamanos de imagen
add_image_size( 'regular-tiny', 260, 146, true );
add_image_size( 'regular-small', 358, 201, true );
add_image_size( 'gallery-module', 400, 400, true );
add_image_size( 'regular-medium', 520, 293, true );
add_image_size( 'regular-big', 590, 332, true );
add_image_size( 'regular-bigger', 812, 457, true );
add_image_size( 'regular-biggest', 1200, 676, true );
add_image_size( 'horizontal', 793, 268, true );
add_image_size( 'square', 285, 285, true );



/////////////////////// Incrusta Estilos y Javascript en el <head>
///
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
add_action("wp_enqueue_scripts", "incrustar_scripts", 20);
function incrustar_scripts(){
    if( !is_admin() ){
        /// scrips que dependen de cada pagina

        wp_deregister_script('jquery');
        wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js', array('modernizr'), '2.1.3', true );

        // modernizr
        wp_register_script('modernizr', get_bloginfo('template_directory') . '/scripts/libs/modernizr.js', array(), '2.6.2', true );

        // google maps API
        wp_register_script('google_maps_api', 'http://maps.googleapis.com/maps/api/js?key=AIzaSyBpJo3_GYICeNkcNurkaMn0UkakPs6mYw8', array(), '1', true );

        // google plus api
        wp_register_script('googleplus', 'https://apis.google.com/js/plusone.js', array(), '1', true );
        wp_register_script('googlePlusClient', 'https://apis.google.com/js/client:plusone.js', array('googleplus'), '1', true );


        // google maps handler
        wp_register_script('mapsHandler', get_bloginfo('template_directory'). '/scripts/libs/ninjaMap.js', array('jquery', 'google_maps_api'), '1', true );

        // validizr
        wp_register_script('validizr', get_bloginfo('template_directory'). '/scripts/libs/validizr.js', array('jquery'), '1', true );

        // Owl Carousel
        wp_register_script('owlCarousel', get_bloginfo('template_directory'). '/scripts/libs/owl.carousel.min.js', array('jquery'), '1', true );

        // ninjaSlider
        wp_register_script('ninjaSlider', get_bloginfo('template_directory'). '/scripts/libs/ninjaSlider.js', array('jquery'), '1', true );

        // landing slider
        wp_register_script('landingSlider', get_bloginfo('template_directory'). '/scripts/libs/landing-slider.js', array('jquery'), '1', true );

        // enquire
        wp_register_script('enquireJS', get_bloginfo('template_directory'). '/scripts/libs/enquire.js', array('jquery'), '1', true );

        // mainScript
        wp_register_script('mainScript', get_bloginfo('template_directory'). '/scripts/main.js', array('enquireJS', 'modernizr', 'jquery', 'validizr'), '1.1', true );

        wp_enqueue_script('mainScript');

        /// en el caso de los single de galerias SIEMPRE necesito los sliders
        if( is_singular('galeria') ){
            wp_enqueue_script('owlCarousel');
            wp_enqueue_script('ninjaSlider');
        }

        // se saca el script de jetpack en el front
        wp_dequeue_script('devicepx');

    }
}

///// imprime las etiquetas de app-icons
add_action("wp_head", "app_icons_metas");
function app_icons_metas(){
    $template = get_bloginfo('template_directory');
    echo '<link rel="icon" href="'. $template .'/images/app-icons/favicon.ico" type="image/x-icon">';
    echo '<link rel="shortcut icon" href="'. $template .'/images/app-icons/favicon.ico" type="image/x-icon">';
    echo '<meta name="msapplication-square70x70logo" content="'. $template .'/images/app-icons/ms-icno-70x70.png">';
    echo '<meta name="msapplication-square150x150logo" content="'. $template .'/images/app-icons/ms-icon-150x150.png">';
    echo '<meta name="msapplication-square310x310logo" content="'. $template .'/images/app-icons/ms-icon-310x310.png">';
    echo '<link rel="apple-touch-icon" href="'. $template .'/images/app-icons/apple-icon.png">';
    echo '<link rel="apple-touch-icon" sizes="76x76" href="'. $template .'/images/app-icons/apple-icon-76x76.png">';
    echo '<link rel="apple-touch-icon" sizes="120x120" href="'. $template .'/images/app-icons/apple-icon-120x120.png">';
    echo '<link rel="apple-touch-icon" sizes="152x152" href="'. $template .'/images/app-icons/apple-icon-152x152.png">';
}

// First, make sure Jetpack doesn't concatenate all its CSS
add_filter( 'jetpack_implode_frontend_css', '__return_false' );
add_action('wp_print_styles', 'sacar_estilos_extra');
function sacar_estilos_extra(){
    if( !is_admin() ){
        // Saco los estilos de jetpack en el front
        wp_deregister_style( 'AtD_style' ); // After the Deadline
        wp_deregister_style( 'jetpack_likes' ); // Likes
        wp_deregister_style( 'jetpack_related-posts' ); //Related Posts
        wp_deregister_style( 'jetpack-carousel' ); // Carousel
        wp_deregister_style( 'grunion.css' ); // Grunion contact form
        wp_deregister_style( 'the-neverending-homepage' ); // Infinite Scroll
        wp_deregister_style( 'infinity-twentyten' ); // Infinite Scroll - Twentyten Theme
        wp_deregister_style( 'infinity-twentyeleven' ); // Infinite Scroll - Twentyeleven Theme
        wp_deregister_style( 'infinity-twentytwelve' ); // Infinite Scroll - Twentytwelve Theme
        wp_deregister_style( 'noticons' ); // Notes
        wp_deregister_style( 'post-by-email' ); // Post by Email
        wp_deregister_style( 'publicize' ); // Publicize
        wp_deregister_style( 'sharedaddy' ); // Sharedaddy
        wp_deregister_style( 'sharing' ); // Sharedaddy Sharing
        wp_deregister_style( 'stats_reports_css' ); // Stats
        wp_deregister_style( 'jetpack-widgets' ); // Widgets
        wp_deregister_style( 'jetpack-slideshow' ); // Slideshows
        wp_deregister_style( 'presentations' ); // Presentation shortcode
        wp_deregister_style( 'jetpack-subscriptions' ); // Subscriptions
        wp_deregister_style( 'tiled-gallery' ); // Tiled Galleries
        wp_deregister_style( 'widget-conditions' ); // Widget Visibility
        wp_deregister_style( 'jetpack_display_posts_widget' ); // Display Posts Widget
        wp_deregister_style( 'gravatar-profile-widget' ); // Gravatar Widget
        wp_deregister_style( 'widget-grid-and-list' ); // Top Posts widget
        wp_deregister_style( 'jetpack-widgets' ); // Widgets
    }
}

//// metemos el estilo principal en el footer para dejar feliz a pagespeed insights
add_action('wp_print_styles', 'incrustar_estilos');
function incrustar_estilos(){
    wp_register_style('main_style', get_bloginfo('template_directory') . '/css/main.css' );
    wp_enqueue_style( 'main_style' );
}

/////////////////////// Saca los query strings de los css y js, ayuda al page speed
add_filter( 'style_loader_src', 'vc_remove_wp_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'vc_remove_wp_ver_css_js', 9999 );
function vc_remove_wp_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=' ) ) { $src = remove_query_arg( 'ver', $src ); }
    return $src;
}

/////////////////////// Saca la version de wordpress del head para seguridad
add_filter('the_generator', 'remove_wp_version');
function remove_wp_version() { return ''; }

/////////////////////// Saca los widgets inecesarios del dashboard
add_action('wp_dashboard_setup', 'sacar_dashboard_widgets' );
function sacar_dashboard_widgets(){
    remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
}

/////////////////////// se encarga de sobreescribir algunas urls amigables
add_action('init', 'change_default_rewrites');
function change_default_rewrites(){
    global $wp_rewrite;
    $wp_rewrite->search_base = 'busqueda';
}

/////////////////////// Cambia la url de busqueda
add_action( 'template_redirect', 'cambiar_busqueda_url' );
function cambiar_busqueda_url() {
    if ( is_search() && isset( $_GET['s'] ) && !empty( $_GET['s'] ) ) {
        wp_redirect( home_url( "/busqueda/" ) . urlencode( get_query_var( 's' ) ) );
        exit();
    }
}

////////////////////// Le quita el contenedor a la funcion we_nav_menu
function confucio_wp_nav_menu_args( $args = '' ) {
    $args['container'] = false;
    return $args;
}
add_filter( 'wp_nav_menu_args', 'confucio_wp_nav_menu_args' );

////////////////////// Quita del admin la interfaz de los posts comunes y otras cosas por defecto porque no se van a usar
add_action('admin_menu', 'remove_default_menus');
function remove_default_menus(){
    if( function_exists('remove_menu_page') ){
        remove_menu_page('edit.php'); // post comunes
        remove_menu_page('edit-comments.php'); // comentarios
        remove_menu_page('link-manager.php'); // Links
    }
}

////////////////////////////////////////////////////////////////////////////////
//////////////////// Nav Menus
////////////////////////////////////////////////////////////////////////////////
add_action( 'after_setup_theme', 'resgistrar_menus' );
function resgistrar_menus() {
    register_nav_menu( 'principal', __( 'Menu Principal', 'confucio' ) );
    register_nav_menu( 'menutop', __( 'Menu Top', 'confucio' ) );
    register_nav_menu( 'conocemas', __( 'Menu Conoce más', 'confucio' ) );
    register_nav_menu( 'cursos_conocemas', __( 'Menu Conoce más en cursos', 'confucio' ) );
    register_nav_menu( 'secundario', __( 'Menu Secundario', 'confucio' ) );
    register_nav_menu( 'menufooter', __( 'Menu Footer', 'confucio' ) );
    register_nav_menu( 'menusidebar', __( 'Menu Sidebar', 'confucio' ) );
    register_nav_menu( 'mapasitio', __( 'Mapa del sitio', 'confucio' ) );
}

////////////////////////////////////////////////////////////////////////////////
//////////////////// Filtros para ACF
////////////////////////////////////////////////////////////////////////////////
add_filter('acf/fields/relationship/query/name=navegacion_informacion', 'alter_cursos_relation', 10, 3);
add_filter('acf/fields/relationship/query/name=navegacion_cursos', 'alter_cursos_relation', 10, 3);
add_filter('acf/fields/relationship/query/name=inscripcion', 'alter_cursos_relation', 10, 3);
add_filter('acf/fields/relationship/query/name=accesos', 'alter_cursos_relation', 10, 3);
function alter_cursos_relation( $args, $field, $post ){
    $args['post_parent'] = $post->ID;
    return $args;
}

add_filter('acf/fields/relationship/query/name=cursos_disponibles', 'alter_inscripcion_cursos_relation', 10, 3);
function alter_inscripcion_cursos_relation( $args, $field, $post ){
    $args['post_parent'] = $post->post_parent;
    return $args;
}

////////////////////////////////////////////////////////////////////////////////
//////////////////// Adicion de boton para generar HTML de newsletter
////////////////////////////////////////////////////////////////////////////////
add_action( 'edit_form_after_title', 'add_get_html_button_news' );
function add_get_html_button_news( $post ){
    // si no es un newsletter pa fuera

    if( $post->post_type != 'newsletter' ){ return false; }
    echo '<a id="get-HTML-for-news" class="button button-primary" href="#" title="Obtener Código Html" rel="nofollow" style="margin-bottom: 20px;">Ver código HTML</a>';
}

add_action( 'admin_enqueue_scripts', 'add_admin_scripts', 10, 1 );
function add_admin_scripts( $hook ) {
    global $post;

    if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
        if ( 'newsletter' === $post->post_type ) {
            wp_enqueue_style( 'html_news_css', get_bloginfo('template_directory') .'/css/getNewsHTMLStyle.css' );
            wp_enqueue_script( 'html_news_js', get_bloginfo('template_directory') .'/scripts/getNewsHTMLScript.js' );
        }
    }
}

add_action('wp_ajax_get_news_html', 'ajax_get_news_html');
function ajax_get_news_html(){
    $permalink = get_permalink( $_REQUEST['post_id'] );
    die( $permalink );
}


////////////////////////////////////////////////////////////////////////////////
//////////////////// Filtros de wp_query
////////////////////////////////////////////////////////////////////////////////
/**
 * Solo debe3ria actuar en los archivos de galerias, articulos de expertos y calendarios
 */
add_action( 'pre_get_posts', 'alter_archive_queries' );
function alter_archive_queries( $query ){
    global $paged;

    // nada de esto se activa en el admin
    if( is_admin() ){ return; }

    // solo se activa en la query global, no en las customizadas
    if( ! $query->is_main_query() ){ return; }

    if( is_tax('tipo_agenda') ){
        $query->set('post_type', 'agenda');
        $query->set('posts_per_page', 10);
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'ASC');
        $query->set('meta_query', array(
            array(
                'key'     => 'fecha',
                'value'   => date('Ymd'),
                'compare' => '>=',
            )
        ));

        $query->set( 'tax_query', null );

        // buscamos el filtro de sede
        if( isset($_GET['sede-filtro']) && $_GET['sede-filtro'] && is_numeric($_GET['sede-filtro']) ){
            $query->set( 'tax_query', merge_tax_query( $query->get('tax_query'), array(
                'taxonomy' => 'sede',
                'field' => 'term_id',
                'terms' => intval($_GET['sede-filtro'])
            )));
        }
    }

    if( is_post_type_archive('publicacion') ){
        $query->set('posts_per_page', 12);
    }
}

////////////////////////////////////////////////////////////////////////////////
//////////////////// Filtros en Admin para usuarios con sede asociada
////////////////////////////////////////////////////////////////////////////////
add_action('pre_get_posts', 'filtrar_contenidos_usuario');
function filtrar_contenidos_usuario( $query ){
    global $pagenow;

    // solo afectamos a la lista de posts en admin
    if( !is_admin() || $pagenow !== 'edit.php' ){ return; }

    $current_user = wp_get_current_user();
    $user_role = get_current_user_role( $current_user );

    // si el usuario no es periodista_sede o colaborador_sede entonces no se hace nada
    if( $user_role !== 'periodista_sede' && $user_role !== 'colaborador_sede' ){ return; }

    $sede_asociada = (int)get_field('sede_asociada', 'user_'. $current_user->ID );

    // si el term tiene padre es por que es "todas las sedes"
    // en ese caso el filtro no actua
    if( is_parent_term( $sede_asociada, 'sede_asociada') ){ return; }

    // se afectan todas las queries para que muestren solo los contenidos de las sedes
    $query->set('tax_query', merge_tax_query( $query->get('tax_query'), array(
        'taxonomy' => 'sede',
        'field'    => 'id',
        'terms'    => array( $sede_asociada )
    )));
}

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////// Rewrites personalizados
////////////////////////////////////////////////////////////////////////////////
add_action('init', 'rewrites_personalizados');
function rewrites_personalizados(){
    // url de exito en el formulario de newsletter
    add_rewrite_rule('newsletter/exito$', 'index.php?page_id='. get_post_by_slug('newsletter', 'ID') .'&pagename=newsletter', 'top');

    // url de exito en el formulario de contacto
    add_rewrite_rule('contacto/exito$', 'index.php?page_id='. get_post_by_slug('contacto', 'ID') .'&pagename=contacto', 'top');

    // url de exito en el formulario de pre inscripcion de talleres
    add_rewrite_rule('talleres-y-actividades/pre-inscripcion/exito$', 'index.php?page_id='. get_post_by_slug('pre-inscripcion', 'ID') .'&pagename=pre-inscripcion', 'top');

    // url de exito en el formulario de pre inscripcion de cursos
    add_rewrite_rule('cursos/proceso-de-inscripcion/exito$', 'index.php?page_id='. get_post_by_slug('proceso-de-inscripcion', 'ID') .'&pagename=proceso-de-inscripcion', 'top');

    // url de exito en el formulario de pre inscripcion de examen HSK
    //add_rewrite_rule('examen-hsk/inscripcion/exito$', 'index.php?page_id='. get_post_by_slug('inscripcion', 'ID') .'&pagename=inscripcion', 'top');
    add_rewrite_rule('examen-hsk/inscripcion-examen-hsk/exito$', 'index.php?page_id='. get_post_by_slug('inscripcion-examen-hsk', 'ID') .'&pagename=inscripcion-examen-hsk', 'top');
}

// filtro para embed de youtube
add_filter( 'embed_oembed_html', 'filtrar_youtube_embed', 10, 4 ) ;
function filtrar_youtube_embed($html, $url, $attr, $post_id) {
    return str_replace( '?feature=oembed', '?feature=oembed&modestbranding=1&showinfo=0&rel=0', $html );
}

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////// Funciones Generales
////////////////////////////////////////////////////////////////////////////////

/**
 * Genera el HTML correspondientes a los modulos de noticias en las paginas
 * @param  string $cat_slug - slug del termino de las noticias a sacar, por defecto es "instituto-confucio"
 * @param  int $num - numero de noticias a sacar
 * @param  string $output - Que tipo de output devolver, valores: "html" para devolver string html, "array" para devolver un array asociativo
 * @param  array $options - array de opciones para la funcion
 * @return string - HTML de los modulos, incluido el link a la portadilla interna de noticias
 */
function get_noticias( $cat_slug = 'instituto-confucio', $num = 2, $output = 'html', $options = [] ){
    $settings = shortcode_atts([
        'box_options' => []
    ], $options);

    // primero sacamos el link de la portadilla interna
    $noticias_id = get_post_by_slug( 'noticias', 'ID' );
    $titulo_noticias = get_the_title( $noticias_id );

    $title_link = '<h2 class="section-title small icon plus">';
    $title_link .= '<a class="bg-primario" href="'. get_permalink( $noticias_id ) .'" title="'. pll__("Ir a ". $titulo_noticias) .'" rel="section">'. $titulo_noticias .'</a>';
    $title_link .= '</h2>';

    // se cambia de blog a "enlinea" (id = 2)
    switch_to_blog( 2 );

    $news_query = new WP_Query(array(
        'posts_per_page' => $num,
        'post_type' => 'post',
        'orderby' => 'date',
        'order' => 'DESC',
        'category_name' => $cat_slug
    ));

    $news = [];

    if( $news_query->have_posts() ){
        while ( $news_query->have_posts() ) {
            $news_query->the_post();
            $news[] = generate_generic_module( $news_query->post, $settings['box_options'] );
        }
    }

    // se restaura el blog al original (confucio)
    restore_current_blog();
    wp_reset_query();

    if( $output === 'html' ) {
        $out = $title_link;
        $out .= implode('', $news);

        return $out;
    }
    else {
        return [
            'title_link' => $title_link,
            'items' => $news
        ]; 
    }
}

/**
 * Crea el archivo de noticias de confucio que provienen de st en linea
 * @return string - html del archivo incluyendo paginacion
 */
function get_noticias_archive() {
    global $paged, $noticia_excluded;

    // se cambia de blog a "enlinea" (id = 2)
    switch_to_blog( 2 );

    $news_query = new WP_Query(array(
        'posts_per_page' => 5,
        'post_type' => 'post',
        'orderby' => 'date',
        'order' => 'DESC',
        'category_name' => 'instituto-confucio',
        'post__not_in' => $noticia_excluded,
        'paged' => $paged
    ));

    $news = '';

    if( $news_query->have_posts() ){
        while ( $news_query->have_posts() ) {
            $news_query->the_post();
            $news .= generate_generic_module( $news_query->post, array(
                'classes' => 'archive thumbnail',
                'thumbnail' => true,
                'columns' => true
            ));
        }
    }

    $pagination = get_pagination( $news_query );

    // se restaura el blog al original (confucio)
    restore_current_blog();
    wp_reset_query();

    $out = $news;
    $out .= $pagination;

    return $out;
}

/**
 * Genera el modulo de noticia destacada en la portadilla de noticias, tambien le indica a "get_noticias_archive" el posts destacado para que no se repita en el archivo
 * @return string - HTML del modulo
 */
function get_noticias_featured_archive(){
    global $noticia_excluded;

    // se cambia de blog a "enlinea" (id = 2)
    switch_to_blog( 2 );

    $noticia_excluded = array();

    $news_query = new WP_Query(array(
        'posts_per_page' => 1,
        'post_type' => 'post',
        'orderby' => 'date',
        'order' => 'DESC',
        'category_name' => 'instituto-confucio'
    ));

    $news = '';

    if( $news_query->have_posts() ){
        while ( $news_query->have_posts() ) {
            $news_query->the_post();
            $noticia_excluded[] = $news_query->post->ID;

            $news .= generate_generic_module( $news_query->post, array(
                'classes' => 'featured thumbnail',
                'thumbnail' => true,
                'columns' => true
            ));
        }
    }

    // se restaura el blog al original (confucio)
    restore_current_blog();
    wp_reset_query();

    return $news;
}

/**
 * Crea el archivo de noticias de confucio que provienen de st en linea
 * @return string - html del archivo incluyendo paginacion
 */
function get_festivities_archive() {
    global $paged, $noticia_excluded;

    $query = new WP_Query(array(
        'posts_per_page' => 12,
        'post_type' => 'festividad',
        'orderby' => 'date',
        'order' => 'DESC',
        'post__not_in' => $noticia_excluded,
        'paged' => $paged
    ));

    $items = '';

    if( $query->have_posts() ){
        while ( $query->have_posts() ) {
            $query->the_post();
            $items .= '<div class="grid-4 grid-tablet-6 grid-smalltablet-12">';
            $items .= generate_generic_module( $query->post, array(
                'classes' => 'archive thumbnail',
                'thumbnail' => true
            ));
            $items .= '</div>';
        }
    }

    $pagination = get_pagination( $query );

    wp_reset_query();

    $out = '<div class="parent" data-equalize="children" data-mq="vertical-tablet-down">';
    $out .= $items;
    $out .= '</div>';
    $out .= $pagination;

    return $out;
}

/**
 * Genera el modulo de noticia destacada en la portadilla de noticias, tambien le indica a "get_noticias_archive" el posts destacado para que no se repita en el archivo
 * @return string - HTML del modulo
 */
function get_festivities_featured_archive(){
    global $noticia_excluded;

    $noticia_excluded = array();

    $query = new WP_Query(array(
        'posts_per_page' => 1,
        'post_type' => 'festividad',
        'orderby' => 'date',
        'order' => 'DESC'
    ));

    $items = '';

    if( $query->have_posts() ){
        while ( $query->have_posts() ) {
            $query->the_post();
            $noticia_excluded[] = $query->post->ID;
            $items .= generate_generic_module( $query->post, array(
                'classes' => 'featured thumbnail archive',
                'thumbnail' => true,
                'columns' => true
            ));
        }
    }

    wp_reset_query();
    return $items;
}

/**
 * Crea el archivo de galerias de confucio que provienen de st en linea
 * @return string - html del archivo incluyendo paginacion
 */
function get_gallery_archive() {
    global $paged;

    // se cambia de blog a "enlinea" (id = 2)
    switch_to_blog( 2 );

    $gal_query = new WP_Query(array(
        'post_type' => 'galeria',
        'posts_per_page' => 12,
        'orderby' => 'date',
        'order' => 'DESC',
        'paged' => $paged,
        'tax_query' => array(
            array(
                'taxonomy' => 'categorias_galerias',
                'field'    => 'slug',
                'terms'    => 'instituto-confucio'
            )
        )
    ));

    $arch = '';

    if( $gal_query->have_posts() ){
        while( $gal_query->have_posts() ){
            $gal_query->the_post();
            $arch .= '<div class="grid-3 grid-tablet-4 grid-smalltablet-6 grid-mobile-4">';
            $arch .= generate_gallery_module( $gal_query->post->ID );
            $arch .= '</div>';
        }
    }

    $pagination = get_pagination( $gal_query );

    // se restaura el blog al original (confucio)
    restore_current_blog();
    wp_reset_query();

    $out = '<section class="parent page-body">';
    $out .= $arch;
    $out .= '</section>';
    $out .= $pagination;

    return $out;
}

/**
 * Lista las galerias de la pagina de inicio
 * @return string HTML de las galerias
 */
function get_featured_galleries( $wrapper_class = 'grid-6 grid-smalltablet-6 grid-mobile-4 no-gutter-mobile' ){
    $featured = get_field('featured_galleries', 'options');

    $out = '';
    $i = 0;
    if( !empty($featured) ){
        foreach( $featured as $feat ){
            $out .= '<div class="'. $wrapper_class .'">';
            $out .= generate_gallery_module( $feat );
            $out .= '</div>';

            $i++;
        }
    }

    return $out;
}

/**
 * Genera el HTML de varias noticias en base a los settings de la WP_Query indicados
 * @param  array $query_args - Argumentos de configuracion para WP_Query
 * @param  array $options - Argumentos de configuracion para la generacion de cada modulo
 * @param  bool $paginate - Decide si es que se usara paginacion, si esta opcion es 'true' entonces se devuelve un array con los resultados y la paginacion por separado
 * @param  bool $use_main_query - Decide si es que se usa la $wp_query global o se genera una nueva, si esta en 'true' los $query_args quedan innocuos
 * @return string HTML
 */
function generate_news_list( $query_args, $options = array(), $paginate = false, $use_main_query = false ){
    // preparo la funcion en caso de que se quiera usar la wp_query nativa
    if( $use_main_query ){
        global $wp_query;
        $query = $wp_query;
    }
    else {
        $query = new WP_Query( $query_args );
    }


    $out = '';
    if( $query->have_posts() ){
        while( $query->have_posts() ){
            $query->the_post();

            $out .= generate_regular_news( $query->post, shortcode_atts(array(
                'classes' => '',
                'thumbnail' => true,
                'excerpt' => 45,
                'meta' => true
            ), $options));
        }
    }

    $pagination = null;
    if( $paginate ){
        $pagination = get_pagination( $query );
    }

    wp_reset_query();

    if( $paginate ){
        return array(
            'items' => $out,
            'pagination' => $pagination
        );
    }

    return $out;
}

/**
 * Genera el modulo HTML generico de las noticias
 * @param  mixed $news_id_or_object - ID o $post_object correspondient a la noticia que se quiera formatear
 * @param  array  $options - Array de opciones para el modulo
 * @return string - HTML del modulo
 */
function generate_regular_news( $news_id_or_object, $options = array() ){
    $settings = shortcode_atts(array(
        'classes' => '',
        'thumbnail' => false,
        'excerpt' => false,
        'meta' => false,
        'category' => true,
        'additional-content' => false,
        'type' => 'regular',
        'orderby' => 'post_date',
        'order' => 'ASC'
    ), $options);

    $news = null;
    if( is_numeric( $news_id_or_object ) ){
        $news = get_post( $news_id_or_object );
    }
    elseif( is_object( $news_id_or_object ) ){
        $news = $news_id_or_object;
    }
    else { return false; }

    $taxonomy = 'category';
    if( $news->post_type === 'articulo_experto' ){ $taxonomy = 'temas_expertos'; }

    $news_term = false;

    $assigned_cats = wp_get_post_terms($news->ID, $taxonomy);
    if( !empty($assigned_cats) && $settings['category'] ){ $news_term = $assigned_cats[0]; }

    $permalink = get_permalink( $news->ID );

    $out = '<article data-views="'. get_post_meta($news->ID, '_visitas', true) .'" class="regular-news-box '. $settings['classes'] .'">';

    if( $settings['thumbnail'] && $settings['type'] === 'featured' ){
        $out .= '<a href="'. $permalink .'" title="Ver Noticia" rel="contents">';
        $out .= get_the_post_thumbnail($news->ID, 'list-news', array('class' => 'featured-news-thumbnail'));
        $out .= '</a>';
    }

    if( $news_term ){
        $out .= '<a class="regular-news-cat" href="'. get_term_link($news_term) .'" title="Ver más en '. $news_term->name .'" rel="cat">'. $news_term->name .'</a>';
    }

    $out .= '<h3 class="regular-news-title">';
    $out .= '<a href="'. $permalink .'" title="Ver noticia" rel="contents">'. get_the_title( $news->ID ) .'</a>';
    $out .= '</h3>';

    if( $settings['thumbnail'] || $settings['excerpt'] || $settings['meta'] ){
        $out .= '<div  class="clearfix">';

        if( $settings['thumbnail'] && $settings['type'] === 'regular' ){
            $out .= '<a href="'. $permalink .'" title="Ver Noticia" rel="contents">';
            $out .= get_the_post_thumbnail($news->ID, 'list-news', array('class' => 'regular-news-thumbnail'));
            $out .= '</a>';
        }

        if( $settings['excerpt'] ){
            $content = strip_shortcodes( $news->post_content );
            $out .= '<p class="regular-news-excerpt">'. wp_trim_words( $content, $settings['excerpt'], '...' ) .'</p>';
        }

        if( $settings['meta'] ){
            $author = get_user_by( 'id', $news->post_author );
            $author_url = get_author_posts_url( $news->post_author );
            $author_name = get_user_name( $author );

            $post_date = date_i18n('d/m/Y', strtotime( $news->post_date ));

            //para los expertos si se expone el perfil del autor
            if( $news->post_type === 'articulo_experto' ){
                $expert = get_expert_data( $news->post_author );

                $out .= '<p class="regular-news-meta">Por ';
                $out .= '<a href="'. $expert['permalink'] .'" title="Ver el perfil de '. $expert['name'] .'" rel="author" >'. $expert['name'] .'</a>';
                $out .= ' el '. $post_date .'</p>';
            }
            // para las noticias comunes se usa la sede asociada
            else {
                $out .= '<p class="regular-news-meta">Publicado ';

                $sede = wp_get_post_terms($news->ID, 'sede');
                $autoria = 'DEC Santo Tomás';

                if( !empty($sede) ){
                    $sede = $sede[0];
                    if( $sede->slug !== 'todas-las-sedes' ){
                        $autoria = 'DEC '. $sede->name;
                    }
                    // $name_author  = get_the_author_meta('first_name', $post->post_author).' ';
                    // $name_author .= get_the_author_meta('last_name', $post->post_author);

                }

                $out .= 'por <strong>'. $autoria .'</strong> ';
                $out .= 'el '. $post_date .'</p>';
            }

            $icons = get_field('tipos_contenido', $news->ID);
            if( !empty($icons) ){
                $out .= '<p class="regular-news-meta">Este artículo contiene ';

                foreach( $icons as $icon ){
                    $out .= '<i class="icon-element icon-right '. $icon .'" aria-hidden="true" ></i>';
                }

                $out .= '</p>';
            }
        }

        $out .= '</div>';
    }

    if( $settings['additional-content'] ){
        $out .= $settings['additional-content'];
    }

    $out .= '</article>';

    return $out;
}

/**
 * Devuelve una lista de eventos
 * @param  array $args - Lista de argumentos adicionales a pasarse a WP_Query
 * @param  bool $paginate - Decide si generar la paginacion
 * @param  bool $use_main_query - Decide si usar un WP_Query personalizao o el global
 * @param  array $options - array de opciones para la funcion
 * @return string - HTML de los modulos
 */
function get_eventos( $args = array(), $paginate = false, $use_main_query = false, $options = [] ){
    $settings = shortcode_atts([
        'wrap_start' => false,
        'wrap_end' => false,
    ], $options);

    global $wp_query;

    if( $use_main_query ){
        $q = $wp_query;
    }
    else {
        $query_args = array_merge(array(
            'post_type' => 'agenda',
            'meta_key' => 'fecha',
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
            'meta_query' => array(
                array(
                    'key'     => 'fecha',
                    'value'   => date('Ymd'),
                    'compare' => '>=',
                )
            )
        ), $args);

        $q = new WP_Query( $query_args );
    }

    $html = '';
    if( $q->have_posts() ){
        while( $q->have_posts() ){
            $q->the_post();
            $html .= $settings['wrap_start'];
            $html .= generate_event_module( $q->post );
            $html .= $settings['wrap_end'];
        }
    }

    // si se da la directiva 'paged' obviamente quiero un paginador
    if( $paginate ){
        $html .= get_pagination( $q );
    }

    wp_reset_query();

    return $html;
}

/**
 * Genera la navegación interna de las paginas, para el sidebar
 * @param  int $parent_id - post_id de donde sacar los hijos
 * @param  int $current_id - post_id para forzar un estado activo, debe corresponderse con algun hijo de $parent_id
 * @return string - HTML de la navegacion
 */
function get_page_navigation( $parent_id, $current_id = 0 ){
    global $post;

    $children = get_posts(array(
        'posts_per_page' => -1,
        'post_type' => 'page',
        'post_parent' => $parent_id,
        'orderby' => 'menu_order',
        'order' => 'ASC'
    ));

    $html = '<a class="parent-section" href="'. get_permalink($parent_id) .'" title="'. get_the_title($parent_id) .'" rel="section">'. get_the_title($parent_id) .'</a>';

    foreach( $children as $child ){
        $current = is_page( $child->ID ) || $post->ID === $child->ID || $current_id === $child->ID ? 'current' : '';
        $title = get_the_title( $child->ID );

        $html .= '<a class="'. $current .'" href="'. get_permalink($child->ID) .'" title="'. pll__('Ir a '. $title) .'" rel="section">'. $title .'</a>';
    }

    wp_reset_query();

    return $html;
}

/**
 * Clon de get_page_navigation con la salvedad que este esta preparado para menus de segundo nivel
 * -- malditos disenadores y sus logicas incoherentes --
 * @param  int $parent_id - post_id de donde sacar los hijos
 * @return string - HTML de la navegacion
 */
function get_sub_page_navigation( $parent_id ){
    $children = get_posts(array(
        'posts_per_page' => -1,
        'post_type' => 'page',
        'post_parent' => $parent_id,
        'orderby' => 'menu_order'
    ));

    $html = '';

    foreach( $children as $child ){
        $html .= '<p class="page-nav-parent">'. get_the_title( $child->ID ) .'</p>';
        $html .= get_page_navigation( $child->ID );
    }

    wp_reset_query();

    return $html;
}

/**
 * Genera y devuelve el HTML
 *
 * @param  array $data - Informacion del ACF del curso
 * @return string - HTML de los tabs
 */
function get_cursos_tabs( $data ){
    global $post;

    // si viene vacio, nada que hacer
    if( empty($data) ){ return; }

    $tab_controls = '';
    $tab_items = '';

    $count = 0;
    foreach( $data as $tab ){
        $active = $count === 0 ? 'active' : '';
        $tab_slug = sanitize_title( $tab['titulo'] );

        $tab_controls .= '<button class="tab-button '. $active .'" data-func="tabControl" data-target="'. $tab_slug .'" >'. $tab['titulo'] .'</button>';

        $tab_items .= '<article class="tab-item '. $active .'" data-tab-name="'. $tab_slug .'">';
        $tab_items .= '<div class="page-content bg-blanco">';

        $tab_items .= '<h2 class="important-title">Módulo: '. $tab['titulo'] .'</h2>';

        $tab_items .= apply_filters('the_content', $tab['introduccion']);
        $tab_items .= '<p class="indicator duration" ><strong>'. $tab['duracion'] .'</strong></p>';

        if( !empty($tab['sedes_asociadas']) ){
            $tab_items .= '<h3>Sedes donde se imparte</h3>';
            $tab_items .= '<p>El módulo básico se imparte en las sedes de:</p>';
            foreach( $tab['sedes_asociadas'] as $sede_id ){
                $sede_page_id = get_sede_page( $sede_id );
                $tab_items .= '<a class="pretty-link arrow" href="'. get_permalink($sede_page_id) .'" title="Ver sede" rel="subsection">'. get_the_title($sede_page_id) .'</a>';
            }
        }

        if( isset($tab['valores']) && $tab['valores'] ){
            $tab_items .= '<h3>Valores</h3>';
            $tab_items .= '<p><strong>'. $tab['valores'] .'</strong></p>';
        }

        if( isset($tab['descargable']) && $tab['descargable'] ){
            $file = get_file_info( $tab['descargable'] );
            $tab_items .= '<a class="pretty-link download" href="'. $file['file_url'] .'" title="Descargar más información" rel="subsection">Descargar más información</a>';
        }

        if( isset($tab['informacion_adicional']) && $tab['informacion_adicional'] ){
            $tab_items .= apply_filters('the_content', $tab['informacion_adicional']);
        }

        // el link de inscripcion se saca del campo del padre (portadilla cursos) para evitar doble configuracion
        $inscripcion = get_field('inscripcion', $post->post_parent)[0];
        $tab_items .= '<a class="button secundario" href="'. get_permalink($inscripcion) .'?curso='. sanitize_title($tab['titulo']) .'" title="Ver fomulario de inscripción" rel="contents">Inscribirme</a>';

        if( !empty($tab['profesores']) ){

            $tab_items .= '<div class="course-teachers-holder">';
            $tab_items .= '<h3>Profesores</h3>';
            $tab_items .= '<p>Los docentes que realizan las clases de este módulo son:</p>';
            $tab_items .= '<div class="course-teachers parent">';

            foreach( $tab['profesores'] as $profesor ){
                $sedes = '';
                if( isset($profesor['sedes']) && !empty($profesor['sedes']) ){
                    $sedes_arr = array_map(function($term){
                        return $term->name;
                    },$profesor['sedes']);

                    $sedes = 'Sedes: '. implode(', ', $sedes_arr);
                }

                $tab_items .= '<div class="grid-4 grid-smalltablet-12 no-gutter-smalltablet">';
                $tab_items .= generate_figure_module(array(
                    'foto_url' => wp_get_attachment_image_src( $profesor['foto'], 'square' )[0],
                    'nombre' => $profesor['nombre'],
                    'meta_1' => $sedes,
                    'meta_2' => 'Cursos: '. $profesor['cursos'],
                    'meta_3' => 'Origen: '. $profesor['origen']
                ));
                $tab_items .= '</div>';
            }

            $tab_items .= '</div>';
            $tab_items .= '</div>';
        }

        $tab_items .= generate_article_actions_box( $post, $tab['introduccion'], $tab_slug );

        $tab_items .= '</div>';
        $tab_items .= '</article>';

        $count++;
    }

    $html = '<div class="tabs-holder">';
    $html .= '<div class="tabs-controls">';
    $html .= $tab_controls;
    $html .= '</div>';
    $html .= '<div class="tabs-box">';
    $html .= $tab_items;
    $html .= '</div>';
    $html .= '</div>';

    return $html;
}

/**
 * Busca y formatea los ultimos testimonios para mostrarlos en el mosaico de la home
 * @DEPRECATED!
 * @return string HTML del mosaico
 */
function get_testimonials_mosaic(){
    global $wpdb;
    $testimonios = $wpdb->get_results("
        SELECT ID
        FROM $wpdb->posts
        WHERE post_type = 'testimonio'
        AND post_status = 'publish'
        ORDER BY post_date
        DESC LIMIT 7" );
    $testimonios = array_map(function( $val ){ return $val->ID; }, $testimonios);

    $html = '<div class="container mosaic" data-role="mosaic3d">';

    // primer cuadrante
    $cuadrante = array_slice($testimonios, 0, 2);
    $html .= '<div class="mosaic-section small">';
    foreach( $cuadrante as $test_id ){
        $bg_img = wp_get_attachment_image_src( get_post_thumbnail_id($test_id), 'regular-big' )[0];
        $html .= '<a style="background-image: url('. $bg_img .');" class="mosaic-item testimonial" href="'. get_permalink($test_id) .'" title="Ver '. get_the_title($test_id) .'" rel="contents">';
        $html .= '<span class="mosaic-item-desc" >'. get_the_title($test_id) .'</span>';
        $html .= '</a>';
    }
    $html .= '</div>';

    // segundo cuadrante (grande)
    $cuadrante = array_slice($testimonios, 2, 1);
    $html .= '<div class="mosaic-section big">';
    foreach( $cuadrante as $test_id ){
        $bg_img = wp_get_attachment_image_src( get_post_thumbnail_id($test_id), 'regular-big' )[0];
        $html .= '<a style="background-image: url('. $bg_img .');" class="mosaic-item mosaic-deployed testimonial" href="'. get_permalink($test_id) .'" title="Ver '. get_the_title($test_id) .'" rel="contents">';
        $html .= '<blockquote class="mosaic-item-excerpt">';
        $html .= apply_filters('the_content', get_field('texto_intro', $test_id));
        $html .= '</blockquote>';
        $html .= '</a>';
    }
    $html .= '</div>';

    // tercer cuadrante
    $cuadrante = array_slice($testimonios, 3, 2);
    $html .= '<div class="mosaic-section small">';
    foreach( $cuadrante as $test_id ){
        $bg_img = wp_get_attachment_image_src( get_post_thumbnail_id($test_id), 'regular-big' )[0];
        $html .= '<a style="background-image: url('. $bg_img .');" class="mosaic-item testimonial" href="'. get_permalink($test_id) .'" title="Ver '. get_the_title($test_id) .'" rel="contents">';
        $html .= '<span class="mosaic-item-desc" >'. get_the_title($test_id) .'</span>';
        $html .= '</a>';
    }
    $html .= '</div>';

    // cuarto cuadrante
    $cuadrante = array_slice($testimonios, 5, 2);
    $html .= '<div class="mosaic-section small">';
    foreach( $cuadrante as $test_id ){
        $bg_img = wp_get_attachment_image_src( get_post_thumbnail_id($test_id), 'regular-big' )[0];
        $html .= '<a style="background-image: url('. $bg_img .');" class="mosaic-item testimonial" href="'. get_permalink($test_id) .'" title="Ver '. get_the_title($test_id) .'" rel="contents">';
        $html .= '<span class="mosaic-item-desc" >'. get_the_title($test_id) .'</span>';
        $html .= '</a>';
    }
    $html .= '</div>';

    $html .= '</div>';

    return $html;
}

/**
 * General el HTML correspondiente al mosaico de contenidos mezclados en home
 * @param  [array] $mosaico  - Debe corresponder al campo ACF asociado a este mosaico (repeater)
 * @return string            - HTML del mosaico
 */
function get_mixed_mosaic( $mosaico ){
    $html = '<div class="container mosaic" data-role="mosaic3d">';

    // primer cuadrante
    $cuadrante = array_slice($mosaico, 0, 2);
    $html .= '<div class="mosaic-section small">';

    foreach( $cuadrante as $item ) {
        if( $item['acf_fc_layout'] === 'galeria' ){
            switch_to_blog(2);
        }
        
        $html .= generate_mosaic_item( $item );
    
        if( $item['acf_fc_layout'] === 'galeria' ){
            restore_current_blog();
        }
    }
    
    $html .= '</div>';

    // segundo cuadrante (grande)
    $cuadrante = array_slice($mosaico, 2, 1);
    $html .= '<div class="mosaic-section big">';

    foreach( $cuadrante as $item ) {
        if( $item['acf_fc_layout'] === 'galeria' ){
            switch_to_blog(2);
        }

        $html .= generate_mosaic_item( $item, 'big' );
    
        if( $item['acf_fc_layout'] === 'galeria' ){
            restore_current_blog();
        }
    }
    
    $html .= '</div>';

    // tercer cuadrante
    $cuadrante = array_slice($mosaico, 3, 2);
    $html .= '<div class="mosaic-section small">';

    foreach( $cuadrante as $item ) {
        if( $item['acf_fc_layout'] === 'galeria' ){
            switch_to_blog(2);
        }

        $html .= generate_mosaic_item( $item );
    
        if( $item['acf_fc_layout'] === 'galeria' ){
            restore_current_blog();
        }
    }
    
    $html .= '</div>';

    // cuarto cuadrante
    $cuadrante = array_slice($mosaico, 5, 2);
    $html .= '<div class="mosaic-section small">';

    foreach( $cuadrante as $item ) {
        if( $item['acf_fc_layout'] === 'galeria' ){
            switch_to_blog(2);
        }

        $html .= generate_mosaic_item( $item );
    
        if( $item['acf_fc_layout'] === 'galeria' ){
            restore_current_blog();
        }
    }
    
    $html .= '</div>';


    $html .= '</div>';


    return $html;
}

/**
 * Genera el listado de modulos + paginacion para el area de testimonios (historias para contar)
 * @return string - HTML del archivo
 */
function get_testimonios_archive(){
    global $paged;

    $q = new WP_Query(array(
        'posts_per_page' => 12,
        'post_type' => 'testimonio',
        'paged' => $paged
    ));

    $archive = '';
    if( $q->have_posts() ){
        while( $q->have_posts() ){
            $q->the_post();

            $thumb = get_the_post_thumbnail($q->post->ID, 'regular-small', array('class' => 'elastic-img cover'));

            $archive .= '<div class="grid-4 grid-tablet-6 grid-smalltablet-12">';
            $archive .= '<article class="news archive" >';

            $archive .= '<a href="'. get_permalink( $q->post->ID ) .'" title="'. pll__('Ver testimonio') .'" rel="contents">'. $thumb .'</a>';

            $archive .= '<h3 class="news-title" >';
            $archive .= '<a href="'. get_permalink( $q->post->ID ) .'" title="'. pll__('Ver testimonio') .'" rel="contents">'. get_the_title( $q->post->ID ) .'</a>';
            $archive .= '</h3>';
            $archive .= '<p class="news-desc">'. wp_trim_words( get_field('texto_intro', $q->post->ID), 20 ) .'</p>';
            $archive .= '</article>';
            $archive .= '</div>';
        }
    }

    $pagination = get_pagination( $q );
    wp_reset_query();

    $html = '<div class="parent" data-equalize="children" data-mq="vertical-tablet-down">';
    $html .= $archive;
    $html .= '</div>';
    $html .= $pagination;

    return $html;
}

/**
 * Genera las queries necesarias para la busqueca multisite
 * busca en los contenidos de confucio y en las noticias de enlinea
 * se hace un cache de 1hr para los resultados ya que las consultas son pesadas
 * @return string - HTML de los resultados mas la paginacion
 */
function get_complex_search(){
    $pagina = 1;
    if( isset($_GET['pagina']) && is_numeric($_GET['pagina']) ){
        $pagina = intval($_GET['pagina']);
    }
    if( $pagina < 1 ){ $pagina = 1; }

    $search_term = sanitize_text_field( get_query_var('s') );

    // buscamos en el object_cache por los resultados de este termino
    // si no existen entonces se hace la query
    $cache_key = 'busqueda_por_'. sanitize_title($search_term);
    $resultados = wp_cache_get( $cache_key, 'busquedas-confucio' );

    if( ! $resultados ){
        $general_query = new WP_Query(array(
            's' => $search_term,
            'post_type' => array('page', 'festividad', 'testimonio'),
            'nopaging' => true, // igual a "posts_per_page = -1" pero funciona bien con elasticsearch
            'cache_results' => true
        ));

        switch_to_blog(2);
        $news_query = new WP_Query(array(
            // 'sites' => 2,
            's' => $search_term,
            'post_type' => 'post',
            'nopaging' => true, // igual a "posts_per_page = -1" pero funciona bien con elasticsearch
            'cache_results' => true,
            'category_name' => 'instituto-confucio'
        ));
        restore_current_blog();

        $resultados = interpolar_array($news_query->posts, $general_query->posts);
        wp_cache_set($cache_key, $resultados, 'busquedas-confucio', (60 * 60 * 1) );
    }

    $total_resultados = sizeof( $resultados );

    if( !$total_resultados ){
        return alerta(array('mensaje' => 'No se encontraron resultados para el término de búsuqeda <strong>"'. $search_term .'"</strong>'));
    }

    $per_page = 10;
    $offset = $per_page * ($pagina - 1);
    $page_results = array_slice($resultados, $offset, $per_page );

    $html = '';
    foreach( $page_results as $item ){
        $html .= generate_generic_module( $item, array('search' => true) );
    }

    $html .= get_complex_search_pagination( $total_resultados, $per_page, $pagina );
    return $html;
}

/**
 * Genera la paginacion personalizada para la busqueda multisitio
 * @param  int $total    Total de resultados
 * @param  int $per_page numero de resultados por pagina
 * @param  int $page     numero de pagina actua
 * @return string - HTML de la paginacion
 */
function get_complex_search_pagination( $total, $per_page, $page ){
    $total_pages = ceil( $total / $per_page );
    if( $total_pages <= 1 ){ return false; }

    $pages = '';
    for( $num = 1; $num <= $total_pages; $num++ ){
        $active = '';
        if( $num === $page ){ $active = 'active'; }

        $target_uri = esc_url( add_query_arg(array('pagina' => $num)) );
        $pages .= '<a href="'. $target_uri .'" class="pagination-link page-num '. $active .'" title="Ver página '. $num .'">'. $num .'</a>';
    }

    $pagination = '<section class="pagination">';

    $prev_page = $page - 1;
    if( $prev_page >= 1 ){
        $target_uri = esc_url( add_query_arg(array('pagina' => $prev_page)) );
        $pagination .= '<a class="pagination-link direction" href="'. $target_uri .'" title="Página anterior" rel="prev" >&lsaquo;</a>';
    }

    $pagination .= $pages;

    $next_page = $page + 1;
    if( $next_page <= $total_pages ){
        $target_uri = esc_url( add_query_arg(array('pagina' => $next_page)) );
        $pagination .= '<a class="pagination-link direction" href="'. $target_uri .'" title="Página siguiente" rel="next" >&rsaquo;</a>';
    }

    $pagination .= '</section>';

    return $pagination;
}

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////// Generadores
////////////////////////////////////////////////////////////////////////////////

/**
 * Genera el HTML de los breadcrumbs
 * @return string - HTML de los breadcrumbs
 */
function generate_breadcrumbs(){
    global $post, $wp_query;

    $items = '';
    $out = '';

    // link al inicio siempre presente
    $items .= '<a href="'. home_url() .'" title="'. pll__('Ir a la página de inicio') .'" rel="index">'. pll__('Inicio') .'</a>';

    // archivos y post_types
    if( is_post_type_archive('agenda') ){
        $items .= '<span>'. pll__('Agenda') .'</span>';
    }

    elseif( is_post_type_archive('galeria') ){
        $items .= '<span">Galerías</span>';
    }

    // archivos y post_types
    elseif( is_post_type_archive('publicacion') ){
        $items .= '<span>'. pll__('Publicaciones') .'</span>';
    }

    // taxonomias
    elseif( is_tax('tipo_agenda') ){
        $items .= '<a href="'. get_post_type_archive_link('agenda') .'" title="Ir a '. pll__('Agenda') .'" rel="section">'. pll__('Agenda') .'</a>';

        $current_term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
        $items .= '<span>'. $current_term->name .'</span>';
    }

    // en lso singles y singulars siempre va el titulo al final
    elseif( is_singular() ) {
        if( is_page() ){
            $ancestors = get_post_ancestors( $post );
            $ancestors = array_reverse($ancestors);

            if( !empty($ancestors) ){
                foreach( $ancestors as $parent_id ){
                    $items .= '<a href="'. get_permalink( $parent_id ) .'" title="Ir a '. get_the_title( $parent_id ) .'" rel="section">'. get_the_title( $parent_id ) .'</a>';
                }
            }
        }

        // para los testimonios
        elseif( is_singular('testimonio') ){
            $historias = get_post_by_slug('historias-para-contar');
            $ancestors = get_post_ancestors( $historias );
            $ancestors = array_reverse($ancestors);

            if( !empty($ancestors) ){
                foreach( $ancestors as $parent_id ){
                    $items .= '<a href="'. get_permalink( $parent_id ) .'" title="Ir a '. get_the_title( $parent_id ) .'" rel="section">'. get_the_title( $parent_id ) .'</a>';
                }
            }

            $items .= '<a href="'. get_permalink($historias->ID) .'" title="Ir a '. get_the_title($historias->ID) .'" rel="section">'. get_the_title($historias->ID) .'</a>';
        }

        // para las festividades
        elseif( is_singular('festividad') ){
            $milenaria = get_post_by_slug('china-milenaria');
            $ancestors = get_post_ancestors( $milenaria );
            $ancestors = array_reverse($ancestors);

            if( !empty($ancestors) ){
                foreach( $ancestors as $parent_id ){
                    $items .= '<a href="'. get_permalink( $parent_id ) .'" title="Ir a '. get_the_title( $parent_id ) .'" rel="section">'. get_the_title( $parent_id ) .'</a>';
                }
            }

            $items .= '<a href="'. get_permalink($milenaria->ID) .'" title="Ir a '. get_the_title($milenaria->ID) .'" rel="section">'. get_the_title($milenaria->ID) .'</a>';
        }

        elseif( is_singular('galeria') ){
            $items .= '<a class="breadcrumb-item" href="'. get_post_type_archive_link('galeria') .'" title="Ir a Galerías" rel="section">Galerías</a>';
        }

        $items .= '<span>'. get_the_title() .'</span>';
    }




    $out .= '<section class="breadcrumbs hide-on-vertical-tablet-down" >';
    $out .= $items;
    $out .= '</section>';

    return $out;
}

/**
 * Genera el modulo mas generico del sitio, sirve para noticias, festividades y otros. Solo muestra informacion basica del post basado en lso argumentos
 * @param  mixed $post_or_id - Post_object o post_id del cual hacer el modulo
 * @param  array  $options - Array de posibles opciones para el modulo
 * @return string - HTML del modulo
 */
function generate_generic_module( $post_or_id, $options = array() ){
    $settings = shortcode_atts(array(
        'classes' => '',
        'atts' => '',
        'thumbnail' => false,
        'columns' => false,
        'search' => false
    ), $options);

    if( is_numeric( $post_or_id ) ){ $p = get_post( $post_or_id ); }
    else { $p = $post_or_id; }

    if( $p->post_type === 'post' ){
        switch_to_blog(2);
    }

    $enLinea = false;
    if( get_current_blog_id() === 2 ){
        $enLinea = true;
    }

    $permalink = get_permalink( $p->ID );

    $body = '<h3 class="news-title" >';
    $body .= '<a href="'. $permalink .'" title="'. pll__('Ver artículo') .'" rel="contents">'. get_the_title( $p->ID ) .'</a>';
    $body .= '</h3>';
    $body .= '<p class="news-desc">'. wp_trim_words( strip_shortcodes($p->post_content), 20 ) .'</p>';

    //esto solo se activa cuando son noticias de st enlinea
    if( $enLinea ){
        $sede = wp_get_post_terms($p->ID, 'sede');
        $autoria = 'DEC Santo Tomás';

        if( !empty($sede) ){
            $sede = $sede[0];
            if( $sede->slug !== 'todas-las-sedes' ){
                $autoria = 'DEC '. $sede->name;
            }
        }
        $body .= '<p class="news-meta">';
        $body .= 'Por <strong>'. $autoria .'</strong> el '. date_i18n('d/m/Y', strtotime($p->post_date));
        $body .= '</p>';
    }

    if( $settings['search'] ){
        $body .= '<p class="news-meta">';
        $body .= '<a href="'. $permalink .'" title="Ir al resultado" rel="contents" >'. $permalink .'</a>';
        $body .= '</p>';
    }

    if( $settings['thumbnail'] || $settings['columns'] ){
        // si estamos sacando noticias de st en linea
        // el tamano del thumbnail cambia a uno registrado en ese sitio
        // de otra forma saca el tamano completo (full)
        $thumb_size = 'regular-small';
        if( $enLinea ){
            $thumb_size = 'sidebar-banner';
        }


        $thumb = get_the_post_thumbnail($p->ID, $thumb_size, array('class' => 'elastic-img cover'));
    }

    if( $settings['columns'] ){
        $html = '<div class="grid-4 grid-smalltablet-12 no-gutter-left no-gutter-smalltablet">';
        $html .= $thumb;
        $html .= '</div>';
        $html .= '<div class="grid-8 grid-smalltablet-12 no-gutter-right no-gutter-smalltablet">';
        $html .= $body;
        $html .= '</div>';
    }
    elseif( $settings['thumbnail'] && !$settings['columns'] ){
        $html = $thumb;
        $html .= $body;
    }
    else {
        $html = $body;
    }

    $module = '<article class="news '. $settings['classes'] .'"  '. $settings['atts'] .'>';
    $module .= $html;
    $module .= '</article>';

    if( $enLinea ){
        restore_current_blog();
    }

    return $module;
}

/**
 * Genera el modulo generico de los eventos
 * @param  mixed $post_or_id - ID o post_object del que se desea formular el modulo
 * @param  array  $options - Array de opciones para el modulo
 * @return string - HTML del modulo
 */
function generate_event_module( $post_or_id, $options = array() ){
    $settings = shortcode_atts(array(
        'classes' => '',
        'atts' => ''
    ), $options);

    if( is_numeric( $post_or_id ) ){ $p = get_post( $post_or_id ); }
    else { $p = $post_or_id; }

    $fecha_stamp = strtotime( get_field('fecha', $p->ID) );

    $html = '<article class="event-content '. $settings['classes'] .'" '. $settings['atts'] .'>';
    $html .= '<div class="event-date-box">';
    $html .= '<div class="event-date-tag">';
    $html .= '<span>'. date('d', $fecha_stamp) .'</span><span>'. date_i18n('M', $fecha_stamp) .'</span>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '<div class="event-info">';
    $html .= '<h3 class="event-title">'. get_the_title( $p->ID ) .'</h3>';
    $html .= '<p class="event-date">'. date_i18n('d/m/Y', $fecha_stamp) .'</p>';
    $html .= '<p class="event-place">Lugar: '. get_field('lugar', $p->ID) .'</p>';
    $html .= '<p class="event-place">Horario: '. get_field('hora', $p->ID) .'</p>';

    // sede si es que tiene
    $sedes = wp_get_post_terms($p->ID, 'sede', array('fields' => 'names'));
    if( !empty($sedes) ){
        $html .= '<p class="event-place">Sede: '. $sedes[0] .'</p>';
    }

    if( $link = get_field('mas_informacion', $p->ID) ){
        $html .= '<p class="event-place"><a href="'. ensure_url($link) .'" title="Ver enlace" rel="external nofollow" target="_blank" >Más información</a></p>';
    }
    
    $html .= '</div>';
    $html .= '</article>';

    return $html;
}

/**
 * Genera el modulo correspondiente a las personas o accesos directos de seccciones
 * @param  array $person_data - Informacion a poenr en el modulo
 * @return string - HTML del modulo
 */
function generate_figure_module( $person_data ) {
    // $person_data = array(
    //     'foto_url' => '',
    //     'nombre' => '',
    //     'meta_1' => '',
    //     'meta_2' => '',
    //     'meta_3' => '',
    //     'adicional' => ''
    // );

    $html = '<figure class="figure">';
    $html .= '<img src="'. $person_data['foto_url'] .'" class="elastic-img cover">';
    $html .= '<figcaption class="figure-data">';
    $html .= '<p class="figure-name" data-func="deployParent" data-parent=".figure" >'. $person_data['nombre'] .'</p>';
    $html .= '<div class="figure-meta">';

    if( isset($person_data['meta_1']) ) {
        $html .= '<p>'. $person_data['meta_1'] .'</p>';
    }
    if( isset($person_data['meta_2']) ) {
        $html .= '<p>'. $person_data['meta_2'] .'</p>';
    }
    if( isset($person_data['meta_3']) ) {
        $html .= '<p>'. $person_data['meta_3'] .'</p>';
    }
    if( isset($person_data['adicional']) ) {
        $html .= '<p>'. $person_data['adicional'] .'</p>';
    }

    $html .= '</div>';
    $html .= '</figcaption>';
    $html .= '</figure>';

    return $html;
}

/**
 * Genera el modulo generico de las publicaciones
 * @param  mixed $post_or_id - ID o post_object del que se desea formular el modulo
 * @return string - HTML del modulo
 */
function generate_pub_module( $post_or_id ){
    if( is_numeric( $post_or_id ) ){ $p = get_post( $post_or_id ); }
    else { $p = $post_or_id; }

    $html = '<article class="publication-box">';
    $html .= '<div class="publication-embed">';
    $html .= get_field('issuu_code', $p->ID);
    $html .= '</div>';
    $html .= '<div class="publication-meta">';
    $html .= '<p class="publication-title">'. get_the_title($p->ID) .'</p>';

    $pub_date = date_i18n('F Y', strtotime(get_field('pub_date', $p->ID)));
    $html .= '<p class="publication-date">'. ucfirst($pub_date) .' /No '. get_field('numero', $p->ID) .'</p>';

    $html .= '<p class="publication-link">';

    $file_info = get_file_info( get_field('archivo_pdf', $p->ID) );
    $html .= '<a href="'. $file_info['file_url'] .'" title="Descargar '. strtoupper($file_info['file_mimetype']) .'" rel="appendix">Descargar</a> '. strtoupper($file_info['file_mimetype']) .' '. $file_info['file_size'];

    $html .= '</p>';
    $html .= '</div>';
    $html .= '</article>';

    return $html;
}

/**
 * Genera el HTML del modulo de mapa, ademas llama al script que lo hace posible y manejaa los markers asociados
 * @param  array $acf_info - Informacion del campo ACF a convertir en mapa
 * @return string - HTML del modulo
 */
function generate_map_box( $acf_info ){
    // si falta el campo lo indicamos con un error bonito para que
    // no reclamen. Prevencion de capa 8
    if( empty($acf_info) ){
        return alerta(array('mensaje' => 'Aún no se ha indicado ninguna dirección en el mapa'));
    }

    needs_script('mapsHandler');
    $markers = array(
        array( 'lat' => $acf_info['lat'], 'lng' => $acf_info['lng'] )
    );

    return '<div class="map-box" data-googlemap data-map-markers=\''. json_encode($markers) .'\'></div>';
}

/**
 * Genera el modulo de la galeria de imagenes
 * @param  array $imagenes - informacion directa del campo ACF, DEBE tener este formato basico:
 *                         array(
 *                             array(
 *                                 'imagen' => (int)$attachment_id,
 *                                 'pie_imagen' => (string/html)$pie_foto
 *                             )
 *                         )
 * @return string - HTML de la galeria
 */
function generate_regular_gallery_slider( $gallery_id ){
    global $gallery_shown;
    // imagenes de la galeria
    $imagenes = get_field('fotos', $gallery_id);
    if( empty($imagenes) ){ return false; }

    needs_script('owlCarousel');
    needs_script('ninjaSlider');


    $items = '';
    $thumbnails = '';

    $count = 0;

    foreach( $imagenes as $img ){
        if( !$img['imagen'] ){ continue; }
        $active = $count === 0 ? 'active' : '';

        $items .= '<figure class="single-slider-item '. $active .'" data-slide="'. $count .'" data-role="single-slider-item" data-attid="'. $img['imagen'] .'">';
        $items .= wp_get_attachment_image( $img['imagen'], 'regular-bigger', false, array( 'class' => 'single-slider-image' ));

        if( $img['pie_imagen'] ){
            $items .= '<figcaption class="single-slider-footnote">';
            $items .= apply_filters('the_content', $img['pie_imagen']);
            $items .= '</figcaption>';
        }

        $items .= '</figure>';

        $thumbnails .= '<button class="single-slider-thumbnail '. $active .'" title="Ver imagen" data-target="'. $count .'" data-role="single-slider-thumbnail">';
        $thumbnails .= wp_get_attachment_image( $img['imagen'], 'regular-tiny');
        $thumbnails .= '</button>';

        $count++;
    }


    $out = '<div class="single-slider-module" data-role="single-slider-module">';
    $out .= '<div class="single-slider-body">';
    $out .= '<div class="single-slider-main" data-role="slider">';
    $out .= '<div class="single-slider-holder">';
    $out .= $items;
    $out .= '</div>';
    $out .= '</div>';
    $out .= '<div class="single-slider-arrows-box">';
    $out .= '<button class="single-slider-arrow prev" title="Ver imagen anterior" data-role="single-slider-arrow" data-direction="prev"></button>';
    $out .= '<button class="single-slider-arrow next" title="Ver imagen siguiente" data-role="single-slider-arrow" data-direction="next"></button>';
    $out .= '</div>';
    $out .= '</div>';
    $out .= '<div class="single-slider-thumbnails-holder">';
    $out .= '<button class="single-slider-thumbnail-arrow prev" title="Anterior" data-role="single-slider-thumbnail-arrow" data-direction="prev"></button>';
    $out .= '<div class="single-slider-thumbnails">';
    $out .= '<div class="single-slider-thumbnails-list" data-role="thumbnails-holder">';
    $out .= $thumbnails;
    $out .= '</div>';
    $out .= '</div>';
    $out .= '<button class="single-slider-thumbnail-arrow next" title="Siguiente" data-role="single-slider-thumbnail-arrow" data-direction="next"></button>';
    $out .= '</div>';
    $out .= '</div>';

    // se indica que ya se mostro una galeria
    $gallery_shown = true;

    return $out;
}

/**
 * Genera el modulo correspondiente a las galerias de fotos (version listado)
 * @param  mixed $gallery_or_id - ID o $post_object de la galeria
 * @param  array  $options - Array de opciones
 * @return string - HTML del modulo
 */
function generate_gallery_module( $gallery_or_id, $options = array() ){
    $settings = shortcode_atts(array(
        'classes' => ''
    ), $options);

    $gallery = null;
    if( is_numeric( $gallery_or_id ) ){ $gallery = get_post( $gallery_or_id ); }
    elseif( is_object( $gallery_or_id ) ){ $gallery = $gallery_or_id; }
    else { return false; }

    $out = '<article class="regular-gallery '. $settings['classes'] .'">';

    // de preferencia se va a mostrar la imagen destacada,
    // si esta no existe entonces se muestra la primera imagen de la galeria
    if( has_post_thumbnail( $gallery->ID ) ){
        $out .= get_the_post_thumbnail( $gallery->ID, 'gallery-module', array( 'class' => 'elastic-img cover' ));
    }
    else {
        $imagen = get_field('fotos')[0];
        $out .= wp_get_attachment_image($imagen['imagen'], 'gallery-module', false, array( 'class' => 'elastic-img cover' ));
    }

    $out .= '<div class="regular-gallery-info">';

    $out .= '<h3 class="regular-gallery-title">';

    $title = get_the_title( $gallery->ID );
    $out .= '<a href="'. get_permalink( $gallery->ID ) .'" title="'. $title .'" rel="contents">'. $title .'</a>';

    $out .= '</h3>';
    $out .= '</div>';
    $out .= '</article>';

    return $out;
}

/**
 * Genera el formulario de suscripcion a newsletter general que se usa en todas partes excepto en la pagina del newsletter que es levemente distinto.
 * @return string - html del formulario
 */
function generate_suscribe_form(){
    $out = '<form class="suscribe-form" method="post" action="'. get_permalink( get_post_by_slug('newsletter', 'ID') ) .'exito/#feedback" data-validation="generic">';
    $out .= '<input class="email-input" type="email" name="suscriber-email" placeholder="Ingrese su email" required>';
    $out .= '<input type="submit" value="Suscribirme">';
    $out .= wp_nonce_field('enviar_suscripcion', 'st_nonce', true, false);
    $out .= '</form>';

    return $out;
}

/**
 * Busca y devuelve el post al cual esta asociada una galeria
 * @param  int $pid - $post_id de la galeria
 * @return object - $post_object del post relacionado
 */
function get_gallery_related_post( $pid ){
    // metodo de relacionar (inversamente) por relationship ACF
    // sacado de http://www.advancedcustomfields.com/resources/querying-relationship-fields/
    $related = get_posts(array(
        'post_type' => 'post',
        'meta_query' => array(
            array(
                'key' => 'galeria',
                'value' => '"'. $pid .'"',
                'compare' => 'LIKE'
            )
        )
    ));

    if( empty($related) ){ return false; }
    return $related[0];
}

/**
 * Genera la caja de acciones dentro de un articulo
 * esta caja contiene las acciones de
 * compartir, shortlink, enviar por email e imprimir
 * Todas las accioens se hacen a traves del $post
 * @param  object $articulo - $post_object del articulo
 * @param  string $custom_message - Mensaje personalizado para forzar al compartir
 * @return string - HTML de la caja
 */
function generate_article_actions_box( $articulo, $custom_message = false, $target = false ){
    $share_links = generate_share_urls( $articulo, $custom_message, $target );

    $out = '<div class="regular-content-actions-holder parent">';

    $out .= '<div class="regular-content-shares grid-6 grid-smalltablet-12 grid-mobile-4 no-gutter">';
    $out .= '<a class="content-share-link twitter" href="'. $share_links['twitter'] .'" title="Compartir en twitter" rel="external nofollow" data-role="share-counter" data-type="twitter" data-url="'. $share_links['permalink'] .'" target="_blank"></a>';
    $out .= '<a class="content-share-link facebook" href="'. $share_links['facebook'] .'" title="Compartir en facebook" rel="external nofollow" data-role="share-counter" data-type="facebook" data-url="'. $share_links['permalink'] .'" target="_blank">-</a>';

    // los shares de google plus se tienen que sacar con curl :(
    // se guarda en un transienta para no reventar el server
    $gPlus_shares = get_transient('google_shares_num_'. $articulo->ID);
    if( !$gPlus_shares ){
        $gPlus_shares = getPlusOnesByURL( $share_links['permalink'] );
        set_transient( 'google_shares_num_'. $articulo->ID, $gPlus_shares, 60 * 60 * 1 );
    }

    $out .= '<a class="content-share-link google" href="'. $share_links['google'] .'" title="Compartir en google" rel="external nofollow" data-role="share-counter" data-type="google" data-url="'. $share_links['permalink'] .'" target="_blank">'. $gPlus_shares .'</a>';

    $out .= '<a class="content-share-link linkedin" href="'. $share_links['linkedin'] .'" title="Compartir en linkedin" rel="external nofollow" data-role="share-counter" data-type="linkedin" data-url="'. $share_links['permalink'] .'" target="_blank">-</a>';
    $out .= '</div>';

    $out .= '<div class="regular-content-other-actions grid-6 grid-smalltablet-12 grid-mobile-4 no-gutter ">';
    $out .= '<button class="action-square-link shortlink" data-link="'. $share_links['shortlink'] .'" data-func="showShortUrl" title="Shortlink" ></button>';
    // $out .= '<button class="action-square-link email" data-func="sendPostByEmail" data-pid="'. $articulo->ID .'" title="Enviar por correo" ></button>';
    $out .= '<button class="action-square-link print hide-smalltablet-down" data-func="printPage" title="Imprimir" ></button>';

    /// en el caso de las galerias de imagenes existe el boton de "ver noticia relacionada"
    if( $articulo->post_type === 'galeria' ){
        $related_post = get_gallery_related_post( $articulo->ID );
        if( !!$related_post ){
            $out .= '<a class="primary-btn small-btn" href="'. get_permalink($related_post->ID) .'" title="Ver Noticia relacionada" rel="contents">Ver noticia relacionada</a>';
        }
    }


    $out .= '</div>';

    $out .= '</div>';

    return $out;
}


/**
 * Genera el modulo correspondiente a un item del mosaico de la pagina de inicio
 * @param  [array] $item  - Información del item
 * @return string         - HTML del modulo
 */
function generate_mosaic_item( $item, $type = 'small' ){
    $object_id = $item[ $item['acf_fc_layout'] ][0];

    $object_type = '';
    switch ($item['acf_fc_layout']) {
        case 'galeria':
            $object_type = 'gallery';
            break;
        case 'china_milenaria':
            $object_type = 'video';
            break;
        default:
            $object_type = 'testimonial';
            break;
    }

    if( $type === 'small' ){
        $bg_img = wp_get_attachment_image_src( get_post_thumbnail_id($object_id), 'regular-big' )[0];
        $html = '<a style="background-image: url('. $bg_img .');" class="mosaic-item '. $object_type .'" href="'. get_permalink($object_id) .'" title="Ver '. get_the_title($object_id) .'" rel="contents">';
        $html .= '<span class="mosaic-item-desc" >'. get_the_title($object_id) .'</span>';
        $html .= '</a>';
    }
    else {
        $bg_img = wp_get_attachment_image_src( get_post_thumbnail_id($object_id), 'regular-big' )[0];
        $html = '<a style="background-image: url('. $bg_img .');" class="mosaic-item mosaic-deployed '. $object_type .'" href="'. get_permalink($object_id) .'" title="Ver '. get_the_title($object_id) .'" rel="contents">';
        $html .= '<blockquote class="mosaic-item-excerpt">';
        $html .= apply_filters('the_content', get_field('texto_intro', $object_id));
        $html .= '</blockquote>';
        $html .= '</a>';
    }

    return $html;
}

/**
 * Genera una imagen al azar basada en el ACF "imagenes_genericas"
 * toma los mismos argumentos que wp_get_attachment_image con excepcion del $attachment_id
 * ya que se saca al azar desde el campo
 * @param  [string] $size           Tamano de imagen
 * @param  [bool] $icon             media-icon
 * @param  [string/array] $attr     array o string de atributos
 * @return [string]                 html de la imagen o nada
 */
function get_random_thumbnail( $size = 'thumbnail', $icon = false, $attr = null ){
    $imagenes = get_field('imagenes_genericas', 'option');
    if( empty($imagenes) ){ return false; }

    $rand_key = array_rand( $imagenes, 1 );
    return wp_get_attachment_image( $imagenes[$rand_key]['imagen'], $size, $icon, $attr );
}

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////// Shortcodes
////////////////////////////////////////////////////////////////////////////////
add_shortcode( 'mapadelsitio', 'generate_sitemap' );
function generate_sitemap( $atts ){
    return wp_nav_menu(array(
        'theme_location' => 'mapasitio',
        'echo' => false
    ));
}

add_shortcode( 'boton_link', 'boton_link' );
function boton_link( $atts, $content ){
    $settings = shortcode_atts( array(
        'url' => '#',
        'title' => 'Ver enlace'
    ), $atts );


    return '<a class="pretty-link arrow" href="'. $settings['url'] .'" title="'. $settings['title'] .'" >'. $content .'</a>';
}

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////// Envios de Formularios
////////////////////////////////////////////////////////////////////////////////

/**
 * Envia el formualrio de bibliotecas
 * @param  [array] $data - Datos del post
 * @return bool/string
 */
function send_biblioteca_form( $data ){
    // si no respeta el nonce entonces muere
    if( !wp_verify_nonce( $data['st_nonce'], 'enviar_biblioteca' ) ){
        return 'invalid';
    }

    // validacion de email por php
    if( !filter_var($data['biblioteca-email'], FILTER_VALIDATE_EMAIL)) {
        return 'invalid';
    }

    // Primero se guarga el respaldo en un post tipo contacto.
    $new_id = wp_insert_post(array(
        'post_title' => 'Solicitud de de '. $data['biblioteca-nombre'],
        'post_content' => $data['biblioteca-mensaje'],
        'post_type' => 'solicitud_biblioteca',
        'post_status' => 'publish'
    ));

    if( !$new_id || is_wp_error($new_id) ){
        wp_die('Error al crear solicitud');
    }

    // se llenan los ACF correspondientes
    // campo: "nombre"
    update_field( "field_55bf5d34e2634", $data['biblioteca-nombre'], $new_id );

    // se llenan los ACF correspondientes
    // campo: "email"
    update_field( "field_55bf5d4ae2635", $data['biblioteca-email'], $new_id );

    // se llenan los ACF correspondientes
    // campo: "ciudad"
    update_field( "field_55bf5d57e2636", $data['biblioteca-ciudad'], $new_id );

    // si viene el cambo de suscribir checkeado entonces se inserta como suscriptor
    if( isset($data['suscribe-newsletter']) && !!$data['suscribe-newsletter'] ){
        insert_suscriber( $data['biblioteca-email'] );
    }


    ////////////
    //////////// ENVIAR NOTIFICIACION
    ////////////
    $emails = get_emails();

    // email al solicitante
    $mensaje = '<p>Hemos recibido su consulta para la biblioteca del Instituco Confucio.</p>';
    $mensaje .= '<p>Prontamente le enviaremos una respuesta a su cuenta de correo.</p>';

    send_custom_email(array(
        'type' => 'notificacion',
        'to' => $data['biblioteca-nombre'] .' <'. $data['biblioteca-email'] .'>',
        'subject' => 'Con sulta a Biblioteca Instituto Confucio',
        'headers' => array(
            'From: Instituto Confucio <'. $emails['permanente'] .'>',
            'Reply-To: Instituto Confucio <'. $emails['permanente'] .'>'
        ),
        'email_contents' => array(
            'title' => 'Hemos recibido su solicitud de libros',
            'intro' => 'Estimado '. $data['biblioteca-nombre'] . ':',
            'mensaje' => $mensaje
        )
    ));


    // email al admin
    $mensaje = '<p>Hemos recibido una nueva consulta a la biblioteca del Instituto Confucio</p>';
    $mensaje .= '<p>Sus datos son:</p>';
    $mensaje .= '<p>';
    $mensaje .= '<strong>Nombre:</strong> '. $data['biblioteca-nombre'] .'<br>';
    $mensaje .= '<strong>Email:</strong> '. $data['biblioteca-email'] .'<br>';
    $mensaje .= '<strong>Ciudad de residencia:</strong> '. $data['biblioteca-ciudad'] .'<br>';
    $mensaje .= '<strong>Consulta:</strong>';
    $mensaje .= '</p>';

    $mensaje .= apply_filters('the_content', $data['biblioteca-mensaje']);

    send_custom_email(array(
        'type' => 'notificacion',
        'to' => $emails['biblioteca'],
        'subject' => 'Consulta a Biblioteca Instituto Confucio',
        'headers' => array(
            'From: Instituto Confucio <'. $emails['permanente'] .'>',
            'Reply-To: Instituto Confucio <'. $emails['permanente'] .'>',
            'Cc: '. $emails['permanente'],
        ),
        'email_contents' => array(
            'title' => 'Consulta a Biblioteca Instituto Confucio',
            'intro' => 'Estimado/da: ',
            'mensaje' => $mensaje
        )
    ));

    return true;
}

/**
 * Anade al suscriptor a la lista de wordpress, deberia anadirlo tambien a la lista de mailchimp
 * En adicion a esto tambien envia una notificacion al suscriptor acerca del exito de sus suscripcion
 * @param  array $data - $_POST del formulario
 * @return mixed - true cuando se envia correctamente y "email_exists" cuando el correo ingresado ya se encuentra registrado
 */
function send_newsletter_form( $data ){
    // si no respeta el nonce entonces muere
    // if( !wp_verify_nonce( $data['st_nonce'], 'enviar_suscripcion' ) ){
    //     wp_die('Formulario inválido');
    // }

    $email = $data['suscriber-email'];

    // validacion de email por php
    if( !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return 'invalid_email';
    }

    return insert_suscriber( $email );
}

/**
 * Inserta un suscriptor en la bbdd
 * @param  [string] $email - Debe ser un email valido
 * @return mixed - true en caso de  exito, "email_exists" en caso de que el email ya este ocupado
 */
function insert_suscriber( $email ){
    if( suscriber_unavailable( $email ) ){
        return 'email_exists';
    }

    $title = $email;

    /// primero creamos el post suscriptor para que quede en el administrador
    $subscriber_id = wp_insert_post(array(
        'post_title' => $title,
        'post_status' => 'publish',
        'post_type' => 'suscriptor'
    ));

    // si el suscriptor no se creo no vale lapensa seguir
    if( !$subscriber_id || is_wp_error($subscriber_id) ){
        wp_die('Error creando suscripción');
    }

    $emails = get_emails();

    // /// Enviamos mail de notificacion al usuario que lleno el formulario
    $mensaje = '<p>¡Le damos la bienvenida!</p>';
    $mensaje .= '<p>Gracias por suscribirse al <strong>Newsletter</strong> de <strong>Instituto Confucio UST</strong>. Periódicamente, le compartiremos noticias y eventos de nuestra institución para que se mantenga informado de las actividades que realizamos.</p>';

    // desactivado hasta poder tener conexion con mailchimp
    // $mensaje .= '<p>Si no ha registrado sus datos con nosotros, probablemente alguien escribió su correo por accidente al momento de registrarse. Si lo desea, puede <enlace>darse de baja</enlace> de la lista. </p>';

    send_custom_email(array(
        'type' => 'notificacion',
        'to' => $email,
        'subject' => '¡Le damos la bienvenida al newsletter de Instituto Confucio UST!',
        'headers' => array(
            'From: Instituto Confucio <'. $emails['permanente'] .'>',
            'Reply-To: Instituto Confucio <'. $emails['permanente'] .'>'
        ),
        'email_contents' => array(
            'title' => '¡Le damos la bienvenida al newsletter de Instituto Confucio UST!',
            'intro' => 'Estimado/a:',
            'mensaje' => $mensaje
        )
    ));


    // /// Enviamos mail de notificacion al administrador del sitio
    send_custom_email(array(
        'type' => 'notificacion',
        'to' => $emails['newsletter'],
        'subject' => 'Nuevo suscriptor en Newsletter Instituto Confucio UST',
        'headers' => array(
            'From: Instituto Cnfucio <'. $emails['permanente'] .'>',
            'Cc: '. $emails['permanente'],
            'Reply-To: Instituto Cnfucio <'. $emails['permanente'] .'>'
        ),
        'email_contents' => array(
            'title' => 'Nuevo suscriptor en Newsletter Instituto Confucio UST',
            'intro' => 'Se ha agregado un nuevo suscriptor a la lista Newsletter.',
            'mensaje' => '<p>Sus datos son:</p><p>Correo: '. $email .'</p>'
        )
    ));


    return true;
}

/**
 * Envia el formulario de contacto
 * Envia una notificacion al administrador y otra al usuario que envio el formulario
 * @param  array - $_POST del formulario
 * @return bool
 */
function send_contact_form( $data ){
    // si no pasa el nonce muere
    // if( ! wp_verify_nonce( $data['st_nonce'], 'enviar_contacto' ) ){
    //     return 'invalid';
    // }

    // validacion de email por php
    if( !filter_var($data['contacto-email'], FILTER_VALIDATE_EMAIL)) {
        return 'invalid';
    }

    // Primero se guarga el respaldo en un post tipo contacto.
    $new_contact_id = wp_insert_post(array(
        'post_title' => 'Mensaje de '. $data['contacto-nombre'],
        'post_content' => $data['contacto-mensaje'],
        'post_type' => 'contacto',
        'post_status' => 'publish'
    ));

    if( !$new_contact_id || is_wp_error($new_contact_id) ){
        wp_die('Error al crear contacto');
    }

    // se llenan los ACF correspondientes
    // campo: "nombre"
    update_field( "field_55bf5cd76c3f4", $data['contacto-nombre'], $new_contact_id );

    // campo: "email"
    update_field( "field_55bf5cf66c3f5", $data['contacto-email'], $new_contact_id );


    // notificaciones

    $emails = get_emails();

    $mensaje = '<p>Recibimos correctamente el mensaje que ingresó a través de nuestro formulario de contacto en el sitio web del <strong>Instituto Confucio</strong></p>';
    $mensaje .= '<p>Revisaremos su requerimiento para poder responderle lo antes posible, a la dirección de correo electrónico que ingresó al momento de contactarnos</p>';

    // email para el usuario
    send_custom_email(array(
        'type' => 'notificacion',
        'to' => $data['contacto-nombre'] .' <'. $data['contacto-email'] .'>',
        'subject' => 'Instituto Confucio recibió su mensaje',
        'headers' => array(
            'From: Instituto Confucio <'. $emails['permanente'] .'>',
            'Reply-To: Instituto Confucio <'. $emails['permanente'] .'>'
        ),
        'email_contents' => array(
            'title' => 'Instituto Confucio recibió su mensaje',
            'intro' => 'Estimado '. $data['contacto-nombre'] . ':',
            'mensaje' => $mensaje
        )
    ));


    $mensaje = '<p>Hola, se recibió un nuevo mensaje en el formulario de <strong>Contacto</strong></p>';
    $mensaje .= '<p>';
    $mensaje .= '<strong>Nombre:</strong> '. $data['contacto-nombre'] .'<br>';
    $mensaje .= '<strong>Email:</strong> '. $data['contacto-email'] .'<br>';
    $mensaje .= '<strong>Consulta:</strong>';
    $mensaje .= '</p>';
    $mensaje .= apply_filters('the_content', $data['contacto-mensaje']);
    $mensaje .= '<p style="margin-top:40px; font-size:11px;" >Enviamos una confirmación automática al remitente del mensaje, notificándole que este había sido recibido.</p>';


    /// email para el administrador
    send_custom_email(array(
        'type' => 'notificacion',
        'to' => $emails['contacto'],
        'subject' => 'Nuevo mensaje en formulario de Contacto',
        'headers' => array(
            'From: Instituto Confucio <'. $emails['permanente'] .'>',
            'Cc: '. $emails['permanente'],
            'Reply-To: '. $data['contacto-nombre'] .' <'. $data['contacto-email'] .'>'
        ),
        'email_contents' => array(
            'title' => 'Nuevo mensaje en formulario de Contacto',
            'intro' => 'Estimado/da: ',
            'mensaje' => $mensaje
        )
    ));

    return true;
}

/**
 * Se encarga de recibir y guardar las inscripciones al examen HSK
 * @param  [array] $data - Informacion del POST
 * @return bool - true en exito, false en fracaso
 */
function send_inscripcion_examen_form( $data ){
    // si no pasa el nonce muere
    // if( ! wp_verify_nonce( $data['st_nonce'], 'enviar_inscripcion_hsk' ) ){
    //     return 'invalid';
    // }

    // validacion de email por php
    if( !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        return 'invalid';
    }

    // Se revisa la existencia y se suben lios archivos correspondientes
    // Los 3 archivos son requeridos por lo que el formulario no se envia si es que no existen

    // finfo para revisar los mime types
    $finfo = new finfo(FILEINFO_MIME_TYPE);

    // comprobante
    if( !empty($_FILES) && !empty($_FILES['comprobante']) ){
        // revisa el mime type
        // debe ser jpg o pdf
        $extension = array_search($finfo->file($_FILES['comprobante']['tmp_name']), array(
            'jpg' => 'image/jpeg',
            'pdf' => 'application/pdf'
        ), true);

        if( $extension === false ){ return 'bad_mimetype'; }

        $comprobante_id = upload_custom_file( $_FILES['comprobante'] );
        if( !$comprobante_id ){
            wp_die('Error al subir el archivo de comprobante');
        }
    } else {
        return 'missing_file';
    }

    // foto de cedula de identidad
    if( !empty($_FILES) && !empty($_FILES['foto-cedula']) ){
        // revisa el mime type
        // debe ser jpg o pdf
        $extension = array_search($finfo->file($_FILES['foto-cedula']['tmp_name']), array(
            'jpg' => 'image/jpeg',
            'pdf' => 'application/pdf'
        ), true);

        if( $extension === false ){ return 'bad_mimetype'; }

        $foto_cedula_id = upload_custom_file( $_FILES['foto-cedula'] );
        if( !$foto_cedula_id ){
            wp_die('Error al subir el archivo de la foto de cédula de identidad');
        }
    } else {
        return 'missing_file';
    }

    // Foto de pasaporte
    if( !empty($_FILES) && !empty($_FILES['foto-pasaporte']) ){
        // revisa el mime type
        // debe ser jpg o pdf
        $extension = array_search($finfo->file($_FILES['foto-pasaporte']['tmp_name']), array(
            'jpg' => 'image/jpeg'
        ), true);

        if( $extension === false ){ return 'bad_mimetype'; }

        // la foto del pasaporte tambien tiene un limite de tamano
        // 500kb
        if( $_FILES['foto-pasaporte']['size'] > 500000 ){ return 'file_too_big'; }

        $foto_pasaporte_id = upload_custom_file( $_FILES['foto-pasaporte'] );
        if( !$foto_pasaporte_id ){
            wp_die('Error al subir el archivo de la foto del pasaporte');
        }
    } else {
        return 'missing_file';
    }



    // primero se hace el post
    // Primero se guarga el respaldo en un post tipo contacto.
    $new_id = wp_insert_post(array(
        'post_title' => 'Inscripción de '. $data['nombre'] .' '. $data['apellido'],
        'post_type' => 'inscripcion_examen',
        'post_status' => 'publish'
    ));

    if( !$new_id || is_wp_error($new_id) ){
        wp_die('Error al crear inscripción');
    }

    //
    // primer fieldset
    //

    // campo: "tipo_examen"
    update_field( "field_55d73c217f8d1", $data['tipo-examen'], $new_id );

    // campo: "examen_escrito"
    update_field( "field_55bf817fcae22", $data['examen-escrito'], $new_id );

    // campo: "examen_oral"
    update_field( "field_55bf8197cae23", $data['examen-oral'], $new_id );

    // campo: "sede_rendicion"
    update_field( "sede_rendicion", $data['sede'], $new_id );

    //
    // segundo fieldset
    //

    // campo: "comprobante"
    update_field( "field_55bf81bbcae24", $comprobante_id, $new_id );

    // campo: "foto_cedula"
    update_field( "field_56814c97f5c58", $foto_cedula_id, $new_id );

    // campo: "foto_pasaporte"
    update_field( "field_56814cb9f5c59", $foto_pasaporte_id, $new_id );


    //
    // tercer fieldset
    //

    // campo: "nombre"
    update_field( "field_55bf7f90cae12", $data['nombre'], $new_id );

    // campo: "apellidos"
    update_field( "field_55bf7ff3cae13", $data['apellido'], $new_id );

    // campo: "nacionalidad"
    update_field( "field_55c4c748977d7", $data['pais'], $new_id );

    // campo: "rut"
    update_field( "field_55bf809ecae16", $data['rut'], $new_id );

    // la fecha de nacimientp se saca de 3 campos pero se guarda en uno
    $day = $data['born-day'];
    $month = $data['born-month'];
    $year = $data['born-year'];
    $fecha = date('Ymd', mktime(0,0,0,$month,$day,$year));

    // campo: "nacimiento"
    update_field( "field_55bf80b0cae17", $fecha, $new_id );

    // campo: "idioma"
    update_field( "field_55bf80d7cae18", $data['idioma'], $new_id );

    // campo: "telefono"
    update_field( "field_55bf80e3cae19", $data['telefono'], $new_id );

    // campo: "email"
    update_field( "field_55bf80eacae1a", $data['email'], $new_id );

    // campo: "direccion"
    update_field( "field_55bf80f1cae1b", $data['direccion'], $new_id );

    // campo: "ciudad"
    update_field( "field_55bf80f7cae1c", $data['ciudad'], $new_id );

    // campo: "actividad"
    update_field( "field_55bf8109cae1d", $data['actividad'], $new_id );

    // estos campos se llenan en funcion de la opcion anterior
    if( $data['actividad'] === 'Profesión' ){
        // campo: "profesion"
        update_field( "field_55bf8124cae1e", $data['profesion'], $new_id );
    }
    else {
        // campo: "institucion"
        update_field( "field_55bf8137cae1f", $data['institucion'], $new_id );

        // campo: "carrera"
        update_field( "field_55bf8142cae20", $data['carrera'], $new_id );
    }

    // estudios de chino
    // solo funciona si la respuesta es "Si"
    if( $data['estudios-chino'] === 'Si' ){
        // campo "estudios_chino"
        update_field( "field_56814c0f94453", true, $new_id );

        // campo: "lugar_estudios_chino"
        update_field( "field_56814c3194454", $data['lugar-estudio-chino'], $new_id );

        // campo: "rango_duracion"
        update_field( "field_55bf814ccae21", $data['rango-duracion'], $new_id );
    }



    ////////////
    //////////// ENVIAR NOTIFICACION
    ////////////

    $detalles = '<p>';
    $detalles .= '<strong>Tipo de examen:</strong> '. implode('y ', $data['tipo-examen']) .'<br>';
    $detalles .= '<strong>Nivel examen escrito:</strong> '. $data['examen-escrito'] .'<br>';
    $detalles .= '<strong>Nivel examen oral:</strong> '. $data['examen-oral'] .'<br>';
    $detalles .= '<strong>Sede de rendición:</strong> '. $data['sede'] .'<br>';

    $detalles .= '<strong>Nombre:</strong> '. $data['nombre'] .'<br>';
    $detalles .= '<strong>Apellidos:</strong> '. $data['apellido'] .'<br>';
    $detalles .= '<strong>Nacionalidad:</strong> '. $data['pais'] .'<br>';
    $detalles .= '<strong>Cédula de identidad:</strong> '. $data['rut'] .'<br>';
    $detalles .= '<strong>Fecha de nacimiento:</strong> '. date('d/m/Y', mktime(0,0,0,$month,$day,$year)) .'<br>';
    $detalles .= '<strong>Idioma nativo:</strong> '. $data['idioma'] .'<br>';
    $detalles .= '<strong>Teléfono:</strong> '. $data['telefono'] .'<br>';
    $detalles .= '<strong>Email:</strong> '. $data['email'] .'<br>';
    $detalles .= '<strong>Dirección:</strong> '. $data['direccion'] .'<br>';
    $detalles .= '<strong>Ciudad de residencia:</strong> '. $data['ciudad'] .'<br>';
    $detalles .= '<strong>Actividad:</strong> '. $data['actividad'] .'<br>';

    if( $data['actividad'] === 'Profesión' ){
        $detalles .= '<strong>Profesión / Ocupación:</strong> '. $data['profesion'] .'<br>';
    }
    else {
        $detalles .= '<strong>Colegio o Institución:</strong> '. $data['institucion'] .'<br>';
        $detalles .= '<strong>Curso o Carrera:</strong> '. $data['carrera'] .'<br>';
    }


    $detalles .= '<strong>¿Posee estudios de Chino?:</strong> '. $data['estudios-chino'] .'<br>';
    if( $data['estudios-chino'] === 'Si' ){
        $detalles .= '<strong>Lugar donde estudió Chino:</strong> '. $data['lugar-estudio-chino'] .'<br>';
        $detalles .= '<strong>Estudios de chino (Duración):</strong> '. $data['rango-duracion'] .'<br>';
    }

    $detalles .= '</p>';


    $emails = get_emails();

    /// email para el usuario
    $mensaje = '<p>Hemos recibido su inscripción para rendir el examen HSK</p>';
    $mensaje .= '<p>Prontamente nos contactaremos con usted para confirmar lugar y hora de rendición del examen</p>';
    $mensaje .= '<p>Los detalles de la solicitud son:</p>';
    $mensaje .= $detalles;

    send_custom_email(array(
        'type' => 'notificacion',
        'to' => $data['nombre'] .' <'. $data['email'] .'>',
        'subject' => 'Inscripción examen HSK Instituto Confucio',
        'headers' => array(
            'From: Instituto Confucio <'. $emails['permanente'] .'>',
            'Reply-To: Instituto Confucio <'. $emails['permanente'] .'>'
        ),
        'email_contents' => array(
            'title' => 'Inscripción examen HSK Instituto Confucio',
            'intro' => 'Estimado/da '. $data['nombre'] . ':',
            'mensaje' => $mensaje
        )
    ));

    /// email para el administrador
    $mensaje = '<p>Hola, se recibió una nueva inscripción para rendir examen HSK.</p>';
    $mensaje .= '<p>Los detalles de la solicitud son:</p>';
    $mensaje .= $detalles;

    $mensaje .= '<p style="margin-top:40px; font-size:11px;" >Enviamos una confirmación automática al remitente del mensaje, notificándole que su solicitud de inscripción ha sido recibida.</p>';

    send_custom_email(array(
        'type' => 'notificacion',
        'to' => $emails['inscripcion_hsk'],
        'subject' => 'Inscripción examen HSK Instituto Confucio',
        'headers' => array(
            'From: Instituto Confucio <'. $emails['permanente'] .'>',
            'Cc: '. $emails['permanente'],
            'Reply-To: '. $data['nombre'] .' <'. $data['email'] .'>'
        ),
        'attachments' => array(
            get_attached_file( $comprobante_id ),
            get_attached_file( $foto_cedula_id ),
            get_attached_file( $foto_pasaporte_id )
        ),
        'email_contents' => array(
            'title' => 'Inscripción examen HSK Instituto Confucio',
            'intro' => 'Estimado/da: ',
            'mensaje' => $mensaje
        )
    ));

    return true;
}

/**
 * Se encarga de recibir y procesar el formulario de inscripcion a talleres
 * @param  [array] $data - Información del POST del formulario
 * @return bool
 */
function send_inscripcion_taller_form( $data ){
    // si no pasa el nonce muere
    // if( ! wp_verify_nonce( $data['st_nonce'], 'enviar_inscripcion_talleres' ) ){
    //     return 'invalid';
    // }

    // validacion de email por php
    if( !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        return 'invalid';
    }

    // Es primordial la existencia del archivo del comprobante por lo que
    // si no existe se devuelve de inmediato
    // if( !empty($_FILES) && !empty($_FILES['comprobante']) && !empty($_FILES['comprobante']['name']) ){
    //     $archivo_id = upload_custom_file( $_FILES['comprobante'] );
    //     if( !$archivo_id ){
    //         wp_die('Error al subir el archivo de comprobante');
    //     }
    // } else {
    //     return 'invalid';
    // }

    // primero se hace el post
    // Primero se guarga el respaldo en un post tipo contacto.
    $new_id = wp_insert_post(array(
        'post_title' => 'Inscripción de '. $data['nombre'] .' '. $data['apellido'],
        'post_type' => 'inscripcion_taller',
        'post_status' => 'publish'
    ));

    if( !$new_id || is_wp_error($new_id) ){
        wp_die('Error al crear inscripción');
    }

    // se llenan los ACF correspondientes
    // campo: "sede"
    update_field( "field_55bfc1dd7f9ee", intval($data['sede']), $new_id );

    // campo: "taller"
    update_field( "field_55bfc21a7f9f0", array( intval($data['taller']) ), $new_id );

    // campo: "nombre"
    update_field( "field_55bfc2517f9f1", $data['nombre'], $new_id );

    // campo: "apellidos"
    update_field( "field_55bfc2577f9f2", $data['apellido'], $new_id );

    // campo: "rut"
    // update_field( "field_55bfc25c7f9f3", $data['rut'], $new_id );

    // campo: "telefono"
    update_field( "field_55bfc2627f9f4", $data['telefono'], $new_id );

    // campo: "email"
    update_field( "field_55bfc26a7f9f5", $data['email'], $new_id );

    // campo: "pais"
    // update_field( "field_55bfc2737f9f6", $data['pais'], $new_id );

    // campo: "tipo_asistente"
    update_field( "field_55bfc27b7f9f7", $data['tipo-asistente'], $new_id );

    // estos campos se llenan en funcion de la opcion anterior
    //
    //

    if( $data['tipo-asistente'] === 'Alumno Santo Tomás' ){
        // campo: "carrera"
        update_field( "field_55bfc2b17f9f8", $data['alumno-carrera'], $new_id );
    }
    elseif( $data['tipo-asistente'] === 'Egresado Santo Tomás' ){
        // campo: "carrera"
        update_field( "field_55bfc2b17f9f8", $data['egresado-carrera'], $new_id );
    }
    elseif($data['tipo-asistente'] === 'Publico externo') {
        // campo: "institucion"
        update_field( "field_55bfc2c77f9fa", $data['institucion'], $new_id );
    }

    // campo: "comprobante"
    // update_field( "field_55bfc2e47f9fb", $archivo_id, $new_id );

    // si viene el cambo de suscribir checkeado entonces se inserta como suscriptor
    if( isset($data['suscribe-newsletter']) && !!$data['suscribe-newsletter'] ){
        insert_suscriber( $data['email'] );
    }

    ////////////
    //////////// ENVIAR NOTIFICIACION
    ////////////
    $emails = get_emails();

    $taller_id = intval($data['taller']);
    $fecha_stamp = strtotime( get_field('fecha', $taller_id) );
    $fecha_string = date_i18n('d \d\e F Y', $fecha_stamp);
    $sede = get_term_by('id', intval($data['sede']), 'sede');

    $detalles = '<p>';
    $detalles .= '<strong>Sede:</strong> '. $sede->name .'<br>';
    $detalles .= '<strong>Taller o actividad:</strong> '. get_the_title($taller_id) .'<br>';
    $detalles .= '<strong>Nombre:</strong> '. $data['nombre'] .'<br>';
    $detalles .= '<strong>Apellidos:</strong> '. $data['apellido'] .'<br>';
    // $detalles .= '<strong>RUT:</strong> '. $data['rut'] .'<br>';
    $detalles .= '<strong>Teléfono:</strong> '. $data['telefono'] .'<br>';
    $detalles .= '<strong>Email:</strong> '. $data['email'] .'<br>';
    // $detalles .= '<strong>País:</strong> '. $data['pais'] .'<br>';
    $detalles .= '<strong>Tipo de asistente:</strong> '. $data['tipo-asistente'] .'<br>';
    $detalles .= '</p>';

    $mensaje = '<p>Recibimos su <strong>inscripción para una actividad organizada por el Instituto Confucio</strong> con los siguientes datos:</p>';
    $mensaje .= $detalles;

    // email para el usuario
    send_custom_email(array(
        'type' => 'notificacion',
        'to' => $data['nombre'] .' <'. $data['email'] .'>',
        'subject' => 'Inscripción actividad Instituto Confucio',
        'headers' => array(
            'From: Instituto Confucio <'. $emails['permanente'] .'>',
            'Reply-To: Instituto Confucio <'. $emails['permanente'] .'>'
        ),
        'email_contents' => array(
            'title' => 'Inscripción actividad Instituto Confucio',
            'intro' => 'Estimado/da '. $data['nombre'] . ':',
            'mensaje' => $mensaje
        )
    ));

    $mensaje = '<p>Hemos recibido una <strong>inscripción para una actividad organizada por el Instituto Confucio</strong> con los siguientes datos:</p>';
    $mensaje .= $detalles;

    // $mensaje .= '<p>Además, hemos adjuntado el comprobante enviado por el solicitante al momento de inscribirse.</p>';

    $mensaje .= '<p style="margin-top:40px; font-size:11px;" >Enviamos una confirmación automática al remitente del mensaje, notificándole que este había sido recibido.</p>';

    /// email para el administrador
    send_custom_email(array(
        'type' => 'notificacion',
        'to' => $emails['inscripcion_talleres'],
        'subject' => 'Inscripción actividad Instituto Confucio',
        'headers' => array(
            'From: Instituto Confucio <'. $emails['permanente'] .'>',
            'Cc: '. $emails['permanente'],
            'Reply-To: '. $data['nombre'] .' <'. $data['email'] .'>'
        ),
        // 'attachments' => isset($_FILES['comprobante']) ? $_FILES['comprobante'] : null,
        'email_contents' => array(
            'title' => 'Inscripción actividad Instituto Confucio',
            'intro' => 'Estimado/da: ',
            'mensaje' => $mensaje
        )
    ));

    return true;
}

/**
 * Se encarga de recibir y procesar el formulario de inscripcion de cursos
 * @param  [array] $data - Información del POST del formulario
 * @return bool
 */
function send_inscripcion_curso_form( $data ){
    // si no pasa el nonce muere
    // if( ! wp_verify_nonce( $data['st_nonce'], 'enviar_inscripcion_curso' ) ){
    //     return 'invalid';
    // }

    // validacion de email por php
    if( !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        return 'invalid';
    }

    // primero se hace el post
    // Primero se guarga el respaldo en un post tipo contacto.
    $new_id = wp_insert_post(array(
        'post_title' => 'Inscripción de '. $data['nombre'] .' '. $data['apellido'],
        'post_type' => 'inscripcion_curso',
        'post_status' => 'publish'
    ));

    if( !$new_id || is_wp_error($new_id) ){
        wp_die('Error al crear inscripción');
    }

    // se llenan los ACF correspondientes

    // campo: "rut"
    update_field( "field_567c111f8d072", $data['rut'], $new_id );

    // campo: "nombre"
    update_field( "field_55c0daaf6aacc", $data['nombre'], $new_id );

    // campo: "apellidos"
    update_field( "field_55c0dab36aacd", $data['apellido'], $new_id );

    // campo: "sede"
    update_field( "field_55c0dab86aace", intval($data['sede']), $new_id );

    // campo: "nivel"
    update_field( "field_55c0dacd6aacf", $data['nivel'], $new_id );

    // campo: "email"
    update_field( "field_55c0dad76aad0", $data['email'], $new_id );

    // campo: "telefono"
    update_field( "field_55c0dadf6aad1", $data['telefono'], $new_id );

    // campo: "convenio"
    update_field( "field_55c0dae66aad2", $data['convenio'], $new_id );

    // si viene el cambo de suscribir checkeado entonces se inserta como suscriptor
    if( isset($data['suscribe-newsletter']) && !!$data['suscribe-newsletter'] ){
        insert_suscriber( $data['email'] );
    }

    ////////////
    //////////// ENVIAR NOTIFICIACION
    ////////////

    $sede = get_term_by('id', intval($data['sede']), 'sede');

    $detalles = '<p>Los detalles de la solicitud son:</p>';
    $detalles .= '<p>';
    $detalles .= '<strong>RUT:</strong> '. $data['rut'] .'<br>';
    $detalles .= '<strong>Nombre:</strong> '. $data['nombre'] .'<br>';
    $detalles .= '<strong>Apellidos:</strong> '. $data['apellido'] .'<br>';
    $detalles .= '<strong>Sede:</strong> '. $sede->name .'<br>';
    $detalles .= '<strong>Nivel:</strong> '. $data['nivel'] .'<br>';
    $detalles .= '<strong>Email:</strong> '. $data['email'] .'<br>';
    $detalles .= '<strong>Teléfono:</strong> '. $data['telefono'] .'<br>';
    $detalles .= '</p>';

    $emails = get_emails();

    // email para el usuario
    $mensaje = '<p>Recibimos correctamente su <strong>pre inscripción al curso '. $data['nivel'] .'</strong></p>';
    $mensaje .= '<p>Recuerde que para hacer efectivo su cupo debe matricularse en la sede para la firma del respectivo contrato.</p>';
    $mensaje .= '<p>Prontamente nos contactaremos con usted para agilizar el proceso.</p>';
    $mensaje .= $detalles;
    $mensaje .= '<p><strong>Importante: </strong>El IC UST se reserva el derecho a no dictar un curso su no cumple el mínimo de alumnos requerido.</p>';


    send_custom_email(array(
        'type' => 'notificacion',
        'to' => $data['nombre'] .' <'. $data['email'] .'>',
        'subject' => 'Pre inscripción curso Instituto Confucio',
        'headers' => array(
            'From: Instituto Confucio <'. $emails['permanente'] .'>',
            'Reply-To: Instituto Confucio <'. $emails['permanente'] .'>'
        ),
        'email_contents' => array(
            'title' => 'Pre inscripción curso Instituto Confucio',
            'intro' => 'Estimado/da '. $data['nombre'] . ':',
            'mensaje' => $mensaje
        )
    ));

    /// email para el administrador


    $mensaje = '<p>Hola, se recibió una nueva pre inscripción a un curso de Chino Mandarin a IC UST</p>';
    $mensaje .= $detalles;

    $mensaje .= '<p style="margin-top:40px; font-size:11px;" >Enviamos una confirmación automática al remitente del mensaje, notificándole que este había sido recibido.</p>';

    send_custom_email(array(
        'type' => 'notificacion',
        'to' => $emails['inscripcion_cursos'],
        'subject' => 'Pre inscripción curso Instituto Confucio',
        'headers' => array(
            'From: Instituto Confucio <'. $emails['permanente'] .'>',
            'Cc: '. $emails['permanente'],
            'Reply-To: '. $data['nombre'] .' <'. $data['email'] .'>'
        ),
        'email_contents' => array(
            'title' => 'Pre inscripción curso Instituto Confucio',
            'intro' => 'Estimado/da: ',
            'mensaje' => $mensaje
        )
    ));

    return true;
}

/**
 * Se encarga de recibir el formulario de recordatorio
 * @param  [array] $data - Array de datos correspondiente al POST del formulario
 * @return mixed
 */
function send_reminder_form( $data ){
    global $post;

    // si no pasa el nonce muere
    // if( ! wp_verify_nonce( $data['st_nonce_reminder'], 'enviar_recordatorio' ) ){
    //     wp_die('Error al enviar el formulario');
    // }

    // notificaciones

    $emails = get_emails();

    $ancestor_id = get_super_parent( $post );

    $mensaje = '<p>Su solicitud de inscripción a <strong>'. get_the_title($ancestor_id) .'</strong> aún está incompleta.</p>';
    $mensaje .= '<p>Recuerde que puede completar la información de inscripción accediendo al <a href="'. get_permalink($post->ID) .'#formulario" title="Ir al formulario" >formulario de '. get_the_title($ancestor_id) .'</a> desde cualquier computador de escritorio.</p>';

    $mensaje .= '<p>Agradecemos su interés por participar en nuestras actividades.</p>';

    // email para el usuario
    send_custom_email(array(
        'type' => 'notificacion',
        'to' => $data['reminder-nombre'] .' <'. $data['reminder-email'] .'>',
        'subject' => 'Hemos recibido su mensaje',
        'headers' => array(
            'From: Instituto Confucio <'. $emails['permanente'] .'>',
            'Reply-To: Instituto Confucio <'. $emails['permanente'] .'>'
        ),
        'email_contents' => array(
            'title' => 'Hemos recibido su mensaje',
            'intro' => 'Estimado/da '. $data['reminder-nombre'] . ':',
            'mensaje' => $mensaje
        )
    ));

    return true;
}

/**
 * Sete el contenido de un email a html
 * se usa en send_custom_email
 */
function set_html_content_type(){
    return 'text/html';
}

/**
 * Envia un email usando una de las plantillas previamente determinadas,
 * Esta funcion usa los output buffers de php para usar la plantilla de emails
 * de esta forma se hace mas facil la edicion y administracion de estas plantillas
 * @param  array $email_data - Array de datos que debe contener el email, tiene la forma de
 * array(
 *        'type' => 'notificacion',
 *        'to' => $emails['contacto'],
 *        'subject' => 'Nuevo Mensaje de contacto',
 *        'headers' => array(
 *            'From: Santo Tomás en Línea <'. $emails['permanente'] .'>',
 *            'Cc: '. $emails['permanente'],
 *            'Reply-To: '. $data['contact-name'] .' <'. $data['contact-email'] .'>'
 *        ),
 *        'email_contents' => array(
 *            'title' => '',
 *            'titulo' => '',
 *            'intro' => '',
 *            'mensaje' => ''
 *        )
 *    )
 * @return  void
 */
function send_custom_email( $email_data, $return = false ){
    // $email_data['email_contents'] = array();
    // type = 'notificacion',
    // title = <title> del email (obligatorio),
    // intro = introduccion al mensaje (obligatorio)
    // mensaje = mensaje del email en formato HTML (obligatorio)

    $to = $email_data['to'];
    $subject = $email_data['subject'];
    $headers = $email_data['headers'];
    $attachments = isset($email_data['attachments']) && !empty($email_data['attachments']) ? $email_data['attachments'] : null;

    $GLOBALS['email_contents'] = $email_data['email_contents'];

    // se empieza un output buffer para contener el template del email
    ob_start();
    get_template_part('partials/email', $email_data['type']);
    $message = ob_get_clean();
    // temina el output buffer

    // solo en caso de que se quiera devolver el string del correo
    if( !!$return ){ return $message; }

    add_filter( 'wp_mail_content_type', 'set_html_content_type' );
    wp_mail( $to, $subject, $message, $headers, $attachments );
    remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
}

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////// Exportaciones de contenido
////////////////////////////////////////////////////////////////////////////////

/**
 * Recibe los request de los botones de exportacion
 */
add_action( 'admin_init', 'recieve_exports_suscribers' );
function recieve_exports_suscribers(){
    global $pagenow;

    // solo debe activarse dentro de la edicion de los posts
    if( $pagenow !== 'edit.php' ){ return; }
    if( !isset($_GET['exportar']) ){ return; }

    if( $_GET['exportar'] === 'suscriptores' ){
        return export_suscribers_data();
    }
    elseif( $_GET['exportar'] === 'inscripcion_examen' ){
        return export_inscripcion_examen_data();
    }
    elseif( $_GET['exportar'] === 'inscripcion_talleres' ){
        return export_inscripcion_talleres_data();
    }
    elseif( $_GET['exportar'] === 'inscripcion_cursos' ){
        return export_inscripcion_cursos_data();
    }
}

/**
 * Funciones para añadir los botones de exportacion en los post types correspondientes
 */
add_filter( 'views_edit-suscriptor', 'add_export_suscribers_button' );
function add_export_suscribers_button( $views ){
    $url = add_query_arg('exportar', 'suscriptores');

    $views['export-suscribers'] = '<a class="button button-small" href="'. $url .'" title="Exportar suscriptores" rel="nofollow" target="_blank" style="margin-bottom: 10px;">Exportar suscriptores</a>';
    return $views;
}

add_filter( 'views_edit-inscripcion_examen', 'add_export_inscripcion_examen_button' );
function add_export_inscripcion_examen_button( $views ){
    $url = add_query_arg('exportar', 'inscripcion_examen');

    $views['export-suscribers'] = '<a class="button button-small" href="'. $url .'" title="Exportar Inscripciones" rel="nofollow" target="_blank" style="margin-bottom: 10px;">Exportar Inscripciones</a>';
    return $views;
}

add_filter( 'views_edit-inscripcion_taller', 'add_export_inscripcion_taller_button' );
function add_export_inscripcion_taller_button( $views ){
    $url = add_query_arg('exportar', 'inscripcion_talleres');

    $views['export-suscribers'] = '<a class="button button-small" href="'. $url .'" title="Exportar Inscripciones" rel="nofollow" target="_blank" style="margin-bottom: 10px;">Exportar Inscripciones</a>';
    return $views;
}

add_filter( 'views_edit-inscripcion_curso', 'add_export_inscripcion_cursos_button' );
function add_export_inscripcion_cursos_button( $views ){
    $url = add_query_arg('exportar', 'inscripcion_cursos');

    $views['export-suscribers'] = '<a class="button button-small" href="'. $url .'" title="Exportar Inscripciones" rel="nofollow" target="_blank" style="margin-bottom: 10px;">Exportar Inscripciones</a>';
    return $views;
}

/**
 * Exporta un excel de todos los suscriptores (post_type = 'suscriptor')
 * y sus metadatos
 * @return void
 */
function export_suscribers_data(){
    global $wpdb;

    $suscriptores = $wpdb->get_results("
        SELECT ID, post_title, post_date
        FROM $wpdb->posts
        WHERE post_type = 'suscriptor'
        AND post_status = 'publish'
        ORDER BY post_date ASC
    ");

    /// si no hay suscriptores se tira un error bonito
    if( empty($suscriptores) ){ wp_die('No se encontraron suscriptores'); }

    /* Set internal character encoding to UTF-8 */
    mb_internal_encoding("UTF-8");

    header("Content-Type: application/xls");
    header('Content-Disposition: attachment; filename="suscriptores-confucio.xls"');

    $out = '<table>';
    $out .= '<thead>';
    $out .= '<tr>';
    $out .= '<th>Fecha</th>';
    $out .= '<th>Email</th>';
    $out .= '</tr>';
    $out .= '</thead>';
    $out .= '</tbody>';

    foreach( $suscriptores as $sus ){
        $out .= '<tr>';
        $out .= '<td>'. date('d/m/Y', strtotime($sus->post_date)) .'</td>';
        $out .= '<td>'. htmlentities($sus->post_title) .'</td>';
        $out .= '</tr>';
    }

    $out .= '</tbody>';
    $out .= '</table>';

    echo $out;
    exit;
}

/**
 * Exporta un excel de todos los Inscriptores al Examen HSK (post_type = 'inscripcion_examen')
 * y sus metadatos
 * @return void
 */
function export_inscripcion_examen_data(){
    global $wpdb;

    $items = $wpdb->get_results("
        SELECT ID
        FROM $wpdb->posts
        WHERE post_type = 'inscripcion_examen'
        AND post_status = 'publish'
    ");

    /* Set internal character encoding to UTF-8 */
    mb_internal_encoding("UTF-8");

    /// si no hay inscripciones se tira un error bonito
    if( empty($items) ){ wp_die('No se encontraron inscripciones'); }

    header("Content-Type: application/xls");
    header('Content-Disposition: attachment; filename="inscripciones-hsk-confucio.xls"');


    $out = '<table>';
    $out .= '<thead>';
    $out .= '<tr>';
    $out .= '<th>'. htmlentities('Fecha') .'</th>';
    $out .= '<th>'. htmlentities('Tipo de examen') .'</th>';
    $out .= '<th>'. htmlentities('Examen escrito') .'</th>';
    $out .= '<th>'. htmlentities('Examen oral') .'</th>';
    $out .= '<th>'. htmlentities('Sede de Rendición') .'</th>';

    $out .= '<th>'. htmlentities('Comprobante') .'</th>';
    $out .= '<th>'. htmlentities('Foto Cédula de identidad') .'</th>';
    $out .= '<th>'. htmlentities('Foto Pasaporte') .'</th>';

    $out .= '<th>'. htmlentities('Nombre') .'</th>';
    $out .= '<th>'. htmlentities('Apellidos') .'</th>';
    $out .= '<th>'. htmlentities('RUT') .'</th>';
    $out .= '<th>'. htmlentities('Fecha de nacimiento') .'</th>';
    $out .= '<th>'. htmlentities('Idioma nativo') .'</th>';
    $out .= '<th>'. htmlentities('Teléfono') .'</th>';
    $out .= '<th>'. htmlentities('Email') .'</th>';
    $out .= '<th>'. htmlentities('Dirección') .'</th>';
    $out .= '<th>'. htmlentities('Ciudad de residencia') .'</th>';
    $out .= '<th>'. htmlentities('Actividad') .'</th>';
    $out .= '<th>'. htmlentities('Profesión / Ocupación') .'</th>';
    $out .= '<th>'. htmlentities('Colegio o institución') .'</th>';
    $out .= '<th>'. htmlentities('Carrera') .'</th>';
    $out .= '<th>'. htmlentities('Estudios de Chino') .'</th>';
    $out .= '<th>'. htmlentities('Lugar de estudios de chino') .'</th>';
    $out .= '<th>'. htmlentities('Duración estudios cde chino') .'</th>';

    $out .= '</tr>';
    $out .= '</thead>';
    $out .= '</tbody>';

    foreach( $items as $item ){
        // se sacan todos los metas de una para evitar sobrecarga de
        // queries a la bbdd
        $metas = get_post_custom( $item->ID );

        $out .= '<tr>';

        $out .= '<td>'. htmlentities(get_the_date( 'd/m/Y', $item->ID )) .'</td>';

        $tipo_examen = maybe_unserialize( $metas['tipo_examen'][0] );
        $out .= '<td>'. htmlentities( implode('y ', $tipo_examen) ) .'</td>';


        $out .= '<td>'. htmlentities( 'Nivel - '. $metas['examen_escrito'][0] ) .'</td>';
        $out .= '<td>'. htmlentities( 'Nivel - '. $metas['examen_oral'][0] ) .'</td>';
        $out .= '<td>'. htmlentities( $metas['sede_rendicion'][0] ) .'</td>';

        $out .= '<td>'. htmlentities( wp_get_attachment_url( $metas['comprobante'][0] ) ) .'</td>';
        $out .= '<td>'. htmlentities( wp_get_attachment_url( $metas['foto_cedula'][0] ) ) .'</td>';
        $out .= '<td>'. htmlentities( wp_get_attachment_url( $metas['foto_pasaporte'][0] ) ) .'</td>';

        $out .= '<td>'. htmlentities( $metas['nombre'][0] ) .'</td>';
        $out .= '<td>'. htmlentities( $metas['apellidos'][0] ) .'</td>';
        $out .= '<td>'. htmlentities( $metas['rut'][0] ) .'</td>';
        $out .= '<td>'. htmlentities( date_i18n('d/m/Y', strtotime($metas['nacimiento'][0])) ) .'</td>';
        $out .= '<td>'. htmlentities( $metas['idioma'][0] ) .'</td>';
        $out .= '<td>'. htmlentities( $metas['telefono'][0] ) .'</td>';
        $out .= '<td>'. htmlentities( $metas['email'][0] ) .'</td>';
        $out .= '<td>'. htmlentities( $metas['direccion'][0] ) .'</td>';
        $out .= '<td>'. htmlentities( $metas['ciudad'][0] ) .'</td>';
        $out .= '<td>'. htmlentities( $metas['actividad'][0] ) .'</td>';

        if( isset($metas['profesion']) ){
            $out .= '<td>'. htmlentities( $metas['profesion'][0] ) .'</td>';
        }
        else {
            $out .= '<td> - </td>';
        }

        if( isset($metas['institucion']) ){
            $out .= '<td>'. htmlentities( $metas['institucion'][0] ) .'</td>';
        }
        else {
            $out .= '<td> - </td>';
        }

        if( isset($metas['carrera']) ){
            $out .= '<td>'. htmlentities( $metas['carrera'][0] ) .'</td>';
        }
        else {
            $out .= '<td> - </td>';
        }

        if( isset($metas['estudios_chino']) ){
            $out .= '<td>Si</td>';
            $out .= '<td>'. htmlentities( $metas['lugar_estudios_chino'][0] ) .'</td>';
            $out .= '<td>'. htmlentities( $metas['rango_duracion'][0] ) .'</td>';
        }
        else {
            $out .= '<td>No</td>';
            $out .= '<td> - </td>';
            $out .= '<td> - </td>';
        }

        $out .= '</tr>';
    }

    $out .= '</tbody>';
    $out .= '</table>';

    echo $out;
    exit;
}

/**
 * Exporta un excel de todos los Inscriptores a los taleres y actividades (post_type = 'inscripcion_taller')
 * y sus metadatos
 * @return void
 */
function export_inscripcion_talleres_data(){
    global $wpdb;

    $items = $wpdb->get_results("
        SELECT ID
        FROM $wpdb->posts
        WHERE post_type = 'inscripcion_taller'
        AND post_status = 'publish'
    ");

    /* Set internal character encoding to UTF-8 */
    mb_internal_encoding("UTF-8");

    /// si no hay inscripciones se tira un error bonito
    if( empty($items) ){ wp_die('No se encontraron inscripciones'); }

    header("Content-Type: application/slx");
    header('Content-Disposition: attachment; filename="inscripciones-talleres-confucio.xls"');

    $out = '<table>';
    $out .= '<thead>';
    $out .= '<tr>';
    $out .= '<th>'. htmlentities('Fecha') .'</th>';
    $out .= '<th>'. htmlentities('Sede') .'</th>';
    $out .= '<th>'. htmlentities('Taller o actividad') .'</th>';
    $out .= '<th>'. htmlentities('Nombre') .'</th>';
    $out .= '<th>'. htmlentities('Apellidos') .'</th>';
    // $out .= '<th>'. htmlentities('RUT') .'</th>';
    $out .= '<th>'. htmlentities('Teléfono') .'</th>';
    $out .= '<th>'. htmlentities('Email') .'</th>';
    // $out .= '<th>'. htmlentities('País') .'</th>';
    $out .= '<th>'. htmlentities('Tipo de asistente') .'</th>';
    $out .= '<th>'. htmlentities('Carrera') .'</th>';
    $out .= '<th>'. htmlentities('Empresa, institución u organización') .'</th>';
    // $out .= '<th>'. htmlentities('Comprobante') .'</th>';
    $out .= '</tr>';
    $out .= '</thead>';
    $out .= '</tbody>';


    foreach( $items as $item ){
        $out .= '<tr>';

        $out .= '<td>'. htmlentities(get_the_date( 'd/m/Y', $item->ID )) .'</td>';

        // la sede viene en forma de term_id
        $sede = get_term_by('id', get_field('sede', $item->ID), 'sede');
        $out .= '<td>'. htmlentities($sede->name) . '</td>';

        // el taller viene en forma de array( post_id )
        $taller = get_field('taller', $item->ID)[0];
        $out .= '<td>'. htmlentities(get_the_title( $taller )) . '</td>';

        $out .= '<td>'. htmlentities(get_field('nombre', $item->ID)) . '</td>';
        $out .= '<td>'. htmlentities(get_field('apellidos', $item->ID)) . '</td>';
        // $out .= '<td>'. htmlentities(get_field('rut', $item->ID)) . '</td>';
        $out .= '<td>'. htmlentities(get_field('telefono', $item->ID)) . '</td>';
        $out .= '<td>'. htmlentities(get_field('email', $item->ID)) . '</td>';
        // $out .= '<td>'. htmlentities(get_field('pais', $item->ID)) . '</td>';
        $out .= '<td>'. htmlentities(get_field('tipo_asistente', $item->ID)) . '</td>';
        $out .= '<td>'. htmlentities( get_field('carrera', $item->ID) ) . '</td>';
        $out .= '<td>'. htmlentities( get_field('institucion', $item->ID) ) . '</td>';

        // el comprobante viene en forma de attachment_id
        // $out .= '<td>'. wp_get_attachment_url( get_field('comprobante', $item->ID) ) . '</td>';

        $out .= '</tr>';
    }

    $out .= '</tbody>';
    $out .= '</table>';

    echo $out;
    exit;
}

/**
 * Exporta un excel de todos los Inscriptores a los taleres y actividades (post_type = 'inscripcion_curso')
 * y sus metadatos
 * @return void
 */
function export_inscripcion_cursos_data(){
    global $wpdb;

    $items = $wpdb->get_results("
        SELECT ID
        FROM $wpdb->posts
        WHERE post_type = 'inscripcion_curso'
        AND post_status = 'publish'
    ");

    /* Set internal character encoding to UTF-8 */
    mb_internal_encoding("UTF-8");

    /// si no hay inscripciones se tira un error bonito
    if( empty($items) ){ wp_die('No se encontraron inscripciones'); }

    header("Content-Type: application/vnd.ms-excel");
    header('Content-Disposition: attachment; filename="inscripciones-cursos-confucio.xls"');

    $out = '<table>';
    $out .= '<thead>';
    $out .= '<tr>';
    $out .= '<th>'. htmlentities('Fecha') .'</th>';
    $out .= '<th>'. htmlentities('RUT') .'</th>';
    $out .= '<th>'. htmlentities('Nombre') .'</th>';
    $out .= '<th>'. htmlentities('Apellidos') .'</th>';
    $out .= '<th>'. htmlentities('Sede') .'</th>';
    $out .= '<th>'. htmlentities('Nivel') .'</th>';
    $out .= '<th>'. htmlentities('Email') .'</th>';
    $out .= '<th>'. htmlentities('Teléfono') .'</th>';
    $out .= '<th>'. htmlentities('Convenio') .'</th>';
    $out .= '</tr>';
    $out .= '</thead>';
    $out .= '</tbody>';

    foreach( $items as $item ){
        $out .= '<tr>';
        $out .= '<td>'. htmlentities(get_the_date( 'd/m/Y', $item->ID )) .'</td>';
        $out .= '<td>'. htmlentities(get_field('rut', $item->ID)) . '</td>';
        $out .= '<td>'. htmlentities(get_field('nombre', $item->ID)) . '</td>';
        $out .= '<td>'. htmlentities(get_field('apellidos', $item->ID)) . '</td>';

        // la sede viene en forma de term_id
        $sede = get_term_by('id', get_field('sede', $item->ID), 'sede');
        $out .= '<td>'. htmlentities($sede->name) . '</td>';

        $out .= '<td>'. htmlentities(get_field('nivel', $item->ID)) . '</td>';
        $out .= '<td>'. htmlentities(get_field('email', $item->ID)) . '</td>';
        $out .= '<td>'. htmlentities(get_field('telefono', $item->ID)) . '</td>';
        $out .= '<td>'. htmlentities(get_field('convenio', $item->ID)) . '</td>';
        $out .= '</tr>';
    }

    $out .= '</tbody>';
    $out .= '</table>';

    echo $out;
    exit;
}


////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////// Funciones auxiliares
////////////////////////////////////////////////////////////////////////////////

/**
 * Devuelve un mensaje de alerta formateado en base al boilerplate del sitio
 * @param  [array] $info - informacion de la alerta, tiene 'titulo' y 'mensaje'
 * @return string - HTML de la alerta
 */
function alerta( $info = array() ){
    $html = '<div class="message alert">';

    if( isset($info['titulo']) ) {
        $html .= '<h2 class="message-title">'. $info['titulo'] .'</h2>';
    }

    if( isset($info['mensaje']) ) {
        $html .= apply_filters('the_content', $info['mensaje']);
    }

    $html .= '</div>';

    return $html;
}

/**
 * [generate_share_urls]
 * @param  [object]     $post_object
 * @return [array]      URLs para compartir el post
 */
function generate_share_urls( $post_object, $custom_message = false, $target = false ){

    $shortlink = wp_get_shortlink( $post_object->ID );

    if( $target ){
        $shortlink = $shortlink . '#' . $target;
    }

    $clean_url = urldecode( $shortlink );

    $title = urlencode( get_the_title( $post_object->ID ) );

    if( $custom_message ){
        $message = urlencode( cut_string_to( $custom_message, 70 ) );
    }
    else {
        $message = urlencode( cut_string_to( $post_object->post_content, 70 ) );
    }

    $image_url = '';
    if( has_post_thumbnail( $post_object->ID ) ){
        $image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post_object->ID ), 'full' );
        $image_url = $image_url[0];
    }

    $fb_link = 'http://www.facebook.com/sharer.php?u=' . get_permalink( $post_object->ID );

    $twt_link = 'https://twitter.com/intent/tweet?text=' . $title . '+' . $clean_url;

    $google_link = 'https://plus.google.com/share?url=' . $clean_url;

    $linkedin_link = 'https://www.linkedin.com/cws/share?url=' . $clean_url;

    return array(
        'facebook' => $fb_link,
        'twitter' => $twt_link,
        'google' => $google_link,
        'linkedin' => $linkedin_link,
        'shortlink' => $shortlink,
        'permalink' => get_permalink( $post_object->ID )
    );
}

/**
 * Parsea el texto de un tweet (o cualquier string) en busca de URL, hashtags y menciones
 * para luego transformarlas en links accesibles
 * @param  string $tweet_text - Texto que se quiere parsear
 * @return string - Texto parseado
 */
function parse_twitter_links( $tweet_text ){
    $urlRegexp = "/[A-Za-z]+:\/\/[A-Za-z0-9-_]+\.[A-Za-z0-9-_:%&~\?\/.=]+/";
    $twitterMentionRegexp = "/\B@([\w-]+)/m";
    $hashTagRegexp = "/[#]+[A-Za-z0-9-_äáàëéèíìöóòúùñç]+/"; // hashtags hispanos

    $tweet_text = preg_replace( $urlRegexp, '<a href="$0" title="Ver enlace" rel="external nofollow" target="_blank">$0</a>', $tweet_text);
    $tweet_text = preg_replace( $twitterMentionRegexp, '<a href="https://twitter.com/$0" title="Ver perfil" rel="external nofollow" target="_blank">$0</a>', $tweet_text);
    $tweet_text = preg_replace( $hashTagRegexp, '<a href="https://twitter.com/$0" title="Ver tweets relacionados con el hashtag $0" rel="external nofollow" target="_blank">$0</a>', $tweet_text);
    return $tweet_text;
}

/**
 * Devuelve el nombre de usuario ingresado en el campo ACF "usuarios_sociales"
 * dependiendo de el nombre de la cuenta social
 * @param  string $account - Nombre de la red, posibles valores: "twitter", "facebook", "google", "linkedin"
 * @return string - Nombre de usuario de la cuenta
 */
function get_social_account( $account ){
    $usuarios = get_field('usuarios_sociales', 'options')[0];
    return $usuarios[ $account ];
}

/**
 * Va a buscar un $post en base al slug (post_name) pasado
 * @param  string $slug - Slug o post_name del post que se quiere rescatar
 * @param  string $field - (opcional) Campo especifico que se desea del post.
 *                         Puede ser cualquiera del post object
 * @return mixed - false si no encuentra el post, $post_object (object) si es que lo encuentra
 */
function get_post_by_slug( $slug, $field = false ){
    global $wpdb;
    $pid = $wpdb->get_var($wpdb->prepare("
        SELECT ID
        FROM $wpdb->posts
        WHERE post_name = %s
    ", $slug));

    if( !$pid ){ return false; }

    $post_obj = get_post( $pid );

    if( $field && $post_obj ) {
        return $post_obj->{$field};
    }

    return get_post( $pid );
}

/**
 * Devuelve el nombre del usuario
 * @param  object $user $user_object de wordpress a quien sacarle el nombre
 * @return string Nombre del usuario parseado, danto prioridad a "primer_nombre apellido" y luego a $display_name
 */
function get_user_name( $user ){
    if( !$user || !is_object($user) ){
        return false;
    }

    $name = '';

    if( $user->first_name || $user->last_name ){
        $name = $user->first_name . ' ' . $user->last_name;
    }

    if( !$name ){ $name = $user->display_name; }

    return $name;
}

/**
 * Devuelve el post_content de un post basandose en el ID indicado
 * @param  int $pid ID del post en cuestion
 * @return string post_content del post en cuestion
 */
function get_content_by_id( $pid ){
    $p = get_post( $pid );
    return $p->post_content;
}

/**
 * Devuelve un array con los href de las redes sociales
 * @return array
 */
function get_social_links(){
    $perfiles_sociales = get_field('perfiles_sociales', 'options');
    if( !$perfiles_sociales ){ return false; }

    $perfiles_sociales = $perfiles_sociales[0];

    // filtro los resultados para asegurar una url (todas las sociales deben ir con https)
    $filtrados = array();
    foreach( $perfiles_sociales as $red => $url ){
        $filtrados[ $red ] = ensure_url( $url, 'https' );
    }

    // el repeater solo tiene un row
    return $filtrados;
}

/**
 * Devuelve el ID del termino basado en su slug/taxonomia
 * @param  string $term_slug Slug del $term en cuestion
 * @param  string $taxonomy  Nombre de la taxonomia asociada al $term
 * @return int El ID del $term indicado, 0 si no se encuentra
 */
function get_term_id( $term_slug, $taxonomy ){
    $term = get_term_by( 'slug', $term_slug, $taxonomy);
    if( !$term ){ return 0; }

    return intVal( $term->term_id );
}

/**
 * Revisa si se esta viendo la pagina de la categoria indicada o de alguno de sus categorias hijas
 * @param  slug  $parent_category_slug Slug de la categoria padre
 * @return boolean true si se encuentra en alguna de las paginas indicadas
 */
function is_category_current( $parent_category_slug ){
    // revisamos si es que estamos en el archivo de categoria
    if( is_category( $parent_category_slug ) ){ return true; }
    elseif( !is_category() && !is_single() ){ return false; }

    // revisa si es que estamos en el archivo de algun hijo de esta categoria
    $parent_term_id = get_term_id( $parent_category_slug, 'category' );

    if( is_category() ){
        $current_term = get_term_by( 'id', get_query_var( 'cat' ), 'category');
        if( $current_term->parent == $parent_term_id ){ return true; }
    }


    // revisamos si es que es un single y pertenece a la categoria o a alguno de sus hijos
    if( is_single() ){
        global $post;
        $post_cats = wp_get_post_terms($post->ID, 'category');

        // si no tiene categorias asociadas es false
        if( empty($post_cats) ){ return false; }

        $post_cat = $post_cats[0];
        // si el post tiene asignada la categoria
        if( $post_cat->slug === $parent_category_slug ){ return true; }

        // si el post tiene asignada una categoria hija a la en cuestion
        if( $post_cat->parent == $parent_term_id ){ return true; }
    }

    // si llega aca no es nada
    return false;
}

/**
 * Devuelve true si es que el $term indicado tiene hijos asignados
 * @param  int $term_id     ID del $term a revisar
 * @param  string $taxonomy Nombre de la taxonomia
 * @return boolean          true si el $term es padre, false si no tiene hijos o la taxonomia no existe
 */
function is_parent_term( $term_id, $taxonomy ){
    $children = get_term_children( $term_id, $taxonomy );
    if( is_wp_error( $children ) ){ return false; }

    return !!count($children);
}

/**
 * [printMe]
 * Imprime en pantalla cualquier cosa entre <pre>
 * @param  [mixed] $thing [description]
 * @return void
 */
function printMe( $thing ){
    echo '<pre>';
    print_r( $thing );
    echo '</pre>';
}

/**
 * [ensure_url]
 * Convierte un string con forma de url en una URL valida, si ya es una URL valida entonces se devuelve tal cual
 * @param  [type] $proto_url [description]
 * @return [type]            [description]
 */
function ensure_url( $proto_url, $protocol = 'http' ){
    if (filter_var($proto_url, FILTER_VALIDATE_URL)) {
        return $proto_url;
    }
    elseif( substr($proto_url, 0, 7) !== 'http://' || substr($proto_url, 0, 7) !== 'https:/' ){
        return $protocol . '://' . $proto_url;
    }
}

/**
 * [get_image_src description]
 * @param  [int] $id   ID del attachment
 * @param  [string] $size Nombre del tamano a sacar
 * @return [string] URL de la imagen en el tamano solicitado (false si es que falla)
 */
function get_image_src( $id, $size ){
    $img_data = wp_get_attachment_image_src( $id, $size );
    if( empty($img_data) ){ return false; }
    return $img_data[0];
}

/**
 * [needs_script description]
 * Revisa si un script ya se cargo, si no, lo carga
 * @param  [string] $script_name [nombre del script a incluir]
 * @return void
 */
function needs_script( $script_name ){
    if( !wp_script_is( $script_name ) ){
        wp_enqueue_script( $script_name );
    }
}

/**
 * [get_current_user_role description]
 * Devuelve el nombre del rol de un usuario
 * @param  [object] $user Objeto de usuario de wordpress
 * @return [string]
 */
function get_user_role( $user ) {
    $user_roles = $user->roles;
    $user_role = array_shift($user_roles);
    return $user_role;
}

/**
 * [time_ago]
 * Devuelve un string indicando cuanto tiempo (segundos, minutos, dias, horas ,etc...) ha pasado desde el timestamp indicado
 * @param  [int] $time Timestamp
 * @return [string]
 */
function time_ago( $time ) {

    $periods = array(
        array('singular' => 'segundo', 'plural' => 'segundos'),
        array('singular' => 'miunto', 'plural' => 'minutos'),
        array('singular' => 'hora', 'plural' => 'horas'),
        array('singular' => 'dia', 'plural' => 'dias'),
        array('singular' => 'semana', 'plural' => 'semanas'),
        array('singular' => 'mes', 'plural' => 'meses'),
        array('singular' => 'año', 'plural' => 'años'),
        array('singular' => 'decada', 'plural' => 'decadas')
    );
    $lengths = array("60","60","24","7","4.35","12","10");

    $now = strtotime("-3 hours"); // la hora de ahora con el timezone de santiago (-3 GMT)

    $difference = $now - $time;

    for( $id = 0; $difference > $lengths[$id] && $id < count($lengths)-1; $id++ ){
        $difference /= $lengths[$id];
    }

    $difference = round($difference);

    $time_tag = pluralize( $difference, $periods[$id]['singular'], $periods[$id]['plural'] );

    return "hace $difference $time_tag";
}

/**
 * [pluralize]
 * PLuraliza una palabra en base al numero que se pasa
 * @param  [int] $amount             numero de items
 * @param  [string] $singular_name   Nombre del item en singular
 * @param  [string] $plural_name     Nombre de item en plural
 * @return [string]                  Item pluralizado
 */
function pluralize( $amount, $singular_name, $plural_name ){
    if( intval($amount) !== 1 ){ return $plural_name; }
    return $singular_name;
}

/**
 * Devuelve el HTML de la paginacion de una $wp_query
 * @param  object $query $wp_query a la cual paginar
 * @param  string  $prev  Texto para el boton anterior
 * @param  string  $next  Texto para el boton siguiente
 * @return string HTML de la paginacion
 */
function get_pagination( $query = false, $prev = 'Anterior', $next = 'Siguiente' ) {
    global $wp_query;
    if ( !$query ) { $query = $wp_query; }

    $query->query_vars['paged'] > 1 ? $current = $query->query_vars['paged'] : $current = 1;

    // opciones generales para los links de paginacion, la opcion "format" puede esar en español7
    // solo si es que esta activo el filtro para cambiar esto
    $pagination = array(
        'base' => @add_query_arg('paged', '%#%'),
        'format' => '/page/%#%',
        'total' => $query->max_num_pages,
        'current' => $current,
        'prev_text' => __($prev),
        'next_text' => __($next),
        'mid_size' => 2,
        'type' => 'array'
    );

    $items = "";
    $pageLinksArray = paginate_links($pagination);

    if( !empty( $pageLinksArray ) ){
        // reviso si es que existe un link "anterior", lo saco del array y lo guardo en variable
        $prevLink = '';
        if( preg_match('/'. $prev .'/i', $pageLinksArray[0]) ){
            $prevLink = preg_replace('/\sclass=[\'|"][^\'"]+[\'|"]/', ' class="pagination-link direction" title="Página anterior" rel="prev" ', array_shift($pageLinksArray));
            $prevLink = preg_replace('/(?<=\"\>)(.*?)(?=\<\/)/', '&lsaquo;', $prevLink);
        }

        // lo mismo para el link "siguiente"
        $nextLink = '';
        if( preg_match('/'. $next .'/i', end($pageLinksArray)) ){
            $nextLink = preg_replace('/\sclass=[\'|"][^\'"]+[\'|"]/', ' class="pagination-link direction" title="Página siguiente" rel="next" ', array_pop($pageLinksArray));
            $nextLink = preg_replace('/(?<=\"\>)(.*?)(?=\<\/)/', '&rsaquo;', $nextLink);
        }

        // se ponen los links "anterior" y "siguiente" dentro del html deseado

        $items .= $prevLink;
        //se itera sobre los links de paginas
        foreach( (array)$pageLinksArray as $pageLink ){
            // se itera sobre el resto de los links con el fin de cambiar y/o agregar clases personalizadas

            // si estoy en la pagina
            if( preg_match('/current/i', $pageLink) ){
                $items .= preg_replace('/\sclass=[\'|"][^\'"]+[\'|"]/', ' class="pagination-link page-num active" rel="nofollow" ', $pageLink);
            }

            // si son los puntitos
            elseif( preg_match('/dots/i', $pageLink) ){
                $items .= preg_replace('/\sclass=[\'|"][^\'"]+[\'|"]/', ' class="pagination-link page-num dots" rel="nofollow" ', $pageLink);
            }

            // se cambian las clases de los links
            else {
                $items .= preg_replace('/\sclass=[\'|"][^\'"]+[\'|"]/', ' class="pagination-link page-num" rel="nofollow" title="Ir a la página" ', $pageLink);
            }
        }
        $items .= $nextLink;
    }

    $out = '<section class="pagination">';
    $out .= $items;
    $out .= '</section>';

    return $out;
}

/**
 * Se encarga de subir adecuadamente un archivo a wordpress para que
 * quede con todos sus tamanos en caso de imagen y
 * se cree un attachment que sea visible, linkeable y editable via administrador de medios
 * @param  array $file_data - Informacion proveniente de $_FILES
 * @param  array $mimes - Array de mimeTypes permitidos
 * @return int - El attachment ID del archivo recien subido
 */
function upload_custom_file( $file_data, $mimes = null ){
    if ( ! function_exists( 'wp_handle_upload' ) ) { require_once( ABSPATH . 'wp-admin/includes/file.php' ); }

    $fotoUpload = wp_handle_upload( $file_data, array( 'mimes' => $mimes, 'test_form' => false ) );
    $filename = $fotoUpload['file'];
    $wp_filetype = wp_check_filetype(basename($filename), null );
    $wp_upload_dir = wp_upload_dir();
    $attachment = array(
        'guid' => $wp_upload_dir['baseurl'] . _wp_relative_upload_path( $filename ),
        'post_mime_type' => $wp_filetype['type'],
        'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
        'post_content' => '',
        'post_status' => 'inherit'
    );
    $attach_id = wp_insert_attachment( $attachment, $filename );
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
    wp_update_attachment_metadata( $attach_id, $attach_data );

    return $attach_id;
}

/**
 * cut_string_to
 * @param  [string] $string     [Texto a cortar]
 * @param  [int] $charnum       [Numero de caracteres máximo para el texto]
 * @param  string $sufix        [Sufijo para el texto cortado]
 * @return [string]             [Texto cortado]
 */
function cut_string_to( $string, $charnum, $sufix = ' ...' ){
    $string = strip_tags( $string );
    if( strlen($string) > $charnum ){
        $string = substr($string, 0, ($charnum - strlen( $sufix )) ) . $sufix;
    }
    return mb_convert_encoding($string, "UTF-8");
}

/**
 * Devuelve la extension del archivo
 * @param  string $file_path - PATH al archivo
 * @return string - Extension del archivo
 */
function parse_mime_type( $file_path ) {
    $chunks = explode('/', $file_path);
    return substr(strrchr( array_pop($chunks) ,'.'),1);
}

/**
 * Devuelve el peso del archivo formateado
 * @param  string $attachment_file_path - PATH al archivo
 * @return string - Tamano formateado en kb
 */
function get_attachment_size( $attachment_file_path ) {
    return size_format( filesize( $attachment_file_path ) );
}

/**
 * Devuelve informacion variada acerca de un attachment en cuanto al archivo
 * @param  int $attach_id - ID del attachment
 * @return array - Coleccion de datos del attachment
 */
function get_file_info( $attach_id ) {
    $filePath = get_attached_file( $attach_id );
    $attach = get_post( $attach_id );

    if ( is_object($attach) ){
        return array(
            'attachment-id' => $attach_id,
            'attachment' => $attach,
            'filepath' => $filePath,
            'file_url' => $attach->guid,
            'file_mimetype' => parse_mime_type( $filePath ),
            'file_size' => get_attachment_size( $filePath )
        );
    }

    return array();
}

/**
 * Devuelve la URL actual con un "/" al final
 * Se usa para el filtro de sedes por lo que al generar la URL se quita este filtro para uso posterior
 * @return string - URL actual
 */
function get_current_url(){
    $current_url = '//' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    return remove_query_arg( 'filtro-sede', $current_url );
}

/**
 * Anade o mezcla un array de tax_query existente con otro devolviendo el resultado
 * @param  mixed - $old_tax_query - tax_query actual, puede estar vacio
 * @param  array - $aditional_tax_query - tax_query que agregar
 * @param  string $relation = relation del tax_query, default: "AND"
 * @return array - tax_query formateado y mesclado
 */
function merge_tax_query( $old_tax_query, $aditional_tax_query, $relation = 'AND' ){
    if( !$old_tax_query || !is_array( $old_tax_query ) ){
        return array( $aditional_tax_query );
    }

    if( !isset($old_tax_query['relation']) || !$old_tax_query['relation'] ){
        $old_tax_query['relation'] = $relation;
    }

    $old_tax_query[] = $aditional_tax_query;
    return $old_tax_query;
}

/**
 * Devuelve el nombre del rol de un usuario
 * @param  [object] $current_user Objeto de usuario de wordpress
 * @return [string]
 */
function get_current_user_role( $current_user ) {
    $user_roles = $current_user->roles;
    $user_role = array_shift($user_roles);
    return $user_role;
}

/**
 * revisa si es que la pagina actual es la del registro de wordpress (wp_login)
 * @return boolean
 */
function is_login_page() {
    return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
}

/**
 * Revisa si es que existe un suscriptor con el email indicado
 * @param  [string] $email - Email del posible suscriptor
 * @return bool
 */
function suscriber_unavailable( $email ){
    global $wpdb;

    $suscriber = $wpdb->get_var($wpdb->prepare("
        SELECT ID
        FROM $wpdb->posts
        WHERE post_type = 'suscriptor'
        AND post_title = %s
    ", $email));

    return !!$suscriber;
}

/**
 * getPlusOnesByURL()
 *
 * Get the numeric, total count of +1s from Google+ users for a given URL.
 *
 * Example usage:
 * <code>
 *   $url = 'http://www.facebook.com/';
 *   printf("The URL '%s' received %s +1s from Google+ users.", $url, GetPlusOnesByURL($url));
 * </code>
 *
 * @author          Stephan Schmitz <eyecatchup@gmail.com>
 * @copyright       Copyright (c) 2014 Stephan Schmitz
 * @license         http://eyecatchup.mit-license.org/  MIT License
 * @link            <a href="https://gist.github.com/eyecatchup/8495140">Source</a>.
 * @link            <a href="http://stackoverflow.com/a/13385591/624466">Read more</a>.
 *
 * @param   $url    string  The URL to check the +1 count for.
 * @return  intval          The total count of +1s.
 */
function getPlusOnesByURL($url) {
    if( !$url ){ return 0; } // si no hay url devuelve 0

    !filter_var($url, FILTER_VALIDATE_URL) &&
        die(sprintf('PHP said, "%s" is not a valid URL.', $url));

    foreach (array('apis', 'plusone') as $host) {
        $ch = curl_init(sprintf('https://%s.google.com/u/0/_/+1/fastbutton?url=%s',
                                      $host, urlencode($url)));
        curl_setopt_array($ch, array(
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows NT 6.1; WOW64) ' . 'AppleWebKit/537.36 (KHTML, like Gecko) ' . 'Chrome/32.0.1700.72 Safari/537.36'
        ));
        $response = curl_exec($ch);
        $curlinfo = curl_getinfo($ch);
        curl_close($ch);

        if (200 === $curlinfo['http_code'] && 0 < strlen($response)) { break 1; }
        $response = 0;
    }
    // si no hay respuesta se falla silenciosamente
    // !$response && die("Requests to Google's server fail..?!");
    if(!$response){
        return 0;
    }


    preg_match_all('/window\.__SSR\s\=\s\{c:\s(\d+?)\./', $response, $match, PREG_SET_ORDER);
    return (1 === sizeof($match) && 2 === sizeof($match[0])) ? intval($match[0][1]) : 0;
}

/**
 * Formatea un timestamp en un formato aceptable po iCal
 * @param  [int] $timestamp
 * @return string - fecha formateada
 */
function dateToCal($timestamp) {
  return date('Ymd\THis\Z', $timestamp);
}

/**
 * Escapa caracteres raros para compatibilidad con iCal
 * @param  [string] $string - texto a sanitizar
 * @return [string] - Texto sanitizado
 */
function escapeString($string) {
  return preg_replace('/([\,;])/','\\\$1', $string);
}

/**
 * Devuelve el objeto post ancestro de primer nivel al post indicado
 * @param  [mixed] $current_post_or_id - ID o post_object del que se quiere sacar el ancestro
 * @return int - post_id del ancestro de primer nivel
 */
function get_super_parent( $current_post_or_id ){
    $ancestros = get_post_ancestors( $current_post_or_id );
    $super = array_pop( $ancestros );
    if( $super ) return $super;

    if( is_object( $current_post_or_id ) && is_a( $current_post_or_id, 'WP_Post' ) )
        return $current_post_or_id->ID;

    return $current_post_or_id;
}

/**
 * Devuelve el ID de la página asociada a una sede en base al ID (de la taxonomia "sedes") o al slug de la sede
 * estas siemrpe se corresponden a pagias que son hijas de una pagina llamada "sedes"
 * @return int ID de la pagina de la sede
 */
function get_sede_page( $id_or_slug ){
    global $wpdb;
    $sedes_page_id = get_post_by_slug( 'sedes-instituto-confucio', 'ID' );
    $sede_slug = $id_or_slug;

    // si es numerico entonces estoy buscando in ID de taxonomia
    // devolvemos el slug del term
    if( is_numeric( $id_or_slug ) ){
        $sede_term = get_term_by('id', $id_or_slug, 'sede');
        $sede_slug = $sede_term->slug;
    }

    $sede_id = $wpdb->get_var($wpdb->prepare(
        "SELECT ID
        FROM $wpdb->posts
        WHERE post_name = %s
        AND post_parent = %d"
    ,$sede_slug, $sedes_page_id));

    return intval($sede_id);
}

/**
 * Devuelve el ID de la página data en base a su padre, hace una consulta directa a la bbdd
 * @param  [int] $parent_id - ID del padre (contexto)
 * @param  [mixed] $child_slug - Slug del objetivo o false si se quiere sacar todos los hijos de la pagina
 * @return mixed - ID de la pagina en cuestion o array de IDs de los hijos en caso de no haber $child_slug
 */
function get_child_by_slug( $parent_id, $child_slug = 0 ){
    global $wpdb;

    if( $child_slug ){
        return $wpdb->get_var($wpdb->prepare(
            "SELECT ID
            FROM $wpdb->posts
            WHERE post_type = 'page'
            AND post_status = 'publish'
            AND post_parent = %d
            AND post_name = %s",
        $parent_id, $child_slug ));
    }

    // en caso de que no haya un $child_slug se devuelve un array plano de los IDs de las paginas hijas
    $children = $wpdb->get_results($wpdb->prepare(
        "SELECT ID
        FROM $wpdb->posts
        WHERE post_type = 'page'
        AND post_status = 'publish'
        AND post_parent = %d ",
    $parent_id ));

    // se aplana el array para que no queden objetos y cosas raras
    if( is_array($children) && !empty($children) ){
        $children = array_map(function( $val ){ return $val->ID; }, $children);
    }

    return $children;
}

/**
 * Devuelve un array asociativo de emails correspondientes a las notificaciones
 * Estos se setean en el area de administracion bajo "opciones generales" > "notificaciones"
 * @return array
 */
function get_emails(){
    return get_field('emails_notificaciones', 'options')[0];
}

/**
 * Intercala los valores de 2 arrays en base al array mas largo
 * @param  [array] $array_1 - primer array
 * @param  [array] $array_2 - segundo array
 * @return array - resultado intercalado
 */
function interpolar_array($array_1, $array_2){
    $resultado = array();

    $size_1 = sizeof($array_1);
    $size_2 = sizeof($array_2);

    if( $size_1 > $size_2 ){
        $max = $size_1;
        $big = $array_1;
        $small = $array_2;
    }
    else {
        $max = $size_2;
        $big = $array_2;
        $small = $array_1;
    }

    for( $i = 0; $i < $max; $i++ ){
        $resultado[] = $big[$i];
        if( isset($small[$i]) ){
            $resultado[] = $small[$i];
        }
    }

    return $resultado;
}

/**
 * Devuelve un array con los nombres de todos los paises
 * @return array
 */
function get_paises(){
    return array('Afganistán', 'Albania', 'Alemania', 'Andorra', 'Angola', 'Anguila', 'Antigua y Barbuda', 'Antillas Holandesas', 'Antártida', 'Arabia Saudita', 'Argelia', 'Argentina', 'Armenia', 'Aruba', 'Australia', 'Austria', 'Azerbayán', 'Bahamas', 'Bahréin', 'Bangladesh', 'Barbados', 'Belice', 'Benín', 'Bermudas', 'Bielorrusia', 'Bolivia', 'Bosnia-Herzegovina', 'Botsuana', 'Brasil', 'Brunéi', 'Bulgaria', 'Burkina Faso', 'Burundi', 'Bután', 'Bélgica', 'Cabo Verde', 'Camboya', 'Camerún', 'Canadá', 'Chad', 'Chile', 'China', 'Chipre', 'Ciudad del Vaticano', 'Colombia', 'Comoras', 'Congo', 'Corea del Norte', 'Corea del Sur', 'Costa Rica', 'Costa de Marfil', 'Croacia', 'Cuba', 'Dinamarca', 'Dominica', 'Ecuador', 'Egipto', 'El Salvador', 'Emiratos Árabes Unidos', 'Eritrea', 'Eslovaquia', 'Eslovenia', 'España', 'Estados Unidos', 'Estonia', 'Etiopía', 'Filipinas', 'Finlandia', 'Fiyi', 'Francia', 'Gabón', 'Gambia', 'Georgia', 'Ghana', 'Gibraltar', 'Granada', 'Grecia', 'Groenlandia', 'Guadalupe', 'Guam', 'Guatemala', 'Guayana Francesa', 'Guernsey', 'Guinea', 'Guinea Ecuatorial', 'Guinea-Bissau', 'Guyana', 'Haití', 'Honduras', 'Hungría', 'India', 'Indonesia', 'Iraq', 'Irlanda', 'Irán', 'Isla Bouvet', 'Isla Christmas', 'Isla Niue', 'Isla Norfolk', 'Isla de Man', 'Islandia', 'Islas Caimán', 'Islas Cocos', 'Islas Cook', 'Islas Feroe', 'Islas Georgia del Sur y Sandwich del Sur', 'Islas Heard y McDonald', 'Islas Malvinas', 'Islas Marianas del Norte', 'Islas Marshall', 'Islas Salomón', 'Islas Turcas y Caicos', 'Islas Vírgenes Británicas', 'Islas Vírgenes de los Estados Unidos', 'Islas menores alejadas de los Estados Unidos', 'Islas Åland', 'Israel', 'Italia', 'Jamaica', 'Japón', 'Jersey', 'Jordania', 'Kazajistán', 'Kenia', 'Kirguistán', 'Kiribati', 'Kuwait', 'Laos', 'Lesoto', 'Letonia', 'Liberia', 'Libia', 'Liechtenstein', 'Lituania', 'Luxemburgo', 'Líbano', 'Macedonia', 'Madagascar', 'Malasia', 'Malaui', 'Maldivas', 'Mali', 'Malta', 'Marruecos', 'Martinica', 'Mauricio', 'Mauritania', 'Mayotte', 'Micronesia', 'Moldavia', 'Mongolia', 'Montenegro', 'Montserrat', 'Mozambique', 'Myanmar', 'México', 'Mónaco', 'Namibia', 'Nauru', 'Nepal', 'Nicaragua', 'Nigeria', 'Noruega', 'Nueva Caledonia', 'Nueva Zelanda', 'Níger', 'Omán', 'Pakistán', 'Palau', 'Panamá', 'Papúa Nueva Guinea', 'Paraguay', 'Países Bajos', 'Perú', 'Pitcairn', 'Polinesia Francesa', 'Polonia', 'Portugal', 'Puerto Rico', 'Qatar', 'Región Administrativa Especial de Hong Kong de la República Popular China', 'Región Administrativa Especial de Macao de la República Popular China', 'Reino Unido', 'República Centroafricana', 'República Checa', 'República Democrática del Congo', 'República Dominicana', 'Reunión', 'Ruanda', 'Rumania', 'Rusia', 'Sahara Occidental', 'Samoa', 'Samoa Americana', 'San Bartolomé', 'San Cristóbal y Nieves', 'San Marino', 'San Martín', 'San Pedro y Miquelón', 'San Vicente y las Granadinas', 'Santa Elena', 'Santa Lucía', 'Santo Tomé y Príncipe', 'Senegal', 'Serbia', 'Serbia y Montenegro', 'Seychelles', 'Sierra Leona', 'Singapur', 'Siria', 'Somalia', 'Sri Lanka', 'Suazilandia', 'Sudáfrica', 'Sudán', 'Suecia', 'Suiza', 'Surinam', 'Svalbard y Jan Mayen', 'Tailandia', 'Taiwán', 'Tanzanía', 'Tayikistán', 'Territorio Británico del Océano Índico', 'Territorio Palestino', 'Territorios Australes Franceses', 'Timor Oriental', 'Togo', 'Tokelau', 'Tonga', 'Trinidad y Tobago', 'Turkmenistán', 'Turquía', 'Tuvalu', 'Túnez', 'Ucrania', 'Uganda', 'Uruguay', 'Uzbekistán', 'Vanuatu', 'Venezuela', 'Vietnam', 'Wallis y Futuna', 'Yemen', 'Yibuti', 'Zambia', 'Zimbabue');
}

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////// Clases
////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////// AJAX
// se instancia la clase ajax
$st_ajax = new ST_ajax();
class ST_ajax {
    /////// setea los actions para registrar ajax en wordpress
    function __construct(){
        add_action('wp_ajax_st_front_ajax', array( $this, 'set_ajax' ));
        add_action('wp_ajax_nopriv_st_front_ajax', array( $this, 'set_ajax' ));
    }

    // se asgura de que exista un metodo en esta clase, si no existe entonces die()
    function set_ajax(){
        if( isset($_REQUEST['funcion']) && $_REQUEST['funcion'] && method_exists($this, $_REQUEST['funcion']) ){
            $this->{$_REQUEST['funcion']}( $_REQUEST );
        }
        else {
            die('Not Allowed >:(');
        }
    }

    function getFilteredAgenda( $data ){
        $sede_term = intval($data['sede']);

        $agenda_query = new WP_Query(array(
            'post_type' => 'agenda',
            'meta_key' => 'fecha',
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
            'nopaging' => true,
            'tax_query' => array(
                array(
                    'taxonomy' => 'sede',
                    'field'    => 'term_id',
                    'terms'    => $sede_term
                )
            ),
            'meta_query' => array(
                array(
                    'key'     => 'fecha',
                    'value'   => date('Ymd'),
                    'compare' => '>=',
                )
            )
        ));

        // devolvemos HTML parseado
        if( $agenda_query->have_posts() ){
            $html = '<option value="">Seleccione un taller o actividad</option>';
            while( $agenda_query->have_posts() ){
                $agenda_query->the_post();
                $html .= '<option value="'. $agenda_query->post->ID .'">'. get_the_title($agenda_query->post->ID) .'</option>';
            }
        }
        else {
            $html = '<option value="">No hay actividades en esta sede y categoría</option>';
        }


        die(json_encode(array(
            'status' => 'ok',
            'html' => $html
        )));
    }

    ///// devuelve la galeria completa en un single galeria
    function deploy_full_gallery( $data ){
        die( generate_regular_gallery_slider( $data['pid'] ) );
    }

    function get_cursos_by_sede( $data ){
        // los niveles de cursos se extraen de
        // un campo flexible
        // son paginas hijas de "Cursos"
        $cursos_page = get_post_by_slug( 'cursos' );
        $proto_niveles = get_pages(array(
            'parent' => $cursos_page->ID,
            'sort_order' => 'asc',
            'sort_column' => 'menu_order'
        ));

        $niveles = array();

        // se itera por cada nivel
        foreach( $proto_niveles as $proto ){
            $field = get_field('cursos', $proto->ID);

            // si no tiene el campo 'cursos' entonces no es un nivel
            if( empty($field) ){ continue; }

            $cursos = array();

            // se itera por cada curso en cada nivel
            foreach( $field as $course ){
                // si no tiene sedes asociadas o
                // no esta dentro de la sede seleccionada
                if( empty($course['sedes_asociadas']) ) continue;

                if( in_array( $data['sede'], $course['sedes_asociadas']) ){
                    $cursos[] = $course;
                }
            }

            // si no hay cursos pasa de largo
            if( empty($cursos) ) continue;


            $niveles[] = array(
                'nivel' => $proto,
                'cursos' => $cursos
            );
        }

        // si no hay ningun nivel con cursos se informa a través de un option
        if( empty($niveles) ){
            $options = '<option value="">No hay cursos en esta sede</option>';
        }
        else {
            // para este momento $niveles contiene todos los niveles y sus posibles cursos
            // en base a la seleccion de sede

            // se genera el html de los options
            $options = '<option value="">Seleccione un nivel</option>';
            foreach( $niveles as $n ){

                $options .= '<optgroup label="'. $n['nivel']->post_title .'">';

                foreach( $n['cursos'] as $cursos ){
                    $options .= '<option value="'. $n['nivel']->post_title .' - '. $cursos['titulo'] .'">'. $cursos['titulo'] .'</option>';
                }

                $options .= '</optgroup>';
            }
        }

        die(json_encode(array(
            'html' => $options
        )));
    }
}

//Custom mime
//Archivos SVG
add_filter( 'upload_mimes', 'custom_upload_mimes' );
function custom_upload_mimes( $existing_mimes = array() ) {
// Add the file extension to the array
    $existing_mimes['svg'] = 'image/svg+xml';
    return $existing_mimes;
}