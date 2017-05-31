<?php
    get_header();
    the_post();
?>

<main id="main-content" class="main-content" role="main">
    <div class="container">
        <?php echo generate_breadcrumbs(); ?>
        <div class="page-header">
            <h1 class="section-title big icon hide-on-vertical-tablet-down">
                <span class="bg-neutral">Galerías</span>
            </h1>
            <div class="parent" data-equalize="children" data-mq="tablet-down">
                <div class="grid-7 grid-tablet-12 no-gutter" data-area-name="page-header-intro-text">
                    <div class="page-header-intro bg-neutralalt pattern" data-mutable="tablet-down" data-mobile-area="page-header-intro-img" data-desktop-area="page-header-intro-text">
                        <p><?php the_title(); ?></p>
                    </div>
                </div>
                <div class="grid-5 grid-tablet-12 no-gutter" data-area-name="page-header-intro-img">
                    <?php
                        the_post_thumbnail('regular-big', array(
                            'class' => 'elastic-img cover',
                            'data-mutable' => 'tablet-down',
                            'data-mobile-area' => 'page-header-intro-text',
                            'data-desktop-area' => 'page-header-intro-img',
                            'data-order' => '1'
                        ));
                    ?>
                </div>
            </div>      
        </div>
    </div>
    <div class="container">
        <div class="regular-content-area-holder">
            <?php
                echo generate_article_actions_box( $post );
                
                if( $descripcion = get_field('descripcion') ){
                    echo '<div class="regular-featured-text">';
                    echo apply_filters('the_content', $descripcion);
                    echo '</div>';
                }
                ?>

            <div class="parent">
                <?php
                /// se genera la previsualizacion de las fotos
                $imagenes = get_field('fotos');
                if( $imagenes ){
                    $i = 0;
                    foreach( $imagenes as $imagen ){
                        echo '<div class="gallery-item-box grid-3 grid-tablet-4 grid-smalltablet-6 grid-mobile-4">';
                        echo    '<figure class="gallery-image-box" data-gallery-id="'. $post->ID .'" data-target-index="'. $i .'">';
                        echo        wp_get_attachment_image($imagen['imagen'], 'gallery-module');
                        echo        '<figcaption>';
                        echo            '<button class="gallery-image-button" title="Ver detalle" data-func="deployFullGallery">';
                        echo                '<span>Ver detalle</span>';
                        echo            '</button>';
                        echo        '</figcaption> ';
                        echo    '</figure>';
                        echo '</div>';

                        $i++;
                    }
                }
                ?>
            </div>
            
            <?php
                echo generate_article_actions_box( $post );
            ?>

                <section class="regular-content-box inversed content-section">
                    <div class="regular-content-box-header galerias">
                        <h2 class="regular-content-box-title ">Galerías relacionadas</h2>
                    </div>

                    <div class="regular-content-box-body parent">
                        <?php
                            $tax_query = null;
                            $categories = wp_get_post_terms( $post->ID, 'categorias_galerias', array( 'fields' => 'ids' ));
                            if( !empty($categories) ){ 
                                $tax_query = array(
                                    array(
                                        'taxonomy' => 'categorias_galerias',
                                        'field' => 'id',
                                        'terms' => $categories
                                    )
                                );
                            }

                            $related_query = new WP_Query(array(
                                'post_type' => 'galeria',
                                'posts_per_page' => 4,
                                'tax_query' => $tax_query,
                                'post__not_in' => array( $post->ID )
                            ));

                            if( $related_query->have_posts() ){
                                while( $related_query->have_posts() ){
                                    $related_query->the_post();
                                    echo '<div class="gallery-item-box grid-3 grid-tablet-4 grid-smalltablet-6 grid-mobile-4">';
                                    echo  generate_gallery_module( $related_query->post );
                                    echo '</div>';
                                }
                            }
                            wp_reset_query();
                        ?>
                    </div>
                </section>

        </div>
    </div>

</main>

<?php get_footer(); ?>