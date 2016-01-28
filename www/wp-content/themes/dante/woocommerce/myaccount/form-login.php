<?php
/**
 * Login Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.6
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<?php

global $woocommerce;

$options = get_option('sf_dante_options');

if ( version_compare( WOOCOMMERCE_VERSION, "2.1.0" ) >= 0 ) { ?>
	
	<?php wc_print_notices(); ?>
	
	<?php do_action( 'woocommerce_before_customer_login_form' ); ?>
	
	<div class="my-account-login-wrap">
	
	<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>
	
		<div class="col2-set" id="customer_login">
	
		<div class="col-1">
	
	<?php endif; ?>
	
			<div class="login-wrap">
				<h4 class="lined-heading"><span><?php _e( 'Registered customers', 'swiftframework' ); ?></span></h4>
				<form method="post" class="login">
		
					<?php do_action( 'woocommerce_login_form_start' ); ?>
		
					<p class="form-row form-row-wide">
						<label for="username"><?php _e( 'Username or email address', 'swiftframework' ); ?> <span class="required">*</span></label>
						<input type="text" class="input-text" name="username" id="username" />
					</p>
					<p class="form-row form-row-wide">
						<label for="password"><?php _e( 'Password', 'swiftframework' ); ?> <span class="required">*</span></label>
						<input class="input-text" type="password" name="password" id="password" />
					</p>
		
					<?php do_action( 'woocommerce_login_form' ); ?>
		
					<p class="form-row">
						<?php wp_nonce_field( 'woocommerce-login' ); ?>
						<input type="submit" class="button" name="login" value="<?php _e( 'Login', 'swiftframework' ); ?>" /> 
						<label for="rememberme" class="inline">
							<input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php _e( 'Remember me', 'swiftframework' ); ?>
						</label>
					</p>
					<p class="lost_password">
						<a href="<?php echo esc_url( wc_lostpassword_url() ); ?>"><?php _e( 'Lost your password?', 'swiftframework' ); ?></a>
					</p>
		
					<?php do_action( 'woocommerce_login_form_end' ); ?>
		
				</form>
			</div>	
	<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>
	
		</div>
	
		<div class="col-2">
		
			<h4 class="lined-heading"><span><?php _e( 'Not registered? No problem', 'swiftframework' ); ?></span></h4>
				
			<div class="new-user-text"><?php _e($options['checkout_new_account_text'], 'swiftframework'); ?></div>
	
			<form method="post" class="register">
	
				<?php do_action( 'woocommerce_register_form_start' ); ?>
	
				<?php if ( get_option( 'woocommerce_registration_generate_username' ) === 'no' ) : ?>
	
					<p class="form-row form-row-wide username">
						<label for="reg_username"><?php _e( 'Username', 'swiftframework' ); ?> <span class="required">*</span></label>
						<input type="text" class="input-text" name="username" id="reg_username" value="<?php if ( ! empty( $_POST['username'] ) ) esc_attr_e( $_POST['username'] ); ?>" />
					</p>
	
				<?php endif; ?>
	
				<p class="form-row form-row-wide email">
					<label for="reg_email"><?php _e( 'Email address', 'swiftframework' ); ?> <span class="required">*</span></label>
					<input type="email" class="input-text" name="email" id="reg_email" value="<?php if ( ! empty( $_POST['email'] ) ) esc_attr_e( $_POST['email'] ); ?>" />
				</p>
	
				<p class="form-row form-row-wide">
					<label for="reg_password"><?php _e( 'Password', 'swiftframework' ); ?> <span class="required">*</span></label>
					<input type="password" class="input-text" name="password" id="reg_password" value="<?php if ( ! empty( $_POST['password'] ) ) esc_attr_e( $_POST['password'] ); ?>" />
				</p>
	
				<!-- Spam Trap -->
				<div style="left:-999em; position:absolute;"><label for="trap"><?php _e( 'Anti-spam', 'swiftframework' ); ?></label><input type="text" name="email_2" id="trap" tabindex="-1" /></div>
	
				<?php do_action( 'woocommerce_register_form' ); ?>
				<?php do_action( 'register_form' ); ?>
	
				<p class="form-row">
					<?php wp_nonce_field( 'woocommerce-register' ); ?>
					<input type="submit" class="button" name="register" value="<?php _e( 'Register', 'swiftframework' ); ?>" />
				</p>
	
				<?php do_action( 'woocommerce_register_form_end' ); ?>
	
			</form>
	
		</div>
	
	</div>
	<?php endif; ?>
	
	<?php do_action( 'woocommerce_after_customer_login_form' ); ?>

	</div>
	
<?php } else { ?>
	<?php $woocommerce->show_messages(); ?>
	
	<?php do_action('woocommerce_before_customer_login_form'); ?>
	
	<div class="my-account-login-wrap">
		
		<div class="col2-set" id="customer_login">
		
			<div class="col-1">
		
				<div class="login-wrap">
					<h4 class="lined-heading"><span><?php _e( 'Registered customers', 'swiftframework' ); ?></span></h4>
					<form method="post" class="login">
						<p class="form-row form-row-first">
							<label for="username"><?php _e( 'Username or email', 'swiftframework' ); ?> <span class="required">*</span></label>
							<input type="text" class="input-text" name="username" id="username" />
						</p>
						<p class="form-row form-row-last">
							<label for="password"><?php _e( 'Password', 'swiftframework' ); ?> <span class="required">*</span></label>
							<input class="input-text" type="password" name="password" id="password" />
						</p>
						<div class="clear"></div>
			
						<p class="form-row">
							<?php $woocommerce->nonce_field('login', 'login') ?>
							<input type="submit" class="button" name="login" value="<?php _e( 'Login', 'swiftframework' ); ?>" />
							<a class="lost_password" href="<?php
			
							$lost_password_page_id = woocommerce_get_page_id( 'lost_password' );
			
							if ( $lost_password_page_id )
								echo esc_url( get_permalink( $lost_password_page_id ) );
							else
								echo esc_url( wp_lostpassword_url( home_url() ) );
			
							?>"><?php _e( 'Lost Password?', 'swiftframework' ); ?></a>
						</p>
					</form>
				</div>
				
			</div>
			
			<?php if (get_option('woocommerce_enable_myaccount_registration')=='yes') : ?>
		
			<div class="col-2">
		
				<h4 class="lined-heading"><span><?php _e( 'Not registered? No problem', 'swiftframework' ); ?></span></h4>
				
				<div class="new-user-text"><?php _e($options['checkout_new_account_text'], 'swiftframework'); ?></div>
				
				<a class="sf-button sf-icon-reveal alt-button create-account-button" href="#create-account" data-toggle="modal"><i class="ss-compose"></i><span class="text"><?php _e('Create an account', 'swiftframework'); ?></span></a>
								
				<div id="create-account" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="create-account-modal" aria-hidden="true">
					<div class="modal-dialog">
					    <div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="ss-delete"></i></button>
								<h3 id="create-account-modal"><?php _e("Register", "swiftframework"); ?></h3>
							</div>
							<div class="modal-body">
							
								<form method="post" class="register">
							
								<?php if ( get_option( 'woocommerce_registration_email_for_username' ) == 'no' ) : ?>
					
									<p class="form-row form-row-first">
										<label for="reg_username"><?php _e( 'Username', 'swiftframework' ); ?> <span class="required">*</span></label>
										<input type="text" class="input-text" name="username" id="reg_username" value="<?php if (isset($_POST['username'])) echo esc_attr($_POST['username']); ?>" />
									</p>
					
									<p class="form-row form-row-last">
					
								<?php else : ?>
					
									<p class="form-row form-row-wide">
					
								<?php endif; ?>
					
									<label for="reg_email"><?php _e( 'Email', 'swiftframework' ); ?> <span class="required">*</span></label>
									<input type="email" class="input-text" name="email" id="reg_email" value="<?php if (isset($_POST['email'])) echo esc_attr($_POST['email']); ?>" />
								</p>
					
								<div class="clear"></div>
					
								<p class="form-row form-row-first">
									<label for="reg_password"><?php _e( 'Password', 'swiftframework' ); ?> <span class="required">*</span></label>
									<input type="password" class="input-text" name="password" id="reg_password" value="<?php if (isset($_POST['password'])) echo esc_attr($_POST['password']); ?>" />
								</p>
								<p class="form-row form-row-last">
									<label for="reg_password2"><?php _e( 'Re-enter password', 'swiftframework' ); ?> <span class="required">*</span></label>
									<input type="password" class="input-text" name="password2" id="reg_password2" value="<?php if (isset($_POST['password2'])) echo esc_attr($_POST['password2']); ?>" />
								</p>
								<div class="clear"></div>
					
								<!-- Spam Trap -->
								<div style="left:-999em; position:absolute;"><label for="trap">Anti-spam</label><input type="text" name="email_2" id="trap" tabindex="-1" /></div>
			
								<?php do_action( 'register_form' ); ?>
								
								<?php $woocommerce->nonce_field('register', 'register') ?>
								<input type="submit" class="button" name="register" value="<?php _e( 'Register', 'swiftframework' ); ?>" />
								
								</form>					
							</div>
						</div>
					</div>
				</div>
		
			</div>
			
			<?php endif; ?>
			
		</div>
	
	</div>
	
	<?php do_action('woocommerce_after_customer_login_form'); ?>

<?php } ?>