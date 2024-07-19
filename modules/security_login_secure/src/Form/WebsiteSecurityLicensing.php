<?php

/**
 * @file
 * Contains \Drupal\security_login_secure\Form\WebsiteSecurityLicensing.
 */

namespace Drupal\security_login_secure\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBase;
use Drupal\security_login_secure\Utilities;
use Drupal\Core\Render\Markup;

class WebsiteSecurityLicensing extends FormBase {

    public function getFormId() {
        return 'website_security_licensing';
    }

    public function buildForm(array $form, FormStateInterface $form_state){
        global $base_url;
        $module_path = \Drupal::service('extension.list.module')->getPath("security_login_secure");
        $form['markup_library'] = array(
            '#attached' => array(
                'library' => array(
                    "security_login_secure/security_login_secure.admin",
                )
            )
        );
        
        $form['header_top_style_2'] = array(
            '#markup' => '<div class="ns_table_layout_1"><div class="ns_table_layout">'
        );
        
        $form['markup_1'] = array(
            '#markup' => '<br><br><h3>&nbsp; UPGRADE PLANS </h3><hr><br>'
        );

        $premium_url = 'https://www.miniorange.com/contact';

        $features = [
            [ Markup::create(t('<h3>FEATURES / PLANS</h3>')), Markup::create(t('<br><h2>FREE<p class="mo_websec_pricing"><sup>$</sup>0<sup>*</sup></p></h2>')), Markup::create(t('<br><h2>PREMIUM<p class="mo_websec_pricing"><sup>$</sup> 249 <sub>/year<sup>*</sup></sub></p></h2>'))],
            [ '',  Markup::create(t('<p class="button ">Active Plan</p>')), Markup::create(t('<a href="'.$premium_url.'" class="button button--danger">Contact Us</a>'))],
            [ Markup::create(t('Brute Force Protection')), Markup::create(t('&#x2714;')), Markup::create(t('&#x2714;'))],
            [ Markup::create(t('Show remaining login attempts to user')), Markup::create(t('&#x2714;')), Markup::create(t('&#x2714;'))],
            [ Markup::create(t('Set number of login failures before detecting an attack')),Markup::create(t('&#x2714;')), Markup::create(t('&#x2714;'))],
            [ Markup::create(t('Set number of login failures before detecting an attack')), Markup::create(t('&#x2714;')), Markup::create(t('&#x2714;'))],
            [ Markup::create(t('IP Blocking:(manual and automatic) [Blacklisting and whitelisting included]')), Markup::create(t('&#x2714;')), Markup::create(t('&#x2714;'))],
            [ Markup::create(t('View list of Blacklisted and whitelisted IPs')), Markup::create(t('&#x2714;')), Markup::create(t('&#x2714;'))],
            [ Markup::create(t('Email Alerts for IP blocking and unusual activities to admin and end users')), Markup::create(t('&#x2714;')), Markup::create(t('&#x2714;'))],
            [ Markup::create(t('Advanced activity logs auditing and reporting')), Markup::create(t('')), Markup::create(t('&#x2714;')) ],
            [ Markup::create(t('Advanced Blocking - Block users based on: IP range, Country Blocking.')), Markup::create(t('')), Markup::create(t('&#x2714;'))],
            [ Markup::create(t('Allow Role Login by IP Configuration')), Markup::create(t('')), Markup::create(t('&#x2714;'))],
            [ Markup::create(t('Contextual authentication based on Device,location,time and user behavior.')), Markup::create(t('')), Markup::create(t('&#x2714;'))],
            [ Markup::create(t('DOS Protection- Delays responses in case of an attack.')), Markup::create(t('')), Markup::create(t('&#x2714;'))],
            [ Markup::create(t('Icon based Authentication.')), Markup::create(t('')), Markup::create(t('&#x2714;'))],
            [ Markup::create(t('Enforce Strong Password : Check Password strength for all users')), Markup::create(t('')), Markup::create(t('&#x2714;'))],
            [ Markup::create(t('Google reCAPTCHA')), Markup::create(t('')), Markup::create(t('&#x2714;'))],
            [ Markup::create(t('HoneyPot- Divert hackers away from your assets.')), Markup::create(t('')), Markup::create(t('&#x2714;'))],
            [ Markup::create(t('Advanced User Verification.')), Markup::create(t('')), Markup::create(t('&#x2714;'))],
            [ Markup::create(t('Customized Email Templates')), Markup::create(t('')), Markup::create(t('&#x2714;'))],
            [ Markup::create(t('End to End Integration Support')), Markup::create(t('')), Markup::create(t('&#x2714;'))],
            [ Markup::create(t('Support')), Markup::create(t('Basic Email Support Available')), Markup::create(t('Premium Support Plans Available'))],
        ];

        $form['website_security_feature_list'] = array(
            '#type' => 'table',
            '#responsive' => TRUE,
            '#rows' => $features,
            '#size' => 5,
            '#attributes' => ['class' => ['website_security_upgrade_plans_features']],
        );

        $form['website_security_pricing'] = array(
            '#markup' => '<br><br><p>
            <b>&nbsp;&nbsp;&nbsp;&nbsp;**</b>Cost applicable for one instance on a per-year basis. Licenses are <b>subscription-based</b> and are subject to renewal after 12 months from the date of purchase.</p>'
        );

        $form['website_security_instance_info'] = array(
            '#markup' => '<br><div id="instance_info"><h3>What is an Instance ?</h3>
            <p>A Drupal instance refers to a single installation of a Drupal site. It refers to each individual website where the module is active. In the case of multisite/subsite Drupal setup, each site with a separate database will be counted as a single instance. For eg. If you have the dev-staging-prod type of environment then you will require 3 licenses of the module (with additional discounts applicable on pre-production environments). Contact us at <a href="mailto:drupalsupport@xecurify.com">drupalsupport@xecurify.com</a> for bulk discounts.</div><br>'
        );

        $form['website_security_payment_methods'] = array(
            '#markup' => '<div class="container mo-container payment_method_main_divs" id="payment_method">
            <h3 style="text-align: center; margin:3%;">PAYMENT METHODS</h3><hr><br><br>'
        );

        $form['card_method'] = array(
            '#markup' => '<div class="row"><div class="col-md-3 payment_method_inner_divs">
            <div><img src="'. $base_url . '/' . $module_path . '/includes/images/card_payment.png" width="120" ><h4>Card Payment</h4></div><hr>
            <p>If the payment is made through Credit Card/International Debit Card, the license will be created automatically once the payment is completed.</p>
            </div>'
        );

        $form['bank_transfer_method'] = array(
            '#markup' => '<div class="col-md-3 payment_method_inner_divs">
            <div><img src="'. $base_url . '/' . $module_path . '/includes/images/bank_transfer.png" width="150" ><h4>Bank Transfer</h4></div><hr>
            <p>If you want to use bank transfer for the payment then contact us at <a href="mailto:drupalsupport@xecurify.com">drupalsupport@xecurify.com</a> so that we can provide you the bank details.</p>
            </div>'
        );

        $form['return_policy'] = array(
            '#markup' => '</div><div class="mo_return_policy" style="text-align: center; margin:3%;"><h3>Return Policy</h3><hr></div>
            <p>At miniOrange, we want to ensure you are 100% happy with your purchase. If the premium module you purchased is not working as advertised and you have attempted to resolve any issues with our support team, which could not get resolved. We will refund the whole amount within 10 days of the purchase. Please email us at <a href="mailto:drupalsupport@xecurify.com">drupalsupport@xecurify.com</a> for any queries regarding the return policy.</p>'
        );

        $form['payment_end'] = array(
            '#markup' => '</div>'
        );

        $form['main_layout_div_end_1'] = array(
            '#markup' => '</div></div>',
        );

        return $form;
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {

    }

}
