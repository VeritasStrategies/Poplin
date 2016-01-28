jQuery( document ).ready( function( $ ) {
	'use strict';

	$( '.ta-portfolio-shortcode' ).each( function() {
		var $portfolio = $( this ),
			$items = $portfolio.find( '.portfolio_project' ),
			$filter = $portfolio.prev( '.portfolio-filter' ),
			layout = $portfolio.data( 'layout' ),
			gutter = parseInt( $portfolio.data( 'gutter' ) ),
			options;

		if ( gutter > 0 ) {
			$portfolio.css( { marginLeft: - gutter / 2, marginRight: - gutter / 2 } );
			$items.css( 'padding', gutter / 2 );
		}

		options = {
			transitionDuration: '0.8s',
			itemSelector: '.portfolio_project',
			layoutMode  : layout == 'metro' ? 'masonry' : layout
		};

		if ( 'masonry' == layout || 'metro' == layout ) {
			options.masonry = {
				columnWidth: '.portfolio-sizer'
			};
		}

		$portfolio.imagesLoaded( function() {
			if ( gutter > 0 && 'metro' == layout ) {
				var itemHeight = $items.first().height();

				$items.filter( function() { return ! $( this ).hasClass( 'portfolio-long' ); } ).height( itemHeight );
				$items.filter( '.portfolio-long' ).height( itemHeight * 2 + gutter );
				$portfolio.addClass( 'init-completed' );
			}

			$portfolio.isotope( options );
		} );

		if ( $filter.length ) {
			$filter.on( 'click', 'a', function( e ) {
				e.preventDefault();

				var $this = $( this ),
					filterValue = $this.data( 'filter' );

				$filter.children().removeClass( 'active' );
				$this.addClass( 'active' );
				$portfolio.isotope( { filter: filterValue } );
			} );
		}
	} );
} );
