<?php

namespace Drupal\mailgo\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Plugin implementation of the 'url_embed' formatter.
 *
 * @FieldFormatter(
 *   id = "mailgo",
 *   label = @Translation("MailGo Link"),
 *   field_types = {
 *     "email"
 *   }
 * )
 */
class MailGoFormatter extends FormatterBase {

  /**
   * MailGoManager service.
   *
   * @var \Drupal\mailgo\MailGoManager
   */
  protected $mailGoManager;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    $instance = parent::create($container, $configuration, $plugin_id, $plugin_definition);
    $instance->mailGoManager = $container->get('mailgo');
    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'view_mode' => 'mailgo_email',
      'no_spam' => FALSE,
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $options = [
      'mailgo_email' => 'MailGo E-Mail Link',
      'regular_mailto' => 'Regular mailto',
    ];

    return [
      'view_mode' => [
        '#type' => 'select',
        '#title' => t('View mode of the MailGo'),
        '#options' => $options,
        '#default_value' => $this->getSetting('view_mode'),
      ],
      'no_spam' => [
        '#type' => 'checkbox',
        '#title' => t('Hide E-mail from DOM'),
        '#default_value' => $this->getSetting('no_spam'),
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    $summary[] = t('MailGo view mode: @view_mode', ['@view_mode' => $this->getSetting('view_mode')]);
    $summary[] = t('Prevent spam: @no_spam', ['@no_spam' => $this->getSetting('no_spam') ? 'yes' : 'no']);
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];
    $viewMode = $this->getSetting('view_mode');
    $noSpam = $this->getSetting('no_spam');

    $attachments = [
      'library' => [
        'mailgo/mailgo',
      ],
    ];
    foreach ($items as $delta => $item) {
      $text = $item->getValue();
      if (!empty($text['value'])) {
        $markup = NULL;
        switch ($viewMode) {
          case 'mailgo_email':
            $markup = $this->mailGoManager->processEmailsInText($text['value'], $noSpam);
            break;

          case 'regular_mailto':
            $markup = $this->mailGoManager->generateRegularMailToLink($text['value']);
            break;

          default:
            $markup = $text['value'];
        }
        $element[$delta]['#attached'] = $attachments;
        $element[$delta]['#markup'] = $markup;
      }
    }
    return $element;
  }

}
