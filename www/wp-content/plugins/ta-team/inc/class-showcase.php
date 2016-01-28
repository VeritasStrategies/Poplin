<?php
/**
 * Register Showcase CPT and meta boxes for it
 *
 * @package TA Team Management
 */

/**
 * Class TA_Team_Showcase
 */
class TA_Team_Showcase {
	/**
	 * Construction function
	 *
	 * @since 1.0.0
	 *
	 * @return TA_Team_Showcase
	 */
	public function __construct() {
		// Register custom post type and custom taxonomy
		add_action( 'init', array( $this, 'register_post_type' ) );

		// Load script and styles
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

		// Handle post columns
		add_filter( 'manage_team_showcase_posts_columns', array( $this, 'register_custom_columns' ) );
		add_action( 'manage_team_showcase_posts_custom_column', array( $this, 'manage_custom_columns' ), 10, 2 );

		// Add meta box
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_metadata' ) );

		// Help tab
		add_filter( 'contextual_help', array( $this, 'help_tab' ), 10, 3 );
	}

	/**
	 * Register team showcase post type
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function register_post_type() {
		// Return if post type is exists
		if ( post_type_exists( 'team_showcase' ) ) {
			return;
		}

		$labels = array(
			'name'               => _x( 'Showcase', 'Post Type General Name', 'ta-team' ),
			'singular_name'      => _x( 'Showcase', 'Post Type Singular Name', 'ta-team' ),
			'menu_name'          => __( 'Showcase', 'ta-team' ),
			'parent_item_colon'  => __( 'Parent Showcase', 'ta-team' ),
			'all_items'          => __( 'Showcases', 'ta-team' ),
			'view_item'          => __( 'View Showcase', 'ta-team' ),
			'add_new_item'       => __( 'Add New Showcase', 'ta-team' ),
			'add_new'            => __( 'Add New', 'ta-team' ),
			'edit_item'          => __( 'Edit Showcase', 'ta-team' ),
			'update_item'        => __( 'Update Showcase', 'ta-team' ),
			'search_items'       => __( 'Search Showcase', 'ta-team' ),
			'not_found'          => __( 'Not found', 'ta-team' ),
			'not_found_in_trash' => __( 'Not found in Trash', 'ta-team' ),
		);
		$args   = array(
			'label'               => __( 'Showcase', 'ta-team' ),
			'description'         => __( 'Create showcase shortcode', 'ta-team' ),
			'labels'              => $labels,
			'supports'            => array( 'title' ),
			'hierarchical'        => false,
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => 'edit.php?post_type=team_member',
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => false,
			'rewrite'             => true,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'query_var'           => false,
			'capability_type'     => 'post',
		);
		register_post_type( 'team_showcase', $args );
	}

	/**
	 * Load scripts and styles
	 *
	 * @since  1.0.0
	 *
	 * @param  array $columns Default columns
	 *
	 * @return array
	 */
	public function admin_enqueue_scripts() {
		$screen = get_current_screen();
		if ( 'team_showcase' != $screen->post_type ) {
			return;
		}

		wp_enqueue_script( 'ta-team-admin', TA_TEAM_URL . '/js/team-admin.js', array( 'jquery' ), TA_TEAM_VER, true );
	}

	/**
	 * Add custom column to manage team showcase screen
	 * Add shortcode column
	 *
	 * @since  1.0.0
	 *
	 * @param  array $columns Default columns
	 *
	 * @return array
	 */
	public function register_custom_columns( $columns ) {
		$columns['shortcode'] = __( 'Shortcode', 'ta-team' );

		return $columns;
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
		if ( 'shortcode' == $column ) {
			echo '[ta_team_showcase id="' . $post_id . '"]';
		}
	}

	/**
	 * Add team showcase options meta box
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function add_meta_boxes() {
		add_meta_box( 'team-showcase-options', __( 'Showcase Options', 'ta-team' ), array( $this, 'showcase_meta_box' ), 'team_showcase', 'normal', 'high' );
		add_meta_box( 'team-showcase-shortcode', __( 'Shortcode', 'ta-team' ), array( $this, 'shortcode_meta_box' ), 'team_showcase', 'side', 'high' );
	}

	/**
	 * Display team showcase settings meta box
	 *
	 * @since  1.0.0
	 *
	 * @param  object $post
	 *
	 * @return void
	 */
	public function showcase_meta_box( $post ) {
		$group        = get_post_meta( $post->ID, '_team_showcase_group', true );
		$limit        = get_post_meta( $post->ID, '_team_showcase_limit', true );
		$orderby      = get_post_meta( $post->ID, '_team_showcase_orderby', true );
		$order        = get_post_meta( $post->ID, '_team_showcase_order', true );

		$grid         = get_post_meta( $post->ID, '_team_showcase_grid', true );
		$style        = get_post_meta( $post->ID, '_team_showcase_style', true );
		$align        = get_post_meta( $post->ID, '_team_showcase_align', true );
		$display      = get_post_meta( $post->ID, '_team_showcase_display', true );

		$show_name    = get_post_meta( $post->ID, '_team_showcase_show_name', true );
		$show_job     = get_post_meta( $post->ID, '_team_showcase_show_job', true );
		$show_bio     = get_post_meta( $post->ID, '_team_showcase_show_bio', true );
		$show_socials = get_post_meta( $post->ID, '_team_showcase_show_socials', true );
		$show_address = get_post_meta( $post->ID, '_team_showcase_show_address', true );
		$show_phone   = get_post_meta( $post->ID, '_team_showcase_show_phone', true );
		$bio_type     = get_post_meta( $post->ID, '_team_showcase_bio_type', true );
		$hover        = get_post_meta( $post->ID, '_team_showcase_hover', true );

		// Merge with default values
		$grid         = $grid ? $grid : 4;
		$style        = $style ? $style : 'round';
		$align        = $align ? $align : 'center';
		$display      = $display ? $display : 'short';

		$options = array(
			'show_name'    => __( 'Show Name', 'ta-team' ),
			'show_job'     => __( 'Show Job Title', 'ta-team' ),
			'show_bio'     => __( 'Show Bio', 'ta-team' ),
			'show_address' => __( 'Show Address', 'ta-team' ),
			'show_phone'   => __( 'Show Phone Number', 'ta-team' ),
			'show_socials' => __( 'Show Social Icons', 'ta-team' ),
		);

		wp_nonce_field( 'ta_team_showcase_' . $post->ID, '_tanonce' );
		?>

		<table class="form-table">
			<tr>
				<th scope="row"><?php _e( 'Group', 'ta-team' ) ?></th>
				<td>
					<?php
					wp_dropdown_categories( array(
						'show_option_all' => __( 'All Groups', 'ta-team' ),
						'selected'        => $group,
						'name'            => '_team_showcase_group',
						'taxonomy'        => 'team_group',
					) );
					?>
				</td>
			</tr>

			<tr>
				<th scope="row"><label for="team-showcase-limit"><?php _e( 'Number of member', 'ta-team' ) ?></label></th>
				<td>
					<input type="number" name="_team_showcase_limit" value="<?php echo $limit ? $limit : 4; ?>" id="team-showcase-limit" size="3">

					<p class="description">
						<?php _e( 'Maximum number of member to be displayed', 'ta-team' ) ?>
					</p>
				</td>
			</tr>

			<tr>
				<th scope="row"><label for="team-showcase-orderby"><?php _e( 'Orderby', 'ta-team' ) ?></label></th>
				<td>
					<select name="_team_showcase_orderby" id="team-showcase-orderby">
						<option value=""><?php _e( 'Default', 'ta-team' ) ?></option>
						<option value="title" <?php selected( 'title', $orderby ); ?>><?php _e( 'Name', 'ta-team' ) ?></option>
						<option value="ID" <?php selected( 'ID', $orderby ); ?>><?php _e( 'ID', 'ta-team' ) ?></option>
						<option value="rand" <?php selected( 'rand', $orderby ); ?>><?php _e( 'Random', 'ta-team' ) ?></option>
					</select>
				</td>
			</tr>

			<tr>
				<th scope="row"><label for="team-showcase-order"><?php _e( 'Order', 'ta-team' ) ?></label></th>
				<td>
					<select name="_team_showcase_order" id="team-showcase-order">
						<option value="desc"><?php _e( 'DESC', 'ta-team' ) ?></option>
						<option value="asc" <?php selected( 'asc', $order ); ?>><?php _e( 'ASC', 'ta-team' ) ?></option>
					</select>
				</td>
			</tr>

			<tr><td colspan="2"><hr></td></tr>

			<tr>
				<th scope="row"><label for="team-showcase-grid"><?php _e( 'Grid', 'ta-team' ) ?></label></th>
				<td>
					<select name="_team_showcase_grid" id="team-showcase-grid">
						<option value="1" <?php selected( '1', $grid ); ?>><?php _e( 'One Column', 'ta-team' ) ?></option>
						<option value="2" <?php selected( '2', $grid ); ?>><?php _e( 'Two Columns', 'ta-team' ) ?></option>
						<option value="3" <?php selected( '3', $grid ); ?>><?php _e( 'Three Columns', 'ta-team' ) ?></option>
						<option value="4" <?php selected( '4', $grid ); ?>><?php _e( 'Four Columns', 'ta-team' ) ?></option>
					</select>

					<p class="description"><?php _e( 'It is number of member will be showed on one row', 'ta-team' ) ?></p>
				</td>
			</tr>

			<tr>
				<th scope="row"><label for="team-showcase-style"><?php _e( 'Image Style', 'ta-team' ) ?></label></th>
				<td>
					<select name="_team_showcase_style" id="team-showcase-style">
						<option value="default"><?php _e( 'Default', 'ta-team' ) ?></option>
						<option value="round" <?php selected( 'round', $style ); ?>><?php _e( 'Rounded', 'ta-team' ) ?></option>
						<option value="square" <?php selected( 'square', $style ); ?>><?php _e( 'Square', 'ta-team' ) ?></option>
					</select>

					<p class="description"><?php _e( 'Default style is the style of theme', 'ta-team' ) ?></p>
				</td>
			</tr>

			<tr>
				<th scope="row"><?php _e( 'Alignment', 'ta-team' ) ?></th>
				<td>
					<label>
						<input type="radio" name="_team_showcase_align" value="left" <?php checked( 'left', $align ); ?>>
						<?php _e( 'Left', 'ta-team' ); ?>
					</label>
					&nbsp;
					<label>
						<input type="radio" name="_team_showcase_align" value="center" <?php checked( 'center', $align ); ?>>
						<?php _e( 'Center', 'ta-team' ); ?>
					</label>
					&nbsp;
					<label>
						<input type="radio" name="_team_showcase_align" value="right" <?php checked( 'right', $align ); ?>>
						<?php _e( 'Right', 'ta-team' ); ?>
					</label>
				</td>
			</tr>

			<tr id="showcase-display-option">
				<th scope="row"><label for="team-showcase-display"><?php _e( 'Display', 'ta-team' ) ?></label></th>
				<td>
					<select name="_team_showcase_display" id="team-showcase-display">
						<option value="mini" <?php selected( 'mini', $display ); ?>><?php _e( 'Image Only', 'ta-team' ) ?></option>
						<option value="short" <?php selected( 'short', $display ); ?>><?php _e( 'Short Info', 'ta-team' ) ?></option>
						<option value="medium" <?php selected( 'medium', $display ); ?>><?php _e( 'Medium Info', 'ta-team' ) ?></option>
						<option value="medium_socials" <?php selected( 'medium_socials', $display ); ?>><?php _e( 'Medium Info and Social Icons', 'ta-team' ) ?></option>
						<option value="full" <?php selected( 'full', $display ); ?>><?php _e( 'Full Info', 'ta-team' ) ?></option>
						<option value="custom" <?php selected( 'custom', $display ); ?>><?php _e( 'Custom', 'ta-team' ) ?></option>
					</select>

					<p class="description"><?php _e( 'Select the way your showcase will be showed. If you still confuse, we explained about this on Help tab on top-right corner.', 'ta-team' ) ?></p>
				</td>
			</tr>

			<tr><td colspan="2"><hr></td></tr>

			<?php foreach( $options as $opt => $label ) : ?>

			<tr>
				<th scope="row"><label for="team-showcase-<?php echo $opt ?>"><?php echo $label ?></label></th>
				<td>
					<input type="checkbox" id="team-showcase-<?php echo $opt ?>" name="_team_showcase_<?php echo $opt ?>" value="1" <?php checked( 1, $$opt ); ?>>
				</td>
			</tr>

			<?php endforeach; ?>

			<tr>
				<th scope="row"><label for="team-showcase-bio-type"><?php _e( 'Bio', 'ta-team' ) ?></label></th>
				<td>
					<select name="_team_showcase_bio_type" id="team-showcase-bio-type">
						<option value="excerpt" <?php selected( 'excerpt', $bio_type ); ?>><?php _e( 'Show Excerpt', 'ta-team' ) ?></option>
						<option value="content" <?php selected( 'content', $bio_type ); ?>><?php _e( 'Show Content', 'ta-team' ) ?></option>
					</select>
				</td>
			</tr>

			<tr>
				<th scope="row"><label for="team-showcase-hover"><?php _e( 'When Hover', 'ta-team' ) ?></label></th>
				<td>
					<select name="_team_showcase_hover" id="team-showcase-hover">
						<option value="none" <?php selected( 'excerpt', $hover ); ?>><?php _e( 'Show Nothing', 'ta-team' ) ?></option>
						<option value="socials" <?php selected( 'socials', $hover ); ?>><?php _e( 'Show Social Icons', 'ta-team' ) ?></option>
						<option value="button" <?php selected( 'button', $hover ); ?>><?php _e( 'Show Readmore Button', 'ta-team' ) ?></option>
						<option value="info" <?php selected( 'info', $hover ); ?>><?php _e( 'Show Name, Job Title, Readmore Button', 'ta-team' ) ?></option>
						<option value="info_socials" <?php selected( 'info_socials', $hover ); ?>><?php _e( 'Show Name, Job Title, Social Icons', 'ta-team' ) ?></option>
					</select>
					<p class="description"><?php _e( 'Select which will bew showed when mouse hover over member image', 'ta-team' ) ?></p>
				</td>
			</tr>

			<?php do_action( 'ta_team_showcase_fields', $post ); ?>

		</table>

		<?php
	}

	/**
	 * Display generated shortcode
	 *
	 * @since  1.0.0
	 *
	 * @param  object $post
	 *
	 * @return void
	 */
	public function shortcode_meta_box( $post ) {
		echo '[ta_team_showcase id="' . $post->ID . '"]';
		echo '<br><br>';
		echo '<p class="description">' . __( 'Copy and paste this shortcode to any page you want to display team showcase.', 'ta-team' ) . '</p>';
	}

	/**
	 * Save meta data from meta box
	 *
	 * @since  1.0.0
	 *
	 * @param  int $post_id
	 *
	 * @return void
	 */
	public function save_metadata( $post_id ) {
		// Verify nonce
		if ( ( get_post_type() != 'team_showcase' ) || ( isset( $_POST['_tanonce'] ) && ! wp_verify_nonce( $_POST['_tanonce'], 'ta_team_showcase_' . $post_id ) ) ) {
			return;
		}

		// Verify user permissions
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Update post meta
		update_post_meta( $post_id, '_team_showcase_group', $_POST['_team_showcase_group'] );
		update_post_meta( $post_id, '_team_showcase_limit', absint( $_POST['_team_showcase_limit'] ) );
		update_post_meta( $post_id, '_team_showcase_orderby', $_POST['_team_showcase_orderby'] );
		update_post_meta( $post_id, '_team_showcase_order', $_POST['_team_showcase_order'] );

		update_post_meta( $post_id, '_team_showcase_grid', $_POST['_team_showcase_grid'] );
		update_post_meta( $post_id, '_team_showcase_style', $_POST['_team_showcase_style'] );
		update_post_meta( $post_id, '_team_showcase_align', $_POST['_team_showcase_align'] );
		update_post_meta( $post_id, '_team_showcase_display', $_POST['_team_showcase_display'] );

		update_post_meta( $post_id, '_team_showcase_show_name', isset( $_POST['_team_showcase_show_name'] ) );
		update_post_meta( $post_id, '_team_showcase_show_job', isset( $_POST['_team_showcase_show_job'] ) );
		update_post_meta( $post_id, '_team_showcase_show_bio', isset( $_POST['_team_showcase_show_bio'] ) );
		update_post_meta( $post_id, '_team_showcase_show_socials', isset( $_POST['_team_showcase_show_socials'] ) );
		update_post_meta( $post_id, '_team_showcase_show_address', isset( $_POST['_team_showcase_show_address'] ) );
		update_post_meta( $post_id, '_team_showcase_show_phone', isset( $_POST['_team_showcase_show_phone'] ) );
		update_post_meta( $post_id, '_team_showcase_bio_type', $_POST['_team_showcase_bio_type'] );
		update_post_meta( $post_id, '_team_showcase_hover', $_POST['_team_showcase_hover'] );

		do_action( 'ta_team_showcase_save_metadata', $post_id );
	}

	/**
	 * Add content to help tab
	 *
	 * @since  1.0.0
	 *
	 * @param  string $contextual_help
	 * @param  string $screen_id
	 * @param  object $screen
	 *
	 * @return string
	 */
	public function help_tab( $contextual_help, $screen_id, $screen ) {
		if ( 'team_showcase' != $screen_id ) {
			return '';
		}

		ob_start();
		?>

		<p><?php _e( 'You can generate a showcase about your team members by change all options we provide bellow. Here we will help you understand about some of options we provided.', 'ta-team' ) ?></p>

		<h3><?php _e( 'Grid', 'ta-team' ) ?></h3>
		<p><?php _e( 'We use grid to display a team showcase. Each member will be showed in one column. It is mean the number of columns is the number of member will be show in one row.', 'ta-team' ) ?></p>
		<p><?php _e( 'Example: you set "Number of member" is 8 and select grid "Four Columns", your showcase will display 8 members in two rows, each row contain 4 members.', 'ta-team' ) ?></p>

		<h3><?php _e( 'Display', 'ta-team' ) ?></h3>
		<ul>
			<li><?php _e( 'Image Only: Only show member image. When mouse hover, it will show name, job title and readmore button.', 'ta-team' ) ?></li>
			<li><?php _e( 'Short Info: Show member image, name, job title. When mouse hover, it will show social icons.', 'ta-team' ) ?></li>
			<li><?php _e( 'Medium Info: Show member image, name, job title and excerpt. When mouse hover, it will show social icons', 'ta-team' ) ?></li>
			<li><?php _e( 'Medium Info and Social Links: Like Medium Info but also show socials icons bellow excerpt. Nothing will be show when mouse hover.', 'ta-team' ) ?></li>
			<li><?php _e( 'Full Info: Show all information of member. Nothing will be show when mouse hover.', 'ta-team' ) ?></li>
			<li><?php _e( 'Custom: You can decide what to be showed by default and when mouse hover.', 'ta-team' ) ?></li>
		</ul>

		<?php
		return ob_get_clean();
	}
}
