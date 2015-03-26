<?php
/**
 * Admin class
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Mailchimp
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCMC' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCMC_Admin' ) ) {
	/**
	 * WooCommerce Mailchimp Admin
	 *
	 * @since 1.0.0
	 */
	class YITH_WCMC_Admin {
		/**
		 * Single instance of the class
		 *
		 * @var \YITH_WCMC_Admin
		 * @since 1.0.0
		 */
		protected static $instance;

		/**
		 * List of available tab for mailchimp panel
		 *
		 * @var array
		 * @access public
		 * @since 1.0.0
		 */
		public $available_tabs = array();

		/**
		 * Landing url
		 *
		 * @var string
		 * @since 1.0.0
		 */
		public $premium_landing_url = 'http://yithemes.com/themes/plugins/yith-woocommerce-mailchimp/';

		/**
		 * Returns single instance of the class
		 *
		 * @return \YITH_WCMC_Admin
		 * @since 1.0.0
		 */
		public static function get_instance(){
			if( is_null( self::$instance ) ){
				self::$instance = new self;
			}

			return self::$instance;
		}

		/* === REGISTER AND PRINT MAILCHIMP PANEL === */

		/**
		 * Constructor.
		 *
		 * @param array $details
		 * @return \YITH_WCMC_Admin
		 * @since 1.0.0
		 */
		public function __construct() {
			$this->available_tabs = apply_filters( 'yith_wcmc_available_admin_tabs', array(
				'integration' => __( 'Integration', 'yith-wcmc' ),
				'checkout' => __( 'Checkout', 'yith-wcmc' )
			) );

			// register wishlist panel
			add_action( 'admin_menu', array( $this, 'register_panel' ), 5 );
			add_action( 'woocommerce_admin_field_yith_wcmc_integration_status', array( $this, 'print_custom_yith_wcmc_integration_status' ) );

			// register plugin actions and row meta
			add_filter( 'plugin_action_links_' . plugin_basename( YITH_WCMC_DIR . 'init.php' ), array( $this, 'action_links' ) );

			// enqueue style
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
		}

		/**
		 * Get the premium landing uri
		 *
		 * @since   1.0.0
		 * @author  Andrea Grillo <andrea.grillo@yithemes.com>
		 * @return  string The premium landing link
		 */
		public function get_premium_landing_uri(){
			return defined( 'YITH_REFER_ID' ) ? $this->premium_landing_url . '?refer_id=' . YITH_REFER_ID : $this->premium_landing_url;
		}

		/**
		 * Enqueue scripts and stuffs
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function enqueue() {
			global $pagenow;
			$path = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? '/unminified' : '';
			$prefix = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? '' : '.min';

			if( $pagenow == 'admin.php' && isset( $_GET['page'] ) && 'yith_wcmc_panel' == $_GET['page'] ){
				wp_enqueue_style( 'yith-wcmc-admin', YITH_WCMC_URL . '/assets/css/admin/yith-wcmc.css' );
				wp_enqueue_script( 'yith-wcmc-admin', YITH_WCMC_URL . '/assets/js/admin' . $path . '/yith-wcmc' . $prefix . '.js', array( 'jquery', 'jquery-blockui' ), false, true );

				wp_localize_script( 'yith-wcmc-admin', 'yith_wcmc', array(
					'labels' => array(
						'update_list_button' => __( 'Update Lists', 'yith-wcmc' ),
						'update_group_button' => __( 'Update Groups', 'yith-wcmc' )
					),
					'actions' => array(
						'do_request_via_ajax_action' => 'do_request_via_ajax'
					),
					'ajax_request_nonce' => wp_create_nonce( 'yith_wcmc_ajax_request' )
				) );
			}
		}

		/**
		 * Register panel
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function register_panel() {
			$args = array(
				'create_menu_page' => true,
				'parent_slug'   => '',
				'page_title'    => __( 'Mailchimp', 'yith-wcmc' ),
				'menu_title'    => __( 'Mailchimp', 'yith-wcmc' ),
				'capability'    => 'manage_options',
				'parent'        => '',
				'parent_page'   => 'yit_plugin_panel',
				'page'          => 'yith_wcmc_panel',
				'admin-tabs'    => $this->available_tabs,
				'options-path'  => YITH_WCMC_DIR . 'plugin-options'
			);

			/* === Fixed: not updated theme  === */
			if( ! class_exists( 'YIT_Plugin_Panel_WooCommerce' ) ) {
				require_once( YITH_WCMC_DIR . 'plugin-fw/lib/yit-plugin-panel-wc.php' );
			}

			$this->_panel = new YIT_Plugin_Panel_WooCommerce( $args );
		}

		/**
		 * Output integration status filed
		 *
		 * @param $value array Array representing the field to print
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function print_custom_yith_wcmc_integration_status( $value ){
			$result = YITH_WCMC()->do_request( 'users/profile' );

			$user_id = isset( $result['id'] ) ? $result['id'] : false;
			$username = isset( $result['username'] ) ? $result['username'] : false;
			$name = isset( $result['name'] ) ? $result['name'] : false;
			$email = isset( $result['email'] ) ? $result['email'] : false;
			$avatar = isset( $result['avatar'] ) ? $result['avatar'] : false;

			include( YITH_WCMC_DIR . 'templates/admin/types/integration-status.php' );
		}

		/**
		 * Register plugins action links
		 *
		 * @param array $links Array of current links
		 *
		 * @return array
		 * @since 1.0.0
		 */
		public function action_links( $links ) {
			$plugin_links = array(
				'<a href="' . admin_url( 'admin.php?page=yith_wcmc_panel&tab=integration' ) . '">' . __( 'Settings', 'yith-wcmc' ) . '</a>'
			);

			/*
			if( ! defined( 'YITH_WCMC_PREMIUM_INIT' ) ){
				$plugin_links[] = '<a target="_blank" href="' . $this->get_premium_landing_uri() . '">' . __( 'Premium Version', 'yit' ) . '</a>';
			}
			*/

			return array_merge( $links, $plugin_links );
		}
	}
}

/**
 * Unique access to instance of YITH_WCMC_Admin class
 *
 * @return \YITH_WCMC_Admin
 * @since 1.0.0
 */
function YITH_WCMC_Admin(){
	return YITH_WCMC_Admin::get_instance();
}