<nav id="page-navigation" class="page-navigation" data-mutable="vertical-tablet-down" data-mobile-area="mobile-page-nav" data-desktop-area="desktop-page-nav" data-order="1" >
    <?php 
    	$ancestor_id = get_super_parent( $post );
    	echo get_page_navigation( $ancestor_id ); 

    	// boton de inscripcion cuando se encuentre en el template de talleres
    	if( is_page_template('taller.php') ){
    		$inscripcion_id = get_child_by_slug( $ancestor_id, 'pre-inscripcion' );
    		echo '<a class="button secundario full-vertical-tablet-down only-on-vertical-tablet-down" href="'. get_permalink($ancestor_id) .'" title="Ir a formulario de inscripción">Formulario de inscripción</a>';
    	}
    ?>
</nav>