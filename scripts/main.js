(function(window, document, $){
    "use strict";

    var DEBUG = true;

    var $window = $(window),
        $document = $(document),
        $body;

    /// guardo los media queries
    var TABLETS_DOWN = 'screen and (max-width: 1024px)',
        VERTICAL_TABLETS_DOWN = 'screen and (max-width: 768px)',
        PHABLETS_DOWN = 'screen and (max-width: 640px)';

    var throttle = function( fn ){
        return setTimeout(fn, 1);
    };

    var App = function(){
        this.path = document.body.getAttribute('data-path');
        this.ajaxURL = '/wp-admin/admin-ajax.php';
        this.loadLegacyAssets();
        
        var app = this;
    };

    App.prototype = {
        onReady : function(){
            this.setGlobals();
            this.autoHandleEvents( $('[data-func]') );
            this.handleMobileTables();
            this.conditionalInits();
            this.handleForms();
            throttle(this.setFixedHeader);

            $('a, button, input[type="submit"]').on('touchstart', $.noop);
        },
        
        onLoad : function(){
            $('[data-equalize="children"][data-mq="tablet-down"]').equalizeChildrenHeights(true, TABLETS_DOWN);
            $('[data-equalize="children"][data-mq="vertical-tablet-down"]').equalizeChildrenHeights(true, VERTICAL_TABLETS_DOWN);
            $('[data-equalize="target"][data-mq="vertical-tablet-down"]').equalizeTarget(true, VERTICAL_TABLETS_DOWN);
            $('[data-equalize="target"][data-mq="phablet-down"]').equalizeTarget(true, PHABLETS_DOWN);
        },

        onResize : function(){
            throttle(this.setFixedHeader);
        },
        
        loadLegacyAssets : function(){
            // voy a asumir que cualquier browser que no soporte <canvas> es un oldIE (IE8-)
            if( Modernizr.canvas ){ return false; }

            Modernizr.load({
                load : this.path + 'scripts/support/selectivizr.min.js'
            });
        },
        
        autoHandleEvents : function( $elements ){
            if( !$elements || !$elements.length ){ return false; }

            var self = this;

            $elements.each(function(i,el){
                var func = el.getAttribute('data-func') || false,
                    evts = el.getAttribute('data-events') || 'click.customStuff';

                if( func && typeof( self[func] ) === 'function' ){
                    $(el)
                        .off(evts)
                        .on(evts, $.proxy(self[func], self))
                        .attr('data-delegated', 'true');
                }
            });
        },

        setEnquire : function(){
            var app = this,
                $mutable = $('[data-mutable]');

            enquire.register( TABLETS_DOWN, [{
                match: function(){
                    app.moveElements($mutable.filter('[data-mutable="tablet-down"]'), 'mobile');

                    /// tablas de contenido cambian a un scroll desde tablets en adelante
                    $('.page-content table').wrap('<div class="regular-content-table-holder"></div>');
                },
                unmatch: function(){
                    app.moveElements($mutable.filter('[data-mutable="tablet-down"]'), 'desktop');

                    /// tablas de contenido vuelven a su estado natural
                    $('.page-content table').unwrap();
                }
            }]);

            enquire.register( VERTICAL_TABLETS_DOWN, [{
                match: function(){
                    app.moveElements($mutable.filter('[data-mutable="vertical-tablet-down"]'), 'mobile');
                },
                unmatch: function(){
                    app.moveElements($mutable.filter('[data-mutable="vertical-tablet-down"]'), 'desktop');

                    // en caso de que el menu este desplegado cuando se hace un resize
                    $('[data-func="deployMainNav"]').removeClass('deployed');
                    $('#main-nav').removeClass('deployed').removeAttr('style');
                }
            }]);
        },

        conditionalInits : function(){
            // modulo de sliders en singles
            if( $('[data-role="single-slider-module"]').length ){
                this.singleSlider( $('[data-role="single-slider-module"]') );
            }

            if( $('[data-role="landing-carousel"]').length ){
                this.landingCarousel( $('[data-role="landing-carousel"]') );
            }

            if( $('[data-role="landing-slider"]').length ){
                this.landingSlider( $('[data-role="landing-slider"]') );
            }

            // // modulo  mosaicos en home
            if( $('[data-role="mosaic3d"]').length ){
                this.mosaic3d( $('[data-role="mosaic3d"]') );
            }

            /// para los single que tengan contadores de shares
            if( $('[data-role="share-counter"]').length ){
                this.getShareCount( $('[data-role="share-counter"]') );
            }

            /// todos los inpiut type file se estilizan
            if( $('input[type="file"]').length ){
                $('input[type="file"]').beautify();
            }

            // mapas de google
            if( typeof google !== 'undefined' && $('[data-googlemap]').length ){
                this.handleMaps( $('[data-googlemap]') );
            }

            /// cuando se encuentra touch el menu actua diferente
            if( Modernizr.touch ){
                $('.main-nav-items').on('click', '.menu-item-has-children > a', function( event ){
                    event.stopPropagation();

                    var $li = $(event.currentTarget).parent();

                    if( $li.hasClass ('deployed') ){
                        return true;
                    }

                    event.preventDefault();

                    $li.siblings().removeClass('deployed');
                    $li.addClass('deployed');
                });

                $document.on('click', function(){
                    $('.main-nav-items .menu-item-has-children').removeClass('deployed');
                });
            }

            /// Se activa cuando hay un hash y me encuentro en las plantillas de single curso.
            if( $body.hasClass('page-template-curso') && window.location.hash){
                // activamos de inmediato el tab correspondiente
                var tab_hash = window.location.hash.substr(1);
                $('[data-func="tabControl"][data-target="'+ tab_hash +'"]').trigger('click');
            }

            // si no reconoces matchmedia no mereces enquire
            if( window.matchMedia ){
                app.setEnquire();
            }
        },

        setGlobals : function(){
            $body = $('body');
        },

        ///////////////////////////////////////////////////////////
        /////////////////////////////// Auxiliares
        ///////////////////////////////////////////////////////////
        debug : function( message ){
            DEBUG && console.log( message );
        },

        moveElements : function( $set, type ){
            var areaType = 'data-' + type +'-area',
                groups = $set.groupByAtt( areaType );

            groups.forEach(function( $group ){
                var $target = $('[data-area-name="'+ $group.first().attr( areaType ) +'"]');

                $group.sort(function(a, b){
                    return $(a).data('order') - $(b).data('order');
                });

                $group.appendTo( $target );
            });
        },

        setFixedHeader : function(){
            if( Modernizr.mq(VERTICAL_TABLETS_DOWN) ){
                var headerHeight = document.querySelector('#main-header').offsetHeight;
                document.body.style.marginTop = headerHeight + 14 + 'px';
            }
            else {
                document.body.style.marginTop = 0;
            }
        },

        blockScroll : function( event ){
            event.stopPropagation();
        },


        ///////////////////////////////////////////////////////////
        /////////////////////////////// Generales
        ///////////////////////////////////////////////////////////
        handleForms : function(){
            var app = this;

            // validacion generica: campos comunes y envio sincronico
            $('[data-validation="generic"]').validizr();

            // validacion de los formularios de inscripcion (complejos)
            $('[data-validation="complex"]').validizr({
                customValidation : {
                    // valida los ruts
                    validateRut : function( $input ) {
                        var value = $input.val(),
                            validity = $.Rut.validar( value );

                        if( validity ){
                            $input.val( $.Rut.formatear( value, true ) );
                        }
                        return validity;
                    },

                    // valida los campos que deben ser iguales en base al "master"
                    // se usa en los campos tipo email/confirmar-email
                    mustMatch : function( $input, validizr ){
                        var value = $input.val();

                        $('[data-error="mustMatch"]').remove();

                        if( $input.data('match-type') === 'master' ){
                            return !!value && validizr.emailRegEx.test(value);
                        }

                        var masterVal = $('[data-match-type="master"]').val(),
                            slaveValidity = (!!value && validizr.emailRegEx.test(value)) && value === masterVal;

                        if( !slaveValidity ){
                            var message = '<p class="regular-form-error" data-error="mustMatch" >Los mails ingresados no coindicen.</p>';

                            $('[data-match-type="master"]').addClass('invalid-input').after( message );
                            $input.after( message );
                        }

                        return slaveValidity;
                    },

                    // valida los elementos que deben cargar eventos de agenda en
                    // el formulario de inscripcion a talleres o actividades
                    eventsLoad : function( $input, validizr, event ){
                        var $place = $('[data-role="events-place"]'),
                            $events = $('[data-role="events-holder"]'),
                            currentVal = $input.val();

                        // en el caso de que se este validando todo el formulario
                        // no se hace nada para no gatillar una carga nueva de ajax
                        // que dejaria al campo invalido nuevamente
                        if( event.type === 'validate' ){
                            return !!currentVal;
                        }

                        // en caso de que el usuario no eliga ninguna sede
                        // se le indica a traves del select de eventos
                        if( !currentVal ){ 
                            $events.removeClass('valid-input').addClass('invalid-input');
                            $events.html('<option value="">Debe seleccionar una sede</option>');
                            return false; 
                        }

                        // se hace un ajax con para ir a buscar los
                        // eventos filtrados por las opciones seleccionadas
                        $events.removeClass('valid-input').addClass('loading').html('<option value="">Cargando eventos</option>');

                        $.getJSON(app.ajaxURL, {
                            action : 'st_front_ajax',
                            funcion : 'getFilteredAgenda',
                            sede : $place.val()
                        }).done(function(response){
                            $events.html( response.html ).removeClass('loading');
                        });

                        return true;
                    },

                    // Valida los checkbox en donde al menos uno del grupo
                    // debe estar seleccionado
                    oneOfUs : function( $input ){
                        var $group = $('[data-input-group="'+ $input.data('input-group') +'"]');
                        var valid = !!$group.filter(':checked').length;

                        $input.parents('.inline-options-box').find('.regular-form-error').remove();

                        if( !valid ){
                            $input.parents('.inline-options-box').append('<p class="regular-form-error" >Debe seleccionar al menos una opción</p>');
                        }

                        return valid;
                    }
                },

                // se dispara cuando se intenta enviar el formulario
                // y es invalido
                notValidFormCallback : function( $form ){
                    var $firstInvalid = $form.find('.invalid-input:not([type="file"])').first();

                    $form.find('[data-role="required-helper"]').removeClass('regular-form-helper').addClass('regular-form-error');

                    if( $firstInvalid.length ){
                        $('html, body').animate({
                            scrollTop : $firstInvalid.offset().top - 50
                        },800).promise().then(function(){
                            $firstInvalid.focus();
                        });
                    }
                }
            });
        },

        handleMobileTables : function(){
            $('.regular-content-area table').each(function(i, table){
                $(table).wrap('<div class="regular-content-table-holder"></div>');
            });
        },

        setLightBox : function( classes ){
            /// se crean los elementos
            var $bg = $('<div />').attr({ id : 'lightbox-background', class : 'lightbox-background' }),
                $scrollable = $('<div />').attr({ class : 'lightbox-scrollable-holder' }),
                $holder = $('<div />').attr({ class : 'lighbox-holder' }).append('<div class="lightbox-close-holder"></div>'),
                $content = $('<div />').attr({ class : 'lightbox-content' }),
                $closeBtn = $('<button class="primary-btn small-btn icon-btn--close-lb" >Cerrar</button>');

            // se inicia la promesa
            var promise = new $.Deferred();

            if( classes ){
                $holder.addClass( classes );
            }

            $closeBtn.on('click', this.closeLightBox);
            $window.on('keyup.lightbox', this.closeLightBox);
            
            $holder.appendTo( $scrollable ).find('.lightbox-close-holder').append( $closeBtn );

            $body.append( $bg );

            $bg.animate({ opacity : 1 }).promise().then(function(){
                $body.css('overflow', 'hidden');
                $bg.append( $scrollable );
                $holder.append( $content );
                promise.resolve( $bg, $content );
            });

            return promise;
        },

        closeLightBox : function( e ){
            if( e.type === 'click' || (e.type === 'keyup' && e.keyCode == 27) ){
                $('#lightbox-background').remove();
                $body.css('overflow', 'auto');
                $window.off('keyup.lightbox keyup.singleSlider');
            }
        },

        ///////////////////////////////////////////////////////////
        /////////////////////////////// Modulos
        ///////////////////////////////////////////////////////////
        singleSlider : function( $elements ){
            /// primero revisamos la dependencia en ninjaSlider
            if( typeof window.NinjaSlider === 'undefined' || typeof $.fn.owlCarousel === 'undefined' ){
                this.debug('Falta ninjaSlider');
                this.debug('Falta owlCarousel');
                return false;
            }

            var app = this;

            $elements.each(function(i, module){
                var $module = $(module),
                    $slider = $module.find('[data-role="slider"]'),
                    $arrows = $module.find('[data-role="single-slider-arrow"]'),
                    $thumbnailsHolder = $module.find('[data-role="thumbnails-holder"]'),
                    $thumbnailArrows = $module.find('[data-role="single-slider-thumbnail-arrow"]'),
                    $thumbnails = $module.find('[data-role="single-slider-thumbnail"]'),
                    slider, carousel; 


                // se inicializa el carousel de los thumbnails-holder
                carousel = $thumbnailsHolder.owlCarousel({ 
                    items : 6,
                    itemsDesktop : [1199,4],
                    itemsDesktopSmall : [980,4],
                    itemsTablet: [768,3],
                    itemsMobile : [320,2],
                }).data('owlCarousel');

                // se inicializa el slider principal
                slider = $slider.ninjaSlider({
                    auto : false,
                    transitionCallback : function(index, activeSlide, container){
                        var $slide = $(activeSlide);
                        $slide.siblings().removeClass('active');
                        $slide.addClass('active');

                        $thumbnails.removeClass('active').filter('[data-target="'+ index +'"]').addClass('active');
                        carousel.goTo( index );
                    }
                }).data('ninjaSlider');

                // se delegan las flechas principales
                $arrows.on('click.singleSlider', function(e){
                    // this es el boton 
                    e.preventDefault();

                    var direction = this.getAttribute('data-direction');
                    slider[ direction ]();
                });

                // se delegan los thumbnails para que actuen sobre el slider principal
                $thumbnails.on('click.singleSlider', function(e){
                    // this es el boton 
                    e.preventDefault();

                    var target = parseInt( this.getAttribute('data-target') );
                    slider.slide( target );
                });

                // se deben setear controles de los thumbnails
                $thumbnailArrows.on('click.singleSlider', function(e){
                    // this es el boton 
                    e.preventDefault();

                    var direction = this.getAttribute('data-direction');
                    carousel[ direction ]();
                });

                // solo se deben delegar las teclas si hay un solo slider
                if( $elements.length === 1 ){
                    $window.on('keyup.singleSlider', function( e ){
                        if( e.keyCode == 39 ){ slider.next(); }
                        else if( e.keyCode == 37 ){ slider.prev(); }
                    });
                }
            });
        },

        landingCarousel : function( $elements ){
            $elements.each(function(i, box){
                var $carouselHolder = $(box),
                    $carousel = $carouselHolder.find('[data-role="landing-carousel-items"]'),
                    $btns = $carouselHolder.find('[data-role="landing-carousel-btn"]'),
                    carousel;

                // se inicializa el carousel de los thumbnails-holder
                carousel = $carousel.owlCarousel({ 
                    items : 8,
                    itemsDesktop : [1199,8],
                    itemsDesktopSmall : [980,8],
                    itemsTablet: [768,4],
                    itemsMobile : [320,1.5],
                }).data('owlCarousel');

                $btns.on('click.landingCarousel', function( e ){
                    e.preventDefault();
                    var direction = this.getAttribute('data-direction');
                    carousel[ direction ]();
                });
            });
        },

        landingSlider : function( $slider ){
            $slider.landingSlider();
        },

        getShareCount : function( $elements ){
            $elements.each(function(index, element){
                var type = element.getAttribute('data-type'),
                    url = element.getAttribute('data-url') || window.location.href,
                    jsonUrl = '',
                    data = {};

                var params = {
                    nolog: true,
                    id: url,
                    source: "widget",
                    userId: "@viewer",
                    groupId: "@self"
                };

                if( type === 'facebook' ){
                    jsonUrl = 'http://graph.facebook.com/';
                    data.id = url;
                }
                else if( type === 'twitter' ){
                    // Url obsoleta.
                    //jsonUrl = 'http://urls.api.twitter.com/1/urls/count.json';
                    //data.url = url;
                    return;
                }
                else if( type === 'linkedin' ){
                    jsonUrl = 'http://www.linkedin.com/countserv/count/share';
                    data.url = url;
                }

                $.ajax({
                    method : 'GET',
                    url : jsonUrl,
                    data : data,
                    dataType : 'jsonp'
                }).then(function( response ){
                    var count = '';

                    // se saca el valor de cada red segun lo que responda el API correspondiente
                    if( type === 'facebook' ){ count = response.shares; }
                    else if( type === 'twitter' ){ count = response.count; }
                    else if( type === 'linkedin' ){ count = response.count; }

                    // prevencion de error en caso de false o undefined
                    count = count ? count : 0;
                    element.textContent = count;
                });
            });
        },

        handleMaps : function( $boxes ){
            $boxes.ninjaMap();
        },

        deployFullGallery : function( event ){
            event.preventDefault();

            var app = this,
                $item = $(event.currentTarget),
                lightbox_promise = this.setLightBox('gallery-detail'),
                ajax_promise = $.get(this.ajaxURL, {
                    action : 'st_front_ajax',
                    funcion : 'deploy_full_gallery',
                    pid : $item.parents('.gallery-image-box').data('gallery-id')
                });

            $.when(lightbox_promise, ajax_promise).then(function( lightbox_info, ajax_response ){
                var $lightbox_bg = lightbox_info[0],
                    $lightbox_content = lightbox_info[1],
                    response = ajax_response[0];

                $lightbox_content.append( response );

                if( $('[data-role="single-slider-module"]').length ){
                    app.singleSlider( $lightbox_content.find('[data-role="single-slider-module"]') );
                    var slider = $lightbox_content.find('[data-role="slider"]').data('ninjaSlider');

                    // se mueve el slider al elemento que se clickeo
                    slider.slide( $item.parents('.gallery-image-box').data('target-index') );
                }

                throttle(function(){
                    $lightbox_bg.addClass('loaded');
                });


            }).fail(function(){
                app.debug('fallo algo en el ajax');
                app.closeLightBox();
            });
        },
        
        mosaic3d : function( $container ){
            var $items = $container.find('.mosaic-item');
            setInterval(function(){
                $items.removeClass('mosaic-deployed');
                $items.random().addClass('mosaic-deployed');
                $items.not('.mosaic-deployed').random().addClass('mosaic-deployed');
            }, 2000);
        },

        ///////////////////////////////////////////////////////////
        /////////////////////////////// Delegaciones directas
        ///////////////////////////////////////////////////////////
        toggleTarget : function( event ){
            event.preventDefault();

            $( event.currentTarget.getAttribute('data-target') ).toggleClass('deployed');

            // expansion para cuando quiero enfocar algo despues de mostrarlo
            if( event.currentTarget.getAttribute('data-focus') ){
                $( event.currentTarget.getAttribute('data-focus') ).focus();
            }
        },

        tabControl : function( event ){
            event.preventDefault();

            var $button = $(event.currentTarget),
                $target = $('[data-tab-name="'+ $button.data('target') +'"]');

            $button.siblings().removeClass('active');
            $target.siblings().removeClass('active');

            throttle(function(){
                $button.addClass('active');
                $target.addClass('active');
            });
        },

        deployParent : function( event ){
            event.preventDefault();
            $(event.currentTarget).parents( event.currentTarget.getAttribute('data-parent') ).toggleClass('deployed');
        },

        deployMainNav : function( event ){
            event.preventDefault();

            var $button = $(event.currentTarget),
                $mainNav = $('#main-nav');

            if( $button.is('.deployed') ){
                $button.removeClass('deployed');
                $mainNav.removeClass('deployed').css({
                    'max-height' : 0
                });

                $('#main-header').off('touchmove', this.blockScroll);

                document.body.style.overflow = 'auto';
                document.body.style.pointerEvents = 'auto';
            }
            else {
                $button.addClass('deployed');

                // la navegacion no deberia ser mas grande que la pantalla ofreciendo un scroll
                var windowHeight = $window.height();
                var headerHeight = $('#main-header').height();
                
                $('#main-header').css({
                    'pointer-events' : 'auto'
                }).on('touchmove', this.blockScroll);
                
                $mainNav.css({
                    'max-height' : windowHeight - headerHeight,
                    'pointer-events' : 'auto'
                });

                /// ponemos la clase una vez que se termina la transicion css
                $mainNav.one('webkitTransitionend transitionend', function(){
                    $mainNav.addClass('deployed');
                    document.body.style.overflow = 'hidden';
                    document.body.style.pointerEvents = 'none';
                });
            }
        },

        deployMobileSearch : function( event ){
            event.preventDefault();

            var $button = $(event.currentTarget),
                $searchBox = $('#mobile-search-holder');

            $button.toggleClass('deployed');
            $searchBox.toggleClass('deployed');
        },

        showShortUrl : function( event ){
            event.preventDefault();
            event.stopPropagation();

            var self = this,
                $item = $(event.currentTarget),
                shortUrl = $item.data('link') || $('link[rel="shortlink"]').attr('href') || window.location.href,
                urlInput = $('<input class="tooltip-data-input" type="text" name="short-url" value="'+ shortUrl +'" readonly>').get(0),
                $tooltip = $('<div />').attr({
                    'id' : 'short-url-tooltip-object',
                    'class' : 'regular-tooltip short-url'
                }).append( urlInput ),
                position = $item.offset(),
                unloadFunc = function( e ){
                    $('#short-url-tooltip-object').remove();
                    $(this).off('click.tooltip');
                };


            // primero se saca cualquiera que actualmente se este mostrando
            $('#short-url-tooltip-object').remove();

            // se setean las propiedades y se adjunta al body
            $tooltip.appendTo('body').css({
                'position' : 'absolute',
                'top' : position.top - $tooltip.outerHeight() - 20,
                'left' : position.left - $tooltip.outerWidth() + $item.outerWidth(),
                'opacity' : 1
            }).on('click', function(e){
                e.stopPropagation();
            });

            urlInput.setSelectionRange(0, urlInput.value.length);

            $('body').on('click.tooltip', unloadFunc);
        },

        printPage : function( event ){
            event.preventDefault();
            window.print();
        },

        sendPostByEmail : function( event ){
            event.preventDefault();

            var app = this,
                lightbox_promise = this.setLightBox('expert-contact'),
                ajax_promise = $.get(this.ajaxURL, {
                    action : 'st_front_ajax',
                    funcion : 'show_send_by_email_form',
                    pid : $(event.currentTarget).data('pid')
                });

            $.when(lightbox_promise, ajax_promise).then(function( lightbox_info, ajax_response ){
                var $lightbox_bg = lightbox_info[0],
                    $lightbox_content = lightbox_info[1],
                    response = ajax_response[0];

                $lightbox_content.append( response );

                $lightbox_content.find('[data-validation="basic"]').validizr({
                    delegate_keyup : false,
                    notValidInputCallback : app.genericInvalidInputAction,
                    validFormCallback : function( $form ){
                        var form_data = 'action=st_front_ajax&funcion=send_post_by_email&' + $form.serialize();

                        $form.css({
                            'opacity' : '.2',
                            'pointer-events' : 'none'
                        });

                        $.ajax({
                            method : 'post',
                            url : app.ajaxURL,
                            dataType : 'json',
                            data : form_data
                        }).done(function( response ){
                            $form.html( response.feedback ).css({
                                'opacity' : '1',
                                'pointer-events' : 'auto'
                            });
                            app.isSending = false;
                        });
                    }
                });

                throttle(function(){
                    $lightbox_bg.addClass('loaded');
                });
            });
        },

        expandFootNote : function( event ){
            event.preventDefault();
            $( event.currentTarget ).toggleClass('expanded');
        },

        inputControl : function( event ){
            var $item = $(event.currentTarget);

            if( ($item.is('[type="radio"]') && $item.is(':checked')) || $item.is('select') ){
                $('[data-role="'+ $item.data('group') +'"]')
                    .removeClass('active')
                    .find('input, select, textarea')
                    .removeAttr('required');

                $('[data-role="'+ $item.data('group') +'"][data-name="'+ $item.val() +'"]')
                    .addClass('active')
                    .find('input, select, textarea')
                    .attr('required', true);
            }
        },

        goToTop : function( event ){
            event.preventDefault();
            $('html, body').animate({scrollTop : 0},800);
        },

        loadCursos : function( event ){
            var $element = $(event.currentTarget),
                $target = $( $element.data('target') );

            // se informa la carga de datos
            $target.addClass('loading').html('<option value="">Cargando cursos</option>');

            $.getJSON( this.ajaxURL, {
                action : 'st_front_ajax',
                funcion : 'get_cursos_by_sede',
                sede : $element.val()
            }).then(function(response){
                // console.log(response);
                $target.removeClass('loading').html(response.html);
            });
        }
    };

    var app = new App();

    $document.ready(function(){ app.onReady && app.onReady(); });

    $window.on({
        'load' : function(){ app.onLoad && app.onLoad(); },
        'resize' : function(){ app.onResize && app.onResize(); },
    });

}(this, this.document, jQuery));


/////////////////////////////////////////
// Plugins y APIS
/////////////////////////////////////////
(function( window, $, undefined ){
    var $window = $(window);

    // pruebas personalizadas para modernizr
    Modernizr.addTest('device', function(){
        return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    });


    var unique = function( arr ) {
        var unique = [], i;

        for (i = 0; i < arr.length; i++) {
            var current = arr[i];
            if (unique.indexOf(current) < 0) { unique.push(current); }
        }
        return unique;
    };

    $.fn.svgfallback = function( callback ) {
        if( Modernizr.svg ){ return false; }

        return this.each(function() {
            this.src = this.getAttribute('data-svgfallback');
        });
    };

    $.fn.groupByAtt = function( attname ){
        var $set = this,
            groups = [],
            posibles = [];

        // se guardan todos los posibles valores
        $set.each(function(i,el){
            posibles.push( el.getAttribute(attname) );
        });

        // se quitan los elementos duplicados dejando solo los unicos
        posibles = unique( posibles );

        // se itera sobre las posibilidades y se agrupan los elementos
        posibles.forEach(function( value ){
            groups.push($set.filter('['+ attname +'="'+ value +'"]'));
        });

        return groups;
    };

    $.fn.equalizeHeights = function( dinamic, mqException ){
        var items = this,
            eq_h = function( $collection ){
                var heightArray = [];

                $collection.removeClass('height-equalized').height('auto');

                if( !mqException || !Modernizr.mq(mqException) ){
                    $collection.each(function(i,e){ heightArray.push( $(e).height() ); });
                    $collection.height( Math.max.apply( Math, heightArray ) ).addClass('height-equalized').attr('data-max-height', Math.max.apply( Math, heightArray ));
                }
            };

        setTimeout(function(){
            eq_h( items );
        }, 0);

        if( dinamic ) { 
            $window.on('resize', function(){ 
                setTimeout(function(){
                    eq_h( items );
                }, 10);
            });
        }
    };

    $.fn.equalizeChildrenHeights = function( dinamic, mqException ){
        return this.each(function(i,e){
            $(e).children().equalizeHeights(dinamic, mqException);
        });
    };

    $.fn.equalizeTarget = function( dinamic, mqException ){
        return this.each(function( index, box ){
            $(box).find( $(box).data('eq-target') ).equalizeHeights( dinamic, mqException );
        });
    };

    $.fn.equalizeGroup = function( attname, dinamic, mqException ){
        var groups = this.groupByAtt( attname );

        groups.forEach(function( $set ){
            $set.equalizeHeights( dinamic, mqException );
        });

        return this;
    };

    $.fn.random = function() {
        var randomIndex = Math.floor(Math.random() * this.length);  
        return $(this[randomIndex]);
    };

}( this, jQuery ));

/////////////////////////////////////////
// Beautiful input plugin
/////////////////////////////////////////
(function( window, $, undefined ){
    window.Beautifier = function( element, callback ){
        this.$element = $(element);
        this.fileType = this.$element.data('file-type');
        this.name = this.$element.attr('name');
        this.placeholder = this.$element.data('placeholder');
        this.$fakeInput = $('<div />').attr({ 
            'class' : 'beautiful-input ' + this.fileType + (this.$element.data('aditional-classes') || ''), 
            'data-name' : this.name,
            'data-identifier' : this.$element.data('identifier') || 0
        }).text( this.placeholder || '' );

        this.$element.css({ 'position' : 'absolute', 'top' : '-999999em' });
        this.$element.after( this.$fakeInput );

        this.$fakeInput.on('click.beautify', { $realElement : this.$element }, function( event ){ 
            event.preventDefault(); 
            event.data.$realElement.trigger('click.beautify');  
        });

        this.$element.on('change.beautify',{ $fakeInput : this.$fakeInput }, function( event ){
            var input = event.currentTarget,
                $input = $(input);
            // si el elemento tiene definido un "max filesize" entonces se intenta enforzar
            if( $input.data('max-filesize') ){
                var maxSize = $input.data('max-filesize');

                // revisamos si se soporta la laecura de archivos
                if( typeof( input.files ) !== 'undefined'  ){
                    if( input.files[0] && input.files[0].size && input.files[0].size > maxSize ){
                        alert( 'El archivo sobrepasa el límite de tamaño, por favor selecione otro archivo.' );
                        return false;
                    }
                }
                
            }

            if( typeof( callback ) === 'function' ){
                callback( event );
            } else {
                var value = $input.val();
                value = value.replace("C:\\fakepath\\", '').replace("C:\/fakepath\/", '');
                
                event.data.$fakeInput.text( value ? value : $input.data('placeholder') ); 
            }
        });
    };
    $.fn.beautify = function( callback ) {
        return this.each(function() {
            var $element = $(this);
            if ($element.data('beautify')) { return $element.data('beautify'); }
            var beautify = new window.Beautifier( this, callback );
            $element.data('beautify', beautify);
        });
    };
}( this, jQuery ));


/////////////////////////////////////////
// Carga de tipografias
/////////////////////////////////////////
WebFontConfig = {
    google: { 
        families: [ 
            'Roboto+Condensed:300italic,400italic,700italic,300,400,700:latin',
            'Roboto:400,300italic,300,400italic,700,700italic:latin',
            'Oswald:400,300,700:latin' 
        ]
    }
};

(function() {
var wf = document.createElement('script');
wf.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
wf.type = 'text/javascript';
wf.async = 'true';
var s = document.getElementsByTagName('script')[0];
s.parentNode.insertBefore(wf, s);
})();


/////////////////////////////////////////
// Validador de RUTs
/////////////////////////////////////////
(function($){jQuery.fn.Rut=function(options){var defaults={digito_verificador:null,on_error:function(){},on_success:function(){},validation:true,format:true,format_on:'change'};var opts=$.extend(defaults,options);return this.each(function(){if(defaults.format){jQuery(this).bind(defaults.format_on,function(){jQuery(this).val(jQuery.Rut.formatear(jQuery(this).val(),defaults.digito_verificador==null));});}if(defaults.validation){if(defaults.digito_verificador==null){jQuery(this).bind('blur',function(){var rut=jQuery(this).val();if(jQuery(this).val()!=""&&!jQuery.Rut.validar(rut)){defaults.on_error();}else if(jQuery(this).val()!=""){defaults.on_success();}});}else
{var id=jQuery(this).attr("id");jQuery(defaults.digito_verificador).bind('blur',function(){var rut=jQuery("#"+id).val()+"-"+jQuery(this).val();if(jQuery(this).val()!=""&&!jQuery.Rut.validar(rut)){defaults.on_error();}else if(jQuery(this).val()!=""){defaults.on_success();}});}}});}})(jQuery);jQuery.Rut={formatear:function(Rut,digitoVerificador){var sRut=new String(Rut);var sRutFormateado='';sRut=jQuery.Rut.quitarFormato(sRut);if(digitoVerificador){var sDV=sRut.charAt(sRut.length-1);sRut=sRut.substring(0,sRut.length-1);}while(sRut.length>3){sRutFormateado="."+sRut.substr(sRut.length-3)+sRutFormateado;sRut=sRut.substring(0,sRut.length-3);}sRutFormateado=sRut+sRutFormateado;if(sRutFormateado!=""&&digitoVerificador){sRutFormateado+="-"+sDV;}else if(digitoVerificador){sRutFormateado+=sDV;}return sRutFormateado;},quitarFormato:function(rut){var strRut=new String(rut);while(strRut.indexOf(".")!=-1){strRut=strRut.replace(".","");}while(strRut.indexOf("-")!=-1){strRut=strRut.replace("-","");}return strRut;},digitoValido:function(dv){if(dv!='0'&&dv!='1'&&dv!='2'&&dv!='3'&&dv!='4'&&dv!='5'&&dv!='6'&&dv!='7'&&dv!='8'&&dv!='9'&&dv!='k'&&dv!='K'){return false;}return true;},digitoCorrecto:function(crut){largo=crut.length;if(largo<2){return false;}if(largo>2){rut=crut.substring(0,largo-1);}else
{rut=crut.charAt(0);}dv=crut.charAt(largo-1);jQuery.Rut.digitoValido(dv);if(rut==null||dv==null){return 0;}dvr=jQuery.Rut.getDigito(rut);if(dvr!=dv.toLowerCase()){return false;}return true;},getDigito:function(rut){var dvr='0';suma=0;mul=2;for(i=rut.length-1;i>=0;i--){suma=suma+rut.charAt(i)*mul;if(mul==7){mul=2;}else
{mul++;}}res=suma%11;if(res==1){return'k';}else if(res==0){return'0';}else
{return 11-res;}},validar:function(texto){texto=jQuery.Rut.quitarFormato(texto);largo=texto.length;if(largo<2){return false;}for(i=0;i<largo;i++){if(!jQuery.Rut.digitoValido(texto.charAt(i))){return false;}}var invertido="";for(i=(largo-1),j=0;i>=0;i--,j++){invertido=invertido+texto.charAt(i);}var dtexto="";dtexto=dtexto+invertido.charAt(0);dtexto=dtexto+'-';cnt=0;for(i=1,j=2;i<largo;i++,j++){if(cnt==3){dtexto=dtexto+'.';j++;dtexto=dtexto+invertido.charAt(i);cnt=1;}else
{dtexto=dtexto+invertido.charAt(i);cnt++;}}invertido="";for(i=(dtexto.length-1),j=0;i>=0;i--,j++){invertido=invertido+dtexto.charAt(i);}if(jQuery.Rut.digitoCorrecto(texto)){return true;}return false;}};
