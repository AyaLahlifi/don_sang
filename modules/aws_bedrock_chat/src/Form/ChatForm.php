<?php

namespace Drupal\aws_bedrock_chat\Form;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\Core\Render\RendererInterface;
use Drupal\Core\State\StateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Builds the AWS Bedrock Chat form.
 */
class ChatForm extends FormBase implements ContainerInjectionInterface {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The language manager service.
   *
   * @var \Drupal\Core\Language\LanguageManagerInterface
   */
  protected $languageManager;

  /**
   * The module handler service.
   *
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected $moduleHandler;

  /**
   * The Renderer service.
   *
   * @var \Drupal\Core\Render\RendererInterface
   */
  protected $renderer;

  /**
   * The state service.
   *
   * @var \Drupal\Core\State\StateInterface
   */
  protected $state;

  /**
   * Constructs a new ChatForm.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager service.
   * @param \Drupal\Core\Language\LanguageManagerInterface $language_manager
   *   The language manager service.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler service.
   * @param \Drupal\Core\Render\RendererInterface $renderer
   *   The Renderer service.
   * @param \Drupal\Core\State\StateInterface $state
   *   The state service.
   */
  public function __construct(
    EntityTypeManagerInterface $entity_type_manager,
    LanguageManagerInterface $language_manager,
    ModuleHandlerInterface $module_handler,
    RendererInterface $renderer,
    StateInterface $state,
  ) {
    $this->entityTypeManager = $entity_type_manager;
    $this->languageManager = $language_manager;
    $this->moduleHandler = $module_handler;
    $this->renderer = $renderer;
    $this->state = $state;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager'),
      $container->get('language_manager'),
      $container->get('module_handler'),
      $container->get('renderer'),
      $container->get('state')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'aws_bedrock_chat_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('aws_bedrock_chat.settings');
    $customize = $config->get('customize') ?: [];

    $close_icon_url = $this->getIconUrl($customize, 'close');
    $loading_icon_url = $this->getIconUrl($customize, 'loading');
    $response_icon_url = $this->getIconUrl($customize, 'response');
    $toggle_icon_url = $this->getIconUrl($customize, 'toggle');
    $user_icon_url = $this->getIconUrl($customize, 'user');

    $current_language = $this->languageManager->getCurrentLanguage()->getId();
    $default_language = $this->languageManager->getDefaultLanguage()->getId();

    if ($current_language == $default_language) {
      $header_text = $customize['interface']['header_text'] ?: 'Chat with us';
      $start_text = $customize['interface']['start_text'] ?: 'Hi, how can we assist you today?';
      $user_input_placeholder = $customize['interface']['user_input_placeholder'] ?: 'Type your message here...';
    }
    else {
      $header_text = $this->state->get('aws_bedrock_chat.header_text.' . $current_language, ($customize['interface']['header_text'] ?: 'Chat with us'));
      $start_text = $this->state->get('aws_bedrock_chat.start_text.' . $current_language, ($customize['interface']['start_text'] ?: 'Hi, how can we assist you today?'));
      $user_input_placeholder = $this->state->get('aws_bedrock_chat.user_input_placeholder.' . $current_language, ($customize['interface']['user_input_placeholder'] ?: 'Type your message here...'));
    }

    $form['header'] = [
      '#type' => 'markup',
      '#markup' => '<div class="aws-bedrock-chat-header"><span class="aws-bedrock-chat-header-text">' . $header_text . '</span></div>',
    ];

    $form['messages'] = [
      '#type' => 'container',
      '#attributes' => [
        'class' => ['aws-bedrock-chat-messages'],
      ],
    ];

    $form['messages']['chat_start_message'] = [
      '#type' => 'markup',
      '#markup' => '<div class="aws-bedrock-chat-message aws-bedrock-chat-response-message">' .
      (!empty($response_icon_url) ? '<img class="aws-bedrock-chat-response-message-icon" src="' . $response_icon_url . '" alt="Response Message Icon"/>' : '') .
      '<p class="aws-bedrock-chat-message-content aws-bedrock-chat-response"><span class="aws-bedrock-chat-response-text">' . $start_text . '</span></p>' .
      '</div>',
    ];

    $form['chat_input_container'] = [
      '#type' => 'container',
      '#attributes' => [
        'class' => ['aws-bedrock-chat-input'],
      ],
    ];

    $form['chat_input_container']['user_input'] = [
      '#type' => 'textarea',
      '#rows' => 1,
      '#attributes' => [
        'placeholder' => $user_input_placeholder,
        'class' => ['aws-bedrock-chat-user-input'],
      ],
      '#value' => '',
    ];

    $form['chat_input_container']['submit'] = [
      '#type' => 'button',
      '#value' => $this->t('Send'),
      '#attributes' => [
        'class' => ['aws-bedrock-chat-submit', 'use-image'],
        'id' => 'aws-bedrock-chat-submit',
      ],
    ];

    $form['chat_input_container']['custom_svg'] = [
      '#type' => 'markup',
      '#markup' => '<button><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="50" height="50" viewBox="0 0 256 256" xml:space="preserve">
                   <defs>
                   </defs>
                   <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)" >
                     <polygon points="40.32,52.5 47.23,66.96 60.72,32.11 " style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform="  matrix(1 0 0 1 0 0) "/>
                     <polygon points="57.88,29.29 23.04,42.77 37.5,49.68 " style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform="  matrix(1 0 0 1 0 0) "/>
                     <path d="M 45 0 C 20.147 0 0 20.147 0 45 c 0 24.853 20.147 45 45 45 s 45 -20.147 45 -45 C 90 20.147 69.853 0 45 0 z M 67.978 24.225 c -0.018 0.156 -0.05 0.309 -0.104 0.458 c -0.005 0.013 -0.004 0.027 -0.009 0.039 l -0.012 0.03 c 0 0 0 0.001 0 0.001 l -18.57 47.969 c -0.288 0.745 -0.991 1.246 -1.789 1.277 C 47.469 74 47.443 74 47.418 74 c -0.769 0 -1.472 -0.44 -1.805 -1.138 L 36.41 53.59 l -19.271 -9.203 c -0.72 -0.344 -1.167 -1.083 -1.137 -1.881 c 0.03 -0.797 0.532 -1.501 1.276 -1.789 l 47.968 -18.57 c 0.001 0 0.002 -0.001 0.003 -0.001 l 0.029 -0.011 c 0.012 -0.005 0.025 -0.004 0.038 -0.009 c 0.149 -0.054 0.303 -0.087 0.459 -0.105 c 0.042 -0.005 0.083 -0.01 0.125 -0.012 c 0.168 -0.008 0.336 -0.001 0.501 0.033 c 0.017 0.004 0.033 0.011 0.05 0.015 c 0.149 0.034 0.292 0.089 0.431 0.158 c 0.039 0.019 0.076 0.038 0.114 0.06 c 0.148 0.086 0.291 0.184 0.418 0.311 c 0.127 0.127 0.225 0.269 0.311 0.418 c 0.022 0.038 0.041 0.076 0.06 0.115 c 0.068 0.138 0.122 0.279 0.156 0.426 c 0.004 0.019 0.013 0.036 0.016 0.055 c 0.033 0.164 0.041 0.332 0.033 0.499 C 67.988 24.141 67.983 24.182 67.978 24.225 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                   </g>
                   </svg></button>',
      '#allowed_tags' => ['button', 'svg', 'path', 'g', 'defs', 'polygon'],
    ];

    $module_path = $this->moduleHandler->getModule('aws_bedrock_chat')->getPath();

    $form['#attributes']['class'][] = 'aws-bedrock-chat-form';
    $form['#attached']['library'][] = 'aws_bedrock_chat/chat_style';
    $form['#attached']['drupalSettings']['awsBedrockChat']['closeIcon'] = $close_icon_url;
    $form['#attached']['drupalSettings']['awsBedrockChat']['loadingIcon'] = $loading_icon_url ?: '/' . $module_path . '/images/ajax-loader.gif';
    $form['#attached']['drupalSettings']['awsBedrockChat']['responseIcon'] = $response_icon_url;
    $form['#attached']['drupalSettings']['awsBedrockChat']['toggleIcon'] = $toggle_icon_url;
    $form['#attached']['drupalSettings']['awsBedrockChat']['userIcon'] = $user_icon_url;

    $custom_css = $this->getCssMarkup();
    if (!empty($custom_css)) {
      $form['#attached']['drupalSettings']['awsBedrockChat']['customCss'] = $custom_css;
    }

    $rendered_form = $this->renderer->render($form);
    $variables = [
      'form' => $rendered_form,
      'toggle_icon_url' => $toggle_icon_url,
    ];

    return [
      '#theme' => 'aws_bedrock_chat_form_wrapper',
      '#form' => $variables['form'],
      '#toggle_icon_url' => $variables['toggle_icon_url'],
      '#printed' => TRUE,
    ];

  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {}

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {}

  /**
   * Get the icon URL based on the customization settings.
   *
   * @param array $customize
   *   The customization settings.
   * @param string $type
   *   The type of icon to get.
   *
   * @return string
   *   The URL of the icon.
   */
  private function getIconUrl($customize, $type) {
    return $customize[$type]['use_uploaded'] && $customize[$type]['upload'][0] ?
      $this->entityTypeManager->getStorage('file')->load($customize[$type]['upload'][0])->createFileUrl() :
      $customize[$type]['url'];
  }

  /**
   * Get the CSS markup for the chat form.
   *
   * @return string
   *   The CSS markup.
   */
  protected function getCssMarkup() {
    $config = $this->config('aws_bedrock_chat.settings');
    $customize = $config->get('customize') ?: [];
    $cssMarkup = '';
    $css_items = [
      'header_text' => [
        'color' => [
          'color_code' => 'span',
        ],
      ],
      'header' => [
        'background_color' => [
          'color_code' => 'div',
        ],
      ],
      'main' => [
        'background' => [
          'color_code' => 'div',
        ],
        'border_color' => [
          'color_code' => '',
        ],
      ],
      'response_text' => [
        'color' => [
          'color_code' => 'span',
        ],
      ],
      'response' => [
        'background_color' => [
          'color_code' => 'p',
        ],
      ],
      'user_text' => [
        'color' => [
          'color_code' => 'span',
        ],
      ],
      'user' => [
        'background_color' => [
          'color_code' => 'p',
        ],
      ],
      'toggle_outer' => [
        'fill' => [
          'color_code' => 'div',
        ],
      ],
      'toggle_inner' => [
        'fill' => [
          'color_code' => 'div',
        ],
      ],
      'submit_outer' => [
        'fill' => [
          'color_code' => 'div',
        ],
      ],
      'submit_inner_top' => [
        'fill' => [
          'color_code' => 'div',
        ],
      ],
      'submit_inner_bottom' => [
        'fill' => [
          'color_code' => 'div',
        ],
      ],
      'submit_focus' => [
        'outline' => [
          'color_code' => 'div',
        ],
      ],
      'input_focus' => [
        'border' => [
          'color_code' => 'input',
        ],
      ],
    ];

    foreach ($css_items as $key => $style) {
      if (isset($customize['interface']['style'][$key]) && !empty($customize['interface']['style'][$key])) {
        $class = '';
        foreach ($style as $attribute => $value) {
          // Add selector and style for each item.
          // If key found with unstructured class add the specific class.
          if ($attribute === array_key_first($style)) {
            if ($key === 'toggle_outer') {
              $class .= '.aws-bedrock-chat-icon svg path:nth-child(1) {';
            }
            elseif ($key === 'toggle_inner') {
              $class .= '.aws-bedrock-chat-icon svg path:nth-child(2) {';
            }
            elseif ($key === 'submit_outer') {
              $class .= '.aws-bedrock-chat-input svg path {';
            }
            elseif ($key === 'submit_inner_bottom') {
              $class .= '.aws-bedrock-chat-input svg polygon:nth-child(1) {';
            }
            elseif ($key === 'submit_inner_top') {
              $class .= '.aws-bedrock-chat-input svg polygon:nth-child(2) {';
            }
            elseif ($key === 'input_focus') {
              $class .= 'div.aws-bedrock-chat-input .aws-bedrock-chat-user-input:focus {';
            }
            elseif ($key === 'submit_focus') {
              $class .= 'div.aws-bedrock-chat-input button:focus {';
            }
            else {
              $class .= current($value) . '.aws-bedrock-chat-' . str_replace('_', '-', $key) . ' {';
            }
          }
          if (isset($customize['interface']['style'][$key][$attribute][key($value)])) {
            $class .= str_replace('_', '-', $attribute) . ': ' . $customize['interface']['style'][$key][$attribute][key($value)] . ';';
          }
          if ($attribute === array_key_last($style)) {
            if ($key === 'input_focus') {
              $class .= 'border-width: 1px;border-style: solid;';
            }
            if ($key === 'submit_focus') {
              $class .= 'outline-width: 1px;outline-style: solid;';
            }
            $class .= "}\n";
          }
        }
        $cssMarkup .= $class;
      }
    }
    if ($customize['interface']['disable_shadow']) {
      $cssMarkup .= '.aws-bedrock-chat-main { box-shadow: none; }';
    }
    if ($customize['interface']['chat_width']) {
      $cssMarkup .= '@media (min-width: 64em) { form#aws-bedrock-chat-form { width: ' . $customize['interface']['chat_width'] . '} }';
    }
    return $cssMarkup;
  }

}
