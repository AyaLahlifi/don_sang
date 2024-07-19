<?php

namespace Drupal\security_login_secure\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Ajax\RedirectCommand;
use Drupal\security_login_secure\Utilities;

class WebsiteSecurityCustomerRequest extends Formbase{
    public function getFormId() {
        return 'website_security_customer_request';
    }

    public function buildForm(array $form, FormStateInterface $form_state, $options = NULL) {
        $form['#prefix'] = '<div id="modal_support_form">';
        $form['#suffix'] = '</div>';
        $form['status_messages'] = [
            '#type' => 'status_messages',
            '#weight' => -10,
        ];

        $user_email = \Drupal::config('security_login_secure.settings')->get('website_security_customer_admin_email');
        $phone = \Drupal::config('security_login_secure.settings')->get('website_security_customer_admin_phone');

        $form['website_security_support_email_address'] = array(
          '#type' => 'email',
          '#title' => t('Email'),
          '#default_value' => $user_email,
          '#required'=>true,
          '#attributes' => array('placeholder' => t('Enter your email'), 'style' => 'width:99%;margin-bottom:1%;'),
        );

        $form['website_security_support_phone_number'] = array(
          '#type' => 'textfield',
          '#title' => t('Phone'),
          '#default_value' => $phone,
          '#attributes' => array('placeholder' => t('Enter number with country code Eg. +00xxxxxxxxxx'), 'style' => 'width:99%;margin-bottom:1%;'),
        );

        $form['website_security_support_query'] = array(
          '#type' => 'textarea',
          '#title' => t('Query'),
          '#required'=>true,
          '#attributes' => array('placeholder' => t('Describe your query here!'), 'style' => 'width:99%'),
        );

        $form['actions'] = array('#type' => 'actions');
        $form['actions']['send'] = [
          '#type' => 'submit',
          '#value' => $this->t('Submit'),
          '#attributes' => [
            'class' => [
              'use-ajax',
              'button--primary'
            ],
          ],
          '#ajax' => [
            'callback' => [$this, 'submitModalFormAjax'],
            'event' => 'click',
          ],
        ];

        $form['#attached']['library'][] = 'core/drupal.dialog.ajax';
        return $form;
    }

    public function submitModalFormAjax(array $form, FormStateInterface $form_state) {
        $response = new AjaxResponse();
        // If there are any form errors, AJAX replace the form.
        if ( $form_state->hasAnyErrors() ) {
            $response->addCommand(new ReplaceCommand('#modal_support_form', $form));
        } else {
          $email = trim($form['website_security_support_email_address']['#value']);
          $phone = trim($form['website_security_support_phone_number']['#value']);
          $query = $form['website_security_support_query']['#value'];

          Utilities::website_security_send_query($email, $phone, $query);
          $response->addCommand(new RedirectCommand(\Drupal\Core\Url::fromRoute('security_login_secure.configuration')->toString()));
        }
        return $response;
    }

    //This is abstract method in parent class so need to override here
    public function validateForm(array &$form, FormStateInterface $form_state) { }

    //This is abstract method in parent class so need to override here
    public function submitForm(array &$form, FormStateInterface $form_state) { }

}