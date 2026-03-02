<?php
/**
 * Admin integration for the OpenAI-Compatible Connector.
 *
 * @package OpenAiCompatibleConnector
 */

declare(strict_types=1);

namespace OpenAiCompatibleConnector;

/**
 * Enqueues the connector script module on the Connectors admin page.
 *
 * The `connectors-wp-admin_init` action fires only on the Settings > Connectors
 * page, so the module is loaded only where it is needed.
 */
function enqueue_connector_module(): void {
	wp_register_script_module(
		'ai-provider-for-any-openai-compatible',
		plugins_url( 'build/connector.js', AI_PROVIDER_OPENAI_COMPAT_FILE ),
		[
			[
				'id'     => '@wordpress/connectors',
				'import' => 'static',
			],
		],
		'1.2.0'
	);
	wp_enqueue_script_module( 'ai-provider-for-any-openai-compatible' );
}
