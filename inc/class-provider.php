<?php
/**
 * Provider class for an OpenAI-compatible endpoint.
 *
 * @package OpenAiCompatibleConnector
 */

declare(strict_types=1);

namespace OpenAiCompatibleConnector;

use WordPress\AiClient\Providers\ApiBasedImplementation\AbstractApiProvider;
use WordPress\AiClient\Providers\ApiBasedImplementation\ListModelsApiBasedProviderAvailability;
use WordPress\AiClient\Providers\Contracts\ModelMetadataDirectoryInterface;
use WordPress\AiClient\Providers\Contracts\ProviderAvailabilityInterface;
use WordPress\AiClient\Providers\DTO\ProviderMetadata;
use WordPress\AiClient\Providers\Enums\ProviderTypeEnum;
use WordPress\AiClient\Providers\Http\Enums\RequestAuthenticationMethod;
use WordPress\AiClient\Providers\Models\Contracts\ModelInterface;
use WordPress\AiClient\Providers\Models\DTO\ModelMetadata;
use WordPress\AiClient\Common\Exception\RuntimeException;

/**
 * Provider class for an OpenAI-compatible endpoint.
 *
 * The base URL is read from plugin settings and stored in a static property
 * so that it is available to the SDK's static `baseUrl()` method.
 */
class OpenAiCompatProvider extends AbstractApiProvider {

	/**
	 * Configured endpoint URL. Set from options before registration.
	 *
	 * @var string
	 */
	public static string $endpointUrl = '';

	/**
	 * {@inheritDoc}
	 */
	protected static function baseUrl(): string {
		return rtrim( self::$endpointUrl, '/' );
	}

	/**
	 * {@inheritDoc}
	 */
	protected static function createModel(
		ModelMetadata $modelMetadata,
		ProviderMetadata $providerMetadata
	): ModelInterface {
		$capabilities = $modelMetadata->getSupportedCapabilities();
		foreach ( $capabilities as $capability ) {
			if ( $capability->isTextGeneration() ) {
				return new OpenAiCompatModel( $modelMetadata, $providerMetadata );
			}
		}

		throw new RuntimeException(
			'Unsupported model capabilities: ' . esc_html( implode( ', ', $capabilities ) )
		);
	}

	/**
	 * {@inheritDoc}
	 */
	protected static function createProviderMetadata(): ProviderMetadata {
		return new ProviderMetadata(
			'ai-provider-for-any-openai-compatible',
			'OpenAI Compatible',
			ProviderTypeEnum::server(),
			null,
			RequestAuthenticationMethod::apiKey()
		);
	}

	/**
	 * {@inheritDoc}
	 */
	protected static function createProviderAvailability(): ProviderAvailabilityInterface {
		return new ListModelsApiBasedProviderAvailability(
			static::modelMetadataDirectory()
		);
	}

	/**
	 * {@inheritDoc}
	 */
	protected static function createModelMetadataDirectory(): ModelMetadataDirectoryInterface {
		return new OpenAiCompatModelDirectory();
	}
}
