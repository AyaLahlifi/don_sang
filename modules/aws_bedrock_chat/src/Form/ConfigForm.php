<?php

namespace Drupal\aws_bedrock_chat\Form;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\file\FileUsage\FileUsageInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a form for configuring AWS Bedrock Chat module settings.
 */
class ConfigForm extends ConfigFormBase {

  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

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
   * Constructs a new ConfigForm.
   *
   * @param \Drupal\Core\Session\AccountProxyInterface $current_user
   *   The current user.
   * @param \Drupal\file\FileUsage\FileUsageInterface $file_usage
   *   The file usage service.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager service.
   */
  public function __construct(AccountProxyInterface $current_user, FileUsageInterface $file_usage, EntityTypeManagerInterface $entity_type_manager) {
    $this->currentUser = $current_user;
    $this->fileUsage = $file_usage;
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('current_user'),
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
    return 'aws_bedrock_chat_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('aws_bedrock_chat.settings');

    if ($this->currentUser->hasPermission('administer aws bedrock chat')) {

      $form['aws_authentication'] = [
        '#type' => 'radios',
        '#title' => $this->t('AWS Authentication Method'),
        '#options' => [
          'profile' => $this->t('AWS Profile'),
          'keys' => $this->t('Access/Secret Keys'),
          'env' => $this->t('Environment Variables'),
        ],
        '#default_value' => $config->get('aws_authentication_method'),
        '#description' => $this->t('Select the method you prefer to authenticate with AWS Bedrock services.'),
        '#required' => TRUE,
      ];

      $form['aws_profile'] = [
        '#type' => 'textfield',
        '#title' => $this->t('AWS Profile Name'),
        '#default_value' => $config->get('aws_profile'),
        '#states' => [
          'visible' => [
            ':input[name="aws_authentication"]' => ['value' => 'profile'],
          ],
        ],
      ];

      $form['aws_access_key'] = [
        '#type' => 'textfield',
        '#title' => $this->t('AWS Access Key ID'),
        '#default_value' => $config->get('aws_access_key'),
        '#states' => [
          'visible' => [
            ':input[name="aws_authentication"]' => ['value' => 'keys'],
          ],
        ],
        '#description' => $this->t('(Leave blank to pull from environment variable AWS_ACCESS_KEY_ID) <strong>Note: Storing Access keys in the database is insecure and not recommended for production environments.</strong>'),
      ];

      $form['aws_secret_key'] = [
        '#type' => 'textfield',
        '#title' => $this->t('AWS Secret Access Key'),
        '#default_value' => $config->get('aws_secret_key'),
        '#states' => [
          'visible' => [
            ':input[name="aws_authentication"]' => ['value' => 'keys'],
          ],
        ],
        '#description' => $this->t('(Leave blank to pull from environment variable AWS_SECRET_ACCESS_KEY) <strong>Note: Storing Secret keys in the database is insecure and not recommended for production environments.</strong>'),
      ];

      $form['aws_env_info'] = [
        '#type' => 'item',
        '#markup' => $this->t('Authentication via Environment Variables will use the default credentials stored in your server environment.<br>For more information, see <a href="https://docs.aws.amazon.com/sdk-for-php/v3/developer-guide/guide_credentials_environment.html" target="_blank">AWS SDK for PHP - Environment Variables</a>.'),
        '#states' => [
          'visible' => [
            ':input[name="aws_authentication"]' => ['value' => 'env'],
          ],
        ],
      ];

      $form['model_arn'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Model ARN'),
        '#default_value' => $config->get('model_arn'),
        '#description' => $this->t('ARN of the AWS model (Example: arn:aws:bedrock:us-east-1::foundation-model/anthropic.claude-v2)'),
        '#required' => TRUE,
      ];

      $form['knowledge_base_id'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Knowledge Base ID'),
        '#default_value' => $config->get('knowledge_base_id'),
        '#description' => $this->t('ID of the AWS knowledge base (Example: EA1234ABCD)'),
        '#required' => TRUE,
        '#size' => 25,
      ];

      $form['search_type'] = [
        '#type' => 'select',
        '#title' => $this->t('Search Type'),
        '#options' => [
          'HYBRID' => $this->t('Hybrid'),
          'SEMANTIC' => $this->t('Semantic'),
        ],
        '#default_value' => $config->get('search_type'),
        '#description' => $this->t('Type of search to use for the Bedrock Knowledge Base.'),
        '#required' => TRUE,
      ];

      $form['region'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Region'),
        '#default_value' => $config->get('region'),
        '#description' => $this->t('AWS region (Example: us-east-1)'),
        '#required' => TRUE,
        '#size' => 25,
      ];

      $form["disable_api"] = [
        '#type' => 'checkbox',
        '#title' => $this->t('Disable API'),
        '#default_value' => $config->get('disable_api'),
        '#description' => $this->t('Enable to disable all calls to the AWS Bedrock API'),
      ];

      $form["debug"] = [
        '#type' => 'checkbox',
        '#title' => $this->t('Debug mode'),
        '#default_value' => $config->get('debug'),
        '#description' => $this->t('Enable to log all chat actions to PHP error log'),
      ];

      $form['#attached']['library'][] = 'aws_bedrock_chat/color_picker';
      return parent::buildForm($form, $form_state);
    }
    else {
      $other_tabs = '';
      if ($this->currentUser->hasPermission('customize aws bedrock chat') || $this->currentUser->hasPermission('translate aws bedrock chat')) {
        $other_tabs = ' or select a different tab above';
      }
      $form['limited_view'] = [
        '#type' => 'markup',
        '#markup' => $this->t('You do not have permission to view the configuration settings. Please contact a site administrator to ensure proper role permissions are set@other_tabs.', [
          '@other_tabs' => $other_tabs,
        ]),
      ];

      return $form;
    }

  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    if ($this->currentUser->hasPermission('administer aws bedrock chat')) {
      $this->config('aws_bedrock_chat.settings')
        ->set('aws_authentication_method', $form_state->getValue('aws_authentication'))
        ->set('aws_profile', $form_state->getValue('aws_profile'))
        ->set('aws_access_key', $form_state->getValue('aws_access_key'))
        ->set('aws_secret_key', $form_state->getValue('aws_secret_key'))
        ->set('model_arn', $form_state->getValue('model_arn'))
        ->set('knowledge_base_id', $form_state->getValue('knowledge_base_id'))
        ->set('search_type', $form_state->getValue('search_type'))
        ->set('region', $form_state->getValue('region'))
        ->set('disable_api', $form_state->getValue('disable_api'))
        ->set('debug', $form_state->getValue('debug'))
        ->save();

      parent::submitForm($form, $form_state);
    }
  }

}
