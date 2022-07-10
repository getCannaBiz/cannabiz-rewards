<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @package    CannaBiz_Rewards
 * @subpackage CannaBiz_Rewards/admin
 * @author     CannaBiz Software <hello@cannabiz.pro>
 * @license    GPL-2.0+ http://www.gnu.org/licenses/gpl-2.0.txt
 * @link       https://cannabiz.pro
 * @since      1.0.0
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    CannaBiz_Rewards
 * @subpackage CannaBiz_Rewards/admin
 * @author     CannaBiz Software <hello@cannabiz.pro>
 * @license    GPL-2.0+ http://www.gnu.org/licenses/gpl-2.0.txt
 * @link       https://cannabiz.pro
 * @since      1.0.0
 */
class CannaBiz_Rewards_Public {

    /**
     * The ID of this plugin.
     *
     * @since  1.0.0
     * @access private
     * @var    string  $_plugin_name - The ID of this plugin.
     */
    private $_plugin_name;

    /**
     * The version of this plugin.
     *
     * @since  1.0.0
     * @access private
     * @var    string  $_version - The current version of this plugin.
     */
    private $_version;

    /**
     * Initialize the class and set its properties.
     *
     * @param string $_plugin_name - The name of the plugin.
     * @param string $_version     - The version of this plugin.
     * 
     * @since 1.0.0
     */
    public function __construct( $_plugin_name, $_version ) {

        $this->plugin_name = $_plugin_name;
        $this->version = $_version;

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since  1.0.0
     * @return void
     */
    public function enqueue_styles() {
        // CSS - Public.
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cannabiz-rewards-public.css', array(), $this->version, 'all' );
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since  1.0.0
     * @return void
     */
    public function enqueue_scripts() {
        // JS - Public.
        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/cannabiz-rewards-public.js', array( 'jquery' ), $this->version, false );

    }

}
