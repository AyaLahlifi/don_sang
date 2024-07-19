<?php

namespace Drupal\aws_bedrock_chat\Form;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\Core\State\StateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a form for configuring AWS Bedrock Chat module translations.
 */
class TranslationForm extends FormBase implements ContainerInjectionInterface {

  /**
   * The language manager service.
   *
   * @var \Drupal\Core\Language\LanguageManagerInterface
   */
  protected $languageManager;

  /**
   * The state service.
   *
   * @var \Drupal\Core\State\StateInterface
   */
  protected $state;

  /**
   * Constructs a new TranslationForm.
   *
   * @param \Drupal\Core\Language\LanguageManagerInterface $language_manager
   *   The language manager service.
   * @param \Drupal\Core\State\StateInterface $state
   *   The state service.
   */
  public function __construct(LanguageManagerInterface $language_manager, StateInterface $state) {
    $this->languageManager = $language_manager;
    $this->state = $state;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('language_manager'),
      $container->get('state')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'aws_bedrock_chat_translation_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $languages = $this->languageManager->getLanguages();

    if (count($languages) > 1) {
      $default_language = $this->languageManager->getDefaultLanguage()->getId();

      foreach ($languages as $langcode => $language) {
        if ($langcode != $default_language) {
          $form['details_' . $langcode] = [
            '#type' => 'details',
            '#title' => $language->getName(),
            '#open' => FALSE,
          ];
          // Set language section to be open by default if a value exists.
          if ($this->state->get('aws_bedrock_chat.header_text.' . $langcode) ||
              $this->state->get('aws_bedrock_chat.start_text.' . $langcode) ||
              $this->state->get('aws_bedrock_chat.user_input_placeholder.' . $langcode)) {
            $form['details_' . $langcode]['#open'] = TRUE;
          }
          $form['details_' . $langcode]['header_text_' . $langcode] = [
            '#type' => 'textfield',
            '#title' => $this->t('Header text (@language)', ['@language' => $language->getName()]),
            '#default_value' => $this->state->get('aws_bedrock_chat.header_text.' . $langcode, ''),
          ];
          $form['details_' . $langcode]['start_text_' . $langcode] = [
            '#type' => 'textfield',
            '#title' => $this->t('Start text (@language)', ['@language' => $language->getName()]),
            '#default_value' => $this->state->get('aws_bedrock_chat.start_text.' . $langcode, ''),
          ];
          $form['details_' . $langcode]['user_input_placeholder_' . $langcode] = [
            '#type' => 'textfield',
            '#title' => $this->t('User input placeholder (@language)', ['@language' => $language->getName()]),
            '#default_value' => $this->state->get('aws_bedrock_chat.user_input_placeholder.' . $langcode, ''),
          ];
        }
      }

      $form['submit'] = [
        '#type' => 'submit',
        '#value' => $this->t('Save Translations'),
        '#attributes' => [
          'class' => ['button--primary'],
        ],
      ];
    }
    else {
      $form['no_translations'] = [
        '#markup' => $this->t('There are currently no additional languages enabled on the site to translate.'),
      ];
    }
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $languages = $this->languageManager->getLanguages();
    $default_language = $this->languageManager->getDefaultLanguage()->getId();
    foreach ($languages as $langcode => $language) {
      if ($langcode != $default_language) {
        $this->state->set('aws_bedrock_chat.header_text.' . $langcode, $form_state->getValue('header_text_' . $langcode));
        $this->state->set('aws_bedrock_chat.start_text.' . $langcode, $form_state->getValue('start_text_' . $langcode));
        $this->state->set('aws_bedrock_chat.user_input_placeholder.' . $langcode, $form_state->getValue('user_input_placeholder_' . $langcode));
      }
    }
    $this->messenger()->addMessage($this->t('The translations have been saved.'));
  }

}
