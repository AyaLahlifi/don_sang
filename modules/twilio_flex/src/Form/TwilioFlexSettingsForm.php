<?php

namespace Drupal\twilio_flex\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Messenger\MessengerInterface;
use GuzzleHttp\Exception\ClientException;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Configure Twilio Flex settings.
 */
class TwilioFlexSettingsForm extends ConfigFormBase {

  /**
   * The Messenger service.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * The logger service.
   *
   * @var \Psr\Log\LoggerInterface
   */
  protected $logger;

  /**
   * Constructs a new NegotiationUrlForm object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The factory for configuration objects.
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger.
   * @param \Psr\Log\LoggerInterface $logger
   *   The logger service.
   */
  public function __construct(ConfigFactoryInterface $config_factory, MessengerInterface $messenger, LoggerInterface $logger) {
    parent::__construct($config_factory);
    $this->messenger = $messenger;
    $this->logger = $logger;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('messenger'),
      $container->get('logger.channel.twilio_flex')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'twilio_flex_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['twilio_flex.settings'];
  }

  /**
   * Retrieves a configuration object.
   *
   * @return \Drupal\Core\Config\Config|\Drupal\Core\Config\ImmutableConfig
   *   An editable configuration object if the given name is listed in the
   *   getEditableConfigNames() method or an immutable configuration object if
   *   not.
   */
  protected function getEditableConfig() {
    $config_names = $this->getEditableConfigNames();
    $config_name = reset($config_names);
    return $this->config($config_name);
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->getEditableConfig();

    $form['twilio_flex_account_sid'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Account SID'),
      '#required' => TRUE,
      '#default_value' => $config->get('twilio_flex_account_sid'),
      '#description' => $this->t('Twilio Account SID, ie AC...'),
    ];

    $form['twilio_flex_flow_sid'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Flex Flow SID'),
      '#required' => TRUE,
      '#default_value' => $config->get('twilio_flex_flow_sid'),
      '#description' => $this->t('Twilio Flex Flow SID, ie FO...'),
    ];

    $form['twilio_flex_main_header_title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Header title'),
      '#required' => TRUE,
      '#default_value' => $config->get('twilio_flex_main_header_title'),
      '#description' => $this->t('Header title (default: <em>Chat with Us</em>)'),
    ];

    $form['twilio_flex_msg_canvas_welcome'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Canvas welcome message'),
      '#required' => TRUE,
      '#default_value' => $config->get('twilio_flex_msg_canvas_welcome'),
      '#description' => $this->t('Canvas welcome message (default: <em>Welcome to customer service</em>)'),
    ];

    $form['twilio_flex_msg_canvas_predefined_author'] = [
      '#type' => 'textfield',
      '#title' => $this->t('First message author'),
      '#required' => TRUE,
      '#default_value' => $config->get('twilio_flex_msg_canvas_predefined_author'),
      '#description' => $this->t('First message author (default: <em>Bot</em>)'),
    ];

    $form['twilio_flex_msg_canvas_predefined_body'] = [
      '#type' => 'textfield',
      '#title' => $this->t('First message body'),
      '#required' => TRUE,
      '#default_value' => $config->get('twilio_flex_msg_canvas_predefined_body'),
      '#description' => $this->t('First message body (default: <em>Hi there! How can we help you today?</em>)'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->getEditableConfig();
    $config->set('twilio_flex_account_sid', $form_state->getValue('twilio_flex_account_sid'));
    $config->set('twilio_flex_flow_sid', $form_state->getValue('twilio_flex_flow_sid'));
    $config->set('twilio_flex_main_header_title', $form_state->getValue('twilio_flex_main_header_title'));
    $config->set('twilio_flex_msg_canvas_welcome', $form_state->getValue('twilio_flex_msg_canvas_welcome'));
    $config->set('twilio_flex_msg_canvas_predefined_author', $form_state->getValue('twilio_flex_msg_canvas_predefined_author'));
    $config->set('twilio_flex_msg_canvas_predefined_body', $form_state->getValue('twilio_flex_msg_canvas_predefined_body'));
    $config->save();
    parent::submitForm($form, $form_state);

  }

}
