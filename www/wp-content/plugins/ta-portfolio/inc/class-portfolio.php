<?php
/**
 * Register Portfolio CPT and meta boxes for it
 * Post type name and meta key names are follow 'content type standard',
 * see more about it here: https://github.com/justintadlock/content-type-standards/wiki/Content-Type:-Portfolio
 *
 * @package TA Portfolio Management
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class TA_Portfolio
 */
class TA_Portfolio {
	/**
	 * Construction function
	 *
	 * @since 1.0.0
	 *
	 * @return TA_Portfolio
	 */
	public function __construct() {
		// Register custom post type and custom taxonomy
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'init', array( $this, 'register_taxonomy' ) );

		// Handle post columns
		add_filter( 'manage_portfolio_project_posts_columns', array( $this, 'register_custom_columns' ) );
		add_action( 'manage_portfolio_project_posts_custom_column', array( $this, 'manage_custom_columns' ), 10, 2 );

		// Add meta box
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_metadata' ) );

		// Enqueue style and javascript
		add_action( 'admin_print_styles-post.php', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_print_styles-post-new.php', array( $this, 'enqueue_scripts' ) );

		// Handle ajax callbacks
		add_action( 'wp_ajax_ta_portfolio_attach_images', array( $this, 'ajax_attach_images' ) );
		add_action( 'wp_ajax_ta_portfolio_order_images', array( $this, 'ajax_order_images' ) );
		add_action( 'wp_ajax_ta_portfolio_delete_image', array( $this, 'ajax_delete_image' ) );
	}

	/**
	 * Register portfolio post type
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function register_post_type() {
		// Return if post type is exists
		if ( post_type_exists( 'portfolio_project' ) ) {
			return;
		}

		$labels = array(
			'menu_name'          => __( 'Portfolio',                  'ta-portfolio' ),
			'name_admin_bar'     => __( 'Portfolio Project',          'ta-portfolio' ),
			'add_new'            => __( 'Add New',                    'ta-portfolio' ),
			'add_new_item'       => __( 'Add New Project',            'ta-portfolio' ),
			'edit_item'          => __( 'Edit Project',               'ta-portfolio' ),
			'new_item'           => __( 'New Project',                'ta-portfolio' ),
			'view_item'          => __( 'View Project',               'ta-portfolio' ),
			'search_items'       => __( 'Search Projects',            'ta-portfolio' ),
			'not_found'          => __( 'No projects found',          'ta-portfolio' ),
			'not_found_in_trash' => __( 'No projects found in trash', 'ta-portfolio' ),
			'all_items'          => __( 'Projects',                   'ta-portfolio' ),
		);
		$args   = array(
			'label'               => __( 'Portfolio', 'ta-portfolio' ),
			'description'         => __( 'Create and manage all works', 'ta-portfolio' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => true,
			'rewrite'             => array( 'slug' => apply_filters( 'ta_portfolio_slug', 'portfolio' ) ),
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'menu_icon'           => 'dashicons-portfolio',
		);
		register_post_type( 'portfolio_project', $args );
	}

	/**
	 * Register portfolio category taxonomy
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function register_taxonomy() {
		$labels = array(
			'name'                       => __( 'Project Categories', 'ta-portfolio' ),
			'singular_name'              => __( 'Project Category',   'ta-portfolio' ),
			'menu_name'                  => __( 'Categories',         'ta-portfolio' ),
			'name_admin_bar'             => __( 'Category',           'ta-portfolio' ),
			'search_items'               => __( 'Search Categories',  'ta-portfolio' ),
			'popular_items'              => __( 'Popular Categories', 'ta-portfolio' ),
			'all_items'                  => __( 'All Categories',     'ta-portfolio' ),
			'edit_item'                  => __( 'Edit Category',      'ta-portfolio' ),
			'view_item'                  => __( 'View Category',      'ta-portfolio' ),
			'update_item'                => __( 'Update Category',    'ta-portfolio' ),
			'add_new_item'               => __( 'Add New Category',   'ta-portfolio' ),
			'new_item_name'              => __( 'New Category Name',  'ta-portfolio' ),
			'parent_item'                => __( 'Parent Category',    'ta-portfolio' ),
			'parent_item_colon'          => __( 'Parent Category:',   'ta-portfolio' ),
			'separate_items_with_commas' => null,
			'add_or_remove_items'        => null,
			'choose_from_most_used'      => null,
			'not_found'                  => null,
		);

		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'hierarchical'      => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'rewrite'           => array(
				'slug'         => apply_filters( 'ta_portfolio_category_slug', 'portfolio-category' ),
				'with_front'   => false,
				'hierarchical' => true,
				'ep_mask'      => EP_NONE,
			),
		);

		// Register portfolio project category
		register_taxonomy( 'portfolio_category', array( 'portfolio_project' ), apply_filters( 'ta_portfolio_category_args', $args ) );

		$labels = array(
			'name'                       => __( 'Project Tags',                   'ta-portfolio' ),
			'singular_name'              => __( 'Project Tag',                    'ta-portfolio' ),
			'menu_name'                  => __( 'Tags',                           'ta-portfolio' ),
			'name_admin_bar'             => __( 'Tag',                            'ta-portfolio' ),
			'search_items'               => __( 'Search Tags',                    'ta-portfolio' ),
			'popular_items'              => __( 'Popular Tags',                   'ta-portfolio' ),
			'all_items'                  => __( 'All Tags',                       'ta-portfolio' ),
			'edit_item'                  => __( 'Edit Tag',                       'ta-portfolio' ),
			'view_item'                  => __( 'View Tag',                       'ta-portfolio' ),
			'update_item'                => __( 'Update Tag',                     'ta-portfolio' ),
			'add_new_item'               => __( 'Add New Tag',                    'ta-portfolio' ),
			'new_item_name'              => __( 'New Tag Name',                   'ta-portfolio' ),
			'separate_items_with_commas' => __( 'Separate tags with commas',      'ta-portfolio' ),
			'add_or_remove_items'        => __( 'Add or remove tags',             'ta-portfolio' ),
			'choose_from_most_used'      => __( 'Choose from the most used tags', 'ta-portfolio' ),
			'not_found'                  => __( 'No tags found',                  'ta-portfolio' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
		);

		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'hierarchical'      => false,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'rewrite'           => array(
				'slug'         => apply_filters( 'ta_portfolio_category_slug', 'portfolio-tag' ),
				'with_front'   => false,
				'hierarchical' => false,
				'ep_mask'      => EP_NONE,
			),
		);

		// Register portfolio project category
		register_taxonomy( 'portfolio_tag', array( 'portfolio_project' ), apply_filters( 'ta_portfolio_tag_args', $args ) );
	}

	/**
	 * Add custom column to manage portfolio screen
	 * Add Thumbnail column
	 *
	 * @since  1.0.0
	 *
	 * @param  array $columns Default columns
	 *
	 * @return array
	 */
	public function register_custom_columns( $columns ) {
		$cb              = array_slice( $columns, 0, 1 );
		$cb['thumbnail'] = __( 'Thumbnail', 'ta-portfolio' );

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
		if ( 'thumbnail' == $column ) {
			echo get_the_post_thumbnail( $post_id, array( 50, 50 ) );
		}
	}

	/**
	 * Load scripts and style for meta box
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		global $post_type;

		if ( $post_type == 'portfolio_project' ) {
			wp_enqueue_media();
			wp_enqueue_style( 'ta-portfolio', TA_PORTFOLIO_URL . '/css/admin.css' );
			wp_enqueue_script( 'ta-portfolio', TA_PORTFOLIO_URL . '/js/admin.js', array( 'jquery', 'underscore', 'jquery-ui-sortable' ), TA_PORTFOLIO_VER, true );

			wp_localize_script(
				'ta-portfolio', 'taPortfolio', array(
					'frameTitle' => __( 'Select Or Upload Images', 'ta-portfolio' ),
				)
			);
		}
	}

	/**
	 * Add portfolio details meta box
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function add_meta_boxes() {
		add_meta_box( 'portfolio-detail', __( 'Portfolio Details', 'ta-portfolio' ) . '<span id="ta-portfolio-spinner" class="spinner"></span>', array( $this, 'portfolio_detail_meta_box' ), 'portfolio_project', 'normal', 'high' );
	}

	/**
	 * Display portfolio details meta box
	 * It contains: Client, URL, Skill, Gallery
	 *
	 * @since  1.0.0
	 *
	 * @param  object $post
	 *
	 * @return void
	 */
	public function portfolio_detail_meta_box( $post ) {
		wp_nonce_field( 'ta_portfolio_details_' . $post->ID, '_tanonce' );
		?>

		<p>
			<label for="project-client"><?php _e( 'Project Client', 'ta-portfolio' ) ?></label><br>
			<input type="text" name="_project_client" value="<?php echo esc_attr( get_post_meta( $post->ID, '_project_client', true ) ) ?>" id="project-client" class="widefat">
		</p>

		<p>
			<label for="project-url"><?php _e( 'Project URL', 'ta-portfolio' ) ?></label><br>
			<input type="text" name="_project_url" value="<?php echo esc_attr( get_post_meta( $post->ID, '_project_url', true ) ) ?>" id="project-url" class="widefat">
		</p>

		<p>
			<label for="project-skills"><?php _e( 'Project Skills', 'ta-portfolio' ) ?></label><br>
			<input type="text" name="_project_skills" value="<?php echo esc_attr( get_post_meta( $post->ID, '_project_skills', true ) ) ?>" id="project-skills" class="widefat">
		</p>

		<p>
			<?php _e( 'Project Gallery', 'ta-portfolio' ) ?>
		</p>

		<ul id="project-images" class="images-holder" data-nonce="<?php echo wp_create_nonce( 'ta-portfolio-images-' . $post->ID ) ?>">
			<?php
			foreach ( $images = array_filter( (array) get_post_meta( $post->ID, 'images', false ) ) as $image ) {
				echo $this->gallery_item( $image );
			}
			?>
		</ul>

		<input type="button" id="ta-images-upload" class="button" value="<?php _e( 'Select Or Upload Images', 'ta-portfolio' ) ?>" data-nonce="<?php echo wp_create_nonce( 'ta-upload-images-' . $post->ID ) ?>">

		<?php do_action( 'ta_portfolio_details_fields', $post ); ?>

		<?php
	}

	/**
	 * Save portfolio details
	 *
	 * @since  1.0.0
	 *
	 * @param  int $post_id
	 *
	 * @return void
	 */
	public function save_metadata( $post_id ) {
		// Verify nonce
		if ( ( get_post_type() != 'portfolio_project' ) || ( isset( $_POST['_tanonce'] ) && ! wp_verify_nonce( $_POST['_tanonce'], 'ta_portfolio_details_' . $post_id ) ) ) {
			return;
		}

		// Verify user permissions
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Update post meta
		update_post_meta( $post_id, '_project_url', esc_url( $_POST['_project_url'] ) );
		update_post_meta( $post_id, '_project_client', esc_html( $_POST['_project_client'] ) );
		update_post_meta( $post_id, '_project_skills', esc_html( $_POST['_project_skills'] ) );

		do_action( 'ta_portfolio_save_metadata', $post_id );
	}

	/**
	 * Get html markup for one gallery's image item
	 *
	 * @param  int $attachment_id
	 *
	 * @return string
	 */
	public function gallery_item( $attachment_id ) {
		return sprintf(
			'<li id="item_%1$s">
				%5$s
				<p class="image-actions">
					<a title="%3$s" class="ta-portfolio-edit-image" href="%2$s" target="_blank">%3$s</a> |
					<a title="%4$s" class="ta-portfolio-delete-image" href="#" data-attachment_id="%1$s" data-nonce="%6$s">×</a>
				</p>
			</li>',
			$attachment_id,
			get_edit_post_link( $attachment_id ),
			__( 'Edit', 'ta-portfolio' ),
			__( 'Delete', 'ta-portfolio' ),
			wp_get_attachment_image( $attachment_id ),
			wp_create_nonce( 'ta-portfolio-delete-image-' . $attachment_id )
		);
	}

	/**
	 * Ajax callback for attaching media to field
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function ajax_attach_images() {
		$post_id        = isset( $_POST['post_id'] ) ? $_POST['post_id'] : 0;
		$attachment_ids = isset( $_POST['attachment_ids'] ) ? $_POST['attachment_ids'] : array();

		check_ajax_referer( 'ta-upload-images-' . $post_id );
		$items = '';

		foreach ( $attachment_ids as $attachment_id ) {
			add_post_meta( $post_id, 'images', $attachment_id, false );
			$items .= $this->gallery_item( $attachment_id );
		}
		wp_send_json_success( $items );
	}

	/**
	 * Ajax callback for ordering images
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function ajax_order_images() {
		$order   = isset( $_POST['order'] ) ? $_POST['order'] : 0;
		$post_id = isset( $_POST['post_id'] ) ? (int) $_POST['post_id'] : 0;

		check_ajax_referer( 'ta-portfolio-images-' . $post_id );

		parse_str( $order, $items );

		delete_post_meta( $post_id, 'images' );
		foreach ( $items['item'] as $item ) {
			add_post_meta( $post_id, 'images', $item, false );
		}
		wp_send_json_success();
	}

	/**
	 * Ajax callback for deleting an image from portfolio's gallery
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	function ajax_delete_image() {
		$post_id       = isset( $_POST['post_id'] ) ? intval( $_POST['post_id'] ) : 0;
		$attachment_id = isset( $_POST['attachment_id'] ) ? intval( $_POST['attachment_id'] ) : 0;

		check_ajax_referer( 'ta-portfolio-delete-image-' . $attachment_id );

		delete_post_meta( $post_id, 'images', $attachment_id );
		wp_send_json_success();
	}
}
