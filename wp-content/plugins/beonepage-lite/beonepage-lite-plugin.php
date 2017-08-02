<?php
/*
Plugin Name: BeOnePage Lite Plugin
Description: This plugin is required for BeOnePage Lite theme.
Author:      BeTheme
Version:     1.0.0
Author URI:  http://betheme.me/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: beonepage
*/

class beOnePageLitePlugin {
    public static function init() {
        $class = __CLASS__;
		$plugin_file = basename( __FILE__ );
		$plugin_folder = basename( dirname( __FILE__ ) );
		$plugin_hook = "after_plugin_row_{$plugin_folder}/{$plugin_file}";

        new $class;
		add_action( $plugin_hook, array( 'beOnePageLitePlugin', 'beonepage_get_premium' ) );
    }

    public function __construct() {
		// Add Custom Menu plugin.
		if (!function_exists('array_column')) {
			require_once plugin_dir_path( __FILE__ ) . 'inc/custom-menu/array-column.php';
		}
		if ( ! class_exists( 'beonepage_Menu_Item_Custom_Fields' ) ) {
			require_once plugin_dir_path( __FILE__ ) . 'inc/custom-menu/menu-item-custom-field.php';
		}
		
		// Add Custom Post Type plugin.
		if( ! class_exists('CPT', false) ) {
			require_once plugin_dir_path( __FILE__ ) . 'inc/cpt/CPT.php';
			require_once plugin_dir_path( __FILE__ ) . 'inc/cpt/portfolio-post-type.php';
		}
		
		// Add Custom Meta Box 2 plugin.
		if (!function_exists('beonepage_register_metabox')) {
			require_once plugin_dir_path( __FILE__ ) . 'inc/cmb2/CMB.php';
		}
    }

	/**
	 * Add upgrade information to plugin page.
	 */
	public static function beonepage_get_premium() {
		echo '</tr><tr class="plugin-update-tr"><td colspan="5" class="plugin-update"><div class="update-message">' . beonepage_premium_info() . '</div></td></tr>';
	}
}
add_action( 'plugins_loaded', array( 'beOnePageLitePlugin', 'init' ) );

/**
 * Send mail using wp_mail().
 */
function beonepage_contact_send_message() {
	if ( ! wp_verify_nonce( $_POST['ajax_contact_form_nonce'], 'ajax_contact_form' ) ) {
		$msg = array( 'error' => __( 'Verification error. Try again!', 'beonepage' ) );
	} else {
		$to       = get_option( 'admin_email' );
		$name     = sanitize_text_field( $_POST['name'] );
		$email    = sanitize_email( $_POST['email'] );
		$phone    = sanitize_text_field( $_POST['phone'] );
		$subject  = sanitize_text_field( $_POST['subject'] );
		$message  = sanitize_text_field( $_POST['message'] );
		$headers  = 'From: ' . $name . ' <' . $email . '>' . "\r\n";
		$headers .= "Reply-To: $email\r\n";

		if ( $phone != '' ) {
			$subject .= ', from: ' . $name . ', ' . __( 'phone', 'beonepage' ) . ': ' . $phone ;
		}

		// Send the email using wp_mail().
		if ( wp_mail( $to, $subject, $message, $headers ) ) {
			$msg = array( 'success' => __( 'Thank you. The Mailman is on his way!', 'beonepage' ) );
		} else {
			$msg = array( 'error' => __( "Sorry, don't know what happened. Try later!", 'beonepage' ) );
		}
	}

	wp_send_json( $msg );
}
add_action( 'wp_ajax_contact_form', 'beonepage_contact_send_message' );
add_action( 'wp_ajax_nopriv_contact_form', 'beonepage_contact_send_message' ); 

?>