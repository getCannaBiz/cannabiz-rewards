<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @package    CannaBiz_Rewards
 * @subpackage CannaBiz_Rewards/admin
 * @author     CannaBiz Software <hello@cannabiz.pro>
 * @license    GPL-2.0+ http://www.gnu.org/licenses/gpl-2.0.txt
 * @link       https://cannabiz.pro
 * @since      1.0.0
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    wp_die();
}

/**
 * Add loyalty points on successful customer registration
 *
 * @param int $user_id 
 * 
 * @since  1.0.0
 * @return void
 */
function cannabiz_customer_registration( $user_id ) {
    // Check settings before adding any points.
    if ( 'on' == cannabiz_loyalty_points_activate() && 0 != cannabiz_earning_points_customer_registration() ) {
        // Get user's loyalty points.
        $old_points = get_user_meta( $user_id, 'cannabiz_loyalty_points', true );

        // Set empty variable to zero.
        if ( '' == $old_points ) {
            $old_points = 0;
        }

        // Add loyalty points for customer registration.
        $new_points = $old_points + cannabiz_earning_points_customer_registration();

        // Update customer loyalty points.
        update_user_meta( $user_id, 'cannabiz_loyalty_points', $new_points, $old_points );
    }

}
add_action( 'user_register', 'cannabiz_customer_registration', 10, 1 );

/**
 * Add loyalty points on order completion
 * 
 * @since  1.0.0
 * @return void
 */
function cannabiz_customer_first_order() {
    // Check settings before adding any points.
    if ( 'on' == cannabiz_loyalty_points_activate() && 0 != cannabiz_earning_points_order_complete() ) {
        // Get user's loyalty points.
        $old_points = get_user_meta( get_current_user_id(), 'cannabiz_loyalty_points', true );

        // Set empty variable to zero.
        if ( '' == $old_points ) {
            $old_points = 0;
        }

        // Add loyalty points for completing an order.
        $new_points = $old_points + cannabiz_earning_points_order_complete();

        // Update customer loyalty points.
        update_user_meta( get_current_user_id(), 'cannabiz_loyalty_points', $new_points, $old_points );
    }
}
add_action( 'wpd_ecommerce_checkout_success_after', 'cannabiz_customer_first_order', 10 );

/**
 * Add loyalty points for every dollar spent
 *
 * @param int $order_id 
 *
 * @since  1.0.0
 * @return void
 */
function cannabiz_customer_money_spent( $order_id ) {
    // Check settings before adding any points.
    if ( 'on' == cannabiz_loyalty_points_activate() && 0 != cannabiz_earning_points_money_spent() ) {
        // Get order data.
        $order = wc_get_order( $order_id );

        // Get order total.
        $order_total = $order->get_total();

        // Get order subtotal.
        if ( 'subtotal' === cannabiz_loyalty_points_redeem_points_calculation_type() ) {
            $order_total = $order->get_subtotal();
        }

        // Get user's loyalty points.
        $old_points = get_user_meta( get_current_user_id(), 'cannabiz_loyalty_points', true );

        // Set empty variable to zero.
        if ( '' == $old_points ) {
            $old_points = 0;
        }

        // Get money spent loyalty points.
        $money_spent = $order_total * cannabiz_earning_points_money_spent();

        // Get new loyalty points total.
        $new_points = $old_points + round( $money_spent );

        // Update customer loyalty points.
        update_user_meta( get_current_user_id(), 'cannabiz_loyalty_points', $new_points, $old_points );
    }

}
add_action( 'wpd_ecommerce_checkout_success_after', 'cannabiz_customer_money_spent', 10 );
