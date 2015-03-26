<?php
/**
 * Integration settings page
 *
 * @author  Your Inspiration Themes
 * @package YITH WooCommerce Mailchimp
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCMC' ) ) {
	exit;
} // Exit if accessed directly

return apply_filters( 'yith_wcmc_integration_options', array(
	'integration' => array(
		'mailchimp-options' => array(
			'title' => __( 'Mailchimp Options', 'yith-wcmc' ),
			'type' => 'title',
			'desc' => '',
			'id' => 'yith_wcmc_mailchimp_options'
		),

		'mailchimp-api-key' => array(
			'title' => __( 'Mailchimp API Key', 'yith-wcmc' ),
			'type' => 'text',
			'id' => 'yith_wcmc_mailchimp_api_key',
			'desc' => __( 'API Key used to access MailChimp account; you can get one <a href="admin.mailchimp.com/account/api/">here</a>', 'yith-wcmc' ),
			'default' => '',
			'css'     => 'min-width:300px;'
		),

		'mailchimp-status' => array(
			'title' => __( 'Integration status', 'yith-wctc' ),
			'type' => 'yith_wcmc_integration_status',
			'id' => 'yith_wcmc_integration_status'
		),

		'mailchimp-options-end' => array(
			'type'  => 'sectionend',
			'id'    => 'yith_wcmc_mailchimp_options'
		),
	)
) );