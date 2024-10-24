<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @package    CannaBiz_Rewards
 * @subpackage CannaBiz_Rewards/admin
 * @author     CannaBiz Software <contact@cannabizsoftware.com>
 * @license    GPL-2.0+ http://www.gnu.org/licenses/gpl-2.0.txt
 * @link       https://cannabizsoftware.com
 * @since      1.0.0
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    wp_die();
}

/**
 * Add 1 to the users 'rewards earned' count
 *
 * @param int $order_id 
 * @param int $user_id 
 *
 * @since  1.0.0
 * @return void
 */
function cannabiz_customer_update_rewards_earned( $order_id, $user_id ) {
    // Check settings before adding any points.
    if ( 'on' == cannabiz_rewards_card_activate() ) {
        // Get rewards earned.
        $rewards_earned = get_user_meta( $user_id, 'cannabiz_rewards_earned', true );

        // Set to zero if customer has no earned rewards.
        if ( ! $rewards_earned ) {
            $rewards_earned = 0;
        }

        // Add one to the rewards earned count.
        $rewards_new = $rewards_earned + 1;

        // Set order meta name with current order ID.
        $order_meta = 'cannabiz_rewards_earned_' . $order_id;

        // Check that the user has not already viwed this order success page.
        if ( ! get_user_meta( $user_id, $order_meta, true ) ) {

            // Add reward count for this order.
            add_user_meta( $user_id, $order_meta, 1, true );

            // Check customer rewards punch count against the required punches.
            if ( $rewards_new >= cannabiz_rewards_card_required_punches() ) {
                // Add the new rewards count (old count + one).
                update_user_meta( $user_id, 'cannabiz_rewards_earned', 0, $rewards_earned );
            }

        }
    }
}
add_action( 'wpd_ecommerce_checkout_success_after', 'cannabiz_customer_update_rewards_earned', 10, 2 );

/**
 * init
 * 
 * @return string
 */
function the_name() {
    // Get rewards earned.
    $rewards_earned  = get_user_meta( 1, 'cannabiz_rewards_earned', true );
    $rewards_punches = get_user_meta( 1, 'cannabiz_rewards_card_punches', true );

    echo '<pre>';
    var_dump( $rewards_earned );
    echo '</pre>';

    echo '<pre>';
    var_dump( $rewards_punches );
    echo '</pre>';

    echo '<pre>';
    var_dump( cannabiz_rewards_card_required_punches() );
    echo '</pre>';
}
//add_action( 'init', 'the_name' );
