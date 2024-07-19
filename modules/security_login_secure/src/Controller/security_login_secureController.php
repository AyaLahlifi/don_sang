<?php

namespace Drupal\security_login_secure\Controller;

use Drupal\security_login_secure\website_security_error_403_page;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Drupal\Core\Ajax\AjaxResponse;
/**
 * Provides route responses for the website_security module.
 */
class security_login_secureController {

  public function website_security_feedback_func(){
    global $base_url;
    $config = \Drupal::config('security_login_secure.settings');
    if (isset($_GET['miniorange_feedback_submit'])){
      $modules_info = \Drupal::service('extension.list.module')->getExtensionInfo('security_login_secure');
      $modules_version = $modules_info['version'];
      $_SESSION['mo_other']="False";
      $reason=$_GET['deactivate_plugin'];
      $q_feedback=$_GET['query_feedback'];
      $message='Reason: '.$reason.'<br>Feedback: '.$q_feedback;
      $url = 'https://login.xecurify.com/moas/api/notify/send';
      $ch = curl_init($url);
      $email =$config->get('website_security_customer_admin_email');
      if(empty($email))
        $email = $_GET['miniorange_feedback_email'];
      $phone = $config->get('website_security_customer_admin_phone');
      $customerKey= $config->get('website_security_customer_id');
      $apikey = $config->get('website_security_customer_api_key');
      if($customerKey==''){
        $customerKey="16555";
        $apikey="fFd2XcvTGDemZvbw1bcUesNJWEqKbbUq";
      }
      $currentTimeInMillis = self::get_ns_timestamp();
      $stringToHash 		= $customerKey .  $currentTimeInMillis . $apikey;
      $hashValue 			= hash("sha512", $stringToHash);
      $customerKeyHeader 	= "Customer-Key: " . $customerKey;
      $timestampHeader 	= "Timestamp: " .  $currentTimeInMillis;
      $authorizationHeader= "Authorization: " . $hashValue;
      $fromEmail 			= $email;
      $subject            = 'Drupal ' . \DRUPAL::VERSION . ' Website Security Free Module Feedback | '.$modules_version;
      $query        = '[Drupal ' . \DRUPAL::VERSION[0] . ' Website Security Free | '.$modules_version.']: ' . $message;
      $content='<div >Hello, <br><br>Company :<a href="'.$_SERVER['SERVER_NAME'].'" target="_blank" >'.$_SERVER['SERVER_NAME'].'</a><br><br>Phone Number :'.$phone.'<br><br>Email :<a href="mailto:'.$fromEmail.'" target="_blank">'.$fromEmail.'</a><br><br>Query :'.$query.'</div>';
      $fields = array(
        'customerKey'	=> $customerKey,
        'sendEmail' 	=> true,
        'email' 		=> array(
          'customerKey' 	=> $customerKey,
          'fromEmail' 	=> $fromEmail,
          'fromName' 		=> 'miniOrange',
          'toEmail' 		=> 'drupalsupport@xecurify.com',
          'toName' 		=> 'drupalsupport@xecurify.com',
          'subject' 		=> $subject,
          'content' 		=> $content
        ),
      );

      $field_string = json_encode($fields);
      curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
      curl_setopt( $ch, CURLOPT_ENCODING, "" );
      curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
      curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
      curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );    # required for https urls
      curl_setopt( $ch, CURLOPT_MAXREDIRS, 10 );
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $customerKeyHeader,
        $timestampHeader, $authorizationHeader));
      curl_setopt( $ch, CURLOPT_POST, true);
      curl_setopt( $ch, CURLOPT_POSTFIELDS, $field_string);
      $content = curl_exec($ch);
      if(curl_errno($ch)){
        return json_encode(array("status"=>'ERROR','statusMessage'=>curl_error($ch)));
      }
      curl_close($ch);
    }
    \Drupal::configFactory()->getEditable('security_login_secure.settings')->clear('miniorange_web_security_uninstall_status')->save();
    \Drupal::service('module_installer')->uninstall(['security_login_secure']);
    $uninstall_redirect = $base_url.'/admin/modules';
    \Drupal::messenger()->addMessage('The module has been successfully uninstalled.');
    return new RedirectResponse($uninstall_redirect);
  }


  /**
     * This function is used to get the timestamp value
     */
    public function get_ns_timestamp()
    {
        $url = 'https://login.xecurify.com/moas/rest/mobile/get-timestamp';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_ENCODING, "");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // required for https urls
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_POST, true);
        $content = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error in sending curl Request';
            exit ();
        }
        curl_close($ch);
        if (empty($content)) {
            $currentTimeInMillis = round(microtime(true) * 1000);
            $currentTimeInMillis = number_format($currentTimeInMillis, 0, '', '');
        }
        return empty($content) ? $currentTimeInMillis : $content;
    }

  public function website_security_error(){
	    website_security_error_403_page::error_page();
	    return new Response();
  }

}
