<div id="page-navigation" class="course-nav-parent" data-mutable="vertical-tablet-down" data-mobile-area="mobile-page-nav" data-desktop-area="desktop-page-nav" data-order="1">
    <nav class="course-nav">
        <h3 class="course-nav-title bg-neutral pattern">Cursos</h3>
        <div class="access">
            <?php
                $courses_nav = get_field('navegacion_cursos', $post->post_parent);
                foreach( $courses_nav as $curso_id ) :
                    $title = get_the_title( $curso_id );
                    $lower_title = strtolower($title);
                    switch ( $lower_title ) {
                        case 'nivel básico' :
                            $type_class = 'corporativo';
                            break;

                        case 'nivel intermedio':
                            $type_class = 'complementario';
                            break;

                        case 'nivel avanzado':
                            $type_class = 'primario';
                            break;
                        
                        default:
                            $type_class = 'neutralalt';
                            break;
                    }
                    $current = is_page( $curso_id ) ? 'current' : '';
                    $class = $type_class .' '. $current;
            ?>
            <a class="course-nav-item <?php echo $class ?>" href="<?php echo get_permalink($curso_id); ?>" title="Ver <?php echo get_the_title($curso_id); ?>" rel="section"><?php echo get_the_title($curso_id); ?></a>
            <?php endforeach; ?>
        </div>
    </nav>
    <nav class="page-navigation" >
        <?php
            $info_nav = get_field('navegacion_informacion', $post->post_parent);
            foreach( $info_nav as $item_id ) :
                $current = is_page($item_id) ? 'current' : '';
        ?>
            <a class="<?php echo $current; ?>" href="<?php echo get_permalink($item_id); ?>" title="Ir a <?php echo get_the_title($item_id); ?>" rel="section"><?php echo get_the_title($item_id); ?></a>
        <?php endforeach; ?>
    </nav>
</div>