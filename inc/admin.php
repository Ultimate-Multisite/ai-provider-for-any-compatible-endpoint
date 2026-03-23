<?php
/**
 * Admin integration for the Gratis AI Provider for Any Compatible Endpoint plugin.
 *
 * @package GratisAiProviderCompatibleEndpoint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

declare(strict_types=1);

namespace GratisAiProviderCompatibleEndpoint;

/**
 * Enqueues the connector script module on the Connectors admin page.
 *
 * The `connectors-wp-admin_init` action fires only on the Settings > Connectors
 * page, so the module is loaded only where it is needed.
 */
function enqueue_connector_module(): void {
	wp_register_script_module(
		'gratis-ai-provider-for-any-compatible-endpoint',
		plugins_url( 'build/connector.js', GRATIS_AI_PROVIDER_COMPATIBLE_ENDPOINT_FILE ),
		[
			[
				'id'     => '@wordpress/connectors',
				'import' => 'static',
			],
		],
		'1.0.0'
	);
	wp_enqueue_script_module( 'gratis-ai-provider-for-any-compatible-endpoint' );
}
