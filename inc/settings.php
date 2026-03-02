<?php
/**
 * Settings registration for the OpenAI-Compatible Connector.
 *
 * @package OpenAiCompatibleConnector
 */

declare(strict_types=1);

namespace OpenAiCompatibleConnector;

/**
 * Registers the plugin settings for the REST API and admin.
 */
function register_settings(): void {
	register_setting(
		'openai_compat_connector',
		'openai_compat_endpoint_url',
		[
			'type'              => 'string',
			'sanitize_callback' => 'esc_url_raw',
			'default'           => '',
			'show_in_rest'      => true,
		]
	);

	register_setting(
		'openai_compat_connector',
		'openai_compat_api_key',
		[
			'type'              => 'string',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => '',
			'show_in_rest'      => true,
		]
	);

	register_setting(
		'openai_compat_connector',
		'openai_compat_default_model',
		[
			'type'              => 'string',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => '',
			'show_in_rest'      => true,
		]
	);

	register_setting(
		'openai_compat_connector',
		'openai_compat_timeout',
		[
			'type'              => 'integer',
			'sanitize_callback' => 'absint',
			'default'           => 360,
			'show_in_rest'      => true,
		]
	);
}
