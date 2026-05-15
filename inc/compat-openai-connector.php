<?php
/**
 * Compatibility shims for the OpenAiCompatibleConnector namespace.
 *
 * The WordPress AI Agent plugin (gratis-ai-agent / ai-agent-for-wp) looks for
 * functions in the `OpenAiCompatibleConnector` namespace when working with
 * OpenAI-compatible providers. This file registers those shims so the agent
 * can discover models and the default model from our multi-provider config.
 *
 * @package UltimateAiConnectorCompatibleEndpoints
 */

namespace OpenAiCompatibleConnector;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return the default model from the primary configured provider.
 *
 * Called by the AI Agent's AgentLoop when no explicit model is set.
 *
 * @return string Model ID, or empty string if none configured.
 */
function get_default_model(): string {
	$primary = \UltimateAiConnectorCompatibleEndpoints\get_primary_provider();
	if ( $primary && ! empty( $primary['default_model'] ) ) {
		return (string) $primary['default_model'];
	}

	// Legacy single-provider fallback.
	return (string) get_option( 'ultimate_ai_connector_default_model', '' );
}

/**
 * Proxy to the plugin's REST model listing function.
 *
 * Called by the AI Agent's SettingsController and ModelsCommand to populate
 * model lists for providers whose SDK ID starts with
 * 'ai-provider-for-any-openai-compatible'.
 *
 * Supported request params (set via $request->set_param() at the call site):
 * - 'provider_id'  Optional SDK provider ID (e.g. 'ai-provider-for-any-openai-compatible-2').
 *                  When provided, the matching configured provider's endpoint URL and API
 *                  key are used. Without it, the call falls back to the primary provider,
 *                  which causes every OpenAI-compatible provider in a multi-provider setup
 *                  to incorrectly return the same model list.
 * - 'endpoint_url' Optional explicit endpoint URL override.
 * - 'api_key'      Optional explicit API key override.
 *
 * @param \WP_REST_Request $request REST request (may have no params when called
 *                                  internally; falls back to primary provider).
 * @return \WP_REST_Response|\WP_Error
 */
function rest_list_models( \WP_REST_Request $request ) {
	return \UltimateAiConnectorCompatibleEndpoints\rest_list_models( $request );
}
