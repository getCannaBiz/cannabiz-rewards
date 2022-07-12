<?php
/**
 * Customer Loyalty for WooCommerce - Admin Settings
 * 
 * @package    CannaBiz_Rewards
 * @subpackage CannaBiz_Rewards/admin
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
 * Actions/Filters
 *
 * Related to all settings API.
 *
 * @since 1.0.0
 */
if ( class_exists( 'CannaBiz_Rewards_OSA' ) ) {
    /**
     * Function Name
     * 
     * @return string
     */
    function cannabiz_rewards_initialize_admin_settings() {
        /**
         * Object Instantiation.
         *
         * Object for the class `CannaBiz_Rewards_OSA`.
         */
        $cannabiz_obj = new CannaBiz_Rewards_OSA();

        // Section: Rewards Card.
        $cannabiz_obj->add_section(
            array(
                'id'    => 'cannabiz_rewards_card',
                'title' => esc_attr__( 'Rewards Card', 'cannabiz-rewards' ),
            )
        );

        // Section: Loyalty Points.
        $cannabiz_obj->add_section(
            array(
                'id'    => 'cannabiz_loyalty_points',
                'title' => esc_attr__( 'Loyalty Points', 'cannabiz-rewards' ),
            )
        );

        // Field: Title.
        $cannabiz_obj->add_field(
            'cannabiz_rewards_card',
            array(
                'id'   => 'cannabiz_reward_settings_title',
                'type' => 'title',
                'name' => '<h1>' . esc_attr__( 'Rewards Card', 'cannabiz-rewards' ) . '</h1>',
            )
        );

        // Field: Checkbox.
        $cannabiz_obj->add_field(
            'cannabiz_rewards_card',
            array(
                'id'   => 'cannabiz_rewards_card_activate',
                'type' => 'checkbox',
                'name' => esc_attr__( 'Activate Rewards Card', 'cannabiz-rewards' ),
                'desc' => esc_attr__( 'Check to activate the included customer rewards card features.', 'cannabiz-rewards' ),
            )
        );

        // Field: Text.
        $cannabiz_obj->add_field(
            'cannabiz_rewards_card',
            array(
                'id'      => 'cannabiz_rewards_card_title',
                'type'    => 'text',
                'name'    => esc_attr__( 'Rewards Card Title', 'cannabiz-rewards' ),
                'desc'    => esc_attr__( 'The title displayed in a customer\'s order when a new reward is earned.', 'cannabiz-rewards' ),
                'default' => 'You earned a reward',
            )
        );

        // Field: Textarea.
        $cannabiz_obj->add_field(
            'cannabiz_rewards_card',
            array(
                'id'      => 'cannabiz_rewards_card_text',
                'type'    => 'textarea',
                'name'    => esc_attr__( 'Rewards Card Text', 'cannabiz-rewards' ),
                'desc'    => esc_attr__( 'The text displayed in a customer\'s order when a new reward is earned.', 'cannabiz-rewards' ),
                'default' => '',
            )
        );

        // Field: Image.
        $cannabiz_obj->add_field(
            'cannabiz_rewards_card',
            array(
                'id'      => 'cannabiz_rewards_card_image',
                'type'    => 'image',
                'name'    => esc_attr__( 'Rewards Card Image', 'cannabiz-rewards' ),
                'desc'    => esc_attr__( 'Display an image in the customer\'s order when a new reward is earned.', 'cannabiz-rewards' ),
                'options' => array(
                    'button_label' => esc_attr__( 'Choose Image', 'cannabiz-rewards' ),
                ),
            )
        );

        // Field: Title.
        $cannabiz_obj->add_field(
            'cannabiz_rewards_card',
            array(
                'id'   => 'cannabiz_rewards_card_coupon_settings_title',
                'type' => 'title',
                'name' => '<h1>' . esc_attr__( 'Rewards coupon', 'cannabiz-rewards' ) . '</h1>',
            )
        );

        // Field: Rewards Card - Required punches.
        $cannabiz_obj->add_field(
            'cannabiz_rewards_card',
            array(
                'id'                => 'cannabiz_rewards_card_required_punches',
                'type'              => 'number',
                'name'              => esc_attr__( 'Required punches', 'cannabiz-rewards' ),
                'desc'              => esc_attr__( 'How many punches are required before a coupon is created for the customer?', 'cannabiz-rewards' ),
                'default'           => 10,
                'sanitize_callback' => 'intval',
            )
        );

        // Field: Rewards Card - Coupon amount.
        $cannabiz_obj->add_field(
            'cannabiz_rewards_card',
            array(
                'id'                => 'cannabiz_rewards_card_coupon_amount',
                'type'              => 'number',
                'name'              => esc_attr__( 'Coupon amount', 'cannabiz-rewards' ),
                'desc'              => esc_attr__( 'Enter the amount you would like used when creating the coupon.', 'cannabiz-rewards' ),
                'default'           => 0,
                'sanitize_callback' => 'intval',
            )
        );

        // Field: Rewards Card - Coupon type.
        $cannabiz_obj->add_field(
            'cannabiz_rewards_card',
            array(
                'id'      => 'cannabiz_rewards_card_coupon_type',
                'type'    => 'select',
                'name'    => esc_attr__( 'Coupon type', 'cannabiz-rewards' ),
                'desc'    => esc_attr__( 'Select the type of coupon that you would like created for the customer', 'cannabiz-rewards' ),
                'options' => array(
                    'fixed_cart' => esc_attr__( 'Fixed cart', 'cannabiz-rewards' ),
                    'percent'    => esc_attr__( 'Percentage', 'cannabiz-rewards' ),
                ),
            )
        );

        // Field: Rewards Card - Coupon prefix.
        $cannabiz_obj->add_field(
            'cannabiz_rewards_card',
            array(
                'id'      => 'cannabiz_rewards_card_coupon_prefix',
                'type'    => 'text',
                'name'    => esc_attr__( 'Coupon prefix', 'cannabiz-rewards' ),
                'desc'    => esc_attr__( 'Add the text you would like included before the randomize coupon code', 'cannabiz-rewards' ),
                'default' => 'CBIZ',
            )
        );

        // Field: Title - Loyalty Points.
        $cannabiz_obj->add_field(
            'cannabiz_loyalty_points',
            array(
                'id'   => 'cannabiz_loyalty_points_settings_title',
                'type' => 'title',
                'name' => '<h1>' . esc_attr__( 'Loyalty Points', 'cannabiz-rewards' ) . '</h1>',
            )
        );

        // Field: Checkbox.
        $cannabiz_obj->add_field(
            'cannabiz_loyalty_points',
            array(
                'id'   => 'cannabiz_loyalty_points_activate',
                'type' => 'checkbox',
                'name' => esc_attr__( 'Activate Loyalty Points', 'cannabiz-rewards' ),
                'desc' => esc_attr__( 'Check to activate the included customer loyalty points features.', 'cannabiz-rewards' ),
            )
        );

        // Field: Loyalty Points - Calculation type.
        $cannabiz_obj->add_field(
            'cannabiz_loyalty_points',
            array(
                'id'      => 'cannabiz_loyalty_points_redeem_points_calculation_type',
                'type'    => 'select',
                'name'    => esc_attr__( 'Calculation type', 'cannabiz-rewards' ),
                'desc'    => esc_attr__( 'Should the points be calculated from the order total or subtotal?', 'cannabiz-rewards' ),
                'options' => array(
                    'total'   => esc_attr__( 'Order total', 'cannabiz-rewards' ),
                    'subotal' => esc_attr__( 'Order subtotal', 'cannabiz-rewards' ),
                ),
            )
        );

        // Field: Title.
        $cannabiz_obj->add_field(
            'cannabiz_loyalty_points',
            array(
                'id'   => 'cannabiz_loyalty_points_redeem_points_settings_title',
                'type' => 'title',
                'name' => '<h1>' . esc_attr__( 'Redeeming Points', 'cannabiz-rewards' ) . '</h1>',
            )
        );

        // Field: Loyalty Points - Redeem points.
        $cannabiz_obj->add_field(
            'cannabiz_loyalty_points',
            array(
                'id'                => 'cannabiz_loyalty_points_redeem_points_minimum',
                'type'              => 'number',
                'name'              => esc_attr__( 'Minimum points', 'cannabiz-rewards' ),
                'desc'              => esc_attr__( 'How many points are required before a customer can redeem points?', 'cannabiz-rewards' ),
                'default'           => 10,
                'sanitize_callback' => 'intval',
            )
        );

        // Field: Loyalty Points - Redeem points value.
        $cannabiz_obj->add_field(
            'cannabiz_loyalty_points',
            array(
                'id'                => 'cannabiz_loyalty_points_redeem_points_value',
                'type'              => 'number',
                'name'              => esc_attr__( 'Redeemable value', 'cannabiz-rewards' ),
                'desc'              => esc_attr__( 'How much should the redeemed points be worth in actual currency?', 'cannabiz-rewards' ),
                'default'           => 10,
                'sanitize_callback' => 'intval',
            )
        );

        // Field: Title.
        $cannabiz_obj->add_field(
            'cannabiz_loyalty_points',
            array(
                'id'   => 'cannabiz_earning_points_settings_title',
                'type' => 'title',
                'name' => '<h1>' . esc_attr__( 'Earning Points', 'cannabiz-rewards' ) . '</h1>',
            )
        );

        // Field: Earning Points - Customer registration.
        $cannabiz_obj->add_field(
            'cannabiz_loyalty_points',
            array(
                'id'                => 'cannabiz_earning_points_customer_registration',
                'type'              => 'number',
                'name'              => esc_attr__( 'Customer registration', 'cannabiz-rewards' ),
                'desc'              => esc_attr__( 'The amount of points a customer earns when they register an account.', 'cannabiz-rewards' ),
                'default'           => 0,
                'sanitize_callback' => 'intval',
            )
        );

        // Field: Earning Points - Order Complete.
        $cannabiz_obj->add_field(
            'cannabiz_loyalty_points',
            array(
                'id'                => 'cannabiz_earning_points_order_complete',
                'type'              => 'number',
                'name'              => esc_attr__( 'Order complete', 'cannabiz-rewards' ),
                'desc'              => esc_attr__( 'The amount of points a customer earns when completing an order.', 'cannabiz-rewards' ),
                'default'           => 0,
                'sanitize_callback' => 'intval',
            )
        );

        // Field: Earning Points - Money spent.
        $cannabiz_obj->add_field(
            'cannabiz_loyalty_points',
            array(
                'id'                => 'cannabiz_earning_points_money_spent',
                'type'              => 'number',
                'name'              => esc_attr__( 'Money spent', 'cannabiz-rewards' ),
                'desc'              => esc_attr__( 'The amount of points a customer earns per dollar spent.', 'cannabiz-rewards' ),
                'default'           => 1,
                'sanitize_callback' => 'intval',
            )
        );
    }
}
add_action( 'init', 'cannabiz_rewards_initialize_admin_settings', 100 );
