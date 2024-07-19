(function ($, Drupal) {
  Drupal.behaviors.colorPickerSync = {
    attach: function (context, settings) {
      // Sync the color picker and color code input fields
      $(once('colorPickerSync', '.abc-color-code', context)).on('input', function () {
        $(this).parents('.aws-bedrock-chat-color-container').find('.abc-color-picker', context).val($(this).val());
      });

      $(once('colorCodeSync', '.abc-color-picker', context)).on('input', function () {
        $(this).parents('.aws-bedrock-chat-color-container').find('.abc-color-code', context).val($(this).val());
      });
    }
  };
})(jQuery, Drupal);
