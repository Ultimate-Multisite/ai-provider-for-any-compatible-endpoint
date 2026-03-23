<?php
/**
 * Plugin Name: Ultimate AI Connector for Compatible Endpoints
 * Description: Registers an AI Client provider for Ollama, LM Studio, or any AI endpoint using the standard chat completions API format.
 * Requires at least: 6.9
 * Requires PHP: 7.4
 * Version: 1.0.0
 * Author: Ultimate Multisite Community
 * Author URI: https://ultimatemultisite.com
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: ultimate-ai-connector-compatible-endpoints
 *
 * @package UltimateAiConnectorCompatibleEndpoints
 */


namespace UltimateAiConnectorCompatibleEndpoints;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

// ---------------------------------------------------------------------------
// Load classes and function files.
// ---------------------------------------------------------------------------

require_once __DIR__ . '/inc/class-provider.php';
require_once __DIR__ . '/inc/class-model.php';
require_once __DIR__ . '/inc/class-model-directory.php';
require_once __DIR__ . '/inc/settings.php';
require_once __DIR__ . '/inc/admin.php';
require_once __DIR__ . '/inc/rest-api.php';
require_once __DIR__ . '/inc/http-filters.php';
require_once __DIR__ . '/inc/provider-registration.php';

// ---------------------------------------------------------------------------
// Hook registrations.
// ---------------------------------------------------------------------------

// Settings.
add_action( 'admin_init', __NAMESPACE__ . '\\register_settings' );
add_action( 'rest_api_init', __NAMESPACE__ . '\\register_settings' );

// Connectors page.
add_action( 'connectors-wp-admin_init', __NAMESPACE__ . '\\enqueue_connector_module' );

// REST API.
add_action( 'rest_api_init', __NAMESPACE__ . '\\register_models_route' );

// HTTP filters.
add_filter( 'http_request_args', __NAMESPACE__ . '\\increase_timeout', 10, 2 );
add_filter( 'http_allowed_safe_ports', __NAMESPACE__ . '\\allow_endpoint_port' );
add_filter( 'http_request_host_is_external', __NAMESPACE__ . '\\allow_endpoint_host', 10, 2 );

// Provider registration.
add_action( 'init', __NAMESPACE__ . '\\register_provider', 5 );
