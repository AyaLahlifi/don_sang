(function ($, Drupal, debounce) {
  Drupal.behaviors.awsBedrockChatForm = {
    attach: function (context) {
      // Trigger a click on the submit button when the Enter key is pressed in the input field
      $(once('awsBedrockChatForm', '.aws-bedrock-chat-user-input', context)).on('keypress', function (e) {
        if (e.which === 13) {
          e.preventDefault();
          $('form#aws-bedrock-chat-form input.aws-bedrock-chat-submit').click();
        }
      });

      $(once('chatTextarea', '.aws-bedrock-chat-user-input', context)).each(function (key, textarea) {
        // Update the height of the textarea.
        function updateTextareaHeight() {
          // Reset the size of the textarea, so that the DOM updates.
          textarea.style.height = "auto";
          // Adjust the size to match the scrollheight, with some padding.
          textarea.style.height = textarea.scrollHeight + "px";
        }
        // On initialization, update the height on load.
        updateTextareaHeight();
        // When the user enters text, update the size of the textareas.
        textarea.oninput = debounce(updateTextareaHeight, 200);
      });
    }
  };
  Drupal.behaviors.chatFormSubmission = {
    attach: function (context, settings) {
      // Submit the chat form and get the response message
      var scrollToBottom = function() {
        var messagesContainer = $('.aws-bedrock-chat-messages');
        // Animate scrolling to the bottom of the container over 500 milliseconds
        messagesContainer.animate({
          scrollTop: messagesContainer.prop('scrollHeight')
        }, 500);
      };
      var loadingIconPath = drupalSettings.awsBedrockChat.loadingIcon;
      var responseIconPath = drupalSettings.awsBedrockChat.responseIcon;
      var userIconPath = drupalSettings.awsBedrockChat.userIcon;

      $(once('chatFormSubmission', '#aws-bedrock-chat-submit, div.aws-bedrock-chat-input button', context)).on('click', function (event) {
        event.preventDefault();

        // Get user message from the input field
        var userMessage = $('.aws-bedrock-chat-user-input', context).val();

        // Check if the message is not empty
        if (userMessage.trim() !== '') {
          // Clear the input field after getting the message
          $('.aws-bedrock-chat-user-input', context).val('');
          $('.aws-bedrock-chat-user-input', context).css('height', 'auto');

          // Immediately display the user's message in the chat window
          var userMessageHtml = '<div class="aws-bedrock-chat-message aws-bedrock-chat-user-message">';
          if (userIconPath) {
            userMessageHtml += '<img class="aws-bedrock-chat-user-icon" src="' + userIconPath + '" alt="User Icon">';
          }
          userMessageHtml += '<p class="aws-bedrock-chat-message-content aws-bedrock-chat-user"><span class="aws-bedrock-chat-user-text">' + userMessage + '</span></p></div>';

          $('div.aws-bedrock-chat-messages', context).append(userMessageHtml);

          var responseMessageHtml = '<div class="aws-bedrock-chat-message aws-bedrock-chat-response-message">';
          if (responseIconPath) {
            responseMessageHtml += '<img class="aws-bedrock-chat-response-message-icon" src="' + responseIconPath + '" alt="Response Message Icon">';
          }
          responseMessageHtml += '</div>';
          scrollToBottom();

          // Append the response message to the chat window
          $('div.aws-bedrock-chat-messages', context).append(responseMessageHtml)
          $('.aws-bedrock-chat-messages .aws-bedrock-chat-message').last().append('<img src="' + loadingIconPath + '" class="aws-bedrock-chat-ajax-loading" />');

          // AJAX call for the API response
          var responseMessageUrl = '/aws-bedrock-chat/get-response';
          $.ajax({
            url: responseMessageUrl,
            type: 'POST',
            dataType: 'json',
            data: { message: userMessage },
            success: function (response) {
              if (response.responseMessageHtml) {
                $('.aws-bedrock-chat-ajax-loading').remove();
                $(response.responseMessageHtml).hide().appendTo('.aws-bedrock-chat-messages .aws-bedrock-chat-message:last-child').fadeIn('slow');
                scrollToBottom();
              }
            },
            error: function (xhr, status, error) {
              console.error('Response message error:', error);
            }
          });
        }
      });
    }
  };
  Drupal.behaviors.awsBedrockChatIconEffects = {
    attach: function (context, settings) {
      // Add click effect to the chat icon
      $(once('awsBedrockChatIconEffects', '.aws-bedrock-chat-icon img, .aws-bedrock-chat-icon svg', context)).on('mouseenter', function () {
        $(this).on('mousedown', function () {
          $(this).addClass('clicked');
        }).on('mouseup mouseleave', function () {
          $(this).removeClass('clicked');
        });
      });
    }
  };
  Drupal.behaviors.chatEscape = {
    attach: function (context, settings) {
      // Hide the chat container when the Escape key is pressed
      $(once('chatEscape', 'body', context)).on('keydown', function(e) {
        if ($('div.aws-bedrock-chat-main').is(':visible')) {
          if (e.key === "Escape" || e.keyCode === 27) {
            $('.aws-bedrock-chat-main').hide();
          }
        }
      });
    }
  };
  Drupal.behaviors.awsBedrockChatToggle = {
    attach: function (context, settings) {
      // Toggle the chat window to open or close when the chat icon is clicked
      var openIconPath = drupalSettings.awsBedrockChat.toggleIcon;
      var closeIconPath = drupalSettings.awsBedrockChat.closeIcon;

      $(once('awsBedrockChatToggle', '.aws-bedrock-chat-icon img, .aws-bedrock-chat-icon svg', context)).on('click', function () {
        if ($('div.aws-bedrock-chat-main').is(':hidden')) {
          $('div.aws-bedrock-chat-main').show();
          if (closeIconPath) {
            $(this).attr('src', closeIconPath).addClass('rotate-icon').addClass('close-button');
            setTimeout(() => $(this).removeClass('rotate-icon'), 500);
          }
        } else {
          $('div.aws-bedrock-chat-main').hide();
          if (closeIconPath) {
            $(this).attr('src', openIconPath).removeClass('close-button');
          }
        }
      });
    }
  };
})(jQuery, Drupal, Drupal.debounce);
