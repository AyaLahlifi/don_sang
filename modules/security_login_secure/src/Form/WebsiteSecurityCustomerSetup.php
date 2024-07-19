<?php

/**
 * @file
 * Contains \Drupal\security_login_secure\Form\WebsiteSecurityCustomerSetup.
 */

namespace Drupal\security_login_secure\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBase;
use Drupal\security_login_secure\Utilities;
use Drupal\security_login_secure\MiniorangeWebsiteSecurityVerificationCustomer;
use Drupal\security_login_secure\WebsiteSecurityConstants;
use Symfony\Component\HttpFoundation;
use Symfony\Component\HttpFoundation\RedirectResponse;

class WebsiteSecurityCustomerSetup extends FormBase {

    public function getFormId() {
        return 'website_security_customer_setup';
    }

    public function buildForm(array $form, FormStateInterface $form_state){
    	
        $form['markup_library'] = array(
            '#attached' => array(
                'library' => array(
                    "security_login_secure/security_login_secure.admin",
                )
            )
        );

        global $base_url;

        $current_status = \Drupal::config('security_login_secure.settings')->get('website_security_status');

        if ($current_status == 'VALIDATE_OTP') {

            //Utilities::visual_tour_start($form, $form_state);

            $form['website_security_customer_otp_token'] = array(
                '#type' => 'textfield',
                '#title' => t('OTP<span style="color: #FF0000">*</span>'),
                '#attributes' => array('style' => 'width:55%'),
                '#prefix' => '<div class="ns_table_layout_1"><div class="ns_table_layout ns_container">',
                '#suffix' => '<br>',
            );

            $form['website_security_customer_validate_otp_button'] = array(
                '#type' => 'submit',
                '#value' => t('Validate OTP'),
                '#submit' => array('::website_security_validate_otp_submit'),
            );

            $form['website_security_customer_setup_resendotp'] = array(
                '#type' => 'submit',
                '#value' => t('Resend OTP'),
                '#submit' => array('::website_security_resend_otp'),
            );

            $form['website_security_customer_setup_back'] = array(
                '#type' => 'submit',
                '#value' => t('Back'),
                '#submit' => array('::website_security_back'),
            );

            $form['main_layout_div_end_1'] = array(
                '#markup' => '</div><div>',
            );
            Utilities::Two_FA_Advertisement($form, $form_state);

            return $form;

        }elseif($current_status == 'LOGIN'){
            
            $form['markup_top'] = array(
                '#markup' => '<h2>Login with miniOrange</h2><hr>',
                '#prefix' => '<div class="ns_table_layout_1"><div id="Register_Section" class="ns_table_layout ns_container">'
            );

            $form['website_security_customer_email'] = array(
                '#type' => 'textfield',
                '#title' => t('Email'),
                '#required' => True,
                '#attributes' => array(
                    'style' => 'width:50%'
                ),
            );

            $form['website_security_customer_password'] = array(
                '#type' => 'password',
                '#title' => t('Password'),
                '#required' => True,
                '#attributes' => array(
                    'style' => 'width:50%'
                ),
            );

            $form['login_submit'] = array(
                '#type' => 'submit',
                '#button_type' => 'primary',
                '#value' => t('Login')
            );

            $form['back_button'] = array(
                '#type' => 'submit',
                '#submit' => array('::back_to_register_tab'),
                '#value' => t('Create an account?')
            );

            $form['main_layout_div_end_1'] = array(
                '#markup' => '</div>',
            );

            Utilities::Two_FA_Advertisement($form, $form_state);

            return $form;

        }elseif ($current_status == 'PLUGIN_CONFIGURATION') {

            //Utilities::visual_tour_start($form, $form_state);

            $form['markup_top'] = array(
                '#markup' => '<div class="ns_table_layout_1"><div class="ns_table_layout ns_container">
                                  <div class="ns_welcome_message">Thank you for registering with miniOrange</div><br><br>
                                  <h4>Your Profile: </h4>'
            );

            $header = array(
                'email' => array('data' => t('Customer Email')),
                'customerid' => array('data' => t('Customer ID')),
                'token' => array('data' => t('Token Key')),
                'apikey' => array('data' => t('API Key')),
            );

            $options = [];
            $options[0] = array(
                'email' => \Drupal::config('security_login_secure.settings')->get('website_security_customer_admin_email'),
                'customerid' => \Drupal::config('security_login_secure.settings')->get('website_security_customer_id'),
                'token' => \Drupal::config('security_login_secure.settings')->get('website_security_customer_admin_token'),
                'apikey' => \Drupal::config('security_login_secure.settings')->get('website_security_customer_api_key'),
            );

            $form['fieldset']['customerinfo'] = array(
                '#theme' => 'table',
                '#header' => $header,
                '#rows' => $options,
                '#suffix' => '<br><br><br><br><br><br><h4>Remove Account:</h4>'
            );

            $form['Premium_feature_Note'] = array(
                '#markup' => '<div class="ns_highlight_background_note"><b>Note:</b> This feature is available in <a href="' . $base_url . WebsiteSecurityConstants::LICENSING_TAB_URL .'">[Premium]</a> version of the module</div>',
            );

            $form['website_security_customer_Remove_Account'] = array(
                '#type' => 'submit',
                '#value' => t('Remove Account'),
                '#disabled' => TRUE,
                '#suffix' => '<br><br><hr></div>',
                '#prefix' => '<p>This section will help you to remove your current logged in account without losing your current configurations.</p>'
            );

            $form['main_layout_div_end_1'] = array(
                '#markup' => '<div>',
            );
            Utilities::Two_FA_Advertisement($form, $form_state);

            return $form;
        }

        //Utilities::visual_tour_start($form, $form_state);

        $form['register_login_with_miniorange'] = array(
            '#markup' => '<h3>Register/Login with miniOrange (Optional)</h3><hr>',
            '#prefix' => '<div class="ns_table_layout_1"><div id="Register_Section" class="ns_table_layout ns_container">'
        );

        $form['why_should_i_register_msg'] = array(
            '#markup' => '<h4>Why should I register?</h4><div class="ns_highlight_background_note_1">You should register so that in case you need help, we can help you with step by step instructions.
                <b>You will also need a miniOrange account to upgrade to the premium version of the module.</b> 
                We do not store any information except the email that you will use to register with us.</div><br>'
        );

        $form['valid_email_id_msg'] = array(
            '#markup' => '<div class="ns_highlight_background_note_1">Please enter a valid email id that you have access to. We will send OTP to this email for verification.</div>'
        );

        $form['website_security_customer_setup_username'] = array(
            '#type' => 'textfield',
            '#title' => t('Email<span style="color: #FF0000">*</span>'),
            '#description' => t('<b>Note:</b> Use valid Email-Id. (We discourage the use of disposable emails)'),
            '#attributes' => array(
                'style' => 'width:73%'
            ),
        );

        $form['website_security_customer_setup_phone'] = array(
            '#type' => 'textfield',
            '#title' => t('Phone'),
            '#description' => t('<b>Note:</b> We will only call if you need support.'),
            '#attributes' => array(
                'style' => 'width:73%'
            ),
        );

        $form['website_security_customer_setup_password'] = array(
            '#type' => 'password_confirm',
        );

        $form['website_security_customer_setup_button'] = array(
            '#type' => 'submit',
            '#button_type' => 'primary',
            '#value' => t('Register'),
            '#prefix' => '<br> <div class="mo_row"><div class="ns_name">',
            '#suffix' => '</div>'
        );

        $form['website_security_already_have_account'] = array(
            '#type' => 'submit',
            '#value' => 'Already have an account?',
            '#submit' => array('::already_registred_customer'),
            '#prefix' => '<div class="already_have_account">',
            '#suffix' => '</div></div><br>'
        );

        $form['main_layout_div_end_1'] = array(
                '#markup' => '</div>',
        );

        Utilities::Two_FA_Advertisement($form, $form_state);

        return $form;
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {
        
        $db_var = \Drupal::configFactory()->getEditable('security_login_secure.settings');
        $current_status = $db_var->get('website_security_status');
        if($current_status == 'LOGIN'){
            $username = trim($form['website_security_customer_email']['#value']);
            $password = trim($form['website_security_customer_password']['#value']);
        }else{
            $username = trim($form['website_security_customer_setup_username']['#value']);
            $phone =    trim($form['website_security_customer_setup_phone']['#value']);
            $password = trim($form['website_security_customer_setup_password']['#value']['pass1']);
        }
        
        if(empty($username)||empty($password)){
            \Drupal::messenger()->addMessage(t('The <b><u>Email </u></b> and <b><u>Password</u></b> fields are mandatory.'), 'error');
            return;
        }

        if (!\Drupal::service('email.validator')->isValid($username)) {
            \Drupal::messenger()->addMessage(t('The email address <i>' . $username . '</i> is not valid.'), 'error');
            return;
        }
        $customer_config = new MiniorangeWebsiteSecurityVerificationCustomer($username, $phone, $password, NULL);
        $check_customer_response = json_decode($customer_config->checkCustomer());
        
        if ($check_customer_response->status == 'CUSTOMER_NOT_FOUND') {
            $db_var->set('website_security_customer_admin_email', $username)
                   ->set('website_security_customer_admin_phone', $phone)
                   ->set('website_security_customer_admin_password', $password)
                   ->save();

            $send_otp_response = json_decode($customer_config->sendOtp());

            if ($send_otp_response->status == 'SUCCESS') {
                $current_status = 'VALIDATE_OTP';
                $db_var->set('website_security_tx_id', $send_otp_response->txId)
                       ->set('website_security_status', $current_status)
                       ->save();
                \Drupal::messenger()->addMessage(t('Verify email address by entering the passcode sent to @username', ['@username' => $username]),'status');
            }
        }
        elseif ($check_customer_response->status == 'TRANSACTION_LIMIT_EXCEEDED') {
            \Drupal::messenger()->addMessage(t('An error has been occured. Please try after some time.'), 'error');
        }
        elseif ($check_customer_response->status == 'CURL_ERROR') {
            \Drupal::messenger()->addMessage(t('cURL is not enabled. Please enable cURL'), 'error');
        }
        else {
            $customer_keys_response = json_decode($customer_config->getCustomerKeys());
            if (json_last_error() == JSON_ERROR_NONE) {
                $current_status = 'PLUGIN_CONFIGURATION';

                $db_var->set('website_security_customer_id', $customer_keys_response->id)
                       ->set('website_security_customer_admin_token', $customer_keys_response->token)
                       ->set('website_security_customer_admin_email', $username)
                       ->set('website_security_customer_admin_phone', $phone)
                       ->set('website_security_customer_api_key', $customer_keys_response->apiKey)
                       ->set('website_security_status', $current_status)
                       ->save();

                \Drupal::messenger()->addMessage(t('Successfully retrieved your account.'), 'status');
            }
            else {
                \Drupal::messenger()->addMessage(t('Invalid credentials'), 'error');
            }
        }
    }

    public static function back_to_register_tab(){
        global $base_url;
        $current_status = '';
        \Drupal::configFactory()->getEditable('security_login_secure.settings')->set('website_security_status',$current_status)->save();
        $url = $base_url . '/admin/config/people/security_login_secure/WebsiteSecurityCustomerSetup';
		$response = new RedirectResponse($url);
        $response->send();
    }

    public static function already_registred_customer(){
        global $base_url;
        $current_status = 'LOGIN';
        \Drupal::configFactory()->getEditable('security_login_secure.settings')->set('website_security_status',$current_status)->save();
        $url = $base_url . '/admin/config/people/security_login_secure/WebsiteSecurityCustomerSetup';
		$response = new RedirectResponse($url);
        $response->send();
    }

    public function website_security_back(&$form, $form_state) {
        $current_status = 'CUSTOMER_SETUP';
        $db_var = \Drupal::configFactory()->getEditable('security_login_secure.settings');
        $db_var->set('website_security_status', $current_status)->save();

        $db_var->clear('website_security_customer_admin_email')
               ->clear('website_security_customer_admin_phone')
               ->clear('website_security_tx_id')
               ->save();

        \Drupal::messenger()->addMessage(t('Register/Login with your miniOrange Account'),'status');
    }

    public function website_security_resend_otp(&$form, $form_state) {
        $db_var = \Drupal::configFactory()->getEditable('security_login_secure.settings');
        $config = \Drupal::config('security_login_secure.settings');
        $db_var->clear('website_security_tx_id')->save();
        $username = $config->get('website_security_customer_admin_email');
        $phone = $config->get('website_security_customer_admin_phone');
        $customer_config = new MiniorangeWebsiteSecurityVerificationCustomer($username, $phone, NULL, NULL);
        $send_otp_response = json_decode($customer_config->sendOtp());
        if ($send_otp_response->status == 'SUCCESS') {
            // Store txID.
            $current_status = 'VALIDATE_OTP';
            $db_var->set('website_security_tx_id', $send_otp_response->txId)
                   ->set('miniorange_otp_verification_status', $current_status)
                   ->save();

            \Drupal::messenger()->addMessage(t('Verify email address by entering the passcode sent to @username', array('@username' => $username)),'status');
        }
    }

    public function website_security_validate_otp_submit(&$form, $form_state) {
        $db_var = \Drupal::configFactory()->getEditable('security_login_secure.settings');
        $config = \Drupal::config('security_login_secure.settings');
        $otp_token = $form['website_security_customer_otp_token']['#value'];
        $otp_token = trim($otp_token);
        if (empty($otp_token)) {
            \Drupal::messenger()->addMessage(t('The OTP field is required.'), 'error');
            return;
        }
        $username = $config->get('website_security_customer_admin_email');
        $phone = $config->get('website_security_customer_admin_phone');
        $tx_id = $config->get('website_security_tx_id');
        $customer_config = new MiniorangeWebsiteSecurityVerificationCustomer($username, $phone, NULL, $otp_token);
        $validate_otp_response = json_decode($customer_config->validateOtp($tx_id));

        if ($validate_otp_response->status == 'SUCCESS')
        {
            $db_var->clear('website_security_tx_id')->save();
            $password = $config->get('website_security_customer_admin_password');
            $customer_config = new MiniorangeWebsiteSecurityVerificationCustomer($username, $phone, $password, NULL);
            $create_customer_response = json_decode($customer_config->createCustomer());
            if ($create_customer_response->status == 'SUCCESS') {
                $current_status = 'PLUGIN_CONFIGURATION';
                $db_var->set('website_security_status', $current_status)
                       ->set('website_security_customer_admin_email', $username)
                       ->set('website_security_customer_admin_phone', $phone)
                       ->set('website_security_customer_admin_token', $create_customer_response->token)
                       ->set('website_security_customer_id', $create_customer_response->id)
                       ->set('website_security_customer_api_key', $create_customer_response->apiKey)
                       ->save();
                \Drupal::messenger()->addMessage(t('Customer account created successfully.'), 'status');
            }
            else {
                \Drupal::messenger()->addMessage(t('There was an error while creating customer. Please try again later.'), 'error');
            }
        }
        else {
            \Drupal::messenger()->addMessage(t('There was an error while validating OTP. Please try again.'), 'error');
        }
    }

}