<?php
/**
 * Text generation model for an OpenAI-compatible endpoint.
 *
 * @package OpenAiCompatibleConnector
 */

declare(strict_types=1);

namespace OpenAiCompatibleConnector;

use WordPress\AiClient\Providers\Http\DTO\Request;
use WordPress\AiClient\Providers\Http\Enums\HttpMethodEnum;
use WordPress\AiClient\Providers\OpenAiCompatibleImplementation\AbstractOpenAiCompatibleTextGenerationModel;

/**
 * Text generation model that forwards requests to the configured endpoint
 * using the standard OpenAI chat/completions format.
 */
class OpenAiCompatModel extends AbstractOpenAiCompatibleTextGenerationModel {

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
			OpenAiCompatProvider::url( $path ),
			$headers,
			$data,
			$this->getRequestOptions()
		);
	}
}
