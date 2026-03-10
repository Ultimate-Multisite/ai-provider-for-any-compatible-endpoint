<?php
/**
 * Admin integration for the AI Services Connector.
 *
 * @package AiServicesConnector
 */

declare(strict_types=1);

namespace AiServicesConnector;

/**
 * Enqueues the connector script module on the Connectors admin page.
 *
 * The `connectors-wp-admin_init` action fires only on the Settings > Connectors
 * page, so the module is loaded only where it is needed.
 */
function enqueue_connector_module(): void {
	wp_register_script_module(
		'ai-services-connector',
		plugins_url( 'build/connector.js', AI_SERVICES_CONNECTOR_FILE ),
		[
			[
				'id'     => '@wordpress/connectors',
				'import' => 'static',
			],
		],
		'1.0.0'
	);
	wp_enqueue_script_module( 'ai-services-connector' );
}
