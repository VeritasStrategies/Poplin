<?php
/**
 * Register Team Member CPT and meta boxes for it
 *
 * @package TA Team Management
 */

/**
 * Class TA_Team_Member
 */
class TA_Team_Member {
	/**
	 * Social profiles
	 * @var array
	 */
	public $socials;

	/**
	 * Construction function
	 *
	 * @since 1.0.0
	 *
	 * @return TA_Team_Member
	 */
	public function __construct() {
		// Register custom post type and custom taxonomy
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'init', array( $this, 'register_taxonomy' ) );

		// Register socials
		add_action( 'init', array( $this, 'register_socials' ) );

		// Handle post columns
		add_filter( 'manage_team_member_posts_columns', array( $this, 'register_custom_columns' ) );
		add_action( 'manage_team_member_posts_custom_column', array( $this, 'manage_custom_columns' ), 10, 2 );

		// Add meta box
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_metadata' ) );
	}

	/**
	 * Register custom post type for Team Member
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function register_post_type() {
		// Return if post type is exists
		if ( post_type_exists( 'team_member' ) ) {
			return;
		}

		$labels = array(
			'name'               => _x( 'Team Member', 'Post Type General Name', 'ta-team' ),
			'singular_name'      => _x( 'Team Member', 'Post Type Singular Name', 'ta-team' ),
			'menu_name'          => __( 'Team', 'ta-team' ),
			'parent_item_colon'  => __( 'Parent Team Member', 'ta-team' ),
			'all_items'          => __( 'All Members', 'ta-team' ),
			'view_item'          => __( 'View Member', 'ta-team' ),
			'add_new_item'       => __( 'Add New Member', 'ta-team' ),
			'add_new'            => __( 'Add New', 'ta-team' ),
			'edit_item'          => __( 'Edit Member', 'ta-team' ),
			'update_item'        => __( 'Update Member', 'ta-team' ),
			'search_items'       => __( 'Search Member', 'ta-team' ),
			'not_found'          => __( 'Not found', 'ta-team' ),
			'not_found_in_trash' => __( 'Not found in Trash', 'ta-team' ),
		);
		$args   = array(
			'label'               => __( 'Team Member', 'ta-team' ),
			'description'         => __( 'Create and manage all works', 'ta-team' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => false,
			'menu_position'       => 5,
			'rewrite'             => array( 'slug' => apply_filters( 'ta_team_member_slug', 'member' ) ),
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'menu_icon'           => 'dashicons-groups',
		);
		register_post_type( 'team_member', $args );
	}

	/**
	 * Register Team Group taxonomy
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function register_taxonomy() {
		$labels = array(
			'name'              => __( 'Team Group', 'ta-team' ),
			'singular_name'     => __( 'Team Group', 'ta-team' ),
			'search_items'      => __( 'Search Team Groups', 'ta-team' ),
			'all_items'         => __( 'All Team Groups', 'ta-team' ),
			'parent_item'       => __( 'Parent Team Group', 'ta-team' ),
			'parent_item_colon' => __( 'Parent Team Group:', 'ta-team' ),
			'edit_item'         => __( 'Edit Team Group', 'ta-team' ),
			'update_item'       => __( 'Update Team Group', 'ta-team' ),
			'add_new_item'      => __( 'Add New Team Group', 'ta-team' ),
			'new_item_name'     => __( 'New Team Group Name', 'ta-team' ),
			'menu_name'         => _x( 'Groups', 'Team Group Taxonomy Menu', 'ta-team' ),
		);

		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'hierarchical'      => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => false,
			'rewrite'           => array(
				'slug'         => apply_filters( 'ta_team_group_slug', 'member-group' ),
				'with_front'   => true,
				'hierarchical' => false,
			),
		);

		register_taxonomy( 'team_group', array( 'team_member' ), $args );
	}

	/**
	 * Register social profile for a Team Member
	 *
	 * @since  1.0.0
	 *
	 * @return array
	 */
	public function register_socials() {
		$this->socials = apply_filters(
			'ta_team_member_socials',
			array(
				'facebook'   => __( 'Facebook', 'ta-team' ),
				'twitter'    => __( 'Twitter', 'ta-team' ),
				'googleplus' => __( 'Google Plus', 'ta-team' ),
				'linkedin'   => __( 'LinkedIn', 'ta-team' ),
				'flickr'     => __( 'Flickr', 'ta-team' ),
				'pinterest'  => __( 'Pinterest', 'ta-team' ),
				'dribbble'   => __( 'Dribbble', 'ta-team' ),
				'behance'    => __( 'Behance', 'ta-team' ),
				'youtube'    => __( 'Youtube', 'ta-team' ),
				'vimeo'      => __( 'Vimeo', 'ta-team' ),
			)
		);
	}

	/**
	 * Add custom column to manage Team Member screen
	 * Add image column
	 *
	 * @since  1.0.0
	 *
	 * @param  array $columns Default columns
	 *
	 * @return array
	 */
	public function register_custom_columns( $columns ) {
		$cb              = array_slice( $columns, 0, 1 );
		$cb['image'] = __( 'Image', 'ta-team' );

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

	/**
	 * Add Team Member information meta box
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function add_meta_boxes() {
		add_meta_box( 'team-member-info', __( 'Team Member Information', 'ta-team' ), array( $this, 'info_meta_box' ), 'team_member', 'normal', 'high' );
	}

	/**
	 * Display meta box
	 * It contains fields: email, website url and social links
	 *
	 * @since  1.0.0
	 *
	 * @param  object $post
	 *
	 * @return void
	 */
	public function info_meta_box( $post ) {
		$job     = get_post_meta( $post->ID, '_team_member_job', true );
		$address = get_post_meta( $post->ID, '_team_member_address', true );
		$phone   = get_post_meta( $post->ID, '_team_member_phone', true );
		$email   = get_post_meta( $post->ID, '_team_member_email', true );
		$url     = get_post_meta( $post->ID, '_team_member_url', true );
		$socials = get_post_meta( $post->ID, '_team_member_socials', true );

		wp_nonce_field( 'ta_team_member_info_' . $post->ID, '_tanonce' );
		?>

		<table class="form-table">
			<tr><th colspan="2"><h2><?php _e( 'Personal Information', 'ta-team' ) ?></h2></th></tr>

			<tr class="team-member-job">
				<th scope="row"><label for="team-member-job"><?php _e( 'Job Title', 'ta-team' ) ?></label></th>
				<td><input type="text" name="_team_member_job" value="<?php echo $job ?>" id="team-member-job" class="widefat"></td>
			</tr>

			<tr class="team-member-address">
				<th scope="row"><label for="team-member-address"><?php _e( 'Address', 'ta-team' ) ?></label></th>
				<td><input type="text" name="_team_member_address" value="<?php echo $address ?>" id="team-member-address" class="widefat"></td>
			</tr>

			<tr class="team-member-phone">
				<th scope="row"><label for="team-member-phone"><?php _e( 'Phone Number', 'ta-team' ) ?></label></th>
				<td><input type="text" name="_team_member_phone" value="<?php echo $phone ?>" id="team-member-phone" class="widefat"></td>
			</tr>

			<tr class="team-member-email">
				<th scope="row"><label for="team-member-email"><?php _e( 'Email', 'ta-team' ) ?></label></th>
				<td><input type="text" name="_team_member_email" value="<?php echo $email ?>" id="team-member-email" class="widefat"></td>
			</tr>

			<tr class="team-member-url">
				<th scope="row"><label for="team-member-url"><?php _e( 'Website', 'ta-team' ) ?></label></th>
				<td><input type="text" name="_team_member_url" value="<?php echo $url ?>" id="team-member-url" class="widefat"></td>
			</tr>

			<?php do_action( 'ta_team_member_info_fields', $post ); ?>

			<tr><th colspan="2"><h2><?php _e( 'Social Profile', 'ta-team' ) ?></h2></th></tr>

			<?php foreach( $this->socials as $social => $label ) : ?>
				<tr class = "team-member-social-<?php echo $social ?>">
					<th scope="row"><label for="team-member-social-<?php echo $social ?>"><?php echo $label ?></label></th>
					<td><input type="text" name="_team_member_socials[<?php echo $social ?>]" value="<?php echo isset( $socials[$social] ) ? $socials[$social] : '' ?>" id="team-member-social-<?php echo $social ?>" class="widefat"></td>
				</tr>
			<?php endforeach; ?>
		</table>

		<?php
	}

	/**
	 * Save post meta data
	 *
	 * @since  1.0.0
	 *
	 * @param  int $post_id
	 *
	 * @return void
	 */
	public function save_metadata( $post_id ) {
		// Verify nonce
		if ( ( get_post_type() != 'team_member' ) || ( isset( $_POST['_tanonce'] ) && ! wp_verify_nonce( $_POST['_tanonce'], 'ta_team_member_info_' . $post_id ) ) ) {
			return;
		}

		// Verify user permissions
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Update post meta
		update_post_meta( $post_id, '_team_member_job', esc_html( $_POST['_team_member_job'] ) );
		update_post_meta( $post_id, '_team_member_address', esc_html( $_POST['_team_member_address'] ) );
		update_post_meta( $post_id, '_team_member_phone', esc_html( $_POST['_team_member_phone'] ) );
		update_post_meta( $post_id, '_team_member_email', esc_html( $_POST['_team_member_email'] ) );
		update_post_meta( $post_id, '_team_member_url', esc_url( $_POST['_team_member_url'] ) );
		update_post_meta( $post_id, '_team_member_socials', array_map( 'esc_url', $_POST['_team_member_socials'] ) );

		do_action( 'ta_team_member_save_metadata', $post_id );
	}
}
