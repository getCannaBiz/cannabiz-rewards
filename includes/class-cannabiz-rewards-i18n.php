<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @package    CannaBiz_Rewards
 * @subpackage CannaBiz_Rewards/includes
 * @author     CannaBiz Software <hello@cannabiz.pro>
 * @license    GPL-2.0+ http://www.gnu.org/licenses/gpl-2.0.txt
 * @link       https://www.deviodigital.com
 * @since      1.0.0
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @package    CannaBiz_Rewards
 * @subpackage CannaBiz_Rewards/includes
 * @author     CannaBiz Software <hello@cannabiz.pro>
 * @license    GPL-2.0+ http://www.gnu.org/licenses/gpl-2.0.txt
 * @link       https://www.deviodigital.com
 * @since      1.0.0
 */
class CannaBiz_Rewards_i18n {


    /**
     * Load the plugin text domain for translation.
     *
     * @since  1.0.0
     * @return void
     */
    public function load_plugin_textdomain() {

        load_plugin_textdomain(
            'cannabiz-rewards',
            false,
            dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
        );

    }



}
