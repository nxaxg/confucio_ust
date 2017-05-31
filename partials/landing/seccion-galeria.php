<?php

$galeria = get_field('galeria_imagenes');
if( !empty($galeria) ) :
    
    needs_script('landingSlider');

    $images = '';
    $bullets = '';
    $counter = 0;
    foreach( $galeria as $item ){
        $img_id = $item['imagen'];

        $active = '';
        if( $counter === 0 ){ $active = 'active'; }

        $images .= '<figure class="landing-slider-item '. $active .'" data-role="landing-slider-item" data-slide="'. $counter .'">';
        $images .= wp_get_attachment_image($img_id, 'gallery-item', false, array('class' => 'full-elastic-img' ));
        $images .= '</figure>';


        $bullets .= '<button class="landing-slider-bullet '. $active .'" data-role="landing-slider-bullet" data-target="'. $counter .'"></button>';

        $counter++;
    }

?>
    <section id="galeria" class="landing-full-section">
        <div class="landing-slider" data-role="landing-slider">
            <div class="landing-slider-body" >
                <div class="landing-slider-items" data-role="landing-slider-list">
                    <?php echo $images; ?>
                </div>

                <div class="landing-slider-controls">
                    <button class="landing-slider-btn prev" data-role="landing-slider-btn" data-direction="prev" ></button>
                    <button class="landing-slider-btn next" data-role="landing-slider-btn" data-direction="next" ></button>
                </div>
            </div>
            
            <div class="landing-slider-bullets">
                <?php echo $bullets; ?>
            </div>
        </div>
    </section>

<?php endif; ?>