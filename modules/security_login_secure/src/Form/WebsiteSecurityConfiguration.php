<?php

/**
 * @file
 * Contains \Drupal\security_login_secure\Form\WebsiteSecurityConfiguration.
 */

namespace Drupal\security_login_secure\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBase;
use Drupal\security_login_secure\Utilities;
use Drupal\security_login_secure\WebsiteSecurityConstants;

class WebsiteSecurityConfiguration extends FormBase {

    public function getFormId() {
        return 'website_security_configuration';
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
                       <h2>Brute Force Protection from an IP</h2>This feature protects your site from attacks by blocking an IP which tries to login with random usernames and passwords.<hr><br>'
        );

        $form['website_security_ip_enable_bruteforce'] = array(
          '#type' => 'checkbox',
          '#title' => t('<b>Enable Brute Force Protection</b>'),
          '#default_value' => $db_var->get('website_security_ip_enable_bruteforce'),
        );

        $prefixname = '<div class="ns_row"><div class="ns_name">';
        $suffixname = '</div>';

        $prefixvalue = '<div class="ns_value">';
        $suffixvalue = '</div></div>';

        $form['set_of_limit_login_features'] = array(
            '#type' => 'fieldset',
            '#attributes' => array( 'style' => array('padding:14px 12px 14px;color:#34495e;border-radius:10px;') ),
            '#states' => array(
            // Only show this field when the checkbox is enabled.
            'visible' => array(
                ':input[name="website_security_ip_enable_bruteforce"]' => array('checked' => TRUE),
                  ),
            ),
        );

        $form['set_of_limit_login_features']['website_security_ip_track_time'] = array(
            '#markup' => 'Track time to check for security violations (hours) <div class="ns_tooltip"><img src="'.$base_url . '/' . \Drupal::service('extension.list.module')->getPath('security_login_secure') . '/includes/images/icon3.png" alt="info icon" height="20px" width="15px"></div><div class="ns_tooltiptext">The time in hours for which the failed login attempts are monitored. After that time, the attempts are deleted and will never be considered again.<br> <b>Note: </b>Provide 0 if you do not want to enable the feature.</div>',
            '#prefix' => $prefixname,
            '#suffix' => $suffixname,
        );

        $form['set_of_limit_login_features']['website_security_ip_track_time_value'] = array(
            '#type' => 'number',
            '#min' => 0,
            '#prefix' => $prefixvalue,
            '#suffix' => $suffixvalue,
            '#default_value' => $db_var->get('website_security_ip_track_time'),
        );

        $form['set_of_limit_login_features']['website_security_ip_allowed_attempts_name'] = array(
            '#markup' => 'Number of login failures before blocking an IP <div class="ns_tooltip"><img src="'.$base_url . '/' . \Drupal::service('extension.list.module')->getPath('security_login_secure') . '/includes/images/icon3.png" alt="info icon" height="20px" width="15px"></div><div class="ns_tooltiptext">The number of failed login attempts through an IP before it gets blocked. After that count, the IP is blocked, and user can never login using that IP until it is unblocked by admin or after the time provided below.</div>',
            '#prefix' => $prefixname,
            '#suffix' => $suffixname,
        );

        $form['set_of_limit_login_features']['website_security_ip_allowed_attempts_value'] = array(
            '#type' => 'number',
            '#min' => 1,
            '#prefix' => $prefixvalue,
            '#suffix' => $suffixvalue,
            '#default_value' => $db_var->get('website_security_ip_allowed_attempts'),
        );

        $form['set_of_limit_login_features']['website_security_ip_blocked'] = array(
            '#markup' => 'Time period for which IP should be blocked (hours) <div class="ns_tooltip"><img src="'.$base_url . '/' . \Drupal::service('extension.list.module')->getPath('security_login_secure') . '/includes/images/icon3.png" alt="info icon" height="20px" width="15px"></div><div class="ns_tooltiptext">The time in hours for which the IP will remain in blocked state. After that time, the IP will be unblocked.<br> <b>Note: </b>Provide 0 if you want to permanently block an IP.</div>',
            '#prefix' => $prefixname,
            '#suffix' => $suffixname,
        );

        $form['set_of_limit_login_features']['website_security_ip_blocked_time'] = array(
            '#type' => 'number',
            '#min' => 0,
            '#prefix' => $prefixvalue,
            '#suffix' => $suffixvalue,
            '#default_value' => $db_var->get('website_security_ip_block_time_period'),
        );   

        $form['set_of_limit_login_features']['website_security_attack_allowed_attempts_name'] = array(
            '#markup' => 'Number of login failures before detecting an attack <div class="ns_tooltip"><img src="'.$base_url . '/' . \Drupal::service('extension.list.module')->getPath('security_login_secure') . '/includes/images/icon3.png" alt="info icon" height="20px" width="15px"></div><div class="ns_tooltiptext">The number of failed login attempts through an IP that can be considered as an attack. After that count, the admin gets a notification email about the attack.<br> <b>Note: </b>Provide a number less than the allowed attempts or else provide 0 if you do not want to send alert mail.</div>',
            '#prefix' => $prefixname,
            '#suffix' => $suffixname,
        );

        $form['set_of_limit_login_features']['website_security_attack_ip_allowed_attempts_value'] = array(
            '#type' => 'number',
            '#min' => 0,
            '#prefix' => $prefixvalue,
            '#suffix' => $suffixvalue,
            '#default_value' => $db_var->get('website_security_ip_attack_detection'),
        );     

        $form['website_security_ip_config_submit'] = array(
            '#type' => 'submit',
            '#value' => t('Save IP Configurations'),
            '#submit' => array('::website_security_ip_configurations'),
            '#prefix' => '<br>',
            '#suffix' => '</div>',
        );

        Utilities::Two_FA_Advertisement($form, $form_state);

        $form['naagin'] = [
          '#markup' => '</div></div><div class="ns_table_layout ns_container"><h2>Brute Force Protection from an User</h2>This feature protects your site from attacks by blocking an user which tries to login with random passwords.<hr><br>'
        ];

        $form['website_security_user_enable_bruteforce'] = array(
          '#type' => 'checkbox',
          '#title' => t('<b>Enable Brute Force Protection</b>'),
          '#default_value' => $db_var->get('website_security_user_enable_bruteforce'),
        );

        $form['set_of_user_limit_login_features'] = array(
            '#type' => 'fieldset',
            '#attributes' => array( 'style' => array('padding:14px 12px 14px;color:#34495e;border-radius:10px;') ),
            '#states' => array(
            // Only show this field when the checkbox is enabled.
            'visible' => array(
                ':input[name="website_security_user_enable_bruteforce"]' => array('checked' => TRUE),
                  ),
            ),
        );

        $form['set_of_user_limit_login_features']['website_security_user_track_time'] = array(
            '#markup' => 'Track time to check for security violations (hours) <div class="ns_tooltip"><img src="'.$base_url . '/' . \Drupal::service('extension.list.module')->getPath('security_login_secure') . '/includes/images/icon3.png" alt="info icon" height="20px" width="15px"></div><div class="ns_tooltiptext">The time in hours for which the failed login attempts are monitored. After that time, the attempts are deleted and will never be considered again.<br> <b>Note: </b>Provide 0 if you do not want to enable the feature.</div>',
            '#prefix' => $prefixname,
            '#suffix' => $suffixname,
        );

        $form['set_of_user_limit_login_features']['website_security_user_track_time_value'] = array(
            '#type' => 'number',
            '#min' => 0,
            '#prefix' => $prefixvalue,
            '#suffix' => $suffixvalue,
            '#default_value' => $db_var->get('website_security_user_track_time'),
        );

        $form['set_of_user_limit_login_features']['website_security_user_allowed_attempts_name'] = array(
            '#markup' => 'Number of login failures before blocking an User <div class="ns_tooltip"><img src="'.$base_url . '/' . \Drupal::service('extension.list.module')->getPath('security_login_secure') . '/includes/images/icon3.png" alt="info icon" height="20px" width="15px"></div><div class="ns_tooltiptext">The number of failed login attempts by an User before it gets blocked. After that count, the user will be blocked from the site until it is unblocked by admin or after the time provided below.</div>',
            '#prefix' => $prefixname,
            '#suffix' => $suffixname,
        );

        $form['set_of_user_limit_login_features']['website_security_user_allowed_attempts_value'] = array(
            '#type' => 'number',
            '#min' => 1,
            '#prefix' => $prefixvalue,
            '#suffix' => $suffixvalue,
            '#default_value' => $db_var->get('website_security_user_allowed_attempts'),
        );

        $form['set_of_user_limit_login_features']['website_security_user_blocked'] = array(
            '#markup' => 'Time period for which User should be blocked (hours) <div class="ns_tooltip"><img src="'.$base_url . '/' . \Drupal::service('extension.list.module')->getPath('security_login_secure') . '/includes/images/icon3.png" alt="info icon" height="20px" width="15px"></div><div class="ns_tooltiptext">The time in hours for which the user will remain in blocked state. After that time, the user will be unblocked.<br> <b>Note: </b>Provide 0 if you want to permanently block an user.</div>',
            '#prefix' => $prefixname,
            '#suffix' => $suffixname,
        );

        $form['set_of_user_limit_login_features']['website_security_user_blocked_time'] = array(
            '#type' => 'number',
            '#min' => 0,
            '#prefix' => $prefixvalue,
            '#suffix' => $suffixvalue,
            '#default_value' => $db_var->get('website_security_user_block_time_period'),
        );

        $form['set_of_user_limit_login_features']['website_security_attack_user_allowed_attempts_name'] = array(
            '#markup' => 'Number of login failures before detecting an attack <div class="ns_tooltip"><img src="'.$base_url . '/' . \Drupal::service('extension.list.module')->getPath('security_login_secure') . '/includes/images/icon3.png" alt="info icon" height="20px" width="15px"></div><div class="ns_tooltiptext">The number of failed login attempts by an User that can be considered as an attack. After that count, the admin and user gets a notification email about the attack.<br> <b>Note: </b>Provide a number less than the allowed attempts or else provide 0 if you do not want to send alert mail.</div>',
            '#prefix' => $prefixname,
            '#suffix' => $suffixname,
        );

        $form['set_of_user_limit_login_features']['website_security_user_attack_allowed_attempts_value'] = array(
            '#type' => 'number',
            '#min' => 0,
            '#prefix' => $prefixvalue,
            '#suffix' => $suffixvalue,
            '#default_value' => $db_var->get('website_security_user_attack_detection'),
        );

        $form['set_of_user_limit_login_features']['website_security_show_remaining'] = array(
            '#markup' => 'Show remaining login attempts to user:',
            '#prefix' => $prefixname,
            '#suffix' => $suffixname,
        );

        $form['set_of_user_limit_login_features']['website_security_show_remaining_value'] = array(
            '#type' => 'checkbox',
            '#prefix' => $prefixvalue,
            '#suffix' => $suffixvalue,
            '#default_value' => $db_var->get('website_security_show_remaining_attempts'),
        );

        $form['website_security_user_config_submit'] = array(
            '#type' => 'submit',
            '#value' => t('Save User Configurations'),
            '#submit' => array('::website_security_user_configurations'),
            '#prefix' => '<br>',
            '#suffix' => '</div>',
        );

            $form['main_layout_div_end_1'] = array(
                '#markup' => '<div>',
            );
        

        return $form;
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {
      
    }

    function website_security_ip_configurations(&$form, $form_state){

        $enable_ip_bruteforce = $form_state->getValue('website_security_ip_enable_bruteforce');
        $db_var = $this->configFactory()->getEditable('security_login_secure.settings');

        if ($enable_ip_bruteforce == 1){
      
            $db_var->set('website_security_ip_track_time', $form_state->getValue('website_security_ip_track_time_value'))
                   ->set('website_security_ip_allowed_attempts', $form_state->getValue('website_security_ip_allowed_attempts_value'))
                   ->set('website_security_ip_attack_detection', $form_state->getValue('website_security_attack_ip_allowed_attempts_value'))
                   ->set('website_security_ip_block_time_period', $form_state->getValue('website_security_ip_blocked_time'))
                   ->save();

        }else {
            $db_var->set('website_security_ip_track_time', null)
                   ->set('website_security_ip_allowed_attempts', null)
                   ->set('website_security_ip_attack_detection', null)
                   ->set('website_security_ip_block_time_period', null)
                   ->save();
        }

        $db_var->set('website_security_ip_enable_bruteforce', $enable_ip_bruteforce)->save();
        $this->messenger()->addStatus(t('IP Configurations has been saved successfully.'));
    }

    function website_security_user_configurations(&$form, $form_state){

        $enable_user_bruteforce = $form_state->getValue('website_security_user_enable_bruteforce');
        $db_var = $this->configFactory()->getEditable('security_login_secure.settings');

        if ($enable_user_bruteforce == 1){
      
            $db_var->set('website_security_user_track_time', $form_state->getValue('website_security_user_track_time_value'))
                ->set('website_security_user_allowed_attempts', $form_state->getValue('website_security_user_allowed_attempts_value'))
                ->set('website_security_user_attack_detection', $form_state->getValue('website_security_user_attack_allowed_attempts_value'))
                ->set('website_security_user_block_time_period', $form_state->getValue('website_security_user_blocked_time'))
                ->set('website_security_show_remaining_attempts', $form_state->getValue('website_security_show_remaining_value'))
                ->save();

        } else{
            $db_var->set('website_security_user_track_time', null)
                ->set('website_security_user_allowed_attempts', null)
                ->set('website_security_user_attack_detection', null)
                ->set('website_security_user_block_time_period', null)
                ->set('website_security_show_remaining_attempts', null)
                ->save();
        }

        $db_var->set('website_security_user_enable_bruteforce', $enable_user_bruteforce)->save();
        $this->messenger()->addStatus(t('User Configurations has been saved successfully.'));
    }

}