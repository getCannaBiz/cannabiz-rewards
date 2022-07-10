<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @package    CannaBiz_Rewards
 * @subpackage CannaBiz_Rewards/admin
 * @author     CannaBiz Software <hello@cannabiz.pro>
 * @license    GPL-2.0+ http://www.gnu.org/licenses/gpl-2.0.txt
 * @link       https://www.deviodigital.com
 * @since      1.0.0
 */

/**
 * Add Customer Loyalty profile options to Edit User screen
 * 
 * @param [type] $profileuser 
 * 
 * @since  1.0.0
 * @return string
 */
function cannabiz_add_customer_loyalty_profile_options( $profileuser ) {
    // Get user data.
    //$user = get_userdata( $profileuser->ID );
    ?>
        <h2><?php esc_attr_e( 'Loyalty and Rewards', 'cannabiz-rewards' ); ?></h2>

        <table class="form-table">
        <tr>
            <th scope="row"><?php esc_attr_e( 'Loyalty points', 'cannabiz-rewards' ); ?></th>
            <td>
                <input class="regular-text" type="number" name="cannabiz_loyalty_points" value="<?php echo esc_html( get_user_meta( $profileuser->ID, 'cannabiz_loyalty_points', true ) ); ?>" />
            </td>
        </tr>
        <tr>
            <th scope="row"><?php esc_attr_e( 'Rewards card punches', 'cannabiz-rewards' ); ?></th>
            <td>
                <input class="regular-text" type="number" name="cannabiz_rewards_card_punches" value="<?php echo esc_html( get_user_meta( $profileuser->ID, 'cannabiz_rewards_card_punches', true ) ); ?>" />
            </td>
        </tr>
        <tr>
            <th scope="row"><?php esc_attr_e( 'Rewards earned', 'cannabiz-rewards' ); ?></th>
            <td>
                <input class="regular-text" type="number" name="cannabiz_rewards_earned" value="<?php echo esc_html( get_user_meta( $profileuser->ID, 'cannabiz_rewards_earned', true ) ); ?>" />
            </td>
        </tr>
        </table>

    <?php
}
add_action( 'show_user_profile', 'cannabiz_add_customer_loyalty_profile_options' );
add_action( 'edit_user_profile', 'cannabiz_add_customer_loyalty_profile_options' );

/**
 * Save customer punch card punches.
 * 
 * @param int $user_id 
 * 
 * @since  1.0.0
 * @return void
 */
function cannabiz_save_custom_profile_fields( $user_id ) {

    // Get user.
    //$user = get_userdata( $user_id );

    // Update customer loyalty points.
    if ( isset( $_POST ) && null !== filter_input( INPUT_POST, 'cannabiz_loyalty_points' ) ) {
        update_user_meta( $user_id, 'cannabiz_loyalty_points', sanitize_text_field( filter_input( INPUT_POST, 'cannabiz_loyalty_points' ) ) );
    }

    // Update customer rewards card punches.
    if ( isset( $_POST ) && null !== filter_input( INPUT_POST, 'cannabiz_rewards_card_punches' ) ) {
        update_user_meta( $user_id, 'cannabiz_rewards_card_punches', sanitize_text_field( filter_input( INPUT_POST, 'cannabiz_rewards_card_punches' ) ) );
    }

    // Update customer card punches.
    if ( isset( $_POST ) && null !== filter_input( INPUT_POST, 'cannabiz_rewards_earned' ) ) {
        update_user_meta( $user_id, 'cannabiz_rewards_earned', sanitize_text_field( filter_input( INPUT_POST, 'cannabiz_rewards_earned' ) ) );
    }

}
add_action( 'personal_options_update', 'cannabiz_save_custom_profile_fields' );
add_action( 'edit_user_profile_update', 'cannabiz_save_custom_profile_fields' );
