<?php

namespace Drupal\aws_bedrock_chat;

use Aws\BedrockAgentRuntime\BedrockAgentRuntimeClient;
use Aws\Credentials\Credentials;
use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Provides responses for the AWS Bedrock Chat module.
 */
class BedrockClient {

  /**
   * The Bedrock Agent Runtime client.
   *
   * @var \Aws\BedrockAgentRuntime\BedrockAgentRuntimeClient
   */
  private $bedrockClient;

  /**
   * Stores Drupal configuration.
   *
   * @var \Drupal\Core\Config\ImmutableConfig
   */
  private $config;

  /**
   * The Config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Constructs a new BedrockClient object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   Config factory.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->configFactory = $config_factory;
    $this->config = $this->configFactory->get('aws_bedrock_chat.settings');
  }

  /**
   * Get the response message.
   *
   * @param string $prompt
   *   The user prompt text to be processed.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   The JSON response.
   */
  public function getResponse(string $prompt) {

    // Process the user input and return response message.
    if (!empty($prompt)) {
      // Get configuration values.
      $disable_api = $this->config->get('disable_api') ?: FALSE;
      $debug = $this->config->get('debug') ?: FALSE;
      $knowledge_base_id = $this->config->get('knowledge_base_id') ?: '';
      $model_arn = $this->config->get('model_arn') ?: '';
      $region = $this->config->get('region') ?: '';
      $search_type = $this->config->get('search_type') ?: '';
      $authentication_method = $this->config->get('aws_authentication_method') ?: '';

      // Build configuration for BedrockAgentRuntimeClient.
      $client_config = [
        'region' => $region,
        'version' => 'latest',
      ];

      if ($authentication_method === 'profile') {
        $profile = $this->config->get('profile') ?: '';
        if (!empty($profile)) {
          $client_config['profile'] = $profile;
        }
      }
      elseif ($authentication_method === 'keys') {
        $api_key = $this->config->get('aws_access_key') ?: getenv('AWS_ACCESS_KEY_ID');
        $api_secret = $this->config->get('aws_secret_key') ?: getenv('AWS_SECRET_ACCESS_KEY');
        if (!empty($api_key) && !empty($api_secret)) {
          $credentials = new Credentials($api_key, $api_secret);
          $client_config['credentials'] = $credentials;
        }
      }

      if ($debug) {
        error_log('User message: ' . $prompt);
        error_log('Region: ' . $region);
        error_log('Model ARN: ' . $model_arn);
        error_log('Knowledge Base ID: ' . $knowledge_base_id);
        error_log('Authentication Method: ' . $authentication_method);
        error_log('Client config: ' . print_r($client_config, 1));
        error_log('Search Type: ' . $search_type);
      }

      if (!$disable_api && !empty($region) && !empty($model_arn) && !empty($knowledge_base_id) && !empty($search_type)) {
        if (class_exists('Aws\BedrockAgentRuntime\BedrockAgentRuntimeClient')) {
          try {
            // Initialize BedrockAgentRuntimeClient.
            $this->bedrockClient = new BedrockAgentRuntimeClient($client_config);

            // Retrieve and generate response.
            $result = $this->bedrockClient->retrieveAndGenerate([
              'input' => [
                'text' => $prompt,
              ],
              'retrieveAndGenerateConfiguration' => [
                'knowledgeBaseConfiguration' => [
                  'knowledgeBaseId' => $knowledge_base_id,
                  'modelArn' => $model_arn,
                  'retrievalConfiguration' => [
                    'vectorSearchConfiguration' => [
                      'overrideSearchType' => $search_type,
                    ],
                  ],
                ],
                'type' => 'KNOWLEDGE_BASE',
              ],
            ]);
          }
          catch (\Throwable $e) {
            // Client error.
            if ($debug) {
              error_log('Error: ' . $e->getMessage());
            }
            return ['error' => 'client_error'];
          }
          if ($debug) {
            error_log('raw results: ' . print_r($result, 1));
          }
        }
        else {
          // BedrockAgentRuntimeClient class does not exist.
          if ($debug) {
            error_log('BedrockAgentRuntimeClient class does not exist, returning default message.');
          }
          return ['error' => 'sdk_missing'];
        }
      }
      else {
        // Chat API is disabled or parameter requirements not met.
        if ($debug) {
          error_log('Chat API is disabled or parameter requirements not met, returning default message.');
        }
        return ['error' => 'api_disabled'];
      }
    }
    else {
      // No user input.
      return ['error' => 'no_user_input'];
    }
    return $result;
  }

}
