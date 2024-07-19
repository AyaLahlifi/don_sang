(function ($, Drupal) {
  Drupal.behaviors.awsBedrockChatDynamicStyles = {
    attach: function (context, settings) {
      // Get the custom CSS from the settings object and apply it to the chat window.
      var customCss = drupalSettings.awsBedrockChat.customCss;

      if (customCss) {
        var styleId = 'aws-bedrock-chat-custom-style';
        // Check if the style tag already exists in the document head.
        if ($('#' + styleId).length === 0) {
          // Create a new style tag, set its ID, type and content, and append it to the document head.
          $('<style>', {
            id: styleId,
            type: 'text/css',
            html: customCss
          }).appendTo('head');
        }
      }
    }
  };
})(jQuery, Drupal, drupalSettings);
