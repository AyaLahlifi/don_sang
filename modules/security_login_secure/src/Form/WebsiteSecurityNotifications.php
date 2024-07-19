<?php

/**
 * @file
 * Contains \Drupal\security_login_secure\Form\WebsiteSecurityNotifications.
 */

namespace Drupal\security_login_secure\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBase;
use Drupal\security_login_secure\Utilities;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\security_login_secure\WebsiteSecurityConstants;

class WebsiteSecurityNotifications extends FormBase {

    public function getFormId() {
        return 'website_security_notifications';
    }

    public function buildForm(array $form, FormStateInterface $form_state){

    	global $base_url;

        $db_var = \Drupal::config('security_login_secure.settings');

        $form['markup_library'] = array(
            '#attached' => array(
                'library' => array(
                    "security_login_secure/security_login_secure.admin",
                )
            )
        );

        $form['markup_top'] = array(
         '#markup' => '<div class="ns_table_layout_1"><div class="ns_table_layout ns_container">
                       <h2>Notifications on Email</h2><hr><br>'
        );

        $default_email_vaules = !empty($db_var->get('website_security_email_id')) ? substr($db_var->get('website_security_email_id'),1) : '';
        $form['set_of_limit_login_features']['website_security_email_id_value'] = array(
            '#type' => 'textarea',
          	'#title' => t('Email ID to send notification emails <div class="ns_tooltip"><img src="'.$base_url . '/' . \Drupal::service('extension.list.module')->getPath('security_login_secure') . '/includes/images/icon3.png" alt="info icon" height="20px" width="15px"></div><div class="ns_tooltiptext">All Block and attack email alerts will be sent on the emails provided below.<br> Note: You will need to configure <b>SMTP</b> module to send email.</div>'),
            '#default_value' => $default_email_vaules,
            '#attributes' => array('placeholder' => 'Enter comma(,) separated email-id',),
            '#description' => t('<b>Note: </b>Provide comma(,) separated email-id at which notification email for attack detection and blocking will be sent. Keep it empty if you do not want to send email.'),
        );


    	$form['email_alerts'] = [
          '#type' => 'details',
          '#open' => False,
          '#title' => t('Templates for Email Notifications <a href="' . $base_url . WebsiteSecurityConstants::LICENSING_TAB_URL .'">[Premium]</a>'),
        ];

        $form['email_alerts']['attack_detection'] = [
          '#type' => 'details',
          '#open' => False,
          '#title' => t('Template for Attack Detection'),
        ];

        $form['email_alerts']['attack_detection']['email_to_attack_detection'] = [
          '#type' => 'textfield',
          '#title' => t('To'),
          '#attributes' => array('placeholder' => 'semi-colon (;) separated list of emails'),
          '#disabled' => TRUE,
        ];

        $form['email_alerts']['attack_detection']['email_subject_attack_detection'] = [
          '#type' => 'textfield',
          '#title' => t('Subject'),
          '#attributes' => array('placeholder' => 'Login attack detected at ##site##'),
          '#disabled' => TRUE,
        ];

        $form['email_alerts']['attack_detection']['email_body_attack_detection'] = [
          '#type' => 'textarea',
          '#title' => t('Body'),
          '#attributes' => array('placeholder' => 'The Attack Detection limit of ##attack_limits## has reached. Please take actions accordingly.'),
          '#disabled' => TRUE,
        ];

        $form['email_alerts']['blocked_account'] = [
          '#type' => 'details',
          '#open' => False,
          '#title' => t('Template for Blocked Account'),
        ];

        $form['email_alerts']['blocked_account']['email_to_blocked_account'] = [
          '#type' => 'textfield',
          '#title' => t('To'),
          '#attributes' => array('placeholder' => 'semi-colon (;) separated list of emails'),
          '#disabled' => TRUE,
        ];

        $form['email_alerts']['blocked_account']['email_subject_blocked_account'] = [
          '#type' => 'textfield',
          '#title' => t('Subject'),
          '#attributes' => array('placeholder' => 'The user ##username## has been blocked.'),
          '#disabled' => TRUE,
        ];

        $form['email_alerts']['blocked_account']['email_body_blocked_account'] = [
          '#type' => 'textarea',
          '#title' => t('Body'),
          '#attributes' => array('placeholder' => 'The user ##username## has been blocked due to amount of invalid login attempts.'),
          '#disabled' => TRUE,
        ];

        $form['notification_save'] = [
          '#type' => 'submit',
          '#value' => t('Save'),
        ];

        $form['aa'] = array(
        	'#markup' => '</div>',
        );

        $form['main_layout_div_end_1'] = array(
                '#markup' => '<div>',
        );
        
        Utilities::Two_FA_Advertisement($form, $form_state);

        return $form;

    }

    public function submitForm(array &$form, FormStateInterface $form_state) {
    	 $emails = filter_var(trim($form_state->getValue('website_security_email_id_value')));
       $email_id = explode(',', $emails);
       $valid_emails = '';
       if (!empty($emails))
         foreach ($email_id as $email){
            if (\Drupal::service('email.validator')->isValid($email))
              $valid_emails .= ',' . $email;
            else {
              $this->messenger()->addError(t('Please provide valid email-id.'));
              return;
            }
         }

       $this->configFactory()->getEditable('security_login_secure.settings')->set('website_security_email_id', $valid_emails)->save();

       $this->messenger()->addStatus(t('Configurations has been saved successfully.'));

    }

}
