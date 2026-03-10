<?php
/**
 * Text generation model for a compatible AI endpoint.
 *
 * @package AiServicesConnector
 */

declare(strict_types=1);

namespace AiServicesConnector;

use WordPress\AiClient\Providers\Http\DTO\Request;
use WordPress\AiClient\Providers\Http\Enums\HttpMethodEnum;
use WordPress\AiClient\Providers\OpenAiCompatibleImplementation\AbstractOpenAiCompatibleTextGenerationModel;

/**
 * Text generation model that forwards requests to the configured endpoint
 * using the standard chat/completions format.
 */
class AiServicesModel extends AbstractOpenAiCompatibleTextGenerationModel {

	/**
	 * {@inheritDoc}
	 */
	protected function createRequest(
		HttpMethodEnum $method,
		string $path,
		array $headers = [],
		$data = null
	): Request {
		return new Request(
			$method,
			AiServicesProvider::url( $path ),
			$headers,
			$data,
			$this->getRequestOptions()
		);
	}
}
