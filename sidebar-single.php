<nav id="page-navigation" class="page-navigation" data-mutable="vertical-tablet-down" data-mobile-area="mobile-page-nav" data-desktop-area="desktop-page-nav" data-order="1" >
    <?php
	    if( $post->post_type === 'festividad' ){
	        $parent_id = get_post_by_slug('conociendo-china', 'ID');
	        $current_id = get_post_by_slug('china-milenaria', 'ID');
	    }
	    else {
	    	$parent_id = get_post_by_slug('instituto-confucio', 'ID');
	    	$current_id = get_post_by_slug('historias-para-contar', 'ID');
	    }

    	echo get_page_navigation( $parent_id, $current_id ); 
    ?>
</nav>