<?php

namespace Drupal\aws_bedrock_chat\Form;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\FileUsage\FileUsageInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a form for customizing the AWS Bedrock Chat.
 */
class CustomizeForm extends ConfigFormBase {

  /**
   * The file usage service.
   *
   * @var \Drupal\file\FileUsage\FileUsageInterface
   */
  protected $fileUsage;

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new CustomizeForm.
   *
   * @param \Drupal\file\FileUsage\FileUsageInterface $file_usage
   *   The file usage service.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager service.
   */
  public function __construct(FileUsageInterface $file_usage, EntityTypeManagerInterface $entity_type_manager) {
    $this->fileUsage = $file_usage;
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('file.usage'),
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['aws_bedrock_chat.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'aws_bedrock_chat_customize_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    // Customization settings.
    $form['customize'] = $this->prepareCustomizeSettings();

    $form['#attached']['library'][] = 'aws_bedrock_chat/color_picker';
    return parent::buildForm($form, $form_state);
  }

  /**
   * Prepares the customize settings fields.
   */
  protected function prepareCustomizeSettings() {

    $config = $this->config('aws_bedrock_chat.settings');
    $customize_config = $config->get('customize') ?: [];

    $customize = [
      '#type' => 'container',
      '#tree' => TRUE,
    ];

    $customize['interface'] = [
      '#type' => 'details',
      '#title' => $this->t('Chat Interface'),
      '#open' => TRUE,
      '#tree' => TRUE,
    ];

    $customize['interface']['chat_width'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Chat Container Width'),
      '#description' => $this->t('Enter the width for the chat container (e.g., "400px" or "40%").'),
      '#default_value' => $customize_config['interface']['chat_width'] ?? '40%',
      '#size' => 12,
      '#maxlength' => 10,
    ];

    $customize['interface']['header_text'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Chat Header Text'),
      '#default_value' => $customize_config['interface']['header_text'] ?? 'Chat with us',
      '#description' => $this->t('Text to display in the chat header.'),
      '#attributes' => [
        'placeholder' => 'Chat with us',
      ],
    ];

    $customize['interface']['start_text'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Starting Message Text'),
      '#default_value' => $customize_config['interface']['start_text'] ?? 'Hi, how can we assist you today?',
      '#description' => $this->t('Text to display when the chat window is first opened.'),
      '#attributes' => [
        'placeholder' => 'Hi, how can we assist you today?',
      ],
    ];

    $customize['interface']['user_input_placeholder'] = [
      '#type' => 'textfield',
      '#title' => $this->t('User Input Placeholder'),
      '#default_value' => $customize_config['interface']['user_input_placeholder'] ?? 'Type your message here...',
      '#description' => $this->t('Placeholder text for the user input field.'),
      '#attributes' => [
        'placeholder' => 'Type your message here...',
      ],
    ];

    $customize['interface']['style'] = $this->prepareColorSettings($customize_config);

    $customize['interface']['disable_shadow'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Disable box shadow'),
      '#default_value' => $customize_config['interface']['disable_shadow'] ?? 0,
      '#description' => $this->t('Check to disable the box shadow underneath the chat container.'),
    ];

    // Image and path settings.
    $imgAndPathItems = $this->prepareImageAndPath($customize_config);
    if (!empty($imgAndPathItems)) {
      $customize = array_merge($customize, $imgAndPathItems);
    }

    $customize['display_related_files'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Display related files'),
      '#default_value' => $customize_config['display_related_files'] ?? 0,
      '#description' => $this->t('Enable to display related file links beneath the response messages.'),
    ];

    $customize['exclude_duplicate_files'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Exclude duplicate related files'),
      '#default_value' => $customize_config['exclude_duplicate_files'] ?? 0,
      '#states' => [
        'visible' => [
          ':input[name="customize[display_related_files]"]' => ['checked' => TRUE],
        ],
      ],
      '#description' => $this->t('Enable to exclude duplicate filenames found in different folders from the related file links.'),
    ];
    return $customize;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $customize = $form_state->getValue('customize');
    if (!empty($customize)) {
      $upload_keys = ['response', 'user', 'toggle', 'close'];
      foreach ($upload_keys as $key) {
        if (isset($customize[$key]['upload'][0]) && !empty($customize[$key]['upload'][0])) {
          /** @var \Drupal\file\FileInterface $file */
          $file = $this->entityTypeManager->getStorage('file')->load($customize[$key]['upload'][0]);
          if ($file) {
            $file->setPermanent();
            $file->save();
            // Mark the file as used.
            $this->fileUsage->add($file, 'aws_bedrock_chat', 'aws_bedrock_chat', $file->id());
          }
        }
      }
    }

    $this->config('aws_bedrock_chat.settings')
      ->set('customize', $form_state->getValue('customize'))
      ->save();

    parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);

    $customize = $form_state->getValue('customize');
    if (!empty($customize) && isset($customize['interface']['chat_width']) && !empty($customize['interface']['chat_width'])) {
      if (!preg_match('/^\d+(px|%)$/', $customize['interface']['chat_width'])) {
        $form_state->setErrorByName('customize][interface][chat_width', $this->t('Please enter a valid width (e.g., "400px" or "40%").'));
      }
    }
  }

  /**
   * Prepares the image and path fields.
   */
  protected function prepareImageAndPath($customize_config) {
    $customize = [];
    $items = [
      'response' => [
        'title' => 'Response Message Icon',
        'url' => [
          'description' => 'URL for the icon to display for response messages.',
          'placeholder' => 'https://example.com/user_icon.png',
        ],
        'upload' => [
          'description' => 'Upload an image to use for the response messages.',
        ],
      ],
      'user' => [
        'title' => 'User Message Icon',
        'url' => [
          'description' => 'URL for the icon to display for user messages.',
          'placeholder' => 'https://example.com/user_icon.png',
        ],
        'upload' => [
          'description' => 'Upload an image to use for the user messages.',
        ],
      ],
      'toggle' => [
        'title' => 'Open/Toggle Button',
        'url' => [
          'description' => 'URL for the icon to toggle the chat window.',
          'placeholder' => 'https://example.com/toggle_icon.png',
        ],
        'upload' => [
          'description' => 'Upload an image to use for the toggling of the chat window.',
        ],
      ],
      'close' => [
        'title' => 'Close Button',
        'url' => [
          'description' => 'URL for the icon to close the chat window.',
          'placeholder' => 'https://example.com/close_icon.png',
        ],
        'upload' => [
          'description' => 'Upload an image to use for the closing of the chat window.',
        ],
      ],
      'loading' => [
        'title' => 'Loading Image/Gif',
        'url' => [
          'description' => 'URL for the image/gif to display while loading responses.',
          'placeholder' => 'https://example.com/ajax_loader.gif',
        ],
        'upload' => [
          'description' => 'Upload an image to use when loading the response.',
        ],
      ],
    ];

    foreach ($items as $item => $data) {
      $customize[$item] = [
        '#type' => 'details',
        '#title' => $this->t('@title', ['@title' => $data['title']]),
        '#open' => FALSE,
        '#tree' => TRUE,
      ];

      if (!empty($customize_config[$item]['upload']) || !empty($customize_config[$item]['url'])) {
        $customize[$item]['#open'] = TRUE;
      }

      $customize[$item]['url'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Icon Path/URL'),
        '#default_value' => $customize_config[$item]['url'] ?? '',
        '#description' => $this->t('@description', ['@description' => $data['url']['description']]),
        '#attributes' => [
          'placeholder' => $data['url']['placeholder'],
        ],
      ];

      $customize[$item]['upload'] = [
        '#type' => 'managed_file',
        '#title' => $this->t('Upload Icon', ['@title' => $data['title']]),
        '#upload_location' => 'public://',
        '#default_value' => isset($customize_config[$item]['upload'][0]) ? [$customize_config[$item]['upload'][0]] : NULL,
        '#description' => $this->t('@description', ['@description' => $data['upload']['description']]),
        '#upload_validators' => [
          'file_validate_extensions' => ['png jpg jpeg gif'],
        ],
      ];

      $customize[$item]['use_uploaded'] = [
        '#type' => 'checkbox',
        '#title' => $this->t('Use uploaded image as @title', ['@title' => strtolower($data['title'])]),
        '#default_value' => $customize_config[$item]['use_uploaded'] ?? 0,
        '#states' => [
          'visible' => [
            ':input[name="files[customize_' . $item . '_upload]"]' => ['!value' => ''],
          ],
        ],
      ];
    }
    return $customize;
  }

  /**
   * Prepares the color settings fields.
   */
  protected function prepareColorSettings($customize_config) {

    $color = [
      '#type' => 'details',
      '#title' => $this->t('Color Settings'),
      '#open' => FALSE,
      '#tree' => TRUE,
    ];

    $color['main']['background'] = $this->prepareColorSelect('main', "Main Background", 'background', '#ffffff', $customize_config);
    $color['main']['border_color'] = $this->prepareColorSelect('main', "Main Border", 'border_color', '#0e1e45', $customize_config);
    $color['header']['background_color'] = $this->prepareColorSelect('header', "Header Background", 'background_color', '#0e1e45', $customize_config);
    $color['header_text']['color'] = $this->prepareColorSelect('header_text', "Header Text", 'color', '#ffffff', $customize_config);
    $color['response']['background_color'] = $this->prepareColorSelect('response', "Response Background", 'background_color', '#f1f0f0', $customize_config);
    $color['response_text']['color'] = $this->prepareColorSelect('response_text', "Response Text", 'color', '#000000', $customize_config);
    $color['user']['background_color'] = $this->prepareColorSelect('user', "User Text Background", 'background_color', '#ccdef7', $customize_config);
    $color['user_text']['color'] = $this->prepareColorSelect('user_text', "User Text", 'color', '#000000', $customize_config);
    $color['toggle_outer']['fill'] = $this->prepareColorSelect('toggle_outer', "Toggle Button Outer", 'fill', '#0e1e45', $customize_config);
    $color['toggle_inner']['fill'] = $this->prepareColorSelect('toggle_inner', "Toggle Button Inner", 'fill', '#0e1e45', $customize_config);
    $color['submit_outer']['fill'] = $this->prepareColorSelect('submit_outer', "Submit Button Outer", 'fill', '#0e1e45', $customize_config);
    $color['submit_inner_top']['fill'] = $this->prepareColorSelect('submit_inner_top', "Submit Button Inner Top", 'fill', '#0e1e45', $customize_config);
    $color['submit_inner_bottom']['fill'] = $this->prepareColorSelect('submit_inner_bottom', "Submit Button Inner Bottom", 'fill', '#0e1e45', $customize_config);
    $color['submit_focus']['outline'] = $this->prepareColorSelect('submit_focus', "Submit Button Focus", 'outline', '#0e1e45', $customize_config);
    $color['input_focus']['border'] = $this->prepareColorSelect('input_focus', "Input Text Field Focus", 'border', '#0e1e45', $customize_config);

    return $color;
  }

  /**
   * Prepares the color select fields.
   */
  protected function prepareColorSelect($type, $label, $attribute, $default, $customize_config) {

    $color_field = [
      '#title' => $this->t('@label', ['@label' => $label]),
      '#type' => 'container',
      '#attributes' => [
        'class' => ['aws-bedrock-chat-color-container'],
      ],
    ];

    $color_field['color_code'] = [
      '#type' => 'textfield',
      '#title' => $this->t('@label Color', ['@label' => $label]),
      '#default_value' => $customize_config['interface']['style'][$type][$attribute]['color_code'] ?? $default,
      '#attributes' => [
        'class' => ['abc-color-code'],
      ],
      '#description' => $this->t('Choose or enter a hex color code for the @label.', ['@label' => strtolower($label)]),
    ];

    $color_field['color_picker'] = [
      '#type' => 'color',
      '#default_value' => $customize_config['interface']['style'][$type][$attribute]['color_picker'] ?? $default,
      '#attributes' => [
        'class' => ['abc-color-picker'],
      ],
    ];

    return $color_field;
  }

}
