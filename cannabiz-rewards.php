<?php

/**
 * The plugin bootstrap file
 *
 * @link              https://cannabiz.pro
 * @since             1.0.0
 * @package           CannaBiz_Rewards
 *
 * @wordpress-plugin
 * Plugin Name:       CannaBiz Rewards
 * Plugin URI:        https://cannabiz.pro/features/dispensary-loyalty-and-rewards/
 * Description:       Dispensary loyalty and rewards program
 * Version:           1.0.0
 * Author:            CannaBiz
 * Author URI:        https://cannabiz.pro
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cannabiz-rewards
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Current plugin version.
define( 'CANNABIZ_REWARDS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-cannabiz-rewards-activator.php
 */
function activate_cannabiz_rewards() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-cannabiz-rewards-activator.php';
	CannaBiz_Rewards_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-cannabiz-rewards-deactivator.php
 */
function deactivate_cannabiz_rewards() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-cannabiz-rewards-deactivator.php';
	CannaBiz_Rewards_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_cannabiz_rewards' );
register_deactivation_hook( __FILE__, 'deactivate_cannabiz_rewards' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-cannabiz-rewards.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_cannabiz_rewards() {

	$plugin = new CannaBiz_Rewards();
	$plugin->run();

}
run_cannabiz_rewards();

/**
 * Add Settings link on plugin page
 *
 * @since  1.0.0
 * @param  array $links an array of links related to the plugin.
 * @return array updatead array of links related to the plugin.
 */
function cannabiz_rewards_settings_link( $links ) {
	// Get Settings link.
	$settings_link = '<a href="admin.php?page=cannabiz-rewards">' . esc_attr__( 'Settings', 'cannabiz-rewards' ) . '</a>';
	// Add Settings link.
	array_unshift( $links, $settings_link );

	return $links;
}

$pluginname = plugin_basename( __FILE__ );

add_filter( "plugin_action_links_$pluginname", 'cannabiz_rewards_settings_link' );
