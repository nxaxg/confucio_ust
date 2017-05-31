<div class="parent" data-equalize="children" data-mq="tablet-down">
    <?php if( has_post_thumbnail() ) : ?>
        <div class="grid-7 grid-tablet-12 no-gutter" data-area-name="page-header-intro-text" >
            <div class="page-header-intro bg-neutralalt pattern" data-mutable="tablet-down" data-mobile-area="page-header-intro-img" data-desktop-area="page-header-intro-text" data-order="1">
                <?php echo apply_filters('the_content', get_field('texto_intro') ); ?>
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
    <?php else : ?>
        <div class="page-header-intro bg-neutralalt pattern">
            <?php echo apply_filters('the_content', get_field('texto_intro') ); ?>
        </div>
    <?php endif; ?>
</div>