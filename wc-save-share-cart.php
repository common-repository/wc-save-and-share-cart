<?php
/**
* Plugin Name: Save and Share Cart for WooCommerce
* Description: This plugin allows create Save and Share Cart plugin.
* Version: 1.0
* Copyright: 2020
* Text Domain: wc-save-and-share-cart
* Domain Path: /languages 
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
  die('-1');
}
if (!defined('WOOSASC_PLUGIN_NAME')) {
  define('WOOSASC_PLUGIN_NAME', 'Save and Share Cart for WooCommerce');
}
if (!defined('WOOSASC_PLUGIN_VERSION')) {
  define('WOOSASC_PLUGIN_VERSION', '1.0');
}
if (!defined('WOOSASC_PLUGIN_FILE')) {
  define('WOOSASC_PLUGIN_FILE', __FILE__);
}
if (!defined('WOOSASC_PLUGIN_DIR')) {
  define('WOOSASC_PLUGIN_DIR',plugins_url('', __FILE__));
}
if (!defined('WOOSASC_BASE_NAME')) {
    define('WOOSASC_BASE_NAME', plugin_basename(WOOSASC_PLUGIN_FILE));
}
if (!defined('WOOSASC_DOMAIN')) {
  define('WOOSASC_DOMAIN', 'wc-save-and-share-cart');
}


if (!class_exists('WOOSASC')) {

    class WOOSASC {

        protected static $WOOSASC_instance;
        function __construct() {
            include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
            //check woocommerce plugin activted or not
            add_action('admin_init', array($this, 'WOOSASC_check_plugin_state'));
        }


        function WOOSASC_check_plugin_state(){
            if ( ! ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) ) {
                set_transient( get_current_user_id() . 'woosascerror', 'message' );
            }
        }


        function init() {
            add_action( 'admin_notices', array($this, 'WOOSASC_show_notice'));
            add_action( 'admin_enqueue_scripts', array($this, 'WOOSASC_load_admin'));
            add_action( 'wp_enqueue_scripts',  array($this, 'WOOSASC_load_front'));
            add_filter( 'wp_mail_content_type', array($this, 'WOOSASC_email_set_content_type' ));
            add_filter( 'plugin_row_meta', array( $this, 'WOOSASC_plugin_row_meta' ), 10, 2 );
        }


        function WOOSASC_show_notice() {
            if ( get_transient( get_current_user_id() . 'woosascerror' ) ) {

                deactivate_plugins( plugin_basename( __FILE__ ) );

                delete_transient( get_current_user_id() . 'woosascerror' );

                echo '<div class="error"><p> This plugin is deactivated because it require <a href="plugin-install.php?tab=search&s=woocommerce">WooCommerce</a> plugin installed and activated.</p></div>';
            }
        }


        function WOOSASC_load_admin() {
            wp_enqueue_style( 'WOOSASC_admin_style', WOOSASC_PLUGIN_DIR . '/includes/css/woosasc_back_style.css', false, '1.0.0' );
            wp_enqueue_style( 'wp-color-picker' );
            wp_enqueue_script( 'wp-color-picker-alpha', WOOSASC_PLUGIN_DIR . '/includes/js/wp-color-picker-alpha.js', array( 'wp-color-picker' ), '1.0.0', true );
        }


        function WOOSASC_load_front() {
            wp_enqueue_style( 'WOOSASC_front_style', WOOSASC_PLUGIN_DIR . '/includes/css/woosasc_front_style.css', false, '1.0.0' );
            wp_enqueue_style( 'WOOSASC_front_fa_css', WOOSASC_PLUGIN_DIR . '/includes/css/font-awesome.min.css', false, '1.0.0' );
            wp_enqueue_style( 'WOOSASC_front_fa_css' );
            wp_enqueue_script( 'WOOSASC_admin_script', WOOSASC_PLUGIN_DIR . '/includes/js/woosasc_front_script.js', false, '1.0.0' );
            $translation_array_img = WOOSASC_PLUGIN_DIR;
            wp_localize_script( 'WOOSASC_admin_script', 'woosasc_js_data', array(
                                                           'ajax_url' => admin_url('admin-ajax.php'),
                                                           'woosasc_loader' => $translation_array_img 
            ) );
        }


        function WOOSASC_email_set_content_type(){
            return "text/html";
        }
        

        function includes() {
            include_once('admin/woosasc_admin_settings.php');           
            include_once('admin/woosasc_kit.php');
            include_once('admin/woosasc_svg.php');       
            include_once('front/woosasc_front_cart.php');
        }

        function WOOSASC_plugin_row_meta( $links, $file ) {
            if ( WOOSASC_BASE_NAME === $file ) {
                $row_meta = array(
                  'rating'    =>  ' <a href="https://www.xeeshop.com/save-and-share-cart-for-woocommerce/" target="_blank">Documentation</a> | <a href="https://www.xeeshop.com/support-us/?utm_source=aj_plugin&utm_medium=plugin_support&utm_campaign=aj_support&utm_content=aj_wordpress" target="_blank">Support</a> | <a href="https://wordpress.org/support/plugin/wc-save-and-share-cart/reviews/?filter=5" target="_blank"><img src="'.WOOSASC_PLUGIN_DIR.'/images/star.png" class="woosasc_rating_div"></a>',
                );

                return array_merge( $links, $row_meta );
            }
            return (array) $links;
        }

        //Flush rewrite rules update permalinks
        public static function WOOSASC_do_activation() {
          	flush_rewrite_rules();
        }


        public static function WOOSASC_instance() {
            if (!isset(self::$WOOSASC_instance)) {
                self::$WOOSASC_instance = new self();
                self::$WOOSASC_instance->init();
                self::$WOOSASC_instance->includes();
            }
            return self::$WOOSASC_instance;
        }
    }
    add_action('plugins_loaded', array('WOOSASC', 'WOOSASC_instance'));

    register_activation_hook( WOOSASC_PLUGIN_FILE, array('WOOSASC', 'WOOSASC_do_activation'));
}


add_action( 'plugins_loaded', 'woosasc_load_textdomain' );
function woosasc_load_textdomain() {
    load_plugin_textdomain( 'wc-save-and-share-cart', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
}

function woosasc_load_my_own_textdomain( $mofile, $domain ) {
    if ( 'wc-save-and-share-cart' === $domain && false !== strpos( $mofile, WP_LANG_DIR . '/plugins/' ) ) {
        $locale = apply_filters( 'plugin_locale', determine_locale(), $domain );
        $mofile = WP_PLUGIN_DIR . '/' . dirname( plugin_basename( __FILE__ ) ) . '/languages/' . $domain . '-' . $locale . '.mo';
    }
    return $mofile;
}
add_filter( 'load_textdomain_mofile', 'woosasc_load_my_own_textdomain', 10, 2 );