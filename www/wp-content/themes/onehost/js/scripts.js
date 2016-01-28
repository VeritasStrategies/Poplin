var onehost = onehost || {},
	onehostShortCode =  onehostShortCode || {};

( function ( $ ) {
	'use strict';

	var pathName = window.location.pathname,
		baseURI;

	if ( !window.location.origin ) {
		window.location.origin = window.location.protocol + '//' + window.location.host;
	}

	//get baseURI if is preview
	baseURI = window.location.origin + pathName;
	baseURI = baseURI.replace( 'https', 'http' ).replace( 'www.', '' );

	if( baseURI.substr( -1 ) !== '/' ) {
		baseURI += '/';
	}

	// Store browser check in global variable 'onehost'
	onehost.isChrome = /chrome/.test( navigator.userAgent.toLowerCase() );
	onehost.isSafari = /safari/.test( navigator.userAgent.toLowerCase() ) && !onehost.isChrome;

	$( function() {

		var $window = $( window ),
			$body = $( 'body' ),
			$header = $( '#site-header' ),
			$nav    = $( '#primary-nav' ),
			$sectionHome = $( '#section-home' ),
			homeH = $sectionHome.outerHeight();

		// Show menu when resize to bigger
		$window.resize( function() {
			if ( $window.width() > 959 ) {
				$nav.show();
			} else {
				$nav.hide();
			}
		} );

		// Click the icon navbar-toggle show/hide menu mobile
		$header.on( 'click', '.navbar-toggle', function( e ) {
			e.preventDefault();
			$nav.slideToggle();
       	});

		// Menu Item Click
		$nav.on( 'click',  'a', function( e ) {
            var target = this.hash;

            if( target !== '') {
                if( $( target ).length > 0 ) {
                    e.preventDefault();
                    scrollSection( target );
                }
            }

			// Closes the Responsive Menu on
		    $('.navbar-toggle:visible').click();
		});

			// Scroll effect button top
		$( '#scroll-top' ).on( 'click', function( event ) {
			event.preventDefault();
			scrollSection();
		} );

		// Menu scroll
		$window.scroll( function() {
			if ( $window.scrollTop() > homeH - 100 ) {
				$header.addClass( 'minimized' );
			} else {
				$header.removeClass( 'minimized' );
			}

			if ( $window.scrollTop() > homeH ) {
				$( '#scroll-top' ).addClass( 'show-scroll' );
			} else {
				$( '#scroll-top' ).removeClass( 'show-scroll' );
			}

			// Set status active for menu nav
			var found = false,
				scrollTop  = $( window ).scrollTop(),
				headerH = $header.outerHeight(),
				headerTop = $header.position().top;

			$header.find( '.primary-nav a' ).each( function () {
				var target = this.hash,
					href = $( this ).attr( 'href' );

				if( ( target === '' && href !== baseURI ) || found ) { return; }

				var $section = $( target );
				if ( !$section.length ) { return; }

				var top = $section.offset().top - headerH - headerTop - 1;
				var bottom = top + $section.outerHeight();

				$header.find( '.primary-nav a' ).removeClass( 'current' );
				if( scrollTop >= top && scrollTop <= bottom ) {
					$( this ).addClass( 'current' );
					found = true;
				}
			});
		} ).trigger( 'scroll' );

		// Team members carousel
		$( '.ta-team-shortcode' ).each( function() {
			var $team = $( this ),
				show = false;

			if ( $team.hasClass( 'ta-team-grid-4' ) ) {
				show = 4;
			} else if ( $team.hasClass( 'ta-team-grid-3' ) ) {
				show = 3;
			} else if ( $team.hasClass( 'ta-team-grid-2' ) ) {
				show = 2;
			}
			if ( show ) {
				$team.children( '.row' ).owlCarousel( {
					direction: onehost.direction,
					items: show,
					pagination: false,
					autoPlay: true,
					navigation: true,
					navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
					itemsDesktop : [1199,3],
					itemsDesktopSmall: [979,2]
				} );
			}
		} );

		// Parallax
		if ( $window.width() > 768 ) {
			var $parallaxs = $body.find( '.parallax' );
			for( var i = 0; i < $parallaxs.length; i++ ) {
				$( $parallaxs[i] ).parallax( '50%', 0.6 );
			}
		}

		// Wow animation
		if( ! $body.hasClass( 'no-animation' ) ) {
			var wow = new WOW( {
				mobile : false,
				offset: 100
			} );
			wow.init();
		}

		// Portfolio lightbox
		$( '.view-portfolio-image' ).nivoLightbox();

		// whmcs

        if( ! $body.hasClass( 'page-template-template-whmcs-php' ) ) {
            if( $( '.entry-content' ).find( '#bridge' ).length > 0 ) {
                $( '.entry-content' ).prepend( $( '#bridge' ) );
                $( '#bridge' ).addClass( 'col-sm-9 col-md-9' );
                $( '.entry-content' ).find( '.widget' ).wrapAll( '<div class="col-sm-3 col-md-3 whmcs-widget"></div>');
            }
        }

		$body.imagesLoaded( function() {
			$( '#loader' ).fadeOut( 800, function() {
				$body.addClass( 'loaded' );
			} );
		} );

		//Flex slider for gallery
		if( $( '.flexslider .slides' ).find( '.entry-item' ).length > 1 ) {
			$( '.flexslider .slides' ).owlCarousel({
				direction: onehost.direction,
				items: 1,
				slideSpeed : 800,
				navigation: true,
				pagination: false,
				autoPlay: true,
				paginationSpeed : 1000,
				navigationText: ['<span class="fa fa-arrow-left"></span>', '<span class="fa fa-arrow-right"></span>']

			});
		}

		// Testimonial
		testimonialCarousel();

		// Images
		imagesCarousel();

		// Particleground Animated
		if( $body.find( '.particles' ).length > 0 ) {
			$body.find( '.particles' ).each( function() {
				var dotColor = $( this ).attr( 'dot-color' ),
					lineColor = $( this ).attr( 'line-color' );
				$( this ).particleground({
					dotColor: dotColor,
	    			lineColor: lineColor
				});
			});
		}

		// Youtube video background
		var $videoYouTube = $( '.ytvideo-bg' );
		if ( $videoYouTube.length ) {
			// Load Youtube iframe JS API
			var tag = document.createElement( 'script' ),
				firstScript = document.getElementsByTagName( 'script' )[0];

			tag.src = '//www.youtube.com/iframe_api';
			firstScript.parentNode.insertBefore( tag, firstScript );

			// Add callback function for Youtube API
			window.onYouTubeIframeAPIReady = function() {
				$videoYouTube.each( function() {
					var $el = $( this ),
						$toggle = $el.siblings( '.toggle-sound' ),
						id = $el.attr( 'id' );

					var bgPlayerYT = new YT.Player( id, {
						width: $window.width(),
						height: $window.height(),
						videoId: $el.data( 'video' ),
						playerVars: {
							controls: 0,
							showinfo: 0,
							rel     : 0,
							loop    : 1,
							autoplay: 1
						},
						events: {
							onReady: function( e ) {
								resizeYTPlayer( '#' + id );

								if ( ! onehost.isSafari ) {
									e.target.setPlaybackQuality( 'hd720' );
								}

								if ( $el.data( 'sound' ) !== 'mute' ) {
									e.target.unMute();
								} else {
									e.target.mute();
								}
							},
							onStateChange: function( state ) {
								if ( state.data === 0 ) {
									bgPlayerYT.seekTo( 0 );
								}
							}
						}
					} );

					// Toggle sound
					$toggle.on( 'click', function( e ) {
						e.preventDefault();

						if ( bgPlayerYT.isMuted() ) {
							bgPlayerYT.unMute();
							$toggle.find( 'i' ).addClass( 'fa-volume-up' ).removeClass( 'fa-volume-off' );
						} else {
							bgPlayerYT.mute();
							$toggle.find( 'i' ).removeClass( 'fa-volume-up' ).addClass( 'fa-volume-off' );
						}
					} );

				} );

				$window.on( 'resize', function()
				{
					$videoYouTube.each( function() {
						resizeYTPlayer( '#' + $( this ).attr( 'id' ) );
					} );
				} ).trigger( 'resize' );
			};
		}

		/**
		 * Init testimonials carousel
		 */
		function testimonialCarousel() {
			if ( onehostShortCode.length === 0 || typeof onehostShortCode.testimonial === 'undefined' ) {
				return;
			}
			$.each( onehostShortCode.testimonial, function ( id, testimonialData ) {
				var autoplay = ( testimonialData.autoplay === 'true' ) ? true : false,
				single       = ( testimonialData.single === 'true' ) ? true : false,
				navigation   = ( testimonialData.navigation === 'true' ) ? true : false,
				pagination   = ( testimonialData.pagination === 'true' ) ? true : false;

				$( document.getElementById( id ) ).owlCarousel({
					direction: onehost.direction,
					singleItem: single,
					items: 3,
					slideSpeed : testimonialData.speed ,
					navigation: navigation,
					autoPlay: autoplay,
					itemsDesktop : [1199,3],
					itemsDesktopSmall: [979,2],
					pagination: pagination,
					navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>']
				});
			} );
		}

		/**
		 * Init Images Carousel
		 */
		 function imagesCarousel() {
			if ( onehostShortCode.length === 0 || typeof onehostShortCode.imagesCarousel === 'undefined' ) {
				return;
			}
			$.each( onehostShortCode.imagesCarousel, function ( id, imagesCarousel ) {
				var autoplay = ( imagesCarousel.autoplay === 'true' ) ? true : false,
					navigation = ( imagesCarousel.navigation === 'true' ) ? true : false;
				$( document.getElementById( id ) ).owlCarousel({
					direction: onehost.direction,
					items: 6,
					slideSpeed : imagesCarousel.speed,
					navigation: navigation,
					pagination: false,
					autoPlay: autoplay,
					navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>']

				});
			} );
		}

		/**
		 * Scroll to section
		 */
		function scrollSection( target ) {
			var $header = $( '#site-header' ),
				headerH = $header.outerHeight(),
				headerTop = $header.position().top,
				top = 0;

			if( $window.width() <= 768 ) {
				headerTop = 0;
				headerH = $header.find( '.site-branding' ).height();
			}

			if( target != null ) {
				var $section = $( target );
				if( $section.length > 0 ) {
					var topSection = $section.offset().top;
					top = topSection - headerH - headerTop;
				}
			}

			$( 'html, body' ).stop().animate ( {
					scrollTop : top
				},
				1200, 'easeInOutExpo'
			);
		}

		/**
		 * Calculate background video width and height
		 */
		function resizeYTPlayer( element ) {
			var $player = $( element ),
				$section = $player.parents( 'section' ),
				ratio = 16 / 9,
				width = $section.outerWidth(),
				height = $section.outerHeight(),
				pWidth,
				pHeight;

			if ( width / ratio < height )
			{
				pWidth = Math.ceil( height * ratio );
				$player.width( pWidth ).height( height ).css( {left: (width - pWidth) / 2, top: 0} );
			}
			else
			{
				pHeight = Math.ceil( width / ratio );
				$player.width( width ).height( pHeight ).css( {left: 0, top: (height - pHeight) / 2} );
			}
		}
	} );

} )( jQuery );
