<?php
/**
 * Checkout settings page
 *
 * @author  Your Inspiration Themes
 * @package YITH WooCommerce Mailchimp
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCMC' ) ) {
	exit;
} // Exit if accessed directly

// retrieve lists
$list_options = YITH_WCMC()->retrieve_lists();
$selected_list = get_option( 'yith_wcmc_mailchimp_list' );

return apply_filters( 'yith_wcmc_checkout_options', array(
	'checkout' => array(
		'checkout-options' => array(
			'title' => __( 'Mailchimp Options', 'yith-wcmc' ),
			'type' => 'title',
			'desc' => '',
			'id' => 'yith_wcmc_checkout_options'
		),

		'checkout-trigger' => array(
			'title' => __( 'Register after', 'yith-wcmc' ),
			'type' => 'select',
			'desc' => __( 'Select when the user should be subscribed to the list', 'yith-wcmc' ),
			'id' => 'yith_wcmc_checkout_trigger',
			'options' => array(
				'never' => __( 'Never', 'yith-wcmc' ),
				'completed' => __( 'Order completed', 'yith-wcmc' ),
				'created' => __( 'Order placed', 'yith-wcmc' )
			),
			'css' => 'min-width:300px;'
		),

		'checkout-checkbox' => array(
			'title' => __( 'Show "Newsletter subscription" checkbox', 'yith-wcmc' ),
			'type' => 'checkbox',
			'id' => 'yith_wcmc_subscription_checkbox',
			'desc' => __( 'When you select this option, a checkbox will be added to the checkout form, inviting users to subscribe to the newsletter; otherwise users will be subscribed automatically', 'yith-wcmc' ),
			'default' => ''
		),

		'checkout-checkbox-label' => array(
			'title' => __( '"Newsletter subscription" label', 'yith-wcmc' ),
			'type' => 'text',
			'desc' => __( 'Enter here the label you want to use for the "Newsletter subscription" checkbox', 'yith-wcmc' ),
			'id' => 'yith_wcmc_subscription_checkbox_label',
			'default' => __( 'Subscribe to our wonderful newsletter', 'yith-wcmc' ),
			'css' => 'min-width:300px;'
		),

		'checkout-checkbox-position' => array(
			'title' => __( '"Newsletter subscription" position', 'yith-wcmc' ),
			'type' => 'select',
			'desc' => __( 'Select where you want to place the "Newsletter subscription" checkbox within the page', 'yith-wcmc' ),
			'id' => 'yith_wcmc_subscription_checkbox_position',
			'options' => array(
				'above_customer' => __( 'Above customer details', 'yith-wcmc' ),
				'below_customer' => __( 'Below customer details', 'yith-wcmc' ),
				'above_place_order' => __( 'Above place order button', 'yith-wcmc' ),
				'below_place_order' => __( 'Below place order button', 'yith-wcmc' ),
				'above_total' => __( 'Above review order total', 'yith-wcmc' ),
				'above_billing' => __( 'Above billing details', 'yith-wcmc' ),
				'below_billing' => __( 'Below billing details', 'yith-wcmc' ),
				'above_shipping' => __( 'Above shipping details', 'yith-wcmc' ),
			),
			'default' => 'below_customer',
			'css' => 'min-width:300px;'
		),

		'checkout-checkbox-default' => array(
			'title' => __( 'Show "Newsletter subscription" checked', 'yith-wcmc' ),
			'type' => 'checkbox',
			'id' => 'yith_wcmc_subscription_checkbox_default',
			'desc' => __( 'When you check this option, the "Newsletter subscription" checkbox will be printed checked', 'yith-wcmc' ),
			'default' => ''
		),

		'checkout-email-type' => array(
			'title' => __( 'Email type', 'yith-wcmc' ),
			'type' => 'select',
			'id' => 'yith_wcmc_email_type',
			'desc' => __( 'User preferential email type (HTML or plain text)', 'yith-wcmc' ),
			'options' => array(
				'html' => __( 'HTML', 'yith-wcmc' ),
				'text' => __( 'Text', 'yith-wcmc' )
			),
			'default' => 'html'
		),

		'checkout-double-optin' => array(
			'title' => __( 'Double Optin', 'yith-wcmc' ),
			'type' => 'checkbox',
			'id' => 'yith_wcmc_double_optin',
			'desc' => __( 'When you check this option, Mailchimp will send a confirmation email before subscribing the user', 'yith-wcmc' ),
			'default' => ''
		),

		'checkout-update-existing' => array(
			'title' => __( 'Update existing', 'yith-wcmc' ),
			'type' => 'checkbox',
			'id' => 'yith_wcmc_update_existing',
			'desc' => __( 'When you check this option, existing users will be updated, and Mailchimp servers will not show an error', 'yith-wcmc' ),
			'default' => ''
		),

		'checkout-send-welcome' => array(
			'title' => __( 'Send welcome email', 'yith-wcmc' ),
			'type' => 'checkbox',
			'id' => 'yith_wcmc_send_welcome',
			'desc' => __( 'Send a welcome email to the user (only available when double optin is disabled)', 'yith-wcmc' ),
			'default' => ''
		),

		'checkout-options-end' => array(
			'type'  => 'sectionend',
			'id'    => 'yith_wcmc_checkout_options'
		),

		'checkout-list-basic-options' => array(
			'title' => __( 'List Options', 'yith-wcmc' ),
			'type' => 'title',
			'desc' => '',
			'id' => 'yith_wcmc_list_basic_options'
		),

		'checkout-list' => array(
			'title' => __( 'Users list', 'yith-wcmc' ),
			'type' => 'select',
			'desc' => __( 'Select a list where you want to add the user', 'yith-wcmc' ),
			'id' => 'yith_wcmc_mailchimp_list',
			'options' => $list_options,
			'custom_attributes' => empty( $list_options ) ? array(
				'disabled' => 'disabled'
			) : array(),
			'css' => 'min-width:300px;'
		),

		'checkout-list-basic-options-end' => array(
			'type'  => 'sectionend',
			'id'    => 'yith_wcmc_list_basic_options'
		),
	)
) );