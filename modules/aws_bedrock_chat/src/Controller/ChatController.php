<?php

namespace Drupal\aws_bedrock_chat\Controller;

use Drupal\aws_bedrock_chat\BedrockClient;
use Drupal\Component\Utility\Html;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\File\FileUrlGeneratorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Provides responses for the AWS Bedrock Chat module.
 */
class ChatController extends ControllerBase {

  /**
   * The Bedrock Client service.
   *
   * @var \Drupal\aws_bedrock_chat\BedrockClient
   */
  protected $bedrockClient;

  /**
   * The File URL Generator service.
   *
   * @var \Drupal\Core\File\FileUrlGeneratorInterface
   */
  protected $fileUrlGenerator;

  /**
   * Constructs a new ChatController object.
   *
   * @param \Drupal\aws_bedrock_chat\BedrockClient $bedrock_client
   *   The Bedrock client service.
   * @param \Drupal\Core\File\FileUrlGeneratorInterface $file_url_generator
   *   The File URL Generator service.
   */
  public function __construct(BedrockClient $bedrock_client, FileUrlGeneratorInterface $file_url_generator) {
    $this->bedrockClient = $bedrock_client;
    $this->fileUrlGenerator = $file_url_generator;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('aws_bedrock_chat.bedrock_client'),
      $container->get('file_url_generator')
    );
  }

  /**
   * Response message ajax callback for the chat form.
   */
  public function responseMessage(Request $request) {

    // Get the user message from the request.
    $userMessage = $request->request->get('message');

    if (!empty($userMessage)) {
      $config = $this->config('aws_bedrock_chat.settings');
      $debug = $config->get('debug') ?: FALSE;
      $customize = $config->get('customize') ?: [];

      // Get response from the Bedrock Client service.
      $result = $this->bedrockClient->getResponse($userMessage);

      // If there is a text response check for file citations if enabled
      // and return results, otherwise return an error message.
      if (isset($result['output']['text'])) {
        $citationHTML = '';
        if (isset($result['citations']) && isset($customize['display_related_files']) && $customize['display_related_files']) {
          $citationHTML = $this->generateCitationHtml($result['citations']);
        }
        $responseMessageHtml = '<p class="aws-bedrock-chat-message-content aws-bedrock-chat-response"><span class="aws-bedrock-chat-response-text">' . $result['output']['text'] . $citationHTML . '</span></p>';
      }
      elseif (isset($result['error'])) {
        $error_message = $this->getErrorMessage($result['error']);
        return new JsonResponse(['responseMessageHtml' => '<p class="aws-bedrock-chat-message-content aws-bedrock-chat-response"><span class="aws-bedrock-chat-response-text">' . $error_message . '</span></p>']);
      }
      else {
        $responseMessageHtml = '<p class="aws-bedrock-chat-message-content aws-bedrock-chat-response"><span class="aws-bedrock-chat-response-text">Sorry, we couldn\'t find a response to "' . Html::escape($userMessage) . '".</span></p>';
      }
    }
    else {
      // If no user message sent, return a default message.
      $responseMessageHtml = '<p class="aws-bedrock-chat-message-content aws-bedrock-chat-response"><span class="aws-bedrock-chat-response-text">No user message was sent, please try again.</span></p>';
    }
    if ($debug) {
      error_log('Response message: ' . $responseMessageHtml);
    }
    // Return the response message HTML as JSON.
    return new JsonResponse(['responseMessageHtml' => $responseMessageHtml]);
  }

  /**
   * Generate HTML for citations.
   *
   * @param array $citations
   *   The citations array.
   *
   * @return string
   *   The HTML for citations.
   */
  protected function generateCitationHtml($citations) {
    // Generate HTML for citations.
    $config = $this->config('aws_bedrock_chat.settings');
    $debug = $config->get('debug') ?: FALSE;
    $customize = $config->get('customize') ?: [];
    $references = [];
    $html = '';

    foreach ($citations as $citation) {
      if (isset($citation['retrievedReferences']) && !empty($citation['retrievedReferences'])) {
        foreach ($citation['retrievedReferences'] as $reference) {
          if (isset($reference['location']['s3Location']['uri'])) {
            if (str_starts_with($reference['location']['s3Location']['uri'], 's3://')) {
              // Get the public url from the S3 URI.
              $pos = strpos($reference['location']['s3Location']['uri'], '/', 5);
              if ($pos !== FALSE) {
                $reference_uri = substr($reference['location']['s3Location']['uri'], $pos);
              }
            }
            elseif (str_starts_with($reference['location']['s3Location']['uri'], 'public://')) {
              // Get the public URL from the public URI.
              $reference_uri = $this->fileUrlGenerator->generateString($reference['location']['s3Location']['uri']);
            }
            else {
              $reference_uri = $reference['location']['s3Location']['uri'];
            }
            $pos = strrpos($reference_uri, '/');
            $filename = $pos === FALSE ? $reference_uri : substr($reference_uri, $pos + 1);
            if (!empty($filename)) {
              // Avoid duplicates from the same file in different folders.
              if (isset($customize['exclude_duplicate_files']) && $customize['exclude_duplicate_files']) {
                $references[$filename] = ['url' => $reference_uri, 'filename' => $filename];
              }
              else {
                $references[] = ['url' => $reference_uri, 'filename' => $filename];
              }
            }
            else {
              $references[] = ['url' => $reference_uri, 'filename' => 'No filename'];
            }
          }
        }
      }
      if (!empty($references)) {
        // Build HTML for the references.
        $html = '<span class="aws-bedrock-chat-references-divider">&nbsp;</span><span class="aws-bedrock-chat-references-header">Related files:</span>';
        $count = 1;
        foreach ($references as $reference) {
          $html .= '<span class="aws-bedrock-reference"><span class="aws-bedrock-reference-num">' .
            '[' . $count . ']</span><a href="' . $reference['url'] . '" target="_blank">' . $reference['filename'] . '</a></span>';
          $count++;
        }
        if ($debug) {
          error_log('References: ' . print_r($references, 1));
          error_log('References returned HTML: ' . $html);
        }
      }
    }
    return $html;
  }

  /**
   * Get the error message.
   *
   * @param array $error
   *   The error array.
   *
   * @return string
   *   The error message.
   */
  protected function getErrorMessage($error) {
    $error_message = '';
    switch ($error) {
      case 'client_error':
        $error_message = $this->t('An error occurred while processing your request. Please try again later.');
        break;

      case 'sdk_missing':
        $error_message = $this->t('The AWS SDK for PHP is required for the AWS Bedrock Chat module to function properly. Please install it by running <strong>composer require aws/aws-sdk-php</strong>.');
        break;

      case 'api_disabled':
        $error_message = $this->t('The chat API is currently disabled. Please check back soon.');
        break;

      case 'no_user_input':
        $error_message = $this->t('No user message was sent, please try again.');
        break;

      default:
        $error_message = $this->t('An error occurred while processing your request. Please try again later.');
    }
    return $error_message;
  }

}
