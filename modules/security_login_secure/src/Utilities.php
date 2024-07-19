<?php
namespace Drupal\security_login_secure;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Ajax\RedirectCommand;
use Drupal\Core\Url;
/**
 * This file is part of miniOrange Website Security module.
 *
 * miniOrange Website Security module is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * miniOrange Website Security module is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with miniOrange Website Security module.  If not, see <http://www.gnu.org/licenses/>.
 */
class Utilities {

    /**
     * Advertise 2FA
     */

    public static function Two_FA_Advertisement(array &$form, FormStateInterface $form_state){
        global $base_url;
        
        $form['markup_idp_attr_hea555der_top_support'] = array(
            '#markup' => '<div class="ns_table_layout_support_1 mo_2fa_advt" style="height:27em;">',
        );

        $form['miniorangerr_otp_email_address'] = array(
            '#markup' => '<div><h5 class="h_3"  >Looking for a Drupal Two-Factor Authentication(2FA)?<br></h5></div><div class="mo_adv_tfa"><img src="'.$base_url . '/' . \Drupal::service('extension.list.module')->getPath('security_login_secure') . '/includes/images/miniorange_i.png" alt="miniOrange Logo" height="80px" width="80px" class="mo_img_adv"><h5 class="mo_txt_h3">Two-Factor Authentication (2FA)</h5></div>',
        );

        $form['minioranqege_otp_phone_number'] = array(
            '#markup' => '<div class="mo_paragraph"><p><em>Two Factor Authentication (2FA) module adds a second layer of authentication at the time of login to secure your Drupal accounts. It is a highly secure and easy to setup module which protects your site from hacks and unauthorized login attempts.</em></p></div>',
        );

        $form['miniorange_otp_2fa_button'] = array(
            '#markup' => '<div style="align:center;"><span><a href="https://www.drupal.org/project/miniorange_2fa" class="button button--primary" target="_blank" id="tfa_btn_download">Download Module</a>
      <a href="https://plugins.miniorange.com/drupal-two-factor-authentication-2fa" class="button" target="_blank" id="mo_tfa_btn_know">Know More</a></span>'
        );

    }

    public static function saved_support($form, &$form_state) {
        $email = trim($form['website_security_email_address_support']['#value']);
        $phone = trim($form['website_security_phone_number_support']['#value']);
        $query = trim($form['website_security_support_query_support']['#value']);

        self::website_security_send_query($email, $phone, $query);
    }

    /**
     * Send support query.
     */
    Public static function website_security_send_query($email, $phone, $query) {
        if(empty($email)||empty($query)){
            \Drupal::messenger()->addMessage(t('The <b><u>Email</u></b> and <b><u>Query</u></b> fields are mandatory.'), 'error');
            return;
        } elseif(!\Drupal::service('email.validator')->isValid($email)) {
            \Drupal::messenger()->addMessage(t('The email address <b><i>' . $email . '</i></b> is not valid.'), 'error');
            return;
        }
        $support = new MiniorangeWebsiteSecuritySupport($email, $phone, $query);
        $support_response = $support->sendSupportQuery();
        if($support_response) {
            \Drupal::messenger()->addMessage(t('Thanks for getting in touch! We will get back to you soon.'), 'status');
        }
        else {
            \Drupal::messenger()->addMessage(t('Error sending support query.'), 'error');
        }
    }

    /**
    * Check if curl is installed.
    */
    public static function isCurlInstalled() {
        if (in_array('curl', get_loaded_extensions())) {
            return 1;
        } else {
            return 0;
        }
    }

  public static function drupal_is_cli()
  {
    $server = \Drupal::request()->server;
    $server_software = $server->get('SERVER_SOFTWARE');
    $server_argc = $server->get('argc');

    if(!isset($server_software) && (php_sapi_name() == 'cli' || (is_numeric($server_argc) && $server_argc > 0)))
      return TRUE;
    else
      return FALSE;
  }
}
