<?php

namespace Drupal\mailgo\Plugin\Filter;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\filter\FilterProcessResult;
use Drupal\filter\Plugin\FilterBase;
use Drupal\mailgo\MailGoManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a filter to convert emails to mailgo links.
 *
 * @Filter(
 *   id = "mailgo_filter",
 *   title = @Translation("MailGo filter"),
 *   description = @Translation("Converts emails/phones into links with MailGo popup window"),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_MARKUP_LANGUAGE,
 * )
 */
class MailGoFilter extends FilterBase implements ContainerFactoryPluginInterface {

  /**
   * MailGoManager service.
   *
   * @var \Drupal\mailgo\MailGoManager
   */
  protected $mailGoManager;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, MailGoManager $mailgo_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->mailGoManager = $mailgo_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('mailgo')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    // E-mails processing.
    $form['mailgo_process_emails'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Process E-Mails'),
      '#default_value' => !empty($this->settings['mailgo_process_emails']) ? 1 : 0,
      '#description' => $this->t('Emails will be performed as MailGo-links'),
    ];
    // No spam activate.
    $form['mailgo_no_spam'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable anti-spam mode'),
      '#default_value' => !empty($this->settings['mailgo_no_spam']) ? 1 : 0,
      '#description' => $this->t('Hide email from DOM ("data" attributes required)'),
    ];
    // Phones processing.
    $form['mailgo_process_phones'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Process phone numbers'),
      '#default_value' => !empty($this->settings['mailgo_process_phones']) ? 1 : 0,
      '#description' => $this->t('Phone numbers will be performed as MailGo-links'),
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function process($text, $langcode) {

    $attachments = [
      'library' => [
        'mailgo/mailgo',
      ],
    ];
    $text = $this->mailGoManager->stripMailto($text);
    if (!empty($this->settings['mailgo_process_emails'])) {
      $text = $this->mailGoManager->processEmailsInText($text, $this->settings['mailgo_no_spam']);
    }
    if (!empty($this->settings['mailgo_process_phones'])) {
      $text = $this->mailGoManager->processPhonesInText($text);
    }
    return (new FilterProcessResult($text))
      ->setAttachments($attachments);
  }

  /**
   * {@inheritdoc}
   */
  public function tips($long = FALSE) {
    if ($long) {
      return $this->t('<p>You can convert emails & phone numbers to MailGo links</p>');
    }
    else {
      return $this->t('You can convert emails & phone numbers to MailGo links');
    }

  }

}
