<?php

namespace Drupal\comm100\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Provides a controller for configuring the comm100 module.
 */
class Comm100Controller extends ControllerBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['comm100.settings'];
  }

  /**
   * Provides controller for Comm100 admin configuration.
   *
   * @return array
   *   Drupal page render array.
   */
  public function adminForm() {
    $settings = \Drupal::config('comm100.settings');

    $livechat_props['site_id'] = $settings->get('site_id');
    $livechat_props['plan_id'] = $settings->get('plan_id');
    $livechat_props['plan_type'] = $settings->get('plan_type');
    $livechat_props['email'] = $settings->get('email');
    $livechat_props['plugin_version'] = $settings->get('plugin_version');
    $livechat_props['cpanel_domain'] = $settings->get('cpanel_domain');
    $livechat_props['main_chatserver_domain'] = $settings->get('main_chatserver_domain');
    $livechat_props['standby_chatserver_domain'] = $settings->get('standby_chatserver_domain');

    $host = \Drupal::request()->getSchemeAndHttpHost();

    $render = [
      '#theme' => 'comm100_settings',
    ];

    $render['#attached'] = [
      'library' => [
        'comm100/comm100_css',
        'comm100/comm100_admin',
      ],
    ];

    $url_savelink = Url::fromUri('internal:/admin/config/services/comm100/savelink');
    $url_saveunlink = Url::fromUri('internal:/admin/config/services/comm100/saveunlink');

    $render['#attached']['drupalSettings']['comm100']['comm100_admin']['livechat_props'] = $livechat_props;
    $render['#attached']['drupalSettings']['comm100']['comm100_admin']['save_link_url'] = $host . $url_savelink->toString();
    $render['#attached']['drupalSettings']['comm100']['comm100_admin']['save_unlink_url'] = $host . $url_saveunlink->toString();

    return $render;
  }

  /**
   * Provides Ajax call back for linking comm100 config.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The current request info.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   Ajax Response.
   */
  public function saveLink(Request $request) {

    $settings = \Drupal::configFactory()->getEditable('comm100.settings');

    $settings->set('site_id', filter_var($request->request->get('site_id'), FILTER_SANITIZE_NUMBER_INT))->save();
    $settings->set('plan_id', $request->request->get('plan_id'))->save();
    $settings->set('plan_type', filter_var($request->request->get('plan_type'), FILTER_SANITIZE_NUMBER_INT))->save();
    $settings->set('email', filter_var($request->request->get('email'), FILTER_SANITIZE_STRING))->save();
    $settings->set('plugin_version', filter_var($request->request->get('plugin_version'), FILTER_SANITIZE_STRING))->save();
    $settings->set('cpanel_domain', filter_var($request->request->get('cpanel_domain'), FILTER_SANITIZE_STRING))->save();
    $settings->set('main_chatserver_domain', filter_var($request->request->get('main_chatserver_domain'), FILTER_SANITIZE_STRING))->save();
    $settings->set('standby_chatserver_domain', filter_var($request->request->get('standby_chatserver_domain'), FILTER_SANITIZE_STRING))->save();

    drupal_flush_all_caches();
    return new JsonResponse(['save_link' => 'success']);
  }

  /**
   * Provides Ajax call back for unlinking comm100 config.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The current request info.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   Ajax Response.
   */
  public function saveUnLink(Request $request) {
    // \Drupal::logger('comm100')->notice('SaveUnLink');
    $settings = \Drupal::configFactory()->getEditable('comm100.settings');
    $settings->set('site_id', '0')->save();
    $settings->set('plan_id', '0')->save();
    $settings->set('plan_type', '0')->save();
    $settings->set('email', '')->save();
    $settings->set('plugin_version', filter_var($request->request->get('plugin_version'), FILTER_SANITIZE_STRING))->save();
    $settings->set('cpanel_domain', '')->save();
    $settings->set('main_chatserver_domain', '')->save();
    $settings->set('standby_chatserver_domain', '')->save();

    drupal_flush_all_caches();
    return new JsonResponse(['save_link' => 'success']);
  }

}
