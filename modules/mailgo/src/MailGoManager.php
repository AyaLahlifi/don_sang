<?php

namespace Drupal\mailgo;

use Drupal\Core\Config\Config;
use Drupal\Core\Config\ConfigFactoryInterface;
use Psr\Container\ContainerInterface;

/**
 * MailGo Manager helper class.
 *
 * @package Drupal\mailgo
 */
class MailGoManager {

  const EMAIL_REGEX = "/(((?<!\"|')(?<!mailto:)[a-z0-9_\-\.]+)@(([a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?)(?!\"|'|<\/a)))/i";

  const PHONE_REGEX = "/((?<!\"|')(?<!tel:|callto:)\+\d{1,3}[\d\s-]{7,}(?!\"|'|<\/a))/";

  const MAILTO_LINK_REGEX = "/<a(?:.*)href=(?:\"|')mailto:(.+)(?:\"|')(?:.*)>(.+)<\/a>/Ui";

  /**
   * Module config.
   *
   * @var \Drupal\Core\Config\Config
   *   config array
   */
  protected $config;

  /**
   * Constructs a new GlobalConfigForm object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   Config factory.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->config = $config_factory->get('mailgo.globalconfig');
  }

  /**
   * Creates a class instance.
   *
   * @param \Psr\Container\ContainerInterface $container
   *   Service container.
   *
   * @return static
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory')
    );
  }

  /**
   * Get module config.
   *
   * @return \Drupal\Core\Config\Config
   *   Config array.
   */
  public function getConfig() {
    return $this->config;
  }

  /**
   * Set module config.
   *
   * @param \Drupal\Core\Config\Config $config
   *   Config to set.
   */
  public function setConfig(Config $config) {
    $this->config = $config;
  }

  /**
   * Replace all emails in text with MailGo links.
   *
   * @param string $text
   *   Text to be parsed.
   * @param bool $noSpam
   *   Flag if email should be hidden from DOM.
   *
   * @return string
   *   Processed text
   */
  public function processEmailsInText(string $text, $noSpam = FALSE) {
    $replace = $noSpam
      ? "<a href=\"#mailgo\" data-address=\"$2\" data-domain=\"$3\">$1</a>"
      : "<a href=\"mailto:$1\">$1</a>";
    return preg_replace(self::EMAIL_REGEX, $replace, $text);
  }

  /**
   * Replace all tel numbers in text with MailGo links.
   *
   * @param string $text
   *   Text to be parsed.
   *
   * @return string
   *   Processed text
   */
  public function processPhonesInText(string $text) {
    $replace = "<a href=\"tel:$1\">$1</a>";
    return preg_replace(self::PHONE_REGEX, $replace, $text);
  }

  /**
   * Make a link with mailto:<email> (for email field only).
   *
   * @param string $email
   *   Email address.
   *
   * @return string
   *   Link tag
   */
  public function generateRegularMailToLink(string $email) {
    return sprintf("<a href='mailto:%s' class='no-mailgo'>%s</a>", $email, $email);
  }

  /**
   * This method removes the effect from "_filter_url_parse_email_links" filter.
   *
   * @param string $text
   *   Text where mailto: links will be striped.
   *
   * @return string
   *   Processed text
   */
  public function stripMailto(string $text) {
    return preg_replace(self::MAILTO_LINK_REGEX, "$1", $text);
  }

  /**
   * Generates a mailgo library config in a JS-string.
   *
   * @return string
   *   Config JS string
   */
  public function generateConfigJs() {
    $_isDark       = $this->config->get('mailgo.theme') === 'dark' ? 'true' : 'false';
    $_loadCss      = $this->config->get('mailgo.theme') !== 'no_theme' ? 'true' : 'false';
    $_showFooter   = !empty($this->config->get('mailgo.show_footer')) ? 'true' : 'false';
    $_showGmail    = !empty($this->config->get('mailgo.actions.gmail')) ? 'true' : 'false';
    $_showOutlook  = !empty($this->config->get('mailgo.actions.outlook')) ? 'true' : 'false';
    $_showYahoo    = !empty($this->config->get('mailgo.actions.yahoo')) ? 'true' : 'false';
    $_showWhatsapp = !empty($this->config->get('mailgo.actions.whatsapp')) ? 'true' : 'false';
    $_showSkype    = !empty($this->config->get('mailgo.actions.skype')) ? 'true' : 'false';
    return "window.mailgoConfig = {
      dark: {$_isDark},
      showFooter: {$_showFooter},
      loadCSS: {$_loadCss},
      actions: {
        \"gmail\": {$_showGmail},
        \"outlook\": {$_showOutlook},
        \"yahoo\": {$_showYahoo},
        \"whatsapp\": {$_showWhatsapp},
        \"skype\": {$_showSkype},
      },
    }";

  }

}
