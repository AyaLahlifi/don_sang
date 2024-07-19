<?php

/**
 * @file
 * Contains \Drupal\security_login_secure\Form\WebsiteSecurityReports.
 */

namespace Drupal\security_login_secure\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBase;
use Drupal\security_login_secure\Utilities;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\user\Entity\User;

class WebsiteSecurityReports extends FormBase {

    public function getFormId() {
        return 'website_security_reports';
    }

    public function buildForm(array $form, FormStateInterface $form_state){

    	global $base_url;

    	$config = \Drupal::config('security_login_secure.settings');
    	$db_var = \Drupal::configFactory()->getEditable('security_login_secure.settings');

    	$dat = $this->website_security_return_search_values();
    	$disable_download_and_clear = (count($dat) == 0) ? TRUE : FALSE;

    	if (isset($_GET['delete']))
    		$this->website_security_unblock_ip($_GET['delete']);
    	

    	$form['website_security_reports_tab'] = array(
            '#attached' => array('library' => 'security_login_secure/security_login_secure.admin',),
            '#markup' => '<div class="ns_table_layout_1"><div class="ns_table_layout ns_container">',
        );

        $form['website_security_clear_report_header'] = array(
            '#markup' => '<h2> User Transactions Report </h2>',
            '#prefix' => '<div class="ns_row"><div class="ns_name">',
            '#suffix' => '</div>',
        );

        $form['website_security_download_reports'] = array(
            '#type' => 'submit',
            '#value' => t('Download Reports'),
            '#submit' => array('::website_security_download_reports'),
            '#disabled' => $disable_download_and_clear,
            '#prefix' => '<div class="ns_download">',
            '#suffix' => '</div>',
        );

        $form['website_security_clear_reports'] = array(
            '#type' => 'submit',
            '#value' => t('Clear Reports'),
            '#submit' => array('::website_security_clear_reports'),
            '#disabled' => $disable_download_and_clear,
            '#prefix' => '<div class="ns_clear">',
            '#suffix' => '</div></div><hr>',
        );

	    $form['username'] = [
	       '#markup' => '<b>Username (Optional) :</b>',
	       '#prefix' => '<div class="ns_search_row"><div class="ns_search_name">',
	       '#suffix' => '</div>',
	    ];

	    $form['ip'] = [
	       '#markup' => '<b>IP Address (Optional) :</b>',
	       '#prefix' => '<div class="ns_search_ip">',
	       '#suffix' => '</div>',
	    ];

	    $form['status'] = [
	       '#markup' => '<b>Status :</b>',
	       '#prefix' => '<div class="ns_search_status">',
	       '#suffix' => '</div></div>',
	    ];

	    $form['username_value'] = [
	       '#type' => 'textfield',
	       '#default_value' => $config->get('website_security_username_value'),
	       '#prefix' => '<div class="ns_search_row"><div class="ns_search_name">',
	       '#suffix' => '</div>',
	    ];

	    $form['ip_value'] = [
	       '#type' => 'textfield',
	       '#default_value' => $config->get('website_security_ip_value'),
	       '#prefix' => '<div class="ns_search_ip">',
	       '#suffix' => '</div>',
	    ];

	    $options = [
	    	'All' => 'All',
	    	'Success' => 'Success',
	    	'IP Login Failed' => 'IP Login Failed',
	    	'User Login Failed' => 'User Login Failed',
	    	'IP Whitelisted' => 'IP Whitelisted',
	    	'IP Blacklisted' => 'IP Blacklisted',
	    	'IP Blocked' => 'IP Blocked',
	    	'User Blocked' => 'User Blocked',
	    ];

	    $form['status_value'] = [
	       '#type' => 'select',
	       '#options' => $options,
	       '#default_value' => $config->get('website_security_status_value'),
	       '#attributes' => array('style' => 'width:95% !important',),
	       '#prefix' => '<div class="ns_search_status">',
	       '#suffix' => '</div>',
	    ];

	    $form['search_info'] = [
	    	'#markup' => '<div class="ns_tooltip"><img src="'.$base_url . '/' . \Drupal::service('extension.list.module')->getPath('security_login_secure') . '/includes/images/icon3.png" alt="info icon" height="20px" width="15px"></div><div class="ns_tooltiptext">Success => All the successful login entries <br> IP Login Failed => Failed login entries of IPs <br> User Login Failed => Failed login entries of site users <br> IP Whitelisted => Manually added IPs for whitelisting <br> IP Blacklisted => Manually added IP for blocking <br> IP Blocked => IP blocked due to invalid login attempts <br> User Blocked => Site user blocked due to invalid login attempts</div>',
	    	'#prefix' => '<div class="ns_search_info">',
	        '#suffix' => '</div></div>',
	    ];

	    $form['search'] = [
	       '#type' => 'submit',
	       '#submit' => array('::website_security_advanced_search'),
	       '#value' => t('Search'),
	    ];

	    $url = $base_url . '/admin/config/people/security_login_secure/WebsiteSecurityReports';
	    $var = $config->get('website_security_entry_option','');
	    
	    $entry_option = 10;
	    if (isset($var)) 
	    	$entry_option = explode('=', $var)[1];
	    
	    $next = 1;
	    $prev = 0;

	    if (isset($_GET['entry_option'])){
	    	$entry_option = $_GET['entry_option'];
	    	$default_value = $url . '/?entry_option=' . $entry_option;
	    	$db_var->set('website_security_entry_option', $default_value)
	    	  ->save();
	    }

	    $db_order = $config->get('website_security_entry_order','');
	    $order = 'DESC';
	    if (isset($db_order)) 
	    	$order = explode('=', $db_order)[1];

	    if (isset($_GET['order'])){ 
	    	$order = $_GET['order'];
	    	$order_key = $url . '/?order=' . $order;
	    	$db_var->set('website_security_entry_order', $order_key)
	    	  ->save();
	    }

	    

	    if (isset($_GET['next'])) {
	    	$next = $_GET['next'];
	    	$prev = ($next == 0) ? $next : $next-1;
	    	$next+=1;
	    }

	    $entries_options = [
	    	$url . '/?entry_option=10' => '10',
	    	$url . '/?entry_option=25' => '25',
	    	$url . '/?entry_option=50' => '50',
	    	$url . '/?entry_option=100' => '100',
	    ];

	    $order_options = [
	    	$url . '/?order=DESC' => 'DESC',
	    	$url . '/?order=ASC' => 'ASC',
	    ];

	    $form['website_security_show_entries'] = array(
            '#markup' => 'Show Entries:',
            '#prefix' => '<div class="ns_row"><div class="ns_entries_name">',
            '#suffix' => '</div>',
        );

        $form['website_security_show_entries_value'] = array(
            '#type' => 'select',
            '#options' => $entries_options,
            '#default_value' => $config->get('website_security_entry_option'),
            '#attributes' => array('style' => 'width:80% !important', 'onchange' => 'javascript:location.href = this.value;'),
            '#prefix' => '<div class="ns_entries_value">',
            '#suffix' => '</div>',
        );

        $form['website_security_show_entries_order'] = array(
            '#type' => 'select',
            '#options' => $order_options,
            '#default_value' => $config->get('website_security_entry_order'),
            '#attributes' => array('style' => 'width:80% !important', 'onchange' => 'javascript:location.href = this.value;'),
            '#prefix' => '<div class="ns_entries_order">',
            '#suffix' => '</div></div>',
        );
        
        $data = $this->website_security_return_search_values($order);
        $total_rows = count($data);

        $starting_value = ($next-1) * $entry_option;
        
        $ending_value = $entry_option + $starting_value;
        
        if ($ending_value > $total_rows) {
        	$ending_value = $total_rows;
        	$next = 0;
        }

        $form['miniorange_ns_report'] = array(

          '#markup' => " 
                <table class='ns_customer_reports'>                                    
		            <tr>
		                <th>IP Address </th>
		                <th>Username </th>
		                <th>Status </th>
		                <th>Date & Time </th>
		                <th>Action</th>
                    </tr>                    
		            "
        );

        $db_rows = '';
        if ($total_rows > 0){
        
          for ($x = $starting_value; $x < $ending_value ; $x++) {
              $status_row = "<td class='failure_report'>" . $data[$x]->status . "</td>";
              if ($data[$x]->status == 'IP Whitelisted' || $data[$x]->status == 'Success' || $data[$x]->status == 'Unblocked User' || $data[$x]->status == 'Unblocked IP') {
                  $status_row = "<td class='success_report'>" . $data[$x]->status . "</td>";
              }
          	  $timestamp = $data[$x]->timestamp;
        	  $date = date('d-m-Y', $timestamp);
			  $time = date('H:i:s', $timestamp);
              $db_rows .= "<tr>";
              $db_rows .= "<td>" . $data[$x]->ip_address . "</td>";
              $db_rows .= "<td>" . $data[$x]->uname . "</td>";
              $db_rows .= $status_row;
              $db_rows .= "<td>" . $date . ' | ' . $time . "</td>";

              if ($data[$x]->status == 'IP Blocked' && @$this->is_ip_blocked($data[$x]->ip_address))
              	$db_rows .= "<td>" . '<a class="ns_btn2 btn btn-primary" href="' . $url . '/?delete='. $data[$x]->ip_address .'">Unblock</a>' . "</td>";
              else
              	$db_rows .= "<td>" . '--' . "</td>";

              $db_rows .= "</tr>";

			}
              $form['miniorange_ns_reports_rows'] = array(
	              '#markup' => $db_rows,
	          );
          
        }else{
        	$form['miniorange_ns_reports_rows'] = array(
              '#markup' => '<tr>
		                <td>--</td>
		                <td>--</td>
		                <td>--</td>
		                <td>--</td>
		                <td>--</td>
                    </tr>'
            );
        }

	    $form['miniorange_ns_report_table_end'] = array(
	        '#markup' =>'</table>',
	    );

	    $starting_value = ($total_rows == 0) ? -1 : $starting_value;
	    $last = ($total_rows % $entry_option == 0) ? floor($total_rows/$entry_option)-1 : floor($total_rows/$entry_option);

	    $form['showing_entries'] = [
	    	'#markup' => 'Showing ' . ($starting_value+1) . '-' . $ending_value . ' of ' . $total_rows .' entries',
	    	'#prefix' => '<div class="ns_search_row"><div class="ns_entries">',
	    	'#suffix' => '</div>',
	    ];

	    $form['previous_entries'] = [
	    	'#markup' => '<a id="mo_ns_first" class="ns_btn2 btn btn-primary" href="' . $url . '/?entry_option='. $entry_option .'&next=0" style="padding:6px 12px;">' . 'First</a>&nbsp;&nbsp;<a id="mo_ns_previous" class="ns_btn2 btn btn-primary" href="' . $url . '/?entry_option='. $entry_option .'&next=' . $prev . '" style="padding:6px 12px;">' . 'Previous</a>',
	    	'#prefix' => '<div class="ns_entries_previous">',
	    	'#suffix' => '</div>',
	    ];

	    $form['next_entries'] = [
	    	'#markup' => '<a id="mo_ns_next" class="ns_btn2 btn btn-primary" href="' . $url . '/?entry_option='. $entry_option .'&next=' . $next . '" style="padding:6px 12px;">' . 'Next</a>&nbsp;&nbsp;<a id="mo_ns_last" class="ns_btn2 btn btn-primary" href="' . $url . '/?entry_option='. $entry_option .'&next=' . $last . '" style="padding:6px 12px;">' . '  Last</a>',
	    	'#prefix' => '<div class="ns_entries_next">',
	    	'#suffix' => '</div></div>',
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
    	
    }

    function is_ip_blocked($ip_address){
    	$db = \Drupal::database();
		$ip_exists = $db->select('miniorange_website_security_ip_track', 'ip_address')
		  ->fields('ip_address')
		  ->condition('ip_address', $ip_address)
	      ->countQuery()
	      ->execute()
	      ->fetchField();

	    if ($ip_exists == 0)
	    	return FALSE;

	    return TRUE;
    }

    function website_security_unblock_ip($ip_address){
    	global $base_url;

    	$db = \Drupal::database();
    	$db->delete('miniorange_website_security_ip_track')
		  ->condition('ip_address', $ip_address, '=')
		  ->execute();

		$account = User::load(\Drupal::currentUser()->id());

		website_security_add_to_reports($ip_address, $account->getAccountName(), 'Unblocked IP');
		$url = $base_url . '/admin/config/people/security_login_secure/WebsiteSecurityReports';
		$this->messenger()->addStatus(t('The IP address '.$ip_address.' has been successfully unblocked.'));
		$response = new RedirectResponse($url);
        $response->send();
    }

    function website_security_download_reports(&$form, $form_state){

      $data = $this->website_security_return_search_values();

      $reports = "S.NO,IP ADDRESS,USERNAME,REASON,DATE & TIME\n";
      $i = 1; 

      foreach ($data as $value) {
        $timestamp = $value->timestamp;
        $date = date('d-m-Y H:i:s', $timestamp);
        $reports .= $i . ',' . $value->ip_address . ',' . $value->uname . ',' . $value->status . ',' . $date . "\n";
        $i++;
      }

      header('Content-Type: application/csv');
      header('Content-Disposition: attachment; filename="reports.csv"');
    
      print_r($reports);
      exit();

    }

    function website_security_clear_reports(&$form, $form_state){
    	global $base_url;
    	$db = \Drupal::database();
		$db->delete('miniorange_website_security_reports')
		  ->execute();

		$url = $base_url . '/admin/config/people/security_login_secure/WebsiteSecurityReports';
		$response = new RedirectResponse($url);
        $response->send();
    }

    function website_security_advanced_search(&$form, $form_state){
    	global $base_url;
    	$config = $this->configFactory()->getEditable('security_login_secure.settings');
    	$username_value = $form_state->getValue('username_value');
    	$ip_value = $form_state->getValue('ip_value');
    	$status_value = $form_state->getValue('status_value');
    	$url = $base_url . '/admin/config/people/security_login_secure/WebsiteSecurityReports';

    	if (!filter_var($ip_value, FILTER_VALIDATE_IP))
    		$ip_value = '';

    	$config->set('website_security_ip_value', $ip_value)
    			->set('website_security_username_value', $username_value)
    			->set('website_security_status_value', $status_value)
    			->save();

    	$response = new RedirectResponse($url);
        $response->send();
    }

    function website_security_return_search_values($order = 'DESC'){
    	$db_var = \Drupal::config('security_login_secure.settings');
    	$ip_value = $db_var->get('website_security_ip_value');
    	$username_value = $db_var->get('website_security_username_value');
    	$status_value = $db_var->get('website_security_status_value');

    	$db = \Drupal::database();

    	if (isset($ip_value) && !empty($ip_value) && isset($username_value) && !empty($username_value) && filter_var($ip_value, FILTER_VALIDATE_IP)) {
    		if ($status_value != 'All'){
	    		$reports = $db->select('miniorange_website_security_reports', 'ns_ip')
	    						  ->fields('ns_ip')
								  ->condition('ip_address', $ip_value, '=')
								  ->condition('uname', $username_value, '=')
								  ->condition('status', $status_value, '=')
								  ->orderBy('timestamp', $order)
							      ->execute()
							      ->fetchAll();
			}else{
				$reports = $db->select('miniorange_website_security_reports', 'ns_ip')
							  ->fields('ns_ip')
							  ->condition('ip_address', $ip_value, '=')
							  ->condition('uname', $username_value, '=')
							  ->orderBy('timestamp', $order)
						      ->execute()
						      ->fetchAll();
			}

    	}elseif (isset($ip_value) && !empty($ip_value) && filter_var($ip_value, FILTER_VALIDATE_IP)) {
    		if ($status_value != 'All'){
	    		$reports = $db->select('miniorange_website_security_reports', 'ns_ip')
	    						  ->fields('ns_ip')
								  ->condition('ip_address', $ip_value, '=')
								  ->condition('status', $status_value, '=')
								  ->orderBy('timestamp', $order)
							      ->execute()
							      ->fetchAll();
			}else{
				$reports = $db->select('miniorange_website_security_reports', 'ns_ip')
								  ->fields('ns_ip')
								  ->condition('ip_address', $ip_value, '=')
								  ->orderBy('timestamp', $order)
							      ->execute()
							      ->fetchAll();
			}
    	}elseif (isset($username_value) && !empty($username_value)) {
    		if ($status_value != 'All'){
	    		$reports = $db->select('miniorange_website_security_reports', 'ns_ip')
	    						  ->fields('ns_ip')
								  ->condition('uname', $username_value, '=')
								  ->condition('status', $status_value, '=')
								  ->orderBy('timestamp', $order)
							      ->execute()
							      ->fetchAll();
			}else{
				$reports = $db->select('miniorange_website_security_reports', 'ns_ip')
								  ->fields('ns_ip')
								  ->condition('uname', $username_value, '=')
								  ->orderBy('timestamp', $order)
							      ->execute()
							      ->fetchAll();
			}
    	}else{
    		if (isset($status_value) && !empty($status_value) && $status_value != 'All'){
	    		$reports = $db->select('miniorange_website_security_reports', 'ns_ip')
    							  ->fields('ns_ip')
								  ->condition('status', $status_value, '=')
								  ->orderBy('timestamp', $order)
							      ->execute()
							      ->fetchAll();
			}else{
				$reports = $db->select('miniorange_website_security_reports', 'ns_ip')
								  ->fields('ns_ip')
								  ->orderBy('timestamp', $order)
							      ->execute()
							      ->fetchAll();
			}
    	}

    	return $reports;
    }

}