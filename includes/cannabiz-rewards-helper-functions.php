<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @package    CannaBiz_Rewards
 * @subpackage CannaBiz_Rewards/includes
 * @author     CannaBiz Software <hello@cannabiz.pro>
 * @license    GPL-2.0+ http://www.gnu.org/licenses/gpl-2.0.txt
 * @link       https://cannabiz.pro
 * @since      1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    wp_die();
}

/**
 * Random String function.
 * 
 * @param int $length 
 * 
 * @since  1.0.0
 * @return string
 */
function cannabiz_get_random_string( $length = 6 ) {
    // Characters to use when creating random string.
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    // Create string.
    $string = '';

    // Add characters to string.
    for ( $i = 0; $i < $length; $i++ ) {
        $string .= $characters[mt_rand( 0, strlen( $characters ) - 1 )];
    }

    // Add prefix (if any).
    $string = cannabiz_rewards_card_coupon_prefix() . $string;

    // Filter string.
    $string = apply_filters( 'cannabiz_get_random_string', $string );

    return $string;
}

/**
 * Check to see if the Rewards Card is activated.
 *
 * @return string|bool
 */
function cannabiz_rewards_card_activate() {
    $card   = get_option( 'cannabiz_rewards_card' );
    $active = false;

    if ( isset( $card['cannabiz_rewards_card_activate'] ) && '' !== $card['cannabiz_rewards_card_activate'] ) {
        $active = $card['cannabiz_rewards_card_activate'];
    }

    return apply_filters( 'cannabiz_rewards_card_activate', $active );
}

/**
 * Get the rewards card title
 *
 * @return string|bool
 */
function cannabiz_rewards_card_title() {
    $card  = get_option( 'cannabiz_rewards_card' );
    $title = esc_attr__( 'You earned a reward', 'customer-loyalty-for-woocommerce' );

    if ( isset( $card['cannabiz_rewards_card_title'] ) && '' !== $card['cannabiz_rewards_card_title'] ) {
        $title = $card['cannabiz_rewards_card_title'];
    }

    return apply_filters( 'cannabiz_helper_rewards_card_title', $title );
}

/**
 * Get the rewards card text
 *
 * @return string|bool
 */
function cannabiz_rewards_card_text() {
    $card = get_option( 'cannabiz_rewards_card' );
    $text = false;

    if ( isset( $card['cannabiz_rewards_card_text'] ) && '' !== $card['cannabiz_rewards_card_text'] ) {
        $text = $card['cannabiz_rewards_card_text'];
    }

    return apply_filters( 'cannabiz_helper_rewards_card_text', $text );
}

/**
 * Get the rewards card image
 *
 * @return string|bool
 */
function cannabiz_rewards_card_image() {
    $card  = get_option( 'cannabiz_rewards_card' );
    $image = false;

    if ( isset( $card['cannabiz_rewards_card_image'] ) && '' !== $card['cannabiz_rewards_card_image'] ) {
        $image = $card['cannabiz_rewards_card_image'];
    }

    return apply_filters( 'cannabiz_helper_rewards_card_image', $image );
}

/**
 * Get the rewards card required punches
 *
 * @return string|bool
 */
function cannabiz_rewards_card_required_punches() {
    $card    = get_option( 'cannabiz_rewards_card' );
    $punches = false;

    if ( isset( $card['cannabiz_rewards_card_required_punches'] ) && '' !== $card['cannabiz_rewards_card_required_punches'] ) {
        $punches = $card['cannabiz_rewards_card_required_punches'];
    }

    return apply_filters( 'cannabiz_rewards_card_required_punches', $punches );
}

/**
 * Get the rewards card coupon amount
 *
 * @return string|bool
 */
function cannabiz_rewards_card_coupon_amount() {
    $card   = get_option( 'cannabiz_rewards_card' );
    $amount = false;

    if ( isset( $card['cannabiz_rewards_card_coupon_amount'] ) && '' !== $card['cannabiz_rewards_card_coupon_amount'] ) {
        $amount = $card['cannabiz_rewards_card_coupon_amount'];
    }

    return apply_filters( 'cannabiz_rewards_card_coupon_amount', $amount );
}

/**
 * Get the rewards card coupon type
 *
 * @return string|bool
 */
function cannabiz_rewards_card_coupon_type() {
    $card        = get_option( 'cannabiz_rewards_card' );
    $coupon_type = false;

    if ( isset( $card['cannabiz_rewards_card_coupon_type'] ) && '' !== $card['cannabiz_rewards_card_coupon_type'] ) {
        $coupon_type = $card['cannabiz_rewards_card_coupon_type'];
    }

    return apply_filters( 'cannabiz_rewards_card_coupon_type', $coupon_type );
}

/**
 * Get the rewards card coupon prefix
 *
 * @return string|bool
 */
function cannabiz_rewards_card_coupon_prefix() {
    $card   = get_option( 'cannabiz_rewards_card' );
    $prefix = false;

    if ( isset( $card['cannabiz_rewards_card_coupon_prefix'] ) && '' !== $card['cannabiz_rewards_card_coupon_prefix'] ) {
        $prefix = $card['cannabiz_rewards_card_coupon_prefix'];
    }

    return apply_filters( 'cannabiz_rewards_card_coupon_prefix', $prefix );
}

/**
 * Check to see if Loyalty Points is activated.
 *
 * @return string|bool
 */
function cannabiz_loyalty_points_activate() {
    $points = get_option( 'cannabiz_loyalty_points' );
    $active = false;

    if ( isset( $points['cannabiz_loyalty_points_activate'] ) && '' !== $points['cannabiz_loyalty_points_activate'] ) {
        $active = $points['cannabiz_loyalty_points_activate'];
    }

    return apply_filters( 'cannabiz_loyalty_points_activate', $active );
}

/**
 * Get the loyalty points redeem points calculation type.
 *
 * @return string|bool
 */
function cannabiz_loyalty_points_redeem_points_calculation_type() {
    $points = get_option( 'cannabiz_loyalty_points' );
    $type   = false;

    if ( isset( $points['cannabiz_loyalty_points_redeem_points_calculation_type'] ) && '' !== $points['cannabiz_loyalty_points_redeem_points_calculation_type'] ) {
        $type = $points['cannabiz_loyalty_points_redeem_points_calculation_type'];
    }

    return apply_filters( 'cannabiz_loyalty_points_redeem_points_calculation_type', $type );
}

/**
 * Get the loyalty points redeem points minimum.
 *
 * @return string|bool
 */
function cannabiz_loyalty_points_redeem_points_minimum() {
    $points  = get_option( 'cannabiz_loyalty_points' );
    $minimum = false;

    if ( isset( $points['cannabiz_loyalty_points_redeem_points_minimum'] ) && '' !== $points['cannabiz_loyalty_points_redeem_points_minimum'] ) {
        $minimum = $points['cannabiz_loyalty_points_redeem_points_minimum'];
    }

    return apply_filters( 'cannabiz_loyalty_points_redeem_points_minimum', $minimum );
}

/**
 * Get the loyalty points redeem points value.
 *
 * @return string|bool
 */
function cannabiz_loyalty_points_redeem_points_value() {
    $points = get_option( 'cannabiz_loyalty_points' );
    $value  = false;

    if ( isset( $points['cannabiz_loyalty_points_redeem_points_value'] ) && '' !== $points['cannabiz_loyalty_points_redeem_points_value'] ) {
        $value = $points['cannabiz_loyalty_points_redeem_points_value'];
    }

    return apply_filters( 'cannabiz_loyalty_points_redeem_points_value', $value );
}

/**
 * Get the earning points customer registration.
 *
 * @return string|bool
 */
function cannabiz_earning_points_customer_registration() {
    $points       = get_option( 'cannabiz_loyalty_points' );
    $registration = 0;

    if ( isset( $points['cannabiz_earning_points_customer_registration'] ) && '' !== $points['cannabiz_earning_points_customer_registration'] ) {
        $registration = $points['cannabiz_earning_points_customer_registration'];
    }

    return apply_filters( 'cannabiz_earning_points_customer_registration', $registration );
}

/**
 * Get the earning points order complete.
 *
 * @return string|bool
 */
function cannabiz_earning_points_order_complete() {
    $points   = get_option( 'cannabiz_loyalty_points' );
    $complete = 0;

    if ( isset( $points['cannabiz_earning_points_order_complete'] ) && '' !== $points['cannabiz_earning_points_order_complete'] ) {
        $complete = $points['cannabiz_earning_points_order_complete'];
    }

    return apply_filters( 'cannabiz_earning_points_order_complete', $complete );
}

/**
 * Get the earning points money spent.
 *
 * @return string|bool
 */
function cannabiz_earning_points_money_spent() {
    $points      = get_option( 'cannabiz_loyalty_points' );
    $money_spent = 0;

    if ( isset( $points['cannabiz_earning_points_money_spent'] ) && '' !== $points['cannabiz_earning_points_money_spent'] ) {
        $money_spent = $points['cannabiz_earning_points_money_spent'];
    }

    return apply_filters( 'cannabiz_earning_points_money_spent', $money_spent );
}
