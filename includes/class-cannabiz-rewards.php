<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @package    CannaBiz_Rewards
 * @subpackage CannaBiz_Rewards/includes
 * @author     CannaBiz Software <hello@cannabiz.pro>
 * @license    GPL-2.0+ http://www.gnu.org/licenses/gpl-2.0.txt
 * @link       https://cannabiz.pro
 * @since      1.0.0
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @package    CannaBiz_Rewards
 * @subpackage CannaBiz_Rewards/includes
 * @author     CannaBiz Software <hello@cannabiz.pro>
 * @license    GPL-2.0+ http://www.gnu.org/licenses/gpl-2.0.txt
 * @link       https://cannabiz.pro
 * @since      1.0.0
 */
class CannaBiz_Rewards {

    /**
     * The loader that's responsible for maintaining and registering 
     * all hooks that power the plugin.
     *
     * @since  1.0.0
     * @access protected
     * @var    CannaBiz_Rewards_Loader $loader - Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since  1.0.0
     * @access protected
     * @var    string    $plugin_name - The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     * 
     * @since  1.0.0
     * @access protected
     * @var    string    $version - The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since 1.0.0
     */
    public function __construct() {
        $this->plugin_name = 'cannabiz-rewards';
        $this->version     = '1.0.0';

        if ( defined( 'CANNABIZ_REWARDS_VERSION' ) ) {
            $this->version = CANNABIZ_REWARDS_VERSION;
        }

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();

    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - CannaBiz_Rewards_Loader. Orchestrates the hooks of the plugin.
     * - CannaBiz_Rewards_i18n. Defines internationalization functionality.
     * - CannaBiz_Rewards_Admin. Defines all hooks for the admin area.
     * - CannaBiz_Rewards_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since  1.0.0
     * @access private
     * @return void
     */
    private function load_dependencies() {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-cannabiz-rewards-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-cannabiz-rewards-i18n.php';

        /**
         * The file responsible for defining all helper functions used throughout
         * the plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/cannabiz-rewards-helper-functions.php';

        /**
         * The class responsible for defining all actions that occur in the 
         * admin area.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-cannabiz-rewards-admin.php';

        /**
         * The class responsible for defining the admin settings area.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-cannabiz-rewards-osa-settings.php';

        /**
         * The file responsible for defining all user fields.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/cannabiz-rewards-user-fields.php';

        /**
         * The file responsible for defining the ways that a customer can earn
         * loyalty points and rewards.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/cannabiz-rewards-earning-loyalty-points.php';

        /**
         * The class responsible for defining all actions that occur in the 
         * public-facing side of the site.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-cannabiz-rewards-public.php';

        $this->loader = new CannaBiz_Rewards_Loader();

    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the CannaBiz_Rewards_i18n class in order to set the domain and to 
     * register the hook with WordPress.
     *
     * @since  1.0.0
     * @access private
     * @return void
     */
    private function set_locale() {

        $plugin_i18n = new CannaBiz_Rewards_i18n();

        $this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since  1.0.0
     * @access private
     * @return void
     */
    private function define_admin_hooks() {

        $plugin_admin = new CannaBiz_Rewards_Admin( $this->get_plugin_name(), $this->get_version() );

        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since  1.0.0
     * @access private
     * @return void
     */
    private function define_public_hooks() {

        $plugin_public = new CannaBiz_Rewards_Public( $this->get_plugin_name(), $this->get_version() );

        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since  1.0.0
     * @return void
     */
    public function run() {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since  1.0.0
     * @return string The name of the plugin.
     */
    public function get_plugin_name() {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since  1.0.0
     * @return CannaBiz_Rewards_Loader - Orchestrates the hooks of the plugin.
     */
    public function get_loader() {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since  1.0.0
     * @return string The version number of the plugin.
     */
    public function get_version() {
        return $this->version;
    }

}
