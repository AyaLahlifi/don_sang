<?php

namespace Drupal\mailgo\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Module config form.
 */
class GlobalConfigForm extends ConfigFormBase {

  /**
   * {@inheritDoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory')
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'mailgo.globalconfig',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'mailgo_global_config_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('mailgo.globalconfig');

    $form['theme'] = [
      '#type' => 'select',
      '#title' => $this->t('Theme'),
      '#description' => $this->t('The theme which will be used for MailGo pop-up.'),
      '#default_value' => $config->get('mailgo.theme'),
      '#options' => [
        'light' => $this->t("Light"),
        'dark' => $this->t("Dark"),
        'no_theme' => $this->t("No theme (custom CSS)"),
      ],
    ];

    $form['show_footer'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Show Footer'),
      '#description' => $this->t('Show or not the footer in the modal with <mailgo.dev> link.'),
      '#default_value' => $config->get('mailgo.show_footer'),
    ];

    $form['actions_gmail'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('GMail'),
      '#default_value' => $config->get('mailgo.actions.gmail'),
    ];

    $form['actions_outlook'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Outlook'),
      '#default_value' => $config->get('mailgo.actions.outlook'),
    ];

    $form['actions_yahoo'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Yahoo!'),
      '#default_value' => $config->get('mailgo.actions.yahoo'),
    ];

    $form['actions_whatsapp'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('WhatsApp'),
      '#default_value' => $config->get('mailgo.actions.whatsapp'),
    ];

    $form['actions_skype'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Skype'),
      '#default_value' => $config->get('mailgo.actions.skype'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);
    $config = $this->config('mailgo.globalconfig');
    $config->set('mailgo.theme', $form_state->getValue('theme'));
    $config->set('mailgo.show_footer', $form_state->getValue('show_footer'));
    $config->set('mailgo.actions.gmail', $form_state->getValue('actions_gmail'));
    $config->set('mailgo.actions.outlook', $form_state->getValue('actions_outlook'));
    $config->set('mailgo.actions.yahoo', $form_state->getValue('actions_yahoo'));
    $config->set('mailgo.actions.whatsapp', $form_state->getValue('actions_whatsapp'));
    $config->set('mailgo.actions.skype', $form_state->getValue('actions_skype'));
    $config->save();
  }

}
