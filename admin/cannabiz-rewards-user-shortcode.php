<?php
/**
 * The CannaBiz Rewards User Dashboard Shortcode.
 *
 * @package    CannaBiz_Rewards
 * @subpackage CannaBiz_Rewards/admin
 * @author     CannaBiz Software <hello@cannabiz.pro>
 * @license    GPL-2.0+ http://www.gnu.org/licenses/gpl-2.0.txt
 * @link       https://cannabiz.pro
 * @since      1.0.0
 */
function cannabiz_rewards_dashboard_shortcode() {

    // Set empty vars.
    $coupon_codes = '';

    // Check if user is logged in.
    if ( is_user_logged_in() ) {
        // Get the user ID.
        $user_id = get_current_user_id();

        // Get loyalty points.
        $loyalty_points = get_user_meta( $user_id, 'cannabiz_loyalty_points', true );

        // Set to zero if customer has no points.
        if ( ! $loyalty_points ) {
            $loyalty_points = 0;
        }

        // Redeemable points minimum.
        $redeem_points_min = cannabiz_loyalty_points_redeem_points_minimum();
        // Set empty variable.
        $redeem_points = '';

        // Set redeem points variable if availabe.
        if ( $redeem_points_min && $loyalty_points >= $redeem_points_min ) {
            // Create new coupon when user redeem's loyalty points.
            if ( isset( $_POST ) && null !== filter_input( INPUT_POST, 'cannabiz_redeem_points' ) ) {
                $coupon_code = cannabiz_get_random_string(); // Code.
                $amount      = cannabiz_loyalty_points_redeem_points_value(); // Amount.

                // Coupon args.
                $coupon_args = array(
                    'post_title'   => 'Redeemed: ' . $coupon_code,
                    'post_content' => '',
                    'post_status'  => 'publish',
                    'post_author'  => $user_id,
                    'post_type'    => 'coupons'
                );

                // Filter args.
                $coupon_args = apply_filters( 'cannabiz_redeem_points_coupon_args', $coupon_args, $coupon_code, $user_id );

                // Get newly create coupon's ID #
                $new_coupon_id = wp_insert_post( $coupon_args );

                // Add custom meta data to the newly created coupon.
                update_post_meta( $new_coupon_id, 'wpd_coupon_type', 'Flat Rate' );
                update_post_meta( $new_coupon_id, 'wpd_coupon_amount', $amount );
                update_post_meta( $new_coupon_id, 'wpd_coupon_code', $coupon_code );
                update_post_meta( $new_coupon_id, 'wpd_coupon_exp', '' );

                // Reduce required points from user's loyalty points.
                $new_loyalty_points = $loyalty_points - $redeem_points_min;

                // Update user meta with the updated loyalty points amount.
                update_user_meta( $user_id, 'cannabiz_loyalty_points', $new_loyalty_points, $loyalty_points );

                // Apply new coupon to the cart automatically.
                $_SESSION['wpd_ecommerce']->add_coupon( $coupon_code, $amount, 'fixed_cart', '' );

                // Redirect to cart when discount applied.
                wp_safe_redirect( apply_filters( 'cannabiz_redeem_points_redirect_url', wpd_ecommerce_cart_url() ) );
                //exit;
            }

            // Redeem loyalty points.
            $redeem_button = '<form class="cannabiz-rewards-redeem-points" name="cannabiz_redeem_loyalty_points" method="post">
            <input type="submit" class="button cannabiz-rewards-button" name="cannabiz_redeem_points" value="' . esc_attr__( 'Redeem', 'cannabiz-rewards' ) . '" />'
            . wp_nonce_field( 'cannabiz-rewards-redeem-points' ) . 
            '</form>';

            // Redeem loyalty points.
            $redeem_points = '<tr><td><strong>' . esc_attr__( 'Redeem Points', 'cannabiz-rewards' ) . '</strong></td><td>' . $redeem_button . '</td></tr>';
        }

        // Coupons args.
        $args = array(
            'posts_per_page'   => -1,
            'orderby'          => 'title',
            'order'            => 'asc',
            'post_type'        => 'coupons',
            'post_status'      => 'publish',
        );

        // Filter the coupons args.
        $args = apply_filters( 'cannabiz_customer_coupons_args', $args );

        // Get all coupons.
        $customer_coupons = get_posts( $args );

        // Loop through coupons.
        foreach ( $customer_coupons as $customer_coupon ) {
            if ( $user_id == $customer_coupon->post_author ) {

                /**
                 * @todo get rid of WooCommerce functionality and replace it with WPD functionality
                 */

                // Get coupon object.
                $coupon = new WC_Coupon( $customer_coupon->post_name );

                // Get coupon data.
                $coupon_data = array(
                    'id'          => $customer_coupon->ID,
                    'usage_limit' => ( ! empty( $customer_coupon->usage_limit ) ) ? $customer_coupon->usage_limit : null,
                    'usage_count' => (int) $customer_coupon->usage_count,
                    'amount'      => wc_format_decimal( $coupon->get_amount(), 2 ),
                );

                // How many uses are left for this coupon?
                $usage_left = $coupon_data['usage_limit'] - $coupon_data['usage_count'];

                // Set is_coupon_active var.
                if ( $usage_left > 0 ) {
                    $is_coupon_active = '<span class="cannabiz-rewards-available-coupon">' . esc_attr__( 'Available', 'cannabiz-rewards' ) . '</span>';
                    $coupon_class     = '';
                } else {
                    $is_coupon_active = '';
                    $coupon_class     = ' class="cannabiz-rewards-inactive-coupon" ';
                }

                $coupon_codes .= '<tr><td ' . $coupon_class . '><strong>' . $customer_coupon->post_title . '</strong> - ' . wc_price( $coupon_data['amount'] ) . '</td><td>' . $is_coupon_active . '</td></tr>';
            }
        }

        // Display lotalty points if activated in the admin settings.
        if ( 'on' == cannabiz_loyalty_points_activate() ) {
            // Table loyalty points.
            echo '<h4 class="cannabiz-rewards-loyalty-points">' . esc_attr__( 'My Loyalty Points', 'cannabiz-rewards' ) . '</h4>';

            do_action( 'cannabiz_customer_dashboard_loyalty_points_table_before' );

            echo '<table class="cannabiz-rewards-dashboard">';
            echo '<tbody>';

            do_action( 'cannabiz_customer_dashboard_loyalty_points_table_tbody_top' );

            echo '<tr><td><strong>' . esc_attr__( 'Loyalty Points', 'cannabiz-rewards' ) . '</strong></td><td>' . esc_attr( $loyalty_points ) . '</td></tr>';
            echo $redeem_points;

            do_action( 'cannabiz_customer_dashboard_loyalty_points_table_tbody_bottom' );

            echo '</tbody>';
            echo '</table>';

            do_action( 'cannabiz_customer_dashboard_loyalty_points_table_after' );

        }

        /**
         * @todo replace all WooCommerce functionality with WP Dispensary's eCommerce functionality
         */

        // Get all customer orders.
        $customer_orders = get_posts( array(
            'numberposts' => -1,
            'meta_key'    => '_customer_user',
            'meta_value'  => $user_id,
            'post_type'   => wc_get_order_types(),
            'post_status' => array_keys( wc_get_order_statuses() ),
        ) );

        /**
         * Add coupon codes to CannaBiz Rewards Dashboard
         * 
         * Checks to see if there's coupons created and added to a customer's order, then it
         * also checks to see if the coupon is active or not, and displays these details to the
         * customer in the Rewards Card table.
         */
        foreach ( $customer_orders as $cannabiz_order ) {
            // Get CannaBiz Rewards customer coupon code - if any.
            $coupon_added = get_post_meta( $cannabiz_order->ID, 'cannabiz_customer_coupon_code', true );

            // Add coupon code to output if it's active.
            if ( $coupon_added ) {

                // Get coupon data.
                $coupon = new WC_Coupon( $coupon_added );
                //$coupon_post = get_post( $coupon->get_id() );
                $coupon_data = array(
                    'id'          => $coupon->get_id(),
                    'usage_limit' => ( ! empty( $coupon->get_usage_limit() ) ) ? $coupon->get_usage_limit() : null,
                    'usage_count' => (int) $coupon->get_usage_count(),
                    'amount'      => wc_format_decimal( $coupon->get_amount(), 2 ),
                );
                
                // How many uses are left for this coupon?
                $usage_left = $coupon_data['usage_limit'] - $coupon_data['usage_count'];

                // Set is_coupon_active var.
                if ( $usage_left > 0 ) {
                    $is_coupon_active = '<span class="cannabiz-rewards-available-coupon">' . esc_attr__( 'Available', 'cannabiz-rewards' ) . '</span>';
                    $coupon_class     = '';
                } else {
                    $is_coupon_active = '';
                    $coupon_class     = ' class="cannabiz-rewards-inactive-coupon" ';
                }

                $coupon_codes .= '<tr><td ' . $coupon_class . '><strong>' . $coupon_added . '</strong> - ' . wc_price( $coupon_data['amount'] ) . '</td><td>' . $is_coupon_active . '</td></tr>';
            }
        }

        // Set message when no coupons are available.
        if ( '' == $coupon_codes ) {
            $coupon_codes .= '<tr><td class="cannabiz-rewards-no-coupons">' . apply_filters( 'cannabiz_no_coupons_message', esc_attr__( 'You do not have any coupons available', 'cannabiz-rewards' ) ) . '</td></tr>';
        }

        // Get rewards card punches.
        $rewards_card_punches = get_user_meta( $user_id, 'cannabiz_rewards_card_punches', true );

        // Set to zero if customer has no punches.
        if ( ! $rewards_card_punches ) {
            $rewards_card_punches = 0;
        }

        // Get rewards earned.
        $rewards_earned = get_user_meta( $user_id, 'cannabiz_rewards_earned', true );

        // Set to zero if customer has no earned rewards.
        if ( ! $rewards_earned ) {
            $rewards_earned = 0;
        }

        // Display rewards card if it's activated in admin settings.
        if ( 'on' == cannabiz_rewards_card_activate() ) {
            // Table rewards card.
            echo '<h4 class="cannabiz-rewards-rewards-card">' . esc_attr__( 'My Rewards Card', 'cannabiz-rewards' ) . '</h4>';

            do_action( 'cannabiz_customer_dashboard_rewards_card_table_before' );

            echo '<table class="cannabiz-rewards-dashboard rewards-card">';
            echo '<tbody>';

            do_action( 'cannabiz_customer_dashboard_rewards_card_table_tbody_top' );

            echo '<tr><td><strong>' . esc_attr__( 'Rewards Card Punches', 'cannabiz-rewards' ) . '</strong></td><td>' . esc_attr( $rewards_card_punches ) . '</td></tr>';
            echo '<tr><td><strong>' . esc_attr__( 'Rewards Earned', 'cannabiz-rewards' ) . '</strong></td><td>' . esc_attr( $rewards_earned ) . '</td></tr>';

            do_action( 'cannabiz_customer_dashboard_rewards_card_table_tbody_bottom' );

            echo '</tbody>';
            echo '</table>';

            do_action( 'cannabiz_customer_dashboard_rewards_card_table_after' );

        }

        // Display coupons if rewards card or loyalty points are active.
        if ( 'on' == cannabiz_rewards_card_activate() || 'on' == cannabiz_loyalty_points_activate() ) {
            // My coupons.
            echo '<h4 class="cannabiz-rewards-rewards-coupons">' . esc_attr__( 'My Coupons', 'cannabiz-rewards' ) . '</h4>';

            do_action( 'cannabiz_customer_dashboard_coupons_table_before' );

            echo '<table class="cannabiz-rewards-dashboard rewards-coupons">';
            echo '<tbody>';

            do_action( 'cannabiz_customer_dashboard_coupons_table_tbody_top' );

            echo $coupon_codes;

            do_action( 'cannabiz_customer_dashboard_coupons_table_tbody_bottom' );

            echo '</tbody>';
            echo '</table>';

            do_action( 'cannabiz_customer_dashboard_coupons_table_after' );

        }

    } else {
        // Display login form.
        apply_filters( 'cannabiz_customer_dashboard_login_form', wp_login_form() );
    }
}
add_shortcode( 'cannabiz_rewards_user_dashboard', 'cannabiz_rewards_dashboard_shortcode' );
