<?php
/**
 * Register Testimonial CPT
 *
 * @package TA Testimonial
 */

/**
 * Class TA_Testimonial
 */
class TA_Testimonial {

	/**
	 * Construction function
	 *
	 * @since 1.0.0
	 *
	 * @return TA_Testimonial
	 */
	public function __construct() {
		// Register custom post type and custom taxonomy
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'init', array( $this, 'register_taxonomy' ) );

		// Handle post columns
		add_filter( 'manage_testimonial_posts_columns', array( $this, 'register_custom_columns' ) );
		add_action( 'manage_testimonial_posts_custom_column', array( $this, 'manage_custom_columns' ), 10, 2 );
	}

	/**
	 * Register custom post type for testimonails
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function register_post_type() {
		// Return if post type is exists
		if ( post_type_exists( 'testimonial' ) ) {
			return;
		}

		$labels = array(
			'name'               => _x( 'Testimonials', 'Post Type General Name', 'ta-testimonial' ),
			'singular_name'      => _x( 'Testimonial', 'Post Type Singular Name', 'ta-testimonial' ),
			'menu_name'          => __( 'Testimonials', 'ta-testimonial' ),
			'parent_item_colon'  => __( 'Parent Testimonial', 'ta-testimonial' ),
			'all_items'          => __( 'All Testimonial', 'ta-testimonial' ),
			'view_item'          => __( 'View Testimonial', 'ta-testimonial' ),
			'add_new_item'       => __( 'Add New Testimonial', 'ta-testimonial' ),
			'add_new'            => __( 'Add New', 'ta-testimonial' ),
			'edit_item'          => __( 'Edit Testimonial', 'ta-testimonial' ),
			'update_item'        => __( 'Update Testimonial', 'ta-testimonial' ),
			'search_items'       => __( 'Search Testimonial', 'ta-testimonial' ),
			'not_found'          => __( 'Not found', 'ta-testimonial' ),
			'not_found_in_trash' => __( 'Not found in Trash', 'ta-testimonial' ),
		);
		$args   = array(
			'label'               => __( 'Testimonial', 'ta-testimonial' ),
			'description'         => __( 'Create and manage all testimonials', 'ta-testimonial' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => false,
			'menu_position'       => 5,
			'rewrite'             => array( 'slug' => apply_filters( 'ta_testimonial_slug', 'testimonial' ) ),
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'menu_icon'           => 'dashicons-format-quote',
		);
		register_post_type( 'testimonial', $args );
	}

	/**
	 * Register Testimonial category taxonomy
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function register_taxonomy() {
		$labels = array(
			'name'              => __( 'Categories', 'ta-testimonial' ),
			'singular_name'     => __( 'Category', 'ta-testimonial' ),
			'search_items'      => __( 'Search Category', 'ta-testimonial' ),
			'all_items'         => __( 'All Categories', 'ta-testimonial' ),
			'parent_item'       => __( 'Parent Category', 'ta-testimonial' ),
			'parent_item_colon' => __( 'Parent Category:', 'ta-testimonial' ),
			'edit_item'         => __( 'Edit Category', 'ta-testimonial' ),
			'update_item'       => __( 'Update Category', 'ta-testimonial' ),
			'add_new_item'      => __( 'Add New Category', 'ta-testimonial' ),
			'new_item_name'     => __( 'New Category Name', 'ta-testimonial' ),
			'menu_name'         => _x( 'Categories', 'Category Taxonomy Menu', 'ta-testimonial' ),
		);

		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'hierarchical'      => true,
			'show_admin_column' => false,
			'show_in_nav_menus' => false,
			'rewrite'           => array(
				'slug'         => apply_filters( 'ta_testimonial_category_slug', 'testimonial-cat' ),
				'with_front'   => true,
				'hierarchical' => false,
			),
		);

		register_taxonomy( 'testimonial_category', array( 'testimonial' ), $args );
	}

	/**
	 * Add custom column to manage testimonials screen
	 * Add image column
	 *
	 * @since  1.0.0
	 *
	 * @param  array $columns Default columns
	 *
	 * @return array
	 */
	public function register_custom_columns( $columns ) {
		$cb          = array_slice( $columns, 0, 1 );
		$cb['image'] = __( 'Image', 'ta-testimonial' );

		return array_merge( $cb, $columns );
	}

	/**
	 * Handle custom column display
	 *
	 * @since  1.0.0
	 *
	 * @param  string $column
	 * @param  int    $post_id
	 *
	 * @return void
	 */
	public function manage_custom_columns( $column, $post_id ) {
		if ( 'image' == $column ) {
			echo get_the_post_thumbnail( $post_id, array( 50, 50 ) );
		}
	}
}
