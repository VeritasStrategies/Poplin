<?php
/**
 * My Addresses
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;

$customer_id = get_current_user_id();

if ( ! wc_ship_to_billing_address_only() && get_option( 'woocommerce_calc_shipping' ) !== 'no' ) {
	$page_title = apply_filters( 'woocommerce_my_account_my_address_title', __( 'Address Book', 'swiftframework' ) );
	$get_addresses    = array(
		'billing' => __( 'Billing Address', 'swiftframework' ),
		'shipping' => __( 'Shipping Address', 'swiftframework' )
	);
} else {
	$page_title = apply_filters( 'woocommerce_my_account_my_address_title', __( 'Address Book', 'swiftframework' ) );
	$get_addresses    = array(
		'billing' =>  __( 'Billing Address', 'swiftframework' )
	);
}
$col = 1;
?>

<h3><?php echo $page_title; ?></h3>

<p class="myaccount_address">
	<?php echo apply_filters( 'woocommerce_my_account_my_address_description', __( 'The following addresses will be used on the checkout page by default.', 'swiftframework' ) ); ?>
</p>

<?php if ( ! wc_ship_to_billing_address_only() && get_option( 'woocommerce_calc_shipping' ) !== 'no' ) echo '<div class="col2-set addresses">'; ?>

<?php foreach ( $get_addresses as $name => $title ) : ?>

	<div class="col-<?php echo ( ( $col = $col * -1 ) < 0 ) ? 1 : 2; ?> address">
		<header class="title">
			<h3><?php echo $title; ?></h3>
		</header>
		<address>
			<?php
				$address = apply_filters( 'woocommerce_my_account_my_address_formatted_address', array(
					'first_name' 	=> get_user_meta( $customer_id, $name . '_first_name', true ),
					'last_name'		=> get_user_meta( $customer_id, $name . '_last_name', true ),
					'company'		=> get_user_meta( $customer_id, $name . '_company', true ),
					'address_1'		=> get_user_meta( $customer_id, $name . '_address_1', true ),
					'address_2'		=> get_user_meta( $customer_id, $name . '_address_2', true ),
					'city'			=> get_user_meta( $customer_id, $name . '_city', true ),
					'state'			=> get_user_meta( $customer_id, $name . '_state', true ),
					'postcode'		=> get_user_meta( $customer_id, $name . '_postcode', true ),
					'country'		=> get_user_meta( $customer_id, $name . '_country', true )
				), $customer_id, $name );
				
				$formatted_address = $woocommerce->countries->get_formatted_address( $address );
			
				if ( version_compare( WOOCOMMERCE_VERSION, "2.1.0" ) >= 0 ) {
				$formatted_address = WC()->countries->get_formatted_address( $address );		
				}

				if ( ! $formatted_address )
					_e( 'You have not set up this type of address yet.', 'swiftframework' );
				else
					echo $formatted_address;
					
				$edit_address_url = "";
				
				if ( version_compare( WOOCOMMERCE_VERSION, "2.1.0" ) >= 0 ) {
				$edit_address_url = wc_get_endpoint_url( 'edit-address', $name );
				} else {
				$edit_address_url = esc_url( add_query_arg('address', $name, get_permalink( woocommerce_get_page_id( 'edit_address' ) ) ) );
				}
			?>
		</address>
		<a href="<?php echo $edit_address_url; ?>" class="edit-address"><?php echo sprintf( __('Edit address', 'swiftframework' ), $name); ?></a>
		
	</div>

<?php endforeach; ?>

<?php if ( ! wc_ship_to_billing_address_only() && get_option( 'woocommerce_calc_shipping' ) !== 'no' ) echo '</div>'; ?>