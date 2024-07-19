(function (Drupal, drupalSettings) {
  Drupal.behaviors.twilioFlex = {
    attach: function attach(context) {
      const settings = drupalSettings.twilioFlex;
      // See https://assets.flex.twilio.com/docs/releases/flex-webchat-ui/2.5.1/MainHeader.html.
      const appConfig = {
        accountSid: settings.twilio_flex_account_sid,
        flexFlowSid: settings.twilio_flex_flow_sid,
        componentProps: {
          MainHeader: {
            titleText: settings.twilio_flex_main_header_title
          },
          MessagingCanvas: {
            showWelcomeMessage: true,
            welcomeMessageText: () => settings.twilio_flex_msg_canvas_welcome
          }
        }
      };
      Twilio.FlexWebChat.renderWebChat(appConfig);
      Twilio.FlexWebChat.MessagingCanvas.defaultProps.predefinedMessage.authorName = settings.twilio_flex_msg_canvas_predefined_author;
      Twilio.FlexWebChat.MessagingCanvas.defaultProps.predefinedMessage.body = settings.twilio_flex_msg_canvas_predefined_body;

    }
  };
})(Drupal, drupalSettings);
