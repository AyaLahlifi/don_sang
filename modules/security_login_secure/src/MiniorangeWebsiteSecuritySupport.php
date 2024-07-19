<?php

namespace Drupal\security_login_secure;

/**
 * @file
 * This class represents support information for customer.
 */
/**
 * @file
 * Contains miniOrange Support class.
 */
class MiniorangeWebsiteSecuritySupport {
  public $email;
  public $phone;
  public $query;

  public function __construct($email, $phone, $query) {
    $this->email = $email;
    $this->phone = $phone;
    $this->query = $query;

  }

  /**
	 * Send support query.
	 */
	public function sendSupportQuery() {
  
      $this->query = '[Drupal 8 Website Security Module(Free)] ' . $this->query;
      $fields = array (
        'company' => $_SERVER['SERVER_NAME'],
        'email' => $this->email,
        'ccEmail' => 'drupalsupport@xecurify.com',
        'phone' => $this->phone,
        'query' => $this->query,
      );
      $field_string = json_encode ($fields);
      $url = 'https://login.xecurify.com/moas/rest/customer/contact-us';

      $ch = curl_init ( $url );
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
      curl_setopt($ch, CURLOPT_ENCODING, "");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
      curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array (
        'Content-Type: application/json',
        'charset: UTF-8',
        'Authorization: Basic'
      ));
      curl_setopt($ch, CURLOPT_POST, TRUE);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $field_string);
      $content = curl_exec($ch);

	  if (curl_errno($ch)) {
          $error = 'method => sendSupportQuery, file => MiniorangeWebsiteSecuritySupport.php, error =>'.curl_error($ch);
          \Drupal::logger('security_login_secure')->error($error);
        return FALSE;
      }
      curl_close ($ch);
      return TRUE;
  }

}