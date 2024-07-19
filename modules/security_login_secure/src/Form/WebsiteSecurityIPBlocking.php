<?php

/**
 * @file
 * Contains \Drupal\security_login_secure\Form\WebsiteSecurityLicensing.
 */

namespace Drupal\security_login_secure\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBase;
use Drupal\security_login_secure\Utilities;
use Drupal\user\Entity\User;
use Drupal\security_login_secure\WebsiteSecurityConstants;

class WebsiteSecurityIPBlocking extends FormBase {

    public function getFormId() {
        return 'website_security_ipblocking';
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
                       <h2>Blocking/Whitelisting IPs</h2><hr><br>'
        );

        $form['website_security_enable_ip_blocking'] = [
            '#type' => 'checkbox',
            '#title' => t('<b>Enable IP Blocking</b>'),
            '#default_value' => $db_var->get('website_security_enable_ip_blocking'),
        ];

        $form['block_ip_list'] = array(
            '#type' => 'fieldset',
            '#attributes' => array( 'style' => array('padding:14px 12px 14px;color:#34495e;border-radius:10px;') ),
            '#states'=>array(
                'visible' => array(
                    ':input[name="website_security_enable_ip_blocking"]' => array('checked' =>True),
                ),
            ),
        );

        $form['block_ip_list']['markup'] = [
            '#markup' => '<h3>Manual Block IPs</h3>'
        ];


        $form['block_ip_list']['manual_block_ip_address'] = [
            '#type' => 'textarea',
            '#attributes' => ['placeholder' => t('semicolon(;) separated IP address')],
            '#default_value' => $db_var->get('website_security_block_ips'),
            '#description' => t('<b>Note: </b>Provide semicolon(;) separated IP address that will be blocked from the site.'),
        ];

        $form['website_security_enable_ip_whitelisting'] = [
            '#type' => 'checkbox',
            '#title' => t('<b>Enable IP Whitelisting</b>'),
            '#default_value' => $db_var->get('website_security_enable_ip_whitelisting'),
        ];

        $form['whitelist_ip_list'] = array(
            '#type' => 'fieldset',
            '#attributes' => array( 'style' => array('padding:14px 12px 14px;color:#34495e;border-radius:10px;') ),
            '#states'=>array(
                'visible' => array(
                    ':input[name="website_security_enable_ip_whitelisting"]' => array('checked' =>True),
                ),
            ),
        );

        $form['whitelist_ip_list']['markup'] = [
            '#markup' => '<h3>Whitelist IPs</h3>'
        ];

        $form['whitelist_ip_list']['manual_whitelist_ip_address'] = [
            '#type' => 'textarea',
            '#attributes' => ['placeholder' => t('semicolon(;) separated IP address')],
            '#default_value' => $db_var->get('website_security_white_ips'),
            '#description' => t('<b>Note: </b>Provide semicolon(;) separated IP address that will be whitelisted and will never be blocked in any case.'),
        ];

        $form['whitelist_ip_list']['whitelist_user'] = [
            '#type' => 'checkbox',
            '#title' => t('<b>Enable User whitelisting if IP is whitelisted</b> <div class="ns_tooltip"><img src="'.$base_url . '/' . \Drupal::service('extension.list.module')->getPath('security_login_secure') . '/includes/images/icon3.png" alt="info icon" height="20px" width="15px"></div><div class="ns_tooltiptext">Enable this feature if you do not want your site users to be blocked if the corresponding IP is whitelisted.<br> Note: If you do not enable this feature then site users will be blocked after 5 invalid attempts (Drupal default behaviour) even if IP is whitelisted.</div>'),
            '#default_value' => $db_var->get('website_security_disable_user_blocking'),
        ];

        $form['website_security_enforce_strong_password'] = [
          '#type' => 'checkbox',
          '#title' => t('<b>Enforce Strong Password <a href="' . $base_url . WebsiteSecurityConstants::LICENSING_TAB_URL .'">[Premium]</a></b> <div class="ns_tooltip"><img src="'.$base_url . '/' . \Drupal::service('extension.list.module')->getPath('security_login_secure') . '/includes/images/icon3.png" alt="info icon" height="20px" width="15px"></div><div class="ns_tooltiptext">Enable this feature if you want to enforce your users to save strong password while registration. A strong password is difficult to be guessed using manual and automatic password cracking tools.</div>'),
          '#disabled' => TRUE,
        ];

        $form['website_security_enable_bot_detection'] = [
            '#type' => 'checkbox',
            '#title' => t('<b>Enable Bot Blocking <a href="' . $base_url . WebsiteSecurityConstants::LICENSING_TAB_URL .'">[Premium]</a></b> <div class="ns_tooltip"><img src="'.$base_url . '/' . \Drupal::service('extension.list.module')->getPath('security_login_secure') . '/includes/images/icon3.png" alt="info icon" height="20px" width="15px"></div><div class="ns_tooltiptext">Check this feature if you want to enable bot detection. A botnet is a network of compromised computers under the control of a malicious actor. Each individual device in a botnet is referred to as a bot. A bot is formed when a computer gets infected with malware that enables third-party control.</div>'),
            '#disabled' => TRUE,
        ];

        $form['website_security_dos_protection'] = [
            '#type' => 'checkbox',
            '#title' => t('<b>Enable DoS Protection <a href="' . $base_url . WebsiteSecurityConstants::LICENSING_TAB_URL .'">[Premium]</a></b> <div class="ns_tooltip"><img src="'.$base_url . '/' . \Drupal::service('extension.list.module')->getPath('security_login_secure') . '/includes/images/icon3.png" alt="info icon" height="20px" width="15px"></div><div class="ns_tooltiptext">A denial-of-server attack is an explicit attempt to deny users from using a service or computer resource. Enable DoS protection feature can filter suspicious or unreasonable packets to prevent from flooding the network with large amounts of fake traffic.</div>'),
            '#disabled' => TRUE,
        ];

        $form['website_security_risk_based_authentication'] = [
            '#type' => 'checkbox',
            '#title' => t('<b>Enable Risk Based Authentication <a href="' . $base_url . WebsiteSecurityConstants::LICENSING_TAB_URL .'">[Premium]</a></b> <div class="ns_tooltip"><img src="'.$base_url . '/' . \Drupal::service('extension.list.module')->getPath('security_login_secure') . '/includes/images/icon3.png" alt="info icon" height="20px" width="15px"></div><div class="ns_tooltiptext">Risk-based implementation allows the application to challenge the user for additional credentials only when the risk level is appropriate. Enable this feature if you want to allow risk-based authentication.</div>'),
            '#disabled' => TRUE,
        ];

        $form['website_security_advanced_blocking'] = [
          '#type' => 'details',
          '#open' => False,
          '#title' => t('<b>Advanced Blocking <a href="' . $base_url . WebsiteSecurityConstants::LICENSING_TAB_URL .'">[Premium]</a></b>'),
        ];

        $form['website_security_advanced_blocking']['website_security_add_block_ip_range'] = [
            '#type' => 'textfield',
            '#title' => t('IP Range  <div class="ns_tooltip"><img src="'.$base_url . '/' . \Drupal::service('extension.list.module')->getPath('security_login_secure') . '/includes/images/icon3.png" alt="info icon" height="20px" width="15px"></div><div class="ns_tooltiptext">This feature allows you to block a complete IP range from accessing the Drupal site.</div>'),
            '#attributes' => array('placeholder' => 'For eg. a.b.c.d-a.b.c.e;a.b.c.d-a.b.c.e'),
            '#description' => t('<b>Note: </b>Provide dash(-) in between the IP range that you want to block and if you want to block multiple IP range then separate them using semicolon(;).'),
            '#disabled' => TRUE,
        ];


        $form['website_security_advanced_blocking']['website_security_add_country_name_value'] = [
            '#type' => 'textfield',
            '#title' => t('Country Name  <div class="ns_tooltip"><img src="'.$base_url . '/' . \Drupal::service('extension.list.module')->getPath('security_login_secure') . '/includes/images/icon3.png" alt="info icon" height="20px" width="15px"></div><div class="ns_tooltiptext">This feature allows you to block site access requests from the country names provided in the textbox.</div>'),
            '#attributes' => array('placeholder' => 'For eg. country_name;country_name;country_name'),
            '#description' => t('<b>Note: </b>Provide semicolon(;) separated country names from where you want to block site access requests.'),
            '#disabled' => TRUE,
        ];

        $form['website_security_advanced_blocking']['advanced_blocking_save'] = [
            '#type' => 'submit',
            '#value' => t('Add'),
            '#disabled' => TRUE,
        ];

        $form['role_login_markup_top'] = [
            '#type' => 'details',
            '#open' => False,
            '#title' => 'Allow Role Login by IP Configuration <b><a href="' . $base_url . WebsiteSecurityConstants::LICENSING_TAB_URL .'">[Premium]</a></b>'
        ];

        $form['role_login_markup_top']['website_security_allowed_ip_range_value'] = [
            '#type' => 'textfield',
            '#title' => t('Allowed IP Range <div class="ns_tooltip"><img src="'.$base_url . '/' . \Drupal::service('extension.list.module')->getPath('security_login_secure') . '/includes/images/icon3.png" alt="info icon" height="20px" width="15px"></div><div class="ns_tooltiptext">This feature allows you to select roles and provide IP range in which user with selected role and IP address within defined IP range will be allowed to login.</div>'),
            '#attributes' => array('placeholder' => 'For eg. 123.2.3.1-123.2.3.25;145.25.32.2-145.25.32.15'),
            '#description' => t('<b>Note: </b>Provide dash(-) in between the IP range that you want to block and if you want to block multiple IP range then separate them using semi-colon(;).'),
            '#disabled' => TRUE,
        ];

        $mrole = user_role_names(TRUE);

        $form['role_login_markup_top']['website_security_select_roles_markup'] = [
            '#markup' => '<br><b>What roles do you want to allow login within specified IP range? </b>'
        ];

        foreach ($mrole as $key => $value) {
            $form['role_login_markup_top']['website_security_allowed_role_' . $key] = [
                '#type' => 'checkbox',
                '#title' => $value,
                '#disabled' => TRUE,
            ];
        }

        $form['website_security_save'] = [
            '#type' => 'submit',
            '#value' => t('Save'),
        ];

        $form['last'] = [
            '#markup' => '</div>',
        ];

            $form['main_layout_div_end_1'] = array(
                '#markup' => '<div>',
            );
        Utilities::Two_FA_Advertisement($form, $form_state);

        return $form;
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {

        $config = $this->configFactory()->getEditable('security_login_secure.settings');
        $account = User::load(\Drupal::currentUser()->id());
        $enable_ip_blocking = $form_state->getValue('website_security_enable_ip_blocking');
        $enable_ip_whitelisting = $form_state->getValue('website_security_enable_ip_whitelisting');
        $whitelist_user = $form_state->getValue('whitelist_user');

        if ($enable_ip_blocking == 1) {
            $block_ips = filter_var(trim($form_state->getValue('manual_block_ip_address')));
            if (empty($block_ips)) {
                $this->messenger()->addError(t('IP address for blocking is required.'));
                return;
            }
            $block_ips = $this->website_security_validate_ip_address($block_ips, 'blocking');
        }

        if ($enable_ip_whitelisting == 1) {
            $whitelist_ips = filter_var(trim($form_state->getValue('manual_whitelist_ip_address')));
            if (empty($whitelist_ips)) {
                $this->messenger()->addError(t('IP address for whitelist is required.'));
                return;
            }
            $whitelist_ips = $this->website_security_validate_ip_address($whitelist_ips, 'whitelisting');
        }

        if ($enable_ip_blocking == 1 && $enable_ip_whitelisting == 1) {
            $blocked_ips = explode(';', $block_ips);
            $whitelisted_ips = explode(';', $whitelist_ips);
            $common_ips = array_intersect($blocked_ips, $whitelisted_ips);

            if (count($common_ips) > 0) {
                $block_ips = implode(';', array_diff($blocked_ips, $whitelisted_ips));
                $whitelist_ips = implode(';', array_diff($whitelisted_ips, $blocked_ips));
                $common_ips = implode(',', $common_ips);
                $this->messenger()->addWarning(t('The following IPs '. $common_ips .' can either be blocked or whitelisted and hence not saved.'));
                \Drupal::state()->set('warning_in_saving_config', TRUE);
            }

            $config->set('website_security_block_ips', $block_ips)
                   ->set('website_security_white_ips', $whitelist_ips)
                   ->save();

            $this->website_security_add_to_reports($whitelist_ips, $account->getAccountName(), 'IP Whitelisted');
            $this->website_security_add_to_reports($block_ips, $account->getAccountName(), 'IP Blacklisted');

        }elseif ($enable_ip_blocking == 1) {
            $config->set('website_security_block_ips', $block_ips)->save();
            $this->website_security_add_to_reports($block_ips, $account->getAccountName(), 'IP Blacklisted');
        }elseif ($enable_ip_whitelisting == 1) {
            $config->set('website_security_white_ips', $whitelist_ips)->save();
            $this->website_security_add_to_reports($whitelist_ips, $account->getAccountName(), 'IP Whitelisted');
        }


        $config->set('website_security_enable_ip_blocking', $enable_ip_blocking)
               ->set('website_security_enable_ip_whitelisting', $enable_ip_whitelisting)
               ->set('website_security_disable_user_blocking', $whitelist_user)
               ->save();

        if (!\Drupal::state()->get('warning_in_saving_config', FALSE))
            $this->messenger()->addStatus(t('Configurations has been saved successfully.'));

        \Drupal::state()->set('warning_in_saving_config', FALSE);

    }

    function website_security_validate_ip_address($ip_addresses, $type){
        $ip_addresses = array_filter(array_unique(explode(';',$ip_addresses)));
        $valid_ips = array();
        $invalid_ips = array();
        foreach ($ip_addresses as $ip_address){

            if ($type == 'blocking' && $ip_address == \Drupal::request()->getClientIp()) {
                $this->messenger()->addWarning(t('You cannot block your own IP address i.e. '.$ip_address.'.'));
                \Drupal::state()->set('warning_in_saving_config', TRUE);
                continue;
            }

            if (!filter_var($ip_address, FILTER_VALIDATE_IP))
                array_push($invalid_ips, $ip_address);
            else
                array_push($valid_ips, $ip_address);
        }

        if (count($invalid_ips) > 0) {
            $invalid_ips = implode(',', $invalid_ips);
            $this->messenger()->addWarning(t('The following IP address <i>'.$invalid_ips.'</i> for '.$type.' is not valid and hence not saved.'));
            \Drupal::state()->set('warning_in_saving_config', TRUE);
        }

        return implode(';', $valid_ips);
    }

    function website_security_add_to_reports($ip_addresses, $username, $status){
        $db = \Drupal::database();

        $ip_addresses = explode(';',$ip_addresses);
        foreach ($ip_addresses as $ip_address) {
            if (!empty($ip_address))
                $db->insert('miniorange_website_security_reports')
                    ->fields([
                        'ip_address' => $ip_address,
                        'uname' => $username,
                        'status' => $status,
                        'timestamp' => \Drupal::time()->getRequestTime(),
                    ])
                    ->execute();

        }

    }

}

